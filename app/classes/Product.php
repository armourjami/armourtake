<?php
class Product extends STOCK_DB{
	
	public static function exists($productId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "SELECT * FROM `Products` WHERE `Products`.`user` = ? AND `Products`.`id` = ?;";
		if($db->query($sql,[$userId, $productId])->count()){
			return true;
		}else{
			return false;
		}
	}

	public static function searchProductsByString($string){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$name = "%{$name}%";
		echo $name;
		$sql = "SELECT `Products`.`id`, `Products`.`productName`, `Products`.`purchaseUnit`,`Products`.`purchaseUnitPrice`,`Products`.`purchaseUnitWeight`,`Products`.`yeild`,`Products`.`costPerKiloUnit`,`Products`.`density`, `Products`.`discount`,`Products`.`Suppliers_id`
		FROM `Products`
		WHERE `Products`.`productName` LIKE ?
		AND `Products`.`user` = ?;"; 
		if($products = $db->query($sql,[$string, $userId])){
			return $products->results();
		}
		return false;
	}
	
	public static function toArray(){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "SELECT `Products`.`id`, `Products`.`productName`, `Products`.`purchaseUnit`,`Products`.`purchaseUnitPrice`,`Products`.`purchaseUnitWeight`,`Products`.`yeild`,`Products`.`costPerKiloUnit`,`Products`.`density`, `Products`.`discount`,`Products`.`Suppliers_id`
		FROM `Products`
		WHERE `Products`.`user` = ?;";
		if($products = $db->query($sql,[$userId])){
			$products = $products->results();
			return json_decode(json_encode($products),true);
		}
		return false;
	}

	public static function deleteById($productId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "DELETE FROM `Products` WHERE `Products`.`user` = ? AND `Products`.`id` = ?;";
		if(!$db->query($sql, [$userId, $productId])){
			return false;
		}
		return true;
	}

		
}
