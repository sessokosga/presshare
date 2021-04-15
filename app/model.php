<?php 
namespace App;
use \PDO;
//The superlass containing the main functions used by all models
abstract class Model{
	
	//Login informations
	private $dbname="presshare";
	private $host="localhost:3307";	
	private $username="util";
	private $password="util";
	
	//Connexion
	protected $_connexion;
	
	//Id et tanle name
	public $id;
	public $table="";
	
	//Function with connects to the database
	//It returns an PDO object
	public function getConnexion(){
		$this->connexion = null;
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		try{
			$this->connexion = new PDO("mysql:host=".$this->host."; dbname=".$this->dbname,$this->username,$this->password,$pdo_options);
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
			return $query->fetchAll(PDO::FETCH_OBJ);
		}catch(PDOException $exception){
			die("Erreur Connexion ".$exception->getMessage());
		}
	}
	
	//Function with get one record on with it's id
	//args : $id the id of the record
	public function getOne(int $id){
		try{
			$sql = "SELECT * FROM ".$table."WHERE id=".$id;
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return $query->fetch(PDO::FETCH_OBJ);
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
			return $query->fetchAll(PDO::FETCH_OBJ);
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
