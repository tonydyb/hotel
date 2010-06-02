<?php
class HotelController extends AppController {
	var $name = "Hotel";
	var $needAuth = true;	// ログイン必須のフラグ
	var $helpers = array('Construct', 'Javascript', 'Ajax', 'Number', 'Time', );
	var $components = array('ModelUtil', 'ListGetter', 'RequestHandler', 'ImageUpload');
	var $uses = array(
				'Hotel', 'HotelLanguage', 'HotelAgent', 'CountryLanguage', 'StateLanguage', 'CityLanguage',
				'HotelFacilityLanguage', 'ViewLanguage', 'AreaLanguage', 'HotelLinkFacility', 'HotelGradeLanguage',
				'RoomBedLanguage', 'SmokingLanguage', 'MealTypeLanguage', 'BreakfastTypeLanguage', 'CurrencyLanguage',
				'HotelRoom', 'HotelRoomLanguage', 'HotelRoomLinkRoomFacility', 'RoomFacilityLanguage',
				'HotelImage', 'HotelImageLanguage', 'CancelCharge', 'MiscInfoLanguage', 'HotelEmergencyContact',
				'RoomGradeLanguage', 'AreaLinkCountry', 'Condition3', 'Language',
				);

	function change() {
		if (!empty($this->data)) {
			$data = $this->data['Change'];
			$display_stat = $data['display_stat'];
			$hotel_ids = '';
			foreach ($data['checked'] as $chk => $value) {
				if ($value != 0) {
					if (!empty($hotel_ids)) {
						$hotel_ids .= ',';
					}
					$hotel_ids .= $value;
				}
			}
			$sql = sprintf(HOTEL_DISPLAY_STAT_CHANGE_SQL, $hotel_ids);
			$this->Hotel->query($sql, array($display_stat));
		}

		$this->redirect('/hotel/index/');
	}

	function init() {
		$this->Session->delete(HS_SESSION);
		$this->Session->delete(HS_SESSION_BASE);
		$this->redirect('/hotel/index/');
	}

	function index ($base_condition = null) {
		$cnd = null;
		$cnd_db = null;
		if ($this->Session->check(HS_SESSION)) {
			$cnd = $this->Session->read(HS_SESSION);
		} else {
			// 検索データ用スケルトン作成
			$cnd = $this->make_search_skeleton();
			$this->Session->write(HS_SESSION, $cnd);
			$this->Session->write(HS_SESSION_BASE, $cnd);
		}

		if (!is_null($base_condition)) {
			$cnd = $base_condition;
			$this->set('condition3', $this->Session->read(HS_SESSION));
			$this->Session->write(HS_SESSION_BASE, $cnd);
		} else {
			$this->set('condition3', $cnd);
		}
		$cnd_db = $cnd;

		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$view_list = array();
		$this->get_index_view_list($view_iso, $view_list);
		$this->get_place_data($cnd, $view_list, $view_iso);

		$where = $this->make_search_condition3($cnd_db);

		// データを取得する
		$whitelist = array(
						'Hotel.id',
						'AreaLinkCountry.area_id',
						'Hotel.country_id',
						'Hotel.state_id',
						'Hotel.city_id',
						'Hotel.code',
						'count(HotelRoom.id)',
						'Hotel.display_stat',
						'Hotel.created'
					);

		$search_cond = array(
			'conditions' => $where,			// 検索条件
			'fields' => $whitelist,			// 取得するカラム
			'page' => 1,					// 数値,最初に表示するページ。デフォルトは1,'last'(小文字)も可*1
			'limit' => HS_VIEW_MAX,			// 数値：showでも可。デフォルトは20
			'sort' => 'Hotel.id',			// ソートkey：order*2 でもよい。重なった場合はsortが優先される。
			'joins' => array(				// JOIN条件
				array('type' => 'INNER', 'alias' => 'HotelRoom', 'table' => 'hotel_room', 'conditions' => 'Hotel.id = HotelRoom.hotel_id AND Hotel.deleted IS NULL AND HotelRoom.deleted IS NULL'),
				array('type' => 'INNER', 'alias' => 'AreaLinkCountry', 'table' => 'area_link_country', 'conditions' => 'Hotel.country_id = AreaLinkCountry.country_id AND AreaLinkCountry.deleted IS NULL') ,
				),
			'order' => array('Hotel.id' => 'desc'),
			'group' => array(
							'Hotel.id',
							'AreaLinkCountry.area_id',
							'Hotel.country_id',
							'Hotel.state_id',
							'Hotel.city_id',
							'Hotel.code',
							'Hotel.display_stat',
							'Hotel.created'
						),
			'direction' => 'desc'			// asc or desc:デフォルトはasc
			 );
		$this->paginate=$search_cond;
		$hotel_data = $this->paginate('Hotel');

		$attached_data = null;

		$language = $this->Language->find('first', array('conditions' => array('Language.iso_code' => $view_iso, 'Language.deleted is null')));
		$language_id = $language['Language']['id'];

		if (!empty($hotel_data)) {
			$count = 0;
			foreach ($hotel_data as $hd) {
				$hotel_language = $this->HotelLanguage->query(USED_HOTEL_LANGUAGE_SQL,  array($view_iso, $hd['Hotel']['id'], $view_iso, $hd['Hotel']['id']));
				$area_data = $this->AreaLanguage->find('first', array('conditions' => array('AreaLanguage.area_id' => $hd['AreaLinkCountry']['area_id'], 'AreaLanguage.language_id' => $language_id, 'AreaLanguage.deleted is null')));
				$country_data = $this->CountryLanguage->find('first', array('conditions' => array('CountryLanguage.country_id' => $hd['Hotel']['country_id'], 'CountryLanguage.language_id' => $language_id, 'CountryLanguage.deleted is null')));
				$state_data = $this->StateLanguage->find('first', array('conditions' => array('StateLanguage.state_id' => $hd['Hotel']['state_id'], 'StateLanguage.language_id' => $language_id, 'StateLanguage.deleted is null')));
				$city_data = $this->CityLanguage->find('first', array('conditions' => array('CityLanguage.city_id' => $hd['Hotel']['city_id'], 'CityLanguage.language_id' => $language_id, 'CityLanguage.deleted is null')));
				$attached_data[$count] = $hotel_language[0][0];
				$attached_data[$count]['area_name'] = $area_data['AreaLanguage']['name'];
				$attached_data[$count]['country_name'] = $country_data['CountryLanguage']['name_long'];
				$attached_data[$count]['state_name'] = $state_data['StateLanguage']['name'];
				$attached_data[$count]['city_name'] = $city_data['CityLanguage']['name'];
				$count++;
			}
		}

		$view_list['Condition3'] = $cnd;
		$view_list['Hotel'] = $hotel_data;
		$view_list['Attached'] = $attached_data;

		$this->set_view_list_data($view_list);
	}

	function search($page = 1) {
		$base_condition = $this->Session->read(HS_SESSION_BASE);
		if(!empty($this->data)) {
			$this->to_string_post_date($this->data);

			$this->Condition3->set($this->data);
			$this->Session->write(HS_SESSION, $this->data['Condition3']);

			if ($this->Condition3->validates($this->data)) {
				$this->index(null);
				$this->render('/hotel/index/');
			} else {
				$this->index($base_condition);
				$this->render('/hotel/index/');
			}
		}
	}

	function make_search_condition3($cnd) {
		$where = array('1=1');
		// hotel
		if (!empty($cnd['created_from']) && !empty($cnd['created_to'])) {
			$where = array_merge($where, array('Hotel.created BETWEEN ? AND ?' => array(date($cnd['created_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['created_to'])))))));
		} else if (!empty($cnd['created_from'])) {
			$where = array_merge($where, array('Hotel.created >= ?' => array(date($cnd['created_from']))));
		} else if (!empty($cnd['created_to'])) {
			$where = array_merge($where, array('Hotel.created < ?' => array(date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['created_to'])))))));
		}
		// area_link_country
		if (!empty($cnd['area_id'])) {
			$where = array_merge($where, array("AreaLinkCountry.area_id" => $cnd['area_id']));
		}
		// hotel
		if (!empty($cnd['country_id'])) {
			$where = array_merge($where, array("Hotel.country_id" => $cnd['country_id']));
		}
		if (!empty($cnd['state_id'])) {
			$where = array_merge($where, array("Hotel.state_id" => $cnd['state_id']));
		}
		if (!empty($cnd['city_id'])) {
			$where = array_merge($where, array("Hotel.city_id" => $cnd['city_id']));
		}
		if (isset($cnd['display_stat'])) {
			if ($cnd['display_stat'] == DISPLAY_STAT_EXIST || $cnd['display_stat'] == DISPLAY_STAT_NOTEXIST || $cnd['display_stat'] == DISPLAY_STAT_DELETE) {
				$where = array_merge($where, array("Hotel.display_stat" => $cnd['display_stat']));
			}
		}
		// hotel_imageは「あり」exists
		if (isset($cnd['image_exists'])) {
			if ($cnd['image_exists'] == HOTEL_IMAGE_EXISTS) {
				$where = array_merge($where, array("EXISTS (SELECT hotel_image.id FROM hotel_image WHERE hotel_image.hotel_id = hotel.id AND isnull(hotel_image.deleted))"));
			}
		}
		// keywordの条件は複数部分のLIKE
		// keyword
		if (isset($cnd['keyword']) && $cnd['keyword'] != '') {
			$likes = array();
			$likes = array_merge($likes, array("Hotel.code LIKE" => "%" .$cnd['keyword']. "%"));
			$likes = array_merge($likes, array("EXISTS (SELECT hotel_language.id FROM hotel_language WHERE hotel_language.hotel_id = hotel.id AND isnull(hotel_language.deleted) AND hotel_language.name like '%".$cnd['keyword']."%')"));
			$where = array_merge($where, array("OR" => $likes));
		}
		// hotel_agent_id
		if (!empty($cnd['hotel_agent_id'])) {
			$where = array_merge($where, array("EXISTS (SELECT hotel_room.id FROM hotel_room WHERE hotel_room.hotel_id = hotel.id AND isnull(hotel_room.deleted) AND hotel_room.hotel_agent_id = ".$cnd['hotel_agent_id'].")"));
		}

		return array("AND" => $where);
	}

	function to_string_post_date (&$data) {
		$data['Condition3']['created_from'] = $this->isLegalDate($data['Condition3']['created_from']);
		$data['Condition3']['created_to'] = $this->isLegalDate($data['Condition3']['created_to']);
	}

	function make_search_skeleton() {
		$search_skel = array();
		$search_skel['keyword'] = '';
		$search_skel['area_id'] = '';
		$search_skel['country_id'] = '';
		$search_skel['state_id'] = '';
		$search_skel['city_id'] = '';
		$search_skel['display_stat'] = '';
		$search_skel['hotel_agent_id'] = '';
		$search_skel['image_exists'] = '';
		$search_skel['created_from'] = '';
		$search_skel['created_to'] = '';
		return $search_skel;
	}

	function file_upload($hotel_code, &$data) {
		$count = 0;
		$dir = $hotel_code;
		$this->ModelUtil->mkdirRec(HOTEL_IMAGE_ROOT_PATH_ON_MKDIR.$dir);
		$path = HOTEL_IMAGE_ROOT_PATH.$dir;

		// 画像のリサイズ・アップロード
		$upload_file_name = $this->ImageUpload->resize(
			$data['pic']['tmp_name'],	// ソース画像
			$path,						// 画像の保存先
			$data['pic']['name'],		// 保存名
			false						// リサイズするか
		);
//				100,						// リサイズ横幅
//				100,						// リサイズ縦幅
//				true						// 画像横縦比の維持フラグ
//			);
		$data['image_file'] = $data['pic']['name'];
		$data['image_url'] = $dir.SLASH;
	}

	function edit ($hotel_id = null, $language_id = null) {
		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$view_list = array();

		$this->get_edit_view_list($view_iso, $view_list);

		$hotel = null;
		$hotel_language = null;
		$hotel_link_facility = null;
		$hotel_room = null;
		$hotel_room_language = null;
		$room_link_facility = null;
		$hotel_image = null;
		$hotel_image_language = null;
		$cancel_charge = null;
		$hotel_emergency_contact = null;
		$country = array();
		$state = array();
		$city = array();

		$is_room_skeleton = false;
		$is_image_skeleton = false;
		$is_charge_skeleton = false;
		$is_contact_skeleton = false;
		if (is_null($hotel_id)) {
			// 新規作成
			$hotel = $this->get_hotel_skeleton();
			$hotel_language = $this->get_hotel_language_skeleton();
			$hotel_link_facility = $this->get_hotel_link_facility_skeleton();
			$hotel_room[] = $this->get_hotel_room_skeleton();
			$hotel_room_language[] = $this->get_hotel_room_language_skeleton();
			$room_link_facility[] = $this->get_hotel_room_link_room_facility_skeleton();
			$hotel_image[] = $this->get_hotel_image_skeleton();
			$hotel_image_language[] = $this->get_hotel_image_language_skeleton();
			$cancel_charge[] = $this->get_cancel_charge_skeleton();
			$hotel_emergency_contact[] = $this->get_hotel_emergency_contact_skeleton();
		} else {
			// 編集
			$hotel = $this->Hotel->find('first', array('conditions' => array('Hotel.id' => $hotel_id, 'Hotel.deleted is null')));
			if (is_null($language_id)) {
				$hotel_language = $this->HotelLanguage->query(USED_HOTEL_LANGUAGE_SQL, array($view_iso, $hotel_id, $view_iso, $hotel_id));
				$hotel_language = $hotel_language[0][0];
			} else {
				$hotel_language = $this->HotelLanguage->find('first', array('conditions' => array('HotelLanguage.hotel_id' => $hotel_id, 'HotelLanguage.language_id' => $language_id, 'HotelLanguage.deleted is null')));
				$hotel_language = $hotel_language['HotelLanguage'];
			}
			$language_id = is_null($language_id) ? $hotel_language['language_id'] : $language_id;
			$hotel_link_facility = $this->ListGetter->getHotelLinkFacilityList($view_iso, $hotel_id);
			if (empty($hotel_link_facility)) {
				$hotel_link_facility = $this->get_hotel_link_facility_skeleton();
			}
			$hotel_room = $this->HotelRoom->find('all', array('conditions' => array('HotelRoom.hotel_id' => $hotel_id, 'HotelRoom.deleted is null'), 'order' => array('HotelRoom.id')));
			if (empty($hotel_room)) {
				$is_room_skeleton = true;
				$hotel_room[] = $this->get_hotel_room_skeleton();
				$hotel_room_language[] = $this->get_hotel_room_language_skeleton();
				$room_link_facility[] = $this->get_hotel_room_link_room_facility_skeleton();
			} else {
				$room_ids = '';
				$room_link_facility = array();
				foreach ($hotel_room as $room) {
					if (!empty($room_ids)) {
						$room_ids .= ',';
					}
					$room_ids .= $room['HotelRoom']['id'];
					$room_link_facility[] = $this->ListGetter->getRoomLinkFacilityList($view_iso, $room['HotelRoom']['id']);
				}
				$hotel_room_language = $this->HotelRoomLanguage->find('all', array('conditions' => array('HotelRoomLanguage.hotel_room_id in ('.$room_ids.')', 'HotelRoomLanguage.language_id' => $language_id, 'HotelRoomLanguage.deleted is null'), 'order' => array('HotelRoomLanguage.hotel_room_id')));
			}
			$hotel_image = $this->HotelImage->find('all', array('conditions' => array('HotelImage.hotel_id' => $hotel_id, 'HotelImage.deleted is null'), 'order' => array('HotelImage.id')));
			if (empty($hotel_image)) {
				$is_image_skeleton = true;
				$hotel_image[] = $this->get_hotel_image_skeleton();
				$hotel_image_language[] = $this->get_hotel_image_language_skeleton();
			} else {
				$image_ids = '';
				foreach ($hotel_image as $image) {
					if (!empty($image_ids)) {
						$image_ids .= ',';
					}
					$image_ids .= $image['HotelImage']['id'];
				}
				$hotel_image_language = $this->HotelImageLanguage->find('all', array('conditions' => array('HotelImageLanguage.hotel_image_id in ('.$image_ids.')', 'HotelImageLanguage.language_id' => $language_id, 'HotelImageLanguage.deleted is null'), 'order' => array('HotelImageLanguage.hotel_image_id')));
			}
			$cancel_charge = $this->CancelCharge->find('all', array('conditions' => array('CancelCharge.hotel_id' => $hotel_id, 'CancelCharge.deleted is null'), 'order' => array('CancelCharge.id')));
			if (empty($cancel_charge)) {
				$is_charge_skeleton = true;
				$cancel_charge[] = $this->get_cancel_charge_skeleton();
			}
			$hotel_emergency_contact = $this->HotelEmergencyContact->find('all', array('conditions' => array('HotelEmergencyContact.hotel_id' => $hotel_id, 'HotelEmergencyContact.deleted is null'), 'order' => array('HotelEmergencyContact.id')));
			if (empty($hotel_emergency_contact)) {
				$is_contact_skeleton = true;
				$hotel_emergency_contact[] = $this->get_hotel_emergency_contact_skeleton();
			}

			// 取得データを成形して使用できるように変更
			$hotel = $hotel['Hotel'];
			$area_link_country = $this->AreaLinkCountry->find('first', array('conditions' => array('AreaLinkCountry.country_id' => $hotel['country_id'], 'AreaLinkCountry.deleted is null')));
			$hotel['area_id'] = $area_link_country['AreaLinkCountry']['area_id'];
			if (!empty($hotel['checkin'])) {
				$tmp_time = explode(':', $hotel['checkin']);
				$hotel['checkin'] = array('hour'=>$tmp_time[0], 'min'=>$tmp_time[1]);
			} else {
				$hotel['checkin'] = array('hour'=>'', 'min'=>'');
			}
			if (!empty($hotel['checkout'])) {
				$tmp_time = explode(':', $hotel['checkout']);
				$hotel['checkout'] = array('hour'=>$tmp_time[0], 'min'=>$tmp_time[1]);
			} else {
				$hotel['checkout'] = array('hour'=>'', 'min'=>'');
			}
			if (empty($hotel_language)) {
				$hotel_language = $this->get_hotel_language_skeleton();
				$hotel_language['language_id'] = $language_id;
			}
//			$hotel_link_facility = $hotel_link_facility;
			if (!$is_room_skeleton) {
				$tmp_data = array();
				$tmp_data_lang = array();
				for ($i = 0; $i < count($hotel_room); $i++) {
					$tmp_data[$i] = $hotel_room[$i]['HotelRoom'];
					$tmp_data[$i]['delete'] = '0';
					if (array_key_exists($i, $hotel_room_language)) {
						$tmp_data_lang[$i] = $hotel_room_language[$i]['HotelRoomLanguage'];
					} else {
						$tmp_data_lang[$i] = $this->get_hotel_room_language_skeleton();
					}
				}
				$hotel_room = $tmp_data;
				$hotel_room_language = $tmp_data_lang;
			}
//			$room_link_facility = $room_link_facility;
			if (!$is_image_skeleton) {
				$tmp_data = array();
				$tmp_data_lang = array();
				for ($i = 0; $i < count($hotel_image); $i++) {
					$tmp_data[$i] = $hotel_image[$i]['HotelImage'];
					$tmp_data[$i]['pic'] = null;
					$tmp_data[$i]['delete'] = '0';
					if (array_key_exists($i, $hotel_image_language)) {
						$tmp_data_lang[$i] = $hotel_image_language[$i]['HotelImageLanguage'];
					} else {
						$tmp_data_lang[$i] = $this->get_hotel_image_language_skeleton();
					}
				}
				$hotel_image = $tmp_data;
				$hotel_image_language = $tmp_data_lang;
			}
			if (!$is_charge_skeleton) {
				$tmp_data = array();
				for ($i = 0; $i < count($cancel_charge); $i++) {
					$tmp_data[$i] = $cancel_charge[$i]['CancelCharge'];
					$tmp_data[$i]['delete'] = '0';
				}
				$cancel_charge = $tmp_data;
			}
			if (!$is_contact_skeleton) {
				$tmp_data = array();
				for ($i = 0; $i < count($hotel_emergency_contact); $i++) {
					$tmp_data[$i] = $hotel_emergency_contact[$i]['HotelEmergencyContact'];
					$tmp_data[$i]['delete'] = '0';
				}
				$hotel_emergency_contact = $tmp_data;
			}
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

	function save () {
		$isSaved = false;
		$db_errors = null;
		if (!empty($this->data)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$repacked_data = array();
			$this->repacked_post_data($this->data, $repacked_data);
			$save_data = array();
			$this->make_save_data($repacked_data, $save_data);

			// バリデーション
			$errors = array();
			$is_error = $this->beforehand_validate($save_data, $errors);

			if (!$is_error) {
				$db_errors = $this->save_data($save_data);
				if (is_null($db_errors)) {
					$isSaved = true;
				} else {
					if (is_array($db_errors)) {
						if (array_key_exists('hotel', $db_errors)) {
							$this->Hotel->validationErrors = $db_errors['hotel'];
						}
						if (array_key_exists('hotel_language', $db_errors)) {
							$this->HotelLanguage->validationErrors = $db_errors['hotel_language'];
						}
						if (array_key_exists('hotel_link_facility', $db_errors)) {
							$this->HotelLinkFacility->validationErrors = $db_errors['hotel_link_facility'];
						}
						if (array_key_exists('hotel_room', $db_errors)) {
							$this->HotelRoom->validationErrors = $db_errors['hotel_room'];
						}
						if (array_key_exists('hotel_room_language', $db_errors)) {
							$this->HotelRoomLanguage->validationErrors = $db_errors['hotel_room_language'];
						}
						if (array_key_exists('hotel_room_link_room_facility', $db_errors)) {
							$this->HotelRoomLinkRoomFacility->validationErrors = $db_errors['hotel_room_link_room_facility'];
						}
						if (array_key_exists('hotel_image', $db_errors)) {
							$this->HotelImage->validationErrors = $db_errors['hotel_image'];
						}
						if (array_key_exists('hotel_image_language', $db_errors)) {
							$this->HotelImageLanguage->validationErrors = $db_errors['hotel_image_language'];
						}
						if (array_key_exists('cancel_charge', $db_errors)) {
							$this->CancelCharge->validationErrors = $db_errors['cancel_charge'];
						}
						if (array_key_exists('hotel_emergency_contact', $db_errors)) {
							$this->HotelEmergencyContact->validationErrors = $db_errors['hotel_emergency_contact'];
						}
					}
				}
			}
		}

		if ($isSaved) {
			$this->redirect('/hotel/index/');
		} else {

			$this->get_edit_view_list($view_iso, $repacked_data);

			$this->get_place_data($repacked_data['Hotel'], $repacked_data, $view_iso);
			$this->get_contact_place_data($repacked_data, $view_iso);
			$repacked_data['default_iso_code'] = $view_iso;

			$this->set_view_list_data($repacked_data);
			$this->render('/hotel/edit/');
		}
	}

	function save_data(&$save_data) {
		$hotel_id = null;
		$hotel_room_id = null;
		$hotel_image_id = null;
		$is_break = false;
		$errors = array();

		$hotel_data = array_key_exists('hotel', $save_data) ? $save_data['hotel'] : null;
		$hotel_language_data = array_key_exists('hotel_language', $save_data) ? $save_data['hotel_language'] : null;
		$hotel_link_facility_data = array_key_exists('hotel_link_facility', $save_data) ? $save_data['hotel_link_facility'] : array();
		$hotel_room_data = array_key_exists('hotel_room', $save_data) ? $save_data['hotel_room'] : array();
		$hotel_room_language_data = array_key_exists('hotel_room_language', $save_data) ? $save_data['hotel_room_language'] : array();
		$hotel_room_link_room_facility_data = array_key_exists('hotel_room_link_room_facility', $save_data) ? $save_data['hotel_room_link_room_facility'] : array();
		$hotel_image_data = array_key_exists('hotel_image', $save_data) ? $save_data['hotel_image'] : array();
		$hotel_image_language_data = array_key_exists('hotel_image_language', $save_data) ? $save_data['hotel_image_language'] : array();
		$cancel_charge_data = array_key_exists('cancel_charge', $save_data) ? $save_data['cancel_charge'] : array();
		$hotel_emergency_contact_data = array_key_exists('cancel_charge', $save_data) ? $save_data['hotel_emergency_contact'] : array();

		$this->Hotel->begin();

		// Hotelの保存
		$this->Hotel->create();
		$this->Hotel->set($hotel_data);
		$whitelist = $this->remove_not_save_column(array_keys($this->Hotel->getColumnTypes()));
		if ($this->Hotel->save($hotel_data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
			if (empty($hotel_data['id'])) {
				$hotel_id = $this->Hotel->getLastInsertID();
			} else {
				$hotel_id = $hotel_data['id'];
			}

			// HotelLanguageの保存
			$hotel_language_data['hotel_id'] = $hotel_id;
			$this->HotelLanguage->create();
			$this->HotelLanguage->set($hotel_language_data);
			$whitelist = array_keys($this->HotelLanguage->getColumnTypes());
			if (!$this->HotelLanguage->save($hotel_language_data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$is_break;
				$errors['hotel_language'] = $this->HotelLanguage->validationErrors;
			}

			// HotelLinkFacilityの保存
			$whitelist = $this->remove_not_save_column(array_keys($this->HotelLinkFacility->getColumnTypes()));
			$hlf_count = 0;
			foreach ($hotel_link_facility_data as $hlfd) {
				$hlfd['hotel_id'] = $hotel_id;
				$this->HotelLinkFacility->create();
				$this->HotelLinkFacility->set($hlfd);
				if (!$this->HotelLinkFacility->save($hlfd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break;
					$errors['hotel_link_facility'][$hlf_count] = $this->HotelLinkFacility->validationErrors;
				}
				$hlf_count++;
			}

			// HotelRoomの保存
			$whitelist = $this->remove_not_save_column(array_keys($this->HotelRoom->getColumnTypes()));
			$whitelist_hrl = $this->remove_not_save_column(array_keys($this->HotelRoomLanguage->getColumnTypes()));
			$whitelist_hrlrf = $this->remove_not_save_column(array_keys($this->HotelRoomLinkRoomFacility->getColumnTypes()));
			$hr_count = 0;
			foreach ($hotel_room_data as $hrd) {
				$hrd['hotel_id'] = $hotel_id;
				$this->HotelRoom->create();
				$this->HotelRoom->set($hrd);
				if ($this->HotelRoom->save($hrd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					if (empty($hotel_data['id'])) {
						$hotel_room_id = $this->HotelRoom->getLastInsertID();
					} else {
						$hotel_room_id = $hrd['id'];
					}

					// HotelRoomLanguageの保存
					$hotel_room_language_data[$hr_count]['hotel_room_id'] =$hotel_room_id;
					$this->HotelRoomLanguage->create();
					$this->HotelRoomLanguage->set($hotel_room_language_data[$hr_count]);
					if (!$this->HotelRoomLanguage->save($hotel_room_language_data[$hr_count], array('validate' => true, 'fieldList' => $whitelist_hrl, 'callbacks' => true))) {
						$is_break;
						$errors['hotel_room_language'][$hr_count] = $this->HotelRoomLanguage->validationErrors;
					}

					// HotelRoomLinkRoomFacilityの保存
					$hrlrf_count = 0;
					if (!empty($hotel_room_link_room_facility_data) && is_array($hotel_room_link_room_facility_data[$hr_count])) {
						foreach ($hotel_room_link_room_facility_data[$hr_count] as $hrlrf) {
							$hrlrf['hotel_room_id'] = $hotel_room_id;
							$this->HotelRoomLinkRoomFacility->create();
							$this->HotelRoomLinkRoomFacility->set($hrlrf);
							if (!$this->HotelRoomLinkRoomFacility->save($hrlrf, array('validate' => true, 'fieldList' => $whitelist_hrlrf, 'callbacks' => true))) {
								$is_break;
								$errors['hotel_room_link_room_facility'][$hr_count][$hrlrf_count] = $this->HotelRoomLinkRoomFacility->validationErrors;
							}
							$hrlrf_count++;
						}
					}
				} else {
					$is_break;
					$errors['hotel_room'][$hr_count] = $this->HotelRoom->validationErrors;
				}
				$hr_count++;
			}

			// HotelImageの保存
			$whitelist = $this->remove_not_save_column(array_keys($this->HotelImage->getColumnTypes()));
			$whitelist_hil = $this->remove_not_save_column(array_keys($this->HotelImageLanguage->getColumnTypes()));
			$hi_count = 0;
			foreach ($hotel_image_data as $hid) {
				$hid['hotel_id'] = $hotel_id;
				$this->HotelImage->create();
				$this->HotelImage->set($hid);
				if ($this->HotelImage->save($hid, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					if (empty($hid['id'])) {
						$hotel_image_id = $this->HotelImage->getLastInsertID();
					} else {
						$hotel_image_id = $hid['id'];
					}

					// HotelImageLanguageの保存
					$hotel_image_language_data[$hi_count]['hotel_image_id'] =$hotel_image_id;
					$this->HotelImageLanguage->create();
					$this->HotelImageLanguage->set($hotel_image_language_data[$hi_count]);
					if (!$this->HotelImageLanguage->save($hotel_image_language_data[$hi_count], array('validate' => true, 'fieldList' => $whitelist_hil, 'callbacks' => true))) {
						$is_break;
						$errors['hotel_room_language'][$hi_count] = $this->HotelImageLanguage->validationErrors;
					}
				} else {
					$is_break;
					$errors['hotel_image'][$hi_count] = $this->HotelImage->validationErrors;
				}
				$hi_count++;
			}

			// CancelChargeの保存
			$whitelist = $this->remove_not_save_column(array_keys($this->CancelCharge->getColumnTypes()));
			$cc_count = 0;
			foreach ($cancel_charge_data as $ccd) {
				$ccd['hotel_id'] = $hotel_id;
				$this->CancelCharge->create();
				$this->CancelCharge->set($ccd);
				if (!$this->CancelCharge->save($ccd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break;
					$errors['cancel_charge'][$cc_count] = $this->CancelCharge->validationErrors;
				}
				$cc_count++;
			}

			// CancelChargeの保存
			$whitelist = $this->remove_not_save_column(array_keys($this->HotelEmergencyContact->getColumnTypes()));
			$hec_count = 0;
			foreach ($hotel_emergency_contact_data as $hecd) {
				$hecd['hotel_id'] = $hotel_id;
				$this->HotelEmergencyContact->create();
				$this->HotelEmergencyContact->set($hecd);
				if (!$this->HotelEmergencyContact->save($hecd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break;
					$errors['cancel_charge'][$cc_count] = $this->HotelEmergencyContact->validationErrors;
				}
				$cc_count++;
			}
		} else {
			$is_break;
			$errors['hotel'] = $this->Hotel->validationErrors;
		}

		if (!$is_break) {
			$this->Hotel->commit();
			$errors = null;
		} else {
			$this->Hotel->rollback();
		}

		return $errors;
	}

	function beforehand_validate(&$save_data, &$errors) {
		$errors = array();
		$keys = array_keys($save_data);
		$result = false;
		foreach ($keys as $key) {
			$data = $save_data[$key];
			$model = '';
			$loop = 0;
			if ($key == 'hotel') {
				$model = $this->Hotel;
			} else if ($key == 'hotel_language') {
				$model = $this->HotelLanguage;
			} else if ($key == 'hotel_link_facility') {
				$model = $this->HotelLinkFacility;
				$loop = 1;
			} else if ($key == 'hotel_room') {
				$model = $this->HotelRoom;
				$loop = 1;
			} else if ($key == 'hotel_room_language') {
				$model = $this->HotelRoomLanguage;
				$loop = 1;
			} else if ($key == 'hotel_room_link_room_facility') {
				$model = $this->HotelRoomLinkRoomFacility;
				$loop = 2;
			} else if ($key == 'hotel_image') {
				$model = $this->HotelImage;
				$loop = 1;
			} else if ($key == 'hotel_image_language') {
				$model = $this->HotelImageLanguage;
				$loop = 1;
			} else if ($key == 'cancel_charge') {
				$model = $this->CancelCharge;
				$loop = 1;
			} else if ($key == 'hotel_emergency_contact') {
				$model = $this->HotelEmergencyContact;
				$loop = 1;
			}

			$model->create();

			if ($loop === 1) {
				$loop_keys = array_keys($data);
				foreach ($loop_keys as $loop_key) {
					$model->set($data[$loop_key]);
					$is_error = !$model->validates($data[$loop_key]);
					$result = $is_error || $result;
					$errors[$key][$loop_key] = $model->validationErrors;
				}
			} else if ($loop === 2) {
				$loop_keys = array_keys($data);
				foreach ($loop_keys as $loop_key) {
					$looop_keys = array_keys($data[$loop_key]);
					foreach ($looop_keys as $looop_key) {
						$model->set($data[$loop_key][$looop_key]);
						$is_error = !$model->validates($data[$loop_key][$looop_key]);
						$result = $is_error || $result;
						$errors[$key][$loop_key][$looop_key] = $model->validationErrors;
					}
				}
			} else {
				$model->set($data);
				$is_error = !$model->validates($data);
				$result = $is_error || $result;
				$errors[$key] = $model->validationErrors;
			}
			$model->validationErrors = $errors[$key];
		}
		return $result;
	}

	function make_save_data($data, &$save) {
		$keys = array_keys($data);
		$language_id = $data['HotelLanguage']['language_id'];

		foreach ($keys as $key) {
			if ($key == 'Hotel') {
				$save['hotel'] = $data['Hotel'];
				if ($data['Hotel']['checkin']['hour'] != '' && $data['Hotel']['checkin']['min'] != '') {
					$save['hotel']['checkin'] = date('H:i',mktime($data['Hotel']['checkin']['hour'], $data['Hotel']['checkin']['min'], 0, 0, 0, 0));
				} else if ($data['Hotel']['checkin']['hour'] != '' || $data['Hotel']['checkin']['min'] != '') {
					$save['hotel']['checkin'] = 'error';
				} else {
					$save['hotel']['checkin'] = '';
				}
				if ($data['Hotel']['checkout']['hour'] != '' && $data['Hotel']['checkout']['min'] != '') {
					$save['hotel']['checkout'] = date('H:i',mktime($data['Hotel']['checkout']['hour'], $data['Hotel']['checkout']['min'], 0, 0, 0, 0));
				} else if ($data['Hotel']['checkout']['hour'] != '' || $data['Hotel']['checkout']['min'] != '') {
					$save['hotel']['checkout'] = 'error';
				} else {
					$save['hotel']['checkout'] = '';
				}
				$save['hotel']['hotel_grade_id'] = empty($save['hotel']['hotel_grade_id']) ? 0 : $save['hotel']['hotel_grade_id'];
				$save['hotel']['town_id'] = empty($save['hotel']['town_id']) ? 0 : $save['hotel']['town_id'];
				$save['hotel']['total_room_number'] = empty($save['hotel']['total_room_number']) ? 0 : $save['hotel']['total_room_number'];
				$save['hotel']['deleted'] = null;
			} else if ($key == 'HotelLanguage') {
				$save['hotel_language'] = $data['HotelLanguage'];
				$save['hotel_language']['hotel_id'] = $data['Hotel']['id'];
				$save['hotel_language']['deleted'] = null;
			} else if ($key == 'HotelLinkFacility') {
				$count = 0;
				foreach ($data['HotelLinkFacility'] as $facility) {
					if ($facility['hotel_link_facility']['hotel_facility_id'] != 0) {
						$save['hotel_link_facility'][$count] = $facility['hotel_link_facility'];
						$save['hotel_link_facility'][$count]['deleted'] = null;
					} else if ($facility['hotel_link_facility']['hotel_facility_id'] == 0 && !empty($facility['hotel_link_facility']['id'])) {
						$save['hotel_link_facility'][$count] = $facility['hotel_link_facility'];
						$save['hotel_link_facility'][$count]['deleted'] = date('Y-m-d H:i:s');
					}
					$count++;
				}
			} else if ($key == 'HotelRoom') {
//			} else if ($key == 'HotelRoomLanguage') {
//			} else if ($key == 'HotelRoomLinkRoomFacility') {
				for ($count = 0; $count < count($data['HotelRoom']); $count++) {
					if ($data['HotelRoom'][$count]['delete'] == DELETE_FLAG_NOT_DELETE && !empty($data['HotelRoomLanguage'][$count]['name'])) {
						$save['hotel_room'][$count] = $data['HotelRoom'][$count];
						$save['hotel_room_language'][$count] = $data['HotelRoomLanguage'][$count];
						$save['hotel_room'][$count]['deleted'] = null;
						$save['hotel_room_language'][$count]['deleted'] = null;
						$save['hotel_room_language'][$count]['language_id'] = $language_id;
						$save['hotel_room_language'][$count]['hotel_room_id'] = $data['HotelRoom'][$count]['id'];
						$save['hotel_room'][$count]['room_grade_id'] = empty($save['hotel_room'][$count]['room_grade_id']) ? 0 : $save['hotel_room'][$count]['room_grade_id'];
						$save['hotel_room'][$count]['price'] = empty($save['hotel_room'][$count]['price']) ? 0 : $save['hotel_room'][$count]['price'];
						$save['hotel_room'][$count]['point'] = empty($save['hotel_room'][$count]['point']) ? 0 : $save['hotel_room'][$count]['point'];
						$save['hotel_room'][$count]['commission'] = empty($save['hotel_room']['commission']) ? 0 : $save['hotel_room'][$count]['commission'];
						for ($i = 0; $i < count($data['HotelRoomLinkRoomFacility'][$count]); $i++) {
							if ($data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility']['room_facility_id'] != 0) {
								$save['hotel_room_link_room_facility'][$count][$i] = $data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility'];
								$save['hotel_room_link_room_facility'][$count][$i]['deleted'] = null;
							} else if ($data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility']['room_facility_id'] == 0 && !empty($data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility']['id'])) {
								$save['hotel_room_link_room_facility'][$count][$i] = $data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility'];
								$save['hotel_room_link_room_facility'][$count][$i]['deleted'] = date('Y-m-d H:i:s');
							}
						}
					} else if ($data['HotelRoom'][$count]['delete'] == DELETE_FLAG_DELETE  && !empty($data['HotelRoom'][$count]['id'])) {
						$save['hotel_room'][$count] = $data['HotelRoom'][$count];
						$save['hotel_room_language'][$count] = $data['HotelRoomLanguage'][$count];
						$save['hotel_room'][$count]['deleted'] = date('Y-m-d H:i:s');
						$save['hotel_room_language'][$count]['deleted'] = date('Y-m-d H:i:s');
						$save['hotel_room_language'][$count]['language_id'] = $language_id;
						$save['hotel_room_language'][$count]['hotel_room_id'] = $data['HotelRoom'][$count]['id'];
						for ($i = 0; $i < count($data['HotelRoomLinkRoomFacility'][$count]); $i++) {
							if (!empty($data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility']['id'])) {
								$save['hotel_room_link_room_facility'][$count][$i] = $data['HotelRoomLinkRoomFacility'][$count][$i]['room_link_facility'];
								$save['hotel_room_link_room_facility'][$count][$i]['deleted'] = date('Y-m-d H:i:s');
							}
						}
					}
				}
			} else if ($key == 'HotelImage') {
//			} else if ($key == 'HotelImageLanguage') {
				for ($count = 0; $count < count($data['HotelImage']); $count++) {
					if ($data['HotelImage'][$count]['delete'] == DELETE_FLAG_NOT_DELETE && !empty($data['HotelImage'][$count]['pic']['name'])) {
						$save['hotel_image'][$count] = $data['HotelImage'][$count];
						$save['hotel_image_language'][$count] = $data['HotelImageLanguage'][$count];
						$save['hotel_image'][$count]['deleted'] = null;
						$save['hotel_image_language'][$count]['deleted'] = null;
						$save['hotel_image_language'][$count]['language_id'] = $language_id;
						$save['hotel_image_language'][$count]['hotel_image_id'] = $data['HotelImage'][$count]['id'];
						$this->file_upload($data['Hotel']['id'], $save['hotel_image'][$count]);
					} else if ($data['HotelImage'][$count]['delete'] == DELETE_FLAG_NOT_DELETE && !empty($data['HotelImage'][$count]['id']) && !empty($data['HotelImageLanguage'][$count]['name'])) {
						$save['hotel_image'][$count] = $data['HotelImage'][$count];
						$save['hotel_image_language'][$count] = $data['HotelImageLanguage'][$count];
						$save['hotel_image'][$count]['deleted'] = null;
						$save['hotel_image_language'][$count]['deleted'] = null;
						$save['hotel_image_language'][$count]['language_id'] = $language_id;
						$save['hotel_image_language'][$count]['hotel_image_id'] = $data['HotelImage'][$count]['id'];
					} else if ($data['HotelImage'][$count]['delete'] == DELETE_FLAG_DELETE && !empty($data['HotelRoom'][$count]['id'])) {
						$save['hotel_image'][$count] = $data['HotelImage'][$count];
						$save['hotel_image_language'][$count] = $data['HotelImageLanguage'][$count];
						$save['hotel_image'][$count]['deleted'] = date('Y-m-d H:i:s');
						$save['hotel_image_language'][$count]['deleted'] = date('Y-m-d H:i:s');
						$save['hotel_image_language'][$count]['language_id'] = $language_id;
						$save['hotel_image_language'][$count]['hotel_image_id'] = $data['HotelImage'][$count]['id'];
					}
				}
			} else if ($key == 'CancelCharge') {
				for ($count = 0; $count < count($data['CancelCharge']); $count++) {
					if ($data['CancelCharge'][$count]['delete'] == DELETE_FLAG_NOT_DELETE &&
						(!is_null($this->isLegalDate($data['CancelCharge'][$count]['term_from'])) ||
						!is_null($this->isLegalDate($data['CancelCharge'][$count]['term_to'])) ||
						!empty($data['CancelCharge'][$count]['charge_occur_from']) ||
						!empty($data['CancelCharge'][$count]['charge_occur_to']) ||
						!empty($data['CancelCharge'][$count]['charge_percent']))) {

						$save['cancel_charge'][$count] = $data['CancelCharge'][$count];
						$save['cancel_charge'][$count]['term_from'] = $this->isLegalDate($data['CancelCharge'][$count]['term_from']);
						$save['cancel_charge'][$count]['term_to'] = $this->isLegalDate($data['CancelCharge'][$count]['term_to']);
						$save['cancel_charge'][$count]['deleted'] = null;
					} else if ($data['CancelCharge'][$count]['delete'] == DELETE_FLAG_DELETE  && !empty($data['CancelCharge'][$count]['id'])) {
						$save['cancel_charge'][$count] = $data['CancelCharge'][$count];
						$save['cancel_charge'][$count]['term_from'] = $this->isLegalDate($data['CancelCharge'][$count]['term_from']);
						$save['cancel_charge'][$count]['term_to'] = $this->isLegalDate($data['CancelCharge'][$count]['term_to']);
						$save['cancel_charge'][$count]['deleted'] = date('Y-m-d H:i:s');
					}
				}
			} else if ($key == 'HotelEmergencyContact') {
				for ($count = 0; $count < count($data['HotelEmergencyContact']); $count++) {
					if ($data['HotelEmergencyContact'][$count]['delete'] == DELETE_FLAG_NOT_DELETE && (!empty($data['HotelEmergencyContact'][$count]['name']) || !empty($data['HotelEmergencyContact'][$count]['tel']))) {
						$save['hotel_emergency_contact'][$count] = $data['HotelEmergencyContact'][$count];
						$save['hotel_emergency_contact'][$count]['deleted'] = null;
					} else if ($data['HotelEmergencyContact'][$count]['delete'] == DELETE_FLAG_DELETE  && !empty($data['HotelEmergencyContact'][$count]['id'])) {
						$save['hotel_emergency_contact'][$count] = $data['HotelEmergencyContact'][$count];
						$save['hotel_emergency_contact'][$count]['deleted'] = date('Y-m-d H:i:s');
					}
				}
			}
		}
	}

	function remove_not_save_column(&$witelist) {
		unset($witelist['updated']);
		unset($witelist['created']);
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
		$this->get_index_view_list($view_iso, $view_list);
		$view_list['hotel_facility'] = $this->ListGetter->getHotelFacilityList($view_iso);
		$view_list['language'] = $this->ListGetter->getLanguageList($view_iso);
		$view_list['hotel_grade'] = $this->ListGetter->getHotelGradeList($view_iso);
		$view_list['room_bed'] = $this->ListGetter->getRoomBedList($view_iso);
		$view_list['smoking'] = $this->ListGetter->getSmokingList($view_iso);
		$view_list['meal_type'] = $this->ListGetter->getMealTypeList($view_iso);
		$view_list['breakfast_type'] = $this->ListGetter->getBreakfastTypeList($view_iso);
		$view_list['currency'] = $this->ListGetter->getCurrencyList($view_iso);
		$view_list['cancel_charge_const'] = $this->ListGetter->getMiscInfoList($view_iso, 'cancel_charge_const');
		$view_list['room_grade'] = $this->ListGetter->getRoomGradeList($view_iso);
	}

	function get_index_view_list($view_iso = null, &$view_list = array()) {
		if (is_null($view_iso)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}
		$area = $this->ListGetter->getAreaList($view_iso);
		array_unshift($area, array('al'=>array('area_id'=>'0','name'=>'')));
		$view_list['area'] = $area;
		$view_list['hotel_agent'] = $this->ListGetter->getHotelAgentList();
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
		$hotel_image_skel['pic'] = null;
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

	function get_hotel_link_facility_skeleton() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		return $this->ListGetter->getHotelLinkFacilityList($view_iso, -1);
	}

	function get_hotel_room_link_room_facility_skeleton() {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		return $this->ListGetter->getRoomLinkFacilityList($view_iso, -1);
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
			array_unshift($countrys, array('cl'=>array('country_id'=>'0','name_long'=>'')));
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
		$this->_reload('add_room', $this->data);
	}

	function add_pic() {
		$this->_reload('add_pic', $this->data);
	}

	function add_cancel() {
		$this->_reload('add_cancel', $this->data);
	}

	function add_contact() {
		$this->_reload('add_contact', $this->data);
	}

	function change_language() {
		$this->_reload('change_language', $this->data);
	}

	function _reload($pattern, $post) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		$repacked_data = array();
		$this->repacked_post_data($post, $repacked_data);


		if ($pattern == 'add_room') {
			if ($post['AddData']['add_room'] != 0) {
				for ($i = 0; $i < $post['AddData']['add_room']; $i++) {
					$repacked_data['HotelRoom'][] = $this->get_hotel_room_skeleton();
					$repacked_data['HotelRoomLanguage'][] = $this->get_hotel_room_language_skeleton();
					$repacked_data['HotelRoomLinkRoomFacility'][] = $this->get_hotel_room_link_room_facility_skeleton();
				}
			}
		} else if ($pattern == 'add_pic') {
			if ($post['AddData']['add_pic'] != 0) {
				for ($i = 0; $i < $post['AddData']['add_pic']; $i++) {
					$repacked_data['HotelImage'][] = $this->get_hotel_image_skeleton();
					$repacked_data['HotelImageLanguage'][] = $this->get_hotel_image_language_skeleton();
				}
			}
		} else if ($pattern == 'add_cancel') {
			if ($post['AddData']['add_cancel'] != 0) {
				for ($i = 0; $i < $post['AddData']['add_cancel']; $i++) {
					$repacked_data['CancelCharge'][] = $this->get_cancel_charge_skeleton();
				}
			}
		} else if ($pattern == 'add_contact') {
			$repacked_data['HotelEmergencyContact'][] = $this->get_hotel_emergency_contact_skeleton();
		} else if ($pattern == 'change_language') {
			if (!empty($repacked_data['Hotel']['id'])) {
				$this->redirect('/hotel/edit/'.$repacked_data['Hotel']['id'].'/'.$repacked_data['HotelLanguage']['language_id'].'/');
//				$hotel_language = $this->HotelLanguage->find('first', array('conditions' => array('HotelLanguage.hotel_id' => $repacked_data['Hotel']['id'], 'HotelLanguage.language_id' => $repacked_data['HotelLanguage']['language_id'], 'HotelLanguage.deleted is null')));
//				if ($hotel_language['HotelLanguage']['language_id'] == $repacked_data['HotelLanguage']['language_id']) {
//					$this->redirect('/hotel/edit/'.$repacked_data['Hotel']['id'].'/'.$repacked_data['HotelLanguage']['language_id'].'/');
//				} else {
//					$repacked_data['HotelLanguage']['id'] = null;
//
//					for ($i = 0; $i < count($repacked_data['HotelRoomLanguage']); $i++) {
//						$repacked_data['HotelRoomLanguage'][$i]['id'] = null;
//					}
//					for ($i = 0; $i < count($repacked_data['HotelImageLanguage']); $i++) {
//						$repacked_data['HotelImageLanguage'][$i]['id'] = null;
//					}
//				}
			}
		}

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
				$skeleton =  $this->get_hotel_link_facility_skeleton();
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
				$skeleton = $this->get_hotel_room_link_room_facility_skeleton();
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
						$tmp_data = $skeleton;
						for ($i= 0; $i < count($now_data); $i++) {
							$tmp_keys_dim = array_keys($tmp_data[$i]);
							foreach($tmp_keys_dim as $tmp_key_dim) {
								$tmp_keys = array_keys($tmp_data[$i][$tmp_key_dim]);
								foreach ($tmp_keys as $tmp_key) {
									if (array_key_exists($tmp_key, $now_data[$i])) {
										$tmp_data[$i][$tmp_key_dim][$tmp_key] = $now_data[$i][$tmp_key];
									}
								}
							}
						}
					} else if ($is_room_facility) {
						for ($i= 0; $i < count($now_data); $i++) {
							$tmp_data[$i] = $skeleton;
							for ($j = 0; $j < count($tmp_data[$i]); $j++) {
								$tmp_keys_dim = array_keys($tmp_data[$i][$j]);
								foreach($tmp_keys_dim as $tmp_key_dim) {
									$tmp_keys = array_keys($tmp_data[$i][$j][$tmp_key_dim]);
									foreach ($tmp_keys as $tmp_key) {
										if (array_key_exists($tmp_key, $now_data[$i][$j])) {
											$tmp_data[$i][$j][$tmp_key_dim][$tmp_key] = $now_data[$i][$j][$tmp_key];
										}
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

}

?>