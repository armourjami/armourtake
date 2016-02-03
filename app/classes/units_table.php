<?php

class units_table extends Table{
	private $_db;
	private $_user_id;

	public function __construct($dom, $user_id){
		$this->_db = STOCK_DB::getInstance();						
		$this->_user_id = $user_id;

		//load database content
		$units = $this->_db->get('Unit', ['name', '<>', ''], $this->_user_id);
		$unit_count = $units->count();
		$units = $units->results();

		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'units_table');
		
		//initialize num_rows/num_columns
		$this->num_rows = sizeof($units);
		$this->num_columns = sizeof($units[0]);

		$units_heading = self::$dom->createElement('thead');
		$this->table->appendChild($units_heading);
		$heading_row = self::$dom->createElement('tr');
		$units_heading->appendChild($heading_row);

		$heading = array();
		array_push($heading, self::$dom->createElement('th', 'Unit name'));
		array_push($heading, self::$dom->createElement('th', 'Ratio'));
		array_push($heading, self::$dom->createElement('th', 'Unit type'));
		array_push($heading, self::$dom->createElement('th', ' '));
		
		foreach($heading as $head){
			$heading_row->appendChild($head);
		}

		//create all the cells in the table and fill them with database content
		foreach($units as $unit){
		//create the table row	
			$row = self::$dom->createElement('tr');

		//Name:
			$span = self::$dom->createElement('span', $unit->Name);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $unit->Name . 'name');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Ratio:
			$span = self::$dom->createElement('span', $unit->Ratio);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $unit->Name . 'ratio');
			$cell->appendChild($span);
			$row->appendChild($cell);	

		//Unit type:
			$span = self::$dom->createElement('span', $unit->UnitType);
			$cell = self::$dom->createElement('td');
			$types = $this->_db->get('UnitType', ['UnitName', '<>', '']);
			$types = $types->results();
			$select = self::$dom->createElement('select');
			$select->setAttribute('id', $unit->UnitType . 'UnitType');
			foreach($types as $type){
				$option = self::$dom->createElement('option', $type->UnitName);
				$option->setAttribute('value', $type->UnitName);
				if($type->UnitName == $unit->UnitType){
					$option->setAttribute('selected', '');
				}
				$select->appendChild($option);
			}
			$cell->appendChild($select);	
			$cell->setAttribute('id', $unit->Name . 'untiType');
			$row->appendChild($cell);	

		/****Add in Delete button cell*****/
			$link = self::$dom->createElement('a', 'Delete');
			$a = '/account/unit/';
			$link->setAttribute('href', 'unit/' . $unit->Name);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $unit->Name . 'view');
			$cell->appendChild($link);
			$row->appendChild($cell);

		//Set row attributes
			$row->setAttribute('id', $unit->Name);	
		//Finish row		
			$this->table->appendChild($row);
		}
				

		return $this;
	}
}

?>
