<?php

class Track extends AppModel {
	public $name = 'Track';
	
	public $validate = array(

	);
	
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
		$data = array( 'Track' => array(
			'id' => $track['id'],
			'content' => json_encode($track),
			'created_at' => $track['created_at'],
			'upvotes' => 1,
			'downvotes' => 0
		));
		$this->save($data);
	}

}

?>
