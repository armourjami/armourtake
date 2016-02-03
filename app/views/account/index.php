<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<div class="main-div">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
?>
<p>
	Welcome back!
</p>
