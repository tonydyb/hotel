<?php
class ListGetterComponent extends Object {

	var $_controller;

	function startup(&$controller) {
		$this->_controller = $controller;
	}




	/**
	 * 性別リストを取得します。
	 *
	 */
	function getGenderList($view_iso = DEFAULT_ISO_CODE) {
//		$genderLanguage =& new GenderLanguage();
//		// 性別を取得
//		return $genderLanguage->query(GENDER_LIST_SQL, array($view_iso));
		return $this->_controller->GenderLanguage->query(GENDER_LIST_SQL, array($view_iso));
	}

	/**
	 * 国リストを取得します。
	 *
	 */
	function getCountryList($view_iso = DEFAULT_ISO_CODE) {
//		$countryLanguage =& new CountryLanguage();
		// 国を取得
//		return $countryLanguage->query(COUNTRY_LIST_SQL, array($view_iso));
		return $this->_controller->CountryLanguage->query(COUNTRY_LIST_SQL, array($view_iso));
	}

	/**
	 * キャリアリストを取得します。
	 *
	 */
	function getCarrierTypeList() {
		$carrierType =& new CarrierType();
		// キャリアを取得
		return $carrierType->query(CARRIER_TYPE_LIST_SQL);
	}

	/**
	 * メディアリストを取得します。
	 *
	 */
	function getMediaList() {
		$carrierType =& new CarrierType();
		// メディアを取得
		return $carrierType->query(MEDIA_LIST_SQL);
	}

	/**
	 * 会員状態リストを取得します。
	 *
	 */
	function getCustomerTypeList($view_iso = DEFAULT_ISO_CODE) {
		$customerTypeLanguage =& new CustomerTypeLanguage();
		// 会員状態を取得
		return $customerTypeLanguage->query(CUSTOMER_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メルマガ状態リストを取得します。
	 *
	 */
	function getMailMagazineTypeList($view_iso = DEFAULT_ISO_CODE) {
		$mailMagazineTypeLanguage =& new MailMagazineTypeLanguage();
		// メルマガ状態を取得
		return $mailMagazineTypeLanguage->query(MAIL_MAGAZINE_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メール配布状態リストを取得します。
	 *
	 */
	function getMailDeliveryList($view_iso = DEFAULT_ISO_CODE) {
		$mailDeliveryLanguage =& new MailDeliveryLanguage();
		// メール配布状態を取得
		return $mailDeliveryLanguage->query(MAIL_DELIVERY_LIST_SQL, array($view_iso));
	}

	/**
	 * 管理者リストを取得します。
	 *
	 */
	function getAdminUserList() {
		$adminUser =& new AdminUser();
		// 管理者を取得
		return $adminUser->query(ADMIN_USER_LIST_SQL);
	}

	/**
	 * 雑インフォから、指定のcodeのリストを取得します。
	 *
	 */
	function getMiscInfoList($view_iso = DEFAULT_ISO_CODE, $misc_info_code = null) {
		$miscInfoLanguage =& new MiscInfoLanguage();
		return $miscInfoLanguage->query(MISC_INFO_LIST_SQL, array($view_iso, $misc_info_code));
	}

	/**
	 * 決済状態リストを取得します。
	 *
	 */
	function getRequestPaymentList($view_iso = DEFAULT_ISO_CODE) {
		$requestPaymentLanguage =& new RequestPaymentLanguage();
		// 決済状態を取得
		return $requestPaymentLanguage->query(REQUEST_PAYMENT_LIST_SQL, array($view_iso));
	}

	/**
	 * 決済通貨リストを取得します。
	 *
	 */
	function getCurrencyList($view_iso = DEFAULT_ISO_CODE) {
		$currencyLanguage =& new CurrencyLanguage();
		// 決済通貨を取得
		return $currencyLanguage->query(REQUEST_CURRENCY_LIST_SQL, array($view_iso));
	}

	/**
	 * 個別リクエスト状況リストを取得します。
	 *
	 */
	function getRequestStatList($view_iso = DEFAULT_ISO_CODE) {
		$requestStatLanguage =& new RequestStatLanguage();
		// 個別リクエスト状況を取得
		return $requestStatLanguage->query(REQUEST_STAT_LIST_SQL, array($view_iso));
	}

	/**
	 * ホテルエージェント(ホールセラー)リストを取得します。
	 *
	 */
	function getHotelAgentList() {
		$hotelAgent =& new HotelAgent();
		// ホテルエージェント(ホールセラー)を取得
		return $hotelAgent->query(HOTEL_AGENT_LIST_SQL);
	}

	/**
	 * エリアリストを取得します。
	 *
	 */
	function getAreaList($view_iso = DEFAULT_ISO_CODE) {
//		$areaLanguage =& new AreaLanguage();
//		// エリアを取得
//		return $areaLanguage->query(AREA_LIST_SQL, array($view_iso));

		return $this->_controller->AreaLanguage->query(AREA_LIST_SQL, array($view_iso));
	}

	/**
	 * 国リストを取得します。
	 *
	 */
	function getSelectCountryList($view_iso = DEFAULT_ISO_CODE, $area_id) {
//		$countryaLanguage =& new CountryLanguage();
//		// 国を取得
//		return $countryaLanguage->query(SELECT_COUNTRY_LIST_SQL, array($view_iso, $area_id));
		return $this->_controller->CountryLanguage->query(SELECT_COUNTRY_LIST_SQL, array($view_iso, $area_id));
	}

	/**
	 * 州リストを取得します。
	 *
	 */
	function getSelectStateList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id) {
//		$stateLanguage =& new StateLanguage();
		// 州を取得

		$add_sql = '';
		$args = array($view_iso, $area_id);
		if ($country_id != 0) {
			$add_sql .= " AND s.country_id = ?";
			array_push($args, $country_id);
		}
		$sql = sprintf(SELECT_STATE_LIST_SQL, $add_sql);
//		$stateLanguage->query($sql, $args);
		return $this->_controller->StateLanguage->query($sql, $args);
//debug($this->_controller->StateLanguage->query($sql, $args));
	}

	/**
	 * 都市リストを取得します。
	 *
	 */
	function getSelectCityList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id) {
		$cityLanguage =& new CityLanguage();
		// 都市を取得
		$add_sql = '';
		$args = array($view_iso);
		if ($country_id != 0) {
			$add_sql .= " AND c.country_id = ?";
			array_push($args, $country_id);
		}
		if ($state_id != 0) {
			$add_sql .= " AND c.state_id = ?";
			array_push($args, $state_id);
		}
		$sql = sprintf(SELECT_CITY_LIST_SQL, $add_sql);

		if (count($args) > 1) {
			return $cityLanguage->query($sql, $args);
		} else {
			return array();
		}
	}

	/**
	 * ホテルリストを取得します。
	 *
	 */
	function getSelectHotelList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id) {
		$hotelLanguage =& new HotelLanguage();
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
	function getSelectRoomList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id) {
		$hotelRoomLanguage =& new HotelRoomLanguage();
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
	function getMailTemplateNameList($view_iso = DEFAULT_ISO_CODE, $mail_template_code) {
		$mailTemplateLanguage =& new MailTemplateLanguage();
		// メールテンプレート名を取得
		return $mailTemplateLanguage->query(MAIL_TEMPLATE_NAME_LIST_SQL, array($view_iso, $mail_template_code));
	}



}
?>