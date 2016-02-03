<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
//include_once $_SERVER['DOCUMENT_ROOT'] . '/login/mvc/app/includes/sidenav.php';
?>
<div class="main-div">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
?>
<?php
/**********************
	Build the table
***********************/
	$doc = new DOMDoc();
	$doc->preserveWhiteSpace = false;
	$table = new Table(3,3, $doc);
	$doc->loadHTMLFile('../app/boiler_plate.html');
	$doc->formatOutput = true;
	$table = new units_table($doc, $data['user_id']);
	$body = $doc->getElementsByTagName('body')->item(0);
	$body->appendChild($table->getTableElement());
	$doc->formatOutput = true;
	echo $doc->saveXML();
/*****************************
	End building the table
******************************/

?>
