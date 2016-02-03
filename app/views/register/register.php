<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off" value="<?php echo isset($_POST['username'])?$_POST['username']:''; ?>">
	</div>
	<div class="field">
		<label for="name">Enter your name</label> 
		<input type="text" name="name" id="name" value="<?php echo isset($_POST['name'])?$_POST['name']:''; ?>">
	</div>
	<div class="field">
		<label for="sirname">Last Name</label>
		<input type="text" name="sirname" id="sirname">
	</div>
	<div class="field">
		<label for="email">E-mail</label>
		<input type="text" name="email" id="email">
	</div>
	<div class="field">
		<label for="date_of_birth">Date of Birth</label>
		<input type="text" name="date_of_birth" id="date_of_birth">
	</div>
	
	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password">
	</div>
	<div class="field">
		<label for="password_again">Please re-enter your password</label>
		<input type="password" name="password_again" id="password_again">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">
</form>
