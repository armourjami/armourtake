<?php
class recipe {
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
		$recipe = $this->_db->get('Recipes', ['id', '=', $id], $this->_user->data()->id);
                $recipe = $recipe->first();	
		$this->_data = array($recipe);
		$data = $this->_db->join(array( 
			 array( 
				 'name' => 'Products'     
			 ),      
			 array( 
				 'name' => 'ProductRecipes', 
			 ),      
			 array(  
				 'name' => 'Recipes',
				 'recipeName' => $recipe->recipeName 
			 )       
		)); 
		if(count($data)){
			$this->_data = $data->results();
			return true;
		}
		return false;
	}
	
	public function findIngredient($id){
		foreach($this->_data as $ingredient){
			if($ingredient->id == $id){
				return $ingredient;
			}
		}
	}
	
	public function updateIngredient($pid, $rid, $fields = array()){
		if(!$this->_db->update_recipe($pid, $rid, $fields, $this->_user->data()->id)){
			throw new Exception('Could not update Ingredient');
		}
	}

	public function update($fields = array()){
		if(!$this->_db->update('Recipes', $this->first()->id, $fields, $this->_user->data()->id)){
			throw new Exception('Could not update Recipe');
		}
	}

	public function create($fields){
		if(count($fields) == 10){
			$fields['id'] = null;
			if(!$this->_db->insert('Recipes', $fields, $this->_user->data()->id)){
				throw new Exception('Could not create new Recipe');
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

	public function first(){
		return $this->_data[0];
	}
 }
