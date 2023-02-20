<?php

/**
* Class ApiController 
* Extends Controller
* Opens up Interfaces for Reporting and Asterisk call session
*/

class ApiController extends Controller{
	
	private $s;

	function __construct(){
		parent::__construct();
		$this->setView('', 'raw');

		if (isset($_GET['phone'])){

			// API output requires a pure output without HTML tagas
			
			Utils::trace('Checking if ' . $_GET['phone'] . ' is subscribed...');
			$this->s = Subscriber::getOne(array('msisdn' => $_GET['phone'] ));
			// print_r($this->s);
			if(null == $this->s->getId()){
				$this->s = new Subscriber();
				$this->s->setPhone($_GET['phone']);
				$this->s->setCategory('generic');
			}
			$this->s->setLastDialed(date('Y-m-d G:i:s'));

			$this->s->save();

		}
	}

	// Service API for Javascript AJAX request
	function subCat($_cat){

		Utils::trace('Setting Category to '. $_cat . ' for '. $this->s->getPhone());
		$this->s->setCategory($_cat);
		$this->s->setAdded(date('Y-m-d H:i:s'));
		$this->s->save();

	}

	function getCat(){
		$cat = $this->s->getCategory();
		echo $cat;
		Utils::trace('API Call: Retrieving Service category - '. $cat . ' for '. $this->s->getPhone());
		return $cat;
	}

	/*
	**	API Call get Count between Timeframe
	**	Sample: /api/answered/incoming/2015-08-16/2015-08-16%2010:00:34
	**	@Variables: $start, $status, $end
	**	$status = NO ANSWER, FAILED, BUSY, ANSWERED, or UNKNOWN
	*/

	public function call_count($type='incoming', $status, $start=NULL, $end=NULL){

		$start = !isset($start) ? date('Y-m-d') : $start;
		$end = !isset($end) ? date('Y-m-d H:i:s', time()) : $end;
		$status = isset($status) ? strtoupper($status) : NULL ;
		
		// echo 'Status is ' . $status;
		Utils::trace('Getting Number of ' . $type . ' '. $status . ' between ' . $start . ' and ' . $end);

		$count = CDR::getCountModified($type, $status, $start, $end);
		Utils::trace($count);
		return $count;
			
	}

	/*
	**	API Call get Count between Timeframe
	**	Sample: /api/answered/incoming/2015-08-16/2015-08-16%2010:00:34
	**	@Variables: $start, $status, $end
	**	$status = NO ANSWER, FAILED, BUSY, ANSWERED, or UNKNOWN
	*/

	public function sub_count($category='generic', $start=NULL, $end=NULL){

		$start = !isset($start) ? date('Y-m-d') : $start;
		$end = !isset($end) ? date('Y-m-d H:i:s', time()) : $end;

		// echo 'Status is ' . $status;
		Utils::trace('Getting Number of ' . $category . ' calls between ' . $start . ' and ' . $end);

		$count = Subscriber::getCountModified($category, $start, $end);
		Utils::trace($count);
		return $count;

	}


	/*
	**	Generates JSON output for daily intermittent (incomign and outgoing) calls between a timeframe
	**	Sample: /api/call-graph/2015-08-16/2015-08-16%2010:00:34
	**	@Variables: $start, $finish
	**	$status = NO ANSWER, FAILED, BUSY, ANSWERED, or UNKNOWN
	*/
	function call_graph($start, $finish){

		// echo $start . $finish;
		$date = strtotime($start);
		$finish = strtotime($finish);
		$arrIncoming = array();
		
		while ($date <= $finish) {
			# code...
			// Container Class for Returned Data
			$d = new data();

			$d->period = date('Y-m-d', $date);

			$next =  date('Y-m-d', strtotime("+1 day", $date));

			$d->inbound = $this->call_count('incoming', 'answered', $d->period, $next);
			$d->outbound = $this->call_count('outgoing', 'answered', $d->period, $next);

			$date = strtotime("+1 day", $date);

			$arrIncoming[] = $d;
		}

		echo json_encode($arrIncoming);

    }


    /*
	**	Generates JSON output for daily intermittent (incomign and outgoing) calls between a timeframe
	**	Sample: /api/call-graph/2015-08-16/2015-08-16%2010:00:34
	**	@Variables: $start, $finish
	**	$status = NO ANSWER, FAILED, BUSY, ANSWERED, or UNKNOWN
	*/
	function sub_graph($start, $finish){

		// echo $start . $finish;
		$date = strtotime($start);
		$finish = strtotime($finish);
		$arrSubscriber = array();
		
		while ($date <= $finish) {
			# code...
			// Container Class for Returned Data
			$d = new data();
			$d->period = date('Y-m-d', $date);

			$next =  date('Y-m-d', strtotime("+1 day", $date));

			$d->generic = $this->sub_count('generic', $d->period, $next);
			$d->christian = $this->sub_count('christian', $d->period, $next);
			$d->muslim = $this->sub_count('muslim', $d->period, $next);

			$date = strtotime("+1 day", $date);

			$arrSubscriber[] = $d;
		}

		echo json_encode($arrSubscriber);

    }



}

class data{}

?>