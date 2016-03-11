<?php

class UnitType extends STOCK_DB{
	public static function exists($name){
		$db = self::getInstance();
		$sql = "SELECT * FROM `UnitType` WHERE `UnitType`.`UnitName` = ?;";
		if($db->query($sql, [$name])->count()){
			return true;
		}else{
			return false;
		}
	}
}
