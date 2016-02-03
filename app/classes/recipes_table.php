<?php

class recipes_table extends Table{
	private $_db;
	private $_user_id;

	public function __construct($dom, $user_id){
		$this->_db = STOCK_DB::getInstance();						
		$this->_user_id = $user_id;

		//load database content
		$recipes = $this->_db->get('Recipes', ['id', '>=', '1'], $this->_user_id);
		$recipe_count = $recipes->count();
		$recipes = $recipes->results();

		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'recipes_table');
		
		//initialize num_rows/num_columns
		$this->num_rows = sizeof($recipes);
		$this->num_columns = sizeof($recipes[0]);

		$recipes_heading = self::$dom->createElement('thead');
		$this->table->appendChild($recipes_heading);
		$heading_row = self::$dom->createElement('tr');
		$recipes_heading->appendChild($heading_row);

		$heading = array();
		array_push($heading, self::$dom->createElement('th', 'Recipe name'));
		array_push($heading, self::$dom->createElement('th', 'Yeild'));
		array_push($heading, self::$dom->createElement('th', 'Cost'));
		array_push($heading, self::$dom->createElement('th', ' '));
		array_push($heading, self::$dom->createElement('th', ' '));
		
		foreach($heading as $head){
			$heading_row->appendChild($head);
		}

		//create all the cells in the table and fill them with database content
		foreach($recipes as $recipe){
		//create the table row	
			$row = self::$dom->createElement('tr');

		//Name:
			$span = self::$dom->createElement('span', $recipe->recipeName);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $recipe->id . 'name');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Yeild:
			$span = self::$dom->createElement('span', $recipe->yeild);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $recipe->id . 'yeild');
			$cell->appendChild($span);
			$text = $recipe->yeildUnit;
			switch($text){
				case 'Volume': $text = ' L';
				case 'Weight': $text = ' Kg';
				case 'Each' : $text = ' Portion/Serving';
			}
			if($recipe->yeild > 1){
				$text .= 's';
			}
			$text = self::$dom->createTextNode($text);
			$cell->appendChild($text);
			$row->appendChild($cell);	
		//Cost:
			$span = self::$dom->createElement('span', $recipe->recipeCost);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $recipe->id . 'cost');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		/****Add in view button cell*****/
			$link = self::$dom->createElement('a', 'View');
			$a = '/account/recipe/';
			$link->setAttribute('href', 'recipe/' . $recipe->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $recipe->id . 'view');
			$cell->appendChild($link);
			$row->appendChild($cell);
		/****Add in Edit button cell*****/
			$link = self::$dom->createElement('a', 'Edit');
			$a = '/account/recipe/';
			$link->setAttribute('href', 'edit_recipe/' . $recipe->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $recipe->id . 'edit');
			$cell->appendChild($link);
			$row->appendChild($cell);

		//Set row attributes
			$row->setAttribute('id', $recipe->id);	
		//Finish row		
			$this->table->appendChild($row);
		}
				

		return $this;
	}
}

?>
