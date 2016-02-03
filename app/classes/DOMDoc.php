<?php

class DOMDoc extends SmartDOMDocument{
	public function searchForElementById($id){
		$xpath = new DOMXPath($this);
		// keep the quotes around the classname
		$element = $xpath->query('//*[@id="' . $id . '"]');		
		return $element->item(0);
	}
	
}

?>
