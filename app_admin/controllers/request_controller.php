<?php
class RequestController extends AppController {
	var $name = "Request";
	var $helpers = array('Construct', 'Javascript', 'Ajax', 'Number');
	var $uses = array('Request',
					'AdminUser',
					'CustomerUser',
					'CurrencyLanguage',
					'RequestPaymentLanguage',
					'RequestStatLanguage',
					'HotelAgent',
					'Hotel',
					'AreaLanguage',
					'AreaLinkCountry',
					'StateLanguage',
					'CountryLanguage',
					'CityLanguage',
					'HotelLanguage',
					'HotelRoomLanguage',
					'MealType',
					'BreakfastType',
					'GenderLanguage',
					'RequestHotel',
					'RequestHotelCustomerUser',
					'RequestReceipt',
					'MailTemplateLanguage',
					'MiscInfoLanguage',
					'LanguageLanguage',
					'Condition2',
					'CarrierType',
	);
	var $needAuth = true;	// ログイン必須のフラグ
	var $components = array('ModelUtil', 'ListGetter', 'RequestHandler');

	function index ($base_condition = null) {

		$cnd = null;
		$cnd_db = null;
		if ($this->Session->check(RS_SESSION)) {
			$cnd = $this->Session->read(RS_SESSION);
		} else {
			// 検索データ用スケルトン作成
			$cnd = $this->makeSearchSkeleton();
			$this->Session->write(RS_SESSION, $cnd);
			$this->Session->write(RS_SESSION_BASE, $cnd);
		}

		if (!is_null($base_condition)) {
			$cnd = $base_condition;
			$this->set('condition2', $this->Session->read(RS_SESSION));
			$this->Session->write(RS_SESSION_BASE, $cnd);
		} else {
			$this->set('condition2', $cnd);
		}

		$cnd_db = $cnd;

		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$this->init_data_set();
		$this->getViewListIndex();

		$this->set('countrys', array());
		$this->set('states', array());
		$this->set('citys', array());

		// データを取得する
		$whitelist = array(
				'Request.id',
				'Request.first_name',
				'Request.last_name',
				'MiscInfoLanguage.name',
				'Request.tel',
				'Request.tel_mobile',
				'Request.request_date',
				'Request.fix_date',
				'Currency.iso_code_a',
				'CurrencyLanguage.name',
				'Request.price',
				'RequestPaymentLanguage.name',
				'RequestSettlement.auth_request_id',
				'Media.name',
//				'RequestStatLanguage.name',
//				'RequestHotel.limit_date',
//				'RequestHotel.checkin',
//				'RequestHotel.checkout',
//				'HotelLanguage.name',
//				'AreaLanguage.name',
//				'CountryLanguage.name',
//				'StateLanguage.name',
//				'CityLanguage.name',
//				'HotelRoomLanguage.name',
				);

		$where = $this->makeSearchCondition2($cnd_db);
		$search_cond = array(
			'conditions' => $where,			// 検索条件
			'fields' => $whitelist,			// 取得するカラム
			'page' => 1,					// 数値,最初に表示するページ。デフォルトは1,'last'(小文字)も可*1
			'limit' => RS_VIEW_MAX,		// 数値：showでも可。デフォルトは20
			'sort' => 'Request.id',					// ソートkey：order*2 でもよい。重なった場合はsortが優先される。
			'joins' => array(				// JOIN条件
				array('type' => 'INNER', 'alias' => 'CustomerUser', 'table' => 'customer_user', 'conditions' => 'Request.customer_user_id = CustomerUser.id'),
				array('type' => 'INNER', 'alias' => 'RequestHotel', 'table' => 'request_hotel', 'conditions' => 'Request.id = RequestHotel.request_id') ,
				array('type' => 'INNER', 'alias' => 'Hotel', 'table' => 'hotel', 'conditions' => 'RequestHotel.hotel_id = Hotel.id') ,
				array('type' => 'INNER', 'alias' => 'RequestHotelCustomerUser', 'table' => 'request_hotel_customer_user', 'conditions' => 'Request.id = RequestHotelCustomerUser.request_id'),
				array('type' => 'INNER', 'alias' => 'HotelLanguage', 'table' => 'hotel_language', 'conditions' => 'HotelLanguage.hotel_id = RequestHotel.hotel_id'),
				array('type' => 'INNER', 'alias' => 'Language', 'table' => 'language', 'conditions' => 'HotelLanguage.language_id = Language.id'),
				array('type' => 'INNER', 'alias' => 'AreaLinkCountry', 'table' => 'area_link_country', 'conditions' => 'Hotel.country_id = AreaLinkCountry.country_id'),
				array('type' => 'INNER', 'alias' => 'HotelRoomLanguage', 'table' => 'hotel_room_language', 'conditions' => 'HotelRoomLanguage.hotel_room_id = RequestHotel.hotel_room_id AND HotelRoomLanguage.language_id = Language.id'),
				array('type' => 'INNER', 'alias' => 'Currency', 'table' => 'currency', 'conditions' => 'Currency.id = Request.currency_id'),
				array('type' => 'INNER', 'alias' => 'CurrencyLanguage', 'table' => 'currency_language', 'conditions' => 'CurrencyLanguage.currency_id = Request.currency_id AND CurrencyLanguage.language_id = Language.id'),
				array('type' => 'INNER', 'alias' => 'RequestPaymentLanguage', 'table' => 'request_payment_language', 'conditions' => 'RequestPaymentLanguage.request_payment_id = Request.request_payment_id AND RequestPaymentLanguage.language_id = Language.id'),
				array('type' => 'INNER', 'alias' => 'MiscInfoLanguage', 'table' => 'misc_info_language', 'conditions' => 'MiscInfoLanguage.code_id = Request.request_stat_id AND MiscInfoLanguage.language_id = Language.id AND MiscInfoLanguage.misc_info_code = \''.REQUEST_CONDITION.'\''),
				array('type' => 'INNER', 'alias' => 'Media', 'table' => 'media', 'conditions' => 'Media.id = CustomerUser.media_id'),
				array('type' => 'INNER', 'alias' => 'RequestStatLanguage', 'table' => 'request_stat_language', 'conditions' => 'RequestStatLanguage.request_stat_id = RequestHotel.request_stat_id AND RequestStatLanguage.language_id = Language.id'),

				array('type' => 'LEFT', 'alias' => 'AreaLanguage', 'table' => 'area_language', 'conditions' => 'AreaLinkCountry.area_id = AreaLanguage.area_id AND Language.id = AreaLanguage.language_id'),
				array('type' => 'LEFT', 'alias' => 'CountryLanguage', 'table' => 'country_language', 'conditions' => 'Hotel.country_id = CountryLanguage.country_id AND Language.id = CountryLanguage.language_id'),
				array('type' => 'LEFT', 'alias' => 'StateLanguage', 'table' => 'state_language', 'conditions' => 'Hotel.state_id = StateLanguage.state_id AND Language.id = StateLanguage.language_id'),
				array('type' => 'LEFT', 'alias' => 'CityLanguage', 'table' => 'city_language', 'conditions' => 'Hotel.city_id = CityLanguage.city_id AND Language.id = CityLanguage.language_id'),
				array('type' => 'LEFT', 'alias' => 'RequestSettlement', 'table' => 'request_settlement', 'conditions' => 'Request.id = RequestSettlement.request_id'),
				),
			'order' => array('Request.id' => 'desc'),
			'group' => array(
				'Request.id',
				'Request.first_name',
				'Request.last_name',
				'MiscInfoLanguage.name',
				'Request.tel',
				'Request.tel_mobile',
				'Request.request_date',
				'Request.fix_date',
				'CurrencyLanguage.name',
				'Request.price',
				'RequestPaymentLanguage.name',
				'RequestSettlement.auth_request_id',
				'Media.name',
				),
			'direction' => 'desc'			// asc or desc:デフォルトはasc
			 );
		$this->paginate=$search_cond;
		$request_data = $this->paginate('Request');

		$attached_data = null;
		if (!empty($request_data)) {
			$req_ids = '';
			foreach ($request_data as $req) {
				if (!empty($req_ids)) {
					$req_ids .= ',';
				}
				$req_ids .= $req['Request']['id'];
			}
			if (!empty($req_ids)) {
				$sql = sprintf(REQUEST_LIST_ATTACHED_DATA_SQL, $req_ids);
				$attached_data = $this->Request->query($sql, array($view_iso));
			}
		}

		$this->set('Request', $request_data);
		$this->set('Attached', $attached_data);

	}

	function makeSearchSkeleton() {
		return array(
		'request_date_from'		=> '',
		'request_date_to'		=> '',
		'fix_date_from'			=> '',
		'fix_date_to'			=> '',
		'checkin_from'			=> '',
		'checkin_to'			=> '',
		'checkout_from'			=> '',
		'checkout_to'			=> '',
		'limit_date_from'		=> '',
		'limit_date_to'			=> '',
		'keyword'				=> '',
		'price'					=> '',
		'area_id'				=> '',
		'country_id'			=> '',
		'state_id'				=> '',
		'city_id'				=> '',
		'admin_user_id'			=> '',
		'hotel_agent_id'		=> '',
		'request_stat_id'		=> '',
		'request_payment_id'	=> '',
		'media_id'				=> '',
		);
	}


	function search($page = 1) {
		$base_condition = $this->Session->read(RS_SESSION_BASE);
		if(!empty($this->data)) {
			$this->data['Condition2']['request_date_from'] = $this->isLegalDate($this->data['Condition2']['request_date_from']);
			$this->data['Condition2']['request_date_to'] = $this->isLegalDate($this->data['Condition2']['request_date_to']);
			$this->data['Condition2']['fix_date_from'] = $this->isLegalDate($this->data['Condition2']['fix_date_from']);
			$this->data['Condition2']['fix_date_to'] = $this->isLegalDate($this->data['Condition2']['fix_date_to']);
			$this->data['Condition2']['checkin_from'] = $this->isLegalDate($this->data['Condition2']['checkin_from']);
			$this->data['Condition2']['checkin_to'] = $this->isLegalDate($this->data['Condition2']['checkin_to']);
			$this->data['Condition2']['checkout_from'] = $this->isLegalDate($this->data['Condition2']['checkout_from']);
			$this->data['Condition2']['checkout_to'] = $this->isLegalDate($this->data['Condition2']['checkout_to']);
			$this->data['Condition2']['limit_date_from'] = $this->isLegalDate($this->data['Condition2']['limit_date_from']);
			$this->data['Condition2']['limit_date_to'] = $this->isLegalDate($this->data['Condition2']['limit_date_to']);

			$this->Condition2->set($this->data);
			$this->Session->write(RS_SESSION, $this->data['Condition2']);
			if ($this->Condition2->validates($this->data)) {
				$this->redirect('/request/index/');
			} else {
				$this->index($base_condition);
				$this->render('/request/index/');
//				$this->set('msgs',  $this->Condition2->invalidFields());
			}
		}
	}

	function makeSearchCondition2($cnd) {
		$where = array();
		// request
		if (!empty($cnd['request_date_from']) && !empty($cnd['request_date_to'])) {
			$where = array_merge($where, array('Request.request_date BETWEEN ? AND ?' => array(date($cnd['request_date_from']), date($cnd['request_date_to']))));
		}
		if (!empty($cnd['fix_date_from']) && !empty($cnd['fix_date_to'])) {
			$where = array_merge($where, array('Request.fix_date BETWEEN ? AND ?' => array(date($cnd['fix_date_from']), date($cnd['fix_date_to']))));
		}
		if (!empty($cnd['price'])) {
			$where = array_merge($where, array("Request.price" => $cnd['price']));
		}
		if (!empty($cnd['admin_user_id'])) {
			$where = array_merge($where, array("Request.admin_user_id" => $cnd['admin_user_id']));
		}
		if (!empty($cnd['request_stat_id'])) {
			$ids = '';
			foreach ($cnd['request_stat_id'] as $id) {
				if (!empty($ids)) {
					$ids .= ',';
				}
				$ids .= $id;
			}
			$where = array_merge($where, array("Request.request_stat_id IN (".$ids.")"));
//			$where = array_merge($where, array("Request.request_stat_id IN " => $cnd['request_stat_id']));
		}
		// request_hotel
		if (!empty($cnd['checkin_from']) && !empty($cnd['checkin_to'])) {
			$where = array_merge($where, array('Request.request_date BETWEEN ? AND ?' => array(date($cnd['checkin_from']), date($cnd['checkin_to']))));
		}
		if (!empty($cnd['checkout_from']) && !empty($cnd['checkout_to'])) {
			$where = array_merge($where, array('Request.request_date BETWEEN ? AND ?' => array(date($cnd['checkout_from']), date($cnd['checkout_to']))));
		}
		if (!empty($cnd['limit_date_from']) && !empty($cnd['limit_date_to'])) {
			$where = array_merge($where, array('Request.request_date BETWEEN ? AND ?' => array(date($cnd['limit_date_from']), date($cnd['limit_date_to']))));
		}
		if (!empty($cnd['hotel_agent_id'])) {
			$where = array_merge($where, array("RequestHotel.hotel_agent_id" => $cnd['hotel_agent_id']));
		}
		// request_settlement
		// request_settlementは「あり」exists 「なし」not exists 「両方」なにも
		if (!empty($cnd['request_settlement_id'])) {
			if ($cnd['request_settlement_id'] == REQUEST_SETTLEMENT_EXISTS) {
				$where = array_merge($where, array("EXISTS (SELECT request_settlement.id FROM request_settlement WHERE request_settlement.request_id = request.id AND isnull(request_settlement.deleted))"));
			} else if ($cnd['request_settlement_id'] == REQUEST_SETTLEMENT_NOT_EXISTS) {
				$where = array_merge($where, array("NOT EXISTS (SELECT request_settlement.id FROM request_settlement WHERE request_settlement.request_id = request.id AND isnull(request_settlement.deleted))"));
			}
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
		// customer_user
		if (!empty($cnd['media_id'])) {
			$where = array_merge($where, array("CustomerUser.media_id" => $cnd['media_id']));
		}

		// keywordの条件は複数部分のLIKE
		// keyword
		if (!empty($cnd['keyword'])) {
			$likes = array_merge($where, array("Request.message_bord LIKE" => "%" .$cnd['keyword']. "%"));
			$likes = array_merge($where, array("RequestHotelCustomerUser.first_name LIKE" => "%" .$cnd['keyword']. "%"));
			$likes = array_merge($where, array("RequestHotelCustomerUser.last_name LIKE" => "%" .$cnd['keyword']. "%"));
			$where = array_merge($where, array("OR" => $likes));
		}

		$where = array_merge($where, array('Request.deleted' => null));
		$where = array_merge($where, array('Hotel.deleted' => null));
		$where = array_merge($where, array('RequestHotel.deleted' => null));
		$where = array_merge($where, array('RequestHotelCustomerUser.deleted' => null));
		$where = array_merge($where, array('AreaLinkCountry.deleted' => null));
		$where = array_merge($where, array('CustomerUser.deleted' => null));
		$where = array_merge($where, array('HotelLanguage.deleted' => null));
		$where = array_merge($where, array('Language.deleted' => null));
		$where = array_merge($where, array('HotelLanguage.deleted' => null));
		$where = array_merge($where, array('HotelRoomLanguage.deleted' => null));
		$where = array_merge($where, array('RequestStatLanguage.deleted' => null));
		$where = array_merge($where, array('CurrencyLanguage.deleted' => null));
		$where = array_merge($where, array('RequestPaymentLanguage.deleted' => null));
		$where = array_merge($where, array('Media.deleted' => null));
		$where = array_merge($where, array('AreaLanguage.deleted' => null));
		$where = array_merge($where, array('CountryLanguage.deleted' => null));
		$where = array_merge($where, array('StateLanguage.deleted' => null));
		$where = array_merge($where, array('CityLanguage.deleted' => null));

		$where = array_merge($where, array('Language.iso_code' => $this->Session->read(VIEW_ISO_CODE)));

		return array("AND" => $where);
	}

	function save() {
//debug($this->data);

		$request = $this->setSaveRequestData($this->data);
		$requestHotel = $this->setSaveRequestHotelData($this->data);
		$requestHotelCustomerUser = $this->setSaveRequestHotelCustomerUserData($this->data);
		$requestReceipt = $this->setSaveRequestReceiptData($this->data);

		$saveRequestReceipt = $this->makeSaveRequestReceiptData($requestReceipt);
		$saveRequestHotelCustomerUser = $this->makeSaveRequestHotelCustomerUser($requestHotelCustomerUser);
		$saveRequestHotel = $this->makeSaveRequestHotel($requestHotel);
		$saveRequest = $this->makeSaveRequest($request, $requestHotel);

		$last_id = null;
		$is_break = false;

		$this->Request->create();
		$this->Request->set($saveRequest);
		$whitelist = array_keys($this->Request->getColumnTypes());

//debug($request);
//debug($requestHotel);
//debug($requestHotelCustomerUser);
//debug($requestReceipt);

		$this->Request->begin();
		if ($this->Request->save($saveRequest, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
			$last_id = $this->Request->getLastInsertID();
			$whitelist = array_keys($this->RequestHotel->getColumnTypes());
			$count = 0;
			$errors = null;
			foreach ($saveRequestHotel as $hotel) {
				$this->RequestHotel->create();
				$this->RequestHotel->set($hotel);
				$hotel['request_id'] = $last_id;
				if (!$this->RequestHotel->save($hotel, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break = true;
					$errors[$count++] = $this->RequestHotel->validationErrors;
					while ($count < 4) {
						$errors[$count++] = array();
					}
					$this->RequestHotel->validationErrors = $errors;
					break;
				}
				$errors[$count++] = array();
			}
			$whitelist = array_keys($this->RequestHotelCustomerUser->getColumnTypes());
			$count = 0;
			$errors = null;
			foreach ($saveRequestHotelCustomerUser as $user) {
				$this->RequestHotelCustomerUser->create();
				$this->RequestHotelCustomerUser->set($user);
				$user['request_id'] = $last_id;
				if (!$this->RequestHotelCustomerUser->save($user, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break = true;
					$errors[$count++] = $this->RequestHotelCustomerUser->validationErrors;
					while ($count < 4) {
						$errors[$count++] = array();
					}
					$this->RequestHotelCustomerUser->validationErrors = $errors;
					break;
				}
			}
			if ($saveRequestReceipt) {
				$whitelist = array_keys($this->RequestReceipt->getColumnTypes());
				$this->RequestReceipt->create();
				$this->RequestReceipt->set($saveRequestReceipt);
				$saveRequestReceipt['request_id'] = $last_id;
				if (!$this->RequestReceipt->save($saveRequestReceipt, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break = true;
				}
			}
		} else {
			$is_break = true;
		}

		if (!$is_break) {
			$this->Request->commit();
//			$this->redirect('/request/edit/'.$last_id.'/');
			$this->redirect('/request/edit/index/');
		} else {
			$this->Request->rollback();
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$this->init_data_set();
			$this->getViewrList($view_iso);

			$this->getCustomerUserData($request, $requestHotelCustomerUser, $request['customer_user_id']);

			$requestHotel = $this->setHotelDataList($requestHotel);

			$this->set('request', $request);
			$this->set('request_hotel', $requestHotel);
			$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
			$this->set('request_receipt', $requestReceipt);

			$this->render('/request/edit/');
		}
//debug($this->Request->validationErrors);
//debug($this->RequestHotel->validationErrors);
//debug($this->RequestHotelCustomerUser->validationErrors);
//debug($this->RequestReceipt->validationErrors);

//debug($request);
//debug($requestHotel);
//debug($requestHotelCustomerUser);
//debug($requestReceipt);


	}

	function makeSaveRequest($request, $requestHotel) {
		$tmpData = array();
		$price = 0;
		$point = 0;

		foreach($requestHotel as $hotel) {
			if (!empty($hotel['price'])) {
				$price += $hotel['price'];
			}
			if (!empty($hotel['point'])) {
				$point += $hotel['point'];
			}
		}
		$tmpData = $request;
		$tmpData['price'] = $price;
		$tmpData['point'] = $point;
		return $tmpData;
	}

	function makeSaveRequestHotel($requestHotel) {
		$tmpData = array();
		$count = 0;
		foreach($requestHotel as $hotel) {
			// ホテルと部屋が選択されている場合、データを使用
			if (!empty($hotel['hotel_id']) && !empty($hotel['hotel_room_id'])) {
				$tmpData[$count] = $hotel;
			} else if ($count == 0) {
				// 最初のデータは必ず使用
				$tmpData[$count] = $hotel;
			}
			$count++;
		}
		return $tmpData;
	}

	function makeSaveRequestHotelCustomerUser($requestHotelCustomerUser) {
		$tmpData = array();
		$count = 0;
		foreach($requestHotelCustomerUser as $user) {
			// 何か入力があればデータを使用
			if (!empty($user['first_name']) || !empty($user['last_name']) || !empty($user['age'])) {
				$tmpData[$count] = $user;
			} else if ($count = 0) {
				// リーダーの場合、必ず使用
				if ($user['leader'] == REQUEST_CUSTOMER_USER_LEADER) {
					$tmpData[$count] = $user;
				}
			}
			$count++;
		}
		return $tmpData;
	}

	function makeSaveRequestReceiptData($requestReceipt) {
		// 登録されてなくて、不要なら捨てる
		if (empty($requestReceipt['id']) && $requestReceipt['status'] == UNNECESSARY_REQUEST_RECEIPT) {
			return null;
		} else {
			return $requestReceipt;
		}
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

	/***
	 * ポストされたリクエストをスケルトンにコピーする。
	 * ※POSTされない項目を網羅させるため
	 */
	function setSaveRequestData($postdata) {
		$saveRequestData = $this->make_request_skel();
		$postRequestData = $postdata['RequestData']['Request'];

		$keys = array_keys($this->Request->getColumnTypes());

		// 日付(POST時配列)を文字列に変換
		$postRequestData['request_date'] = $this->isLegalDate($postRequestData['request_date']);

		foreach ($keys as $key) {
			if (array_key_exists($key, $postRequestData)) {
				$saveRequestData[$key] = $postRequestData[$key];
			}
		}

		return $saveRequestData;
	}

	/***
	 * ポストされたリクエストホテルをスケルトンにコピーする。
	 * ※POSTされない項目を網羅させるため
	 */
	function setSaveRequestHotelData($postdata) {
		$saveRequestHotelData = $this->make_request_hotel_skel();
		$postRequestHotelData = $postdata['RequestData']['RequestHotel'];

		$keys = array_keys($this->RequestHotel->getColumnTypes());

		// 代表者・同行者から、大人・子供の人数をカウント
		$postRequestHotelCustomerUserData = $postdata['RequestData']['RequestHotelCustomerUser'];
		$cnt_adult = 0;
		$cnt_child = 0;
		foreach ($postRequestHotelCustomerUserData as $postRequestHotelCustomerUser) {
			if (!empty($postRequestHotelCustomerUser['first_name']) && !empty($postRequestHotelCustomerUser['last_name'])) {
				if (array_key_exists('adult', $postRequestHotelCustomerUser)) {
					if ($postRequestHotelCustomerUser['adult'] == REQUEST_CUSTOMER_USER_ADULT) {
						$cnt_adult++;
					} else {
						$cnt_child++;
					}
				}
			}
		}

		$count = 0;
		foreach ($postRequestHotelData as $postRequestHotel) {
			$saveRequestHotel = $saveRequestHotelData[$count];
			// 日付(POST時配列)を文字列に変換
			$checkin = $this->isLegalDate($postdata['RequestHotel'][$count]['checkin']);
			$checkout = $this->isLegalDate($postdata['RequestHotel'][$count]['checkout']);
			$limit_date = $this->isLegalDateTime($postdata['RequestHotel'][$count]['limit_date']);
			foreach ($keys as $key) {

				if (array_key_exists($key, $postRequestHotel)) {
					// 通常のデータ
					$saveRequestHotel[$key] = $postRequestHotel[$key];
				}
				// 他のデータから取得するもの
				// 日付は先に変換したものを使用
				if (strtolower($key) == 'checkin') {
					$saveRequestHotel[$key] = $checkin;
				} else if (strtolower($key) == 'checkout') {
					$saveRequestHotel[$key] = $checkout;
				} else if (strtolower($key) == 'limit_date') {
					$saveRequestHotel[$key] = $limit_date;
				} else if (strtolower($key) == 'currency_id') {
					$saveRequestHotel[$key] = $postdata['RequestData']['Request'][$key];
				} else if (strtolower($key) == 'adult_cnt') {
					$saveRequestHotel[$key] = $cnt_adult;
				} else if (strtolower($key) == 'child_cnt') {
					$saveRequestHotel[$key] = $cnt_child;
				}
			}
			$saveRequestHotelData[$count++] = $saveRequestHotel;

		}

		return $saveRequestHotelData;
	}

	/***
	 * ポストされたリクエストホテルカスタマーユーザーをスケルトンにコピーする。
	 * ※POSTされない項目を網羅させるため
	 */
	function setSaveRequestHotelCustomerUserData($postdata) {
		$saveRequestHotelCustomerUserData = $this->make_request_hotel_customer_user_skel();
		$postRequestHotelCustomerUserData = $postdata['RequestData']['RequestHotelCustomerUser'];

		$keys = array_keys($this->RequestHotelCustomerUser->getColumnTypes());

		$count = 0;
		foreach ($postRequestHotelCustomerUserData as $postRequestHotelCustomerUser) {
			$saveRequestHotelCustomerUser = $saveRequestHotelCustomerUserData[$count];
			foreach ($keys as $key) {
				if (array_key_exists($key, $postRequestHotelCustomerUser)) {
					$saveRequestHotelCustomerUser[$key] = $postRequestHotelCustomerUser[$key];
				} else if ($key == 'comment') {
					$saveRequestHotelCustomerUser[$key] = '';
				}
			}
			$saveRequestHotelCustomerUserData[$count++] = $saveRequestHotelCustomerUser;
		}

		return $saveRequestHotelCustomerUserData;
	}


	/***
	 * ポストされたリクエストをスケルトンにコピーする。
	 * ※POSTされない項目を網羅させるため
	 */
	function setSaveRequestReceiptData($postdata) {
		$saveRequestReceiptData = $this->make_request_receipt_skel();
		$postRequestReceiptData = $postdata['RequestData']['RequestReceipt'];

		$keys = array_keys($this->RequestReceipt->getColumnTypes());

		foreach ($keys as $key) {
			if (array_key_exists($key, $postRequestReceiptData)) {
				$saveRequestReceiptData[$key] = $postRequestReceiptData[$key];
			}
		}

		return $saveRequestReceiptData;
	}






	function add($customer_user_id) {
		$this->redirect('/request/edit/0/'.$customer_user_id.'/');
	}


	function edit($request_id = null, $customer_user_id = null) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		$request = null;
		$requestHotel = null;
		$requestHotelCustomerUser = null;
		$requestReceipt = null;
		if (is_null($request_id) || $request_id <= 0) {
			// 引数がない場合、空をセット
			if (empty($this->data)) {
				// リクエストの空データを作成
				$request = $this->make_request_skel();
				// リクエストホテル(最大4つ)の空データを作成
				$requestHotel = $this->make_request_hotel_skel();
				// 申し込み・同行者(最大6+申し込み者1の7件)情報の空データを作成
				$requestHotelCustomerUser = $this->make_request_hotel_customer_user_skel();
				// 領収書の空データを作成
				$requestReceipt = $this->make_request_receipt_skel();
			} else {
				// TODO:POSTデータ分解して再設定用の処理
				$customer_user = $this->data['Request'];
			}
		} else {
			//引数がある場合、データを取得
			$request = $this->Request->query(REQUEST_SQL, array($request_id));
			if (empty($request)) {
				// リクエストの空データを作成
				$request = $this->make_request_skel();
				// リクエストホテル(最大4つ)の空データを作成
				$requestHotel = $this->make_request_hotel_skel();
				// 申し込み・同行者(最大6+申し込み者1の7件)情報の空データを作成
				$requestHotelCustomerUser = $this->make_request_hotel_customer_user_skel();
				// 領収書の空データを作成
				$requestReceipt = $this->make_request_receipt_skel();
				// TODO:空データセットするときはここも
			} else {
				foreach ($request as $data) {
					// リクエストはあったが、なぜか不正データの場合
					if (empty($data['request']['id'])) {
						// リクエストの空データを作成
						$request = $this->make_request_skel();
						// リクエストホテル(最大4つ)の空データを作成
						$requestHotel = $this->make_request_hotel_skel();
						// 申し込み・同行者(最大6+申し込み者1の7件)情報の空データを作成
						$requestHotelCustomerUser = $this->make_request_hotel_customer_user_skel();
						// 領収書の空データを作成
						$requestReceipt = $this->make_request_receipt_skel();
						// TODO:空データセットするときはここも
						break;
					}
					$this->Request->set($data['request']);
					$request = $data['request'];

					// データが正しそうな場合、リクエストホテルのリストを取得
					$requestHotel = $this->RequestHotel->query(REQUEST_HOTEL_LIST_SQL, array($request_id));
					if (count($requestHotel) == 0) {
						// リクエストホテルに何も登録されてない場合
						// リクエストホテル(最大4つ)の空データを作成
						$requestHotel = $this->make_request_hotel_skel();
					} else {
						// データが存在する場合データを、存在しない場合最大4件中の空き部分に空データを詰めてやる
						$requestHotelSkel = $this->ModelUtil->getSkeleton($this->RequestHotel);
						$tmpRequestHotel = array();
						for ($count = 0; $count < 4; $count++) {
							if ($count < count($requestHotel)) {
								if (empty($requestHotel[$count]['request_hotel']['hotel_room_id'])) {
									$tmpRequestHotel[$count] = $requestHotelSkel;
								} else {
									$tmpRequestHotel[$count] = $requestHotel[$count]['request_hotel'];
								}
							} else {
								$tmpRequestHotel[$count] = $requestHotelSkel;
							}
						}
						$requestHotel = $tmpRequestHotel;
					}
					$this->RequestHotel->set($requestHotel);

					// データが正しそうな場合、申し込み者・同行者のリストを取得
					$requestHotelCustomerUser = $this->RequestHotelCustomerUser->query(REQUEST_HOTEL_CUSTOMER_USER_LIST_SQL, array($request_id));
					if (count($requestHotelCustomerUser) == 0) {
						// リクエストホテルカスタマーユーザーに何も登録されてない場合
						// リクエストホテルカスタマーユーザー(最大6+申し込み者1の7件)の空データを作成
						$requestHotelCustomerUser = $this->make_request_hotel_customer_user_skel();
					} else {
						// データが存在する場合データを、存在しない場合最大7件中の空き部分に空データを詰めてやる
						$requestHotelCustomerUserSkel = $this->ModelUtil->getSkeleton($this->RequestHotelCustomerUser);
						$tmpRequestHotelCustomerUser = array();
						for ($count = 0; $count < 7; $count++) {
							if ($count < count($requestHotelCustomerUser)) {
								if (empty($requestHotelCustomerUser[$count]['request_hotel_customer_user']['first_name'])) {
									$tmpRequestHotelCustomerUser[$count] = $requestHotelCustomerUserSkel;
								} else {
									$tmpRequestHotelCustomerUser[$count] = $requestHotelCustomerUser[$count]['request_hotel_customer_user'];
								}
							} else {
								$tmpRequestHotelCustomerUser[$count] = $requestHotelCustomerUserSkel;
							}
						}
						$requestHotelCustomerUser = $tmpRequestHotelCustomerUser;
					}

					// データが正しそうな場合、領収書を取得
					$requestReceipt = $this->RequestReceipt->query(REQUEST_RECEIPT_SQL, array($request_id));
					if (count($requestReceipt) == 0) {
						// リクエスト領収書に何も登録されてない場合
						// リクエスト領収書の空データを作成
						$requestReceipt = $this->make_request_receipt_skel();
					} else {
						foreach ($requestReceipt as $receipt) {
							$requestReceipt = $receipt;
							break;
						}
					}


					break;
				}
			}

		}


		$this->init_data_set();
		$this->getViewrList($view_iso);

		$this->getCustomerUserData($request, $requestHotelCustomerUser, $customer_user_id);

		$requestHotel = $this->setHotelDataList($requestHotel);

		$this->set('request', $request);
		$this->set('request_hotel', $requestHotel);
		$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
		$this->set('request_receipt', $requestReceipt);
	}

	function getCustomerUserData(&$request, &$requestHotelCustomerUser, $customer_user_id) {
		if (empty($request['customer_user_id'])) {
			$customer_users = $this->CustomerUser->query(CUSTOMER_USER_SQL, array($customer_user_id));
			foreach($customer_users as $customer_user) {
				$request['customer_user_id'] = $customer_user['customer_user']['id'];
				$request['addr_country_id'] = $customer_user['customer_user']['addr_country_id'];
				$request['addr_1'] = $customer_user['customer_user']['addr_1'];
				$request['addr_2'] = $customer_user['customer_user']['addr_2'];
				$request['addr_3'] = $customer_user['customer_user']['addr_3'];
				$request['tel'] = $customer_user['customer_user']['tel'];
				$request['fax'] = $customer_user['customer_user']['fax'];
				$request['tel_mobile'] = $customer_user['customer_user']['tel_mobile'];
				$request['postcode'] = $customer_user['customer_user']['postcode'];
				$request['email'] = $customer_user['customer_user']['email'];
				$request['email_mobile'] = $customer_user['customer_user']['email_mobile'];
				$request['country_id'] = $customer_user['customer_user']['country_id'];
				$request['language_id'] = $customer_user['customer_user']['language_id'];
				$request['first_name'] = $customer_user['customer_user']['first_name'];
				$request['last_name'] = $customer_user['customer_user']['last_name'];
				$request['gender_id'] = $customer_user['customer_user']['gender_id'];
				$request['age'] = $this->calc_age($customer_user['customer_user']['birthday']);

				$requestHotelCustomerUser[0]['first_name'] = $customer_user['customer_user']['first_name'];
				$requestHotelCustomerUser[0]['last_name'] = $customer_user['customer_user']['last_name'];
				$requestHotelCustomerUser[0]['age'] = $this->calc_age($customer_user['customer_user']['birthday']);
				$requestHotelCustomerUser[0]['gender_id'] = $customer_user['customer_user']['gender_id'];
				$requestHotelCustomerUser[0]['adult'] = 1;
				break;
			}
		}
	}

	function setHotelDataList(&$requestHotel) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$coutry = array();
		$state = array();
		$city = array();
		$hotel = array();
		$hotel_room = array();
		$room_data = array();

		$count = 0;
		foreach ($requestHotel as $rh) {
			$requestHotel[$count]['area_id'] = 0;
			$requestHotel[$count]['country_id'] = 0;
			$requestHotel[$count]['state_id'] = 0;
			$requestHotel[$count]['city_id'] = 0;
			$requestHotel[$count]['town_id'] = 0;
			if (!empty($rh['hotel_id'])) {
				$tmphotel = $this->Hotel->query(HOTEL_SQL, array($rh['hotel_id']));
				if ($tmphotel) {
					$area = $this->Hotel->query(AREA_LINK_COUNTRY_LIST_SQL, array($tmphotel[0]['hotel']['country_id']));
					if ($area) {
						$area_id = empty($area[0]['area_link_country']['area_id']) ? 0 : $area[0]['area_link_country']['area_id'];
						$country_id = empty($tmphotel[0]['hotel']['country_id']) ? 0 : $tmphotel[0]['hotel']['country_id'];
						$state_id = empty($tmphotel[0]['hotel']['state_id']) ? 0 : $tmphotel[0]['hotel']['state_id'];
						$city_id = empty($tmphotel[0]['hotel']['city_id']) ? 0 : $tmphotel[0]['hotel']['city_id'];
						$town_id = empty($tmphotel[0]['hotel']['town_id']) ? 0 : $tmphotel[0]['hotel']['town_id'];
						$hotel_id = empty($rh['hotel_id']) ? 0 : $rh['hotel_id'];
						$room_id = empty($rh['hotel_room_id']) ? 0 : $rh['hotel_room_id'];
						$agent_id = empty($rh['hotel_agent_id']) ? 0 : $rh['hotel_agent_id'];

						$requestHotel[$count]['area_id'] = $area_id;
						$requestHotel[$count]['country_id'] = $country_id;
						$requestHotel[$count]['state_id'] = $state_id;
						$requestHotel[$count]['city_id'] = $city_id;
						$requestHotel[$count]['town_id'] = $town_id;

						$countrys = $this->ListGetter->getSelectCountryList($view_iso, $area_id);
						$states = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);
						$citys = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);
						$hotels = $this->ListGetter->getSelectHotelList($view_iso, $area_id, $country_id, $state_id, $city_id);
						$rooms = $this->ListGetter->getSelectRoomList($view_iso, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id);

						$room_datas = $this->HotelRoomLanguage->query(SELECT_ROOM_DATA, array($view_iso, $room_id));
						// TODO:ルームデータの取得処理 既にbooking_id等が埋まっている場合のデータ変換処理が必要

						$country[$count] = $countrys;
						$state[$count] = $states;
						$city[$count] = $citys;
						$hotel[$count] = $hotels;
						$hotel_room[$count] = $rooms;
						$room_data[$count] = $room_datas[0];
						$room_data[$count]['count'] = $count;

					} else {
						$country[$count] = array();
						$state[$count] = array();
						$city[$count] = array();
						$hotel[$count] = array();
						$hotel_room[$count] = array();
						$room_data[$count] = array();
					}
				} else {
					$country[$count] = array();
					$state[$count] = array();
					$city[$count] = array();
					$hotel[$count] = array();
					$hotel_room[$count] = array();
					$room_data[$count] = array();
				}
			} else {
				$country[$count] = array();
				$state[$count] = array();
				$city[$count] = array();
				$hotel[$count] = array();
				$hotel_room[$count] = array();
				$room_data[$count] = array();
			}
			$count++;
		}
		$this->set('countrys', $country);
		$this->set('states', $state);
		$this->set('citys', $city);
		$this->set('hotels', $hotel);
		$this->set('hotel_rooms', $hotel_room);
		$this->set('room_data', $room_data);

//debug($requestHotel);

//debug($country);
//debug($state);
//debug($city);
//debug($hotel);
//debug($hotel_room);
//debug($room_data);
		return ($requestHotel);
	}

	function calc_age($birth)
	{
		$ty = date("Y");
		$tm = date("m");
		$td = date("d");
		list($by, $bm, $bd) = explode('-', $birth);
		$age = $ty - $by;
		if($tm * 100 + $td < $bm * 100 + $bd) $age--;
		return $age;
	}

	function make_request_skel() {
		// リクエストの空データを作成
		return $this->ModelUtil->getSkeleton($this->Request);
	}

	function make_request_hotel_skel() {
		// リクエストホテル(最大4つ)の空データを作成
		$requestHotel = $this->ModelUtil->getSkeleton($this->RequestHotel);
		return array($requestHotel, $requestHotel, $requestHotel, $requestHotel);
	}

	function make_request_hotel_customer_user_skel() {
		// 申し込み・同行者(最大6+申し込み者1の7件)情報の空データを作成
		$requestHotelCustomerUser = $this->ModelUtil->getSkeleton($this->RequestHotelCustomerUser);
		return array($requestHotelCustomerUser, $requestHotelCustomerUser, $requestHotelCustomerUser, $requestHotelCustomerUser, $requestHotelCustomerUser, $requestHotelCustomerUser, $requestHotelCustomerUser);
	}

	function make_request_receipt_skel() {
		return $this->ModelUtil->getSkeleton($this->RequestReceipt);
	}

	/**
	 * 初期データをセットします。
	 *
	 */
	function init_data_set() {
		$login_user = $this->Session->read('auth');
		$this->set('loginUser', $login_user[0]['AdminUser']);
	}

	/***
	 * 表示用リストを取得し、コントローラにセットします。
	 *
	 */
	function getViewrList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 性別を取得
		$this->set('gender', $this->ListGetter->getGenderList($view_iso));
		// 国を取得
		$this->set('country', $this->ListGetter->getCountryList($view_iso));
//		// 管理者を取得
//		$this->set('admin_user', $this->ListGetter->getAdminUserList());
//		// リクエスト状態取得
//		$this->set('request_stat', $this->ListGetter->getMiscInfoList($view_iso, REQUEST_CONDITION));
//		// 決済状態取得
//		$this->set('request_payment', $this->ListGetter->getRequestPaymentList($view_iso));
//		// 決済通貨取得
//		$this->set('currency', $this->ListGetter->getCurrencyList($view_iso));
		// リクエスト状態取得
		$this->set('individual_request_stat', $this->ListGetter->getRequestStatList($view_iso));
//		// ホテルエージェント(ホールセラー)取得
//		$this->set('hotel_agent', $this->ListGetter->getHotelAgentList());
//		// エリア取得
//		$area = $this->ListGetter->getAreaList();
//		array_unshift($area, array('al'=>array('area_id'=>'0','name'=>'')));
//		$this->set('area', $area);
		// 大人/子供取得
		$this->set('adult', $this->ListGetter->getMiscInfoList($view_iso, ADULT));
		// 請求書状態取得
		$this->set('receipt_status', $this->ListGetter->getMiscInfoList($view_iso, RECEIPT_STATUS));
		// メールテンプレート名取得
		$this->set('mail_template_name', $this->ListGetter->getMailTemplateNameList($view_iso, REQUEST_MAIL_TEMPLATE));

		$this->getViewListIndex($view_iso);
	}

	function getViewListIndex($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 管理者を取得
		$this->set('admin_user', $this->ListGetter->getAdminUserList());
		// リクエスト状態取得
		$this->set('request_stat', $this->ListGetter->getMiscInfoList($view_iso, REQUEST_CONDITION));
		// 決済状態取得
		$this->set('request_payment', $this->ListGetter->getRequestPaymentList($view_iso));
		// 決済通貨取得
		$this->set('currency', $this->ListGetter->getCurrencyList($view_iso));
		// ホテルエージェント(ホールセラー)取得
		$this->set('hotel_agent', $this->ListGetter->getHotelAgentList());
		// エリア取得
		$area = $this->ListGetter->getAreaList();
		array_unshift($area, array('al'=>array('area_id'=>'0','name'=>'')));
		$this->set('area', $area);
		$data = $this->ListGetter->getMediaList();
		$this->set('media', $data);

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
	 * 都市リストボックス/コールセラー(代理店)リストボックスが変更された場合にAjaxにより呼ばれ、
	 * ホテルリストを取得します。
	 */
	function change_city($area_id = 0, $country_id = 0, $state_id = 0, $city_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$hotels = $this->ListGetter->getSelectHotelList($view_iso, $area_id, $country_id, $state_id, $city_id);

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('hotels', $hotels);
	}

	/***
	 * ホテルリストボックスが変更された場合にAjaxにより呼ばれ、
	 * 部屋リストを取得します。
	 */
	function change_hotel($area_id = 0, $country_id = 0, $state_id = 0, $city_id = 0, $hotel_id = 0, $agent_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$rooms = $this->ListGetter->getSelectRoomList($view_iso, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id);

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('rooms', $rooms);
	}

	/***
	 * 部屋リストボックスが変更された場合にAjaxにより呼ばれ、
	 * 部屋情報を取得します。
	 */
	function change_room($room_id, $count) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$room_data = $this->HotelRoomLanguage->query(SELECT_ROOM_DATA, array($view_iso, $room_id));

		Configure::write('debug', 0);
		$this->layout = 'ajax';

		if (count($room_data) >= 1) {
			$room_data[0]['room_data']['count'] = $count;
			$this->set('room_data', $room_data[0]);
		} else {
			$this->set('room_data', null);
		}
	}

	function change_mail_template($mail_template_id = 0) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		if ($mail_template_id == 0) {
			$mail_template_data = null;
		} else {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$mail_template_data = $this->MailTemplateLanguage->query(MAIL_TEMPLATE_LANGUAGE_BY_ID_SQL, array($mail_template_id));

			if (count($mail_template_data) != 0) {
				$mail_template_data = $mail_template_data[0];
			} else {
				$mail_template_data = $this->ModelUtil->getSkeleton($this->MailTemplateLanguage);
			}
		}

		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->set('mail_template', $mail_template_data);
	}


	function init() {
		$this->Session->delete(RS_SESSION);
		$this->Session->delete(RS_SESSION_BASE);
		$this->redirect('/request/index/');
	}

}
?>