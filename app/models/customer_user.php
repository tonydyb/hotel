<?php
class CustomerUser extends AppModel {

	var $name = 'CustomerUser';


//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `postcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_country_id` int(11) unsigned NOT NULL,
//  `addr_1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `addr_3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `gender_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `birthday` datetime NOT NULL,
//  `last_access` datetime NOT NULL,
//  `language_id` int(11) unsigned NOT NULL,
//  `country_id` int(11) unsigned NOT NULL,
//  `carrier_type_id` int(11) unsigned NOT NULL,
//  `media_id` int(11) unsigned NOT NULL,
//  `mail_delivery_id` int(11) unsigned NOT NULL,
//  `mail_delivery_mobile_id` int(11) unsigned NOT NULL,
//  `customer_type_id` int(11) unsigned NOT NULL,
//  `mail_magazine_type_id` int(11) unsigned NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime,

	// hasMany使用可能オプション
	// className, foreignKey, conditions, fields, order, limit, offset,
	// dependent, exclusive, finderQuery
//	var $hasMany = array('Country' => array('className' => 'Country',	// クラス名
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//						),
//						'Country' => array('className' => 'Country',	// クラス名
//							'foreignKey' => 'addr_country_id',	// FKey(命名規則に沿っていない場合必要)
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//						),
//						'Gender' => array('className' => 'Gender',	// クラス名
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//						),
//						'Language' => array('className' => 'Language',	// クラス名
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//						)
//						);

	var $validate =
	array(
		'account' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'email_invalid' =>
				array(
					'rule' => VALID_EMAIL,
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'password' =>
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
		'email' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'email_invalid' =>
				array(
					'rule' => VALID_EMAIL,
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'email_mobile' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'email_invalid' =>
				array(
					'rule' => VALID_EMAIL,
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
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
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'tel_mobile' =>
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
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'fax' =>
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
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'postcode' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'number_invalid' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'addr_country_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'addr_1' =>
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
					'required' => true,
				),
			),
		'addr_2' =>
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
					'required' => true,
				),
			),
		'addr_3' =>
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
					'required' => true,
				),
			),
		'gender_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'birthday' =>
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
		'language_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
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
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'carrier_type_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'media_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'mail_delivery_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'mail_delivery_mobile_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'customer_type_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		'mail_magazine_type_id' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'valid_number' =>
				array(
					'rule' => VALID_NUMBER,
					'required' => true,
				),
			),
		);

}
?>