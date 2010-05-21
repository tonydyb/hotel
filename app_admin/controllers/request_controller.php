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
					'Language',
					'AreaLanguage',
					'AreaLinkCountry',
					'StateLanguage',
					'CountryLanguage',
					'CityLanguage',
					'HotelLanguage',
					'HotelRoomLanguage',
					'MealTypeLanguage',
					'BreakfastTypeLanguage',
					'GenderLanguage',
					'RequestHotel',
					'RequestHotelCustomerUser',
					'RequestReceipt',
					'MailTemplateLanguage',
					'MiscInfoLanguage',
					'LanguageLanguage',
					'Condition2',
					'CancelCharge',
					'CarrierType',
	);
	var $needAuth = true;	// ログイン必須のフラグ
	var $components = array('ModelUtil', 'ListGetter', 'RequestHandler', 'Email', 'MakeTemplateMessage', );

	function mail () {
		if (!empty($this->data)) {
			$data = $this->data;
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$language = $this->Language->find('first', array('conditions' => array('Language.iso_code' => $view_iso, 'Language.deleted is null')));
			$mail_template = $this->MailTemplateLanguage->find('first', array('conditions' => array('MailTemplateLanguage.id' => $data['MailTemplate']['id'], 'MailTemplateLanguage.language_id' => $language['Language']['id'], 'MailTemplateLanguage.deleted is null')));
			$customer_user = $this->CustomerUser->find('first', array('conditions' => array('CustomerUser.id' => $data['Request']['customer_user_id'], 'CustomerUser.deleted is null')));

			$sub_data = array();
			$this->get_view_list($view_iso, $sub_data);
			$this->replace_data($sub_data);

			// POSTデータを使用しやすい形に成形
			$system = array();
			$request = $data['Request'];
			$request['request_stat'] = $sub_data['request_stat'][$request['request_stat_id']];
			$request['request_payment'] = $sub_data['request_payment'][$request['request_payment_id']];
			$request['currency'] = $sub_data['currency'][$request['currency_id']];
			$request['request_date']['date'] = $this->df($this->isLegalDate($request['request_date']));
			$request['fix_date']['date'] = $this->df($this->isLegalDate($request['fix_date']));

			$request_hotel = array();
			$count = 0;
			$price = 0;
			$all_price = 0;
			foreach($data['RequestHotel'] as $hotel) {
				if (!empty($hotel['id'])) {
					$request_hotel[$count] = $hotel;
					$request_hotel[$count]['request_stat'] = $sub_data['individual_request_stat'][$hotel['request_stat_id']];
					$request_hotel[$count]['area'] = $sub_data['area'][$hotel['area_id']];
					$result = $this->CountryLanguage->find('first', array('conditions' => array('CountryLanguage.country_id' => $hotel['country_id'], 'CountryLanguage.language_id' => $language['Language']['id'], 'CountryLanguage.deleted is null')));
					$request_hotel[$count]['country'] = $result['CountryLanguage']['name_long'];
					$hotel['state_id'] = empty($hotel['state_id']) ? 0 : $hotel['state_id'];
					$result = $this->StateLanguage->find('first', array('conditions' => array('StateLanguage.state_id' => $hotel['state_id'], 'StateLanguage.language_id' => $language['Language']['id'], 'StateLanguage.deleted is null')));
					$request_hotel[$count]['state'] = $result['StateLanguage']['name'];
					$result = $this->CityLanguage->find('first', array('conditions' => array('CityLanguage.city_id' => $hotel['city_id'], 'CityLanguage.language_id' => $language['Language']['id'], 'CityLanguage.deleted is null')));
					$request_hotel[$count]['city'] = $result['CityLanguage']['name'];
					$result = $this->HotelLanguage->find('first', array('conditions' => array('HotelLanguage.hotel_id' => $hotel['hotel_id'], 'HotelLanguage.language_id' => $language['Language']['id'], 'HotelLanguage.deleted is null')));
					$request_hotel[$count]['hotel'] = $result['HotelLanguage']['name'];
					$request_hotel[$count]['addr_1'] = $result['HotelLanguage']['addr_1'];
					$request_hotel[$count]['addr_2'] = $result['HotelLanguage']['addr_2'];
					$request_hotel[$count]['addr_3'] = $result['HotelLanguage']['addr_3'];
					$result = $this->HotelRoomLanguage->find('first', array('conditions' => array('HotelRoomLanguage.hotel_room_id' => $hotel['hotel_room_id'], 'HotelRoomLanguage.language_id' => $language['Language']['id'], 'HotelRoomLanguage.deleted is null')));
					$request_hotel[$count]['hotel_room'] = $result['HotelRoomLanguage']['name'];
					$request_hotel[$count] = array_merge($request_hotel[$count], $this->data['RequestHotel'][$count]);
					$request_hotel[$count]['boucher_url'] = "";
					$request_hotel[$count]['count'] = $count + 1;
					$request_hotel[$count]['stay_count'] = $this->calc_difference_day($request_hotel[$count]['checkout'], $request_hotel[$count]['checkin']);
					$result = $this->Hotel->find('first', array('conditions' => array('Hotel.id' => $hotel['hotel_id'], 'Hotel.deleted is null')));
					$request_hotel[$count]['tel'] = $result['Hotel']['tel'];
					$request_hotel[$count]['fax'] = $result['Hotel']['fax'];
					$request_hotel[$count]['email'] = $result['Hotel']['email'];
					$request_hotel[$count]['checkin']['date'] = $this->df($this->isLegalDate($request_hotel[$count]['checkin']));
					$request_hotel[$count]['checkout']['date'] = $this->df($this->isLegalDate($request_hotel[$count]['checkout']));
					$request_hotel[$count]['limit_date']['date'] = $this->dmf($this->isLegalDateTime($request_hotel[$count]['limit_date']));

					$voucher_url = VOUCHER_URL_BASE.$customer_user['CustomerUser']['id'].'/'.base64_encode($customer_user['CustomerUser']['password']).'/'.$request_hotel[$count]['id'].'/';
					$request_hotel[$count]['voucher_url'] = $voucher_url;

					if ($hotel['request_stat_id'] != REQUEST_STAT_NO_VACANCIES && $hotel['request_stat_id'] != REQUEST_STAT_NOVACANCIES_REPAID &&
						$hotel['request_stat_id'] != REQUEST_STAT_CANCEL && $hotel['request_stat_id'] != REQUEST_STAT_CANCEL_REPAID && $hotel['request_stat_id'] != REQUEST_STAT_DELETED) {
						$price += $request_hotel[$count]['price'];
					}
					$all_price += $request_hotel[$count]['price'];

					$cancel_charge = $this->ListGetter->getCancelChargeList($request_hotel[$count]['id']);
					$ct = 0;
					$request_hotel[$count]['cancel_charge'] = array();
					foreach($cancel_charge as $charge) {
						$request_hotel[$count]['cancel_charge'][$ct] = $charge['cancel_charge'];
						$tmp_date = $this->df($request_hotel[$count]['cancel_charge'][$ct]['term_to']);
						$request_hotel[$count]['cancel_charge'][$ct]['term_to'] = $this->ModelUtil->stringDateToArray($request_hotel[$count]['cancel_charge'][$ct]['term_to']);
						$request_hotel[$count]['cancel_charge'][$ct]['term_to']['date'] = $tmp_date;
						$tmp_date = $this->df($request_hotel[$count]['cancel_charge'][$ct]['term_from']);
						$request_hotel[$count]['cancel_charge'][$ct]['term_from'] = $this->ModelUtil->stringDateToArray($request_hotel[$count]['cancel_charge'][$ct]['term_from']);
						$request_hotel[$count]['cancel_charge'][$ct]['term_from']['date'] = $tmp_date;
						$tmp_date = $this->df($request_hotel[$count]['cancel_charge'][$ct]['to_date']);
						$request_hotel[$count]['cancel_charge'][$ct]['to_date'] = $this->ModelUtil->stringDateToArray($request_hotel[$count]['cancel_charge'][$ct]['to_date']);
						$request_hotel[$count]['cancel_charge'][$ct]['to_date']['date'] = $tmp_date;
						$tmp_date = $this->df($request_hotel[$count]['cancel_charge'][$ct]['from_date']);
						$request_hotel[$count]['cancel_charge'][$ct]['from_date'] = $this->ModelUtil->stringDateToArray($request_hotel[$count]['cancel_charge'][$ct]['from_date']);
						$request_hotel[$count]['cancel_charge'][$ct]['from_date']['date'] = $tmp_date;
						$ct++;
					}
				}
				$count++;
			}
			$request['price'] = $price;
			$request['all_price'] = $all_price;

			$cnt = 0;
			$companion = array();
			foreach ($data['RequestHotelCustomerUser'] as $customerUser) {
				$comp = array();
				$count = 0;
				foreach($customerUser as $user) {
					$user['gender'] = $sub_data['gender'][$user['gender_id']];
					$user['adult_name'] = $sub_data['adult'][$user['adult']];
					if (!empty($user['id'])) {
						$user['pax_no'] = $count;
						if ($user['leader'] == REQUEST_CUSTOMER_USER_LEADER) {
							array_unshift($comp, $user);
						} else {
							array_push($comp, $user);
						}
					}
					$count++;
				}
				$companion[$cnt] = $comp;
				$companion[$cnt][0]['pax_count'] = $count;
				$cnt++;
			}

			$email_const = $this->ListGetter->getMiscInfoList($view_iso, EMAIL_CONST);
			$system = array();
			foreach ($email_const as $const) {
				if ($const['mil']['code_id'] == EMAIL_SYTEM_NAME_ID) {
					$system['system_name'] = $const['mil']['name'];
				}
			}
			$this->set('system', $system);
			$this->set('request', $request);
			$this->set('request_hotel', $request_hotel);
			$this->set('companion', $companion);

			$this->MakeTemplateMessage->template = $sub_data['mail_template_name'][$data['MailTemplate']['id']]; // note no '.ctp'
			$this->MakeTemplateMessage->layout_dir = 'email'.DS.'text';
			$messages = $this->MakeTemplateMessage->make_message();
			$message = '';
			foreach ($messages as $msg) {
				$message .= $msg."\n";
			}
			$mail_template['MailTemplateLanguage']['contents'] = $message;
			$this->set('mail_template', $mail_template);
		}
	}

	function send_mail($flg = null) {
		if (!empty($this->data)) {
			$data = $this->data['MailTemplate'];
			$split_to_email = "";

			if ($flg == SEND_MAIL_TO_USER) {
				$split_to_email = preg_split('/,/' , $data['to_email']);
			} else {
				$split_to_email = preg_split('/,/' , $data['test_to_email']);
			}

			foreach ($split_to_email as $to_email) {
				$this->Email->reset();
				if ($flg == SEND_MAIL_TO_USER) {
					$this->Email->bcc = preg_split('/,/' , $data['from_bcc']);
				}
				$this->Email->to = trim($to_email);
				$this->Email->subject = $data['title'];
				$this->Email->replyTo = $data['from_email'];
				$this->Email->from = $data['from_email'];
				$this->Email->template = 'request'; // note no '.ctp'
				// 'html'(HTML)、'text'(テキスト)、または'both'(両方)で送信。(デフォルトは 'text')。
				$this->Email->sendAs = 'text';
				$this->set('mail', array('contents' => $data['contents']));
				// ビュー変数をいつもどおりに渡す。
				$this->Email->smtpOptions = array(
								'port' => REQUEST_EMAIL_PORT,
								'timeout' => REQUEST_EMAIL_TIMEOUT,
								'host' => REQUEST_EMAIL_HOST,
								'username' => REQUEST_EMAIL_USERNAME,
								'password' => REQUEST_EMAIL_PASSWORD
								);
				/* 送信のメソッドをセットする */
				$this->Email->delivery = 'smtp';
				/* send() に変数を渡さないでください。 */
				$this->Email->send();
				/* SMTP エラーを確認する。 */
				$this->set('smtp_errors', $this->Email->smtpError);
			}
		}
	}

	function csv() {
		$base_condition = $this->Session->read(RS_SESSION_BASE);
		if(!empty($this->data)) {

			$this->to_string_post_date($this->data);

			$this->Condition2->set($this->data);
			$this->Session->write(RS_SESSION, $this->data['Condition2']);

			$this->autoRender = false; // Viewを使わないように
			Configure::write('debug', 0); // debugコードを出さないように
			$csv_file = sprintf("request_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
			header ("Content-disposition: attachment; filename=" . $csv_file);
			header ("Content-type: application/octet-stream; name=" . $csv_file);

			$request_data = null;
			$attached_data = null;
			$sub_data = array();

			$this->index(null, REQUEST_CSV_MAX, $request_data, $attached_data, $sub_data);

			$this->replace_data($sub_data);

			$buf = "";
			$delimita = ",";
			$front_delimita =",,,,,,,,,,,,,,,";
			$i = 0;
			$sub_id = 0;
			foreach ($request_data as $req) {
				$count = $sub_id;
				while($count < count($attached_data)) {
					if ($attached_data[$count]['Request']['id'] == $req['Request']['id']) {
						$count++;
					} else {
						break;
					}
				}
				$count -= $sub_id;
				$first_data = true;

				$buf .= $req['Request']['id'] . $delimita;
				$buf .= $req['Request']['first_name'] . $delimita;
				$buf .= $req['Request']['last_name'] . $delimita;
				$buf .= $sub_data['request_stat'][$req['Request']['request_stat_id']] . $delimita;
				$buf .= $req['Request']['tel'] . $delimita;
				$buf .= $req['Request']['tel_mobile'] . $delimita;
				$buf .= $req['Request']['email'] . $delimita;
				$buf .= $req['Request']['email_mobile'] . $delimita;
				$buf .= $this->df($req['Request']['request_date']) . $delimita;
				$buf .= $this->df($req['Request']['fix_date']) . $delimita;
				$buf .= $sub_data['currency'][$req['Request']['currency_id']] . $delimita;
				$buf .= $view_data['Request']['price'] . $delimita;
				$buf .= $sub_data['request_payment'][$req['Request']['request_payment_id']] . $delimita;
				$buf .= $req['Request']['auth_request_id'] . $delimita;
				$buf .= $sub_data['media'][$req['CustomerUser']['media_id']] . $delimita;

				for ($j = $sub_id; $j < $sub_id + $count; $j++) {
					$sub = $attached_data[$j];
					$buf .= $first_data ? '' : $front_delimita; // 上で追加してる要素数のカンマ
					$first_data = false;
					$buf .= $sub['RequestStatLanguage']['name'] . $delimita;
					$buf .= $this->dmf($sub['RequestHotel']['limit_date']) . $delimita;
					$buf .= $this->df($sub['RequestHotel']['checkin']) . $delimita;
					$buf .= $this->df($sub_data['RequestHotel']['checkout']) . $delimita;
					$buf .= $sub['AreaLanguage']['name'] . $delimita;
					$buf .= $sub['CountryLanguage']['name'] . $delimita;
					$buf .= $sub['StateLanguage']['name'] . $delimita;
					$buf .= $sub['CityLanguage']['name'] . $delimita;
					$buf .= $sub['HotelLanguage']['name'] . $delimita;
					$buf .= $sub['HotelRoomLanguage']['name'];
					$buf .= "\r\n";
				}
				$sub_id += $count;
			}
			print($buf); // 出力
		}
		return;
	}

	function replace_data(&$sub_data = array()) {
		$keys = array_keys($sub_data);
		foreach ($keys as $key) {
			$tmp_data = array();
			foreach($sub_data[$key] as $data) {
				if ($key == 'request_stat') {
					$tmp_data[$data['mil']['code_id']] = $data['mil']['name'];
				} else if ($key == 'request_payment') {
					$tmp_data[$data['rpl']['request_payment_id']] = $data['rpl']['name'];
				} else if ($key == 'currency') {
					$tmp_data[$data['currency']['currency_id']] = $data['currency']['iso_code_a'];
				} else if ($key == 'hotel_agent') {
					$tmp_data[$data['hotel_agent']['id']] = $data['hotel_agent']['name'];
				} else if ($key == 'media') {
					$tmp_data[$data['media']['id']] = $data['media']['name'];
				} else  if ($key == 'gender') {
					$tmp_data[$data['gl']['gender_id']] = $data['gl']['name'];
				} else  if ($key == 'country') {
					$tmp_data[$data['cl']['country_id']] = $data['cl']['name_long'];
				} else  if ($key == 'adult') {
					$tmp_data[$data['mil']['code_id']] = $data['mil']['name'];
				} else  if ($key == 'mail_template_name') {
					$tmp_data[$data['mtl']['id']] = $data['mtl']['name'];
				} else  if ($key == 'individual_request_stat') {
					$tmp_data[$data['rsl']['request_stat_id']] = $data['rsl']['name'];
				} else  if ($key == 'area') {
					$tmp_data[$data['al']['area_id']] = $data['al']['name'];
				}
			}
			$sub_data[$key] = $tmp_data;
		}
	}

	function change() {
		if (!empty($this->data)) {
			$data = $this->data['RequestChange'];
			$request_stat_id = $data['request_stat_id'];
			$request_ids = '';
			foreach ($data['checked'] as $chk => $value) {
				if ($value != 0) {
					if (!empty($request_ids)) {
						$request_ids .= ',';
					}
					$request_ids .= $value;
				}
			}
			$sql = sprintf(REQUEST_STAT_ID_CHANGE_SQL, $request_ids);
			$this->Request->query($sql, array($request_stat_id));
		}

		$this->redirect('/request/index/');
	}

	function index($base_condition = null, $limit = RS_VIEW_MAX, &$request_data = null, &$attached_data = null, &$sub_data = null) {
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
		$this->get_view_list_index($view_iso, $sub_data);

		$countrys = array();
		$states = array();
		$citys = array();
		if (!empty($cnd_db['area_id'])) {
			$area_id = empty($cnd_db['area_id']) ? 0 : $cnd_db['area_id'];
			$country_id = empty($cnd_db['country_id']) ? 0 : $cnd_db['country_id'];
			$state_id = empty($cnd_db['state_id']) ? 0 : $cnd_db['state_id'];
			$countrys = $this->ListGetter->getSelectCountryList($view_iso, $area_id);
			$states = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);
			$citys = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);
		}

		$this->set('countrys', $countrys);
		$this->set('states', $states);
		$this->set('citys', $citys);

		// データを取得する
		$whitelist = array(
						'Request.id',
						'Request.first_name',
						'Request.last_name',
						'Request.request_stat_id',
						'Request.tel',
						'Request.tel_mobile',
						'Request.email',
						'Request.email_mobile',
						'Request.request_date',
						'Request.fix_date',
						'Request.currency_id',
						'Request.price',
						'Request.request_payment_id',
						'RequestSettlement.auth_request_id',
						'CustomerUser.media_id',
						'CustomerUser.id',
						'CustomerUser.password',
					);

		$where = $this->makeSearchCondition2($cnd_db);
		$search_cond = array(
			'conditions' => $where,			// 検索条件
			'fields' => $whitelist,			// 取得するカラム
			'page' => 1,					// 数値,最初に表示するページ。デフォルトは1,'last'(小文字)も可*1
			'limit' => $limit,				// 数値：showでも可。デフォルトは20
			'sort' => 'Request.id',			// ソートkey：order*2 でもよい。重なった場合はsortが優先される。
			'joins' => array(				// JOIN条件
				array('type' => 'INNER', 'alias' => 'CustomerUser', 'table' => 'customer_user', 'conditions' => 'Request.customer_user_id = CustomerUser.id AND Request.deleted IS NULL AND CustomerUser.deleted IS NULL'),
				array('type' => 'INNER', 'alias' => 'RequestHotel', 'table' => 'request_hotel', 'conditions' => 'Request.id = RequestHotel.request_id AND RequestHotel.deleted IS NULL') ,
				array('type' => 'INNER', 'alias' => 'Hotel', 'table' => 'hotel', 'conditions' => 'RequestHotel.hotel_id = Hotel.id AND Hotel.deleted IS NULL') ,
				array('type' => 'INNER', 'alias' => 'RequestHotelCustomerUser', 'table' => 'request_hotel_customer_user', 'conditions' => 'Request.id = RequestHotelCustomerUser.request_id AND RequestHotelCustomerUser.deleted IS NULL'),
//				array('type' => 'INNER', 'alias' => 'Language', 'table' => 'language', 'conditions' => 'Language.deleted IS NULL AND Language.iso_code = \''.$this->Session->read(VIEW_ISO_CODE).'\''),
				array('type' => 'INNER', 'alias' => 'AreaLinkCountry', 'table' => 'area_link_country', 'conditions' => 'Hotel.country_id = AreaLinkCountry.country_id AND AreaLinkCountry.deleted IS NULL'),
//				array('type' => 'INNER', 'alias' => 'AreaLanguage', 'table' => 'area_language', 'conditions' => 'AreaLinkCountry.area_id = AreaLanguage.area_id AND Language.id = AreaLanguage.language_id AND AreaLanguage.deleted IS NULL'),
//				array('type' => 'INNER', 'alias' => 'CountryLanguage', 'table' => 'country_language', 'conditions' => 'Hotel.country_id = CountryLanguage.country_id AND Language.id = CountryLanguage.language_id AND CountryLanguage.deleted IS NULL'),
//				array('type' => 'INNER', 'alias' => 'CityLanguage', 'table' => 'city_language', 'conditions' => 'Hotel.city_id = CityLanguage.city_id AND Language.id = CityLanguage.language_id AND CityLanguage.deleted IS NULL'),
//				array('type' => 'LEFT', 'alias' => 'StateLanguage', 'table' => 'state_language', 'conditions' => 'Hotel.state_id = StateLanguage.state_id AND Language.id = StateLanguage.language_id AND StateLanguage.deleted IS NULL'),
				array('type' => 'LEFT', 'alias' => 'RequestSettlement', 'table' => 'request_settlement', 'conditions' => 'Request.id = RequestSettlement.request_id AND RequestSettlement.deleted IS NULL'),
				),
			'order' => array('Request.id' => 'desc'),
			'group' => array(
							'Request.id',
							'Request.first_name',
							'Request.last_name',
							'Request.request_stat_id',
							'Request.tel',
							'Request.tel_mobile',
							'Request.email',
							'Request.email_mobile',
							'Request.request_date',
							'Request.fix_date',
							'Request.currency_id',
							'Request.price',
							'Request.request_payment_id',
							'RequestSettlement.auth_request_id',
							'CustomerUser.media_id',
							'CustomerUser.id',
							'CustomerUser.password',
						),
			'direction' => 'desc'			// asc or desc:デフォルトはasc
			 );
		$this->paginate=$search_cond;
		$request_data = $this->paginate('Request');

		$attached_data = null;

		if (!empty($request_data)) {
			$req_ids = '';
			$count = 0;
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
			$request_data[$count]['CustomerUser']['password'] = base64_encode($request_data[$count]['CustomerUser']['password']);
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
		'request_settlement_id'	=> REQUEST_SETTLEMENT_BOTH,
		'auth_request_id'		=> '',
		);
	}


	function search($page = 1) {
		$base_condition = $this->Session->read(RS_SESSION_BASE);
		if(!empty($this->data)) {

			$this->to_string_post_date($this->data);

			$this->Condition2->set($this->data);
			$this->Session->write(RS_SESSION, $this->data['Condition2']);

			if ($this->Condition2->validates($this->data)) {
				$this->index(null);
				$this->render('/request/index/');
			} else {
				$this->index($base_condition);
				$this->render('/request/index/');
			}
		}
	}

	function to_string_post_date (&$data) {
		$data['Condition2']['request_date_from'] = $this->isLegalDate($data['Condition2']['request_date_from']);
		$data['Condition2']['request_date_to'] = $this->isLegalDate($data['Condition2']['request_date_to']);
		$data['Condition2']['fix_date_from'] = $this->isLegalDate($data['Condition2']['fix_date_from']);
		$data['Condition2']['fix_date_to'] = $this->isLegalDate($data['Condition2']['fix_date_to']);
		$data['Condition2']['checkin_from'] = $this->isLegalDate($data['Condition2']['checkin_from']);
		$data['Condition2']['checkin_to'] = $this->isLegalDate($data['Condition2']['checkin_to']);
		$data['Condition2']['checkout_from'] = $this->isLegalDate($data['Condition2']['checkout_from']);
		$data['Condition2']['checkout_to'] = $this->isLegalDate($data['Condition2']['checkout_to']);
		$data['Condition2']['limit_date_from'] = $this->isLegalDate($data['Condition2']['limit_date_from']);
		$data['Condition2']['limit_date_to'] = $this->isLegalDate($data['Condition2']['limit_date_to']);
	}

	function makeSearchCondition2($cnd) {
		$where = array();
		// request
		if (!empty($cnd['request_date_from']) && !empty($cnd['request_date_to'])) {
			$where = array_merge($where, array('Request.request_date BETWEEN ? AND ?' => array(date($cnd['request_date_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['request_date_from'])))))));
		}
		if (!empty($cnd['fix_date_from']) && !empty($cnd['fix_date_to'])) {
			$where = array_merge($where, array('Request.fix_date BETWEEN ? AND ?' => array(date($cnd['fix_date_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['fix_date_from'])))))));
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
		} else {
			$where = array_merge($where, array("Request.request_stat_id NOT IN (".REQUEST_STAT_DELETED.")"));
		}
		// request_hotel
		if (!empty($cnd['checkin_from']) && !empty($cnd['checkin_to'])) {
			$where = array_merge($where, array('RequestHotel.checkin BETWEEN ? AND ?' => array(date($cnd['checkin_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['checkin_from'])))))));
		}
		if (!empty($cnd['checkout_from']) && !empty($cnd['checkout_to'])) {
			$where = array_merge($where, array('RequestHotel.checkout BETWEEN ? AND ?' => array(date($cnd['checkout_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['checkout_from'])))))));
		}
		if (!empty($cnd['limit_date_from']) && !empty($cnd['limit_date_to'])) {
			$where = array_merge($where, array('RequestHotel.limit_date BETWEEN ? AND ?' => array(date($cnd['limit_date_from']), date(strftime("%Y-%m-%d", strtotime("+1 day", strtotime($cnd['limit_date_from'])))))));
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
		if (!empty($cnd['auth_request_id'])) {
			$where = array_merge($where, array("RequestSettlement.auth_request_id" => $cnd['auth_request_id']));
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
			$likes = array();
			$likes = array_merge($likes, array("Request.message_bord LIKE" => "%" .$cnd['keyword']. "%"));
			$likes = array_merge($likes, array("RequestHotelCustomerUser.first_name LIKE" => "%" .$cnd['keyword']. "%"));
			$likes = array_merge($likes, array("RequestHotelCustomerUser.last_name LIKE" => "%" .$cnd['keyword']. "%"));
			$where = array_merge($where, array("OR" => $likes));
		}

		return array("AND" => $where);
	}

	function save() {
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

		$this->Request->begin();
		if ($this->Request->save($saveRequest, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
			if (empty($saveRequest['id'])) {
				$last_id = $this->Request->getLastInsertID();
			} else {
				$last_id = $saveRequest['id'];
			}
			$whitelist = array_keys($this->RequestHotel->getColumnTypes());
			$count = 0;
			$errors = null;
			$errors_rhcu = null;
			foreach ($saveRequestHotel as $hotel) {
				$this->RequestHotel->create();
				$this->RequestHotel->set($hotel);
				$hotel['request_id'] = $last_id;
				if (!$this->RequestHotel->save($hotel, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$is_break = true;
					$errors[$count] = $this->RequestHotel->validationErrors;
					$this->RequestHotel->validationErrors = $errors;
					break;
				}
				$errors[$count] = array();

				$last_hotel_id = null;
				if (empty($hotel['id'])) {
					$last_hotel_id = $this->RequestHotel->getLastInsertID();
				} else {
					$last_hotel_id = $hotel['id'];
				}

				$whitelist_rhcu = array_keys($this->RequestHotelCustomerUser->getColumnTypes());
				$count_rhcu = 0;
				foreach ($saveRequestHotelCustomerUser[$count] as $user) {
					$this->RequestHotelCustomerUser->create();
					$this->RequestHotelCustomerUser->set($user);
					$user['request_id'] = $last_id;
					$user['request_hotel_id'] = $last_hotel_id;
					if (isset($user['deleted']) && !is_null($user['deleted'])) {
						$whitelist_rhcu = array('id', 'deleted', 'update');
					}
					if (!$this->RequestHotelCustomerUser->save($user, array('validate' => true, 'fieldList' => $whitelist_rhcu, 'callbacks' => true))) {
						$is_break = true;
						$errors_rhcu[$count][$count_rhcu] = $this->RequestHotelCustomerUser->validationErrors;
						break;
					}
					$count_rhcu++;
				}
				$count++;
			}
			$this->RequestHotelCustomerUser->validationErrors = $errors_rhcu;
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
			$this->redirect('/request/index/');
		} else {
			$this->Request->rollback();
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$this->init_data_set();
			$this->get_view_list($view_iso);

			$this->getCustomerUserData($request, $request['customer_user_id']);

			$requestHotel = $this->setHotelDataList($requestHotel);

			$this->set('request', $request);
			$this->set('request_hotel', $requestHotel);
			$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
			$this->set('request_receipt', $requestReceipt);

			$this->render('/request/edit/');
		}
	}

	function makeSaveRequest($request, $requestHotel) {
		$tmpData = array();
		$price = 0;
		$point = 0;

		foreach($requestHotel as $hotel) {
			if ($hotel['request_stat_id'] != REQUEST_STAT_NO_VACANCIES && $hotel['request_stat_id'] != REQUEST_STAT_NOVACANCIES_REPAID &&
				$hotel['request_stat_id'] != REQUEST_STAT_CANCEL && $hotel['request_stat_id'] != REQUEST_STAT_CANCEL_REPAID && $hotel['request_stat_id'] != REQUEST_STAT_DELETED) {
				if (!empty($hotel['price'])) {
					$price += $hotel['price'];
				}
				if (!empty($hotel['point'])) {
					$point += $hotel['point'];
				}
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
		$hotel_top = 0;
		for($cnt_hotel = 0; $cnt_hotel < count($requestHotelCustomerUser); $cnt_hotel++) {
			$leader = false;
			foreach($requestHotelCustomerUser[$cnt_hotel] as $user) {
				$tmpData[$cnt_hotel][$count] = $user;
				// 何か入力があればデータを使用
				if (!empty($user['first_name']) && !empty($user['last_name']) && !empty($user['age'])) {
					$tmpData[$cnt_hotel][$count]['deleted'] = null;
				} else if (empty($user['first_name']) && empty($user['last_name']) && empty($user['age'])) {
					$tmpData[$cnt_hotel][$count]['deleted'] = date('Y-m-d H:i:s');
				}
				if (!$leader && !empty($user['leader']) && $user['leader'] == REQUEST_CUSTOMER_USER_LEADER) {
					$leader = true;
				} else {
					$tmpData[$cnt_hotel][$count]['leader'] = REQUEST_CUSTOMER_USER_OTHER;
				}
				$count++;
			}
			if (!$leader) {
				$tmpData[$cnt_hotel][$count-1]['leader'] = REQUEST_CUSTOMER_USER_LEADER;
			}
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
		$postRequestData = $postdata['Request'];

		$keys = array_keys($this->Request->getColumnTypes());

		// 日付(POST時配列)を文字列に変換
		$postRequestData['request_date'] = $this->isLegalDate($postRequestData['request_date']);
		$postRequestData['fix_date'] = $this->isLegalDate($postRequestData['fix_date']);

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
		$saveRequestHotelData = array();
		$postRequestHotelData = $postdata['RequestHotel'];

		$keys = array_keys($this->RequestHotel->getColumnTypes());

		// 代表者・同行者から、大人・子供の人数をカウント
		$postRequestHotelCustomerUserData = $postdata['RequestHotelCustomerUser'];
		$cnt_adult = 0;
		$cnt_child = 0;
		for ($cnt_hotel = 0; $cnt_hotel < count($postRequestHotelData); $cnt_hotel++) {
			foreach ($postRequestHotelCustomerUserData[$cnt_hotel] as $postRequestHotelCustomerUser) {
				if (!empty($postRequestHotelCustomerUser['first_name']) && !empty($postRequestHotelCustomerUser['last_name']) && !empty($postRequestHotelCustomerUser['age'])) {
					if (array_key_exists('adult', $postRequestHotelCustomerUser)) {
						if ($postRequestHotelCustomerUser['adult'] == REQUEST_CUSTOMER_USER_ADULT) {
							$cnt_adult++;
						} else {
							$cnt_child++;
						}
					}
				}
			}
		}

		$count = 0;
		foreach ($postRequestHotelData as $postRequestHotel) {
			$saveRequestHotel = $this->make_request_hotel_skel();
			// 日付(POST時配列)を文字列に変換
			$checkin = $this->isLegalDate($postdata['RequestHotel'][$count]['checkin']);
			$checkout = $this->isLegalDate($postdata['RequestHotel'][$count]['checkout']);
			$limit_date = $this->isLegalDateTime($postdata['RequestHotel'][$count]['limit_date']);
			if (empty($limit_date)) {
				$limit_date = '0000-00-00 00:00:00';
			}
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
					$saveRequestHotel[$key] = $postdata['Request'][$key];
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
		$postRequestHotelCustomerUserData = $postdata['RequestHotelCustomerUser'];
		$keys = array_keys($this->RequestHotelCustomerUser->getColumnTypes());
		for ($cnt_hotel = 0; $cnt_hotel < count($postRequestHotelCustomerUserData); $cnt_hotel++) {
			$count = 0;
			foreach ($postRequestHotelCustomerUserData[$cnt_hotel] as $postRequestHotelCustomerUser) {
				$saveRequestHotelCustomerUser = $this->make_request_hotel_customer_user_skel();
				foreach ($keys as $key) {
					if (array_key_exists($key, $postRequestHotelCustomerUser)) {
						$saveRequestHotelCustomerUser[$key] = $postRequestHotelCustomerUser[$key];
					} else if ($key == 'comment') {
						$saveRequestHotelCustomerUser[$key] = '';
					}
				}
				$saveRequestHotelCustomerUserData[$cnt_hotel][$count] = $saveRequestHotelCustomerUser;
				$count++;
			}
		}

		return $saveRequestHotelCustomerUserData;
	}

	/***
	 * ポストされたリクエストをスケルトンにコピーする。
	 * ※POSTされない項目を網羅させるため
	 */
	function setSaveRequestReceiptData($postdata) {
		$saveRequestReceiptData = $this->make_request_receipt_skel();
		$postRequestReceiptData = $postdata['RequestReceipt'];

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

		$requestSkel = $this->make_request_skel();
		$requestHotelSkel = $this->make_request_hotel_skel();
		$requestHotelCustomerUserSkel = $this->make_request_hotel_customer_user_skel();
		$requestReceiptSkel = $this->make_request_receipt_skel();

		if (is_null($request_id) || $request_id <= 0) {
			// 引数がない場合、空をセット
			if (empty($this->data)) {
				// リクエストの空データを作成
				$request = $requestSkel;
				// リクエストホテルの空データを作成
				$requestHotel[0] = $requestHotelSkel;
				// 申し込み・同行者情報の空データを作成
				$requestHotelCustomerUser[0][0] = $requestHotelCustomerUserSkel;
				// 領収書の空データを作成
				$requestReceipt = $requestReceiptSkel;
			} else {
				// TODO:POSTデータ分解して再設定用の処理
				$customer_user = $this->data['Request'];
			}
		} else {
			//引数がある場合、データを取得
			$request = $this->Request->query(REQUEST_SQL, array($request_id));
			if (empty($request)) {
				// リクエストの空データを作成
				$request = $requestSkel;
				// リクエストホテルの空データを作成
				$requestHotel[0] = $requestHotelSkel;
				// 申し込み・同行者情報の空データを作成
				$requestHotelCustomerUser[0][0] = $requestHotelCustomerUserSkel;
				// 領収書の空データを作成
				$requestReceipt = $requestReceiptSkel;
			} else {
				foreach ($request as $data) {
					// リクエストはあったが、なぜか不正データの場合
					if (empty($data['request']['id'])) {
						// リクエストの空データを作成
						$request = $requestSkel;
						// リクエストホテルの空データを作成
						$requestHotel[0] = $requestHotelSkel;
						// 申し込み・同行者情報の空データを作成
						$requestHotelCustomerUser[0][0] = $requestHotelCustomerUserSkel;
						// 領収書の空データを作成
						$requestReceipt = $requestReceiptSkel;
						break;
					}
					$this->Request->set($data['request']);
					$request = $data['request'];

					// データが正しそうな場合、リクエストホテルのリストを取得
					$requestHotel = $this->RequestHotel->query(REQUEST_HOTEL_LIST_SQL, array($request_id));
					$count = 0;
					// データが存在する場合データを、存在しない場合空データを詰めてやる
					$tmpRequestHotel = array();
					foreach ($requestHotel as $hotel) {
						if (empty($hotel['request_hotel']['hotel_room_id'])) {
							$tmpRequestHotel[$count] = $requestHotelSkel;
						} else {
							$tmpRequestHotel[$count] = $hotel['request_hotel'];
							if ($tmpRequestHotel[$count]['limit_date'] == '0000-00-00 00:00:00') {
								$tmpRequestHotel[$count]['limit_date'] = '';
							}
						}
						$requestHotel = $tmpRequestHotel;

						$request_hotel_id = $hotel['request_hotel']['id'];

						// データが正しそうな場合、申し込み者・同行者のリストを取得
						$tmpRequestHotelCustomerUser = $this->RequestHotelCustomerUser->query(REQUEST_HOTEL_CUSTOMER_USER_LIST_SQL, array($request_id, $request_hotel_id, ));
						if (empty($tmpRequestHotelCustomerUser)) {
							// リクエストホテルカスタマーユーザーに何も登録されてない場合
							// リクエストホテルカスタマーユーザーの空データを作成
							$requestHotelCustomerUser[$count][0] = $requestHotelCustomerUserSkel;;
						} else {
							// データが存在する場合データを詰めてやる
							$tmpData = array();
							$cnt = 0;
							foreach($tmpRequestHotelCustomerUser as $user) {
								$tmpData[$cnt] = $user['request_hotel_customer_user'];
								$cnt++;
							}
							$requestHotelCustomerUser[$count] = $tmpData;
						}

						$count++;
					}
					$this->RequestHotel->set($requestHotel);

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
		$this->get_view_list($view_iso);

		$this->getCustomerUserData($request, $customer_user_id);

		$requestHotel = $this->setHotelDataList($requestHotel);

		$this->set('request', $request);
		$this->set('request_hotel', $requestHotel);
		$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
		$this->set('request_receipt', $requestReceipt);
	}

	function getCustomerUserData(&$request, $customer_user_id) {
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
				break;
			}
		}
	}

	function setHotelDataList(&$requestHotel, $postData = null) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$country = array();
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
						$room_data[$count] = empty($room_datas) ? null : $room_datas[0];
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
			} else if (!is_null($postData)) {
				$area_id = empty($postData[$count]['area_id']) ? 0 : $postData[$count]['area_id'];
				$country_id = empty($postData[$count]['country_id']) ? 0 : $postData[$count]['country_id'];
				$state_id = empty($postData[$count]['state_id']) ? 0 : $postData[$count]['state_id'];
				$city_id = empty($postData[$count]['city_id']) ? 0 : $postData[$count]['city_id'];
				$town_id = empty($postData[$count]['town_id']) ? 0 : $postData[$count]['town_id'];
				$hotel_id = empty($postData[$count]['hotel_id']) ? 0 : $postData[$count]['hotel_id'];
				$room_id = empty($postData[$count]['room_id']) ? 0 : $postData[$count]['room_id'];
				$agent_id = empty($postData[$count]['agent_id']) ? 0 : $postData[$count]['agent_id'];

				$countrys = $this->ListGetter->getSelectCountryList($view_iso, $area_id);
				$states = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);
				$citys = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);
				$hotels = $this->ListGetter->getSelectHotelList($view_iso, $area_id, $country_id, $state_id, $city_id);
				$rooms = $this->ListGetter->getSelectRoomList($view_iso, $area_id, $country_id, $state_id, $city_id, $hotel_id, $agent_id);
				$room_datas = $this->HotelRoomLanguage->query(SELECT_ROOM_DATA, array($view_iso, $room_id));

				$requestHotel[$count]['area_id'] = $area_id;
				$requestHotel[$count]['country_id'] = $country_id;
				$requestHotel[$count]['state_id'] = $state_id;
				$requestHotel[$count]['city_id'] = $city_id;
				$requestHotel[$count]['town_id'] = $town_id;

				array_unshift($countrys, array('cl'=>array('country_id'=>'0','name_long'=>'')));
				$country[$count] = $countrys;
				array_unshift($states, array('sl'=>array('state_id'=>'0','name'=>'')));
				$state[$count] = $states;
				array_unshift($citys, array('cl'=>array('city_id'=>'0','name'=>'')));
				$city[$count] = $citys;
				array_unshift($hotels, array('hl'=>array('hotel_id'=>'0','name'=>'')));
				$hotel[$count] = $hotels;
				array_unshift($rooms, array('hrl'=>array('hotel_room_id'=>'0','name'=>''), 'rbl'=>array('name'=>'')));
				$hotel_room[$count] = $rooms;
				$room_data[$count] = empty($room_datas) ? null : $room_datas[0];
				$room_data[$count]['count'] = $count;
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

	function calc_difference_day($fromDay, $toDay) {
		$aDay = array(0, 0, 0, $fromDay['month'], $fromDay['day'], $fromDay['year']);
		$bDay = array(0, 0, 0, $toDay['month'], $toDay['day'], $toDay['year']);
		//日付データをUNIXタイムスタンプに変換して、引き算
		$dateDiff = gmmktime($aDay['0'],$aDay['1'],$aDay['2'],$aDay['3'],$aDay['4'],$aDay['5'])
		- gmmktime($bDay['0'],$bDay['1'],$bDay['2'],$bDay['3'],$bDay['4'],$bDay['5']);

		//今は差が秒で出ているので日に変換する
		return $dateDiff / (60 * 60 * 24);
	}

	function make_request_skel() {
		// リクエストの空データを作成
		return $this->ModelUtil->getSkeleton($this->Request);
	}

	function make_request_hotel_skel() {
		// リクエストホテルの空データを作成
		return $this->ModelUtil->getSkeleton($this->RequestHotel);
	}

	function make_request_hotel_customer_user_skel() {
		// 申し込み・同行者情報の空データを作成
		return $this->ModelUtil->getSkeleton($this->RequestHotelCustomerUser);
	}

	function make_request_receipt_skel() {
		return array('request_receipt' => $this->ModelUtil->getSkeleton($this->RequestReceipt));
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
	function get_view_list($view_iso = null, &$sub_data = array()) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 性別を取得
		$sub_data['gender'] = $this->ListGetter->getGenderList($view_iso);
		$this->set('gender', $sub_data['gender']);
		// 国を取得
		$sub_data['country'] = $this->ListGetter->getCountryList($view_iso);
		$this->set('country', $sub_data['country']);
		// 大人/子供取得
		$sub_data['adult'] = $this->ListGetter->getMiscInfoList($view_iso, ADULT);
		$this->set('adult', $sub_data['adult']);
		// 請求書状態取得
		$this->set('receipt_status', $this->ListGetter->getMiscInfoList($view_iso, RECEIPT_STATUS));
		// メールテンプレート名取得
		$sub_data['mail_template_name'] = $this->ListGetter->getMailTemplateNameList($view_iso, REQUEST_MAIL_TEMPLATE);
		$this->set('mail_template_name', $sub_data['mail_template_name']);
		// リクエスト状態取得
		$sub_data['individual_request_stat'] = $this->ListGetter->getRequestStatList($view_iso);
		$this->set('individual_request_stat', $sub_data['individual_request_stat']);
		// 食事タイプ取得
		$this->set('meal_type', $this->ListGetter->getMealTypeList($view_iso));
		// 朝食タイプ取得
		$this->set('breakfast_type', $this->ListGetter->getBreakfastTypeList($view_iso));

		$this->get_view_list_index($view_iso, $sub_data);
	}

	function get_view_list_index($view_iso = null, &$sub_data = array()) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 管理者を取得
		$this->set('admin_user', $this->ListGetter->getAdminUserList());
		// リクエスト状態取得
		$sub_data['request_stat'] = $this->ListGetter->getMiscInfoList($view_iso, REQUEST_CONDITION);
		$this->set('request_stat', $sub_data['request_stat']);
		// 決済状態取得
		$sub_data['request_payment'] = $this->ListGetter->getRequestPaymentList($view_iso);
		$this->set('request_payment', $sub_data['request_payment']);
		// 決済通貨取得
		$sub_data['currency'] = $this->ListGetter->getCurrencyList($view_iso);
		$this->set('currency', $sub_data['currency']);
		// ホテルエージェント(ホールセラー)取得
		$sub_data['hotel_agent'] = $this->ListGetter->getHotelAgentList();
		$this->set('hotel_agent', $sub_data['hotel_agent']);
		// エリア取得
		$area = $this->ListGetter->getAreaList($view_iso);
		$sub_data['area'] = $area;
		array_unshift($area, array('al'=>array('area_id'=>'0','name'=>'')));
		$this->set('area', $area);
		// メディア取得
		$sub_data['media'] = $this->ListGetter->getMediaList();
		$this->set('media', $sub_data['media']);
	}


	function add_request() {
		$add_count = $this->data['AddData']['add_request'];

		$request = $this->setSaveRequestData($this->data);
		$requestHotel = $this->setSaveRequestHotelData($this->data);
		$requestHotelCustomerUser = $this->setSaveRequestHotelCustomerUserData($this->data);
		$requestReceipt = $this->setSaveRequestReceiptData($this->data);

		$add_hotel_no = count($requestHotel);
		for ($i = 0; $i < $add_count; $i++) {
			$requestHotel[] = $this->make_request_hotel_skel();
			$requestHotelCustomerUser[$add_hotel_no + $i][] = $this->make_request_hotel_customer_user_skel();
		}
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		$this->init_data_set();
		$this->get_view_list($view_iso);

		$this->getCustomerUserData($request, $request['customer_user_id']);

		$requestHotel = $this->setHotelDataList($requestHotel, $this->data['RequestHotel']);

		$this->set('request', $request);
		$this->set('request_hotel', $requestHotel);
		$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
		$this->set('request_receipt', $requestReceipt);

		$this->render('/request/edit/');
	}

	function add_companion($add_hotel_no) {
		$add_count = $this->data['AddData']['add_companion'][$add_hotel_no];

		$request = $this->setSaveRequestData($this->data);
		$requestHotel = $this->setSaveRequestHotelData($this->data);
		$requestHotelCustomerUser = $this->setSaveRequestHotelCustomerUserData($this->data);
		$requestReceipt = $this->setSaveRequestReceiptData($this->data);

		for ($i = 0; $i < $add_count; $i++) {
			$requestHotelCustomerUser[$add_hotel_no][] = $this->make_request_hotel_customer_user_skel();
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		$this->init_data_set();
		$this->get_view_list($view_iso);

		$this->getCustomerUserData($request, $request['customer_user_id']);

		$requestHotel = $this->setHotelDataList($requestHotel, $this->data['RequestHotel']);

		$this->set('request', $request);
		$this->set('request_hotel', $requestHotel);
		$this->set('request_hotel_customer_user', $requestHotelCustomerUser);
		$this->set('request_receipt', $requestReceipt);

		$this->render('/request/edit/');
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
	function change_room($room_id, $count, $is_color) {
		if (!$this->RequestHandler->isAjax()) {
			$this->cakeError('error404');
		}

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$room_data = $this->HotelRoomLanguage->query(SELECT_ROOM_DATA, array($view_iso, $room_id));

		// 食事タイプ取得
		$this->set('meal_type', $this->ListGetter->getMealTypeList($view_iso));
		// 朝食タイプ取得
		$this->set('breakfast_type', $this->ListGetter->getBreakfastTypeList($view_iso));
		// 決済通貨取得
		$this->set('currency', $this->ListGetter->getCurrencyList($view_iso));

		Configure::write('debug', 0);
		$this->layout = 'ajax';

		if (count($room_data) >= 1) {
			$room_data[0]['room_data']['count'] = $count;
			$this->set('room_data', $room_data[0]);
			$this->set('is_color', $is_color);
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

}
?>