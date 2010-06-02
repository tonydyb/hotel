<?php
class HotelEmergencyContact extends AppModel {

	var $name = 'HotelEmergencyContact';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `hotel_agent_id` int(11) unsigned NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `sort_no` int(11) unsigned NOT NULL,
//  `area_id` int(11) unsigned NOT NULL,
//  `country_id` int(11) unsigned NOT NULL,
//  `state_id` int(11) unsigned NOT NULL,
//  `city_id` int(11) unsigned NOT NULL,
//  `addr_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel_country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,

	var $validate =
	array(
		'hotel_agent_id' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'number_invalid' =>
				array(
					'rule' => array('numeric', ),
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
					'rule' => array('alpha_numeric_check', ),
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'sort_no' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'number_invalid' =>
				array(
					'rule' => array('numeric', ),
				),
			),
		'area_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'number_invalid' =>
				array(
					'rule' => array('numeric', ),
				),
			),
		'country_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'number_invalid' =>
				array(
					'rule' => array('numeric', ),
				),
			),
		'city_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'number_invalid' =>
				array(
					'rule' => array('numeric', ),
				),
			),
		'addr_1' =>
			array(
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
		'addr_2' =>
			array(
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
		'addr_3' =>
			array(
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
		'postcode' =>
			array(
				'number_invalid' =>
				array(
					'rule' => array('number_check', ),
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'tel' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'phone' =>
				array(
					'rule' => PHONE,
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'tel_country_code' =>
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
				),
			),
		'remarks' =>
			array(
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
		);

}
?>