<?php

/**
* Class DashboardController 
* Extends Controller
*/

class LoginController extends Controller
{
	function __construct(){
		parent::__construct();
	}

	function index(){

		unset($_SESSION['user']);
		session_destroy();
		$this->setView('', 'login');

	}
}

?>