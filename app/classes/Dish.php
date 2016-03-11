<?php
//####################################################################################################################
//Dish manipulation class
//
//####################################################################################################################

class Dish extends STOCK_DB{
	//half done
	public static function toArray($dishId = null){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;

		$sql = "SELECT `id`, `dishName`, `costPrice`, `salePrice`, `yeild` 	
			FROM `Dishes` WHERE ";
		$sql .= $dishId !== null ? "`id` = ? AND " : " ";
		$sql .=	"user = ?;";
		if($dishId !== null){
			
			if($dish = $db->query($sql, [$dishId, $userId])){
				$dish = json_decode(json_encode($dish->results()),true)[0];
				$dish['ingredients'] = json_decode(json_encode(Component::getComponentsByDishId($dishId)),true);
				return $dish;
			}else{
				return false;
			}
		}else{
			if($dishes = $db->query($sql, [$userId])){
				return json_decode(json_encode($dishes->results()), true);
			}else{
				return false;
			}
		}
	}
	
	//done
	public static function exists($dishId){
		$db = self::getInstance();
		$user = new User();
		$userId->data()->id;

		if( $db->get('Dishes', ['id', '=', $dishId])->count() >= 1 ){
			return true;
		}else{
			return false;
		}
	}

	public static function getComponentsByName($dishId, $name){
		$db = self::getInstance();
		$user = new User();
		$userId->data()->id;

		if($ingredients = Component::getComponentsName($dishId, $name)){
			return $ingredients;
		}else{
			return false;
		}
	}

	
	public static function addIngredient($dishId, $productId, $quantity, $unitName){
		$db = self::getInstance();
		$user = new User();
		$userId->data()->id;

		if(!$db->insert('ProductDishs', [
			'Products_id' => $productId,
			'Dishs_id' => $dishId,
			'quantity' => $quantity,
			'unit' => $unitName
			]
		)){
			return false;
		}
		return true;
	} 
	
	public static function changeIngredientQuantity($dishId, $productid, $quantity){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "UPDATE `ProductDishs` SET `quantity` = ? WHERE `user` = ? AND `Dishs_id` = ? AND `Products_id` = ?;";
		if(!$db->query($sql, [$quantity, $userId, $dishId, $productId])){
			return false;
		}
		return true;
	}
	
	public static function changeIngredientUnit($dishId, $productid, $unit){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "UPDATE `ProductDishs` SET `unit` = ? WHERE `user` = ? AND `Dishs_id` = ? AND `Products_id` = ?;";
		if(!$db->query($sql, [$quantity, $userId, $dishId, $productId])){
			return false;
		}
		return true;
	}

	public static function deleteIngredient($dishId, $productId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "DELETE FROM `ProductDishs` WHERE `user` = ? AND `Products_id` = ? AND `Dishs_id` = ?;";
		if(!$db->query($sql, [$userId, $productId, $dishId])){
			return false;
		}
		return true;
	}

	public static function deleteDish($dishId){
		$db = self::getInstance();
		$user = new User();
		$userId->data()->id;
		try{
			//delete ingredients first
			$sql = "DELETE FROM `ProductDishs` WHERE `user` = ? AND `Dishs_id` = ?;";
			if(!$db->query($sql, [$userId, $dishId])){
				throw new Exception("Could not delete an ingredients from the dish with id = {$dishId} \n");
			}	
			//delete Dish
			$sql = "DELETE FROM `Dishs` WHERE `user` = ? AND `id` = ?;";
			if(!$db->query($sql, [$userId, $dishId])){
				throw new Exception("Could not delete the dish with id = {$dishId} \n");
			}
			return true;	
		}catch (Exception $e){
			if($e->getCode() == 23000){
				echo "There was an error, you will probably need to delete this dish from a dish\n";
				echo "Caught exception {$e->getMessage()}, \n";
			}
		}finally {
			return false;
		}
	}
}
