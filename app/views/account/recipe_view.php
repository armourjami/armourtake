<div class="main-div" ng-app="armourtake">
	<p><?=$data['flash']?></p>
	<!--Load the recipe table data-->
	<script type="text/javascript">
		var json = '<?=$data['recipe']?>';
		var recipe = JSON.parse(json);

		var json = '<?=$data['units']?>';
		var units = JSON.parse(json);
	
		console.log(recipe.ingredients[0]);

	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['recipe'])?>-->
	<!--FOR DEBUGGING: <?=var_dump($data['units'])?>-->
	<!--FOR DEBUGGING: <?=var_dump($data['ingredients'])?>-->

	<div class="recipe" ng-controller="recipeCardController as recipeCtrl">
		<h1>{{recipeCtrl.recipe.recipeName}}</h1>
		<p>
		<span class="recipe_heading">Yeild:</span>{{recipeCtrl.recipe.yeild}}%
		<span class="recipe_heading">Cost:</span>{{recipeCtrl.recipe.recipeCost | currency}}
		</p>
		<p>
		<table>
			<tbody>
				<tr ng-repeat="ingredient in recipeCtrl.recipe.ingredients">
					<td>{{ingredient.quantity | decimals:1}}</td>
					<td>{{ingredient.unit}}</td>
					<td>{{ingredient.productName}}</td>
					<td>{{(ingredient.quantity * ingredient.costPerKiloUnit) | currency}}</td>
				</tr>
			</tbody>
		</table>
		<p>
		<span class="recipe_heading">Method:</span>
		</p>
		<p class="recipe_method">
			<textarea class="method" rows="10" cols="100" disabled="true">{{recipeCtrl.recipe.method | decodeHtml}}</textarea>
		</p>
		<p>
		<a href="/armourtake/public/account/recipes">Back to Recipes</a>
		</p>
	</div>	
</div>
