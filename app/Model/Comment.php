<?php

class Comment extends AppModel {

	var $name = 'Comment';
	var $belongsTo = array('Track', 'User');

}


?>
