<?php

class suppliers_table extends Table{
	private $_db,
		$_user_id,
		$_suppliers;

	public function __construct($dom, $user_id){
		$this->_db = STOCK_DB::getInstance();						
		$user = new User();
		$this->_user_id = $user->data()->id;

		//load database content
		$this->_suppliers = new suppliers();
		
		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'supplier_table');
		
		//initialize num_rows/num_columns
		$this->num_rows = $this->_suppliers->count();
		$this->num_columns = sizeof($this->_suppliers->getSuppliers()[0]);

		//Draw the supplier heading
		$suppliers_heading = self::$dom->createElement('thead');
		$this->table->appendChild($suppliers_heading);
		$heading_row = self::$dom->createElement('tr');
		$suppliers_heading->appendChild($heading_row);

		$heading = array();
		array_push($heading, self::$dom->createElement('th', 'Supplier Name'));
		array_push($heading, self::$dom->createElement('th', 'Phone Number'));
		array_push($heading, self::$dom->createElement('th', 'Fax Number'));
		array_push($heading, self::$dom->createElement('th', 'Email'));
		array_push($heading, self::$dom->createElement('th', ' '));
		
		foreach($heading as $head){
			$heading_row->appendChild($head);
		}

		


		//create all the cells in the table and fill them with database content
		foreach($this->_suppliers->getSuppliers() as $supplier){
		//create the table row	
			$row = self::$dom->createElement('tr');

		//Name:
			$span = self::$dom->createElement('span', $supplier->data()->supplierName);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $supplier->data()->id . 'name');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Phone
			$span = self::$dom->createElement('span', $supplier->data()->phoneNumber);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $supplier->data()->id . 'phone');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Fax
			$span = self::$dom->createElement('span', $supplier->data()->faxNumber);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $supplier->data()->id . 'fax');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Email
			$span = self::$dom->createElement('span', $supplier->data()->emailAddress);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $supplier->data()->id . 'email');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		/****Add in Edit button cell*****/
			$button = self::$dom->createElement('input');
			$button->setAttribute('type', 'submit');
			$button->setAttribute('value', 'Edit/Delete');
			$button->setAttribute('class', 'button');
			$button->setAttribute('id', 'button' . $supplier->data()->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $supplier->data()->id . 'edit');
			$cell->appendChild($button);
			$row->appendChild($cell);
		//Set row attributes
			$row->setAttribute('id', $supplier->data()->id);	
		//Finish row		
			$this->table->appendChild($row);
		}
				

		return $this;
	}
}

?>
