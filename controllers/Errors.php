<?php

namespace App\Controllers;
use App\Controller;

class Errors extends Controller{
	public function showError(string $message){
		return '<small class="form-error">'.$message.'</small>';
	}
}
