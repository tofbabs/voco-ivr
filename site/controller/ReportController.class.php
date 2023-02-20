<?php

/**
* Class ReportController 
* Extends Controller
*/

class ReportController extends Controller{
	
	function __construct(){
		parent::__construct();
	}

	function index(){

		$this->setView('', 'report');

	}

	// Service API for Javascript AJAX request
	function api(){


	}

}

?>