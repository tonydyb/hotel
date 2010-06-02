<?php
class HotelImage extends AppModel {

	var $name = 'HotelImage';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `hotel_id` int(11) unsigned NOT NULL,
//  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `image_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,

	var $validate =
	array(
		'code' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'image_url' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'image_file' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		);

}
?>