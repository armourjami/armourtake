<?php

class Unit extends STOCK_DB{
	public static function toArray(){
		$db = STOCK_DB::getInstance();
		$user = new User();
		$userId = $user->data()->id;
	
		$sql = "SELECT `Unit`.`Name`, `Unit`.`Ratio`, `Unit`.`UnitType` FROM `Unit` WHERE `Unit`.`user` = ?;";
		if($units = $db->query($sql, [$userId])){
			return json_decode(json_encode($units->results()),true);
		}
		return false;
	}

	public static function getByName($name){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;

		$sql = "SELECT `Unit`.`Name`, `Unit`.`Ratio`, `Unit`.`UnitType` FROM `Unit` WHERE `Unit`.`Name` = ?;";
		if($unit = $db->query($sql, [$name, $userId])){
			return $unit->results();
		}else{
			return false;
		}	
	}

	public static function setUnitType($newUnitType){
		if(UnitType::exists($newUnitTye)){
			$db = self::getInstance();
			$user = new User();
			$userId = $user->data()->id;
			$sql = "UPDATE `Unit` SET `Unit`.`UnitType` = ? WHERE `Unit`.`Name` = ? AND `Unit`.`user` = ?;";
			if($db->query($sql, [$newUnitType, $userId])){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public static function setRatio($newRatio){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "UPDATE `Unit` SET `Unit`.`Ratio` = ? WHERE `Unit`.`Name` = ? AND `Unit`.`user` = ?;";
		if($db->query($sql, [$newRatio, $userId])){
			return true;
		}else{
			return false;
		}
	}


	public static function exists($name){
		$db = STOCK_DB::getInstance();
		$user = new User();
		$userId = $user->data()->id;

		$sql = "SELECT * FROM `Unit` WHERE `Unit`.`Name` = ? AND `Unit`.`user` = ?;";
		
		if($db->query($sql, [$name,$userId])->count()){
			return true;
		}else{
			return false;
		}
	}

	public static function deleteUnit($name){
		$db = self::getInstance();
		$user = new User();
		$userId = $user->data()->id;
		$sql = "DELETE FROM `Unit` WHERE `Unit`.`Name` = ? AND `Unit`.`user` = ?;";
		if($db->query($sql, [$name, $userId])){
			return true;
		}else{
			return true;
		}
	}
}
