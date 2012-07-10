<?php

class UserController extends AppController {

	var $uses = 'User';

	function index() {

	}

	function login() {
		$username = @$_POST['user_name'];
		$password = @$_POST['password'];
		if (empty($username) || empty($password)){
			return json_encode(array('error' => 'You must supply your email (or username) and password'));
		}

		$valid_email = "^[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,})$";
		if (preg_match($valid_email, $username)) {
			$User = $this->findByEmailAndPassword($username, md5($password));
		}else{
			$User = $this->findByNameAndPassword($username, md5($password));
		}
		
		if (empty($User)) {
			return false;
		}

		Cache::write($User['User']['id'], 'logged_in');
	}

}

?>
