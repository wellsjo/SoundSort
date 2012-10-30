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
			<div id="logged_out_message" class="span6 offset2 alert alert-success" style="font-size:17px;margin-top: 40px;">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
				Great music is uploaded to SoundCloud® every day, but it's still hard to find <b>great free music</b>.
				<br/><br/>
				Welcome to <b>SoundSort</b>, a social music player/aggregator which features the best recently uploaded music,
				<b/>all of which you can rate, favorite, comment on, and download for free</b>.
			</div>
			<?php
		}

		$disabled = "";
		if ($page < 2) $disabled = "disabled=\"disabled\"";
		?>

		<div class="span8 offset1" style="height:45px;position:relative; width:783px;">

			<h5 style="color:gray; margin-top:7px;padding-left: 31px; font-size:20px;">
				<span style="margin-left:19px; color:white;"><?php echo $display; ?></span>
				<a href="/all/<?php echo $page - 1; ?>" class="btn _page" <?php echo $disabled; ?> style="margin-left: 27px;"><i class="icon-arrow-left icon-black"></i></a>
				<a href="/all/<?php echo $page + 1; ?>" class="btn _page"><i class="icon-arrow-right icon-black"></i></a>
				<button class="btn btn-success" id="launch_tutorial" style="float:right;">Tutorial</button>
			</h5>
		</div>
		<div class="modal" id="myModal"  data-keyboard="true" tabindex="-1" role="dialog" data-show="false" style="width:700px; left:46%;height:415px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">SoundSort Tutorial</h3>
			</div>
			<div class="modal-body">
				<img src="/img/ss_tutorial.png" />
			</div>
		</div>
		<script type="text/javascript">
			// hackery, I'm not proud of this'
			$('#myModal').modal('toggle');
			$('#myModal').modal('toggle');
			var loaded = false;
			$('#launch_tutorial').click(function() {
				$('#myModal').modal('toggle');
			});
		</script>
		<div id="trend_container" class="span8 offset1">

		</div>
		<div class="span8 offset1" style="position:relative;">
			<h5 style="padding-left: 31px;color:gray; margin-top:7px; font-size:20px;">
				<span style="margin-left:19px;"><?php echo $display; ?></span>
				<a href="/top/<?php echo $page - 1; ?>" <?php echo $disabled; ?> class="btn _page" style="margin-left: 27px;"><i  class="icon-arrow-left icon-black"></i></a>
				<a href="/top/<?php echo $page + 1; ?>" class="btn _page" ><i class="icon-arrow-right icon-black"></i></a></h5>
		</div>
	</div>
</div>