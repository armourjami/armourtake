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
		$this->_products = $data->results();
	}

	public function toJson(){
		return json_encode($this->_products);
	}

	public function toArray(){
		return json_decode($this->toJson(),true);
	}
	public function findProduct($id){
		$products = $this->toArray();
		foreach($products as $product){
			if($product['id'] == $id){
				return $product;
			}
		}
	}
	
	public function getColumn($column_name){
		$list = array();
		foreach($this->_products as $product){
			$list[$product->id] = $product->$column_name;
		}
		return $list;
	}

	public function getProducts(){
		return $this->_products;
	}

	public function count(){
		return $this->_count;
	}
	
}
