<?php

class UserController extends AppController {

	var $components = array('Cookie');

	function login() {
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

		$this->Cookie->write('logged_in', 'true', 3600);
		$this->Cookie->write('user_id', $User['User']['id'], 3600);
	}

	function logout() {
		$this->autoRender = false;
		$this->Cookie->delete('user_id');
		$this->Cookie->delete('logged_in');
		$this->redirect('/top/1');
	}

}

?>
