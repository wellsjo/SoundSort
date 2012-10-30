<script type="text/javascript">
	<?php
	if ($tracks_exist) {
		echo 'tracks=' . $tracks . ';';
	}else{
		echo 'tracks=\'none\';';
	}
	echo 'active_tab='.$active.'_tab;';
	?>
	$(active_tab).addClass('active');
</script>
<script src="/js/my_sc_player.js"></script>
<script src="/js/favorites.js"></script>

<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<div id="favorite_container" class="span8 offset1">
			
		</div>
	</div>
</div>