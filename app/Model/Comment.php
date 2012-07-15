<?php

class Comment extends AppModel {

	var $belongsTo = array('Track', 'User');
	var $hasMany = 'Cvote';
	var $uses = 'Cvote';

	function getScore($comment) {
		$score = 0;
		$comment_votes = $this->findById($comment['id']);
		if (count($comment_votes['Cvote']) == 0) return $score;
		foreach ($comment_votes['Cvote'] as $vote) {
			$score += $vote['upvote'];
			$score -= $vote['downvote'];
		}
		return $score;
	}
}


?>
