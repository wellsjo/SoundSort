<?php

Class CommentsController extends AppController {

	var $uses = 'Track';

	function index() {
		$track_id = $this->params['id'];
		$User = $this->auth();
		$this->set('auth_for_layout', $User);
		$Track = $this->Track->findById($track_id);
		$score = $this->Track->getScore($Track);
		$Track['Track']['score'] = $score;
		foreach ($Track['Vote'] as $vote) {
			if ($vote['user_id'] == $User['User']['id']) {
				if ($vote['upvote'] == 1) {
					$Track['Track']['upvoted'] = true;
				} else if ($vote['downvote'] == 1) {
					$Track['Track']['downvoted'] = true;
				}
			}
		}
		$this->set('Track', json_encode($Track));
	}

}

?>
