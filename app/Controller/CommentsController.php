<?php

Class CommentsController extends AppController {

	var $uses = 'Track';

	function index() {
		$track_id = $this->params['id'];
		$User = $this->auth();
		$this->set('auth_for_layout', $User);
		$Track = $this->Track->findById($track_id);
		$this->set('Track', json_encode($Track));
	}

}

?>
