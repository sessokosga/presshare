<?php
namespace App\Controllers;
use App\Controller;
use App\Models\Pres;
class Home extends Controller{
	public function index(){
		//$this->loadModel('Pres');
		$pres= new Pres();		
		$this->render('home',['title'=>'Accueil', 'last_press'=>$pres->getLastPress(),
								'text_press'=>$pres->getPressByGenre('Text',6), 'link_press'=>$pres->getPressByGenre('Link',6)]);
	}	
}