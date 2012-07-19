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
			if ($page_for_layout == 'top') {
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


			<?php
			if (!$auth_for_layout['User']) {
				?>
				<a href="/register" class="btn btn-success pull-right">Register</a>
				<?php
			}
			?>
			<ul class="nav pull-right">
				<li class="alert alert-error hidden" style="margin-bottom: 0px;margin-top: 2px;">
				</li>
				<?php
				if ($auth_for_layout['User']) {
					?>
					<li id="logout_dropdown" class="dropdown pull-right">
						<a class = "dropdown-toggle" href = "#" data-toggle = "dropdown" data-bypass>
							Welcome, <?php echo $auth_for_layout['User']['name']; ?>
							<b class = "caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown" style="text-align:center;">
								<a href="/users/logout">Log Out</a>
							</li>
						</ul>

					</li>
					<?php
				} else {
					?>
					<li id = "login_dropdown" class = "dropdown pull-right">
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
<?php
?>
<script type="text/javascript">
	$(document).ready(function() {
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
			$('.player-active').parent().parent().parent().next('.track_container').children('.sc-player').children('.sc-controls').children('.sc-play').click();
		});
		
		$('.top_arrow_prev').click(function() {
			$('.player-active').parent().parent().parent().prev('.track_container').children('.sc-player').children('.sc-controls').children('.sc-play').click();
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