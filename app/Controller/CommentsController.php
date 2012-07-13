<?php

Class CommentsController extends AppController {

	var $uses = array('Track', 'Comment');

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
		$this->set('Track', $Track);
	}

	function post($parent_id, $track_id) {
		$this->autoRender = false;
		$User = $this->auth();
		$this->Comment->create();
		$comment = array('Comment' => array(
			'user_id' => $User['User']['id'],
			'track_id' => $track_id,
			'comment' => $_POST['comment'],
			'parent_id' => $parent_id
		));
		$this->Comment->save($comment);
	}

}

?>
