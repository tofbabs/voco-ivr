<?php

/**
* Class ReportController 
* Extends Controller
*/

class SubscriberController extends Controller{

	private $host;
	function __construct(){
		parent::__construct();
		global $host;
		$this->host = $host;

		$this->setVariable('total', Subscriber::getCount());
		$this->setVariable('generic', Subscriber::getCount(array('category' => 'generic')));
		$this->setVariable('christian', Subscriber::getCount(array('category' => 'christian')));
		$this->setVariable('muslim', Subscriber::getCount(array('category' => 'muslim')));
	}

	function index(){

		if(isset($_POST['uploadSubBtn'])) {

			$state = isset($_POST['state']) ? $_POST['state'] : Utils::trace('No State set..');
			$category = isset($_POST['cat']) ? $_POST['cat'] : Utils::trace('Default Category set..');

			// Location to Move Freshly uploaded file
		    $uploadfile = str_replace(' ', '_', $state) . "_" . $category . "_" . time() . ".csv";
		    // echo $uploadfile;
		    Utils::trace('Uploading ' . $uploadfile . "...");

		    // print_r($_FILES);

		    if (move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . $uploadfile)) {
		        $msg = 'File Uploaded Successfully';
		        // $this->notifyBar('success',$msg);
		    } 
		    else {
		        $msg = 'Upload Failed';
		       // $this->notifyBar('error',$msg);
		    }

		    echo $msg;
		    Utils::trace($msg);

		    $queryData = http_build_query(
		    	array(
		    			'cat' => $category,
		    			'state' => $state,
		    			'file' => $uploadfile
		    		)

		    	);
		    echo $queryData;
		    $url = $this->host . '/subscriber/bulkAdd?' . $queryData;
		    echo $url;
		    // $null = exec('wget ' . $url);
		    $this->setView('', 'subscriber');

		}

		if(isset($_SESSION['user'])){

			$this->setVariable('total_call', CDR::getSum('billsec', array('calldate' => date('Y-m-d')), '>'));
			$this->setView('', 'subscriber');

		}

	}

	function bulkAdd($file, $state,$thread, $cat= 'generic'){

		$s = new Subscriber();

		$s->setCategory($cat);
		$s->setLocation($state);

		Utils::trace("Updating Subscriber List in " . $file . ' as ' . $state . $cat);

		$fp = file($file, FILE_SKIP_EMPTY_LINES);
		$numrow = count($fp);

		$factor = $numrow/$thread;
		//Total number of msisdn to be processed by this thread
		$abs_offset = $thread * $factor;
		$cur_offset = $abs_offset - $factor;

		echo "Starting Offset is " . $cur_offset;
		echo "Absolute Offset is " . $abs_offset;

		if (($handle = fopen($file, "r")) !== FALSE) {

			fseek($handle, $cur_offset);
			// exclusive lock
			// if (flock($handle,LOCK_EX|LOCK_NB)){

			 	while (($data = fgetcsv($handle, 20, "\n")) !== FALSE) {

			 	    $msisdn = $data[0];

			 		if ($msisdn == "") {
			 		    # code...
			 		    continue;
			 		}

			 		Utils::trace('Adding ' . $msisdn . "\n");

			 	    $s->setPhone($msisdn);
			 	    $s->save();
			 	}

			  	// release lock
			  	flock($handle,LOCK_UN);
			  	fclose($handle);
			  	unlink($file);
			// }
			// else{

			// 	Utils::trace("Error locking file!");

			// }
		     
		}

	}

	function updatesub(){

		$arrState = array("Anambra","Enugu","Akwa Ibom","Adamawa","Abia","Bauchi","Bayelsa","Benue","Borno","Cross River","Delta"
		,"Ebonyi","Edo","Ekiti","Gombe","Imo","Jigawa","Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos"
		,"Nasarawa","Niger","Ogun","Ondo","Osun","Oyo","Plateau","Rivers","Sokoto","Taraba","Yobe","Zamfara");

		foreach ($arrState as $key => $state) {

			for ($i=0; $i < 20; $i++) { 
				# code...
				$state = str_replace(' ', '', strtolower($state));

				// Set $i to original name of file
				$i = ($i == 0) ? null : $i;
				$file = UPLOAD_PATH . "subscriber/" . $state . $i . ".csv";

				// echo÷ $file;
				Utils::trace('Checking if ' . $file . 'Exist....');

				if (file_exists($file) ) {
					
					// echo $file . " exist";
					Utils::trace($file . ' Exist. Handing to Bulk Insert Module');
					// Invoke Bulk add Module 
					// $this->bulkAdd($file, $state, $thread);

					Subscriber::loadFile($file, $state);
					// shell_exec('mv ' . $file . ' ' . $file . '.indb');

				}
				else{
					# code...
					// echo $file . ' not exist';
					Utils::trace($file . " doesn't exist" );
					continue;

				}

			}

		}
		
		$this->setView('', 'subscriber');
		
		

	}

	function do_bulk(){

		$arrState = array("Anambra","Enugu","Akwa Ibom","Adamawa","Abia","Bauchi","Bayelsa","Benue","Borno","Cross River","Delta"
		,"Ebonyi","Edo","Ekiti","Gombe","Imo","Jigawa","Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos"
		,"Nasarawa","Niger","Ogun","Ondo","Osun","Oyo","Plateau","Rivers","Sokoto","Taraba","Yobe","Zamfara");

		foreach ($arrState as $key => $state) {

			$thread = 8;
			for ($i=1; $i <= $thread; $i++) { 
				# code...
				echo "Inserting" . $state . " Thread " . $thread;
				shell_exec('wget -qO /dev/null http://bimisa.atp-sevas.com/voco/subscriber/updatesub/'. $state .'/'. $i . ' &');
			}

		}
		
	}			

	function beep($start=1,$limit=1000000) {
		# code...
		
		$s = Subscriber::getAllNotDialedIn($start,$limit);

		foreach ($s as $sub) {
			# code...
			$msisdn = Utils::clean($sub->getPhone());
			Utils::buildCallFile($msisdn);
			echo $msisdn;

		}
		$this->setView('', 'raw');


	}


}

?>