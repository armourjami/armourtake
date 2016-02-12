<?php
class STOCK_DB {

	private static $_instance = null;
	private $_pdo,
		$_query,
		$_error = false,
		$_results,
		$_count = 0;

	public function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
			$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e) {
			die($e->getMessage());
		}
	}
	
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new STOCK_DB();
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
			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
			$this->_count = $this->_query->rowCount();
		}else if(!$q){//Execution failed
			$this->_error = true;
			$error = $this->_pdo->errorCode();
			echo "Failed to execute, Error ({$error})";
		}//Anything else does not return results so no operation is needed
		
		return $this;
	}

	private function action($action, $table, $where = array(), $user_id = null) {
		$user = new User();
		if(count($where) === 3){
			$operators = array('=', '<', '>', '<=', '>=', '<>');

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND `user` = ?";
				if(!$this->query($sql, array($value, $user->data()->id))->error()){
					return $this;
				}
			}
		}else if($where[0] === 1){
			$sql = "{$action} FROM {$table} WHERE 1 AND `user` = ?";
			if(!$this->query($sql, array($user->data()->id))->error()){
				return $this;
			}
		}
		return false;
	}

	public function join($tables = array(), $distinct = null){
		$user = new User();
	//Set table rules, ANDs etc
		$table_rules = array();
		$final_values = array();
	//Build table rule strings**********************
		$x = 0;
		foreach($tables as $table){
			$table_rules[$x] = '';
			foreach($table as $key => $value){
				if($key !== 'table_name' && $key !== 'next_table_name' && $key !== 'table_column' && $key !== 'next_table_column' && $key !== 'selections'){
					$table_rules[$x] .= " AND ";
					$table_rules[$x] .= "`{$key}` = ?";	
					array_push($final_values, $value);
				}
			}
			$x++;
		}
		array_push($final_values, $user->data()->id);
	//Build field SELECT strings*********************
		$table_selections = array();	

		for($i = 0; $i < count($tables); $i++){	
			//Keep the table name separate for building the select string
			$table_name = $tables[$i]['table_name'];
			$table_selections[$i] = '';
			if(!empty($tables[$i]['selections']) && $tables[$i]['selections'][0] == '*'){
				$table_selections .= "`{$table_name}`.*";
				//Add commer if neccesary
				if(($i + 1) < count($tables[$i])){
						$table_selections[$i] .= ", ";
				}//else end of selections
			}else{
				for($j = 0; $j < count($tables[$i]['selections']); $j++){
					//Create each selection `Products`.`id` for example
					$table_selections[$i] .= "`{$table_name}`.`{$tables[$i]['selections'][$j]}`";
					//Add commer if neccesary
					if(/*($j + 1) < count($tables[$i]['selections']) &&*/ !empty($tables[$i]['selections'][$j])){
						$table_selections[$i] .= ", ";
					}//else end of selections
				}
			}
		}
	//Build the final query**************************
		$sql = "SELECT ";
		$sql .= $distinct ? 'DISTINCT' : '';
		//What fields we are selecting
		for($j = 0; $j < count($table_selections); $j++){
			$sql .= $table_selections[$j];
		}
		$sql = substr($sql, 0, strlen($sql) - 2);//Removes the last ', ' from the selections

		//Join up the tables
		for($i = 0; $i < (count($tables) - 1); $i++){
			if($tables[$i]['next_table_name'] !== null && $tables[$i]['next_table_column'] !== null){	
				if($i == 0){
				$sql .= "FROM `{$tables[$i]['table_name']}` ";
				}
				$sql .= "JOIN `{$tables[$i]['next_table_name']}`  
					ON `{$tables[$i]['table_name']}`.`{$tables[$i]['table_column']}` = `{$tables[$i]['next_table_name']}`.`{$tables[$i]['next_table_column']}`"; 
			}
			$sql .= "{$table_rules[$i]} "; 
		}
		$sql .= "AND `{$tables[0]['table_name']}`.`user` = ?;";
		if(!$this->query($sql, $final_values)->error()){
			return $this;
		}
		
		return false;
	}

	public function get($table, $where, $user_id = null){
		return $this->action('SELECT *', $table, $where, $user_id);
	}
	
	public function getOneOfEach($table, $where, $user_id = null){
		return $this->action('SELECT DISTINCT *', $table, $where, $user_id);
	}

	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}

	public function error(){
		return $this->_error;
	}

	public function insert($table, $fields = array(), $user_id){
		//add the user to the field array so it is generated in the sql statement
		$fields['user'] = $user_id;
		$keys = array_keys($fields);
		$values = null;
		$x = 1;

		foreach($fields as $field){
			$values .= "?";
			if($x < count($fields)){
				$values .= ', ';
			}
			$x++;
		}
		$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values});";
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;
	}

	public function update($table, $id, $field, $user_id){
		$set = '';
		$x = 1;
		//add the user to the field array so it is generated in the sql statement
		//$field['user'] = $user_id;
		foreach($field as $name => $value){
			$set .= "{$name} = ?";
			if($x < count($field)){
				$set .= ', ';
			}
			$x++;
		}
		$sql = "UPDATE {$table}  SET {$set} WHERE id = {$id} AND user = {$user_id};";
		if(!$this->query($sql, $field)->error()){
			return true;
		}
		return false;
		
	}

	public function update_recipe($products_id, $recipes_id, $field, $user_id){
		echo "recipe id " . $recipes_id;
		$set = '';
		$x = 1;
		//add the user to the field array so it is generated in the sql statement
		foreach($field as $name => $value){
			$set .= "{$name} = ?";
			if($x < count($field)){
				$set .= ', ';
			}
			$x++;
		}
		$sql = "UPDATE `ProductRecipes`  SET {$set} WHERE Recipes_id = {$recipes_id} AND Products_id = {$products_id} AND user = {$user_id};";

		echo $sql;
		if(!$this->query($sql, $field)->error()){
			return true;
		}
		return false;
	}

	public function results(){
		//returns an array of objects with properties attached. These can be accessed by using $this->_results[0]->propertyname
		//this is set in the query function using the PDO::FETCH_OBJ
		return $this->_results;
	}

	public function first(){
		if(sizeof($this->results())){
			return $this->results()[0];
		}else{
			return null;
		}
	}
	public function count(){
		return $this->_count;
	}
	
}
