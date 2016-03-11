<?php
class Component extends STOCK_DB{
	public static function getRecipeComponentByName($dishId, $name){
		$db = self::getInstance();
		$user = new User();	
		$userId = $user->data()->id;
		$sql = "SELECT `Dishes`.`id`, `Recipes`.`recipeName`, `Recipes`.`recipeCost`, `Recipes`.`yeild`, `Recipes`.`yeildUnit`, `DishRecipes`.`quantity`, `DishRecipes`.`unit`, `Unit`.`Ratio`
			FROM `Dishes`
			JOIN `DishRecipes`
			ON `Dishes`.`id` = `DishRecipes`.`Dishes_id`
			AND `DishRecipes`.`Dishes_id` = ?
			AND `Dishes`.`user` = ?
			JOIN `Recipes`
			ON `DishRecipes`.`Recipes_id` = `Recipes`.`id`
			AND `Recipes`.`recipeName` = ?
			JOIN `Unit`
			ON `DishRecipes`.`unit` = `Unit`.`Name`;";						
		if($component = $db->query($sql, [$dishId, $userId, $name])->results()){
			return $component;
		}else{
			return false;
		}
	}

	public static function getComponentsByDishId($dishId){
		$db = self::getInstance();
		$user = new User();	
		$userId = $user->data()->id;
		$sql = "SELECT `Dishes`.`id`, `Recipes`.`recipeName`, `Recipes`.`recipeCost`, `Recipes`.`yeild`, `Recipes`.`yeildUnit`, `DishRecipes`.`quantity`, `DishRecipes`.`unit`, `Unit`.`Ratio`
			FROM `Dishes`
			JOIN `DishRecipes`
			ON `Dishes`.`id` = `DishRecipes`.`Dishes_id`
			AND `DishRecipes`.`Dishes_id` = ?
			AND `Dishes`.`user` = ?
			JOIN `Recipes`
			ON `DishRecipes`.`Recipes_id` = `Recipes`.`id`
			JOIN `Unit`
			ON `DishRecipes`.`unit` = `Unit`.`Name`;";						
		if($ingredient = $db->query($sql, [$dishId, $userId])->results()){
			return $ingredient;
		}else{
			return false;
		}
	}
	
	public static function changeQuantityByRecipeId($dishId, $recipeId, $newQuantity){
		$db = self::getInstance();
		$user = new User();	

		$sql = "UPDATE `DishRecipes` SET `DishRecipes`.`quantity` = ? WHERE `DishRecipes`.`Dishes_id` = ? AND `DishRecipes`.`Recipes_id` = ? AND `DishRecipes`.`user` = ?;";
		if($db->query($sql,[$newQuantity, $dishId, $recipeId, $userId])){
			return true;
		}else{
			return false;
		}	
	}

	public static function changeUnitByRecipeId($dishId, $recipeId, $newUnit){
		if(Unit::exists($newUnit) && Recipe::exists($recipeId)){
			$db = self::getInstance();
			$user = new User();	

			$sql = "UPDATE `DishRecipes` SET `DishRecipes`.`unit` = ? WHERE `DishRecipes`.`Dishes_id` = ? AND `DishRecipes`.`Recipes_id` = ? AND `DishRecipes`.`user` = ?;";
			if($db->query($sql,[$newUnit, $dishId, $recipeId, $userId])){
				return true;
			}else{
				return false;
			}	
		}else{
			return false;
		}
	}
	
	public static function addComponent($dishId, $recipeId, $quantity, $unitName){
		if(Unit::exists($newUnit) && Recipe::exists($recipeId)){
			$db = self::getInstance();
			
			if($db->insert('DishRecipes', [
				'Dishes_id' => $dishId,
				'Recipes_id' => $recipeId,
				'quantity' => $quantity,
				'unit' => $unitName
				]
			)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} 

	public static function deleteComponent($dishId, $recipeId){
		$db = self::getInstance();
		$sql = "DELETE FROM `DishRecipes` WHERE `Recipes_id` = ? AND Dishes_id = ?;";
		if($db->query($sql, [$recipeId, $dishId])){
			return true;
		}else{
			return false;
		}
	}
}
