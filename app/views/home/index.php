<?php /*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<p>
	<?php 
		if($data['flash'] == ""){
			echo 'Welcome!';
		}else{
			echo $data['flash']; 
		}
	?>
</p>

<p>
	<a href="login/">Log in here</a>
	 or 
	<a href="register/">Register</a>
</p>


