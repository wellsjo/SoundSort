/*
 *      globals
 * _page : current page
 * tracks : tracks passed through from server
 *
 * */

$(document).ready(function() {
	SC.initialize({
		client_id: "4ca806233abc6f50dfbd8c124380277b",
		redirect_uri: "http://wellsstuff.com/trending"
	});
	for (var track_index in tracks) {
		$('#trend_container').append('<span class=\'track_container\' data-track_id=\'' + tracks[track_index].id +
			'\' data-dl_link=\'' + tracks[track_index].permalink_url + '/download' + '\' data-vote_count=\''
			+ tracks[track_index].vote_count + '\' ><div id=\'track' + track_index + '\' </div></span>');
		$('#track' + track_index).scPlayer({
			links: [{
				url: tracks[track_index].uri,
				title: tracks[track_index].title
			}]
		});
	}
	render();
	
});

function render() {
	$('.sc-play').click(function() {
		$(this).parent().children('.sc-pause').removeClass('hidden');
	});

	$('.sc-player').each(function() {
		var track_id = $(this).parent().data('track_id');
		var vote_count = $(this).parent().data('vote_count');
		$(this).append('<a href=\'' + $(this).parent().data('dl_link') + '/download' + '\' class=\'download_track btn btn-small\'>Download</a>');
		$(this).append(
			'<span class=\'vote_container\'><div data-track_id=\'' + track_id + '\'class=\'arrow-up upvote\' ></div>'
			+ '<div data-vote_count=\'' + vote_count + '\' class=\'vote_count\' >' + vote_count + '</div>'
			+ '<div data-track_id=\'' + track_id + '\'class=\'arrow-down downvote\' ></div></span>'
		);
	});

	afterRender();
}

function afterRender() {
	$('.upvote').click(function(e) {
		var track = $(e.currentTarget).data('track_id');
		var count = $(e.currentTarget).parent().children('.vote_count').text();
		$(e.currentTarget).parent().children('.vote_count').text(Number(count)+1);
		$.post('/track/upvote/' + track);
	});

	$('.downvote').click(function(e) {
		var track = $(e.currentTarget).data('track_id');
		var count = $(e.currentTarget).parent().children('.vote_count').text();
		$(e.currentTarget).parent().children('.vote_count').text(Number(count)-1);
		$.post('/track/downvote/' + track);
	});
}