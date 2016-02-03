<?php
class register extends Controller{
	public function index(){
		$user1 = new User();
		
		if($user1 ->isLoggedIn()){
			//would you like to register a new user
			
		}else if(Input::exists()){
				if(Token::check(Input::get('token'))){
					$validate = new Validation();	
					$validate->check($_POST, array(
					'username' => array(
						'min' => 2,
						'max' => 20,
						'required' => true,
						'unique' => true
					),'name' => array(
						'min' => 2,
						'max' => 50,
						'required' => true
					),'sirname' => array(
						'min' => 2,
						'max' => 50,
						'required' => true
					),'email' => array(
						'min' => 5,
						'max' => 64,
						'email' => true,
						'required' => true,
						'unique' => true
					),'date_of_birth' => array(
						'min' => 6,
						'max' => 10,
						'date' => true,
						'required' => true	
					),'password' => array(
						'min' => 6,
						'required' => true	
					),'password_again' => array(
						'min' => 6,
						'matches' => 'password',
						'required' => true
					),
					));
						if($validate->passed()){
						$user = new User();
						$salt = Hash::salt(32);
						$date_of_birth = new Date(Input::get('date_of_birth'));
						try{
							$user->create(array(
								'username' => Input::get('username'),
								'name' => Input::get('name'),
								'sirname' => Input::get('sirname'),
								'email' => Input::get('email'),
								'dateofbirth' => $date_of_birth->format('Y-m-d H:i:s'),
								'password' => Hash::make(Input::get('password'), $salt),
								'salt' => $salt,
								'joined' => date('Y-m-d H:i:s'),
								'group' => 1
							));
							
							Session::flash('success', 'You have been registered');	
							Redirect::to('home');
						}catch(Exception $e){
							die($e->getMessage());
						}

					}else{	
						$error_string = '';
						//there were errors
						//Create a file that prints errors	
						foreach($validate->errors() as $error){
							$error_string .= $error . '<br>';
						}
						$this->view('register/failed', [
							'loggedIn' => 0,
							'page_name' => 'Login Failed',
							'errors' => $error_string
						]);
					}
				}
		}else{
			//display form page
			$this->view('register/register', [
				'register' => true, 
				'page_name' => 'Register',
				'loggedIn' => 0]
			);
		}
	}	
}
?>
