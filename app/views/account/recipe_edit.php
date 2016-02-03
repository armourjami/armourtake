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
		<form method="post" action="/account/update_recipe/">	
			<h1>Recipe</h1>
				<br>
				<input type="hidden" id="recipe_id" name="recipe_id" value="<?php echo $data['recipe']['id']; ?>">
				<label class="recipe_label">
				Recipe title:
				<input type="text" id="recipe_name" name="recipe_name" value="<?php echo $data['recipe']['recipeName'];?>" />
				</label>
				<br><br>
				<label class="recipe_label">
				Yeild: 
				<input type="text" id="recipe_yeild" name="recipe_yeild" value="<?php echo $data['recipe']['yeild'];?>" />
				</label>
				<label class="recipe_label">
				Unit: 
				<select id="recipe_unit" name="recipe_unit">
				<?php
				$selected = '';
				foreach($data['units'] as $unit):
					if($unit['Name'] == $data['recipe']['yeildUnit']){$selected = ' selected';}
				?>
				<option value="<?=$unit['Name']?>"<?=$selected?>><?=$unit['Name'];?></option>
				<?php 
				$selected = '';
				endforeach;
				 ?>
				</select>
				</label>

				<label class="recipe_label">
				Cost: 
				$<input type="text" readOnly="true" id="recipeCost" name="recipeCost" value="<?=number_format($data['recipe']['recipeCost'], 2)?>"\>
				<input type="hidden" id="recipe_cost" name="recipe_cost" value="<?=$total?>">
				</label>
				<label class="recipe_label">
				<?php 
				$ratio = 0;
				for($i = 0; $i<count($data['units']); $i++){
					if($data['units'][$i]['Name'] == $data['recipe']['yeildUnit']){
						$ratio = $data['units'][$i]['Ratio'];
					}
				}	
				?>
				Cost per <?=$data['recipe']['yeildUnit'];?>: $<?=number_format(($data['recipe']['recipeCost'] / $data['recipe']['yeild'])*$ratio, 2);?> 
				<label class="recipe_label">
				<br><br>

<!--Ingredients list begins here-->
			<?php 
			$item_number = 1;
			foreach($data['ingredients'] as $ingredient):
			?>
<!--Item <?=$item_number?> Product id <?=$ingredient['Products_id']?>-->
				<input type="text" id="quantity<?=$ingredient['Products_id']?>" name="quantity<?=$ingredient['Products_id']?>" value="<?=$ingredient['quantity']?>" />
				
				<!--Units dropdown-->
				<select id="unit<?=$ingredient['Products_id']?>" name="unit<?=$ingredient['Products_id']?>">
				<?php 
				$current_unit = '';
				foreach($data['units'] as $unit): 
					$selected = '';
					if($unit['Name'] == $ingredient['Unit_Name']){
						$current_unit = $unit['Ratio'];
						$selected = ' selected';
					} ?>
						<option value="<?=$unit['Name']?>"<?=$selected?>><?=$unit['Name']?></option>
					<?php unset($selected); 
				endforeach;
				?>
				</select>
				<?php $selected = '';?>

				<!--Product name drop down -->
				<input type="text" readOnly=true id="name<?=$ingredient['Products_id']?>" name="name<?=$ingredient['Products_id']?>" value="<?=$ingredient['productName']?>">

				$ <input type="text" readOnly="true" id="ingredient_cost<?=$item_number?>" name="ingredient_cost<?=$item_number?>" value="<?=number_format($ingredient['costPerKiloUnit']*$current_unit,2)?>">
				Total: $
				<input type="text" id="cost<?=$ingredient['Products_id']?>" name="cost<?=$ingredient['Products_id']?>" readOnly="true" value="<?=number_format($ingredient['costPerKiloUnit'] * $ingredient['quantity']*$current_unit,2)?>" />
				<button id="delete<?=$item_number?>" name="delete<?=$item_number?>">Delete</button>

				<br>
				<br>
			<?php 
			$item_number++;
			endforeach;
			 ?>				
<!--Ingredients list ends here-->

				<br>
				<br>
<!--Method-->
				Method:<br>
				<textarea class="method" rows=10 cols=100 id="recipe_method" name="recipe_method"><?php echo $data['recipe']['method'];?></textarea>
				</label>
<!--Buttons-->
				<input type=submit value="Update" class="recipe_buttons">
				<!--Cancel the action-->
				<input type=submit value="cancel" class="recipe_buttons">
				<!--Delete the entry-->
				<input type=submit value="Delete" class="recipe_delete">
		</form>
		<p class="goback">
			<a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/recipes'; ?>">Back to Recipes</a>
		</p>
		<!--This is just me playing around with APIS-->
		<?php
			$maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode('disneyland, CA'); 
			$maps_json = file_get_contents($maps_url);
			$maps_array = json_decode($maps_json, true);
			$lat = $maps_array['results'][0]['geometry']['location']['lat'];	
			$lng = $maps_array['results'][0]['geometry']['location']['lng'];	
			$instagram_url = 'https://api.instagram.com/v1/media/search?lat=' . $lat . '&lng=' . $lng . '&access_token=887c0986e56a46e79306e84e4251bf71';
			$instagram_url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=294189837.c3e5a6d.536a8d5f9cf94a0482fb6a69df944df3';
			$instagram_json = file_get_contents($instagram_url);
			$instagram_array = json_decode($instagram_json, true);	
			$image_url = $instagram_array['data'][0]['images']['low_resolution']['url'];
			echo '<img src="' . $image_url . '"\>';
			echo var_dump($image_url);
			//code=294189837.c3e5a6d.536a8d5f9cf94a0482fb6a69df944df3
		?>
	</div>	
<?php
	
?>
