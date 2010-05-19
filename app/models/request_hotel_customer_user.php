<?php
class RequestHotelCustomerUser extends AppModel {

	var $name = 'RequestHotelCustomerUser';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `request_id` int(11) unsigned NOT NULL,
//  `leader` int(11) unsigned NOT NULL,
//  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `gender_id` int(11) unsigned NOT NULL,
//  `adult` int(11) unsigned NOT NULL,
//  `age` int(11) unsigned NOT NULL,
//  `comment` text COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'first_name' =>
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
		'last_name' =>
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
		'age' =>
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
			),
		);

}
?>