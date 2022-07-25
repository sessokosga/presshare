<?php

namespace App\Models;

use App\Model;
use \PDO;
use \PDOException;

class User extends Model
{

	//Set the table name and connect to the database
	public function __construct()
	{
		$this->table = "author";
		$this->getConnexion();
	}

	/*
		Add a new user
	*/
	public function add(string $pseudo, string $email, string $password, string $token)
	{
		$sql = "INSERT INTO {$this->dbname}.{$this->table} (a_pseudo, a_email, a_password, a_created_at, a_confirmation_token)
				VALUES (:pseudo, :email, :password, NOW(), :token)";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute([
				'pseudo' => $pseudo,
				'email' => $email,
				'password' => $password,
				'token' => $token

			]);
			return $this->connexion->lastInsertId();
		} catch (PDOException $exception) {
			die('Erreur add user : ' . $exception->getMessage());
		}
	}

	/*
		Check user's credentials
	*/
	public function login(string $email, string $remember_token)
	{
		$sql = "SELECT * FROM {$this->dbname}.{$this->table} WHERE a_email = :email OR a_pseudo = :pseudo";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['email' => $email, 'pseudo' => $email]);
			$auth = $query->fetch();
			if (!empty($remember_token) && $auth->a_id) {
				$q = $this->connexion->prepare("UPDATE {$this->dbname}.{$this->table} SET a_remember_token = :remember WHERE a_id = {$auth->a_id}");
				$q->execute(['remember' => $remember_token]);
			}
			return $auth;
		} catch (PDOException $exception) {
			die('Erreur login user : ' . $exception->getMessage());
		}
	}

	/*
		Get the id of a user knowing his email address
	*/
	public function getID($email)
	{
		$sql = "SELECT a_id AS id FROM {$this->dbname}.{$this->table} WHERE a_email =:email";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['email' => $email]);
			return $query->fetch();
		} catch (PDOException $exception) {
			die('Erreur get ID : ' . $exception->getMessage());
		}
	}

	/*
		Store a token to reset a password
	*/
	public function resetPassword($id, $token)
	{
		$sql = "UPDATE {$this->dbname}.{$this->table} SET a_reset_token=:token, a_reset_at = NOW() WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['token' => $token, 'id' => $id]);
		} catch (PDOException $exception) {
			die('Erreur reset password : ' . $exception->getMessage());
		}
	}

	/*
		Update user's informations
	*/
	public function update(int $id, string $pseudo, string $last_name, string $first_name)
	{
		$sql = "UPDATE {$this->dbname}.{$this->table} SET a_pseudo = :pseudo, a_first_name = :first_name, a_last_name = :last_name
				WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute([
				'pseudo' => $pseudo,
				'last_name' => $last_name,
				'id' => $id,
				'first_name' => $first_name
			]);
			return true;
		} catch (PDOException $exception) {
			die('Erreur update user : ' . $exception->getMessage());
		}
	}

	/*
		Update user's password
	*/
	public function updatePassword($id, $password)
	{
		$sql = "UPDATE {$this->dbname}.{$this->table} SET a_password = :password WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['id' => $id, 'password' => $password]);
			return true;
		} catch (PDOException $exception) {
			die('Erreur update password : ' . $exception->getMessage());
		}
	}




	/*
		Update user's email
	*/
	public function updateEmail(int $id, string $email, string $token)
	{
		$sql = "UPDATE {$this->dbname}.{$this->table} SET a_email = :email, a_confirmation_token = :token WHERE a_id = :id";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['id' => $id, 'email' => $email, 'token' => $token]);
			return true;
		} catch (PDOException $exception) {
			die('Erreur update email : ' . $exception->getMessage());
		}
	}

	/*
		
	*/
	public function getReset($id)
	{
		try {
			$sql = "SELECT * FROM {$this->dbname}.{$this->table} WHERE a_id = :id AND a_reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
			$query = $this->connexion->prepare($sql);
			$query->execute(['id' => $id]);
			return $query->fetch();
		} catch (PDOException $exception) {
			die("Erreur getReset " . $exception->getMessage());
		}
	}

	/*
		Check if an email is already used or an pseudo is already taken
	*/
	public function exists(string $pseudo_or_email)
	{
		$sql = "SELECT a_id FROM {$this->dbname}.{$this->table} WHERE a_pseudo = :pseudo_or_email OR a_email = :pseudo_or_email";
		$query = $this->connexion->prepare($sql);
		try {
			$query->execute(['pseudo_or_email' => $pseudo_or_email]);
			return $query->fetch();
		} catch (PDOException $exception) {
			die('Erreur  : ' . $exception->getMessage());
		}
	}

	/*
   		Function use when the user confirm his email adress
   */
	public function confirm($id, $token)
	{
		$tok = $this->connexion->prepare("SELECT a_confirmation_token AS token FROM {$this->dbname}.{$this->table} WHERE a_id = :id");
		$tok->execute(['id' => $id]);
		$tok = $tok->fetch();
		if ($tok->token != $token) {
			return false;
		} else {
			$sql = "UPDATE {$this->dbname}.{$this->dbname}.{$this->table} SET a_confirmation_token = NULL,  a_confirmed_at = NOW()";
			$query = $this->connexion->prepare($sql);
			try {
				$query->execute();
				return true;
			} catch (PDOException $exception) {
				die('Erreur confirm email : ' . $exception->getMessage());
			}
		}
	}
}
