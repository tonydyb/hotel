<?php
class SelectGetterComponent extends Object {

	var $components = array('Session');

	/**
	 * 性別リストを取得します。
	 *
	 */
	function getGender($view_iso = DEFAULT_ISO_CODE) {
		$genderLanguage =& new GenderLanguage();
		// 性別を取得
		return $genderLanguage->query(GENDER_LIST_SQL, array($view_iso));
	}

	/**
	 * 言語リストを取得します。
	 *
	 */
	function getLanguage() {
		$userInstance = ClassRegistry::init('Language');
		return $userInstance->query("select language.id as id, language_language.name as name from language left join (select * from language_language where iso_language_id=" . $this->getIsoId() . ") as language_language on  language.id = language_language.language_id order by language_language.name");
    }

	/**
	 * 国リストを取得します。
	 *
	 */
	function getCountry() {
		$userInstance = ClassRegistry::init('Country');
		return $userInstance->query("select country.id as id, country.iso_code_a2 as iso_code_a2, CountryLanguage.name_long as name from country as Country left join (select * from country_language where language_id=" . $this->getIsoId() . ") as CountryLanguage on country.id = CountryLanguage.country_id order by CountryLanguage.name_long");
    }

	/**
	 * 都市リストを取得します。
	 *
	 */
	function getCity($countryId = null) {
		if(!$countryId) {
			return false;
		}
		$userInstance = ClassRegistry::init('City');
		return $userInstance->query("select city.id as id, city.code as code, CityLanguage.name as name from city as City join (select * from city_language where language_id=" . $this->getIsoId() . ") as CityLanguage on City.id = CityLanguage.city_id where City.country_id=$countryId order by CityLanguage.name");
    }

	/**
	 * キャリアリストを取得します。
	 *
	 */
	function getCarrierType() {
		$userInstance = ClassRegistry::init('CarrierType');
		return $userInstance->query("select id, name from carrier_type as CarrierType");
	}

	/**
	 * content layoutリストを取得します。
	 *
	 */
	function getContentLayout() {
		$userInstance = ClassRegistry::init('ContentLayout');
		return $userInstance->query("select id, name from content_layout as ContentLayout");
	}

	/**
	 * メディアリストを取得します。
	 *
	 */
	function getMedia() {
		$carrierType =& new CarrierType();
		// メディアを取得
		return $carrierType->query(MEDIA_LIST_SQL);
	}

	/**
	 * 会員状態リストを取得します。
	 *
	 */
	function getCustomerType($view_iso = DEFAULT_ISO_CODE) {
		$customerTypeLanguage =& new CustomerTypeLanguage();
		// 会員状態を取得
		return $customerTypeLanguage->query(CUSTOMER_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メルマガ状態リストを取得します。
	 *
	 */
	function getMailMagazineType($view_iso = DEFAULT_ISO_CODE) {
		$mailMagazineTypeLanguage =& new MailMagazineTypeLanguage();
		// メルマガ状態を取得
		return $mailMagazineTypeLanguage->query(MAIL_MAGAZINE_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メール配布状態リストを取得します。
	 *
	 */
	function getMailDelivery($view_iso = DEFAULT_ISO_CODE) {
		$mailDeliveryLanguage = new MailDeliveryLanguage();
		// メール配布状態を取得
		return $mailDeliveryLanguage->query(MAIL_DELIVERY_LIST_SQL, array($view_iso));
	}

	/**
	 * 管理者リストを取得します。
	 *
	 */
	function getAdminUser() {
		$adminUser = new AdminUser();
		// 管理者を取得
		return $adminUser->query(ADMIN_USER_LIST_SQL);
	}

	/**
	 * 雑インフォから、指定のcodeのリストを取得します。
	 *
	 */
	function getMiscInfo($view_iso = DEFAULT_ISO_CODE, $misc_info_code = null) {
		$miscInfoLanguage = new MiscInfoLanguage();
		return $miscInfoLanguage->query(MISC_INFO_LIST_SQL, array($view_iso, $misc_info_code));
	}

	/**
	 * 決済状態リストを取得します。
	 *
	 */
	function getRequestPayment($view_iso = DEFAULT_ISO_CODE) {
		$requestPaymentLanguage = new RequestPaymentLanguage();
		// 決済状態を取得
		return $requestPaymentLanguage->query(REQUEST_PAYMENT_LIST_SQL, array($view_iso));
	}

	/**
	 * 決済通貨リストを取得します。
	 *
	 */
	function getCurrency($view_iso = DEFAULT_ISO_CODE) {
		$currencyLanguage = new CurrencyLanguage();
		// 決済通貨を取得
		return $currencyLanguage->query(REQUEST_CURRENCY_LIST_SQL, array($view_iso));
	}

	/**
	 * 個別リクエスト状況リストを取得します。
	 *
	 */
	function getRequestStat($view_iso = DEFAULT_ISO_CODE) {
		$requestStatLanguage = new RequestStatLanguage();
		// 個別リクエスト状況を取得
		return $requestStatLanguage->query(REQUEST_STAT_LIST_SQL, array($view_iso));
	}

	/**
	 * ホテルエージェント(ホールセラー)リストを取得します。
	 *
	 */
	function getHotelAgent() {
		$hotelAgent = new HotelAgent();
		// ホテルエージェント(ホールセラー)を取得
		return $hotelAgent->query(HOTEL_AGENT_LIST_SQL);
	}

	/**
	 * エリアリストを取得します。
	 *
	 */
	function getArea($view_iso = DEFAULT_ISO_CODE) {
		$areaLanguage = new AreaLanguage();
		// エリアを取得
		return $areaLanguage->query(AREA_LIST_SQL, array($view_iso));
	}

	/**
	 * 州リストを取得します。
	 *
	 */
	function getState($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id) {
		$stateLanguage = new StateLanguage();
		// 州を取得

		$add_sql = '';
		$args = array($view_iso, $area_id);
		if ($country_id != 0) {
			$add_sql .= " AND s.country_id = ?";
			array_push($args, $country_id);
		}
		$sql = sprintf(SELECT_STATE_LIST_SQL, $add_sql);
		$stateLanguage->query($sql, $args);

	}

	/**
	 * ホテルリストを取得します。
	 *
	 */
	function getHotel($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id) {
		$hotelLanguage = new HotelLanguage();
		// ホテルを取得
		$add_sql = '';
		$args = array($view_iso);
		if ($country_id != 0) {
			$add_sql .= " AND h.country_id = ?";
			array_push($args, $country_id);
		}
		if ($state_id != 0) {
			$add_sql .= " AND h.state_id = ?";
			array_push($args, $state_id);
		}
		if ($city_id != 0) {
			$add_sql .= " AND h.city_id = ?";
			array_push($args, $city_id);
		}
		$sql = sprintf(SELECT_HOTEL_LIST_SQL, $add_sql);

		if (count($args) > 1) {
			return $hotelLanguage->query($sql, $args);
		} else {
			return array();
		}
	}


	/**
	 * 部屋リストを取得します。
	 *
	 */
	function getRoom($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id) {
		$hotelRoomLanguage = new HotelRoomLanguage();
		// 部屋を取得
		$add_sql = '';
		$args = array($view_iso);
		if ($hotel_id != 0) {
			$add_sql .= " AND hr.hotel_id = ?";
			array_push($args, $hotel_id);
		}
		if ($agent_id != 0) {
			$add_sql .= " AND hr.hotel_agent_id = ?";
			array_push($args, $agent_id);
		}

		$sql = sprintf(SELECT_ROOM_LIST_SQL, $add_sql);

		if (count($args) == 3) {
			return $hotelRoomLanguage->query($sql, $args);
		} else {
			return array();
		}
	}

	/**
	 * メールテンプレート名リストを取得します。
	 *
	 */
	function getMailTemplateName($view_iso = DEFAULT_ISO_CODE, $mail_template_code) {
		$mailTemplateLanguage = new MailTemplateLanguage();
		// メールテンプレート名を取得
		return $mailTemplateLanguage->query(MAIL_TEMPLATE_NAME_LIST_SQL, array($view_iso, $mail_template_code));
	}


	function getIsoId() {
		$sql = "select id from language where iso_code='" . $this->Session->read('view_iso') . "'";
		$result = mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			if (mysql_num_rows($result)) {
				$row = mysql_fetch_row($result);
				return $row[0];
			} else {
				return DEFAULT_ISO_ID;
			}
		}
	}
}
?>