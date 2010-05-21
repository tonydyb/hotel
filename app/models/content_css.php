<?php
class ContentCss extends AppModel {

	var $name = 'ContentCss';
	var $useTable = 'content_css';
	var $validate = array(
		'language_id' => array('numeric'),
		'carrier_type_id' => array('numeric'),
		'alias' => array('notempty')
	);

}
?>