<?php

class Date{
	private $_date;
	
	public function __construct($date){//passes in a string
		if(gettype($date) === "string"){
			switch($date){
				case 'now':	$this->_date = new DateTime('now');
						$this->_date->setTimezone(new DateTimezone('Pacific/Auckland'));					
				break;

				case 'tomorrow':$this->_date = new DateTime('tomorrow');
						$this->_date->setTimezone(new DateTimezone('Pacific/Auckland'));					
				break;

				default:
					$date = explode('/', $date);
					$date[2] = ($date[2] > date('y')) ? ($date[2] + 1900) : ($date[2] + 2000);
					if(checkdate($date[1], $date[0], $date[2])){
						$this->_date = new DateTime();
						$this->_date->setTimezone(new DateTimezone('Pacific/Auckland'));					
						$this->_date->setDate($date[2], $date[1], $date[0]);
					}else{
						echo 'There was an error with the date format';
					}
				break;
			}

		}else if($date instanceof DateTime){
			$this->_date = $date;
		}else{
			echo 'Cannot create a new date';
		}

	}	

	public function toString(){
		return $this->_date->format('d/m/Y');	
	}

	public function isBefore($thatDate){
		return $this->_date < $thatDate->getDate() ? true : false;
	}

	public function isAfter($thatDate){
		return $this->_date > $thatDate->getDate() ? true : false;
	}

	public function getDate(){
		return $this->_date;
	}

	public function format($format){
		return $this->_date->format($format);
	}
}

?>
