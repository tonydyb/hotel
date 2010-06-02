<?php
/* SVN FILE: $Id$ */
/**
 * Custom Inflected Words.
 *
 * This file is used to hold words that are not matched in the normail Inflector::pluralize() and
 * Inflector::singularize()
 *
 * PHP versions 4 and %
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 1.0.0.2312
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a key => value array of regex used to match words.
 * If key matches then the value is returned.
 *
 *  $pluralRules = array('/(s)tatus$/i' => '\1\2tatuses', '/^(ox)$/i' => '\1\2en', '/([m|l])ouse$/i' => '\1ice');
 */
	$pluralRules = array();
/**
 * This is a key only array of plural words that should not be inflected.
 * Notice the last comma
 *
 * $uninflectedPlural = array('.*[nrlm]ese', '.*deer', '.*fish', '.*measles', '.*ois', '.*pox');
 */
	$uninflectedPlural = array();
/**
 * This is a key => value array of plural irregular words.
 * If key matches then the value is returned.
 *
 *  $irregularPlural = array('atlas' => 'atlases', 'beef' => 'beefs', 'brother' => 'brothers')
 */
	$irregularPlural = array(
		// テーブル定義あり(昇順)
		'admin_user' => 'admin_user',
		'area' => 'area',
		'area_language' => 'area_language',
		'area_link_city' => 'area_link_city',
		'area_link_country' => 'area_link_country',
		'area_link_state' => 'area_link_state',
		'area_link_town' => 'area_link_town',
		'breakfast_type' => 'breakfast_type',
		'breakfast_type_language' => 'breakfast_type_language',
		'city' => 'city',
		'city_language' => 'city_language',
		'city_link_location' => 'city_link_location',
		'country' => 'country',
		'country_language' => 'country_language',
		'currency' => 'currency',
		'currency_language' => 'currency_language',
		'customer_user' => 'customer_user',
		'gender' => 'gender',
		'gender_language' => 'gender_language',
		'hotel' => 'hotel',
		'hotel_agent' => 'hotel_agent',
		'hotel_agent_user' => 'hotel_agent_user',
		'hotel_facility' => 'hotel_facility',
		'hotel_facility_language' => 'hotel_facility_language',
		'hotel_grade' => 'hotel_grade',
		'hotel_grade_language' => 'hotel_grade_language',
		'hotel_image' => 'hotel_image',
		'hotel_image_language' => 'hotel_image_language',
		'hotel_language' => 'hotel_language',
		'hotel_link_facility' => 'hotel_link_facility',
		'hotel_room' => 'hotel_room',
		'hotel_room_facility' => 'hotel_room_facility',
		'hotel_room_language' => 'hotel_room_language',
		'hotel_user' => 'hotel_user',
		'language' => 'language',
		'language_language' => 'language_language',
		'location' => 'location',
		'location_language' => 'location_language',
		'meal_type' => 'meal_type',
		'meal_type_language' => 'meal_type_language',
		'request' => 'request',
		'request_hotel' => 'request_hotel',
		'request_hotel_custome_user' => 'request_hotel_custome_user',
		'request_payment' => 'request_payment',
		'request_payment_language' => 'request_payment_language',
		'request_stat' => 'request_stat',
		'request_stat_language' => 'request_stat_language',
		'room_bed' => 'room_bed',
		'room_bed_language' => 'room_bed_language',
		'room_facility' => 'room_facility',
		'room_facility_language' => 'room_facility_language',
		'room_grade' => 'room_grade',
		'room_grade_language' => 'room_grade_language',
		'smoking' => 'smoking',
		'smoking_language' => 'smoking_language',
		'state' => 'state',
		'state_language' => 'state_language',
		'town' => 'town',
		'town_language' => 'town_language',
		'town_link_location' => 'town_link_location',

		// DB定義追加分
		'carrier_type' => 'carrier_type',
		'media' => 'media',
		'customer_type' => 'customer_type',
		'customer_type_language' => 'customer_type_language',
		'mail_magazine_type' => 'mail_magazine_type',
		'mail_magazine_type_language' => 'mail_magazine_type_language',
		'mail_delivery' => 'mail_delivery',
		'mail_delivery_language' => 'mail_delivery_language',
		'request_hotel_customer_user' => 'request_hotel_customer_user',
		'request_receipt' => 'request_receipt',
		'misc_info' => 'misc_info',
		'misc_info_language' => 'misc_info_language',
		'mail_template' => 'mail_template',
		'mail_template_language' => 'mail_template_language',
		'discount_item' => 'discount_item',
		'discount_type' => 'discount_type',
		'discount' => 'discount',
		'content_block' => 'content_block',
		'content_page' => 'content_page',
		'content_layout' => 'content_layout',
		'cancel_charge' => 'cancel_charge',
		'hotel_emergency_contact' => 'hotel_emergency_contact',
		'hotel_room_link_room_facility' => 'hotel_room_link_room_facility',
		'area_convert_agent' => 'area_convert_agent',
		'breakfast_type_convert_agent' => 'breakfast_type_convert_agent',
		'city_convert_agent' => 'city_convert_agent',
		'hotel_facility_convert_agent' => 'hotel_facility_convert_agent',
		'hotel_grade_convert_agent' => 'hotel_grade_convert_agent',
		'language_convert_agent' => 'language_convert_agent',
		'location_convert_agent' => 'location_convert_agent',
		'meal_type_convert_agent' => 'meal_type_convert_agent',
		'room_bed_convert_agent' => 'room_bed_convert_agent',
		'room_facility_convert_agent' => 'room_facility_convert_agent',
		'room_grade_convert_agent' => 'room_grade_convert_agent',
		'smoking_convert_agent' => 'smoking_convert_agent',
		'content_document' => 'content_document',
		'content_document_language' => 'content_document_language',

		// 以下テーブル定義なし
		'admin' => 'admin',
		'login' => 'login',
		'view_language' => 'view_language',
		'condition' => 'condition',
		'condition2' => 'condition2',
		'add_content_document' => 'add_content_document',
	);

/**
 * This is a key => value array of regex used to match words.
 * If key matches then the value is returned.
 *
 *  $singularRules = array('/(s)tatuses$/i' => '\1\2tatus', '/(matr)ices$/i' =>'\1ix','/(vert|ind)ices$/i')
 */
	$singularRules = array();

?>