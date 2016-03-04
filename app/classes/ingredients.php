<?php
class ingredients {
	private $_ingredients;
	private $_db;
	private $_user;

	public function __construct($recipe_id){
		$this->_db = STOCK_DB::getInstance();
		$this->_user = new User();	
		$ingredientUnit = $this->_db->join(
			array(//table1, tablejoin, table2 
				 array( 
					'table_name' => 'ProductRecipes',
					'next_table_name' => 'Unit',
					'table_column' => 'unit',
					'next_table_column' => 'Name',
					'selections' => array(
						'*',
					)					 
				 ),      
				 array( 
					'table_name' => 'Unit', 
					'next_table_name' => null,
					'table_column' => null,
					'next_table_column' => null,
					'selections' => array(
						'Ratio',
					)
				 )      
			)
		, true);//select distinct
		$this->_ingredients = $ingredientUnit->results();

		$recipeInfo = $this->toArray();

		//echo var_dump($recipeInfo);
		//die();

		$ingredients = array();
		foreach($recipeInfo as $ingredient){
			$products = new products();
			$product = $products->findProduct($ingredient['Products_id']);
			$product = $this->_db->get('Products', ['id', '=', $ingredient['Products_id']])->results();
			$product = json_decode(json_encode($product), true);
			$product = $product[0];
			//remove unneccesary fields
			unset($product['user']);
			unset($product['Suppliers_id']);	
			unset($product['purchaseUnitPrice']);
			unset($product['user']);
			unset($product['purchaseUnitWeight']);
			unset($product['purchaseUnit']);
			unset($product['discount']);
			unset($product['density']);
			//append ProductRecipes fields
			$product['quantity'] = $ingredient['quantity'];
			$product['Ratio'] = $ingredient['Ratio'];
			//replace the unitName with ProductRecipes unit
			$product['unitName'] = $ingredient['unit'];
			array_push($ingredients, $product);
			/* final $product:
				id - from Products
				productName - from Products
				yeild - from Products
				costPerKiloUnit - from Products
				unitName - from ProductRecipes
				quantity - from ProductRecipes
				Ratio - from Unit
			*/
		}
		$this->_ingredients = $ingredients;
		
		return $this;
	}

	public function get(){
		return $this->_ingredients;
	}
		
	public function toJson(){
		return json_encode($this->_ingredients);
	}

	private function toArray(){
		return json_decode($this->toJson(),true);
	}
}

