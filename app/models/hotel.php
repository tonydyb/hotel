<?php
class Hotel extends AppModel {

	var $name = 'Hotel';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `hotel_grade_id` int(11) unsigned NOT NULL,
//  `country_id` int(11) unsigned NOT NULL,
//  `state_id` int(11) unsigned NOT NULL,
//  `city_id` int(11) unsigned NOT NULL,
//  `town_id` int(11) unsigned NOT NULL,
//  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `total_room_number` int(11) unsigned NOT NULL,
//  `star_rate` int(11) unsigned COLLATE utf8_unicode_ci NOT NULL,
//  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `display_stat` int(11) unsigned NOT NULL,
//  `checkin` time NOT NULL,
//  `checkout` time NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'code' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'codeCheck' =>
				array(
					'rule' => array('code_check', ),
					'last' => true,
				),
			'isUnique' =>
				array(
					'rule' => array('isUnique', ),
					'on'=>'create',
				),
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
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
		'state_id' =>
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
		'tel' =>
			array(
				'phone' =>
				array(
					'rule' => array('phone_check', ),
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'fax' =>
			array(
				'phone' =>
				array(
					'rule' => array('phone_check', ),
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'email' =>
			array(
				'email_invalid' =>
				array(
					'rule' => array('email_check', ),
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
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'total_room_number' =>
			array(
				'number_invalid' =>
				array(
					'rule' => array('numeric_check', ),
				),
			),
		'star_rate' =>
			array(
				'number_invalid' =>
				array(
					'rule' => array('numeric_check', ),
				),
			),
		'latitude' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'longitude' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'display_stat' =>
			array(
				'number_invalid' =>
				array(
					'rule' => array('numeric_check', ),
				),
			),
		'checkin' =>
			array(
				'userDefined' =>
				array(
					'rule' => array('check_time', ),
				),
			),
		'checkout' =>
			array(
				'userDefined' =>
				array(
					'rule' => array('check_time', ),
				),
			),
		);

	function check_time($data) {
		foreach ($data as $d) {
			if (empty($d)) {
				return true;
			} else if ($d == 'error') {
				return false;
			}

			$regex = '/^([0-1][0-9]|[2][0-3]):([0-9]{2})$/';
			return preg_match($regex, $d);
		}
	}

}
?>