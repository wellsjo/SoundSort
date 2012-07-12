<?php

class VotesController extends AppController {

	function upvote($amount, $track_id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$user_id = $User['User']['id'];
			if ($amount == 2 || $amount == 0) {
				$this->Vote->deleteAll(array(
					'track_id' => $track_id,
					'user_id' => $user_id
				));
			}
			if ($amount == 2 || $amount == 1) {
				$VoteObject = array('Vote' => array(
						'user_id' => $user_id,
						'track_id' => $track_id,
						'upvote' => 1,
						'downvote' => 0
						));
				$this->Vote->save($VoteObject);
			}
		}
	}

	function downvote($amount, $id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$user_id = $User['User']['id'];
			if ($amount == 2 || $amount == 0) {
				$this->Vote->deleteAll(array(
					'track_id' => $id,
					'user_id' => $user_id
				));
			}
			if ($amount == 2 || $amount == 1) {
				$Vote = array('Vote' => array(
						'user_id' => $user_id,
						'track_id' => $id,
						'upvote' => 0,
						'downvote' => 1
						));
				$this->Vote->save($Vote);
			}
		}
	}

}

?>
