<?php

class VoucherComponent extends Object{

/**
 * Startup component
 *
 * @param object $controller Instantiating controller
 * @access public
 */
	function startup(&$controller) {
		$this->_controller = $controller;
	}

	var $request_hotel_id = null;

	function index($voucher_name, $view_iso, $customer_user_id, $password, $request_hotel_id = null, &$request_hotel, &$request_hotel_customer_user) {
		$request_hotel_id = !is_null($request_hotel_id) ? $request_hotel_id : $this->request_hotel_id;

		if (is_null($customer_user_id) || is_null($password) || is_null($request_hotel_id)) {
			return;
		} else {
			$request_hotel = $this->_controller->RequestHotel->query(VAUCHER_DATA_SQL, array($customer_user_id, $password, $request_hotel_id, $view_iso));
			$request_hotel_customer_user = $this->_controller->RequestHotelCustomerUser->query(REQUEST_HOTEL_CUSTOMER_USER_LIST_SQL, array($request_hotel[0]['voucher_data']['request_id'], $request_hotel[0]['voucher_data']['id']));
			$hotel_agent = $this->_controller->HotelAgent->find('first', array('conditions' => array('HotelAgent.id' => $request_hotel[0]['voucher_data']['hotel_agent_id'], 'HotelAgent.deleted is null')));
			$country = $this->_controller->CountryLanguage->find('first', array('conditions' => array('CountryLanguage.country_id' => $hotel_agent['HotelAgent']['addr_country_id'], 'CountryLanguage.language_id' => $request_hotel[0]['voucher_data']['language_id'], 'CountryLanguage.deleted is null')));
			$emergency_contact = $this->_controller->HotelEmergencyContact->query(HOTEL_EMERGENCY_CONTACT_LIST_SQL, array($request_hotel[0]['voucher_data']['hotel_id'], $request_hotel[0]['voucher_data']['hotel_agent_id']));

			$request_hotel = $request_hotel[0]['voucher_data'];
			$tmp = array();
			$count_adlut = 0;
			$count_child = 0;
			foreach($request_hotel_customer_user as $user) {
				$tmp[] = $user['request_hotel_customer_user'];
				if ($user['request_hotel_customer_user']['adult'] == ADULT_CODE_ADULT) {
					$count_adlut++;
				} else {
					$count_child++;
				}
			}
			$request_hotel_customer_user = $tmp;
			$date = $this->isLegalDate($request_hotel['checkin']);
			$request_hotel['checkin'] = $this->stringDateToArray($date);
			$request_hotel['checkin']['date'] = $date;
			$date = $this->isLegalDate($request_hotel['checkout']);
			$request_hotel['checkout'] = $this->stringDateToArray($date);
			$request_hotel['checkout']['date'] = $date;
			$date = $this->isLegalDateTime($request_hotel['limit_date']);
			$request_hotel['limit_date'] = $this->stringDateToArray($date);
			$request_hotel['limit_date']['date'] = $date;
			$request_hotel['adult_count'] = $count_adlut;
			$request_hotel['child_count'] = $count_child;
			$request_hotel['hotel_agent'] = $hotel_agent['HotelAgent'];
			$request_hotel['hotel_agent']['country'] = $country['CountryLanguage']['name_long'];
			$tmpData = null;
			foreach ($emergency_contact as $contact) {
				$tmpData[] = $contact['hotel_emergency_contact'];
			}
			$request_hotel['emergency_contact'] = $tmpData;
		}
	}

	function reset() {
		$this->request_hotel_id = null;
	}


	/***
	 * 日付配列が日付として正しいか判定し、日付として正しい場合、成形して返します。
	 * 日付が不正の場合、不正な日付文字列として返します。
	 */
	function isLegalDate($dateArray) {
		$result = null;
		if (!empty($dateArray['year']) && !empty($dateArray['month']) && !empty($dateArray['day'])) {
			if (checkdate($dateArray['month'], $dateArray['day'], $dateArray['year'])) {
				$result = date('Y-m-d', strtotime($dateArray['year'].'-'.$dateArray['month'].'-'.$dateArray['day']));
			} else {
				$result = $dateArray['year'].'-'.$dateArray['month'].'-'.$dateArray['day'];
			}
		}
		return $result;
	}

	/***
	 * 日付配列が日付として正しいか判定し、日付として正しい場合、成形して返します。
	 * 日付が不正の場合、不正な日付文字列として返します。
	 */
	function isLegalDateTime($dateArray) {
		$result = null;
		if (!empty($dateArray['year']) && !empty($dateArray['month']) && !empty($dateArray['day'])) {
			if (checkdate($dateArray['month'], $dateArray['day'], $dateArray['year'])) {
				$result = date('Y-m-d', strtotime($dateArray['year'].'-'.$dateArray['month'].'-'.$dateArray['day']));
			} else {
				$result = $dateArray['year'].'-'.$dateArray['month'].'-'.$dateArray['day'];
			}
			if (empty($dateArray['hour'])) {
				$result .= ' 00:00';
			} else {
				$result .= ' '.$dateArray['hour'].':00';
			}
		}
		return $result;
	}

	function dateFormat($date, $format = "Y/m/d") {
		$result = '';
		if (!empty($date)) {
			if ($date == '0000-00-00 00:00:00') {
				$result = '';
			} else {
				$result = date($format, strtotime($date));
			}
		}
		return $result;
	}

	function df($date, $format = "Y/m/d") {
		$result = '';
		if (!empty($date)) {
			$result = $this->dateFormat($date, $format);
		}
		return $result;
	}

	function dmf($date, $format = "Y/m/d H:i") {
		$result = '';
		if (!empty($date)) {
			$result = $this->dateFormat($date, $format);
		}
		return $result;
	}

	function stringDateToArray($date = null) {
		if (empty($date)) {
			$date = date("Y-m-d H:i:s");
		}

		$keys = array('year','month','day','hour','min','sec');
		$values = sscanf($date, '%d-%d-%d %d:%d:%d');
		return array_combine($keys, $values);
	}

}
?>
