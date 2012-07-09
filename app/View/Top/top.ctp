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
<script src="/js/top.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="trend_container" class="span8 offset1">
			<h3><?php echo $display; ?></h3><br/>
		</div>
		<br/>
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
