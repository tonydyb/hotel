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
		// 性別を取得
		return $this->_controller->GenderLanguage->query(GENDER_LIST_SQL, array($view_iso));
	}

	/**
	 * 国リストを取得します。
	 *
	 */
	function getCountryList($view_iso = DEFAULT_ISO_CODE) {
		// 国を取得
		return $this->_controller->CountryLanguage->query(COUNTRY_LIST_SQL, array($view_iso));
	}

	/**
	 * キャリアリストを取得します。
	 *
	 */
	function getCarrierTypeList() {
		// キャリアを取得
		return $this->_controller->CarrierType->query(CARRIER_TYPE_LIST_SQL);
	}

	/**
	 * メディアリストを取得します。
	 *
	 */
	function getMediaList() {
		// メディアを取得
		return $this->_controller->CarrierType->query(MEDIA_LIST_SQL);
	}

	/**
	 * 会員状態リストを取得します。
	 *
	 */
	function getCustomerTypeList($view_iso = DEFAULT_ISO_CODE) {
		// 会員状態を取得
		return $this->_controller->CustomerTypeLanguage->query(CUSTOMER_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メルマガ状態リストを取得します。
	 *
	 */
	function getMailMagazineTypeList($view_iso = DEFAULT_ISO_CODE) {
		// メルマガ状態を取得
		return $this->_controller->MailMagazineTypeLanguage->query(MAIL_MAGAZINE_TYPE_LIST_SQL, array($view_iso));
	}

	/**
	 * メール配布状態リストを取得します。
	 *
	 */
	function getMailDeliveryList($view_iso = DEFAULT_ISO_CODE) {
		// メール配布状態を取得
		return $this->_controller->MailDeliveryLanguage->query(MAIL_DELIVERY_LIST_SQL, array($view_iso));
	}

	/**
	 * 管理者リストを取得します。
	 *
	 */
	function getAdminUserList() {
		// 管理者を取得
		return $this->_controller->AdminUser->query(ADMIN_USER_LIST_SQL);
	}

	/**
	 * 雑インフォから、指定のcodeのリストを取得します。
	 *
	 */
	function getMiscInfoList($view_iso = DEFAULT_ISO_CODE, $misc_info_code = null) {
		return $this->_controller->MiscInfoLanguage->query(MISC_INFO_LIST_SQL, array($view_iso, $misc_info_code));
	}

	/**
	 * 決済状態リストを取得します。
	 *
	 */
	function getRequestPaymentList($view_iso = DEFAULT_ISO_CODE) {
		// 決済状態を取得
		return $this->_controller->RequestPaymentLanguage->query(REQUEST_PAYMENT_LIST_SQL, array($view_iso));
	}

	/**
	 * 決済通貨リストを取得します。
	 *
	 */
	function getCurrencyList($view_iso = DEFAULT_ISO_CODE) {
		// 決済通貨を取得
		return $this->_controller->CurrencyLanguage->query(REQUEST_CURRENCY_LIST_SQL, array($view_iso));
	}

	/**
	 * 個別リクエスト状況リストを取得します。
	 *
	 */
	function getRequestStatList($view_iso = DEFAULT_ISO_CODE) {
		// 個別リクエスト状況を取得
		return $this->_controller->RequestStatLanguage->query(REQUEST_STAT_LIST_SQL, array($view_iso));
	}

	/**
	 * ホテルエージェント(ホールセラー)リストを取得します。
	 *
	 */
	function getHotelAgentList() {
		// ホテルエージェント(ホールセラー)を取得
		return $this->_controller->HotelAgent->query(HOTEL_AGENT_LIST_SQL);
	}

	/**
	 * エリアリストを取得します。
	 *
	 */
	function getAreaList($view_iso = DEFAULT_ISO_CODE) {
		// エリアを取得
		return $this->_controller->AreaLanguage->query(AREA_LIST_SQL, array($view_iso));
	}

	/**
	 * 国リストを取得します。
	 *
	 */
	function getSelectCountryList($view_iso = DEFAULT_ISO_CODE, $area_id) {
		// 国を取得
		return $this->_controller->CountryLanguage->query(SELECT_COUNTRY_LIST_SQL, array($view_iso, $area_id));
	}

	/**
	 * 州リストを取得します。
	 *
	 */
	function getSelectStateList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id) {
		// 州を取得

		$add_sql = '';
		$args = array($view_iso, $area_id);
		if ($country_id != 0) {
			$add_sql .= " AND s.country_id = ?";
			array_push($args, $country_id);
		}
		$sql = sprintf(SELECT_STATE_LIST_SQL, $add_sql);
		return $this->_controller->StateLanguage->query($sql, $args);
	}

	/**
	 * 都市リストを取得します。
	 *
	 */
	function getSelectCityList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id) {
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
			return $this->_controller->CityLanguage->query($sql, $args);
		} else {
			return array();
		}
	}

	/**
	 * ホテルリストを取得します。
	 *
	 */
	function getSelectHotelList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id) {
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
			return $this->_controller->HotelLanguage->query($sql, $args);
		} else {
			return array();
		}
	}


	/**
	 * 部屋リストを取得します。
	 *
	 */
	function getSelectRoomList($view_iso = DEFAULT_ISO_CODE, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id) {
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
			return $this->_controller->HotelRoomLanguage->query($sql, $args);
		} else {
			return array();
		}
	}


	/**
	 * メールテンプレート名リストを取得します。
	 *
	 */
	function getMailTemplateNameList($view_iso = DEFAULT_ISO_CODE, $mail_template_code) {
		// メールテンプレート名を取得
		return $this->_controller->MailTemplateLanguage->query(MAIL_TEMPLATE_NAME_LIST_SQL, array($view_iso, $mail_template_code));
	}

	function getCancelChargeList($request_hotel_id) {
		// メールテンプレート名を取得
		return $this->_controller->CancelCharge->query(CANCEL_CHARGE_LIST_SQL, array($request_hotel_id));
	}

	function getMealTypeList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->MealTypeLanguage->query(MEAL_TYPE_LIST_SQL, array($view_iso, ));
	}

	function getBreakfastTypeList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->BreakfastTypeLanguage->query(BREAKFAST_TYPE_LIST_SQL, array($view_iso, ));
	}

	function getHotelFacilityList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->HotelFacilityLanguage->query(HOTEL_FACILITY_LIST_SQL, array($view_iso, ));
	}

	function getLanguageList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->ViewLanguage->query(LANGUAGE_LIST_SQL, array($view_iso, ));
	}

	function getHotelLinkFacilityList($view_iso = DEFAULT_ISO_CODE, $hotel_id = 0) {
		$add_sql = '';
		$args = array($view_iso);
		if ($hotel_id != 0) {
			$add_sql .= " AND hlf.hotel_id = ?";
			array_push($args, $hotel_id);
		}

		$sql = sprintf(HOTEL_LINK_FACILITY_LIST_SQL, $add_sql);
		return $this->_controller->HotelLinkFacility->query($sql, $args);
	}

	function getHotelGradeList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->HotelGradeLanguage->query(HOTEL_GRADE_LIST_SQL, array($view_iso, ));
	}

	function getRoomBedList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->RoomBedLanguage->query(ROOM_BED_LIST_SQL, array($view_iso, ));
	}

	function getSmokingList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->SmokingLanguage->query(SMOKING_LIST_SQL, array($view_iso, ));
	}

	function getRoomFacilityList($view_iso = DEFAULT_ISO_CODE) {
		return $this->_controller->RoomFacilityLanguage->query(ROOM_FACILITY_LIST_SQL, array($view_iso, ));
	}

	function getRoomLinkFacilityList($view_iso = DEFAULT_ISO_CODE, $hotel_room_id = 0) {
		$add_sql = '';
		$args = array($view_iso);
		if ($hotel_room_id != 0) {
			$add_sql .= " AND hrlrf.hotel_room_id = ?";
			array_push($args, $hotel_room_id);
		}

		$sql = sprintf(ROOM_LINK_FACILITY_LIST_SQL, $add_sql);
		return $this->_controller->HotelRoomLinkRoomFacility->query($sql, $args);
	}

}
?>