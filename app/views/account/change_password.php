<?php
/*PARAMS: 	name - username
		flash - session flash data
		
*/
include_once '../app/includes/header.php';
?>
<div class="main-div">
	<form action="" method="post">
		<div class="field">
			<label for="password_current">Current password</label>
			<input type="password" name="password_current" id="password_current" autocomplete="off">
		</div>
		<div class="field">
			<label for="password_new">New password</label>
			<input type="password" name="password_new" id="password_new" autocomplete="off">
		</div>
		<div class="field">
			<label for="password_new_again">New password again</label>
			<input type="password" name="password_new_again" id="password_new_again" autocomplete="off">
		</div>
		<input type="submit" value="Change">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>
</div>
