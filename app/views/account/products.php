<div class="main-div" ng-app="armourtake">
<div id="modal">
	<div id="modalMask">
	</div>
	<div id="modalContent">
		<p>Hello</p>
		<p>I'm modal content</p>
		<input type="submit" id="closeModal" value="Close window">
	</div>
</div>
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
			<th>Cost per Unit</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</thead>
		<tbody ng-controller="productTableController as productCtrl">
			<tr ng-repeat="product in productCtrl.products">
				<td>{{product.productName}}</td>
				<td>{{product.purchaseUnit}}</td>
				<td>{{product.purchaseUnitPrice | currency}}</td>
				<td>{{product.costPerKiloUnit | currency}}/{{product.unitName}}</td>
				<td><a href="/armourtake/public/account/product/{{product.id}}">View</a></td>
				<td><a href="/armourtake/public/account/edit_product/{{product.id}}">Edit/Delete</a></td>
			</tr>
			<tr>
				<td colspan="6"><a href="" id="addNewProduct">Add new Product</a></td>
			</tr>
		</tbody>
	</table>
</div>
