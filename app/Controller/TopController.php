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

//		APP::import('Vendor', 'Soundcloud');
//		$SoundCloud = new Services_Soundcloud('4ca806233abc6f50dfbd8c124380277b', 'f31a95747981711da55ab9823b54cbf9', 'http://wellsstuff.com/trending');
//
//		$offset = (--$page) * 10;
//		$track_options = array(
//			'limit' => 10,
//			'offset' => $offset,
//			'order' => 'hotness',
//			'filter' => 'downloadable',
//		);
//
//		try {
//			$tracks = $SoundCloud->get('tracks', $track_options, array());
//		} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
//			exit($e->getMessage());
//		}
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

	function getSoundCloudTracks() {
		
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
