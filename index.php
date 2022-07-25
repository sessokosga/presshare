<?php
session_start();
// Define the root url
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
$url = $_SERVER['SERVER_ADDR'] == "::1" ? 'localhost' : $_SERVER['SERVER_ADDR'];
//define('ROOT_URL', 'http://' . $url . '/php/presshare/');
define('ROOT_URL', 'http://presshare.test/');

require_once ROOT . "vendor/autoload.php";



use App\Controllers\Errors;

// Errors handler
$error = new Errors();

// Get the params from the url
$params = $_SERVER["REQUEST_URI"];
$params = explode('/', $params);
$controller = $params[1] != '' ? ucfirst(strtolower($params[1])) : 'Home';

// Check if the controller's file exists
$file = ROOT . 'controllers/' . $controller . '.php';
if (file_exists($file)) { // if so, continue 
	// Get the controller 
	$controller = "App\\Controllers\\" . $controller;
	$action = isset($params[2]) ? $params[2] : 'index';
	$action = strtolower($action);
	// check if the controller class exists
	if (class_exists($controller)) { // if so, continue
		// Create an instance of the controller
		$controller = new $controller;
		// Get the action(method) to call
		$action = isset($params[2]) ? $params[2] : 'index';
		// Check if the action(method) exists
		if (method_exists($controller, $action)) { // if so, call the method						
			unset($params[1]);
			unset($params[2]);
			if (count($params) > 1)
				unset($params[0]);
			call_user_func_array([$controller, $action], $params);
		} else { // Throw an error if the action(method) doesn't exist
			//$error->render('errors', ['code' => 404, 'message' => 'Page 1 not found']);
			$error->render('errors', ['code' => 404, 'message' => "the action(method) " . $action . " doesn't exist"]);
		}
	} else { // Throw an error if the controller class doesn't exist
		//$error->render('errors', ['code' => 404, 'message' => 'Page 2 not found']);
		$error->render('errors', ['code' => 404, 'message' => "the controller class doesn't exist"]);
	}
} else { // Throw an error if the required controller's file doesn't exist
	//$error->render('errors', ['code' => 404, 'message' => 'Page 3 not found']);
	$error->render('errors', ['code' => 404, 'message' => "the required controller's file '" . $controller . "' doesn't exist"]);
}
