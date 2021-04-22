<?php
namespace App\Controllers;
use App\Controller;
use App\Models\User;
use App\Controllers\Errors;
class Users extends Controller{

	/*
		Check if an email is valid
	*/
	public function checkEmail(string $email):bool {
		return !(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL));
	}

	/*
		Check if a pseudo is valid
	*/
	public function checkPseudo(string $pseudo):bool{
		return !(strlen($pseudo)<3 || strlen($pseudo)>20 || !preg_match("/^[a-zA-Z0-9\_]+$/",$pseudo));
	}

	/*
		Check if a password is valid
	*/
	public function checkPassword(string $password){
		return !(strlen($password) < 4 || strlen($password) > 255);
	}

	/*
		Check if a first name is valid
	*/
	public function checkFirstname(string $first_name):bool{
		return !(empty($first_name) || ! preg_match("/^[a-zA-Zéèïëçêâôöòó\-]+$/", $first_name) || strlen($first_name) > 20);
	}

	/*
		Check if a last name is valid
	*/
	public function checkLastname(string $last_name):bool{
		return !(empty($last_name) || !preg_match("/^[a-zA-Zéèïëçêâôöòó\- ]+$/", $last_name) || strlen($last_name) > 50);
	}

	public function index(){

	}

	/*
		Function to handle user registration
	*/
	public function signup(){
		$errors=[];
		$fields=[];
		$error = new Errors();
		$title="Créer un compte";
		$user = new User();
		//Check if the user has filled the fields
		if (!empty($_POST)){

			extract($_POST);
			$fields['pseudo']=$a_pseudo;
			$fields['email']=$a_email;

			if(!$this->checkPseudo($a_pseudo)){
				$errors['pseudo']=$error->showError("Veuiller entrer un pseudo valide (alphanumérique, 3 à 20 caractères)");
			}else{
				if($user->exists($a_pseudo)){
					$errors['pseudo']= $error->showError("Ce pseudo est déja pris");
				}
			}

			if(!$this->checkEmail($a_email)){
				$errors['email']=$error->showError("Veuiller entrer un email valide ");
			}else{
				if($user->exists($a_email)){
					$errors['email']= $error->showError("Cet email est déja utilisé pour un autre compte");
				}
			}

			if (!$this->checkPassword($a_password)) {
				$errors['password']=$error->showError("Veuiller entrer un mot de passe valide ( 4 à 255 caractères)");
			}else{
				if ($a_password_confirm !== $a_password) {
					$errors['password_confirm']=$error->showError("Les mots de passe doivent être identiques");
				}
			}
			
			//Add the user if there is no error
			//Generate a token and send a confirmation email to the user
			if($errors === []){
				$a_password = password_hash($a_password, PASSWORD_BCRYPT);
				$token = $this->str_random(60);
				$id=$user->add($a_pseudo,$a_email,$a_password,$token);
				$message="Votre compte a été créé avec succèes";


                $link = ROOT_URL."users/confirm/".$id."/".$token;
                $content ="Afin de valider votre compte, merci de cliquer sur ce lien :<br> <a href=\"{$link}\">{$link}</a>";

              	$this->sendmail($a_email,"Confirmation de votre compte",$content);
				$this->render('add',compact('title','message','link')) ;
			}else{
				$message = "Champ(s) invalide(s)";
				$this->render('add',compact('title','message','errors','fields'));
			}
		}else{
			$this->render('add',compact('title'));
		}
	}

	/*
		Function to login the user
	*/
	public function login(){
		$flash='';		
		if(isset($_SESSION['flash'])){
			$flash=$_SESSION['flash'];
			unset($_SESSION['flash']);
		}

		$fields=[];
		$title="Connexion";
		$user = new User();
		$success = false;

	
      //Redirect the user to the home page if he is already logged in
	  if(isset($_SESSION['auth'])){       		
        header('Location: '.ROOT_URL);
      	exit();
      }

		//Check if the user has filled the fields
		if (!empty($_POST)){
			extract($_POST);
           $remember_token='';
			//Generate a token if the user want to be remembered
			if(isset($a_remember)){
              $remember_token = $this->str_random(250);
            }
			$auth = $user->login($a_pseudo,$remember_token);

			$fields['pseudo']=$a_pseudo;
			//Check if the user's credentials are invalid
			if(!$auth){
				$message='Email ou mot de passe incorrect';
			}else{
				if(!password_verify($a_password, $auth->a_password)){
					$message='Email ou mot de passe incorrect';
				}
			}

			if($auth){
              if($auth->a_confirmed_at != NULL){
					$success = true;
					$message = "Bienvenu {$auth->a_pseudo}.";
					$id = $auth->a_id;
                  $_SESSION['auth']=$auth;
					if(isset($a_remember)){
						setcookie('a_remember',$id.'-'.$remember_token.sha1($id.'vienspasici2001'),time()+60*60*24*7);
					}
              }else{
                $success=false;
                $message="Votre compte n'a pas été activé.";
              }
			}
			$this->render('login',compact('title','message','success','fields'));


		}
		//Log the user using cookies
		elseif(isset($_COOKIE['a_remember'])){
          $token=explode('-',$_COOKIE['a_remember']);
          $auth=$user->getOne($token[0]);

          if($token[1]===$auth->a_remember_token.sha1($token[0].'vienspasici2001')){
            $success = true;
            $message = "Bienvenu {$auth->a_pseudo}.";
			 $_SESSION['auth']=$auth;
            setcookie('a_remember',$token[0].'-'.$token[1],time()+60*60*24*7);

            $this->render('login', compact('title','success','message'));
          }else{
			$this->render('login',compact('title'));
          }

        }
      else{
			$this->render('login',compact('title','flash'));
		}
	}

  /*
  	Function to log out the user
  */
  public function logout(){
    setcookie('a_remember',NULL);
    unset($_SESSION['auth']);
    $title="Connexion";
 	$this->render('login',compact('title'));

  }

	/*
		Function to confirm email address
	*/
	public function confirm($id, $token){
		$title="Compte activé avec succès";
		$error = new Errors();
			$user = new User();
			if($user->confirm($id,$token)){
				$message="Votre compte a été activé avec succès";
				$this->render('add',compact('title','message'));

			}else{
				$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);
			}
    }

  /*
  	Function to handle settings
  */
  public function settings(string $action){
    if(!isset($_SESSION['auth'])){
		header('Location: '.ROOT_URL.'login');
		$_SESSION['flash']['alert']='Veuiller vous connecter';
		$_SESSION['flash']['type']='error';
		exit();
	}
	$title="Paramètres";
    $user = new User();
    $error=new Errors();
    $errors =[];
    $success=false;
    $id = $_SESSION['auth']->a_id;
    $action = empty($action) ? 'main' : $action;
	$auth = $user->getOne($id);
    
	//Handle profile settings
	if($action==='profile'){
      if(isset($_POST['a_pseudo'])){
		extract($_POST);
       $fields['pseudo']=$a_pseudo;
       $fields['first_name']=$a_first_name;
       $fields['last_name']=$a_last_name;	   


       if(!$this->checkPseudo($a_pseudo)){
         $errors['pseudo']=$error->showError('Veuiller entrer un pseudo valide.');
       }


       if(!$this->checkFirstname($a_first_name)){
         $errors['first_name']=$error->showError('Veuiller entrer un prénom valide.');
       }


       if(!$this->checkLastname($a_last_name)){
         $errors['last_name']=$error->showError('Veuiller entrer un nom valide.');
       }
        if($errors==[]){
          if($user->update($id,$a_pseudo,$a_last_name, $a_first_name)){
            $message="Modification enregistrés avec succcèss.";
			$_SESSION['auth']=$user->getOne($id);
          }else{
            $errors['error']='error';
            $message="Une erreur s'est produite. Veuiller réessayer.";
          }
        }else{
          $message="Champ(s) invalide(s).";
        }
		$auth = $user->getOne($id);
        $this->render('settings',compact('title','action','message','fields','errors'));
      }
      $this->render('settings',compact('title','action','auth'));
    }else{
      switch($action){
		//Handle email settings
		case 'email':
          if(isset($_POST['a_email'])){
            extract($_POST);

            if(!$this->checkEmail($a_email)){
              $message="Champ invalide";
              $errors['email']=$error->showError('Veuiller entrer une adresse email valide');
            }else{
              $token=$this->str_random(60);
              if($user->updateEmail($id,$a_email,$token)){
                $link = ROOT_URL."users/confirm/".$id."/".$token;
                $content ="Afin de valider votre nouvelle adresse email, merci de cliquer sur ce lien :<br> <a href=\"{$link}\">{$link}</a>";

              	$this->sendmail($a_email,"Confirmation de votre nouvelle adresse email",$content);
				$_SESSION['auth']=$user->getOne($id);
                $message = "Email modifié avec succès";
                $success=true;
              }else{
                $message="Une erreur s'est prodyite. Veuiller réessayer.";
              }
            }

            $this->render('settings',compact('title','action','message','a_email','errors','success'));
          }
        break;
		//Handle password settings
        case 'password':
			if(isset($_POST['a_password'])){
				extract($_POST);				
				if(!$this->checkPassword($a_password)){
					$errors['password']=$error->showError("Veuiller entrer un mot de passe valide ( 4 à 255 caractères)");
				}
				if (!$this->checkPassword($a_new_password)) {
					$errors['new_password']=$error->showError("Veuiller entrer un mot de passe valide ( 4 à 255 caractères)");
				}else{
					if ($a_new_password_confirm !== $a_new_password) {
						$errors['new_password_confirm']=$error->showError("Les mots de passe doivent être identiques");
					}
				}
				
				if($errors !=[]){
					$message = "Champ(s) invalide(s)";
				}else{
					if(!password_verify($a_password, $auth->a_password)){						
						$errors['password']=$error->showError('Mot de passe incorrect');
						$message = "Champ(s) invalide(s)";
					}else{
						$a_new_password = password_hash($a_new_password, PASSWORD_BCRYPT);
						if($user->updatePassword($id,$a_new_password)){
							$_SESSION['auth']=$user->getOne($id);
							$message = "Mot de passe modifié avec succèss.";
							$success = true;
						}else{
							$message = "Une erreur s'est produite, veuiller réessayer.";
						}						
					}
					
				}
				$this->render('settings',compact('title','action','errors', 'message','success'));
			}
        break;
      }
    $this->render('settings',compact('title','action'));
    }
  }
}