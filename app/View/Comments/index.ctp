<script type="text/javascript">
<?php
echo 'track=' . $Track . ';';
?>
</script>

<script src="/js/my_sc_player.js"></script>
<script src="/js/comment.js"></script>
<div class="container" id="main_container">
	<div class="row">
		<div id="error_message" class="span8 offset1 alert alert-error hidden">

		</div>
		<div id="track_container" class="span8 offset1">

		</div>
		<div id="add_comment_container" class="span4 offset3">
			<div class="well" style="height:75px;" >
				<textarea name ="comment" class="root_comment_box" placeholder="Add a comment..."></textarea>
				<button data-parent_id="0" type="submit" class="btn btn-success pull-right comment_reply_submit">Post</button>
			</div>
		</div>
		<div id="comment_container" class="span8 offset1">
			<?php
			print_comments($PHPTrackObject, 0);

			function comp($a, $b) {
				if ($a['score'] < $b['score']) {
					return 1;
				} else if ($a['score'] > $b['score']) {
					return -1;
				} else {
					return 0;
				}
			}
			function print_comments($PHPTrackObject, $parent_id) {
				$cur_level_comments = array();
				foreach ($PHPTrackObject['Comment'] as $comment) {
					if ($comment['parent_id'] == $parent_id) {
						$cur_level_comments[] = $comment;
					}
				}
				usort($cur_level_comments, 'comp');
				$count = 1;
				foreach ($cur_level_comments as $comment) {
					?>
					<div class="comment" data-comment_score="<?php echo $comment['score']; ?>" data-comment_id="<?php echo $comment['id']; ?>" data-comment_parent_id="<?php echo $comment['parent_id']; ?>">
						<div class="comment_count"><?php echo $count; $count++; ?></div>
						<span class="vote_container">
							<div data-comment_id="<?php echo $comment['id']; ?>" class="arrow-up cupvote <?php if($comment['upvoted']) echo "upvoted"; ?>"></div>
							<div data-vote_count="<?php echo $comment['score']; ?>" class="vote_count"><?php echo $comment['score']; ?></div>
							<div data-comment_id="<?php echo $comment['id']; ?>" class="arrow-down cdownvote <?php if ($comment['downvoted']) echo 'downvoted';?>"></div>
						</span>
		<?php echo $comment['comment']; ?>
						<hr/>
						<div class="hide_children">-hide children</div>
						<div class="reply">+reply</div>
						<div class="top_comment_area" style="display:none;">
							<textarea class="root_comment_box" name="root_comment_box"></textarea>
							<div data-parent_id="<?php echo $comment['id']; ?>" class="btn btn-success pull-right comment_reply_submit">post</div>
							<div class="cancel_reply btn btn-danger pull-right">cancel</div>
						</div>
					<?php print_comments($PHPTrackObject, $comment['id']); ?>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>