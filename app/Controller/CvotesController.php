<?php

// handles comment votes instead
class CvotesController extends AppController {

	var $uses = array('Comment', 'Cvote');

	function upvote($amount, $comment_id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$user_id = $User['User']['id'];
			$comment = $this->Comment->findById('$comment_id');
			if ($comment['Comment']['user_id'] != $user_id) {
				if ($amount == 2 || $amount == 0) {
					$this->Cvote->query("DELETE FROM cvotes WHERE user_id=$user_id AND comment_id=$comment_id");
				}
				if ($amount == 2 || $amount == 1) {
					$CVoteObject = array('Cvote' => array(
							'user_id' => $user_id,
							'comment_id' => $comment_id,
							'upvote' => 1,
							'downvote' => 0
							));
					$this->Cvote->save($CVoteObject);
				}
			}
		}
	}

	function downvote($amount, $comment_id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$user_id = $User['User']['id'];
			if ($amount == 2 || $amount == 0) {
				$this->Cvote->query("DELETE FROM cvotes WHERE user_id=$user_id AND comment_id=$comment_id");
			}
			if ($amount == 2 || $amount == 1) {
				$CVoteObject = array('Cvote' => array(
						'user_id' => $user_id,
						'comment_id' => $comment_id,
						'upvote' => 0,
						'downvote' => 1
						));
				$this->Cvote->save($CVoteObject);
			}
		}
	}

}

?>
