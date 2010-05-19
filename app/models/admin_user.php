<?php
class AdminUser extends AppModel {

	var $name = 'AdminUser';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `language_id` int(11) unsigned NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime,

//		// hasMany使用可能オプション
//	// className, foreignKey, conditions, fields, order, limit, offset,
//	// dependent, exclusive, finderQuery
//	var $hasMany = array('Request' => array('className' => 'Request',	// クラス名
////							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
////							'conditions' => '',	// 連結の絞り込み条件
////							'fields' => '',	// 取得するカラム
////							'order' => '',	// 並べ替え順版
////							'limit' => '',	// 取得上限数
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
////							'finderQuery' => ''	// 自分でSQLを指定する場合
//						)
//						);

	var $validate =
	array(
		'account' =>
		array(
			"account_invalid" =>
			array(
				'rule' => 'alphaNumeric',
				'required' => true,
			),
		),
		'password' =>
		array(
			"password_invalid" =>
			array(
				'rule' => 'alphaNumeric',
				'required' => true,
			),
		),
		'name' =>
		array(
			"name_invalid" =>
			array(
				'rule' => 'notEmpty',
				'required' => true,
			),
		),
		'email' =>
		array(
			"email_invalid" =>
			array(
				'rule' => VALID_EMAIL,
				'required' => true,
			),
		),
		'tel' =>
		array(
			"tel_invalid" =>
			array(
				'rule' => VALID_NUMBER,
				'required' => true,
			),
		),
	);
}
?>