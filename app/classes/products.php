<?php

class products {
	private $_db,
		$_products,
		$_user,
		$_count;

	public function __construct(){
		$this->_db = STOCK_DB::getInstance();
		if(!$this->_user){
			$this->_user = new User();
		}		
		$data = $this->_db->get('Products', ['id', '>=', 1], $this->_user->data()->id);
		$this->_count = count($data);
		$this->_products = array();
		foreach($data->results() as $result){
			$product = new product($result->id);
			array_push($this->_products, $product);
		}
	}
	
	public function findProduct($id){
		foreach($this->_products as $product){
			if($product->data()->id == $id){
				return $product;
			}
		}
	}
	
	public function getColumn($column_name){
		$list = array();
		foreach($this->_products as $product){
			$list[$product->data()->id] = $product->data()->$column_name;
		}
		return $list;
	}

	public function getProducts(){
		return $this->_products;
	}

	public function count(){
		return $this->_count;
	}
	
	public function addProduct($product){
		if(isset($product) && get_class($product) == 'product'){
			array_push($this->_products, $product);	
			return true;
		}else{
			return false;
		}
	}
}
