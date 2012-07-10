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
			if (isset($active) && $active == 'top') {
				?>
				<a href="/register" class="btn btn-success pull-right">Register</a>
				<?php
			}
			?>
			<ul class="nav pull-right">
				<li id="login_dropdown" class="dropdown pull-right">
					<a class="dropdown-toggle" href="#" data-toggle="dropdown" data-bypass>
						Sign In
						<b class="caret"></b>
					</a>
					<div class="dropdown-menu" style="width:221px;padding: 5px;">
						<input type="text" name="user[email]" placeholder="Email" value="" />
						<input type="password" name="user[password]" placeholder="********" value="" />
						<input id="sign_in" class="btn btn-primary span3" style="width: 100px;float: right;" name="commit" value="Sign In" />
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.dropdown-menu input, .dropdown-menu label').click(function(e) {
		e.stopPropagation();
	});
</script>