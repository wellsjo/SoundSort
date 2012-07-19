<script type="text/javascript">
	<?php
	echo 'active_tab='.$active.'_tab;';
	?>
</script>
<script type="text/javascript">
$(active_tab).addClass('active');
</script>
<script type="text/javascript">
<?php
echo 'track=' . json_encode($Track) . ';';
?>
</script>
<script src="/js/favorites.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<div class="span8 offset2">
			
		</div>
	</div>
</div>