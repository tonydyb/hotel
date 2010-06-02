<?php
class ContentDocument extends AppModel {

	var $name = 'ContentDocument';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `type_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,

	var $validate_add_type =
	array(
		'type_name' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'alphaNumeric' =>
				array(
					'rule' => array('alpha_numeric_check', ),
					'last' => true,
				),
			'isUnique' =>
				array(
					'rule' => array('isUnique', ),
					'on'=>'create',
					'last' => true,
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'file_name' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		);

	var $validate_save =
	array(
		'type_name' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'alphaNumeric' =>
				array(
					'rule' => array('alpha_numeric_check', ),
					'last' => true,
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'file_name' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'alphaNumeric' =>
				array(
					'rule' => array('alpha_numeric_check', ),
					'last' => true,
				),
			'isUnique' =>
				array(
					'rule' => array('isUnique', ),
					'on'=>'create',
					'last' => true,
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		);
}
?>