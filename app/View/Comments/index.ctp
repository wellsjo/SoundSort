<script type="text/javascript">
<?php
echo 'track=' . json_encode($Track) . ';';
?>
</script>
<script src="/js/comment.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<div id="track_container" class="span8 offset1">

		</div>
		<div id="add_comment_container" class="span4 offset3">
			<div class="well" data-parent_id="0">
				<textarea name ="comment" placeholder="Add a comment..."></textarea>
				<button id="submit_comment" type="submit" class="btn pull-right">Submit</button>
			</div>
		</div>
		<div id="comment_container" class="span8 offset1">
			<?php
			foreach ($Track['Comment'] as $comment) {
				echo $comment['comment'] . '<br/>';
			}
					?>
		</div>
	</div>
</div>