<?php

App::import('Model', 'Vote');

class Track extends AppModel {

	var $hasMany = array('Vote', 'Comment');
	var $name = 'Track';

	function upvote($id, $user_id) {
		$track = $this->findById($id);
		$track['Track']['upvotes'] += 1;
		$this->save($track);

		$VoteObject = array('Vote' => array(
				'user_id' => $user_id,
				'track_id' => $id,
				'upvote' => 1,
				'downvote' => 0
				));
		$vote = new Vote();
		$vote->create();
		$vote->save($VoteObject);
	}

	function downvote($id, $user_id) {
		$track = $this->findById($id);
		$track['Track']['downvotes'] += 1;
		$Vote = array('Vote' => array(
				'user_id' => $user_id,
				'track_id' => $id,
				'upvote' => 0,
				'downvote' => 1
				));
		$this->Vote->save($Vote);
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

	// not really used anymore
	function retrieveSoundCloudTracks($page, $genre) {
		APP::import('Vendor', 'Soundcloud');
		$SoundCloud = new Services_Soundcloud('4ca806233abc6f50dfbd8c124380277b', 'f31a95747981711da55ab9823b54cbf9', 'http://soundsort.com');

		$offset = (--$page) * 10;
		$track_options = array(
			'limit' => 10,
			'offset' => $offset,
			'order' => 'hotness',
			'filter' => 'downloadable',
			'genre' => $genre
		);

		try {
			$tracks = $SoundCloud->get('tracks', $track_options, array());
		} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
			exit($e->getMessage());
		}

		return $tracks;
	}

	function getScore($track_record) {
		$score = 1;
		if (count($track_record['Vote']) == 0) return $score;
		foreach ($track_record['Vote'] as $vote) {
			$score += $vote['upvote'];
			$score -= $vote['downvote'];
		}
		return $score;
	}

}

?>
