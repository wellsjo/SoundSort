$(document).ready(function() {
	SC.initialize({
		client_id: "4ca806233abc6f50dfbd8c124380277b",
		redirect_uri: "http://soundsort.com/top/1"
	});

	var player = track.Track;
	SC_Player(player, '#track_container', true);

	$(document).bind('onPlayerInit.scPlayer', function(event){
		$('h3').children('a').click(function(e){
			e.preventDefault();
		})
	});
	
	$('.comment_reply_submit').click(function() {
		var self = this;
		$(self).parent().hide();
		if (readCookie('logged_in')){
			var parent_id = $(this).data('parent_id');
			var comment = $(self).siblings('.root_comment_box').val();
			addComment(comment, parent_id);
			$.post('/comments/post/' + parent_id + '/' + track.Track.id, {
				comment: comment
			});
		}else{
			$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
	});

	
	$('.reply').click(function(){
		$(this).siblings('.top_comment_area').show('fast');
		$(this).hide();
	});
	
	$('.cancel_reply').click(function() {
		$(this).parent().hide('fast');
		$(this).parent().siblings('.reply').show();
	});
	
	$('.hide_children').click(function() {
		if($(this).text() == '-hide children'){
			$(this).parent().children('.comment').hide('fast');
			$(this).text('+show children');
		}else{
			$(this).parent().children('.comment').show('fast')
			$(this).text('-hide children');
		}
	});
	
	$('.comment').each(function() {
		if($(this).children('.comment').length == 0) {
			$(this).children('.hide_children').hide();
		}
	})
	
	render();
});

function render() {

	// show modal when navigating while music playing
	$('a').click(function(e) {
		if ($('#play-all').hasClass('playing-all')) {
			if ($(e.currentTarget).attr('id') == 'play-all' || $(e.currentTarget).hasClass('sc-play') || $(e.currentTarget).hasClass('sc-pause')
		|| $(e.currentTarget).hasClass('close')) {
				console.log('exception caught and handled');
			}else{
				e.preventDefault();
				$('#MusicWarning').modal('toggle');
				$('#continue_link').data('link', e.currentTarget.href);
			}
		}
	});

	// comment votes
	$('.cupvote').click(function(e) {
		if (readCookie('logged_in')){
			var comment = $(e.currentTarget).data('comment_id');
			var count = $(e.currentTarget).parent().children('.vote_count').text();
			if (!$(this).hasClass('upvoted')) {
				$(this).addClass('upvoted');
				if ($(this).parent().children('.cdownvote').hasClass('downvoted')) {
					$(this).parent().children('.vote_count').text(Number(count)+2);
					$(this).parent().children('.cdownvote').removeClass('downvoted');
					$.post('/cvotes/upvote/2/' + comment);
				}else{
					$(this).parent().children('.vote_count').text(Number(count)+1);
					$.post('/cvotes/upvote/1/' + comment);
				}
			}else{
				$(this).removeClass('upvoted');
				$(this).parent().children('.vote_count').text(Number(count)-1);
				$.post('/cvotes/upvote/0/' + comment);
			}
		}else{
			$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
	});

	$('.cdownvote').click(function(e) {
		if (readCookie('logged_in')){
			var comment = $(e.currentTarget).data('comment_id');
			var count = $(e.currentTarget).parent().children('.vote_count').text();
			if (!$(this).hasClass('downvoted')) {
				$(this).addClass('downvoted');
				if ($(this).parent().children('.cupvote').hasClass('upvoted')) {
					$(this).parent().children('.vote_count').text(Number(count)-2);
					$(this).parent().children('.cupvote').removeClass('upvoted');
					$.post('/cvotes/downvote/2/' + comment);
				}else{
					$(this).parent().children('.vote_count').text(Number(count)-1);
					$.post('/cvotes/downvote/1/' + comment);
				}
			}else{
				$(this).removeClass('downvoted');
				$(this).parent().children('.vote_count').text(Number(count)+1);
				$.post('/cvotes/downvote/0/' + comment);
			}
		}else{
			$('#error_message').text('You must log in to vote, comment, or favorite any tracks!').removeClass('hidden');
			window.scrollTo(0, 0);
		}
	});
}

function addComment(comment, parent_id) {
	var comment_html =
	'<div class=\"comment\">'
	+'<span class=\"vote_container\">'
	+'<div data-comment_id=\'\' class=\"arrow-up upvote upvoted\"></div>'
	+'<div data-vote_count=\'\' class=\"vote_count\">1</div>'
	+'<div data-comment_id=\'\' class=\"arrow-down downvote\"></div>'
	+'</span>'
	+comment
	+'<hr>'
	+'</div>';
	$('.root_comment_box').val('');
	if (parent_id == 0) {
		$('#comment_container').prepend(comment_html);
	}else {
		$('.comment_reply_submit[data-parent_id="' + parent_id + '"]').parent().parent().append(comment_html);
	}
}