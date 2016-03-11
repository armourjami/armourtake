<div class="main-div" ng-app="armourtake">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
?>
<!--Load the dish table data-->
	<script type="text/javascript">
		var json = '<?=$data['dishes']?>';
		var dishes = JSON.parse(json);
		console.log(dishes[0]);
	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['dishes'])?>-->
	<!--Display the recipe data-->
	<table id="dishes_table" name="dishes_table">
		<thead>
			<th>Dish Name</th>
			<th>Cost per dish</th>
			<th>Sale price</th>
			<th>Gross Profit</th>
			<th>Margin</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</thead>
		<tbody ng-controller="dishTableController as dishCtrl">
			<tr ng-repeat="dish in dishCtrl.dishes">
				<td>{{dish.dishName}}</td>
				<td>{{dish.costPrice/dish.yeild | currency}}</td>
				<td>{{dish.salePrice | currency}}</td>
				<td>{{dish.salePrice/1.15 - dish.costPrice/dish.yeild | currency}}</td>
				<td>{{1 - (dish.costPrice/dish.yeild)/(dish.salePrice/1.15) | percentage:2}}</td>
				<td><a href="/armourtake/public/account/dish/{{dish.id}}">View</a></td>
				<td><a href="/armourtake/public/account/delete_dish/{{dish.Name}}">Edit/Delete</a></td>
			</tr>
			<tr>
				<td colspan="7"><a href="" id="addNewDish">Add new Dish</a></td>
			</tr>
		</tbody>
	</table>
