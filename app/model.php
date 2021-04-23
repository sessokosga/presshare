<?php
namespace App;
use \PDO;
use \PDOException;
//The superlass containing the main functions used by all models
abstract class Model{

	//Login informations
	private $dbname="presshare";
	private $host="localhost:3306";
	private $username="root";
	private $password="";

	//Connexion
	protected $_connexion;

	//Id et tanle name
	public $id;
	public $table="";

	//Function with connects to the database
	//It returns an PDO object
	public function getConnexion(){
		$this->connexion = null;
		try{
			$this->connexion = new PDO("mysql:host=".$this->host."; dbname=".$this->dbname,$this->username,$this->password);
			$this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connexion->exec("set names utf8");
		}catch(PDOException $exception){
			die("Erreur Connexion ".$exception->getMessage());
		}
	}

	//Function with get all the records of a table
	//It returns it as object
	public function getAll(){
		try{
			$sql="SELECT * FROM ".$this->table;
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return $query->fetchAll();
		}catch(PDOException $exception){
			die("Erreur Connexion ".$exception->getMessage());
		}
	}

	//Function with get one record on with it's id
	//args : $id the id of the record
	public function getOne( $id){
		try{
			$sql = "SELECT * FROM {$this->table} WHERE a_id = :id";
			$query = $this->connexion->prepare($sql);
			$query->execute(['id'=>$id ]);
			return $query->fetch();
		}catch(PDOException $exception){
			die("Erreur getOne ".$exception->getMessage());
		}
	}

	//Function with get all records ontaining a key in the title or in the content
	//args : $q the key
	public function search(string $q){
		try{
			$sql = "SELECT p_id AS id, p_title AS title, p_content AS content, p_genre AS genre, DATE(p_created_at) AS 'date' FROM ".$this->table;
			$sql = $sql." WHERE p_title LIKE ('%".$q."%') OR p_content LIKE ('%".$q."%')";
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return $query->fetchAll();
		}catch(PDOException $exception){
			die("Erreur search ".$exception->getMessage());
		}
	}

	/*
		Delete an record by his id
	*/
	public function del($id){
		try{
			$sql = "DELETE FROM ".$this->table." WHERE p_id=".$id;
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return true;
		}catch(PDOException $exception){
			die('Erreur deletePress : '.$exception->getMessage());
		}
	}

}