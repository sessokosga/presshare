<?php
namespace App\Models;
use App\Model;
use \PDO;
use \PDOException;

class User extends Model{
	
	//Set the table name and connect to the database
	public function __construct(){
		$this->table = "author";
		$this->getConnexion();
	}

	/*
		Add a new user
	*/
	public function add(string $pseudo, string $email, string $password, string $token, string $remember_token){
		$sql = "INSERT INTO {$this->table} (a_pseudo, a_email, a_password, a_created_at, a_confirmation_token, a_remember_token)
				VALUES (:pseudo, :email, :password, NOW(), :token,:remember_token)";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute([
								'pseudo'=>$pseudo,
								'email'=>$email,
								'password'=>$password,
								'token'=>$token,
								'remember_token'=>$remember_token
							]);
			return $this->connexion->lastInsertId();
		}catch(PDOException $exception){
			die('Erreur add user : '.$exception->getMessage());
		}
	}
	
	/*
		Update user's informations
	*/
	public function update(int $id,string $pseudo, string $last_name, string $first_name){
		$sql = "UPDATE {$this->table} SET a_pseudo = :pseudo, a_first_name = :first_name, a_last_name = :last_name 
				WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute([
								'pseudo'=>$pseudo,
								'last_name'=>$last_name,
								'id'=>$id,
								'first_name'=>$first_name
							]);
			return true;
		}catch(PDOException $exception){
			die('Erreur update user : '.$exception->getMessage());
		}
	}
	
	/*
		Update user's password
	*/
	public function upadatePassword(int $id, string $password){
		$sql = "UPDATE {$this->table} SET a_password = :password WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute(['id'=>$id,'password'=>$password]);
			return true;			
		}catch(PDOException $exception){
			die('Erreur update password : '.$exception->getMessage());
		}
	}

	/*
		Update user's email
	*/
	public function updatePassword(int $id, string $email){
		$sql = "UPDATE {$this->table} SET a_email = :email WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute(['id'=>$id,'email'=>$email]);
			return true;			
		}catch(PDOException $exception){
			die('Erreur update email : '.$exception->getMessage());
		}
	}

	
	/*
		Check if an email is already used or an pseudo is already taken
	*/
	public function exists(string $pseudo_or_email){
		$sql = "SELECT a_id FROM {$this->table} WHERE a_pseudo = :pseudo_or_email OR a_email = :pseudo_or_email";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute(['pseudo_or_email'=>$pseudo_or_email]);
			return $query->fetch();
		}catch(PDOException $exception){
			die('Erreur  : '.$exception->getMessage());
		}
	}
	
	/*
   		Function use when the user confirm his email adress
   */
  public function confirm ($id, $token){
    $tok= $this->connexion->prepare("SELECT a_confirmation_token AS token FROM {$this->table} WHERE a_id = :id");
    $tok->execute(['id'=>$id]);
    $tok = $tok->fetch();
    if ($tok->token != $token){
      return false;
    }else{
    	$sql = "UPDATE {$this->table} SET a_confirmation_token = NULL,  a_confirmed_at = NOW()";
		$query = $this->connexion->prepare($sql);
		try{
			$query->execute();
			return true;
		}catch(PDOException $exception){
			die('Erreur confirm email : '.$exception->getMessage());
		}
  	}
  }
	
	
	
}