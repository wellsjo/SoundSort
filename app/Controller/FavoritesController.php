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
			if ($Favorites) {
				foreach ($Favorites as $favorite) {
					$track = $this->Track->findById($favorite['Favorite']['track_id']);
					$favorite_tracks[] = $track['Track'];
				}
			}
		}

		foreach ($favorite_tracks as &$track) {
			$favorited = $this->Favorite->findByUserIdAndTrackId($User['User']['id'], $track['id']);
			if ($favorited) {
				$track['favorited'] = true;
			}else{
				$track['favorited'] = false;
			}
		}

		$return_list = json_encode($return_list);
		$this->set('tracks', $return_list);

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
