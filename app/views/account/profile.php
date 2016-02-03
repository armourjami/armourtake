<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<p>Name: <?=$data['name'];?></p>
<p>Surname: <?=$data['surname'];?></p>
<p>Username: <?=$data['username'];?></p>
<p>Date of Birth: <?=$data['date_of_birth'];?></p>
<p>Joined: <?=$data['joined'];?></p>
<p>Email: <?=$data['email'];?></p>
<p>Group: <?=$data['group'];?></p>
