<?php
//####################################################################################################################
//Recipe manipulation class
//
//####################################################################################################################

class Recipe extends STOCK_DB{
	/*
		Recipe::createRecipe($yeild, $unit, $method, $name, $cost, array(
			array(
				'productId' => $id,
				'quantity' => $quantity,
				'unit' => $unit
			),
			array(
				'productId' => $id,
				'quantity' => $quantity,
				'unit' => $unit

			),
			array(
				'productId' => $id,
				'quantity' => $quantity,
				'unit' => $unit

			)
		));
	*/
	public static function createRecipe($yeild, $yeildUnit, $method, $recipeName, $recipeCost, $ingredients = array()){
		$user = new User();
		$userId = $user->data()->id;
		$db = self::getInstance();

		//first create the recipe
		$sql = "INSERT INTO `Recipes` (`user`, `yeild`, `yeildUnit`, `method`, `recipeName`, `recipeCost`) VALUES ( ?, ?, ?, ?, ?, ?);";
		
		if($db->query($sql, [$userId, $yeild, $yeildUnit, $method, $recipeName, $recipeCost])){
			//then add ingredients	
			$recipeId = $db->getLastInsertId();
			foreach($ingredients as $ingredient){
				Ingredient::addIngredient($recipeId, $ingredient['productId'], $ingredient['quantity'], $ingredient['unit']);		
			}	
			return true;	
		}else{
			return false;
		}
	}

	public static function toArray($recipeId = null){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "SELECT `id`, `yeild`, `yeildUnit`, `method`, `recipeName`, `recipeCost`	
			FROM `Recipes` WHERE";
		$sql .= ($recipeId !== null) ? " `id` = ? AND " : " ";
		$sql .= "user = ?;";
		//individual recipe
		if($recipeId !== null){
			if($recipe = $db->query($sql, [$recipeId, $userId])){
				$recipe = json_decode(json_encode($recipe->results()),true)[0];
				$recipe['ingredients'] = json_decode(json_encode(self::getIngredients($recipeId)),true);
				return $recipe;
			}else{
				return false;
			}
		}else{
		//all recipes
			if($recipe = $db->query($sql, [$userId])){
				$recipes = json_decode(json_encode($recipe->results()),true);
				return $recipes;
			}else{
				return false;
			}
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

	public static function isComponent($recipeId){
		$db = self::getInstance();
		if($db->get('DishRecipes',['Recipes_id', '=', $recipeId])->count()){
			return true;
		}
		return false;
	}

	public static function getIngredientsByName($recipeId, $name){
		if($ingredients = Ingredient::getIngredientByName($recipeId, $name)){
			return $ingredients;
		}else{
			return false;
		}
	}

	public static function getIngredients($recipeId){
		if($ingredients = Ingredient::getIngredientsByRecipeId($recipeId)){
			return $ingredients;
		}else{
			return false;
		}
	}
	
	public static function addIngredient($recipeId, $productId, $quantity, $unitName){
		if(Unit::exists($unitName)){
			$db = self::getInstance();
			
			if(!$db->insert('ProductRecipes', [
				'Products_id' => $productId,
				'Recipes_id' => $recipeId,
				'quantity' => $quantity,
				'unit' => $unitName
				]
			)){
				return false;
			}
			return true;
		}else{
			return false;
		}
	} 
	
	public static function changeIngredientQuantity($recipeId, $productId, $quantity){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "UPDATE `ProductRecipes` SET `quantity` = ? WHERE `user` = ? AND `Recipes_id` = ? AND `Products_id` = ?;";
		if(!$db->query($sql, [$quantity, $userId, $recipeId, $productId])){
			return false;
		}
		return true;
	}
	
	public static function changeIngredientUnit($recipeId, $productId, $unit){
		if(Unit::exists($unit)){
			$db = self::getInstance();
			$user = new User();
			$userId = $user->data()->id;
			$sql = "UPDATE `ProductRecipes` SET `unit` = ? WHERE `user` = ? AND `Recipes_id` = ? AND `Products_id` = ?;";
			if(!$db->query($sql, [$unit, $userId, $recipeId, $productId])){
				return false;
			}
			return true;
		}else{
			return false;
		}
	}

	public static function deleteIngredient($recipeId, $productId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "DELETE FROM `ProductRecipes` WHERE `user` = ? AND `Products_id` = ? AND `Recipes_id` = ?;";
		if(!$db->query($sql, [$userId, $productId, $recipeId])){
			return false;
		}
		return true;
	}

	public static function deleteRecipe($recipeId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		try{
			if(self::isComponent($recipeId)){
				//delete ingredients first
				$sql = "DELETE FROM `ProductRecipes` WHERE `user` = ? AND `Recipes_id` = ?;";
				if(!$db->query($sql, [$userId, $recipeId])){
					throw new Exception("Could not delete an ingredients from the recipe with id = {$recipeId} \n");
				}	
				//delete Recipe
				$sql = "DELETE FROM `Recipes` WHERE `user` = ? AND `id` = ?;";
				if(!$db->query($sql, [$userId, $recipeId])){
					throw new Exception("Could not delete the recipe with id = {$recipeId} \n");
				}
			}else{
				return false;
			}
			return true;	
		}catch (Exception $e){
			if($e->getCode() == 23000){
				echo "There was an error, you will probably need to delete this recipe from a dish\n";
			}
			echo "Caught exception {$e->getMessage()}, \n";
		}finally {
			return false;
		}
	}
}
