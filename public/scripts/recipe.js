//recipe class 
function recipe(json){
	var obj = JSON.parse(json);
	this.id = obj.id;
	this.yeild = obj.yeild;
	this.yeildUnit = obj.yeildUnit;
	this.method = obj.method;
	this.recipeName = obj.recipeName;
	this.recipeCost = obj.recipeCost;
	this.ingredients = obj.ingredients;

	this.contains = function (id){
		for(i = 0; i < this.ingredients.length; i++){
			if(id == this.ingredients[i].id){
				return true;
			}	
		}
		//not found
		return false;
	};
}

function dish(json){
	var obj = JSON.parse(json);
	this.id = obj.id;
	this.yeild = obj.yeild;
	this.dishName = obj.dishName;
	this.costPrice = obj.costPrice;
	this.salePrice = obj.salePrice;

	this.contains = function (id){
		for(i = 0; i < this.ingredients.length; i++){
			if(id == this.ingredients[i].id){
				return true;
			}	
		}
		//not found
		return false;
	};
}
