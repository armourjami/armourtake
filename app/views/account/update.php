<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
	<form action="" method="post">
		<div class="field">
			<label for="name">Name</label>
			<input type="text" name="name" value="<?=$data['name']; ?>">
			<br>
			<label for="sirname">Sirname</label>
			<input type="text" name="sirname" value="<?=$data['sirname']; ?>">
			<br>
			<label for="email">E-mail</label>
			<input type="text" name="email" value="<?=$data['email']; ?>">
			<br>


			<input type="submit" value="Update">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		</div>
	</form>
