<?php

class UsersController extends AppController {

	var $components = array('Cookie');
	var $uses = 'User';

	function login() {
		$this->autoRender = false;

		$username = @$_POST['user_name'];
		$password = @$_POST['password'];

		if (empty($username) || empty($password)) {
			return json_encode(array('error' => 'You must supply your email (or username) and password'));
		}
		// if their login matches an email, search for their email credentials.  otherwise use a username/pw combo
		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $username)) {
			$User = $this->User->findByEmailAndPassword($username, md5($password));
		} else {
			$User = $this->User->findByNameAndPassword($username, md5($password));
		}
		if (empty($User)) {
			return json_encode(array("error" => "Invalid user/password combination."));
		}
		if ($User['User']['activated'] == 0) {
			return json_encode(array("error" => "You must first verify your account"));
		}

		$this->Cookie->write('logged_in', 'true', 3600);
		$this->Cookie->write('user_id', $User['User']['id'], 3600);
	}

	function fblogin() {
		$this->autoRender = false;
		$username = @$_POST['name'];
		$fb_id = @$_POST['fb_id'];

		if (empty($username) || empty($fb_id)) {
			return json_encode(array('error' => 'Your facebook information could not be accessed for some reason.  Try re-connecting.'));
		}

		// if there isn't already an entry for this facebook user, add one
		$User = $this->User->findByFb_id($fb_id);
		if (!$User) {
			$NewUser = array('User' => array(
					'name' => $username,
					'fb_id' => $fb_id,
					'activated' => 1
					));
			$User = $this->User->register($NewUser);
		}

		$this->Cookie->write('logged_in', 'true', 3600);
		$this->Cookie->write('user_id', $User['User']['id'], 3600);
	}

	function logout() {
		$this->autoRender = false;
		$this->Cookie->delete('user_id');
		$this->Cookie->delete('logged_in');
		// need a redirect because it's a link not ajax
		$this->redirect($this->referer());
	}

}

?>
