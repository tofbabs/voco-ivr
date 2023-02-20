<?php

/**
* Class DashboardController 
* Extends Controller
*/

class NotfoundController extends Controller
{
	function __construct(){
		parent::__construct();
	}

	function index(){

		$this->setView('', 'notfound');

	}
}

?>