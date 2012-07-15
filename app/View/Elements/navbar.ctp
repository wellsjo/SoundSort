<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container" style="position:relative;">
			<div class="brand pull-left"><a href="/">SoundSort</a></div>
			<ul class="nav">
				<li id="top_tab">
					<a href="/top">top</a>
				</li>
			</ul>
			<div id="play-all">

			</div>

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
			if ($(this).hasClass('playing-all')) {
				$(this).removeClass('playing-all');
			}else{
				$('#play-all').addClass('playing-all');
			}
			$('.sc-player').first().children('.sc-controls').children('.sc-play').click();
		})
		
		$('#sign_in').click(function(e) {
			e.preventDefault();
			$.post('/users/login', {
				user_name: $('#login_user_name').val(),
				password: $('#login_user_password').val()
			}, function(response) {
				console.log(response);
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