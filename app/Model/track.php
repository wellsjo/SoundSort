<?php

class Track extends AppModel {

	public $name = 'Track';
	public $validate = array();

	function upvote($id) {
		$track = $this->findById($id);
		$track['Track']['upvotes'] += 1;
		$this->save($track);
	}

	function downvote($id) {
		$track = $this->findById($id);
		$track['Track']['downvotes'] += 1;
		$this->save($track);
	}

	function syncTrack($track) {
		$this->create();
		$date = new DateTime();
		$data = array('Track' => array(
				'id' => $track['id'],
				'title' => $track['title'],
				'created_at' => $date->format("Y-m-d H:m:s"),
				'uri' => $track['uri'],
				'permalink_url' => $track['permalink_url'],
				'genre' => $track['genre'],
				'upvotes' => 1,
				'downvotes' => 0
				));
		$this->save($data);
		return $data;
	}

	function getSoundCloudTracks($page) {
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

		return $tracks;
	}

}

?>
