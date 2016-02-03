<?php

class Redirect{
	public static function to($location = null){
		if($location){
			if(is_numeric($location)){
				switch($location){
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/404.php';
					break;
				}	
			}

			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			header("Location: $uri/$location");
			exit();	
		}				
	}
}

?>
