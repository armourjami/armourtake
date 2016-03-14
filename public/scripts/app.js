//app.js
//Angular controller for displaying table information
(function(){
	var app = angular.module("armourtake", []); 
	
	app.filter('percentage', ['$filter', function ($filter) {
	  	return function (input, decimals) {
	    		return $filter('number')(input * 100, decimals) + '%';
	  	};
	}]);

	app.filter('decodeHtml', ['$filter', function ($filter) {
		var txt = document.createElement("textarea");
	  	return function (input) {
	    		txt.innerHTML = input;
			return txt.value;
	  	};
	}]);
	
	app.filter('decimals', ['$filter', function ($filter) {
	  	return function (input, decimals) {
	    		return $filter('number')(input, decimals);
	  	};
	}]);

	//For list of Recipes. aka Recipes index
	app.controller("recipeTableController", function(){
		this.recipes = recipes;			
	});

	//For individual Recipe
	app.controller("recipeCardController", function(){
		this.recipe = recipe;			
		this.units = units;
	});
	
	//For individual Recipe
	app.controller("dishCardController", function(){
		this.dish = dish;			
	});

	//For editing an individual Recipe
	app.controller("recipeEditController", function($scope){
		this.recipe = recipe;			
		this.units = units;
		this.products = products;
		this.selected = products[0];

		$scope.changeRatio = function(name, index){
			for(var i = 0; i < units.length; i++){
				if($scope.recipeCtrl.units[i].Name == name){
					var newRatio = $scope.recipeCtrl.units[i].Ratio; 
					$scope.recipeCtrl.recipe.ingredients[index].Ratio = newRatio; 				
				}
			}
		};

		$scope.getTotalCost = function(){
			var total = 0;
			for(var i = 0; i < $scope.recipeCtrl.recipe.ingredients.length; i++){
				var currentIngredient = $scope.recipeCtrl.recipe.ingredients[i];
				total += parseFloat(currentIngredient.quantity) * parseFloat(currentIngredient.costPerKiloUnit) * parseFloat(currentIngredient.Ratio);		
			}
			$scope.recipeCtrl.recipe.recipeCost = total;
			return total;
		};
		
		$scope.removeItem = function(){
			for(var i = 0; i < $scope.recipeCtrl.recipe.ingredients.length; i++){
				if($scope.recipeCtrl.recipe.ingredients[i].id === this.ingredient.id){
					$scope.recipeCtrl.recipe.ingredients.splice(i,1);	
					return;
				}	
			}	
		};

		$scope.addItem = function(){
			var newIngredient = {
				user: $scope.recipeCtrl.recipe.user,
				quantity: 1,
			};
			$scope.recipeCtrl.recipe.ingredients[$scope.recipeCtrl.recipe.ingredients.length] = newIngredient;
		}

		$scope.decodeHtml = function(html) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			return txt.value;
		};

		$scope.addNewIngredient = function(){
			//Change the selection
			var newIngredient = {
				productName: $scope.recipeCtrl.selected.productName,
				id: $scope.recipeCtrl.selected.id,
				costPerKiloUnit: $scope.recipeCtrl.selected.costPerKiloUnit,
				Recipes_id: $scope.recipeCtrl.recipe.id,
				quantity: 1,
				unit: $scope.recipeCtrl.selected.unitName,
				Ratio:	$scope.recipeCtrl.selected.Ratio, 
				UnitType: $scope.recipeCtrl.selected.UnitType
			} 
			if(!recipe.contains(newIngredient.id)){ 
				$scope.recipeCtrl.recipe.ingredients[$scope.recipeCtrl.recipe.ingredients.length] = newIngredient;
				console.log($scope.recipeCtrl.recipe.ingredients[$scope.recipeCtrl.recipe.ingredients.length-1]);
			}else{
				alert("You may only enter each ingredient once");
			}
			//for(var i = 0; i < $scope.recipeCtrl.recipe.ingredients.length ; i++){
			//	console.log($scope.recipeCtrl.recipe.ingredients[i]);
			//}
			Modal.closeModal();
		};

	});


	//For list of Products, aka Products index
	app.controller("productTableController", function($scope){
		this.products = products;			
		this.units = units;
		this.suppliers = suppliers;
		this.newProduct = {
			productName: '',
			purchaseUnit: 'Kilo',
			purchaseUnitWeight: 1,
			unitName: 'Kilo',
			purchaseUnitPrice: 1,
			discount: 0,
			yeild: 100,
			density: 1,
			Suppliers_id: 1
		};
		
		$scope.displayNewItem = function(){
			console.log($scope.productCtrl.newProduct);
		};
		
		$scope.addNewIngredient = function(){
			alert(recipeEditController.recipe.recipeName);
		};
	});

	app.controller("unitTableController", function($scope){
		this.units = units;			
		console.log(this.units);
	});

	app.controller("dishTableController", function($scope){
		this.dishes = dishes;			
		console.log(this.dishes);
	});
})();
