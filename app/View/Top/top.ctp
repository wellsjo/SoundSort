<script type="text/javascript">
	<?php 
	echo '_page='.$page.';';
	echo 'active_tab='.$active.'_tab;';
	echo 'tracks='.$tracks.';';
	?>
</script>
<script type="text/javascript">
$(active_tab).addClass('active');
</script>
<script src="/js/main.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">
			
		</div>
		<div class="span8 offset1" style="height:45px;position:relative;">
			<h3 style="margin-top:7px;"><?php echo $display; ?></h3>
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