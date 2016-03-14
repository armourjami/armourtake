<div class="main-div" ng-app="armourtake">
<div id="modal">
	<div id="modalMask">
	</div>
	<div id="modalContent">
		<form class="edit-form" ng-controller="productTableController as productCtrl">
                <fieldset>
                        <label>
                        <span>Product name</span>
		        	<input type="text" pattern="^[0-9A-Za-z ,\.'-]+$" title="You must enter a valid name, use only Characters 0-9 a-z , . ' - You may use any case" id="product-name" name="product-name" ng-model="productCtrl.productName">			
                        </label>
                        <label>
                        <span>Purchase Unit</span>
                        <select id="purchase-unit" name="purchase-unit" ng-model="productCtrl.newProduct.purchaseUnit">
		        	<option ng-repeat="unit in productCtrl.units">{{unit.Name}}</option>
			</select>
                        </label>
                        <label>
                        <span>Retail Price</span>
		        	<input type="text"  pattern="^\${0,}[0-9]+$|^\${0,}[0-9]+\.[0-9]{0,2}$" title="Must be a $ Value e.g. $2, $12.20, or written as 2, 12.20" id="purchase-unit-price" name="purchase-unit-price" ng-model="purchaseUnitPrice">			
                        </label>
                        <label>
                        <span>Discount</span>
		        	<input type="text" pattern="^0$|^([1-9]?[0-9])$|^100$" title="Values between 0-100" id="discount" name="discount" ng-model="discount">			
                        </label>
                        <label>
                        <span>Yeild</span>
		        	<input type="text" pattern="^0$|^([1-9]?[0-9])$|^100$" title="Values between 0-100" id="yeild" name="yeild" ng-model="yeild">			
                        </label>
                        <label>
                        <span>Kilos/Litre</span>
		        	<input type="text" pattern="^[0-9]+$|^[0-9]+\.[0-9]{0,}$" title="Density must be written as a number" id="density" name="density" ng-model="density">			
                        </label>
                        <label>
                        <span>Supplier</span>
                        <select id="new-product" ng-model="productCtrl.newProduct.Suppliers_id" ng-options="supplier.supplierName for supplier in productCtrl.suppliers track by supplier.id" >
				<option value="">- - select supplier - -</option>
                        </select>
                        </label>

                        <label>
                                <span>&nbsp;</span>
                                <input type="submit" id="add-new-product" value="Add Product" ng-click="displayNewItem()">
                                <input type="button" id="closeModal" value="Cancel" ng-click="">
                        </label> 	
                </fieldset>
		</form>
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

                var json = '<?=$data['units']?>';
		var units = JSON.parse(json);
        
                var json = '<?=$data['suppliers']?>';
		var suppliers = JSON.parse(json);
		console.log(suppliers[0].id);

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
				<td colspan="6"><a href="" id="open-modal">Add new Product</a></td>
			</tr>
		</tbody>
	</table>
</div>
