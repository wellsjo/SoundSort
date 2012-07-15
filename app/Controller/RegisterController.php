<?php

App::uses('CakeEmail', 'Network/Email');

class RegisterController extends AppController {

	var $uses = 'User';

	function index() {
		$Auth = $this->auth();
		$this->set('auth_for_layout', $Auth);
		if (!empty($_POST)) {
			$this->redirect('/register/confirm');
		}
	}

	function confirm() {
		$Auth = $this->auth();
		$this->set('auth_for_layout', $Auth);
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

	function activated($id) {
		$Auth = $this->auth();
		$this->set('auth_for_layout', $Auth);
		$user_id = $id;
		$User = $this->User->findById($user_id);
		$User['User']['activated'] = 1;
		$this->set('user', $User);
		$this->User->save($User);
	}

	private function sendEmailConfirmation($id, $user_email) {
		$email = new CakeEmail('smtp');
		$email->to($user_email);
		$email->subject('SoundSort Authentication');
		$email->template('email_confirm');
		$email->emailFormat('html');
		$email->send($id);
	}

}

?>
