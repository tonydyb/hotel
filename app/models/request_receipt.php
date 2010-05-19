<?php
class RequestReceipt extends AppModel {

	var $name = 'RequestReceipt';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `request_id` int(11) unsigned NOT NULL,
//  `status` int(11) unsigned NOT NULL,
//  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `postname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_country_id` int(11) NOT NULL,
//  `addr_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'postcode' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'number_invalid' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'postname' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => array('alphaNumeric', ),
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'addr_1' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'addr_2' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'addr_3' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'name' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => array('alphaNumeric', ),
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'company' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => array('alphaNumeric', ),
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		);

}
?>