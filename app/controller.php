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
		if($file != 'add' && $file != 'login' && $file != 'signup')
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
	
	/*
		Generate random caracters token
		args: $length => the length of the token
	*/
	public function str_random(int $length){
		$alphabet ="qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
		$alphabet = str_repeat($alphabet,$length);
		$alphabet = str_shuffle($alphabet);
		return substr($alphabet,0,$length);
	}
	
	
	/*
		Function to send emails
	*/
	public function sendmail(string $to, string $subject, string $message){
		$headers =	"From: contact@presshare.com\r\n".
					"Reply to: contact@presshare.com\r\n".
					"MIME-Version:1.0\r\n".
					"Content-Type: text/html; charset=UTF-8\r\n";
		$content = '
		<html>
		<head>
			<meta charset="utf-8">
			<title>Activer votre compte</title>
			<style>
			header{
				padding:10px;
				margin-bottom: 20px;
			}
			.container{
				min-height:200px;
			}
			
			.logo{	
				grid-area: logo;
				margin:0;
				margin-top:0;	
				color:blue;
			}
			.logo a{
				text-decoration:none;
			}
			.logo a:visited{
				color:blue;
			}
			img{
				max-width:100%;
			}
			.svg{
				vertical-align:middle;
			}
			body{
				margin:auto;
				font-family:  Verdana,sans-serif;
				font-size:1em;
				
			}
			footer{
				background-color : #7b7272;
				color: white;
				padding:10px;
				margin-top:30px;
			}
		</style>
	</head>
	<body>
		<header>
			<h1 class="logo"><a href="'.ROOT_URL.'">
			<img id="logo-share" src="'.ROOT_URL.'svg/share-alt-mini.svg" class="svg" alt="logo">
			<img id="logo-clipboard" class="svg" src="'.ROOT_URL.'svg/clipboard-mini.svg" alt="logo">PressShare</a></h1>
		</header>
		<div class="container">'.
		$message
		.'</div>
		<footer>
			PressShare<br>
			Copyright &copy 2021
		</footer>
	</body>
	</html>';
	mail($to, $subject, $content,$headers);
	}
}
