<div class="main-div" ng-app="armourtake">
<?php
	if(isset($data['flash'])){
		echo '<p>' . $data['flash'] . '</p>';
	}	
	
		
?>	<script type="text/javascript">
		var json = '<?=$data['dish']?>';
		var dish = JSON.parse(json);
	</script>
	<!--FOR DEBUGGING: <?=var_dump($data['dish'])?>-->

	<div class="recipe" ng-controller="dishCardController as dishCtrl">
		<h1>{{dishCtrl.dish.dishName}}</h1>
		<br/>
		<p>
			Retail Price: {{dishCtrl.dish.salePrice | currency}}
		</p>
		<br/>
		<p>
			Cost Price: {{dishCtrl.dish.costPrice | currency}}
			Gross Revenue: {{dishCtrl.dish.salePrice/1.15 - dishCtrl.dish.costPrice | currency}}
			Margin: {{(dishCtrl.dish.salePrice/1.15 - dishCtrl.dish.costPrice) / dishCtrl.dish.salePrice | percentage:2}}
		</p>
		<!--List the recipes/products-->
		<div ng-repeat="ingredient in dishCtrl.dish.ingredients">		
			<p>{{ingredient.quantity}} {{ingredient.unit}} <strong>{{ingredient.recipeName}}</strong> {{(ingredient.recipeCost/ingredient.yeild) | currency}}</p>
		</div>
	</div>	
<?php
	
?>
