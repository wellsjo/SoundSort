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
			}else{
				$this->set('display', 'Page ' . $page);
			}
			
		} else {
			$this->redirect('/top/1');
		}

		APP::import('Vendor', 'Soundcloud');
		$SoundCloud = new Services_Soundcloud('4ca806233abc6f50dfbd8c124380277b', 'f31a95747981711da55ab9823b54cbf9', 'http://wellsstuff.com/trending');

		$offset = (--$page) * 10;
		$track_options = array(
			'limit' => 10,
			'offset' => $offset,
			'order' => 'hotness',
			'filter' => 'downloadable',
		);

		try {
			$tracks = $SoundCloud->get('tracks', $track_options, array());
		} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
			exit($e->getMessage());
		}

		$tracks = json_decode($tracks, true);
		foreach ($tracks as &$track) {
			$response = $this->Track->findById($track['id']);
			if (empty($response)) {
				$this->Track->syncTrack($track);
				$track['vote_count'] = 1;
			}else{
				$track['vote_count'] = $response['Track']['upvotes'] - $response['Track']['downvotes'];
			}
		}
		
		$this->Track->find('all', array('conditions' => array(
			
		)));

		// find the tracks to return
		$tracks = json_encode($tracks);
		$this->set('tracks', $tracks);
		$this->set('active', 'top');
	}

	function topSort($tracks) {
		
	}

}

?>
