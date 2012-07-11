<?php

//App::uses('AppModel', 'Model');

/**
 * Moth Model
 *
 */
class Vote extends AppModel {
	var $useTable = 'votes';
	var $name = 'Vote';

	function upvote($id, $user_id) {
		$VoteObject = array('Vote' => array(
				'u_id' => $user_id,
				't_id' => $id,
				'upvote' => 1,
				'downvote' => 0
				));
		$this->save($VoteObject);
	}

	function downvote($id, $user_id) {
		$Vote = array('Vote' => array(
				'user_id' => $user_id,
				'track_id' => $id,
				'upvote' => 0,
				'downvote' => 1
				));
		$this->save($Vote);
	}

}

?>