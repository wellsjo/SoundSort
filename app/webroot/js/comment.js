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

	$('#submit_comment').click(function() {
		if (readCookie('logged_in')){
			var parent_id = $(this).parent().data('parent_id');
			$.post('/comments/post/' + parent_id + '/' + track.Track.id, {
				comment: $(this).parent().children('textarea').val()
			});
		}else{
			$('#error_message').text('You must log in to vote or comment!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
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
	afterRender();
}

function afterRender() {
	$('.upvote').click(function(e) {
		if (readCookie('logged_in')){
			var track = $(e.currentTarget).data('track_id');
			var count = $(e.currentTarget).parent().children('.vote_count').text();
			if (!$(this).hasClass('upvoted')) {
				$(this).addClass('upvoted');
				if ($(this).parent().children('.downvote').hasClass('downvoted')) {
					$(this).parent().children('.vote_count').text(Number(count)+2);
					$(this).parent().children('.downvote').removeClass('downvoted');
					$.post('/votes/upvote/2/' + track);
				}else{
					$(this).parent().children('.vote_count').text(Number(count)+1);
					$.post('/votes/upvote/1/' + track);
				}
			}else{
				$(this).removeClass('upvoted');
				$(this).parent().children('.vote_count').text(Number(count)-1);
				$.post('/votes/upvote/0/' + track);
			}
		}else{
			$('#error_message').text('You must log in to vote or comment!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
	});

	$('.downvote').click(function(e) {
		if (readCookie('logged_in')){
			var track = $(e.currentTarget).data('track_id');
			var count = $(e.currentTarget).parent().children('.vote_count').text();
			if (!$(this).hasClass('downvoted')) {
				$(this).addClass('downvoted');
				if ($(this).parent().children('.upvote').hasClass('upvoted')) {
					$(this).parent().children('.vote_count').text(Number(count)-2);
					$(this).parent().children('.upvote').removeClass('upvoted');
					$.post('/votes/downvote/2/' + track);
				}else{
					$(this).parent().children('.vote_count').text(Number(count)-1);
					$.post('/votes/downvote/1/' + track);
				}
			}else{
				$(this).removeClass('downvoted');
				$(this).parent().children('.vote_count').text(Number(count)+1);
				$.post('/votes/downvote/0/' + track);
			}
		}else{
			$('#error_message').text('You must log in to vote or comment!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
	});
}

function readCookie(cookieName) {
	var theCookie=" "+document.cookie;
	var ind=theCookie.indexOf("["+cookieName+"]=");
	if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
	if (ind==-1 || cookieName=="") return "";
	var ind1=theCookie.indexOf(";",ind+1);
	if (ind1==-1) ind1=theCookie.length;
	return unescape(theCookie.substring(ind+cookieName.length+3,ind1));
}