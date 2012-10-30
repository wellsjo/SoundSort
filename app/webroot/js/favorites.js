$(document).ready(function() {
	SC.initialize({
		client_id: "4ca806233abc6f50dfbd8c124380277b",
		redirect_uri: "http://wellsstuff.com/trending"
	});

	if (tracks == 'none') {
		$('#error_message').text('You don\'t have any favorites yet!').removeClass('hidden');
	}else if (tracks) {
		for (var track_index in tracks) {
			SC_Player(tracks[track_index], '#favorite_container');
		}
		render();
	}
});

function render() {

	$('#favorite_container').children('span').first().children('.sc-player').children('.sc-controls').children('.sc-play, .sc-pause').addClass('player-active');
	$('.track_container').first().children('.sc-player').addClass('player-active');
	$('.sc-controls').click(function() {
		$('.player-active').removeClass('player-active');
		$(this).children('.sc-play, .sc-pause').addClass('player-active');
		$(this).parents().addClass('player-active');
	});

	$('a').click(function(e) {
		if ($('#play-all').hasClass('playing-all')) {
			if ($(e.currentTarget).attr('id') == 'play-all' || $(e.currentTarget).hasClass('sc-play') || $(e.currentTarget).hasClass('sc-pause')
				 || $(e.currentTarget).hasClass('close')) {
				console.log('Smoothies!');
			}else{
				e.preventDefault();
				$('#MusicWarning').modal('toggle');
				$('#continue_link').data('link', e.currentTarget.href);
			}
		}
	});
	
	$('.sc-play').click(function(){
		$('#play-all').addClass('playing-all');
		$('#play-all').children('i').addClass('icon-pause');
	})

	$('.sc-pause').click(function() {
		$('#play-all').removeClass('playing-all');
		$('#play-all').children('i').removeClass('icon-pause');
	});

	$(document).bind('onPlayerInit.scPlayer', function(event){
		$('h3').children('a').click(function(e){
			e.preventDefault();
		})
	});

	$(document).bind('scPlayer:onMediaEnd', function(player, data) {
		$('.player-active').parent().parent().parent().next('span').children('.sc-player').children('.sc-controls').children('.sc-play').click();
	});

}