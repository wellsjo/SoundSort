<?php

include('Soundcloud.php');

$con = mysql_connect('tunnel.pagodabox.com', 'gisela', '2x6Md9sT');
mysql_select_db("SS_DB", $con);

$SoundCloud = new Services_Soundcloud('4ca806233abc6f50dfbd8c124380277b', 'f31a95747981711da55ab9823b54cbf9', 'http://soundsort.com');

// Dubstep

$track_options = array(
	'limit' => 10,
	'order' => 'hotness',
	'filter' => 'downloadable',
	'tags' => 'dubstep'
);

try {
	$tracks = $SoundCloud->get('tracks', $track_options, array());
} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
	exit($e->getMessage());
}

$decoded_tracks = json_decode($tracks, true);

foreach ($decoded_tracks as &$track) {
	$track_id = $track['id'];
	$track_title = $track['title'];
	$created_at = $track['created_at'];
	$uri = $track['uri'];
	$permalink_url = $track['permalink_url'];
	$genre = 'Dubstep';
	$sql_insert = "INSERT INTO tracks (id, title, created_at, uri, permalink_url, genre)
			VALUES ('$track_id', '$track_title', '$created_at', '$uri', '$permalink_url', '$genre')";
	$result = mysql_query($sql_insert);
}

// Rap

$track_options = array(
	'limit' => 10,
	'order' => 'hotness',
	'filter' => 'downloadable',
	'tags' => 'rap'
);

try {
	$tracks = $SoundCloud->get('tracks', $track_options, array());
} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
	exit($e->getMessage());
}

$decoded_tracks = json_decode($tracks, true);

foreach ($decoded_tracks as &$track) {
	$track_id = $track['id'];
	$track_title = $track['title'];
	$created_at = $track['created_at'];
	$uri = $track['uri'];
	$permalink_url = $track['permalink_url'];
	$genre = 'Rap';
	$sql_insert = "INSERT INTO tracks (id, title, created_at, uri, permalink_url, genre)
			VALUES ('$track_id', '$track_title', '$created_at', '$uri', '$permalink_url', '$genre')";
	$result = mysql_query($sql_insert);
}

// Electronic

$track_options = array(
	'limit' => 10,
	'order' => 'hotness',
	'filter' => 'downloadable',
	'tags' => 'electronic'
);

try {
	$tracks = $SoundCloud->get('tracks', $track_options, array());
} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
	exit($e->getMessage());
}

$decoded_tracks = json_decode($tracks, true);

foreach ($decoded_tracks as &$track) {
	$track_id = $track['id'];
	$track_title = $track['title'];
	$created_at = $track['created_at'];
	$uri = $track['uri'];
	$permalink_url = $track['permalink_url'];
	$genre = 'Electronic';
	$sql_insert = "INSERT INTO tracks (id, title, created_at, uri, permalink_url, genre)
			VALUES ('$track_id', '$track_title', '$created_at', '$uri', '$permalink_url', '$genre')";
	$result = mysql_query($sql_insert);
}


// All

$track_options = array(
	'limit' => 10,
	'order' => 'hotness',
	'filter' => 'downloadable',
);

try {
	$tracks = $SoundCloud->get('tracks', $track_options, array());
} catch (Services_Soundcloud_Invalid_Http_Response_Code_Exception $e) {
	exit($e->getMessage());
}

$decoded_tracks = json_decode($tracks, true);

foreach ($decoded_tracks as &$track) {
	$track_id = $track['id'];
	$track_title = $track['title'];
	$created_at = $track['created_at'];
	$uri = $track['uri'];
	$permalink_url = $track['permalink_url'];
	$genre = $track['genre'];
	$sql_insert = "INSERT INTO tracks (id, title, created_at, uri, permalink_url, genre)
			VALUES ('$track_id', '$track_title', '$created_at', '$uri', '$permalink_url', '$genre')";
	$result = mysql_query($sql_insert);
}

?>
