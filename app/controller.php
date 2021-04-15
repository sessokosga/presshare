<?php
namespace App;

//The superclass that contains the main functions used by all controllers
abstract class Controller{
	
	//Funtion that render the views on the user's browser
	//args : $file => The file the render
	//		$data => The  data to show on the page
	public function render(string $file, array $data=[]){
		extract($data);				
		$dir=explode('\\', strtolower(get_class($this)));
		$dir = $dir[count($dir)-1];
		require_once(ROOT.'views/'.$dir.'/'.$file.'.php');
		if($file != 'add')
			$add=true;
		if(!isset($script))
			$script = "";
		require_once(ROOT.'views/layouts/default.php');
	}
		
	//Function to add a script on a page
	//args: $file => the of the script file
	public function loadScript(string $file){
		return "<script src=\"".ROOT_URL."/js/".strtolower($file).".js\" ></script>";
	}
}
