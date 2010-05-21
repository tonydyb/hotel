<?php
class ContentImage extends AppModel {

	var $name = 'ContentImage';
	var $useTable = 'content_image';
	var $validate = array(
		'name' => array('notempty'),
		'type' => array('notempty'),
		'tag' => array('notempty')
	);

}
?>