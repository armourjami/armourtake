<?php
//####################################################################################################################
//This class needs to check if it is specific to each logged in user. The query function may be able to do this for us?
//####################################################################################################################

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
		
		if(!$db->insert('ProductRecipes', [
			'Products_id' => $productId,
			'Recipes_id' => $this->_id,
			'quantity' => $quantity,
			'unit' => $unitName
			]
		)){
			return false;
		}
		return true;
	} 
	
	public static function changeIngredientQuantity($recipeId, $productid, $quantity){
		$db = self::getInstance();
		$sql = "UPDATE `ProductRecipes` SET `quantity` = ? WHERE `Recipes_id` = ? AND `Products_id` = ?;";
		if(!$db->query($sql, [$quantity, $recipeId, $productId]){
			return false;
		}
		return true;
	}
	
	public static function changeIngredientUnit($recipeId, $productid, $unit){
		$db = self::getInstance();
		$sql = "UPDATE `ProductRecipes` SET `unit` = ? WHERE `Recipes_id` = ? AND `Products_id` = ?;";
		if(!$db->query($sql, [$quantity, $recipeId, $productId]){
			return false;
		}
		return true;
	}

	public static function deleteIngredient($recipeId, $productId){
		$db = self::getInstance();
		$sql = "DELETE FROM `ProductRecipes` WHERE `Products_id` = ? AND Recipes_id = ?;";
		if(!$db->query($sql, [$productId, $recipeId])){
			return false;
		}
		return true;
	}

	public static function deleteRecipe($recipeId){
		$db = self::getInstance();
		try{
			//delete ingredients first
			$sql = "DELETE FROM `ProductRecipes` WHERE `Recipes_id` = ?;";
			if(!$db->query($sql, [$recipeId])){
				throw new Exception("Could not delete an ingredients from the recipe with id = {$recipeId} \n");
			}	
			//delete Recipe
			$sql = "DELETE FROM `Recipes` WHERE `id` = ?;";
			if(!$db->query($sql, [$recipeId])){
				throw new Exception("Could not delete the recipe with id = {$recipeId} \n");
			}
			return true;	
		}catch (Exception $e){
			if($e->getCode() == 23000){
				echo "There was an error, you will probably need to delete this recipe from a dish\n";
			echo "Caught exception {$e->getMessage()}, \n";
		}finally {
			return false;
		}
	}
}
