<?php

Class TrackController extends AppController {

	var $uses = array('Track', 'Vote');

	function upvote() {
		$this->autoRender = false;
		$User = $this->auth();
		if (!$User) {
			return false;
		} else {
			$id = @$this->params['id'];
			$response = $this->Track->upvote($id, $User['User']['id']);
			return $response;
		}
	}

	function downvote() {
		$this->autoRender = false;
		$id = @$this->params['id'];
		$response = $this->Track->downvote($id);
		return $response;
	}

}

?>
