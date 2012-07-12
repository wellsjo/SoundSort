<script type="text/javascript">
<?php
echo 'track=' . $Track . ';';
?>
	console.log(track);
</script>
<script src="/js/comment.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<div id="track_container" class="span8 offset1">

		</div>
		<div id="comment_container" class="span4 offset3">
			<form class="well">
				<textarea placeholder="Add a comment..."></textarea>
				<button id="submit_comment" type="submit" class="btn pull-right">Submit</button>
			</form>
		</div>
	</div>
</div>