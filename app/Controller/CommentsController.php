<?php

Class CommentsController extends AppController {

	var $uses = array('Track', 'Comment', 'Cvote', 'Favorite', 'User');

	function index() {
		$this->set('page_for_layout', 'comments');
		$track_id = $this->params['id'];
		$User = $this->auth();
		$this->set('auth_for_layout', $User);
		$Track = $this->Track->findById($track_id);

		$score = $this->Track->getScore($Track);
		$Track['Track']['score'] = $score;

		$favorited = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $Track['Track']['id']);

		if ($favorited) {
			$Track['Track']['favorited'] = true;
		} else {
			$Track['Track']['favorited'] = false;
		}

		foreach ($Track['Comment'] as &$comment) {
			$comment['score'] = $this->Comment->getScore($comment);
			$User = $this->User->findById($comment['user_id']);
			$comment['user_name'] = $User['User']['name'];
			$comment['ago'] = $this->timeago($comment['created']);
			$vote = $this->Cvote->findByUserIdAndCommentId($User['User']['id'], $comment['id']);
			if ($vote) {
				if ($vote['Cvote']['downvote'] == 1) {
					$comment['downvoted'] = true;
				} else if ($vote['Cvote']['upvote'] == 1) {
					$comment['upvoted'] = true;
				}
			}
		}

		foreach ($Track['Vote'] as $vote) {
			if ($vote['user_id'] == $User['User']['id']) {
				if ($vote['upvote'] == 1) {
					$Track['Track']['upvoted'] = true;
				} else if ($vote['downvote'] == 1) {
					$Track['Track']['downvoted'] = true;
				}
			}
		}

		$this->set('PHPTrackObject', $Track);
		$this->set('Track', json_encode($Track));
	}

	function post($parent_id, $track_id) {
		$this->autoRender = false;
		$User = $this->auth();
		$this->Comment->create();
		$comment = array('Comment' => array(
				'user_id' => $User['User']['id'],
				'track_id' => $track_id,
				'created' => time(),
				'comment' => $_POST['comment'],
				'parent_id' => $parent_id
				));
		$Comment = $this->Comment->save($comment);
		$CVoteObject = array('Cvote' => array(
				'user_id' => $User['User']['id'],
				'comment_id' => $Comment['Comment']['id'],
				'upvote' => 1,
				'downvote' => 0
				));
		$this->Cvote->save($CVoteObject);
	}

}

?>
