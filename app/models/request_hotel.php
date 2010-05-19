<?php
class RequestHotel extends AppModel {

	var $name = 'RequestHotel';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `request_id` int(11) unsigned NOT NULL,
//  `hotel_agent_id` int(11) unsigned NOT NULL,
//  `hotel_agent_ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `hotel_agent_item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `currency_id` int(11) unsigned NOT NULL,
//  `request_stat_id` int(11) unsigned NOT NULL,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `hotel_room_id` int(11) unsigned NOT NULL,
//  `price` decimal(15,4) NOT NULL,
//  `point` decimal(15,4) NOT NULL,
//  `checkin` datetime NOT NULL,
//  `checkout` datetime NOT NULL,
//  `adult_cnt` int(11) NOT NULL,
//  `child_cnt` int(11) NOT NULL,
//  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `limit_date` datetime NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'hotel_agent_ref' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
//					'required' => true,
				),
			),
		'hotel_agent_item' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
//					'required' => true,
				),
			),
		'hotel_id' =>
			array(
				'notSelected' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			),
		'hotel_room_id' =>
			array(
				'notSelected' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			),
		'checkin' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'date' =>
				array(
					'rule' => array('date', 'ymd'),
//					'required' => true,
				),
			),
		'checkout' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'date' =>
				array(
					'rule' => array('date', 'ymd'),
//					'required' => true,
				),
			),
		'comment' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
//					'required' => true,
				),
			),
		'limit_date' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'date' =>
				array(
					'rule' => array('date_time_check', ),
//					'required' => true,
				),
			),
		);

	function date_time_check($datetime) {
		if (empty($datetime['limit_date'])) {
			return true;
		}
		$checkdate = preg_split('/ /' , $datetime['limit_date']);
		if (count($checkdate) != 2) {
			return false;
		} else {
			return date($checkdate[0]) && time($checkdate[1]);
		}
	}

//	function not_selected($selected) {
//		if (empty($selected) || $selected <= 0) {
//			return false;
//		} else {
//			return true;
//		}
//	}

}
?>