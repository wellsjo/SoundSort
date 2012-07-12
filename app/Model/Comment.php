<?php

class Comment extends AppModel {

	var $uses = 'Track';
	var $name = 'Comment';
	var $belongsTo = array('Track', 'User');

}


?>
