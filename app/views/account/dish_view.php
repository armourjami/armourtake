<?php
/*PARAMS: 	name - username
		flash - session flash data
		dish_name
		dish_price
		dish_cost
		margin
		type
		gross_revenue
*/
include_once '../app/includes/header.php';
?>
<div class="main-div">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
		
?>
	<div class="recipe">
		<h1><?=$data['dish_name']?></h1>
		<p>
			Retail Price: $<?php echo number_format($data['dish_price'], 2);?>
		</p>
		<p>
			Cost Price: $<?php echo number_format($data['dish_cost'], 2);?> 
			Gross Revenue: $<?php echo number_format($data['gross_revenue'], 2)?> 
			Margin: <?php echo number_format($data['margin'], 0)?>%
		</p>
		<ul>
			<li>List of recipes</li>
			<li>This is the list</li>
			<li>conitnueing the list</li>
		</ul>
	</div>	
<?php
	
?>
