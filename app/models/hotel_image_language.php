<?php
class HotelImageLanguage extends AppModel {

	var $name = 'HotelImageLanguage';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `language_id` int(11) unsigned NOT NULL,
//  `hotel_image_id` int(11) unsigned NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
		);

}
?>