<?php
class ContentCss extends AppModel {

	var $name = 'ContentCss';
	var $useTable = 'content_css';
	var $validate = array(
		'language_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'carrier_type_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'alias' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'last' => true,
				),
		)
	);

}
?>