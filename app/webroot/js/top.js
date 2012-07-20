$(document).ready(function() {
	SC.initialize({
		client_id: "4ca806233abc6f50dfbd8c124380277b",
		redirect_uri: "http://wellsstuff.com/trending"
	});

	for (var track_index in tracks) {
		SC_Player(tracks[track_index], '#trend_container');
	}
	render();
});

function render() {
	$('.track_container').first().children('.sc-player').children('.sc-controls').children('.sc-play, .sc-pause').addClass('player-active');
	$('.track_container').first().children('.sc-player').addClass('player-active');

	$('.sc-controls').click(function() {
		$('.player-active').removeClass('player-active');
		$(this).children('.sc-play, .sc-pause').addClass('player-active');
		$(this).parents().addClass('player-active');
	});

	$('.sc-play').click(function(){
		$('#play-all').addClass('playing-all');
		$('#play-all').children('i').addClass('icon-pause');
	})

	$('.sc-pause').click(function() {
		$('#play-all').removeClass('playing-all');
		$('#play-all').children('i').removeClass('icon-pause');
	});
}