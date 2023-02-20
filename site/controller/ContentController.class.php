<?php

/**
* Class ContentController 
* Extends Controller
* @Variables
*/

class ContentController extends Controller
{
	private $services;

	function __construct(){
		parent::__construct();
		
	}

	function index(){

		$this->setView('', 'services');

	}
	
}

?>