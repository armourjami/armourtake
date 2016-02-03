<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<h1>Login failed sorry</h1>
<?php
	if($data){
		echo '<h3>The following errors occured:</h3>';
		echo $data['errors'];
	}
?>
<a href="login">try again</a>
