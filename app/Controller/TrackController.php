<?php

Class TrackController extends AppController {

	var $uses = 'Track';

	function upvote() {
		$this->autoRender = false;
		$id = @$this->params['id'];
		$response = $this->Track->upvote($id);
		return $response;
	}

	function downvote() {
		$this->autoRender = false;
		$id = @$this->params['id'];
		$response = $this->Track->downvote($id);
		return $response;
	}

}

?>
