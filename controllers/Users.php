<?php
namespace App\Controllers;
use App\Controller;
use App\Models\User;
use App\Controllers\Errors;
class Users extends Controller{	
	public function index(){
		
	}
	
	public function add(){				
		$errors=[];
		$fields=[];
		$error = new Errors();
		$title="Créer un compte";
		$user = new User();
		if (!empty($_POST)){
			
			extract($_POST);			
			$fields['pseudo']=$a_pseudo;
			$fields['email']=$a_email;
			
			if(strlen($a_pseudo)<3 || strlen($a_pseudo)>20 || !preg_match("/^[a-zA-Z0-9\_]+$/",$a_pseudo)){
				$errors['pseudo']=$error->showError("Veuiller entrer un pseudo valide (alphanumérique, 3 à 20 caractères)");				
			}else{				
				if($user->exists($a_pseudo)){
					$errors['pseudo']= $error->showError("Ce pseudo est déja pris");					
				}
			}
			
			if(empty($a_email) || !filter_var($a_email, FILTER_VALIDATE_EMAIL)){
				$errors['email']=$error->showError("Veuiller entrer un email valide ");				
			}else{
				if($user->exists($a_email)){
					$errors['email']= $error->showError("Cet email est déja utilisé pour un autre compte");					
				}
			}
			
			/*if (empty($a_first_name) || ! preg_match("/^[a-zA-Zéèïëçêâôöòó\-]+$/", $a_first_name) || strlen($a_first_name) > 20) {
				$errors['first_name']="Veuiller entrer un prénom valide (alphabétique, au plus 20 caractères";
			}
			
			if (empty($a_last_name) || ! preg_match("/^[a-zA-Zéèïëçêâôöòó\-]+$/", $a_last_name) || strlen($a_last_name) > 50) {
				$errors['last_name']="Veuiller entrer un nom valide (alphabétique, au plus 50 caractères";
			}*/
			
			if (strlen($a_password) < 4 || strlen($a_password) > 255) {
				$errors['password']=$error->showError("Veuiller entrer un mot de passe valide ( 4 à 255 caractères)");
			}else{
				if ($a_password_confirm !== $a_password) {
					$errors['password_confirm']=$error->showError("Les mots de passe doivent être identiques");
				}
			}
			
			if($errors === []){
				$a_password = password_hash($a_password, PASSWORD_BCRYPT);
				$token = $this->str_random(60);
				
				$remember_token = isset($a_remember)? $this->str_random(250) : '';												
				$id = $user->add($a_pseudo, $a_email, $a_password, $token, $remember_token);
				if($a_remember){
					setcookie('a_remember',$id.'-'.$remember_token.sha1($id.'vienspasici2001'),time()+60*60*24*7);
				}
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
}