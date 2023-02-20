<?php

/**
* Class ContentController 
* Extends Controller
* @Variables
*/

class BroadcastController extends Controller
{

	function __construct(){
		parent::__construct();

		$api = new ApiController();

		$this->setVariable('today', date('Y-m-d'));

		$this->setVariable('total', $api->call_count('outgoing',NULL));
		$this->setVariable('answered', $api->call_count('outgoing','ANSWERED'));
		$this->setVariable('not_answered', $api->call_count('outgoing','NO ANSWER'));
		$this->setVariable('failed', $api->call_count('outgoing','FAILED'));
		$this->setVariable('busy', $api->call_count('outgoing','BUSY'));
		
	}

	function index(){


		if(isset($_SESSION['user'])){

			$this->setView('', 'broadcast');
			$this->setVariable('today', date('Y-m-d'));

		}

		if(isset($_POST['startCampaignBtn'])) {

		    $msisdn = $_POST['msisdn'];
		    $uploaddir = UPLOAD_PATH;
		    
		    $info = '';
		    
		    // if(isset($_FILES['file']['name'])){

		    //     // Create unique filename
		    //     $uploadfile = $uploaddir . '/sounds/' . date('YmdHis') . '.mp3';

		    //      // Check file size > 4MB
		    //     if ($_FILES["file"]["size"] > 40000000) {

		    //         $info = "Sorry, your file (" . $_FILES["file"]["size"] . " bytes) is too large.";
		    //         $this->notifyBar('error',$info);
		    //         die();
		           
		    //     }

		    //     if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {


		    //         $info = 'File Uploaded Successfully';
		    //         $this->notifyBar('success',$info);
		            
		    //     } 
		    //     else {
		        
		    //        $info = 'Upload Failed';
		    //        $this->notifyBar('error',$info);
		    //        die();
		           
		    //     }

		    // }
		   
		    if(isset($_POST['msisdn'])){

		        $arrMsisdn = explode(',', $_POST['msisdn']);
		        foreach($arrMsisdn as $msisdn){
		          $this->makeCallFile($msisdn);
		        }
		        $this->notifyBar('success', 'Broadcast sent');
		    }

		}
		

	}

    function makeCallFile($_msisdn){
    	
    	Utils::trace("Building Call File for " . $_msisdn);

    	$c = 'Channel: SIP/prayer360_out/' . $_msisdn;
    	$c .= "\nContext: instant\nExtension: 20\nWaitTime: 20\nRetryTime: 2\nCallerid: 07006443696\nArchive: yes";
    	$filename = UPLOAD_PATH .'calldump/' . $_msisdn . '.call';
    	if (($handle = fopen($filename, "w")) !== FALSE) {

    	    fwrite($handle, $c);
    	    fclose($handle);
    	}
    	
    	shell_exec('chmod +x ' . $filename);
    	shell_exec('mv ' . $filename . ' /var/spool/asterisk/outgoing/' );
    
    }

	
}

?>