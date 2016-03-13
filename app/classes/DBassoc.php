<?php
class DBassoc extends DB{

	public static function getInstance(){
		if(!isset(self::$_instance) || get_class(self::$_instance) !== 'DBassoc'){
			self::$_instance = new DBassoc();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;
			if(count($params)){
				foreach($params as $param){
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}	
		}else{
			$error = $this->_pdo->errorCode();
			echo "Failed o prepare statement, Error ({$error})";
		}
		$q = $this->_query->execute();
		$operation = substr($sql, 0, 6);
		$nonReturningOperation = array('INSERT', 'UPDATE', 'DELETE');
		if($q && !(in_array($operation, $nonReturningOperation))){//Returns results 
			$this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
			$this->_count = $this->_query->rowCount();
		}else if(!$q){//Execution failed
			$this->_error = true;
			$error = $this->_pdo->errorCode();
			echo "Failed to execute, Error ({$error})";
		}//Anything else does not return results so no operation is needed
		
		return $this;
	}
}
