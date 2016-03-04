<?php
class Recipe extends STOCK_DB{
	
	private $_id;

	public function __construct($recipeId){
		$db = self::getInstance();
		if(self::exists($recipeId)){
			$this->_id = $recipeId;
		}
	}

	public function getId(){
		return $this->_id;
	}

	public function toArray(){
		$db = self::getInstance();
		$sql = "SELECT `id`, `yeild`, `yeildUnit`, `method`, `recipeName`, `recipeCost`	
			FROM `Recipes`
			WHERE `id` = ?;";
		if($recipe = $db->query($sql, [$this->_id])){
			$recipe = json_decode(json_encode($recipe->results()),true)[0];
			$recipe['ingredients'] = json_decode(json_encode(self::getIngredients()),true);
			return $recipe;
		}else{
			return false;
		}
	}
	
	public static function exists($recipeId){
		$db = self::getInstance();
		if( $db->get('Recipes', ['id', '=', $recipeId])->count() >= 1 ){
			return true;
		}else{
			return false;
		}
	}

	public function getIngredientsByName($name){
		if($ingredients = Ingredient::getIngredientByName($this->_id, $name)){
			return $ingredients;
		}else{
			return false;
		}
	}

	public function getIngredients(){
		if($ingredients = Ingredient::getIngredientsByRecipeId($this->_id)){
			return $ingredients;
		}else{
			return false;
		}
	}
	
	public static function addIngredient($productId, $quantity, $unitName){
		$db = self::getInstance();
		
		if($db->insert('ProductRecipes', [
			'Products_id' => $productId,
			'Recipes_id' => $this->_id,
			'quantity' => $quantity,
			'unit' => $unitName
			]
		)){
			return true;
		}else{
			return false;
		}
	} 

	public static function deleteIngredient($productId){
		$db = self::getInstance();
		$sql = "DELETE FROM `ProductRecipes` WHERE `Products_id` = ? AND Recipes_id = ?;";
		if($db->query($sql, [$productId, $this->_id])){
			return true;
		}else{
			return false;
		}
	}
}
