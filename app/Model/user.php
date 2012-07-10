<?php

class User extends AppModel {

	public $name = 'User';
	public $validate = array();

	function register($user) {
		$result = $this->save($user);
		return $result;
	}

}

?>
