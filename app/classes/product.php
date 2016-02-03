<?php
class product {
	private	$_db,
		$_user,
		$_data;

	public function __construct($id = null, $user = null){
		$this->_db = STOCK_DB::getInstance();
		if(!$this->_user){
			$this->_user = new User();
		}
		if(isset($id)){
			$this->find($id);
			return $this;
		}
	}	

	public function find($id){
		if(isset($id)){
			$data = $this->_db->get('Products', ['id', '=', $id], $this->_user->data()->id);
			if(count($data)){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function findNext($product_id = null){
		//select all using the user id
		$data = $this->_db->get('Products', ['id', '>=', 1], $this->_user->data()->id);
		if(count($data)){
			if(!$product_id){
				//select the first entry	
				$this->_data = $data->first();	
				return true;
			}else{
				//Select the next after $product_id
				for($i = 0; $i < count($data->results()); $i++){
					if($data->results()[$i]->id == $product_id){
						$this->_data = $data->results()[$i + 1];
						return true;
					}
				}
			}	
		}else{
			return false;
		}
	}
	

	public function update($fields = array(), $id){
		if($this->_db->update($fields, $id, $this->_user->data()->id)){
			throw new Exception('Could not update Product');
		}else{
			$this->find($id, $user);
		}
	}

	public function create($fields){
		if(count($fields) == 10){
			$fields['id'] = null;
			if(!$this->_db->insert('Products', $fields, $this->_user->data()->id)){
				throw new Exception('Could not create new Product');
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	public function data(){
		return $this->_data;
	}
 }
