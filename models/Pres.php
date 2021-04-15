<?php
namespace App\Models;
use App\Model;
use \PDO;
use \PDOException;
class Pres extends Model{
	
	//Set the table name and connect to the database
	public function __construct(){
		$this->table="press";
		$this->getConnexion();
	}	
	
	//Get the 6 last press
	public function getLastPress(){
		try{
			$sql="SELECT p_id AS id, p_title AS title, p_content AS content, DATE(p_created_at) AS 'date', p_genre AS genre FROM ".$this->table." ORDER BY p_created_at DESC LIMIT 6";
			$query = $this->connexion->prepare($sql);
			$query->execute();		
			return $query->fetchAll(PDO::FETCH_OBJ);
		}catch(PDOException $exception){
			die('Erreur : '.$exception->getMessage());
		}
	}

	//Get all Press records by their genre
	//args: $genre => the genre of the presses you want
	public function getPressByGenre(string $genre){
		try{
			$sql="SELECT  p_id AS id, p_title AS title, p_content AS content, DATE(p_created_at) AS 'date', p_genre AS genre FROM ".$this->table." WHERE p_genre='".$genre."'";			
			$query = $this->connexion->prepare($sql);
			$query->execute();		
			return $query->fetchAll(PDO::FETCH_OBJ);
		}catch(PDOException $exception){
			die('Erreur genre : '.$exception->getMessage());
		}
	}
	
	/*
		Add a new Press
		args :	$title => the title of the press
				$content => the content of the press
				$genre => the genre of the press
	*/
	public function add(string $title, string $content, string $genre){		
		try{
			$sql = "INSERT INTO ".$this->table."(p_title,p_content,p_genre,p_author_id) VALUES('".$title."','".$content."','".$genre."',1)";		
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return true;
		}catch(PDOException $exception){			
			return false;
			
		}			
	}
	
	/*
		Verify if an Press is already in the records
		It prevents duplicate entry errors
		args: $title => the title of a press
	*/
	public function exists(string $title){
		try{
			$sql = "SELECT p_id FROM ".$this->table." WHERE p_title='".$title."'";
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return $query->fetch(PDO::FETCH_OBJ);
		}catch(PDOException $exception){			
			die('Erreur exists : '.$exception->getMessage());
		}
	}
	
	/*
		Update the content of a Press
		args :	$id => the id of the press to update
				$title => the new title
				$content => the new content
				$genre => the new genre
	*/
	public function update($id,$title,$content,$genre){
		try{
			$sql = "UPDATE ".$this->table." SET p_title='".$title."', p_content='".$content."', p_genre='".$genre."', p_last_modified = NOW() WHERE p_id=".$id;			
			$query = $this->connexion->prepare($sql);
			$query->execute();			
			return true;
		}catch(PDOException $exception){
			return false;
			die('Erreur update: '.$exception->getMessage());						
		}
	}
	
	/*
		Get one Press by his id
	*/
	public function getPress($id){
		try{
			$sql = "SELECT p_id AS id, p_title AS title, p_content AS content, p_genre AS genre FROM ".$this->table." WHERE p_id=".$id;
			$query = $this->connexion->prepare($sql);
			$query->execute();
			return $query->fetch(PDO::FETCH_OBJ);
		}catch(PDOException $exception){			
			die('Erreur getPress : '.$exception->getMessage());
		}
	}	
}	