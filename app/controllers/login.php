<?php
class login extends Controller{

	public function index(){//add params
		$user = new User();
		if($user->isLoggedIn()){
			Redirect::to('account');
			//$this->view('user/index', ['flash' => '', 'name' => $user->data()->name]);
		}else{

			if(Input::exists()){
				if(Token::check(Input::get('token'))){
					$validate = new Validation();
					$validation = $validate->check($_POST, array(
						'username' => array('required' => true),
						'password' => array('required' => true)
					));
				
					if($validation->passed()){
						$user = new User();
						$remember = (Input::get('remember') === 'on') ? true : false;
						$login = $user->login(Input::get('username'), Input::get('password'), $remember);
						if($login){
							//login success
							Session::flash('account', 'You are now logged in');
							Redirect::to('account');
						}else{
							//login failed
							$error_string = 'Username or passowrd incorrect<br>';
							$this->view('login/failed', [
								'loggedIn' => 2, 
								'page_heading' => 'Login',
								'errors' => $error_string
							]);
						}
					}else{
						$error_string = '';
						//there were errors
						//Create a file that prints errors	
						foreach($validation->errors() as $error){
							$error_string .= $error . '<br>';
						}
						$this->view('login/failed', [
							'loggedIn' => 0, 
							'page_name' => 'Login',
							'errors' => $error_string
						]);


					}
				}else{
					//token did not match so go back to login page
					$this->view('login/index', [
						'loggedIn' => 2,
						'page_name' => 'Login'
					]);
				}
			}else{
				$this->view('login/index', [
					'loggedIn' => 2, 
					'page_name' => 'Login'
				]);
			}
		}
		
	}
	public function logout(){
		$user = new User();
		$user->logout();
		Session::flash('home', 'You have successfully been logged out');
		Redirect::to('home');
	}

}
?>
