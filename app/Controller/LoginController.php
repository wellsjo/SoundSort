<?php

class LoginController extends AppController {

	var $uses = 'User';

	function index() {
		$this->autoRender = false;
		$username = @$_POST['user_name'];
		$password = @$_POST['password'];
		if (empty($username) || empty($password)) {
			return json_encode(array('error' => 'You must supply your email (or username) and password'));
		}

		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $username)) {
			$User = $this->User->findByEmailAndPassword($username, md5($password));
		} else {
			$User = $this->User->findByNameAndPassword($username, md5($password));
		}

		if (empty($User)) {
			return json_encode(array("error" => "Invalid user/password combination."));
		}

		$this->Session->write('logged_in', 'true');
		$this->Session->write('user_id', $User['User']['id']);
	}

}

?>
