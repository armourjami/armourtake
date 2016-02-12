<div class="main-div" ng-app="armourtake">
<div id="modal">
	<div id="modalMask">
	</div>
	<div id="modalContent">
		<form class="edit-form">
			<fieldset ng-controller="productTableController as productsCtrl">
							<label> <span>Name</span>
								<select id="new-product" ng-model="productsCtrl.new" ng-options="product.productName for product in productsCtrl.products track by product.id" ></select>
							</label>
							
							<label>
								<span>&nbsp;</span>
								<input type="button" id="add-ingredient-to-recipe" value="Add ingredient">
								<input type="button" id="closeModal" value="Cancel">
							</label> 	
				</fieldset>
		</form>
	</div>
</div>

	<p><?=$data['flash']?></p>
	<!--Load the recipe table data-->
	<script type="text/javascript">
		var json = '<?=$data['recipe']?>';	
		var recipe = JSON.parse(json);

		json = '<?=$data['units']?>';
		var units = JSON.parse(json);
	
		json = '<?=$data['ingredients']?>';
		var ingredients = JSON.parse(json);

		json = '<?=$data['products']?>';
		var products = JSON.parse(json); 

	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['recipe'])?>-->
	<!--FOR DEBUGGING: <?=var_dump($data['units'])?>-->
	<!--FOR DEBUGGING: <?=var_dump($data['ingredients'])?>-->

	<div class="recipe" ng-controller="recipeEditController as recipeCtrl" ng-init="recipe_id = recipeCtrl.recipe.id">
		<form method="post" action="/armourtake/public/account/update_recipe/?recipe_id=1">	
			<h1>{{recipeCtrl.recipe.recipeName}} - recipe</h1>
				<br>
				<input class="hidden" type="text" id="recipe_id" name="recipe_id" ng-model="recipeCtrl.recipe.id" />
				<label class="recipe_label">
				Recipe name:
			<!--Name-->
				<input type="text" id="recipe_name" name="recipe_name" ng-model="recipeCtrl.recipe.recipeName" />
				</label>
				<br>
				<label class="recipe_label">
				Yeild: 
			<!--Yeild for recipe-->
				<input type="text" id="recipe_yeild" name="recipe_yeild" ng-model="recipeCtrl.recipe.yeild" />%
				</label>
				<label class="recipe_label">
				Unit: 
			<!--Units dropdown-->
				<select id="recipe_unit" name="recipe_unit" ng-model="recipeCtrl.recipe.yeildUnit">
					<option ng-repeat="unit in recipeCtrl.units">{{unit.Name}}</option>
				</select>
				</label>
				<label class="recipe_label">
				<strong>Total cost:</strong> 
			<!--Cost of recipe-->
				{{getTotalCost() | currency}}<input class="hidden" type="text" readOnly="true" id="recipe_cost" name="recipe_cost" ng-model="getTotalCost()"\>
				</label>
				<label class="recipe_label">
				<strong>Cost per {{recipeCtrl.recipe.yeildUnit}}:</strong> 
			<!--Cost of recipe-->
				{{getTotalCost()/recipeCtrl.recipe.yeild | currency}}<input class="hidden" type="text" readOnly="true" id="recipe_individual_cost" name="recipe_individul_cost" ng-model="getTotalCost()/recipeCtrl.recipe.yeild | currency"\>
				</label>
				<br>
				<br>
			<!--Ingredients list-->
				<section id="ingredients-list" ng-repeat="ingredient in recipeCtrl.ingredients">
				<!--product_id-->
					<input class="hidden" type="text" id="product_id{{$index}}" name="product_id{{$index}}" ng-model="ingredient.Products_id">	
				<!--Product name-->
					{{ingredient.productName}}
				<!--quantity-->
					<input type="text" id="quantity" name="quantity{{$index}}" ng-model="ingredient.quantity">			
				<!--Unit dropdown-->
					<select id="unit" name="unit{{$index}}" ng-model="ingredient.unit">
						<option ng-repeat="unit in recipeCtrl.units" ng-selected="unit.id == ">{{unit.Name}}</option>
					</select>
				<!--Cost calculated for each unit selected-->
					$<input type="text" disabled=""  ng-model="ingredient.cost = ingredient.costPerKiloUnit * ingredient.Ratio">
				<!--Total cost for quantity*cost of unit selected-->
					Total $<input type="text" readOnly="true" id="total_cost{{$index}}" name="total_cost{{$index}}" ng-model="totalcost = ingredient.cost * ingredient.quantity">
				</section>
				<button type="button" id="add-new-ingredient-to-recipe">Add new ingredient</button>		
				<br>
				<br>
			<!--Method-->
				Method:<br>
				<textarea class="method" rows=10 cols=100 id="recipe_method" name="recipe_method">{{decodeHtml(recipeCtrl.recipe.method)}}</textarea>
				</label>
			<!--Buttons-->
				<input type=submit value="Update" id="submit_submit" name="submit" class="recipe_buttons">
			<!--Cancel the action-->
				<a href="/armourtake/public/account/recipes/"><button type=button class="recipe_buttons">Cancel</button></a>

		</form>

			<!--Delete the entry-->
			<form method="post" action="/armourtake/public/account/delete_recipe/">
				<input class="hidden" type="text" id="recipe_id" name="recipe_id" ng-model="recipeCtrl.recipe.id" />
				<button id="delete-submit" class="recipe_delete">Delete</button>
			</form>

		<p class="goback">
			<a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/account/recipes'; ?>">Back to Recipes</a>
		</p>

		<!--This is just me playing around with APIS-->
		<?php
			/*
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
			*/
		?>
	</div>	
	<script type="text/javascript">
		var pageInit = function() {
    			Modal.switch_on_edit_buttons('add-new-ingredient-to-recipe');
		};
	</script>
