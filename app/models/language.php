<?php
class Language extends AppModel {

	var $name = 'Language';


//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `iso_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime,



	// hasMany使用可能オプション
	// className, foreignKey, conditions, fields, order, limit, offset,
	// dependent, exclusive, finderQuery
	var $hasMany = array('AdminUser' => array('className' => 'AdminUser',	// クラス名
//							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
//							'conditions' => '',	// 連結の絞り込み条件
//							'fields' => '',	// 取得するカラム
//							'order' => '',	// 並べ替え順版
//							'limit' => '',	// 取得上限数
							'dependent' => 'false',	// 親データ削除時に子データを削除するか
							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//							'finderQuery' => ''	// 自分でSQLを指定する場合
						),
//						'HotelUser' => array('className' => 'HotelUser',	// クラス名
////							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
////							'conditions' => '',	// 連結の絞り込み条件
////							'fields' => '',	// 取得するカラム
////							'order' => '',	// 並べ替え順版
////							'limit' => '',	// 取得上限数
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
////							'finderQuery' => ''	// 自分でSQLを指定する場合
//						),
//						'HotelAgentUser' => array('className' => 'HotelAgentUser',	// クラス名
////							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
////							'conditions' => '',	// 連結の絞り込み条件
////							'fields' => '',	// 取得するカラム
////							'order' => '',	// 並べ替え順版
////							'limit' => '',	// 取得上限数
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
////							'finderQuery' => ''	// 自分でSQLを指定する場合
//						),
//						'CustomerUser' => array('className' => 'CustomerUser',	// クラス名
////							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
////							'conditions' => '',	// 連結の絞り込み条件
////							'fields' => '',	// 取得するカラム
////							'order' => '',	// 並べ替え順版
////							'limit' => '',	// 取得上限数
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
////							'finderQuery' => ''	// 自分でSQLを指定する場合
//						),
//						'Request' => array('className' => 'Request',	// クラス名
////							'foreignKey' => '',	// FKey(命名規則に沿っていない場合必要)
////							'conditions' => '',	// 連結の絞り込み条件
////							'fields' => '',	// 取得するカラム
////							'order' => '',	// 並べ替え順版
////							'limit' => '',	// 取得上限数
//							'dependent' => 'false',	// 親データ削除時に子データを削除するか
//							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
////							'finderQuery' => ''	// 自分でSQLを指定する場合
//						),
						'LanguageLanguage' => array('className' => 'LanguageLanguage',	// クラス名
							'foreignKey' => 'language_id',	// FKey(命名規則に沿っていない場合必要)
//							'conditions' => '',	// 連結の絞り込み条件
							'fields' => 'name',	// 取得するカラム
//							'order' => '',	// 並べ替え順版
//							'limit' => '',	// 取得上限数
							'dependent' => 'false',	// 親データ削除時に子データを削除するか
							'exclusive' => 'false',	// 関連オブジェクトを一つの SQLで削除するか
//							'finderQuery' => ''	// 自分でSQLを指定する場合
						),
						'AreaLanguage' => array(
							'className' => 'AreaLanguage',
							'foreignKey' => 'language_id',
							'dependent' => false,
							'conditions' => '',
							'fields' => '',
							'order' => '',
							'limit' => '',
							'offset' => '',
							'exclusive' => '',
							'finderQuery' => '',
							'counterQuery' => ''
						),
					);
}
?>