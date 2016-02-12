
<?php
				
class account extends Controller{
	public function index($flash_string = ''){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){	
			$this->view('account/index', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => $user->data()->username,
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}	

	public function products(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The products table will be rendered on the view page	
			$db = STOCK_DB::getInstance();						

			//load database content
			$products = $db->get('Products', ['id', '>=', '1'], $user->data()->id);
			$product_count = $products->count();
			$json_products = json_encode($products->results());	

			$this->view('account/products', [
				'products' => $json_products,
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => 'Products',
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}

	public function units(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The products table will be rendered on the view page	
			$this->view('account/units', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => 'Units',
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}

	public function recipes(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The recipes table will be rendered on the view page	
			$db = STOCK_DB::getInstance();						

			//load database content
			$recipes = $db->get('Recipes', ['id', '>=', '1'], $user->data()->id);
			$recipe_count = $recipes->count();
			$json_recipes = json_encode($recipes->results());	

			$this->view('account/recipes', [
				'recipes' => $json_recipes,
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => 'Recipes',
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}

	public function delete_recipe(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The recipes table will be rendered on the view page	
								
			$this->_db = STOCK_DB::getInstance();
			
			$dishes = $this->_db->get('Dishes', ['id', '>=', Input::get('recipe_id')]);
			$dish_count = $dishes->count();
			if(!$dish_count){
				$this->_db->delete('ProductRecipes', ['Recipes_id', '=', Input::get('recipe_id')]);
				$this->_db->delete('Recipes', ['id', '=', Input::get('recipe_id')]);
				
				Session::flash('account', 'Recipe deleted');
			}else{

				Session::flash('account', 'Recipe could not be deleted as it is still part of a dish');
			}
			
			Redirect::to('account/recipes');
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}

	public function recipe($idRecipe = null){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			if(isset($idRecipe)){
				$this->_db = STOCK_DB::getInstance();						
				
				$recipe = $this->_db->get('Recipes', ['id', '=', $idRecipe], $user->data()->id);
				$recipe = $recipe->first();
				$recipe_json  = json_encode($recipe);
					
				$units = $this->_db->get('Unit', ['Name', '<>', ''], $user->data()->id);
				$units_json  = json_encode($units->results());

				$pros_recs = new recipe($idRecipe);
				$pro_rec = $pros_recs->data();	
				$ingredients_json  = json_encode($pro_rec);

				$this->view('account/recipe_view', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => "",
					'user_id' => $user->data()->id,
					'units' => $units_json,
					'recipe' => $recipe_json,
					'ingredients' => $ingredients_json,
				]);

			}else{		
				$this->view('account/recipes', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => "",
					'user_id' => $user->data()->id
				]);
			}
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}	
	}

	public function edit_recipe($idRecipe = null){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			if(isset($idRecipe)){
				$this->_db = STOCK_DB::getInstance();						
				
				$recipe = $this->_db->get('Recipes', ['id', '=', $idRecipe], $user->data()->id);
				$recipe = $recipe->first();
				$recipe_json  = json_encode($recipe);
					
				$units = $this->_db->get('Unit', ['Name', '<>', ''], $user->data()->id);
				$units_json  = json_encode($units->results());

				$pros_recs = new recipe($idRecipe);
				$pro_rec = $pros_recs->data();	
				$ingredients_json  = json_encode($pro_rec);

				$products = $this->_db->join(
					array(//table1, tablejoin, table2 
						 array( 
							'table_name' => 'Products',
							'next_table_name' => 'ProductRecipes',
							'table_column' => 'id',
							'next_table_column' => 'Products_id',
							'selections' => array(
								'productName',
							)					 
						 ),      
						 array( 
							'table_name' => 'ProductRecipes', 
							'next_table_name' => null,
							'table_column' => null,
							'next_table_column' => null,
							'selections' => array(
								'Products_id',
							)
						 )      
					)
				, true);//select distinct
			
				//$products = $this->_db->getOneOfEach('ProductRecipes', [1]); 
				$products = $products->results();
				$products_json = json_encode($products);

				
				$this->view('account/recipe_edit', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => "Edit recipe",
					'ingredients' => $ingredients_json,
					'products' => $products_json,
 					'user_id' => $user->data()->id,
					'recipe' => $recipe_json,
					'units' => $units_json,
				]);

			}else{		
				$this->view('account/recipes', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => "",
					'user_id' => $user->data()->id
				]);
			}
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}	
	}

	public function update_recipe(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			if(Input::exists()){
				$this->_db = STOCK_DB::getInstance();						
				$recipe = $this->_db->get('Recipes', ['id', '=', Input::get('recipe_id')], $user->data()->id);
				$recipe = $recipe->first();
				
				$pros_recs = new recipe(Input::get('recipe_id'));
				$pro_rec = $pros_recs->data();	
				$json  = json_encode($pro_rec);
				$ingredients = json_decode($json, true);

				//Check each field to see what needs to be update
				$entry_changes = array();
				$validate = new Validation();
				$validation = $validate->check($_POST, array(
					'recipe_name' => array(
						'required' => true,
						'label' => true
					),
					'recipe_yeild' => array(
						'required' => true,
						'min' => 0,
						'max' => 1000
					),
					'recipe_cost' => array(
						'required' => true,
						'min' => 0,
						'max' => 50000
					),
					'recipe_method' => array(
						'required' => true
					)
				));

				if($validation->passed()){
				//Validate and check all Recipe table data
					if(Input::get('recipe_name') !== $recipe->recipeName){
						$entry_changes['recipeName'] = Input::get('recipe_name');
					}
					if(Input::get('recipe_yeild') !== $recipe->yeild){
						$entry_changes['yeild'] = Input::get('recipe_yeild');
					}
					if(Input::get('recipe_unit') !== $recipe->yeildUnit){
						$entry_changes['yeildUnit'] = Input::get('recipe_unit');
					}
					if(floatval(Input::get('recipe_cost')) !== floatval($recipe->recipeCost)){
						$entry_changes['recipeCost'] = Input::get('recipe_cost');
					}	
					//$entry_changes['recipeCost'];
					if(Input::get('recipe_method') !== $recipe->method){
						$entry_changes['method'] = filter_var(trim(Input::get('recipe_method')),FILTER_SANITIZE_SPECIAL_CHARS);
					}
					//Update each feild
					if(count($entry_changes)){
						$pros_recs->update($entry_changes);
					}
				}
				$error_string = "";
				echo var_dump($_POST);
				$i = 0;
				foreach($ingredients as $value){

					if(Input::get("product_id$i") != ""){
						if(Input::get("quantity$i") != $value['quantity'] || Input::get("unit$i") != $value['unit']){
							//Validate changes	
							$validate = new Validation();
							$validation = $validate->check($_POST, array(
								"quantity$i" => array(
									'required' => true,
									'min' => 0,
									'max' => 1000
								),
								"unit$i" => array(
									'required' => true
								)
							));
							//Update the changes
							if($validation->passed()){
								$changes = array(
									"quantity" => Input::get("quantity$i"),
									"unit" => Input::get("unit$i")
								);			
								
								//Update the Ingredient	
								$pros_recs->updateIngredient($value['Products_id'], $changes);
							}
						}
					}else{
						continue;
					}
					$i++;
				}
				
				$pros_recs->update(['recipeCost' => Input::get('recipe_cost')]);

				foreach($validation->errors() as $error){
					$error_string .= $error . "\n";
				}		
				Session::flash('account', $error_string); 

				//redirect here
				Redirect::to('account/recipes');

			}else{		
				$this->view('account/recipes', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => "",
					'user_id' => $user->data()->id
				]);
			}
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}	
	}
	public function dish($idDish = null){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			if(isset($idDish)){
				$this->_db = STOCK_DB::getInstance();						
				
				$dish = $this->_db->get('Dishes', ['id', '=', $idDish], $user->data()->id);
				$dish = $dish->first();
				
				$this->view('account/dish_view', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => 'Dish recipe',
					'user_id' => $user->data()->id,
					'dish_name' => $dish->dishName,
					'dish_price' => $dish->dishPrice,
					'dish_cost' => $dish->costPrice,
					'margin' => $dish->margin,
					'type' => $dish->Types_Type,
					'gross_revenue' => $dish->grossRevenue
				]);
			}else{
				$this->view('account/dishes', [
					'register' => true, 
					'loggedIn' => 1, 
					'flash' => $flash_string, 
					'name' => $user->data()->name, 
					'page_name' => 'Dishes',
					'user_id' => $user->data()->id
				]);
			}
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}
	
	public function dishes(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The products table will be rendered on the view page	
			$this->view('account/dishes', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => 'Dishes',
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}
				
	public function suppliers(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		if($user->isLoggedIn()){
			//The products table will be rendered on the view page	
			$this->view('account/suppliers', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name, 
				'page_name' => 'Suppliers',
				'user_id' => $user->data()->id
			]);
		}else{
			Session::flash('home', 'You have been logged out, please log back in');
			Redirect::to('home');
		}
	}

	public function profile(){
		$flash_string = '';
		if(Session::exists('account')){
			$flash_string = Session::flash('account');	
		}
		$user = new User();
		
		$this->view('account/profile', [
			'register' => true, 
			'loggedIn' => 1, 
			'flash' => $flash_string, 
			'name' => $user->data()->name,
			'surname' => $user->data()->surname,
			'username' => $user->data()->username,
			'date_of_birth' => $user->data()->dateofbirth,
			'email' => $user->data()->email,
			'joined' => $user->data()->joined,
			'group' => $user->data()->group,
			'page_name' => 'User profile',
			'user_id' => $user->data()->id

		]);
	}

	public function update(){
		$user = new User();

		if(!$user->isLoggedIn()){
			Redirect::to('home');
		}
		
		if(Input::exists()){
			if(Token::check(Input::get('token'))){
					$validate = new Validation();
					$validation_criteria = array();
					if(Input::get('name') != $user->data()->name){
						$validation_criteria['name'] = array(
							'required' => true,
							'min' => 2,
							'max' => 50
						);
						$validation_criteria['surname'] = array(
							'min' => 2,
							'max' => 50
						);
					}
					if(Input::get('email') != $user->data()->email){
						$validation_criteria['email'] = array(
							'email' => true,
							'unique' => true
						);
					}
					if(!empty($validation_criteria)){
						$validation = $validate->check($_POST, $validation_criteria);
					
						if($validation->passed()){
							try{
								$toUpdate = array();
								if(Input::get('name') != $user->data()->name){
									$toUpdate['name'] = Input::get('name');
								}
								if(Input::get('surname') != $user->data()->sirname){
									$toUpdate['surname'] = Input::get('surname');
								}
								if(Input::get('email') != $user->data()->email){

									$toUpdate['email'] = Input::get('email');
								}

								$user->update($toUpdate);

								Session::flash('account', 'Your details have been updated');
								Redirect::to('account');
							}catch(Exception $e){
								die($e->getMessage());
							}
						}else{
							//view errors
							foreach($validation->errors() as $error){
								echo $error . '<br>';
							}
						}	
					}else{
						Session::flash('account', 'You didn\'t update any of your records');
						Redirect::to('account');
					}
			}else{
				$this->view('account/update', [
						'register' => true, 
						'loggedIn' => 1, 
						'name' => $user->data()->name, 
						'flash' => Session::flash('account'),
						'page_name' => 'Update user details',
						'user_id' => $user->data()->user
				]);
			}
		}else{
			$this->view('account/update', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => Session::flash('account'), 
				'name' => $user->data()->name,
				'surname' => $user->data()->surname,
				'email' => $user->data()->email,
				'page_name' => 'Update user details',
				'user_id' => $user->data()->username

			]);
		}
	}
	
	public function change_password(){

		$user = new User();

		if(!$user->isLoggedIn()){
			Redirect::to('home');
		}

		if(Input::exists()){
			if(Token::check(Input::get('token'))){
				$validate = new Validation();
				$validation = $validate->check($_POST,array(
					'password_current' => array(
						'required' => true,
						'min' => 6,
					),
					'password_new' => array(
						'required' => true,
						'min' => 6,
					),
					'password_new_again' => array(
						'required' => true,
						'min' => 6,
						'matches' => 'password_new'
					)
				));
				if($validation->passed()){
					if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
						//view page error for incorrect password
					}else{
						$salt = Hash::salt(32);
						$user->update(array(
							'password' => Hash::make(Input::get('password_new'), $salt),
							'salt' => $salt
						));

						Session::flash('account', 'Your password has been changed');
						Redirect::to('account');
					}
				}else{
					$error_string = '';
					foreach($validation->errors() as $error){
						$error_string .= $error . '<br>';
					}
					$this->view('account/change_password', [
						'register' => true, 
						'loggedIn' => 1, 
						['errors' => $error_string], 
						'name' => $user->data()->name, 
						'page_name' => 'Change user password',
						'flash' => Session::flash('account')
					]);
				}
			}
		}else{
			$this->view('account/change_password', [
					'register' => true, 
					'loggedIn' => 1, 
					'name' => $user->data()->name, 
					'page_name' => 'Change user password',
					'flash' => Session::flash('account')
			]);
		}
			
	}
}
?>
