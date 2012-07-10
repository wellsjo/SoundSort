<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<div class="brand pull-left"><a href="/">SoundSort</a></div>
			<ul class="nav">
				<li id="top_tab">
					<a href="/top">top</a>
				</li>
			</ul>
			<?php
			if (isset($active) && $active == 'top' && !$auth_for_layout['User']) {
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
				<li style="margin-top:10px;">Welcome, <?php echo $auth_for_layout['User']['name']; ?></li>
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
							<input id = "sign_in" class = "btn btn-primary span3" style = "width: 100px;float: right;" name = "commit" value = "Sign In" />
						</div>
					</li>
					<?php
				}
				?>

			</ul>
		</div>
	</div>
</div>
<?php $Url = Router::url(array('controller' => 'top', 'action' => 'top'), true); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.dropdown-menu input, .dropdown-menu label').click(function(e) {
			e.stopPropagation();
		});
		
		$('#sign_in').click(function(e) {
			e.preventDefault();
			$.post('/login', {
				user_name: $('#login_user_name').val(),
				password: $('#login_user_password').val()
			}, function(response) {
				if (response) {
					response = JSON.parse(response);
					if (response.error) {
						$('.alert-error').removeClass('hidden');
						$('.alert-error').text(response.error);
					}
				}else{
<?php $Url = json_encode($Url);
echo "url=" . $Url . ";";
?>
					window.location = url;
				}
			});
		});
		
	})
</script>