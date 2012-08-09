<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '244647508989780', // App ID
			channelUrl : '//WWW.soundsort.COM/channel.html', // Channel File
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});
	};
	// Load the SDK Asynchronously
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		ref.parentNode.insertBefore(js, ref);
	}(document));
</script>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container" style="position:relative;">
			<div class="brand pull-left"><a href="/">SoundSort</a></div>
			<ul class="nav">
				<li id="top_tab">
					<a href="/top">top</a>
				</li>
				<?php
				if ($auth_for_layout['User']) {
					?>
					<li id="favorites_tab">
						<a href="/favorites">favorites</a>
					</li>
					<?php
				}
				?>

			</ul>
			<?php
			if ($page_for_layout == 'top' || $page_for_layout == 'favorites') {
				?>
				<div id = "play-all" class="btn">
					<i class="icon-play icon-black"></i>
				</div>
				<div id = "play-next" class="btn top_arrow_next">
					<i class="icon-forward icon-black"></i>
				</div>
				<div id = "play-prev" class="btn top_arrow_prev">
					<i class="icon-backward icon-black"></i>
				</div>
				<?php
			}
			?>

			<ul class="nav pull-right">
				<li class="alert alert-error hidden" style="margin-bottom: 0px;margin-top: 2px;">
				</li>
				<?php
				if (!$auth_for_layout['User'] && $page_for_layout != 'register') {
					?>
				<a href='#' id="teh_fb"><img src="/img/facebook-connect-button.png" style="width:160px" /></a>
				<a href="/register" class="btn btn-small btn-success" style="margin-top: 6px; margin-right:80px;">Create Account</a>
					<?php
				}
				?>
				<?php
				if ($auth_for_layout['User']) {
					?>
					<li id="logout_dropdown" class="dropdown">
						<a class = "dropdown-toggle" href = "#" data-toggle = "dropdown" data-bypass>
							Welcome, <?php echo $auth_for_layout['User']['name']; ?>
							<b class = "caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown" style="text-align:center;">
								<?php if ($auth_for_layout['User']['fb_id']) {
									?>
									<a id="fb_logout" href='/users/logout'>Log Out</a>
									<?php
								} else {
									?>
									<a href="/users/logout">Log Out</a>
									<?php
								}
								?>
							</li>
						</ul>

					</li>
					<?php
				} else if($page_for_layout != 'register') {
					?>
					<li id = "login_dropdown" class = "dropdown top_dropdown">
						<a class = "dropdown-toggle" href = "#" data-toggle = "dropdown" data-bypass>
							Sign In
							<b class = "caret"></b>
						</a>
						<div class = "dropdown-menu" style = "width:221px;padding: 5px;">
							<input type = "text" name = "user[email]" placeholder = "Email" id = "login_user_name" value = "wellsjohnston@gmail.com" />
							<input type = "password" name = "user[password]" placeholder = "********" id = "login_user_password" value = "password" />
							<button id ="sign_in" class = "btn btn-primary span3" style = "width: 100px;float: right;" name = "commit" value = "Sign In">Sign In</button>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</div>
</div>
<?php
?>
<script type="text/javascript">
	$(document).ready(function() {

		$('#teh_fb').click(function() {
			FB.login(function(response) {
				if (response.authResponse) {
					FB.api('/me', function(response) {
						console.log(response);
						$.post('/users/fblogin', {
							name: response.name,
							fb_id: response.id
						}, function(response) {
							if (response) {
								// error handling
								response = JSON.parse(response);
								if (response.error) {
									$('.navbar .alert-error').removeClass('hidden');
									$('.navbar .alert-error').text(response.error);
								}
							}else{
								// redirect back to location to update navbar
								window.location.reload(true);
							}
						});
						console.log('Good to see you, ' + response.name + '.');
					});
				} else {
					console.log('User cancelled login or did not fully authorize.');
				}
			});
		});

		$('#fb_logout').click(function() {
			FB.logout(function(response) {
				console.log(response);
				window.location.reload(true);
			});
		});

		$('.dropdown-menu input, .dropdown-menu label').click(function(e) {
			e.stopPropagation();
		});

		$('#play-all').click(function() {
			if ($('.player-active').parent().parent().hasClass('playing')){
				$(this).children('i').removeClass('icon-pause');
				$('.player-active').parent().children('.sc-pause').click();
			}else{
				$(this).children('i').addClass('icon-pause');
				$('.player-active').parent().children('.sc-play').click();
			}
		});

		$('.top_arrow_next').click(function() {
			$('.player-active').parent().parent().parent().next('span').children('.sc-player').children('.sc-controls').children('.sc-play').click();
		});
		
		$('.top_arrow_prev').click(function() {
			$('.player-active').parent().parent().parent().prev('span').children('.sc-player').children('.sc-controls').children('.sc-play').click();
		});
		
		$('#sign_in').click(function(e) {
			e.preventDefault();
			$.post('/users/login', {
				user_name: $('#login_user_name').val(),
				password: $('#login_user_password').val()
			}, function(response) {
				if (response) {
					// error handling
					response = JSON.parse(response);
					if (response.error) {
						$('.navbar .alert-error').removeClass('hidden');
						$('.navbar .alert-error').text(response.error);
					}
				}else{
					// redirect back to location to update navbar
					window.location.reload(true);
				}
			});
		});
		
	})
</script>