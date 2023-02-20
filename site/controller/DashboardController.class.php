<?php

/**
* Class DashboardController 
* Extends Controller
*/

class DashboardController extends Controller
{
	function __construct(){
		parent::__construct();
	}

	function index(){

		if(isset($_POST['loginBtn'])){

		    $user = isset($_POST['username']) ? trim($_POST['username']) : '';
		    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

		    $p = User::getOne(array('name' => $user));

		    // print_r($p);

		    if($p->getPassword() == $password){
		    
		    	$_SESSION['user'] = $p;
		    	$this->initDashboard();
		        $this->setView('', 'index');
		    	
		    }else{
		       $this->setView('', 'login');
		    }
		}
		
		if(isset($_SESSION['user'])){

			$this->initDashboard();
		    $this->setView('', 'index');

		}

	
	}

	function initDashboard(){

		$api = new ApiController();

		$this->setVariable('today', date('Y-m-d'));

		$this->setVariable('total', $api->call_count('incoming',NULL));
		$this->setVariable('answered', $api->call_count('incoming','ANSWERED'));
		$this->setVariable('not_answered', $api->call_count('incoming','NO ANSWER'));
		$this->setVariable('failed', $api->call_count('incoming','FAILED'));
		$this->setVariable('busy', $api->call_count('incoming','BUSY'));

		$this->setVariable('total_call', CDR::getSum('billsec', array('calldate' => date('Y-m-d')), '>'));
// 		$this->setVariable('month_total_call', CDR::getSum('billsec'));
		$this->setVariable('month_total_call', CDR::getSum('billsec', array('calldate' => date('Y-m'). '-01') , '>'));
	}
	
}

?>