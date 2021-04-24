<?php 
namespace App\Controllers;
use App\Controller;
use App\Models\Pres;
use App\Controllers\Errors;


class Press extends Controller{
	
	/*
		Check if the visitor is logged
	*/
	public function checkLogin(){
		if(!isset($_SESSION['auth'])){
			header('Location: '.ROOT_URL.'login');
			$_SESSION['flash']['alert']='You must be logged';
			$_SESSION['flash']['type']='error';
			exit();
		}
	}
	
	/*
		Check if a user can modify a press
	*/
	public function checkAuthor($press_id){
		$error = new Errors();
		$id = $_SESSION['auth']->a_id;
		$pres = new Pres();		
		$author=$pres->getAuthor($press_id)->id;
		
		
		if($id != $author){
			$error->render('errors',['code'=>404, 'message'=>'Page not found']);
		}
		
	}
	
	/*
		The home function of Presses
		It shows the list of the presses of the indiated genre
		args : $genre => The genre of the Presses
	*/
	public function index(string $genre=''){			
		if($genre===''){
			$this->render('index',['title'=>'Press', 'content'=>'Welcome to Press']);
		}else{
			$title=ucfirst(strtolower($genre));			
			$pres = new Pres();
			$press = $pres->getPressByGenre(str_replace('s','',$title));		
			$message=count($press)." Press found(s)";
			$this->render('press',compact('title','message','press'));
		}
	}

	/*
		It manage the form to add a press
	*/
	public function add(){
		$error = new Errors();
		$this->checkLogin();
		$result=[];
		$result['success']=false;
		$title="Ajouter un Press";			
		if(isset($_POST['p_title']) && isset($_POST['p_content']) && isset($_POST['p_genre'])){
			extract($_POST);
			if(strlen($p_title)>0 && strlen($p_content)>1 &&  in_array($p_genre,['Text','Link'])){								
				$pres = new Pres();
				if($pres->exists($p_title)){					
					$result['message'] = "Fields not valids";
					$result['errorInfo']['title']=$error->showError("This title is already used");					
					$result['title']=$p_title;
					$result['content']=$p_content;
					$result['genre']=$p_genre;
				}else{									
					$p_content = str_replace("[enter]","\n",$p_content);
					$success = $pres->add(htmlspecialchars($p_title),htmlspecialchars($p_content),$p_genre,$_SESSION['auth']->a_id);
					if($success){
						$result['success']=true;
						$result['message'] = "Press successfully added.";					
					}else{
						$result['message']="An error occured. Please try again";
					}
				}
			}else{	
			
				$result['message']= "You must fill all the fields";
			}			
			$this->render('add',compact('result', 'title'));
		}else{
			$this->render('add',compact('title'));
		}		
	}

	/*
		It add 30 fake Press records in the database for tests purpose
	*/
	public function addx(){
		$title="Ajouter un Press";			
		for($i=0; $i<30; $i++){
			$pres = new Pres();
			$genre=['Text','Link'];
			$success = $pres->add(str_replace('+',' ',base64_encode(random_bytes(rand(3,12)))),str_replace('+',' ',base64_encode(random_bytes(rand(10,20)))),$genre[rand(0,1)]);						
		}
		$message="30 Press ajouté avec success";
		$this->render('add',compact('success', 'title', 'message'));
	
	}
	
	
	/*
		It manage the form to upadate a press
		args : $id => the id of the press
	*/
	public function update($id){
		$error = new Errors();
		$this->checkLogin();
		$this->checkAuthor($id);		
		$result=[];
		$result['success']=false;
		$title = "Edit a Press";		
		$pres = new Pres();
		$press = $pres->getPress($id);
		if($press){
			if(isset($_POST['p_title']) && isset($_POST['p_content']) && isset($_POST['p_genre'])){
				extract($_POST);		
				$fields['title']=$p_title;				
				$fields['content']=$p_content;				
				$pres = new Pres();								
				$p_content = str_replace("[enter]","\n",$p_content);
				$res = $pres->update($id,htmlspecialchars($p_title), htmlspecialchars($p_content), $p_genre);
				$result['success']=$res['success'];
				if($result['success']){
					$result['message']= "Press successfully edited";
				}else{
					$result['message']="An error occured. Please try again";
					if($res['code']=="23000"){						
						$result['message'] = "Field(s) invalid(s)";
						$result['errorInfo']['title']=$error->showError("This title is already used");										
					}
				}
				
				$press = $pres->getPress($id);
				$this->render('update',compact('title','press', 'result'));
			}			
			$this->render('update',compact('title','press'));
		}else{			
			$error = new Errors();
			$error->render('errors',['code'=>404, 'message'=>'Page not found']);			
		}
	}

	/*
		It manage the deletion of a press
	*/
	public function deletepress($id){
		$error = new Errors();
		$this->checkLogin();
		$this->checkAuthor($id);
		$title="Suppression d'un Press";		
		$pres = new Pres();
		$press = $pres->getPress($id);
		if($press){
			$success = $pres->del($id);
			$message=$success ? "Press successfully deleted" : "An error occured. Please try again.";
			$this->render('delete',compact('title','success','message'));
		}else{			
			$error = new Errors();
			$error->render('errors',['code'=>404, 'message'=>'Page not found']);			
		}
	}
	
	/*
		It handle the search form
		args : $q the key
	*/
	public function search(string $q){
		$title="Search results" ;		
		$q = trim($q);
		if(strlen($q)>0){
			extract($_GET);
			$q=htmlspecialchars($q);
			$pres = new Pres();
			$press = $pres->search($q);
			$title='"'.$q."' Search results" ;
			$message = count($press)." Press found(s)";
			$this->render('search',compact('title','press','message'));
		}else{
			$message = "Enter a search key";
			$this->render('search',compact('title','message'));
		}
	}
}