<!--Load the recipe table data-->
<script type="text/javascript">
	var json = '<?=$data['recipe']?>';	
	var recipe = new recipe(json);
console.log(recipe.ingredients[0]);
console.log(recipe.ingredients[1]);
console.log(recipe.ingredients[2]);
	json = '<?=$data['units']?>';
	var units = JSON.parse(json);

	json = '<?=$data['products']?>';
	var products = JSON.parse(json); 

</script>
<!--FOR DEBUGGING: <?=var_dump($data['recipe'])?>-->
<!--FOR DEBUGGING: <?=var_dump($data['units'])?>-->

<div class="main-div" ng-app="armourtake" ng-controller="recipeEditController as recipeCtrl">
	<div id="modal">
		<div id="modalMask">
		</div>
		<div id="modalContent">
			<form class="edit-form">
				<fieldset>
								<label> <span>Name</span>
									<select id="new-product" ng-model="recipeCtrl.selected" ng-options="product.productName for product in recipeCtrl.products track by product.id" ></select>
								</label>
								
								<label>
									<span>&nbsp;</span>
									<input type="button" id="add-ingredient-to-recipe" value="Add ingredient" ng-click="addNewIngredient()">
									<input type="button" id="closeModal" value="Cancel">
								</label> 	
				</fieldset>
			</form>
		</div>
	</div>

	<div class="recipe" ng-init="recipe_id = recipeCtrl.recipe.id">
	<p><?=$data['flash']?></p>
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
				{{getTotalCost() | currency}}<input class="hidden" type="text" readOnly="true" id="recipe_cost" name="recipe_cost" ng-value="getTotalCost()"/>
				</label>
				<label class="recipe_label">
				<strong>Cost per {{recipeCtrl.recipe.yeildUnit}}:</strong> 
			<!--Cost of recipe-->
				{{getTotalCost()/recipeCtrl.recipe.yeild | currency}}<input class="hidden" type="text" readOnly="true" id="recipe_individual_cost" name="recipe_individual_cost" ng-value="getTotalCost()/recipeCtrl.recipe.yeild | currency"/>
				</label>
				<br>
				<br>
			<!--Ingredients list-->
				<section id="ingredients-list" ng-repeat="ingredient in recipeCtrl.recipe.ingredients track by $index">
				<!--product_id-->
					<input class="hidden" type="text" id="id{{$index}}" name="id{{$index}}" ng-model="ingredient.id">	
				<!--Product name-->
					{{ingredient.productName}}
				<!--quantity-->
					<input type="text" id="quantity" name="quantity{{$index}}" ng-model="ingredient.quantity">			
				<!--Unit dropdown-->
					<select id="unit" name="unit{{$index}}" ng-model="ingredient.unit" ng-change="changeRatio(ingredient.unit,$index)">
						<option ng-repeat="unit in recipeCtrl.units">{{unit.Name}}</option>
					</select>
				<!--Cost calculated for each unit selected-->
					{{ingredient.costPerKiloUnit * ingredient.Ratio | currency}}
				<!--Total cost for quantity*cost of unit selected-->
					Total {{ingredient.costPerKiloUnit * ingredient.quantity * ingredient.Ratio | currency}}
				<!--Delete item-->
					<button type="button" ng-click="removeItem()">Remove</button>
				</section>
				<button type="button" id="open-modal">Add new ingredient</button>		
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
	</div>	
	
