<div class="main-div" ng-app="armourtake">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
?>
<!--Load the unit table data-->
	<script type="text/javascript">
		var json = '<?=$data['units']?>';
		var units = JSON.parse(json);
	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['units'])?>-->
	<!--Display the recipe data-->
	<table id="units_table" name="units_table">
		<thead>
			<th>Unit Name</th>
			<th>Type</th>
			<th>Ratio</th>
			<th>&nbsp;</th>
		</thead>
		<tbody ng-controller="unitTableController as unitCtrl">
			<tr ng-repeat="unit in unitCtrl.units">
				<td>{{unit.Name}}</td>
				<td>{{unit.UnitType}}</td>
				<td>{{unit.Ratio}}</td>
				<td><a href="/armourtake/public/account/edit_unit/{{unit.Name}}">Delete</a></td>
			</tr>
			<tr>
				<td colspan="7"><a href="" id="addNewUnit">Add new Unit</a></td>
			</tr>
		</tbody>
	</table>
</div>
