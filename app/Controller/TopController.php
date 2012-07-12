<?php

Class TopController extends AppController {

	var $uses = array('Track');

	function index() {
		$this->redirect('/top');
	}

	function top() {
		$User = $this->auth();
		$this->set('auth_for_layout', $User);

		$page = @$this->params['id'];
		if (!empty($page)) {
			$this->set('page', $page);
			if ($page == 1) {
				$this->set('display', 'Front Page');
			} else {
				$this->set('display', 'Page ' . $page);
			}
		} else {
			$this->redirect('/top/1');
		}

		$tracks = $this->Track->getSoundCloudTracks($page);
		$tracks = json_decode($tracks, true);
		$SCTracks = array();
		foreach ($tracks as &$track) {
			$response = $this->Track->findById($track['id']);
			if (empty($response)) {
				$response = $this->Track->syncTrack($track);
			}
			$SCTracks[] = $response;
		}

		$TrackList = $this->Track->find('all', array(
			'limit' => 200,
			'order' => array(
				'created_at' => 'DESC'
				)));
		$TrackList = $this->topSort($TrackList);

		foreach ($TrackList as &$track) {
			foreach ($track['Vote'] as $vote) {
				if ($vote['user_id'] == $User['User']['id']) {
					if ($vote['upvote'] == 1) {
						$track['Track']['upvoted'] = true;
					}else if ($vote['downvote'] == 1){
						$track['Track']['downvoted'] = true;
					}

				}
			}
		}

		$return_list = array();
		$offset = (--$page) * 10;
		for ($off_start = $offset; $off_start < ($offset + 10); $off_start++) {
			if (isset($TrackList[$off_start])) {
				$return_list[] = $TrackList[$off_start]['Track'];
			} else {
				$return_list[] = $SCTracks[$off_start - $offset]['Track'];
			}
		}

		$return_list = json_encode($return_list);
		$this->set('tracks', $return_list);
		$this->set('active', 'top');
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

}

?>
