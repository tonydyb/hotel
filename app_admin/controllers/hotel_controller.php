<?php
class HotelController extends AppController {
	var $name = "Hotel";
	var $needAuth = true;	// ログイン必須のフラグ
	var $helpers = array('Construct', 'Javascript', 'Ajax', 'Number', 'Time', );
	var $components = array('ModelUtil', 'ListGetter', 'RequestHandler', );
	var $uses = array(
				'Hotel', 'HotelLanguage', 'HotelAgent', 'CountryLanguage', 'StateLanguage', 'CityLanguage',
				'HotelFacilityLanguage', 'ViewLanguage', 'AreaLanguage', 'HotelLinkFacility', 'HotelGradeLanguage',
				'RoomBedLanguage', 'SmokingLanguage', 'MealTypeLanguage', 'BreakfastTypeLanguage', 'CurrencyLanguage',
				'HotelRoom', 'HotelRoomLanguage', 'HotelRoomLinkRoomFacility', 'RoomFacilityLanguage',
				'HotelImage', 'HotelImageLanguage', 'CancelCharge', 'MiscInfoLanguage', 'HotelEmergencyContact',
				);

	function index () {

	}

	function edit ($hotel_id = null) {
		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$view_list = array();

		$this->get_edit_view_list($view_iso, $view_list);

		$hotel = null;
		$hotel_language = null;
		$hotel_link_facility = null;
		$country = array();
		$state = array();
		$city = array();
		if (is_null($hotel_id)) {
			// 新規作成
			$hotel = $this->get_hotel_skeleton();
			$hotel_language = $this->get_hotel_language_skeleton();
			$hotel_link_facility = $this->ListGetter->getHotelLinkFacilityList($view_iso);
			$hotel_room[] = $this->get_hotel_room_skeleton();
			$hotel_room_language[] = $this->get_hotel_room_language_skeleton();
			$room_link_facility[] = $this->ListGetter->getRoomLinkFacilityList($view_iso);
			$hotel_image[] = $this->get_hotel_image_skeleton();
			$hotel_image_language[] = $this->get_hotel_image_language_skeleton();
			$cancel_charge[] = $this->get_cancel_charge_skeleton();
			$hotel_emergency_contact[] = $this->get_hotel_emergency_contact_skeleton();
		} else {
			// 編集
			$hotel_link_facility = $this->ListGetter->getHotelLinkFacilityList($view_iso, $hotel_id);

			// ループで部屋数だけ
//			$room_link_facility = $this->ListGetter->getRoomLinkFacilityList($view_iso, $hotel_room_id);
		}

		$view_list['Hotel'] = $hotel;
		$view_list['HotelLanguage'] = $hotel_language;
		$view_list['HotelRoom'] = $hotel_room;
		$view_list['HotelRoomLanguage'] = $hotel_room_language;
		$view_list['HotelLinkFacility'] = $hotel_link_facility;
		$view_list['HotelRoomLinkRoomFacility'] = $room_link_facility;
		$view_list['HotelImage'] = $hotel_image;
		$view_list['HotelImageLanguage'] = $hotel_image_language;
		$view_list['CancelCharge'] = $cancel_charge;
		$view_list['HotelEmergencyContact'] = $hotel_emergency_contact;

		$this->get_place_data($hotel, $view_list, $view_iso);
		$this->get_contact_place_data($view_list, $view_iso);

		$view_list['default_iso_code'] = $view_iso;
//		$viewList['country'] = $this->ListGetter->getCountryList($view_iso);

		$this->set_view_list_data($view_list);
	}

	function set_view_list_data($view_list) {
		$keys = array_keys($view_list);
		foreach ($keys as $key) {
			$this->set($key, $view_list[$key]);
		}
	}

	function get_edit_view_list($view_iso = null, &$view_list = array()) {
		if (is_null($view_iso)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}
		$area = $this->ListGetter->getAreaList($view_iso);
		array_unshift($area, array('al'=>array('area_id'=>'0','name'=>'')));
		$view_list['area'] = $area;
		$view_list['hotel_agent'] = $this->ListGetter->getHotelAgentList();
		$view_list['hotel_facility'] = $this->ListGetter->getHotelFacilityList($view_iso);
		$view_list['language'] = $this->ListGetter->getLanguageList($view_iso);
		$view_list['hotel_grade'] = $this->ListGetter->getHotelGradeList($view_iso);
		$view_list['room_bed'] = $this->ListGetter->getRoomBedList($view_iso);
		$view_list['smoking'] = $this->ListGetter->getSmokingList($view_iso);
		$view_list['meal_type'] = $this->ListGetter->getMealTypeList($view_iso);
		$view_list['breakfast_type'] = $this->ListGetter->getBreakfastTypeList($view_iso);
		$view_list['currency'] = $this->ListGetter->getCurrencyList($view_iso);
		$view_list['cancel_charge_const'] = $this->ListGetter->getMiscInfoList($view_iso, 'cancel_charge_const');





	}

	function get_index_view_list() {

	}

	function get_hotel_skeleton() {
		$hotel_skel = $this->ModelUtil->getSkeleton($this->Hotel);
		$hotel_skel['area_id'] = '0';
		$hotel_skel['star_rate'] = '0';
		$hotel_skel['checkin'] = array('hour'=>'', 'min'=>'');
		$hotel_skel['checkout'] = array('hour'=>'', 'min'=>'');
		$hotel_skel['display_stat'] = DISPLAY_STAT_EXIST;
		return $hotel_skel;
	}

	function get_hotel_language_skeleton() {
		$hotel_language_skel = $this->ModelUtil->getSkeleton($this->HotelLanguage);
		return $hotel_language_skel;
	}

	function get_hotel_room_skeleton() {
		$hotel_room_skel = $this->ModelUtil->getSkeleton($this->HotelRoom);
		$hotel_room_skel['delete'] = '0';
		return $hotel_room_skel;
	}

	function get_hotel_room_language_skeleton() {
		$hotel_room_language_skel = $this->ModelUtil->getSkeleton($this->HotelRoomLanguage);
		return $hotel_room_language_skel;
	}

	function get_hotel_image_skeleton() {
		$hotel_image_skel = $this->ModelUtil->getSkeleton($this->HotelImage);
		$hotel_image_skel['delete'] = '0';
		return $hotel_image_skel;
	}

	function get_hotel_image_language_skeleton() {
		$hotel_image_language_skel = $this->ModelUtil->getSkeleton($this->HotelImageLanguage);
		return $hotel_image_language_skel;
	}


	function get_cancel_charge_skeleton() {
		$cancel_charge_skel = $this->ModelUtil->getSkeleton($this->CancelCharge);
		$cancel_charge_skel['delete'] = '0';
		$hotel_skel['term_from'] = array('year'=>'', 'month'=>'', 'day'=>'');
		$hotel_skel['term_to'] = array('year'=>'', 'month'=>'', 'day'=>'');
		return $cancel_charge_skel;
	}

	function get_hotel_emergency_contact_skeleton() {
		$hotel_image_language_skel = $this->ModelUtil->getSkeleton($this->HotelEmergencyContact);
		$hotel_image_language_skel['delete'] = '0';
		return $hotel_image_language_skel;
	}

	function get_place_data($hotel, &$view_list = array(), $view_iso = null) {
		if (is_null($view_iso)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}
		if (!empty($hotel['area_id']) && $hotel['area_id'] != 0 && $hotel['area_id'] != '') {
			$area_id = $hotel['area_id'];
			$country_id = $hotel['country_id'];
			$state_id = $hotel['state_id'];
			$city_id = $hotel['city_id'];
			$countrys = $this->ListGetter->getSelectCountryList($view_iso, $area_id);
			array_unshift($countrys, array('cl'=>array('country_id'=>'0','name'=>'')));
			$states = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);
			array_unshift($states, array('sl'=>array('state_id'=>'0','name'=>'')));
			$citys = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);
			array_unshift($citys, array('cl'=>array('city_id'=>'0','name'=>'')));

			$view_list['country'] = $countrys;
			$view_list['state'] = $states;
			$view_list['city'] = $citys;
		} else {
			$view_list['country'] = array();
			$view_list['state'] = array();
			$view_list['city'] = array();
		}
	}

	function get_contact_place_data(&$view_list, $view_iso = null) {
		if (is_null($view_iso)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		for ($i = 0; $i < count($view_list['HotelEmergencyContact']); $i++) {
			$hec_place = array();
			$this->get_place_data($view_list['HotelEmergencyContact'][$i], $hec_place, $view_iso);
			$view_list['hec_country'][$i] = $hec_place['country'];
			$view_list['hec_state'][$i] = $hec_place['state'];
			$view_list['hec_city'][$i] = $hec_place['city'];
		}
	}

	function add_room() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		// POSTデータを表示用に詰めなおし
		$post = $this->data;
		$repacked_data = array();
		$this->repacked_post_data($post, $repacked_data);
		if ($post['AddData']['add_room'] != 0) {
			for ($i = 0; $i < $post['AddData']['add_room']; $i++) {
				$repacked_data['HotelRoom'][] = $this->get_hotel_room_skeleton();
				$repacked_data['HotelRoomLanguage'][] = $this->get_hotel_room_language_skeleton();
				$repacked_data['HotelRoomLinkRoomFacility'][] = $this->ListGetter->getRoomLinkFacilityList($view_iso);
			}
		}
		$this->get_edit_view_list($view_iso, $repacked_data);

		$this->get_place_data($repacked_data['Hotel'], $repacked_data, $view_iso);
		$this->get_contact_place_data($repacked_data, $view_iso);
		$repacked_data['default_iso_code'] = $view_iso;

		$this->set_view_list_data($repacked_data);
		$this->render('/hotel/edit/');
	}

	function add_pic() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		// POSTデータを表示用に詰めなおし
		$post = $this->data;
		$repacked_data = array();
		$this->repacked_post_data($post, $repacked_data);
		if ($post['AddData']['add_pic'] != 0) {
			for ($i = 0; $i < $post['AddData']['add_pic']; $i++) {
				$repacked_data['HotelImage'][] = $this->get_hotel_image_skeleton();
				$repacked_data['HotelImageLanguage'][] = $this->get_hotel_image_language_skeleton();
			}
		}
		$this->get_edit_view_list($view_iso, $repacked_data);

		$this->get_place_data($repacked_data['Hotel'], $repacked_data, $view_iso);
		$this->get_contact_place_data($repacked_data, $view_iso);
		$repacked_data['default_iso_code'] = $view_iso;

		$this->set_view_list_data($repacked_data);
		$this->render('/hotel/edit/');
	}

	function add_cancel() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		// POSTデータを表示用に詰めなおし
		$post = $this->data;
		$repacked_data = array();
		$this->repacked_post_data($post, $repacked_data);
		if ($post['AddData']['add_cancel'] != 0) {
			for ($i = 0; $i < $post['AddData']['add_cancel']; $i++) {
				$repacked_data['CancelCharge'][] = $this->get_cancel_charge_skeleton();
			}
		}
		$this->get_edit_view_list($view_iso, $repacked_data);

		$this->get_place_data($repacked_data['Hotel'], $repacked_data, $view_iso);
		$this->get_contact_place_data($repacked_data, $view_iso);
		$repacked_data['default_iso_code'] = $view_iso;

		$this->set_view_list_data($repacked_data);
		$this->render('/hotel/edit/');
	}

	function add_contact() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		// POSTデータを表示用に詰めなおし
		$post = $this->data;
		$repacked_data = array();
		$this->repacked_post_data($post, $repacked_data);

		$repacked_data['HotelEmergencyContact'][] = $this->get_hotel_emergency_contact_skeleton();

		$this->get_edit_view_list($view_iso, $repacked_data);

		$this->get_place_data($repacked_data['Hotel'], $repacked_data, $view_iso);
		$this->get_contact_place_data($repacked_data, $view_iso);
		$repacked_data['default_iso_code'] = $view_iso;

		$this->set_view_list_data($repacked_data);
		$this->render('/hotel/edit/');
	}

	function repacked_post_data($data, &$packed = array()) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		$hotel = $this->get_hotel_skeleton();
		$hotel_language = $this->get_hotel_language_skeleton();
		$hotel_link_facility;
		$hotel_room ;
		$hotel_room_language;
		$room_link_facility;
		$hotel_image;
		$hotel_image_language;
		$cancel_charge;
		$hotel_emergency_contact;

		$keys = array_keys($data);

		foreach ($keys as $key) {
			$now_data = $data[$key];
			$tmp_data = null;
			$is_dim = false;
			$is_hotel_facility = false;
			$is_room_facility = false;
			$is_skip = false;
			$skeleton = null;
			if ($key == 'Hotel') {
				$tmp_data = &$hotel;
			} else if ($key == 'HotelLanguage') {
				$tmp_data = &$hotel_language;
			} else if ($key == 'HotelLinkFacility') {
				$tmp_data = &$hotel_link_facility;
				$skeleton =  $this->ListGetter->getHotelLinkFacilityList($view_iso);
				$is_dim = true;
				$is_hotel_facility = true;
			} else if ($key == 'HotelRoom') {
				$tmp_data = &$hotel_room;
				$skeleton = $this->get_hotel_room_skeleton();
				$is_dim = true;
			} else if ($key == 'HotelRoomLanguage') {
				$tmp_data = &$hotel_room_language;
				$skeleton = $this->get_hotel_room_language_skeleton();
				$is_dim = true;
			} else if ($key == 'HotelRoomLinkRoomFacility') {
				$tmp_data = &$room_link_facility;
				$skeleton = $this->ListGetter->getRoomLinkFacilityList($view_iso);
				$is_dim = true;
				$is_room_facility = true;
			} else if ($key == 'HotelImage') {
				$tmp_data = &$hotel_image;
				$skeleton = $this->get_hotel_image_skeleton();
				$is_dim = true;
			} else if ($key == 'HotelImageLanguage') {
				$tmp_data = &$hotel_image_language;
				$skeleton = $this->get_hotel_image_language_skeleton();
				$is_dim = true;
			} else if ($key == 'CancelCharge') {
				$tmp_data = &$cancel_charge;
				$skeleton = $this->get_cancel_charge_skeleton();
				$is_dim = true;
			} else if ($key == 'HotelEmergencyContact') {
				$tmp_data = &$hotel_emergency_contact;
				$skeleton = $this->get_hotel_emergency_contact_skeleton();
				$is_dim = true;
			} else if ($key == 'AddData') {
				$is_skip = true;
			}
			if (!$is_skip) {
				if (!$is_dim) {
					$tmp_keys = array_keys($tmp_data);
					foreach($tmp_keys as $tmp_key) {
						if (array_key_exists($tmp_key, $now_data)) {
							$tmp_data[$tmp_key] = $now_data[$tmp_key];
						}
					}
				} else {
					if ($is_hotel_facility) {
						for ($i= 0; $i < count($now_data); $i++) {
							$tmp_data = $skeleton;
							$tmp_keys_dim = array_keys($tmp_data[$i]);
							foreach($tmp_keys_dim as $tmp_key_dim) {
								if (array_key_exists($tmp_key_dim, $now_data[$i])) {
									$tmp_data[$i][$tmp_key_dim] = $now_data[$i][$tmp_key_dim];
								}
							}
						}
					} else if ($is_room_facility) {
						for ($i= 0; $i < count($now_data); $i++) {
							$tmp_data[$i] = $skeleton;
							for ($j = 0; $j < count($tmp_data[$i]); $j++) {
								$tmp_keys_dim = array_keys($tmp_data[$i][$j]);
								foreach($tmp_keys_dim as $tmp_key_dim) {
									if (array_key_exists($tmp_key_dim, $now_data[$i])) {
										$tmp_data[$i][$j][$tmp_key_dim] = $now_data[$i][$j][$tmp_key_dim];
									}
								}
							}
						}
					} else {
						for ($i= 0; $i < count($now_data); $i++) {
							$tmp_keys_dim = array_keys($skeleton);
							$tmp_data[$i] = $skeleton;
							foreach($tmp_keys_dim as $tmp_key_dim) {
								if (array_key_exists($tmp_key_dim, $now_data[$i])) {
									$tmp_data[$i][$tmp_key_dim] = $now_data[$i][$tmp_key_dim];
								}
							}
						}
					}
				}
				$packed[$key] = $tmp_data;
			}
		}
	}

	/***
	 * エリアリストボックスが変更された場合にAjaxにより呼ばれ、
	 * 国リストを取得します。
	 */
	function change_area($area_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$countrys = $this->ListGetter->getSelectCountryList($view_iso, $area_id);

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('countrys', $countrys);
	}

	/***
	 * 国リストボックスが変更された場合にAjaxにより呼ばれ、
	 * 州リストを取得します。
	 */
	function change_country($area_id = 0, $country_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$states = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('states', $states);
	}

	/***
	 * 州リストボックスが変更された場合にAjaxにより呼ばれ、
	 * 都市リストを取得します。
	 */
	function change_state($area_id = 0, $country_id = 0, $state_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$citys = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('citys', $citys);
	}


}

?>