<?php
	if($data['loggedIn'] == 1){
		//Fill in the table with options for the logged in user
?>

<div class="sidenav">
	<ul>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>">Home</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/products'; ?>">Products</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/suppliers'; ?>">Suppliers</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/recipes'; ?>">Recipes</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/dishes'; ?>">Dishes</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/units'; ?>">Units</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/profile'; ?>">View Profile</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/change_password'; ?>">Change Password</a></li>
		<li class="sidenav_li"><a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/update'; ?>">Update user details</a></li>
	</ul>
</div>
<?php
	}else{
		//Remove the nav bar
	}
?>
