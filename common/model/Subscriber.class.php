<?php

	/**
	* User Model
	*/
	class Subscriber extends Model{


		protected static $primaryKey = "subscriberid";
		protected static $tableName = 'Subscriber';
		
		function __construct(){
			# code...
			parent::__construct();
			
		}

		public function getId(){
			# code...
			return $this->getColumnValue('subscriberid');
		}

		public function setPhone($value){
			# code...
			$this->setColumnValue('msisdn', $value);
		}


		public function getPhone(){
			# code...
			return $this->getColumnValue('msisdn');
		}

		public function setLocation($value){
			# code...
			$this->setColumnValue('location', $value);

		}

		public function getLocation(){
			# code...
			return $this->getColumnValue('location');
		}

		public function setCategory($value){
			# code...
			$this->setColumnValue('category', $value);

		}

		public function getCategory(){
			# code...
			return $this->getColumnValue('category');
		}

		public function setAdded($value){
			# code...
			$this->setColumnValue('added', $value);

		}

		public function getAdded(){
			# code...
			return $this->getColumnValue('added');
		}

		public function setLastDialed($value){

			$this->setColumnValue('last_dialed_in', $value);

		}

		public function getLastDialed(){

			return $this->getColumnValue('last_dialed_in');
		}

		static function getAllNotDialedIn($startIndex=0, $limit=1000000){
			# code...
			$db = Database::getInstance();
			
			$query = 'SELECT DISTINCT(msisdn) FROM ' . static::$tableName . ' WHERE last_dialed_in < :today ORDER BY added DESC ';
			if(isset($startIndex) && isset($limit)){
				
				$query .= 'LIMIT ' . $startIndex  . ',' . $limit;
			
			}
echo $query;
	$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
	$db->setAttribute(PDO::ATTR_PERSISTENT,TRUE);

			$s = $db->getPreparedStatment($query);
			$condition = array('today'=>'NOW()');

			foreach ($condition as $key => $value) {
			    $condition[':'.$key] = $value; 
			    unset($condition[$key]);
			}

			// echo $query;

			$s->execute($condition);
			$result = $s->fetchAll(PDO::FETCH_ASSOC);

			$collection = array();
			$className = get_called_class();
			foreach($result as $row){
			    $item = new $className();
			    $item->createFromDb($row);
			    array_push($collection,$item);
			}
			return $collection;
		}		


		/*
		**	Get Count of Subscribers under each category that dialed in between a specified TimeFrame
		**	@Variable: $left,$category,$right
		**	Defaul: $left=Beginning of TODAY, $right = Present Time/End of Today
		*/

		static function getCountModified($category, $left, $right){

			$db = Database::getInstance();
			
			$query = "SELECT COUNT(*) FROM " . static::$tableName;
			$query .= ' WHERE last_dialed_in > :left AND last_dialed_in < :right';
			$query .= ' AND category=:cat'; 

			$condition = array('left' => $left, 'right' => $right, 'cat'=> $category);

			// echo $query;
			// print_r($condition);
			// Utils::trace($query);

			$s = $db->getPreparedStatment($query);
			$s->execute($condition);
			// print_r($s);
			$countArr = $s->fetch();
			return $countArr[0];
		}

		 
	}

?>