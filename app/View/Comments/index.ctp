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
			<div class="well" >
				<textarea name ="comment" class="root_comment_box" placeholder="Add a comment..."></textarea>
				<button data-parent_id="0" type="submit" class="btn btn-success pull-right comment_reply_submit">Submit</button>
			</div>
		</div>
		<div id="comment_container" class="span8 offset1">
			<?php
			foreach ($Track['Comment'] as $comment) {
				?>

				<div class="comment">
					<span class="vote_container">
						<div data-track_id="<?php echo $Track['Track']['id']; ?>" class="arrow-up upvote"></div>
						<div data-vote_count="<?php echo $Track['Track']['score']; ?>" class="vote_count"></div>
						<div data-track_id="<?php echo $Track['Track']['id']; ?>" class="arrow-down downvote"></div>
					</span>
					<?php echo $comment['comment']; ?>
					<div class="reply">+reply</div>
					<hr/>
					<div class="top_comment_area" style="display:none;">
						<pre><textarea class="root_comment_box" name="root_comment_box"></textarea></pre>
						<div data-parent_id="<?php echo $comment['id'];?>" class="btn btn-success pull-right comment_reply_submit">post</div>
					</div>
				</div>

				<?php
			}
			?>
		</div>
	</div>
</div>