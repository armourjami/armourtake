<?php

class dishes_table extends Table{
	private $_db;
	private $_user_id;

	public function __construct($dom, $user_id){
		$this->_db = STOCK_DB::getInstance();						
		$this->_user_id = $user_id;

		//load database content
		$dishs = $this->_db->get('Dishes', ['id', '>=', '1'], $this->_user_id);
		$dish_count = $dishs->count();
		$dishs = $dishs->results();

		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'dishes_table');
		
		//initialize num_rows/num_columns
		$this->num_rows = sizeof($dishs);
		$this->num_columns = sizeof($dishs[0]);

		$dishs_heading = self::$dom->createElement('thead');
		$this->table->appendChild($dishs_heading);
		$heading_row = self::$dom->createElement('tr');
		$dishs_heading->appendChild($heading_row);

		$heading = array();
		array_push($heading, self::$dom->createElement('th', 'Dish name'));
		array_push($heading, self::$dom->createElement('th', 'Retail price'));
		array_push($heading, self::$dom->createElement('th', 'Cost price'));
		array_push($heading, self::$dom->createElement('th', 'Margin'));
		array_push($heading, self::$dom->createElement('th', 'Gross Revenue'));
		array_push($heading, self::$dom->createElement('th', ' '));
		array_push($heading, self::$dom->createElement('th', ' '));
		
		foreach($heading as $head){
			$heading_row->appendChild($head);
		}

		//create all the cells in the table and fill them with database content
		foreach($dishs as $dish){
		//create the table row	
			$row = self::$dom->createElement('tr');

		//Name:
			$span = self::$dom->createElement('span', $dish->dishName);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'name');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Price:
			$span = self::$dom->createElement('span', number_format($dish->dishPrice, 2));
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'dishPrice');
			$text = self::$dom->createTextNode('$ ');
			$cell->appendChild($text);
			$cell->appendChild($span);
			$row->appendChild($cell);	

		//Cost price:
			$span = self::$dom->createElement('span', number_format($dish->costPrice, 2));
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'costPrice');
			$text = self::$dom->createTextNode('$ ');
			$cell->appendChild($text);
			$cell->appendChild($span);
			$row->appendChild($cell);	

		//Margin:
			$span = self::$dom->createElement('span', $dish->margin);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'margin');
			$text = self::$dom->createTextNode('%');
			$cell->appendChild($span);
			$cell->appendChild($text);
			$row->appendChild($cell);	
		//Gross revenue:
			$span = self::$dom->createElement('span', number_format($dish->grossRevenue,2));
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'grossRevenue');
			$text = self::$dom->createTextNode('$ ');
			$cell->appendChild($text);
			$cell->appendChild($span);
			$row->appendChild($cell);	

		/****Add in view button cell*****/
			$link = self::$dom->createElement('a', 'View');
			$a = '/account/dish/';
			$link->setAttribute('href', 'dish/' . $dish->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'view');
			$cell->appendChild($link);
			$row->appendChild($cell);
		/****Add in Edit button cell*****/
			$link = self::$dom->createElement('a', 'Edit/Delete');
			$a = '/account/dish/';
			$link->setAttribute('href', 'dish/' . $dish->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $dish->id . 'edit');
			$cell->appendChild($link);
			$row->appendChild($cell);

		//Set row attributes
			$row->setAttribute('id', $dish->id);	
		//Finish row		
			$this->table->appendChild($row);
		}
				

		return $this;
	}
}

?>
