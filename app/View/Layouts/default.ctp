<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>SoundSort</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content="A place to vote on and discuss the hottest new music."/>
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
		?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php
		echo $this->element('navbar');
		echo $this->fetch('content');
		echo $this->element('sql_dump');
		?>
	</body>
</html>