<?php
class Request extends AppModel {

	var $name = 'Request';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `customer_user_id` int(11) unsigned NOT NULL,
//  `admin_user_id` int(11) unsigned NOT NULL,
//  `request_stat_id` int(11) unsigned NOT NULL,
//  `request_payment_id` int(11) unsigned NOT NULL,
//  `country_id` int(11) unsigned NOT NULL,
//  `language_id` int(11) unsigned NOT NULL,
//  `currency_id` int(11) unsigned NOT NULL,
//  `price` decimal(15,4) NOT NULL,
//  `point` decimal(15,4) NOT NULL,
//  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_country_id` int(11) NOT NULL,
//  `addr_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `gender_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `message_bord` text COLLATE utf8_unicode_ci NOT NULL,
//  `request_date` datetime NOT NULL,
//  `age` int(11) unsigned NOT NULL,
//  `receipt` int(11) unsigned NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,

	var $validate =
	array(
		'request_date' =>
			array(
				'date' =>
				array(
					'rule' => array('date', 'ymd'),
					'required' => true,
				),
			),
	);
}
?>