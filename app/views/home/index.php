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
	Armourtake kitchen stocktaking, recipe costing and website CMS
</p>
<p>
	<a href="/armourtake/public/login">Log in here</a>
	 or 
	<a href="/armourtake/public/register/">Register</a>
</p>


