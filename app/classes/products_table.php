<?php

class products_table extends Table{
	private $_db,
		$_user_id,
		$_products;

	public function __construct($dom){
		$this->_db = STOCK_DB::getInstance();						
		$user = new User();
		$this->_user_id = $user->data()->id;

		//load database content
		$this->_products = new products();

		//set the root document
		self::$dom = $dom;
		
		//create the table and add it to the dom
		$this->table = self::$dom->createElement('table');
		$this->table->setAttribute('id', 'products_table');
		
		//initialize num_rows/num_columns
		$this->num_rows = $this->_products->count();
		$this->num_columns = sizeof($this->_products->getProducts()[0]);

		$products_heading = self::$dom->createElement('thead');
		$this->table->appendChild($products_heading);
		$heading_row = self::$dom->createElement('tr');
		$products_heading->appendChild($heading_row);

		$heading = array();
		array_push($heading, self::$dom->createElement('th', 'Product Name'));
		array_push($heading, self::$dom->createElement('th', 'Order by'));
		array_push($heading, self::$dom->createElement('th', 'Supplier'));
		array_push($heading, self::$dom->createElement('th', 'Cost per kilo/litre'));
		array_push($heading, self::$dom->createElement('th', ' '));
		
		foreach($heading as $head){
			$heading_row->appendChild($head);
		}

		//create all the cells in the table and fill them with database content
		foreach($this->_products->getProducts() as $product){
		//create the table row	
			$row = self::$dom->createElement('tr');

		//Name:
			$span = self::$dom->createElement('span', $product->data()->productName);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $product->data()->id . 'name');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Purchase Unit:
			$span = self::$dom->createElement('span', $product->data()->purchaseUnit);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $product->data()->id . 'purchaseUnit');
			$cell->appendChild($span);
			$row->appendChild($cell);	
		//Supplier:
			$supplier = $this->_db->get('Suppliers', ['id', '=', $product->data()->Suppliers_id], $this->_user_id);
			$span = self::$dom->createElement('span', $supplier->first()->supplierName);
			$cel = self::$dom->createElement('td');
			$cel->setAttribute('id', $product->data()->id . 'supplier');
			$cel->appendChild($span);
			$row->appendChild($cel);	
		//Cost per kilo/litre:
			$span = self::$dom->createElement('span', $product->data()->costPerKiloUnit);
			$ce = self::$dom->createElement('td');
			$ce->setAttribute('id', $product->data()->id . 'costPerKiloUnit');
			$ce->appendChild($span);
			$suffix = self::$dom->createTextNode('kilo/litre');
			$ce->appendChild($suffix);
			$row->appendChild($ce);	
		/****Add in Edit button cell*****/
			$button = self::$dom->createElement('input');
			$button->setAttribute('type', 'submit');
			$button->setAttribute('value', 'Edit/Delete');
			$button->setAttribute('class', 'button');
			$button->setAttribute('id', 'button' . $product->data()->id);
			$cell = self::$dom->createElement('td');
			$cell->setAttribute('id', $product->data()->id . 'edit');
			$cell->appendChild($button);
			$row->appendChild($cell);
		//Set row attributes
			$row->setAttribute('id', $product->data()->id);	
		//Finish row		
			$this->table->appendChild($row);
		}
				

		return $this;
	}
}

?>
