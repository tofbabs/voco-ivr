<?php

define('UPLOAD_PATH', './uploads');

$db_conn = new DB_conn(DB_HOST,DB_PORT,DB_USER,DB_PASSWORD,DB_DBASE);


if(isset($_POST['uploadBtn'])) {

    $uploaddir = UPLOAD_PATH;

    $uploadfile = $uploaddir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], str_replace(' ','_',$uploadfile))) {
        $msg = 'File Uploaded Successfully';
        notifyBar('success',$msg);
    } 
    else {
        $msg = 'Upload Failed';
       notifyBar('error',$msg);
    }

}

if ($_GET['action'] == ) {
	# code...
	// UPLOAD_PATH . 
}

function process($file){

	if (($handle = fopen($file, "r")) !== FALSE) {

	    while (($data = fgetcsv($handle, 20, "\n")) !== FALSE) {

	        $msisdn = $data[0];
	        // echo $msisdn;
	        buildCallFile($msisdn)
	        if ($msisdn == "") {
	            # code...
	            continue;
	        }
	    }

	    fclose($handle);
	}

}

function buildCallFile(){

	$c = 'Channel: SIP/prayer360_out/' . $_msisdn;
	$c .= "\n Context: call-file-test
					\n Extension: 10
					\n MaxRetries: 2
					\n RetryTime: 60
					\n WaitTime: 30
					\n Callerid: 2348081067641
					\n Archive: yes";
	$filename = 'call' . "_" . time();
	if (($handle = fopen($file, "r")) !== FALSE) {

	    fwrite($handle, $c);
	    fclose($handle);
	}

}

function notifyBar($type, $msg){

	echo '<b>' . $type . "</b>: " . $msg;

}





?>