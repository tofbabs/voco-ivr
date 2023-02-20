<?php

	/**
	* User Model
	*/
	class CDR extends Model{


		// protected static $primaryKey = "uniqueid";
		protected static $tableName = 'cdr';
		
		function __construct(){
			# code...
			parent::__construct();
			
		}

		/*
		**	Incoming Caller ID
		**	@Variable: MSISDN
		*/

		public function getCaller(){
			# code...
			return $this->getColumnValue('src');
		}


		/*
		**	Calling Party - dst
		**	@Variable: MSISDN
		*/

		public function getDest(){
			# code...
			return $this->getColumnValue('dst');
		}

		/*
		**	Call Start Timestamp
		**	@Variable: YYYY-MM-DD h:m:s
		*/

		public function getStartTime(){
			# code...
			return $this->getColumnValue('calldate');
		}		

		/*
		**	End of Call Timestamp
		**	@Variable: YYYY-MM-DD h:m:s
		*/
		public function getEndTime(){
			# code...
			$end = strtotime($this->getColumnValue('calldate')) - $this->getColumnValue('billsec');
			return date('Y-m-d H:m:s', $end);
		}

		/*
		**	Duration After Call has been Answered
		**	@Variable Type: Seconds
		*/
		public function getDuration(){
			# code...
			return $this->getColumnValue('billsec');
		}

		/*
		**	What Happened to the Call
		**	@Status : NO ANSWER, FAILED, BUSY, ANSWERED, or UNKNOWN
		*/
		public function getStatus(){
			# code...
			return $this->getColumnValue('disposition');
		}

		/*
		**	Get Count of Incoming Calls between a specified TimeFrame
		**	@Variable: $left,$status,$right, $type
		**	Defaul: $left=Beginning of TODAY, $right = Present Time, $type=incoming
		*/


		// static function getCountModified($type, $status, $left, $right){
// 
// 			$db = Database::getInstance();
// 			
// 			$query = "SELECT COUNT(*) FROM " . static::$tableName;
// 			$query .= ' WHERE calldate > :left AND calldate < :right';
// 
// 			if ($type == 'incoming') { $query .= ' AND dst<:ext'; }
// 			if ($type == 'outgoing') { $query .= ' AND dst>:ext'; }
// 
// 			$condition = array('left' => $left, 'right' => $right, 'ext' => '5556');
// 			
// 			if (!is_null($status)) {
// 				# code...
// 				$query .= ' AND disposition=:disp'; 
// 				$condition['disp'] = $status;
// 			}
// 
// 			// echo $query;
// 			// print_r($condition);
// 
// 
// 			Utils::trace($query);
// 
// 			$s = $db->getPreparedStatment($query);
// 			$s->execute($condition);
// 			// print_r($s);
// 			$countArr = $s->fetch();
// 			return $countArr[0];
// 		}


		static function getCountModified($type, $status, $left, $right){

			$db = Database::getInstance();
			
			$query = "SELECT COUNT(*) FROM " . static::$tableName;
			$query .= ' WHERE calldate > :left AND calldate < :right';

			if ($type == 'incoming') { $query .= ' AND clid NOT LIKE "%0700%"'; }
			if ($type == 'outgoing') { $query .= ' AND clid LIKE "%0700%"'; }

			$condition = array('left' => $left, 'right' => $right);
			
			if (!is_null($status)) {
				# code...
				$query .= ' AND lastapp <> "CONGESTION" '; 
				$query .= ' AND disposition=:disp'; 
				$condition['disp'] = $status;
			}

			// echo $query;
			// print_r($condition);


			Utils::trace($query);

			$s = $db->getPreparedStatment($query);
			$s->execute($condition);
			// print_r($s);
			$countArr = $s->fetch();
			return $countArr[0];
		}

		
		 
	}

?>