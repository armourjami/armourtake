<?php
class Table extends DOMNode{
	protected $table;
	protected static $dom;
	protected $num_cells;
	protected $num_rows;

	public function __construct($rows, $columns, $dom){
		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'table');
		self::$dom->appendChild($this->table);
		
		//initialize num_rows/num_columns
		$this->num_rows = $rows;
		$this->num_columns = $columns;

		//create all the cells in the table
		for($i = 0; $i < $rows; $i++){
			$row = self::$dom->createElement('tr');
			for($j = 0; $j < $columns; $j++){
				$cell = self::$dom->createElement('td');
				$cell->setAttribute('id', 'row' . $i . 'cell' . $j);
				$row->appendChild($cell);	
			}
			$row->setAttribute('id', 'row' . $i);	

			//append the row to the table
			$dom->searchForElementById('table')->appendChild($row);
		}
		return $this;
	}

	public function addRow($data = null){
		//create the new row
		$new_row = self::$dom->createElement('tr');
		$new_row->setAttribute('id', 'row' . $this->num_rows); 

		//loop through the data or just data as blank spaces
		if(is_array($data)){
			$array_number = 0;
			for($i = 0; $i < sizeof($data); $i++){
				$cell = self::$dom->createElement('td', $data[$i]);
				$cell->setAttribute('id', 'row' . $this->num_rows . 'cell' . $i);
				$new_row->appendChild($cell);
			}
		}else if(get_class($data) == 'DOMElement'){
			$table = self::$dom->searchForElementById('table');
			$table->appendChild($data);
			return;
		}else if(!isset($data)){
			for($i = 0; $i < $this->num_columns; $i++){
				$cell = self::$dom->createElement('td');
				$cell->setAttribute('id', 'row' . $this->num_rows . 'cell' . $i);
				$new_row->appendChild($cell);
			}				
		}

		//add the row to the end of table
		$tables = self::$dom->getElementsByTagName('table');
		foreach($tables as $table){
			if('table' == $table->getAttribute('id')){
				$table->appendChild($new_row);
			}
		}
		$this->num_rows++;
	}

	public function deleteRow($id){
		//find the element by its id
		$rows = self::$dom->getElementsByTagName('tr');
		$row = self::$dom->searchForElementById($id);
		//delete the element
		$row->parentNode->removeChild($row);
		$this->num_rows--;
	}
	
	public function numRows(){
		return $this->num_rows;
	}

	public function numColumns(){
		return $this->num_columns;
	}

	public function getTableElement(){
		return $this->table;
	} 
	
	public function getRowById($id){
		if($element = self::$dom->searchForElementById($id)){
			return $element;
		}else{
			return false;
		}
	}
		
}

