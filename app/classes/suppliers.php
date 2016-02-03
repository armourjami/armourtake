<?php
class suppliers {
	private $_db,
		$_suppliers,
		$_results,
		$_user,
		$_count;

	public function __construct(){
		$this->_db = STOCK_DB::getInstance();
		if(!$this->_user){
			$this->_user = new User();
		}		
		$data = $this->_db->get('Suppliers', ['id', '>=', 1], $this->_user->data()->id);
		$this->_count = count($data);
		$this->_suppliers = array();
		foreach($data->results() as $result){
			$supplier = new supplier($result->id);
			array_push($this->_suppliers, $supplier);
		}
	}
	
	public function findSupplier($id){
		foreach($this->_suppliers as $supplier){
			if($supplier->data()->id == $id){
				return $supplier;
			}
		}
	}
	
	public function getColumn($column_name){
		$list = array();
		foreach($this->_suppliers as $supplier){
			array_push($list, $supplier->data()->id);
		}
		return $list;
	}

	public function getSuppliers(){
		return $this->_suppliers;
	}

	public function count(){
		return $this->_count;
	}
	
	public function addSupplier($supplier){
		if(isset($supplier) && get_class($supplier) == 'supplier'){
			array_push($this->_suppliers, $supplier);	
			return true;
		}else{
			return false;
		}
	}
}
