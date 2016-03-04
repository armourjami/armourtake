<?php

class recipes {
	private $_db,
		$_recipes,
		$_user,
		$_count;

	public function __construct(){
		$this->_db = STOCK_DB::getInstance();
		if(!$this->_user){
			$this->_user = new User();
		}		
		$data = $this->_db->get('Recipes', ['id', '>=', 1], $this->_user->data()->id);
		$this->_count = count($data);
		$this->_recipes = $data->results();

		$recipes = $this->toArray(); 
		for($i = 0; $i < count($recipes); $i++){
			$ingredients = new ingredients($recipes[$i]['id']);
			$recipes[$i]['ingredients'] = $ingredients->get();
			//remove user from the array
			unset($recipes[$i]['user']);
		}
		$this->_recipes = $recipes;
	}

	public function toJson(){
		return json_encode($this->_recipes);
	}

	private function toArray(){
		return json_decode($this->toJson(),true);
	}

	public function get(){
		return $this->_recipes;
	}
		
	public function findRecipe($id){
		$recipes = $this->toArray();
		foreach($recipes as $recipe){
			$recipe['ingredients'] = array();
			if($recipe['id'] == $id){
				$ingredients = new ingredients($id);
				$recipe['ingredients'] = $ingredients->get();
				//echo var_dump($recipe);
				//die();
				return $recipe;
			}
		}
	}
	
	public function getColumn($column_name){
		$list = array();
		foreach($this->_recipes as $recipe){
			array_push($list, $recipe->data()->id);
		}
		return $list;
	}

	public function getRecipes(){
		return $this->_recipes;
	}

	public function count(){
		return $this->_count;
	}
}
