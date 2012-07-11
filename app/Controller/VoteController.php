<?php

class VoteController extends AppController {

	var $uses = array('Track', 'Vote');

	function upvote() {
		$this->autoRender = false;
		$User = $this->auth();
		if ($User) {
			$track_id = @$this->params['id'];
			$this->Vote->upvote($track_id, $User['User']['id']);
			pre_var_dump($this->Vote->getLastQuery());
//			var_dump($response);
//			return $response;
		}
	}

	function downvote() {
//		$this->autoRender = false;
//		$id = @$this->params['id'];
//		$response = $this->Track->downvote($id);
//		return $response;
	}

}

?>
