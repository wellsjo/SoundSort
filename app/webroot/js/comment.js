$(document).ready(function() {
	SC.initialize({
		client_id: "4ca806233abc6f50dfbd8c124380277b",
		redirect_uri: "http://soundsort.com/top/1"
	});
	$('#track_container').append('<span class=\'track_container\' data-track_id=\'' + track.Track.id +
		'\' data-dl_link=\'' + track.Track.permalink_url + '/download' + '\' data-vote_count=\''
		+ track.Track.score + '\''
		+ 'data-genre=\'' + track.Track.genre + '\'><div id=\'track' + track.Track.id + '\' </div></span>');
	$('#track' + track.Track.id).scPlayer({
		links: [{
			url: track.Track.uri,
			title: track.Track.title
		}]
	});
	render();
});

function render() {
	$('.sc-play').click(function() {
		$(this).parent().children('.sc-pause').removeClass('hidden');
	});

	$('.sc-player').each(function() {
		var track_id = $(this).parent().data('track_id');
		var vote_count = $(this).parent().data('vote_count');
		$(this)
		.append('<a href=\'' + $(this).parent().data('dl_link') + '/download'
			+ '\' class=\'download_track btn btn-small\'>Download</a>'
			).append(
			'<span class=\'vote_container\'><div data-track_id=\'' + track_id + '\'class=\'arrow-up upvote\' ></div>'
			+ '<div data-vote_count=\'' + vote_count + '\' class=\'vote_count\' >' + vote_count + '</div>'
			+ '<div data-track_id=\'' + track_id + '\'class=\'arrow-down downvote\' ></div></span>'
			);
	});
	if (track.Track.upvoted == true) {
		$('.upvote[data-track_id="' + track.Track.id + '"]').addClass('upvoted');
	}else if (track.Track.downvoted == true) {
		$('.downvote[data-track_id="' + track.Track.id + '"]').addClass('downvoted');
	}
}