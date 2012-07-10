<?php

Class TopController extends AppController {

	var $uses = array('Track');

	function index() {
		$this->redirect('/top');
	}

	function top() {
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
		foreach ($tracks as &$track) {
			$response = $this->Track->findById($track['id']);
			if (empty($response)) {
				$this->Track->syncTrack($track);
			} 
		}

		$TrackList = $this->Track->find('all', array(
			'limit' => 200,
			'order' => array(
				'created_at' => 'DESC'
			)));

		$TrackList = $this->topSort($TrackList);
		$return_list = array();
		$offset = (--$page) * 10;
		for ($off_start = $offset; $off_start < ($offset+10); $off_start++) {
			$return_list[] = $TrackList[$off_start]['Track'];
		}
		
		$return_list = json_encode($return_list);
		$this->set('tracks', $return_list);
		$this->set('active', 'top');
	}

	function topSort($tracks) {
		foreach ($tracks as &$track) {
			$score = $track['Track']['upvotes'] - $track['Track']['downvotes'];
			$order = log(max(abs($score), 1), 10);
			if ($score > 0) {
				$sign = 1;
			} elseif ($score < 0) {
				$sign = -1;
			} else {
				$sign = 0;
			}
			$seconds = floor(strtotime($track['Track']['created_at'])) - 1134028003;
			$track['hotness'] = round(($order + (($sign * $seconds) / 45000)), 7);
		}

		// function used to sort the posts
		function cmp($a, $b) {
			if ($a['hotness'] < $b['hotness']) {
				return 1;
			} else if ($a['hotness'] > $b['hotness']) {
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
