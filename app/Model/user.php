<?php

class User extends AppModel {

	var $name = 'User';
	var $hasMany = array('Comment', 'Vote', 'Favorite');

	function register($user) {
		$result = $this->save($user);
		return $result;
	}

}

?>
