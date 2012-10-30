<?php

Class FavoritesController extends AppController {

	var $uses = array('Favorite', 'Track');

	function index() {
		$User = $this->auth();
		$favorite_tracks = array();

		if ($User) {
			$Favorites = $this->Favorite->find('all', array('conditions' => array(
					'user_id' => $User['User']['id']
					)));
		}

		if ($Favorites) {
			foreach ($Favorites as $favorite) {
				$track = $this->Track->findById($favorite['Favorite']['track_id']);
				$favorite_tracks[] = $track;
			}
			foreach ($favorite_tracks as &$track) {
				$track['Track']['comment_count'] = count($track['Comment']);
				$score = $this->Track->getScore($track);
				$track['Track']['score'] = $score;
				$favorited = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $track['Track']['id']);
				if ($favorited) {
					$track['Track']['favorited'] = true;
				} else {
					$track['Track']['favorited'] = false;
				}
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

			$return_tracks = array();
			foreach ($favorite_tracks as &$track) {
				$return_tracks[] = $track['Track'];
			}

			$return_list = json_encode($return_tracks);
			$this->set('tracks', $return_list);
			$this->set('tracks_exist', true);
		}else{
			$this->set('tracks_exist', false);
		}

		$this->set('auth_for_layout', $User);
		$this->set('page_for_layout', 'favorites');
		$this->set('active', 'favorites');
	}

	function add($track_id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$already_there = $this->Favorite->findById($track_id);
			if (!$already_there) {
				$FavoriteObject = array('Favorite' => array(
						'track_id' => $track_id,
						'user_id' => $User['User']['id']
						));
				$this->Favorite->save($FavoriteObject);
			}
		} else {
			return json_encode(false);
		}
	}

	function remove($track_id) {
		$this->autoRender = false;
		$User = $this->auth();
		if (!empty($User)) {
			$result = false;
			$Favorite = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $track_id);
			if ($Favorite) {
				$result = $this->Favorite->delete($Favorite['Favorite']['id']);
			}
			return json_encode($result);
		}
		return json_encode(false);
	}

}

?>
