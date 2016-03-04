<?php

class UnitType {
	private $_db;
	private $_user;
	private $_name;
	
	public function __construct($name){
		$this->_db = STOCK_DB::getInstance();
		if(!$this->_user){
			$this->_user = new User();
		}	
		$data = $this->_db->get('UnitType', ['UnitName', '=', $name])->first();
		$this->_name = $data->UnitName;
	}
	
	public function get(){
		return $this->_name;
	}

	public function set($name){
		$this->_unit->update('UnitType', ['UnitName', '=', $this->_name]);	
	}

	public static function exists($name){
		$db = STOCK_DB::getInstance();
		if($this->_db->get('UnitType', ['UnitName', '=', $name])->count()){
			return true;
		}else{
			return false;
		}
	}
}
