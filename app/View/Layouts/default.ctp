<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>SoundSort</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content="A place to download, rate, and discuss the best new music."/>
		<meta name="author" content="Wells Johnston"/>
		<?php
		echo $this->Html->charset();
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive');
		echo $this->Html->css('main');
		echo $this->Html->css('sc-player-artwork');
		echo $this->Html->script('jquery');
		echo $this->Html->script('bootstrap');
		echo $this->Html->script('soundcloud');
		echo $this->Html->script('sc-player');
		echo $this->Html->script('soundcloud.player.api');
		echo $this->Html->script('main'); // my pre-defined functions
		?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="modal" id="MusicWarning" style="width:315px; left:57%;"tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Keep the music going :)</h3>
			</div>
			<div class="modal-body">
				<p>Navigating from this page will stop the music!</p>
			</div>
			<div class="modal-footer">
				<button id="stay_link" class="btn btn-success" data-dismiss="modal" aria-hidden="true">Stay here</button>
				<button id="continue_link" class="btn btn-info">Continue</button>
			</div>
		</div>
		<script type="text/javascript">
			$('#MusicWarning').modal('toggle');
			$('#MusicWarning').modal('toggle')
			$('#continue_link').click(function() {
				document.location.href=$(this).data('link');
			});
			$('#stay_link').click(function() {
				spinner_off();
			})
		</script>
		<?php
		echo $this->element('navbar');
		echo $this->fetch('content');
		echo $this->element('sql_dump');
		?>
		<br/><br/><br/><br/><br/><br/>
		<div class="bottom_footer" style="margin-left: auto;margin-right: auto;">
			Contact me at w@wellsjohnston.com |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/follow_button.1347008535.html#_=1347116922937&amp;id=twitter-widget-0&amp;lang=en&amp;screen_name=wellsjohnston&amp;show_count=false&amp;show_screen_name=true&amp;size=m" class="twitter-follow-button" style=" position: absolute;right: 305px;width: 147px; height: 20px; " title="Twitter Follow Button" data-twttr-rendered="true"></iframe>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<br/><br/><br/><br/><br/><br/>
	</body>
</html>