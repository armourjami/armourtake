<?php
class Supplier extends DBassoc{
        public static function exists($supplierId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "SELECT * FROM `Suppliers` WHERE `Suppliers`.`user` = ? AND `Suppliers`.`id` = ?;";
		if($db->query($sql,[$userId, $supplierId])->count()){
			return true;
		}else{
			return false;
		}
	}

	public static function searchSuppliersByString($string){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$name = "%{$name}%";
		echo $name;
		$sql = "SELECT `Suppliers`.`id`, `Suppliers`.`supplierName`, `Suppliers`.`phoneNumber`,`Suppliers`.`faxNumber`,`Suppliers`.`emailAddress`,`Suppliers`.`address`,`Suppliers`.`cutOffOrderTime`,`Suppliers`.`turnAroundDeliveryTime`, `Suppliers`.`dateOfEntry`,`Suppliers`.`freightCharge`, `Suppliers`.`reliability`, `Suppliers`.`deliveryTime`
		FROM `Suppliers`
		WHERE `Suppliers`.`supplierName` LIKE ?
		AND `Suppliers`.`user` = ?;"; 
		if($suppliers = $db->query($sql,[$string, $userId])){
			return $suppliers->results();
		}
		return false;
	}
	
	public static function toArray(){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "SELECT `Suppliers`.`id`, `Suppliers`.`supplierName`, `Suppliers`.`phoneNumber`,`Suppliers`.`faxNumber`,`Suppliers`.`emailAddress`,`Suppliers`.`address`,`Suppliers`.`cutOffOrderTime`,`Suppliers`.`turnAroundDeliveryTime`, `Suppliers`.`dateOfEntry`,`Suppliers`.`freightCharge`, `Suppliers`.`reliability`, `Suppliers`.`deliveryTime`		
                FROM `Suppliers`
		WHERE `Suppliers`.`user` = ?;";
		if($suppliers = $db->query($sql,[$userId])){
			$suppliers = $suppliers->results();
			return $suppliers;
		}
		return false;
	}

	public static function deleteById($supplierId){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "DELETE FROM `Suppliers` WHERE `Suppliers`.`user` = ? AND `Suppliers`.`id` = ?;";
		if(!$db->query($sql, [$userId, $supplierId])){
			return false;
		}
		return true;
	}       
}
