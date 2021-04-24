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
		$title="Sign up";
		$user = new User();
		//Check if the user has filled the fields
		if (!empty($_POST)){

			extract($_POST);
			$fields['pseudo']=$a_pseudo;
			$fields['email']=$a_email;

			if(!$this->checkPseudo($a_pseudo)){
				$errors['pseudo']=$error->showError("Enter a valid pseudo (letters and/or numbers, 3 to 20 caracters)");
			}else{
				if($user->exists($a_pseudo)){
					$errors['pseudo']= $error->showError("This pseudo is not available");
				}
			}

			if(!$this->checkEmail($a_email)){
				$errors['email']=$error->showError("Enter a valid email address");
			}else{
				if($user->exists($a_email)){
					$errors['email']= $error->showError("This email is used for another account");
				}
			}

			if (!$this->checkPassword($a_password)) {
				$errors['password']=$error->showError("Enter a valid password ( 4 to 255 caracters)");
			}else{
				if ($a_password_confirm !== $a_password) {
					$errors['password_confirm']=$error->showError("Passwords dont match");
				}
			}
			
			//Add the user if there is no error
			//Generate a token and send a confirmation email to the user
			if($errors === []){
				$a_password = password_hash($a_password, PASSWORD_BCRYPT);
				$token = $this->str_random(60);
				$id=$user->add($a_pseudo,$a_email,$a_password,$token);
				$message="Your account is successfully created";


                $link = ROOT_URL."users/confirm/".$id."/".$token;
				$content = "<h3>Welcome {$a_pseudo}.</h3>";
                $content .="In order to activate your account, please follow this link :<br> <a href=\"{$link}\">{$link}</a>";

              	$this->sendmail($a_email,"Account activation",$content);
				$this->render('add',compact('title','message','link')) ;
			}else{
				$message = "Invalid fields";
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
		$title="Log in";
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
				$message='Incorrect credentials';
			}else{
				if(!password_verify($a_password, $auth->a_password)){
					$message='Incorrect credentials';
				}
			}

			if($auth){
              if($auth->a_confirmed_at != NULL){					
					$id = $auth->a_id;
					$_SESSION['auth']=$auth;
					if(isset($a_remember)){
						setcookie('a_remember',$id.'-'.$remember_token.sha1($id.'vienspasici2001'),time()+60*60*24*7);
					}
					header('Location: '.ROOT_URL);
					exit();
              }else{
                $success=false;
                $message="Your account has been successfully activated.";
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
			 $_SESSION['auth']=$auth;
            setcookie('a_remember',$token[0].'-'.$token[1],time()+60*60*24*7);
			header('Location: '.ROOT_URL);
			exit();            
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
 	header('Location: '.ROOT_URL.'login');
    exit();

  }

	/*
		Function to confirm email address
	*/
	public function confirm($id, $token){
		$title="Compte activé avec succès";
		$error = new Errors();
			$user = new User();
			if($user->confirm($id,$token)){
				$message="Your account has been successfully activated.";
				$this->render('add',compact('title','message'));

			}else{
				$error->render('errors',['code'=>404, 'message'=>'Page not found']);
			}
    }

  /*
  	Function to handle settings
  */
  public function settings(string $action){
    if(!isset($_SESSION['auth'])){
		header('Location: '.ROOT_URL.'login');
		$_SESSION['flash']['alert']='You must log in';
		$_SESSION['flash']['type']='error';
		exit();
	}
	$title="Settings";
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
         $errors['pseudo']=$error->showError('Enter a valid pseudo');
       }


       if(!$this->checkFirstname($a_first_name)){
         $errors['first_name']=$error->showError('Enter a valid first name.');
       }


       if(!$this->checkLastname($a_last_name)){
         $errors['last_name']=$error->showError('Enter a valid last name.');
       }
        if($errors==[]){
          if($user->update($id,$a_pseudo,$a_last_name, $a_first_name)){
            $message="Modifications saved successfully.";
			$_SESSION['auth']=$user->getOne($id);
          }else{
            $errors['error']='error';
            $message="An error occured. Please try again.";
          }
        }else{
          $message="Invalid fields";
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
              $message="Invalid fields";
              $errors['email']=$error->showError('Enter a valid email');
            }else{
              $token=$this->str_random(60);
              if($user->updateEmail($id,$a_email,$token)){
                $link = ROOT_URL."users/confirm/".$id."/".$token;
                $content ="In order to confirm your new email address, please follow this link. :<br> <a href=\"{$link}\">{$link}</a>";

              	$this->sendmail($a_email,"Email confirmation",$content);
				$_SESSION['auth']=$user->getOne($id);
                $message = "Email successfully updated";
                $success=true;
              }else{
                $message="An error occured. Please try again.";
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
					$errors['password']=$error->showError("Enter a valid pseudo (letters and/or numbers, 3 to 20 caracters)");
				}
				if (!$this->checkPassword($a_new_password)) {
					$errors['new_password']=$error->showError("Enter a valid pseudo (letters and/or numbers, 3 to 20 caracters)");
				}else{
					if ($a_new_password_confirm !== $a_new_password) {
						$errors['new_password_confirm']=$error->showError("Passwords dont match");
					}
				}
				
				if($errors !=[]){
					$message = "Invalid fields";
				}else{
					if(!password_verify($a_password, $auth->a_password)){						
						$errors['password']=$error->showError('Wrong password');
						$message = "Invalid fields";
					}else{
						$a_new_password = password_hash($a_new_password, PASSWORD_BCRYPT);
						if($user->updatePassword($id,$a_new_password)){
							$_SESSION['auth']=$user->getOne($id);
							$message = "Password changed successfully";
							$success = true;
						}else{
							$message = "An error occured. Please try again";
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
  
  
  /*
	Send an email to restore a password
  */
  public function restore(){
	$title = "Restore password";
	$errors=[];
	$message="Invalid fields";
	$success = false;
	$error = new Errors();
	$user = new User();
	if(isset($_POST['a_email'])){
		extract($_POST);
		$email=$a_email;
		if(!$this->checkEmail($a_email)){
			$errors['email']=$error->showError('Enter a valid email');
		}else{
			$id = $user->getID($email);
			if(!$id){
				$message='There is no account using that email';
			}else{
				$id = $id->id;
				$success = true;				
				$token = $this->str_random(200);
				$message="An account was found";
				$user->resetPassword($id,$token);
				$content ='Follow this link to restore your password : <a href="'.ROOT_URL.'renew/'.$id.'/'.$token.'">'.ROOT_URL.'renew/'.$id.'/'.$token.'</a>';
				$this->sendmail($a_email,'Reset password',$content);
			}
		}				
		$this->render('restore',compact('title','message','success','errors','email'));
	}
	
	$this->render('restore',compact('title'));
  }
  
	/*
		Set new password
	*/
	public function renew($id, $token){
		$title = "Set a new password";
		$errors=[];
		$message="Invalid fields";
		$success = false;
		$error = new Errors();
		$user = new User();
		
		$tok = $user->getReset($id);
		if(!$tok || $token != $tok->a_reset_token){
			$error->render('errors',['code'=>404, 'message'=>'Page not found']);
		}
		
		if(isset($_POST['a_password'])){
			extract($_POST);
			if(!$this->checkPassword($a_password)){
				$errors['password']=$error->showError("Enter a valid password");
			}else{
				if($a_password != $a_password_confirm){
					$errors['password_confirm']=$error->showError("Passwords dont match");
				}
			}
			
			if($errors==[]){
				$a_password = password_hash($a_password, PASSWORD_BCRYPT);
				if($user->updatePassword($id,$a_password)){
					$_SESSION['auth']=$user->getOne($id);					
					header('Location: '.ROOT_URL);
				}else{
					$message = "An error occured. Please try again";
				}
			}
			
			$this->render('renew',compact('title','message','success','errors'));
		}				
		$this->render('renew',compact('title','errors'));
	}
}