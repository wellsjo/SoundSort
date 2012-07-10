<?php

App::uses('CakeEmail', 'Network/Email');

class RegisterController extends AppController {

	var $uses = array('User');
	var $components = 'Email';

	function index() {
		if (!empty($_POST)) {
			$this->redirect('/register/confirm');
		}
	}

	function confirm() {
		if (!empty($_POST)) {
			$NewUser = array('User' => array(
					'name' => @$_POST['user_name'],
					'email' => @$_POST['user_email'],
					'password' => md5(@$_POST['pwd'])
					));
			$result = $this->User->register($NewUser);
			$this->set('user', $result);
			$this->sendEmailConfirmation($result['User']['id'], $NewUser['User']['email']);
		}
	}

	function sendEmailConfirmation($id, $user_email) {
		$email = new CakeEmail('smtp');
		$email->to($user_email);
		$email->subject('SoundSort Authentication');
		$email->template('email_confirm');
		$email->emailFormat('html');
		$email->send($id);
	}

}

?>
