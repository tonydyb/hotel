<?php
class HotelLanguage extends AppModel {

	var $name = 'HotelLanguage';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `language_id` int(11) unsigned NOT NULL,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `comment` text COLLATE utf8_unicode_ci NOT NULL,
//  `location_comment` text COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'name' =>
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
		'addr_1' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'addr_2' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'addr_3' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		);

}
?>