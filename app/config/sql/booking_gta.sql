-- phpMyAdmin SQL Dump
-- version 2.11.10
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成時間: 2010 年 5 月 28 日 21:09
-- サーバのバージョン: 5.0.77
-- PHP のバージョン: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- データベース: `walkinhotel_com`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_area`
--

CREATE TABLE IF NOT EXISTS `gta_area` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `code` (`code`),
  KEY `language_code_code` (`language_code`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3169 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_area_link_city`
--

CREATE TABLE IF NOT EXISTS `gta_area_link_city` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `area_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `area_code` (`area_code`),
  KEY `city_code` (`city_code`),
  KEY `area_code_city_code` (`area_code`,`city_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5166 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_city`
--

CREATE TABLE IF NOT EXISTS `gta_city` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `country_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `code` (`code`),
  KEY `language_code_code` (`language_code`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39634 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_country`
--

CREATE TABLE IF NOT EXISTS `gta_country` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `code` (`code`),
  KEY `language_code_code` (`language_code`,`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=689 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel`
--

CREATE TABLE IF NOT EXISTS `gta_hotel` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `city_hotel_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line3` varchar(255) collate utf8_unicode_ci NOT NULL,
  `address_line4` varchar(255) collate utf8_unicode_ci NOT NULL,
  `telephone` varchar(32) collate utf8_unicode_ci NOT NULL,
  `fax` varchar(32) collate utf8_unicode_ci NOT NULL,
  `star_rating` int(11) unsigned NOT NULL,
  `category` varchar(255) collate utf8_unicode_ci NOT NULL,
  `room_count` int(11) unsigned NOT NULL,
  `email_address` varchar(255) collate utf8_unicode_ci NOT NULL,
  `website` varchar(255) collate utf8_unicode_ci NOT NULL,
  `geocode_latitude` varchar(32) collate utf8_unicode_ci NOT NULL,
  `geocode_longitude` varchar(32) collate utf8_unicode_ci NOT NULL,
  `map_page_link` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `code` (`code`),
  KEY `city_hotel_code` (`city_hotel_code`),
  KEY `telephone` (`telephone`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=103216 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_area_report`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_area_report` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `language_code_city_code_code` (`language_code`,`city_code`,`hotel_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_facility`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_facility` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_group`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_group` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `country_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `hotel_primary_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `city_hotel_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `room_category` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `hotel_primary_code` (`hotel_primary_code`),
  KEY `hotel_group_code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=79681 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_image`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_image` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `thumbnail_url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `image_url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_location`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_location` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_report`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_report` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_room_facility`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_room_facility` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_room_type`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_room_type` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `language_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `language_code` (`language_code`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `gta_hotel_room_price_availability`
--

CREATE TABLE IF NOT EXISTS `gta_hotel_room_price_availability` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `city_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `hotel_code` varchar(8) collate utf8_unicode_ci NOT NULL,
  `rate_minpax` int(11) unsigned NOT NULL,
  `rate_minnights` int(11) unsigned NOT NULL,
  `rate_meals` varchar(4) collate utf8_unicode_ci NOT NULL,
  `room_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `currency_code` varchar(4) collate utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `availability` int(11) unsigned NOT NULL,
  `night_date` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `city_code` (`city_code`),
  KEY `hotel_code` (`hotel_code`),
  KEY `room_code` (`room_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

