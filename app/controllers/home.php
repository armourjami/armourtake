<?php
class home extends Controller {

	public function index(){
		$flash_string = '';
		if(Session::exists('home')){
			$flash_string = Session::flash('home');	
		}
		if(Session::exists('success')){
			$flash_string = Session::flash('success');
		}

		$user = new User();
		if($user->isLoggedIn()){
			$this->view('account/index', [
				'register' => true, 
				'loggedIn' => 1, 
				'flash' => $flash_string, 
				'name' => $user->data()->name,
				'user_id' => $user->data()->id,
				'page_name' => 'Home'
			]);
		}else{
			$this->view('home/index', [
				'loggedIn' => 0, 
				'page_name' => 'Home',
				'flash' => $flash_string
			]);
		}
	}	
}
?>
