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
			$_SESSION['flash']['alert']='Veuiller vous connecter';
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
			$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);
		}
		
	}
	
	/*
		The home function of Presses
		It shows the list of the presses of the indiated genre
		args : $genre => The genre of the Presses
	*/
	public function index(string $genre=''){			
		if($genre===''){
			$this->render('index',['title'=>'Press', 'content'=>'Bienvenu dans Press']);
		}else{
			$title=ucfirst(strtolower($genre));			
			$pres = new Pres();
			$press = $pres->getPressByGenre(str_replace('s','',$title));		
			$message=count($press)." Press trouvés";
			$this->render('press',compact('title','message','press'));
		}
	}

	/*
		It manage the form to add a press
	*/
	public function add(){
		$error = new Errors();
		$this->checkLogin();
		$title="Ajouter un Press";			
		if(isset($_POST['p_title']) && isset($_POST['p_content']) && isset($_POST['p_genre'])){
			extract($_POST);
			if(strlen($p_title)>0 && strlen($p_content)>1 &&  in_array($p_genre,['Text','Link'])){								
				$pres = new Pres();
				if($pres->exists($p_title)){
					$result['success']=false;					
					$result['message'] = "Champ(s) non valide(s)";
					$result['errorInfo']['title']=$error->showError("Ce titre est déja utilisé");					
					$result['title']=$p_title;
					$result['content']=$p_content;
					$result['genre']=$p_genre;
				}else{									
					$p_content = str_replace("[enter]","\n",$p_content);
					$success = $pres->add(htmlspecialchars($p_title),htmlspecialchars($p_content),$p_genre,$_SESSION['auth']->a_id);
					if($success){
						$result['success']=true;
						$result['message'] = "Press ajouté avec success.";					
					}else{
						$result['success']=false;
						$message="Une erreur s'est produite. Veuiller réessayer";
					}
				}
			}else{				
				$message= "Veuiller remplir tous les champs.";
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
		
		$title = "Modifier un Press";		
		$pres = new Pres();
		$press = $pres->getPress($id);
		if($press){
			if(isset($_POST['p_title']) && isset($_POST['p_content']) && isset($_POST['p_genre'])){
				extract($_POST);							
				$pres = new Pres();								
				$p_content = str_replace("[enter]","\n",$p_content);
				$res = $pres->update($id,htmlspecialchars($p_title), htmlspecialchars($p_content), $p_genre);
				$result['success']=$res['success'];
				if($result['success']){
					$result['message']= "Press modifié ave succès";
				}else{
					$result['message']="Une erreur s'est produite. Veuiller réessayer.";
					if($res['code']=="23000"){
						$result['message'] = "Champ(s) non valide(s)";
						$result['errorInfo']['title']=$error->showError("Ce titre est déja utilisé");										
					}
				}
				
				$press = $pres->getPress($id);
				$this->render('update',compact('title','press', 'result'));
			}			
			$this->render('update',compact('title','press'));
		}else{			
			$error = new Errors();
			$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);			
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
			$message=$success ? "Press supprimé avec succès" : "Une erreur s'est produite. Veuiller réessayer.";
			$this->render('delete',compact('title','success','message'));
		}else{			
			$error = new Errors();
			$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);			
		}
	}
	
	/*
		It handle the search form
		args : $q the key
	*/
	public function search(string $q){
		$title="Résultats de recherche" ;		
		$q = trim($q);
		if(strlen($q)>0){
			extract($_GET);
			$q=htmlspecialchars($q);
			$pres = new Pres();
			$press = $pres->search($q);
			$title='"'.$q."' Résultats de recherche" ;
			$message = count($press)." Press trouvés";
			$this->render('search',compact('title','press','message'));
		}else{
			$message = "Veuiller entrer un mot clé";
			$this->render('search',compact('title','message'));
		}
	}
}