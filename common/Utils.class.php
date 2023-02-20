<?php

/*
	Utility operation e.g. Debug to Console, 
*/

class Utils{

	/*
	**	Get DATA via HTTP
	*/

	static function getData($url){
 
	    // is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	 	
	   	$ch = curl_init();  
	   	
	   	curl_setopt($ch,CURLOPT_URL,$url);
	   	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	   	
	   	$output = curl_exec($ch);
	   	
	   	if($output === false){
	   	    self::debug_to_console("Error Number:".curl_errno($ch)."<br>");
	   	    self::debug_to_consol("Error String:".curl_error($ch));
	   	}

	   	curl_close($ch);
	   	return $output;
	}

	/*
	**	Post DATA via HTTP
	*/

	static function postData($url,$params){

	   //create name value pairs seperated by &
	  $postData = http_build_query($params);
	 
	    $ch = curl_init();  
	 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_HEADER, false); 
	    curl_setopt($ch, CURLOPT_POST, count($postData));
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
	 
	    $output=curl_exec($ch);
	 
	    curl_close($ch);
	    return $output;
	 
	}
	/**
	 * Set error reporting | From Config File
	 */
	
	static function setErrorLogging(){
	    if(DEVELOPMENT_ENVIRONMENT == true){
	        error_reporting(E_ALL);
	        ini_set('display_errors', "1");
	    }else{
	        error_reporting(E_ALL);
	        ini_set('display_errors', "0");
	    }
	    ini_set('log_errors', "1");
	    ini_set('error_log', ROOT . 'system/log/error_log.php');
	}

	/**
	 * Trace function which outputs variables to system/log/output.php file
	 */
	static function trace($var,$append=false){
	    // $oldString="<?php\ndie();/*";
	    if($append){
	        $oldString=file_get_contents(ROOT . 'system/log/access.log');
	    }

	    file_put_contents(ROOT . 'system/log/access.log', $var . "\n");
	}

	/** Check for Magic Quotes and remove them **/
	static function stripSlashesDeep($value) {
	    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	    return $value;
	}

	static function removeMagicQuotes() {
	    if ( get_magic_quotes_gpc() ) {
	        $_GET    = self::stripSlashesDeep($_GET   );
	        $_POST   = self::stripSlashesDeep($_POST  );
	        $_COOKIE = self::stripSlashesDeep($_COOKIE);
	    }
	}

	/** Check register globals and remove them **/
	static function unregisterGlobals() {
	    if (ini_get('register_globals')) {
	        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	        foreach ($array as $value) {
	            foreach ($GLOBALS[$value] as $key => $var) {
	                if ($var === $GLOBALS[$key]) {
	                    unset($GLOBALS[$key]);
	                }
	            }
	        }
	    }
	}

/*
	static function buildCallFile($_msisdn){

		Utils::trace("Calling " . $_msisdn);
		
		$c = 'Channel: SIP/prayer360_out/' . $_msisdn;
		$c .= "\nContext: beep\nExtension: 10\nWaitTime: 1\nCallerid: 07007729365\nArchive: yes";
    	$filename = UPLOAD_PATH .'calldump/' . $_msisdn . '.call';
    	if (($handle = fopen($filename, "w")) !== FALSE) {

    	    fwrite($handle, $c);
    	    fclose($handle);
    	}
    	
    	shell_exec('chmod +x ' . $filename);
    	shell_exec('mv ' . $filename . ' /var/spool/asterisk/outgoing/' );

	}
*/	
	static function buildCallFile($_msisdn){

		Utils::trace("Building Call File for " . $_msisdn);

		$c = 'Channel: SIP/prayer360_out/' . $_msisdn;
		$c .= "\nContext: instant\nExtension: 10\nWaitTime: 1\nCallerid: 014405365\nArchive: yes";
		$filename = UPLOAD_PATH .'calldump/' . $_msisdn . '.call';
		if (($handle = fopen($filename, "w")) !== FALSE) {

		    fwrite($handle, $c);
		    fclose($handle);
		}
		shell_exec('chmod +x ' . $filename);

	}

	static function clean($string){
		# code...

   		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
   		return preg_replace('?', '', $string);


	}

}

