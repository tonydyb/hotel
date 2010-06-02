<?php
class CancelCharge extends AppModel {

	var $name = 'CancelCharge';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `sort_no` int(11) unsigned NOT NULL,
//  `term_from` datetime NOT NULL,
//  `term_to` datetime NOT NULL,
//  `charge_occur_from` int(11) unsigned NOT NULL,
//  `charge_occur_to` int(11) unsigned NOT NULL,
//  `charge_stat_id` int(11) unsigned NOT NULL,
//  `charge_percent` int(11) unsigned NOT NULL,
//  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
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
		'term_from' =>
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
					'required' => true,
				),
			),
		'term_to' =>
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
					'required' => true,
				),
			),
		'charge_occur_from' =>
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
		'charge_occur_to' =>
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
		'charge_stat_id' =>
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
		'charge_percent' =>
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
		'remarks' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		);

}
?>