<?php
class Ingredient extends STOCK_DB{
	
	public static function getIngredientByName($recipeId, $name){
		$db = self::getInstance();
		$user = new User();	
		$userId = $user->data()->id;
		$sql = "SELECT `Products`.`productName`, `Products`.`id`, `Products`.`costPerKiloUnit`, `ProductRecipes`.`Recipes_id`, `ProductRecipes`.`quantity`, `ProductRecipes`.`unit`, `Unit`.`Ratio`
			FROM `Products`
			JOIN `ProductRecipes`
			ON `Products`.`id` = `ProductRecipes`.`Products_id`
			AND `Products`.`productName` = ?
			AND `ProductRecipes`.`Recipes_id` = ?
			AND `Products`.`user` = ?
			JOIN `Unit`
			ON `ProductRecipes`.`unit` = `Unit`.`Name`;";						
		if($ingredient = $db->query($sql, [$name, $recipeId, $userId])->results()){
			return $ingredient;
		}else{
			return false;
		}
	}

	public static function getIngredientsByRecipeId($recipeId){
		$db = self::getInstance();
		$user = new User();	
		$userId = $user->data()->id;
		$sql = "SELECT `Products`.`productName`, `Products`.`id`, `Products`.`costPerKiloUnit`, `ProductRecipes`.`Recipes_id`, `ProductRecipes`.`quantity`, `ProductRecipes`.`unit`, `ProductRecipes`.`id`, `Unit`.`Ratio`
			FROM `Products`
			JOIN `ProductRecipes`
			ON `Products`.`id` = `ProductRecipes`.`Products_id`
			AND `ProductRecipes`.`Recipes_id` = ?
			AND `Products`.`user` = ?
			JOIN `Unit`
			ON `ProductRecipes`.`unit` = `Unit`.`Name`;";						
		if($ingredient = $db->query($sql, [$recipeId, $userId])->results()){
			return $ingredient;
		}else{
			return false;
		}
	}
	
	public static function addIngredient($recipeId, $productId, $quantity, $unitName){
		$db = self::getInstance();
		
		if($db->insert('ProductRecipes', [
			'Products_id' => $productId,
			'Recipes_id' => $recipeId,
			'quantity' => $quantity,
			'unit' => $unitName
			]
		)){
			return true;
		}else{
			return false;
		}
	} 

	public static function deleteIngredient($recipeId, $productId){
		$db = self::getInstance();
		$sql = "DELETE FROM `ProductRecipes` WHERE `Products_id` = ? AND Recipes_id = ?;";
		if($db->query($sql, [$productId, $recipeId])){
			return true;
		}else{
			return false;
		}
	}
}
