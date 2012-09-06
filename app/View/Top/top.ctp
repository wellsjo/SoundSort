<script type="text/javascript">
<?php
echo '_page=' . $page . ';';
echo 'active_tab=' . $active . '_tab;';
echo 'tracks=' . $tracks . ';';
?>
		$(active_tab).addClass('active');
</script>

<script src="/js/my_sc_player.js"></script>
<script src="/js/top.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<?php if (!$auth_for_layout['User']) {
			?>
			<div id="logged_out_message" class="span6 offset2 alert alert-success" style="font-size:18px;">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				Great music is uploaded to SoundCloud every day, but it's still hard to find <b>great free music</b>.
				<br/><br/>
				Welcome to <b>SoundSort</b>, a social music player/aggregator which features the best recently uploaded music,
				<b/>all of which you can download for free</b>.
			</div>
			<?php
		}
		?>

		<div class="span8 offset1" style="height:45px;position:relative;">
			<h5 style="color:gray; margin-top:7px;"><?php echo $display; ?></h5>
		</div>
		<div id="trend_container" class="span8 offset1">

		</div>
		<div class="span8 offset1">
			<?php
			$disabled = "";
			if ($page < 2) $disabled = "disabled=\"disabled\"";
			?>
			<a href="/top/<?php echo $page - 1; ?>" class="btn" <?php echo $disabled; ?>>Previous</a>
			<a href="/top/<?php echo $page + 1; ?>" class="btn" >Next</a>
		</div>
	</div>
	<br/>
	<hr/>
</div>