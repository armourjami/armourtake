<div class="main-div" ng-app="armourtake">
	<?php
		if(isset($data['flash'])){
			echo '<p>' . $data['flash'] . '</p>';
		}	
	?>
	<!--Load the recipe table data-->
	<script type="text/javascript">
		var json = '<?=$data['recipes']?>';
		var recipes = JSON.parse(json);
	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['recipes'])?>-->
	<!--Display the recipe data-->
	<table id="recipe_table" name="recipe_table">
		<thead>
			<th>Recipe Name</th>
			<th>Cost</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</thead>
		<tbody ng-controller="recipeTableController as recipeCtrl">
			<tr ng-repeat="recipe in recipeCtrl.recipes">
				<td>{{recipe.recipeName}}</td>
				<td>{{recipe.recipeCost | currency}}</td>
				<td><a href="/armourtake/public/account/recipe/{{recipe.id}}">View</a></td>
				<td><a href="/armourtake/public/account/edit_recipe/{{recipe.id}}">Edit/Delete</a></td>
			</tr>
		</tbody>
	</table>
</div>
