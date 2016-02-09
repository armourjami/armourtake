<div class="main-div" ng-app="armourtake">
	<?php
		if(isset($data['flash'])){
			echo '<p>' . $data['flash'] . '</p>';
		}	
	?>
	<!--Load the product table data-->
	<script type="text/javascript">
		var json = '<?=$data['products']?>';
		var products = JSON.parse(json);
	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['products'])?>-->
	<!--Display the recipe data-->
	<table id="products_table" name="products_table">
		<thead>
			<th>Recipe Name</th>
			<th>Purchase Unit</th>
			<th>Price</th>
			<th>Default unit</th>
			<th>Cost per Unit</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</thead>
		<tbody ng-controller="productTableController as productCtrl">
			<tr ng-repeat="product in productCtrl.products">
				<td>{{product.productName}}</td>
				<td>{{product.purchaseUnit}}</td>
				<td>{{product.purchaseUnitPrice}}</td>
				<td>{{product.unitName}}</td>
				<td>{{product.costPerKiloUnit | currency}}</td>
				<td><a href="/armourtake/public/account/product/{{product.id}}">View</a></td>
				<td><a href="/armourtake/public/account/edit_product/{{product.id}}">Edit/Delete</a></td>
			</tr>
		</tbody>
	</table>
</div>
