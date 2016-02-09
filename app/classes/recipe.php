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
		$data = $this->_db->join(
			array(//table1, tablejoin, table2 
				 array( 
					'table_name' => 'Products',
					'next_table_name' => 'ProductRecipes',
					'table_column' => 'id',
					'next_table_column' => 'Products_id',
					'selections' => array(
						'productName',
						'costPerKiloUnit',
						'unitName'
					)					 
				 ),      
				 array( 
					'table_name' => 'ProductRecipes', 
					'next_table_name' => 'Recipes',
					'table_column' => 'Recipes_id',
					'next_table_column' => 'id',
					'selections' => array(
						'Products_id',
						'quantity',
						'unit',
					)
				 ),      
				 array(  
					'table_name' => 'Recipes',
					'table_column' => 'id',
					'next_table_name' => null,					
					'next_table_column' => null,
					'selections' => array(
						'recipeName',
						'id',
						'yeild',
						'yeildUnit',
						'method',
						'recipecost'
					),
					'recipeName' => $recipe->recipeName 
				 ),
				array(
					'table_name' => 'Products',
					'next_table_name' => 'Unit',
					'table_column' => 'unitName',
					'next_table_column' => 'Name',
					'selections' => array()
				),
				array(
					'table_name' => 'Unit',
					'next_table_name' => null,
					'table_column' => 'Name',
					'next_table_column' => null,
					'selections' => array(
						'Ratio'
					)
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
	
	public function updateIngredient($product_id, $fields = array()){
		if(!$this->_db->update_recipe($product_id, $this->first()->id, $fields, $this->_user->data()->id)){
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
