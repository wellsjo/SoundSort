var SC_Player = function(track, element, hide_comment_button) {
	if (!hide_comment_button) {
		this.hide_comment_button = false;
	}else{
		this.hide_comment_button = true;
	}
	this._track = track;
	this.element = element;
	
	this.load = function() {
		$(this.element).append(
			'<span id=\'_track'+ this._track.id + '\' data-favorited=\''+this._track.favorited
			+'\' data-track_id=\'' + this._track.id
			+'\' data-dl_link=\'' + this._track.permalink_url + '/download' + '\' data-vote_count=\''
			+ this._track.score + '\' data-genre=\'' + this._track.genre + '\'><div class=\'track_container\'></div></span>');

		$('#_track' + this._track.id).children('.track_container').scPlayer({
			links: [{
				url: this._track.uri,
				title: this._track.title
			}],
			beforeRender: function(track_data) {
				// put code to check for bad track info here
			}
		});

		this.afterLoad();
	}

	this.afterLoad = function() {
		
		var sc_player = $('#_track' + this._track.id).children('.sc-player');

		$(sc_player).children('.sc-controls').children('.sc-play').click(function() {
			$(this).parent().children('.sc-pause').removeClass('hidden');
		});

		var artist_string = $(sc_player).children('.sc-info').children('h4').text();
		artist_string = artist_string.substring(3, artist_string.length);
		$(sc_player).children('.sc-info').children('h4').html(artist_string);

		$(sc_player).append(
			'<div class="comment_count"></div><a href=\'' + $(sc_player).parent().data('dl_link')
			+ '\' class=\'download_track btn btn-small\'><i class=\'icon-download-alt\'></i></a>'
			+'<button class=\'favorite_link btn btn-small\' ><i class=\'heart-shape\'></i></button>'
			+'<span class=\'vote_container\'><div data-track_id=\'' + this._track.id + '\'class=\'arrow-up upvote\' ></div>'
			+ '<div data-vote_count=\'' + this._track.score + '\' class=\'vote_count\' >' + this._track.score + '</div>'
			+ '<div data-track_id=\'' + this._track.id + '\'class=\'arrow-down downvote\' ></div></span>'
			+'<a class = \'btn btn-small comment_link\' href=\'/comments/' + this._track.id + '\'>'
			+"<div class=\"spch-bub-outside\"><span class=\"point\"></span><span class=\"bubble\"></span><span class=\'icon_comment_count\'>(" + this._track.comment_count + ")</span></div></a>"
			);

		var favorited = $(sc_player).parent().data('favorited');
		if (favorited) $(sc_player).children('.favorite_link').children('.heart-shape').addClass('favorited');

		if (this._track.upvoted == true) {
			$('.upvote[data-track_id="' + this._track.id + '"]').addClass('upvoted');
		}else if (this._track.downvoted == true) {
			$('.downvote[data-track_id="' + this._track.id + '"]').addClass('downvoted');
		}

		this.setHandlers();
	}

	this.setHandlers = function() {
		if (this.hide_comment_button) $('.comment_link').hide();
		
		var sc_player = $('#_track'+this._track.id).children('.sc-player');

		$(sc_player).children('.favorite_link').hover(function() {
			$(this).children('.heart-shape').addClass('red-heart');
		}, function() {
			$(this).children('.heart-shape').removeClass('red-heart');
		});

		$(sc_player).children('.comment_link').hover(function() {
			$(this).children('.spch-bub-outside').children('.bubble').addClass('comment_bubble_hover');
			$(this).children('.spch-bub-outside').children('.point').addClass('comment_point_hover');
		}, function() {
			$(this).children('.spch-bub-outside').children('.bubble').removeClass('comment_bubble_hover');
			$(this).children('.spch-bub-outside').children('.point').removeClass('comment_point_hover');
		});

		$(sc_player).children('.sc-controls').children('.sc-play').click(function() {
			$(this).parent().children('.sc-pause').removeClass('hidden');
		});

		$(sc_player).children('.favorite_link').click(function() {
			if (readCookie('logged_in')) {
				var track_id = $(this).parent().parent().data('track_id');
				var favorited = $(this).children('i').hasClass('favorited');
				if (favorited) {
					$.post('/favorites/remove/' + track_id);
					$(this).children('i').removeClass('favorited');
				}else{
					$.post('/favorites/add/' + track_id);
					$(this).children('i').addClass('favorited');
				}
			}else{
				$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
				window.scrollTo(0, 0);
			}
		});

		$(sc_player).children('.vote_container').children('.upvote').click(function(e) {
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
				$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
				window.scrollTo(0, 0);
			}
		});

		$(sc_player).children('.vote_container').children('.downvote').click(function(e) {
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
				$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
				window.scrollTo(0, 0);
			}
		});
	}

	this.load();
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