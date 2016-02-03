<?php
/*PARAMS: 	name - username
		flash - session flash data
		recipe_name
		yeild
		yeild_unit
		method
		cost
*/
include_once '../app/includes/header.php';
?>
<div class="main-div">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
	$unit = $data['recipe']['yeildUnit'];
	if($data['recipe']['yeildUnit'] == 'Each'){
		$unit = 'portion/servings';
	}
		
?>
	<div class="recipe">
		<h1><?=$data['recipe']['recipeName']?></h1>
		<p>
		<span class="recipe_heading">Yeild:</span> <?php echo $data['recipe']['yeild'] . ' ' . $unit;?>
		<span class="recipe_heading">Cost:</span>
		$ <?=number_format($data['recipe']['recipeCost'], 2)?>
		</p>
		<p>
		<?php 
		foreach($data['ingredients'] as $ingredient):
			$ratio = 0;
			//find Unit ratio
			foreach($data['units'] as $unit){
				if($unit['Name'] == $ingredient['Unit_Name']){
					$ratio = $unit['Ratio'];
				}
			}
			echo $ingredient['quantity'] . " " . $ingredient['Unit_Name'] . "\t\t" .  $ingredient['productName'] . "\t\t$ " . $ratio*$ingredient['quantity']*$ingredient['costPerKiloUnit'] . "\n<br><br>";
		endforeach;
		 ?>
		</p>
		<p>
		<span class="recipe_heading">Method:</span>
		</p>
		<p class="recipe_method">
		<?php
			echo str_replace("&#13;", "\n<br><br>\n", $data['recipe']['method']);
		?>
		</p>
		<p>
		<a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/recipes'; ?>">Back to Recipes</a>
		</p>
	</div>	
<?php
	
?>
