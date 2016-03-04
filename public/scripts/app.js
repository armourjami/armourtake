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
		this.products = products;
		this.selected = products[0];

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
				console.log(this.ingredient);
				if($scope.recipeCtrl.recipe.ingredients[i].id === this.ingredient.id){
					$scope.recipeCtrl.recipe.ingredients.splice(i,1);	
					return;
				}	
			}	
			console.log(this.ingredient.id);	
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
			console.log(recipe);
			var newIngredient = $scope.recipeCtrl.selected;
			newIngredient.quantity = 1;
			console.log(recipe.contains(newIngredient.id));
			if(!recipe.contains(newIngredient.id)){ 
				$scope.recipeCtrl.recipe.ingredients[$scope.recipeCtrl.recipe.ingredients.length] = newIngredient;
			}else{
				alert("You may only enter each ingredient once");
			}
			for(var i = 0; i < $scope.recipeCtrl.recipe.ingredients.length ; i++){
				console.log($scope.recipeCtrl.recipe.ingredients[i]);
			}
			Modal.closeModal();
		};

	});


	//For list of Products, aka Products index
	app.controller("productTableController", function($scope){
		this.products = products;			
		this.new;
		
		$scope.addNewIngredient = function(){
			alert(recipeEditController.recipe.recipeName);
		};
	});
	

})();
