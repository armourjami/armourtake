//app.js
//Angular controller for displaying table information
(function(){
	var app = angular.module("armourtake", []); 

	//For list of Recipes. aka Recipes index
	app.controller("recipeTableController", function(){
		this.recipes = recipes;			
	});

	//For individual Recipe
	app.controller("recipeCardController", function(){
		this.recipe = recipe;			
		this.units = units;
		this.ingredients = ingredients;
	});
	
	//For editing an individual Recipe
	app.controller("recipeEditController", function($scope){
		this.recipe = recipe;			
		this.units = units;
		this.ingredients = ingredients;
		this.products = products;
		$scope.getTotalCost = function(){
			var total = 0;
			for(var i = 0; i < $scope.recipeCtrl.ingredients.length; i++){
				total += $scope.recipeCtrl.ingredients[i].quantity * $scope.recipeCtrl.ingredients[i].cost;		
			}
			return total;
		};

	});


	//For list of Products, aka Products index
	app.controller("productTableController", function(){
		this.products = products;			
	});
	

})();
