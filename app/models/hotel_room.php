<?php
class HotelRoom extends AppModel {

	var $name = 'HotelRoom';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `hotel_agent_id` int(11) unsigned NOT NULL,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `room_bed_id` int(11) unsigned NOT NULL,
//  `room_grade_id` int(11) unsigned NOT NULL,
//  `room_bath_id` int(11) unsigned NOT NULL,
//  `smoking_id` int(11) unsigned NOT NULL,
//  `meal_type_id` int(11) unsigned NOT NULL,
//  `breakfast_type_id` int(11) unsigned NOT NULL,
//  `currency_id` int(11) unsigned NOT NULL,
//  `price` decimal(15,4) NOT NULL,
//  `point` decimal(15,4) NOT NULL,
//  `commission` decimal(8,4) NOT NULL,
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
		'room_bed_id' =>
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
		'price' =>
			array(
				'decimal' =>
				array(
					'rule' => array('decimal_check', 4, ),
				),
			),
		'point' =>
			array(
				'decimal' =>
				array(
					'rule' => array('decimal_check', 4, ),
				),
			),
		'commission' =>
			array(
				'decimal' =>
				array(
					'rule' => array('decimal_check', 4, ),
				),
			),
		);

}
?>