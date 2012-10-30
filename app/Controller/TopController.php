<?php

Class TopController extends AppController {

	var $uses = array('Track', 'Favorite');

	function index() {
		$this->redirect('/all');
	}

	function all() {

		$User = $this->auth();
		$this->set('auth_for_layout', $User);
		$this->set('page_for_layout', 'all');

		$page = @$this->params['id'];
		if (!empty($page)) {
			$this->set('page', $page);
			$this->set('display', $page);
		} else {
			$this->redirect('/all/1');
		}

		$TrackList = $this->Track->find('all', array(
			'limit' => 200,
			'order' => array(
				'created_at' => 'DESC'
				)));
		$TrackList = $this->topSort($TrackList);

		foreach ($TrackList as &$track) {
			$track['Track']['comment_count'] = count($track['Comment']);
			foreach ($track['Vote'] as $vote) {
				if ($vote['user_id'] == $User['User']['id']) {
					if ($vote['upvote'] == 1) {
						$track['Track']['upvoted'] = true;
					} else if ($vote['downvote'] == 1) {
						$track['Track']['downvoted'] = true;
					}
				}
			}
		}

		$return_list = array();
		$offset = (--$page) * 10;
		for ($off_start = $offset; $off_start < ($offset + 10); $off_start++) {
			$return_list[] = $TrackList[$off_start]['Track'];
		}

		foreach ($return_list as &$track) {
			$favorited = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $track['id']);
			if ($favorited) {
				$track['favorited'] = true;
			} else {
				$track['favorited'] = false;
			}
		}

		$JSON_return_list = json_encode($return_list);
		$this->set('tracks', $JSON_return_list);
		$this->set('active', 'all');
	}

	function topSort($tracks) {
		foreach ($tracks as &$track) {
			$score = $this->Track->getScore($track);
			$track['Track']['score'] = $score;
			$order = log(max(abs($score), 1), 10);
			if ($score > 0) {
				$sign = 1;
			} elseif ($score < 0) {
				$sign = -1;
			} else {
				$sign = 0;
			}
			$seconds = floor(strtotime($track['Track']['created_at'])) - 1134028003;
			$track['Track']['hotness'] = round(($order + (($sign * $seconds) / 45000)), 7);
		}

		// function used to sort the posts
		function cmp($a, $b) {
			if ($a['Track']['hotness'] < $b['Track']['hotness']) {
				return 1;
			} else if ($a['Track']['hotness'] > $b['Track']['hotness']) {
				return -1;
			} else {
				return 0;
			}
		}

		usort($tracks, "cmp");
		return $tracks;
	}

	function genre() {
		$User = $this->auth();
		$this->set('auth_for_layout', $User);

		$page = @$this->params['id'];
		$genre = @$this->params['genre'];
		$this->set('page_for_layout', 'all');

		if (!empty($page)) {
			$this->set('page', $page);
			$this->set('display', $page);
		} else {
			$this->redirect("/$genre/1");
		}

		$genre = ucwords($genre);

		$TrackList = $this->Track->find('all', array(
			'conditions' => array(
				'genre' => $genre
			),
			'limit' => 200,
			'order' => array(
				'created_at' => 'DESC'
				)));
		$TrackList = $this->topSort($TrackList);

		foreach ($TrackList as &$track) {
			$track['Track']['comment_count'] = count($track['Comment']);
			foreach ($track['Vote'] as $vote) {
				if ($vote['user_id'] == $User['User']['id']) {
					if ($vote['upvote'] == 1) {
						$track['Track']['upvoted'] = true;
					} else if ($vote['downvote'] == 1) {
						$track['Track']['downvoted'] = true;
					}
				}
			}
		}

		$return_list = array();
		$offset = (--$page) * 10;
		for ($off_start = $offset; $off_start < ($offset + 10); $off_start++) {
			$return_list[] = $TrackList[$off_start]['Track'];
		}

		foreach ($return_list as &$track) {
			$favorited = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $track['id']);
			if ($favorited) {
				$track['favorited'] = true;
			} else {
				$track['favorited'] = false;
			}
		}

		$JSON_return_list = json_encode($return_list);
		$this->set('tracks', $JSON_return_list);
		$this->set('active', lcfirst($genre));
	}

}

?>
