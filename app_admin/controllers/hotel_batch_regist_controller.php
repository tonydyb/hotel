<?php
class HotelBatchRegistController extends AppController {
	var $name = "HotelBatchRegist";
	var $needAuth = true;	// ログイン必須のフラグ
	var $helpers = array('Construct', 'Javascript');
	var $components = array('ModelUtil', 'ListGetter',);
	var $uses = array(
				'Hotel', 'HotelLanguage', 'HotelAgent', 'AreaLanguage', 'CountryLanguage', 'StateLanguage', 'CityLanguage',
				'HotelFacilityLanguage', 'ViewLanguage', 'HotelLinkFacility', 'HotelGradeLanguage',
				'RoomBedLanguage', 'SmokingLanguage', 'MealTypeLanguage', 'BreakfastTypeLanguage', 'CurrencyLanguage',
				'HotelRoom', 'HotelRoomLanguage', 'HotelRoomLinkRoomFacility', 'RoomFacilityLanguage',
				'HotelImage', 'HotelImageLanguage', 'CancelCharge', 'MiscInfoLanguage', 'HotelEmergencyContact',
				'RoomGradeLanguage', 'AreaLinkCountry', 'Language', 'Country', 'State', 'City', 'RoomBed', 'RoomGrade',
				'Smoking', 'MealType', 'BreakfastType', 'Currency',
				);

	var $citys = array();
	var $areas = array();
	var $use_charset = array();
	var $use_iso = array();

	function beforeFilter() {
		parent::beforeFilter();
		$this->use_charset = array(
								__('English', true) => 'UTF-8',
								__('Japanese', true) => 'SJIS-win',
								__('Traditional Chinese', true) => 'big5',
								__('Simplified Chinese', true) => 'GB2312'
							);
		// TODO:中国語のISOコード
		$this->use_iso = array(
								'UTF-8' => 'en',
								'SJIS-win' => 'ja',
								'big5' => 'zh',
								'GB2312' => 'zh'
							);
	}

	function index() {
		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$language = $this->Language->find('first', array('conditions' => array('Language.iso_code' => $view_iso, 'Language.deleted is null')));

		$view_list = array();
		$view_list['language_id'] = $language['Language']['id'];
		$view_list['use_charset'] = $this->use_charset;

		$this->get_view_list($view_iso, $view_list);
		$this->set_view_list_data($view_list);
	}

	function upload(){
		if (!empty($this->data)) {
			$data = $this->data['Hotel'];
			$func = $data['up_func'];
			$charset = $data['charset'];
			$delimita = null;

			if ($this->data['Hotel']['extension'] == 0) {
				$delimita = ',';
			} else {
				$delimita = "\t";
			}

			if (is_uploaded_file($data['file']['tmp_name'])) {
				if (strlen($data['file']['name']) == mb_strlen($data['file']['name'])) {
					$path = str_replace('/', DS, WWW_ROOT.UPLOAD_FILE_TEMP_DIR);

					if(!file_exists($path)) {
						$this->ModelUtil->mkdirRec($path);
					}
					// アップロードするファイルの場所
					$uploadfile = $path.basename($data['file']['name']);

					// ファイル情報を取得
					$info = pathinfo($uploadfile);
					if ($info['extension'] != 'csv' && $this->data['Hotel']['extension'] == 0) {
						$this->Hotel->validationErrors = array('file' => __('ファイルがCSVファイルではありません。', true));
					} else if ($info['extension'] != 'tsv' && $this->data['Hotel']['extension'] == 1) {
						$this->Hotel->validationErrors = array('file' => __('ファイルがTSVファイルではありません。', true));
					} else if ($info['extension'] != 'csv' && $info['extension'] != 'tsv') {
						$this->Hotel->validationErrors = array('file' => __('ファイルはCSVまたはTSVファイルを使用してください。', true));
					} else {
						// 同じ名前のファイルがすでに存在すれば、別名に変える
						$i = 1;
						while (file_exists($uploadfile)) {
							$i++;
							$file_name = basename($info['basename'],'.'.$info['extension']).'_'.$i.'.'.$info['extension'];
							$uploadfile = $info['dirname'].DS.$file_name;
							$data['file']['name'] = $file_name;
						}

						//画像をテンポラリーの場所から、正式な置き場所へ移動
						if (move_uploaded_file($data['file']['tmp_name'], $uploadfile)){
							chmod($uploadfile, 0777);

							$split_char = null;
							if ($delimita == "\t") {
								// TSV
								$split_char = "/\t/";
							} else {
								// CSV
								$split_char = '/,(?=(([^"]*"){2})*[^"]*$)/';
							}

							switch ($func) {
								case (0):
									$this->save_hotel($charset, $split_char, $delimita, $uploadfile);
									break;
								case (1):
									$this->save_room($charset, $split_char, $delimita, $uploadfile);
									break;
								case (2):
									$this->save_cancel_charge($charset, $split_char, $delimita, $uploadfile);
									break;
								case (3):
									$this->save_emergency_contact($charset, $split_char, $delimita, $uploadfile);
									break;
								default:
									break;
							}
							unlink($uploadfile);
						} else {
							//失敗
							$this->Hotel->validationErrors = array('file' => __('ファイルのアップロードに失敗しました。', true));
						}
					}

				}else{

					$this->Hotel->validationErrors = array('file' => __('ファイル名に全角文字は使用できません。', true));
				}
			} else {

				$this->Hotel->validationErrors = array('file' => __('ファイルをアップロードしてください。', true));
			}

		}
		$this->index();
		$this->render('/hotel_batch_regist/index/');
	}

	function get_code_data(&$codes, $pattern) {
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		if ($pattern == 'hotel' || $pattern == 'room') {
			// 言語コード
			$language = $this->ListGetter->getLanguageList($view_iso);
			$tmp = array();
			foreach ($language as $la) {
				$tmp[$la['ViewLanguage']['iso_code']] = $la['ViewLanguage']['ll_id'];
			}
			$codes['language'] = $tmp;
		}

		if ($pattern == 'room' || $pattern == 'contact') {
			// ホールセラーコード
			$hotel_agent = $this->ListGetter->getHotelAgentList();
			$tmp = array();
			foreach ($hotel_agent as $ha) {
				$tmp[$ha['hotel_agent']['code']] = $ha['hotel_agent']['id'];
			}
			$codes['hotel_agent'] = $tmp;
		}

		if ($pattern == 'hotel') {
			$hotel_grade = $this->ListGetter->getHotelGradeList($view_iso);
			$tmp = array();
			foreach ($hotel_grade as $hg) {
				$tmp[$hg['hg']['code']] = $hg['hgl']['hotel_grade_id'];
			}
			$codes['hotel_grade'] = $tmp;

//			$area = $this->ListGetter->getAreaList($view_iso);
//			$tmp = array();
//			foreach ($area as $ar) {
//				$tmp[$ar['a']['code']] = $ar['al']['area_id'];
//			}
//			$codes['area'] = $tmp;
//
//			$condition = array('Country.deleted is null');
//			$fields = array("id", "iso_code_a3");
//		    $order = "id";
//		    $country = $this->Country->findAll($condition, $fields, $order);
//			$tmp = array();
//			foreach ($country as $co) {
//				$tmp[$co['Country']['iso_code_a3']] = $co['Country']['id'];
//			}
//			$codes['country'] = $tmp;
//
//			$condition = array('State.deleted is null');
//			$fields = array("id", "country_id", "iso_code_a");
//		    $order = "id";
//		    $state = $this->State->findAll($condition, $fields, $order);
//			$tmp = array();
//			foreach ($state as $st) {
//				$tmp[$st['State']['iso_code_a']] = array('id' => $st['State']['id'], 'country_id' => $st['State']['country_id']);
//			}
//			$codes['state'] = $tmp;
//
//			$condition = array('City.deleted is null');
//			$fields = array("id", "country_id", "state_id", "code");
//		    $order = "id";
//		    $city = $this->City->findAll($condition, $fields, $order);
//			$tmp = array();
//			foreach ($city as $ci) {
//				$tmp[$ci['City']['code']] = array('id' => $ci['City']['id'], 'country_id' => $ci['City']['country_id'], 'state_id' => $ci['City']['state_id']);
//			}
//			$codes['city'] = $tmp;
		}
		if ($pattern == 'room') {
			// ホテルコード
			// ホテルは件数が多いので、個別に取得

			// 部屋コード
			$condition = array('RoomBed.deleted is null');
			$fields = array("id", "code");
		    $order = "id";
		    $room_bed = $this->RoomBed->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($room_bed as $rb) {
				$tmp[$rb['RoomBed']['code']] = $rb['RoomBed']['id'];
			}
			$codes['room_bed'] = $tmp;

			// 部屋グレードコード
			$condition = array('RoomGrade.deleted is null');
			$fields = array("id", "code");
		    $order = "id";
		    $room_grade = $this->RoomGrade->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($room_grade as $rg) {
				$tmp[$rg['RoomGrade']['code']] = $rg['RoomGrade']['id'];
			}
			$codes['room_grade'] = $tmp;

			// 喫煙コード
			$condition = array('Smoking.deleted is null');
			$fields = array("id", "code");
		    $order = "id";
		    $smoking = $this->Smoking->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($smoking as $sm) {
				$tmp[$sm['Smoking']['code']] = $sm['Smoking']['id'];
			}
			$codes['smoking'] = $tmp;

			// 食事コード
			$condition = array('MealType.deleted is null');
			$fields = array("id", "code");
		    $order = "id";
		    $meal_type = $this->MealType->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($meal_type as $mt) {
				$tmp[$mt['MealType']['code']] = $mt['MealType']['id'];
			}
			$codes['meal_type'] = $tmp;

			// 朝食コード
			$condition = array('BreakfastType.deleted is null');
			$fields = array("id", "code");
		    $order = "id";
		    $breakfast_type = $this->BreakfastType->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($breakfast_type as $bt) {
				$tmp[$bt['BreakfastType']['code']] = $bt['BreakfastType']['id'];
			}
			$codes['breakfast_type'] = $tmp;

			// 通貨コード
			$condition = array('Currency.deleted is null');
			$fields = array("id", "iso_code_a");
		    $order = "id";
		    $currency = $this->Currency->findAll($condition, $fields, $order);
			$tmp = array();
			foreach ($currency as $cu) {
				$tmp[$cu['Currency']['iso_code_a']] = $cu['Currency']['id'];
			}
			$codes['currency'] = $tmp;
		}
		if ($pattern == 'cancel') {
			$cancel = $this->ListGetter->getMiscInfoList($view_iso, 'cancel_charge_const');
			$tmp = array();
			foreach ($cancel as $ca) {
				$tmp[$ca['mil']['code_id']] = $ca['mil']['name'];
			}
			$codes['cancel_charge_const'] = $tmp;
		}
	}

	function get_hotel_by_code($hotel_code) {
		return $this->Hotel->find('first', array('conditions' => array('Hotel.code' => $hotel_code, 'Hotel.deleted is null')));
	}

	function save_hotel($charset, $split_char, $delimita, $uploadfile) {
		$file = fopen($uploadfile, 'r');
		$is_break = false;

		if ($file) {
			$count = 0;
			$this->Hotel->begin();
			$old_hotel_code = null;	// 直前の保存ホテルcode
			$hotel_id = null;		// DB登録したホテルID
			$this->get_code_data($code_list, 'hotel');
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$hotel_skel = $this->ModelUtil->getSkeleton($this->Hotel);
			$hotel_lang_skel = $this->ModelUtil->getSkeleton($this->HotelLanguage);
			$hotel_facility_skel = $this->ListGetter->getHotelLinkFacilityList($view_iso, -1);

			$old_hotel = null;

			$errors = array();

			while ((!feof($file))) {
				$error_msg = '';
				$hotel = null;
				$hotel_lang = null;
				$hotel_facility = null;
				$line = mb_convert_encoding(fgets($file), "UTF-8", $charset);
				if (!$line && $line != '') {
					$is_break = true;
					break;
				}
				// 先頭は見出しなのでスキップ
				if ($count != 0 && $line != '') {
					$data = preg_split($split_char, $line);
					if (count($data) < HOTEL_UPLOAD_COL_MIN) {
						$error_msg['csv'] = __('ファイル内容が不正です。', true);
					} else {
						// コードで大文字小文字が関係するものを成型
						$data[3] = strtolower($data[3]);		// 言語コード
//						$data[9] = strtolower($data[9]);		// ホテルグレードコード 現在不明
						$data[10] = strtoupper($data[10]);		// 都市コード
//						$data[13] = strtoupper($data[13]);		// 街コード

						// データ登録
						if (empty($data[0]) && (is_null($old_hotel_code) || ($old_hotel_code != $data[1]))) {
							// ホテルID空 かつ 直前保存無し または 直前保存と今回の保存のホテルコードが違う
							// DB登録済みデータを取得するために、ホテルを検索
							$hotel = $this->Hotel->find('first', array('conditions' => array('Hotel.code' => $data[1], 'Hotel.deleted is null')));
						} else if (!empty($data[0]) && (is_null($old_hotel_code) || ($old_hotel_code != $data[1]))) {
							// ホテルIDが埋まっている場合
							// DB登録済みデータを取得するために、ホテルを検索
							$hotel = $this->Hotel->find('first', array('conditions' => array('Hotel.id' => $data[0], 'Hotel.deleted is null')));
						} else if (!is_null($old_hotel_code) || $old_hotel_code == $data[1]) {
							$hotel = $old_hotel;
						}
						$old_hotel = $hotel;
						// 取得したホテルをもとに関連データを取得
						if ($hotel && $hotel['Hotel']) {
							// ホテルがDBにあった場合
							$hotel = $hotel['Hotel'];
							$old_hotel_code = $hotel['code'];
							$hotel_id = $hotel['id'];

							// 関連データ(ホテル言語/ホテル設備)を取得
							$hotel_lang = $this->HotelLanguage->find('first', array('conditions' => array('HotelLanguage.hotel_id' => $hotel_id, 'HotelLanguage.language_id' => $code_list['language'][$data[2]], 'HotelLanguage.deleted is null')));
							if ($hotel_lang && $hotel_lang['HotelLanguage']) {
								$hotel_lang = $hotel_lang['HotelLanguage'];
							}
							$hotel_facility = $this->ListGetter->getHotelLinkFacilityList($view_iso, $hotel_id);
						} else {
							// ホテルがDBに無かった場合
							$hotel = $hotel_skel;
							$hotel_lang = $hotel_lang_skel;
							$hotel_facility = $hotel_facility_skel;
						}
						$tmp_err = $this->hotel_validate($hotel, $hotel_lang, $hotel_facility, $data, $count, $code_list);
						if (!empty($tmp_err)) {
							$error_msg['csv'] = $tmp_err;
						}
						$this->Hotel->create();
						$this->Hotel->set($hotel);
						// 保存処理
						$whitelist = array_keys($this->Hotel->getColumnTypes());
						if ($this->Hotel->validates($hotel)) {
							if (empty($error_msg) && $this->Hotel->save($hotel, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
								if (empty($hotel['id'])) {
									$hotel_id = $this->Hotel->getLastInsertID();
								} else {
									$hotel_id = $hotel['id'];
								}
								// HotelLanguageの保存
								$hotel_lang['hotel_id'] = $hotel_id;
								$this->HotelLanguage->create();
								$this->HotelLanguage->set($hotel_lang);
								$whitelist = array_keys($this->HotelLanguage->getColumnTypes());

								if ($this->HotelLanguage->validates($hotel_lang)) {
									if (empty($error_msg) && !$this->HotelLanguage->save($hotel_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
										$error_msg['hotel_language'] = $this->HotelLanguage->validationErrors;
									} else {
										// HotelLinkFacilityの保存
										$whitelist = array_keys($this->HotelLinkFacility->getColumnTypes());
										$hlf_count = 0;
										foreach ($hotel_facility as $hlfd) {
											$hlfd['hotel_link_facility']['hotel_id'] = $hotel_id;
											$this->HotelLinkFacility->create();
											$this->HotelLinkFacility->set($hlfd['hotel_link_facility']);
											if (!empty($hlfd['hotel_link_facility']['deleted']) || (empty($hlfd['hotel_link_facility']['id']) && !empty($hlfd['hotel_link_facility']['hotel_facility_id']))) {
												if ($this->HotelLinkFacility->validates($hlfd)) {
													if (empty($error_msg) && !$this->HotelLinkFacility->save($hlfd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
														$error_msg['hotel_link_facility'][$hlf_count] = $this->HotelLinkFacility->validationErrors;
													}
												} else {
													$error_msg['hotel_link_facility'][$hlf_count] = $this->HotelLinkFacility->validationErrors;
												}
											}
											$hlf_count++;
										}
									}
								} else {
									$error_msg['hotel_language'] = $this->HotelLanguage->validationErrors;
								}
							} else {
								$error_msg['hotel'] = $this->Hotel->validationErrors;
							}
						} else {
							$error_msg['hotel'] = $this->Hotel->validationErrors;
						}
					}
				}
				if (!empty($error_msg)) {
					$errors[$count] = $error_msg;
					$errors[$count]['prefix'] = $count.__("行目:\n", true);
				}
				$count++;
			}
			if (empty($errors)) {
				$this->Hotel->commit();
			} else {
				$this->Hotel->rollback();
				$this->set('errors', $errors);
			}
			fclose($file);
		}

		if ($is_break) {
			$this->Hotel->validationErrors = array('file' => __('ファイルの読み込みに失敗しました。', true));
		}
	}

	function hotel_validate(&$hotel, &$hotel_lang, &$hotel_facility, $data, $count, &$code_list) {
		$error_msg = '';
		$prefix = __("行目:\n", true);

		// ホテルIDが違う
		if (!empty($data[0]) && empty($hotel['id'])) {
			$error_msg .= __('指定されたホテルIDは存在しません。', true)."\n";
		}
		// ホテルコードが未入力
		if (empty($data[1])) {
			$error_msg .= __('ホテルコードが入力されていません。', true)."\n";
		}
		// 言語コードが未入力/存在しない
		if (empty($data[2])) {
			$error_msg .= __('言語コードが入力されていません。', true)."\n";
		} else if (!array_key_exists($data[2], $code_list['language'])) {
			$error_msg .= __('指定された言語コードは存在しません。', true)."\n";
		} else {
			$data[2] = $code_list['language'][$data[2]];
		}
		// ホテル名が未入力
		if (empty($data[3])) {
			$error_msg .= __('ホテル名が入力されていません。', true)."\n";
		}
		// ホテルグレードコードが未入力/存在しない
		if (empty($data[9])) {
			if (empty($code_list['hotel_grade'])) {
				$data[9] = 0;
			} else {
				$error_msg .= __('ホテルグレードコードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['hotel_grade'])) {
				$data[9] = 0;
			} else if (!array_key_exists($data[9], $code_list['hotel_grade'])) {
				$error_msg .= __('指定されたホテルグレードコードは存在しません。', true)."\n";
			} else {
				$data[9] = $code_list['hotel_grade'][$data[9]];
			}
		}
		// 都市コードが未入力/存在しない
		if (empty($data[10])) {
			$error_msg .= __('都市コードが入力されていません。', true)."\n";
			$data[10] = 0;
		} else {
			if (!array_key_exists($data[10], $this->citys)) {
				$city = $this->City->find('first', array('conditions' => array('City.code' => $data[10], 'City.deleted is null')));
				if (empty($city)) {
					$error_msg .= __('指定された都市コードは存在しません。', true)."\n";
					$data[10] = 0;
				} else {
					$this->citys[$city['City']['code']] = array('country_id' => $city['City']['country_id'], 'state_id' => $city['City']['state_id'], 'city_id' => $city['City']['id'], );
				}
			}
		}
		// 部屋数が未入力の場合、0に
		if (empty($data[15])) {
			$data[15] = 0;
		}
		// スターレートが未入力の場合、0に
		if (empty($data[16])) {
			$data[16] = 0;
		}
		// 表示状態が未入力/存在しない
		if (empty($data[21]) && $data[21] != DISPLAY_STAT_NOTEXIST) {
			$error_msg .= __('表示状態が入力されていません。', true)."\n";
		} else if ($data[21] != DISPLAY_STAT_EXIST && $data[21] != DISPLAY_STAT_NOTEXIST && $data[21] != DISPLAY_STAT_DELETE) {
			$error_msg .= __('指定された表示状態は存在しません。', true)."\n";
		}
		// ホテル設備の数が登録データのほうが多い
		if (count($data) - HOTEL_UPLOAD_COL_MIN > count($hotel_facility)) {
			for ($i = HOTEL_UPLOAD_COL_MIN + count($hotel_facility); $i < count($data); $i++) {
				$chk_data = trim($data[$i]);
				if (!empty($chk_data)) {
					$error_msg .= __('存在しない設備情報を登録しようとしています。', true)."\n";
					break;
				}
			}
		}
		$this->set_hotel_save_data($hotel, $hotel_lang, $hotel_facility, $data, $code_list);

		return empty($error_msg) ? '' : $count.$prefix.$error_msg;
	}

	function room_validate(&$room, &$room_lang, &$room_facility, $data, $count, &$code_list, $hotel_id) {
		$error_msg = '';
		$prefix = __("行目:\n", true);

		// ホテル部屋IDが存在しない
		if (!empty($data[0]) && empty($room['id'])) {
			$error_msg .= __('指定されたホテル部屋IDは存在しません。', true)."\n";
		}
		// ホールセラーコードが未入力/存在しない
		if (empty($data[1])) {
			$error_msg .= __('ホールセラーコードが入力されていません。', true)."\n";
		} else if (!array_key_exists($data[1], $code_list['hotel_agent'])) {
			$error_msg .= __('指定されたホールセラーコードは存在しません。', true)."\n";
		} else {
			$data[1] = $code_list['hotel_agent'][$data[1]];
		}
		// ホテルコードが未入力/存在しない
		if (empty($data[2])) {
			$error_msg .= __('ホテルコードが入力されていません。', true)."\n";
		} else if ($hotel_id < 0) {
			$error_msg .= __('指定されたホテルコードは存在しません。', true)."\n";
		}
		// 言語コードが未入力/存在しない
		if (empty($data[3])) {
			$error_msg .= __('言語コードが入力されていません。', true)."\n";
		} else if (!array_key_exists($data[3], $code_list['language'])) {
			$error_msg .= __('指定された言語コードは存在しません。', true)."\n";
		} else {
			$data[3] = $code_list['language'][$data[3]];
		}
		// 部屋名が未入力
		if (empty($data[4])) {
			$error_msg .= __('ホテル名が入力されていません。', true)."\n";
		}
		// 部屋コードが未入力/存在しない
		if (empty($data[6])) {
			$error_msg .= __('部屋コードが入力されていません。', true)."\n";
		} else if (!array_key_exists($data[6], $code_list['room_bed'])) {
			$error_msg .= __('指定された部屋コードは存在しません。', true)."\n";
		} else {
			$data[6] = $code_list['room_bed'][$data[6]];
		}
		// 部屋グレードコードが未入力/存在しない
		if (empty($data[7])) {
			if (empty($code_list['room_grade'])) {
				$data[7] = 0;
			} else {
				$error_msg .= __('部屋グレードコードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['room_grade'])) {
				$data[7] = 0;
			} else if (!array_key_exists($data[7], $code_list['room_grade'])) {
				$error_msg .= __('指定された部屋グレードコードは存在しません。', true)."\n";
			} else {
				$data[7] = $code_list['room_grade'][$data[7]];
			}
		}
		// バスタブ有無が未入力の場合、0に
		if (empty($data[8])) {
			$data[8] = 0;
		} else {
			$data[8] = 1;
		}
		// 喫煙コードが未入力/存在しない
		if (empty($data[9])) {
			if (empty($code_list['smoking'])) {
				$data[9] = 0;
			} else {
				$error_msg .= __('喫煙コードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['smoking'])) {
				$data[9] = 0;
			} else if (!array_key_exists($data[9], $code_list['smoking'])) {
				$error_msg .= __('指定された喫煙コードは存在しません。', true)."\n";
			} else {
				$data[9] = $code_list['smoking'][$data[9]];
			}
		}
		// 食事コードが未入力/存在しない
		if (empty($data[10])) {
			if (empty($code_list['meal_type'])) {
				$data[10] = 0;
			} else {
				$error_msg .= __('食事コードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['meal_type'])) {
				$data[10] = 0;
			} else if (!array_key_exists($data[10], $code_list['meal_type'])) {
				$error_msg .= __('指定された食事コードは存在しません。', true)."\n";
			} else {
				$data[10] = $code_list['meal_type'][$data[10]];
			}
		}
		// 朝食コードが未入力/存在しない
		if (empty($data[11])) {
			if (empty($code_list['breakfast_type'])) {
				$data[11] = 0;
			} else {
				$error_msg .= __('朝食コードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['breakfast_type'])) {
				$data[11] = 0;
			} else if (!array_key_exists($data[11], $code_list['breakfast_type'])) {
				$error_msg .= __('指定された朝食コードは存在しません。', true)."\n";
			} else {
				$data[11] = $code_list['breakfast_type'][$data[11]];
			}
		}
		// 通貨コード
		if (empty($data[12])) {
			if (empty($code_list['currency'])) {
				$data[12] = 0;
			} else {
				$error_msg .= __('通貨コードが入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['currency'])) {
				$data[12] = 0;
			} else if (!array_key_exists($data[12], $code_list['currency'])) {
				$error_msg .= __('指定された通貨コードは存在しません。', true)."\n";
			} else {
				$data[12] = $code_list['currency'][$data[12]];
			}
		}
		// 価格が未入力の場合、0に
		if (empty($data[13])) {
			$data[13] = 0;
		}
		// ポイントが未入力の場合、0に
		if (empty($data[14])) {
			$data[14] = 0;
		}
		// 手数料が未入力の場合、0に
		if (empty($data[15])) {
			$data[15] = 0;
		}
		// ホテル設備の数が登録データのほうが多い
		if (count($data) - HOTEL_ROOM_UPLOAD_COL_MIN > count($room_facility)) {
			for ($i = HOTEL_ROOM_UPLOAD_COL_MIN + count($room_facility); $i < count($data); $i++) {
				$chk_data = trim($data[$i]);
				if (!empty($chk_data)) {
					$error_msg .= __('存在しない設備情報を登録しようとしています。', true)."\n";
					break;
				}
			}
		}
		$this->set_room_save_data($room, $room_lang, $room_facility, $data, $code_list, $hotel_id);

		return empty($error_msg) ? '' : $count.$prefix.$error_msg;
	}

	function cancel_validate(&$cancel, $data, $count, &$code_list, $hotel_id) {
		$error_msg = '';
		$prefix = __("行目:\n", true);

		// キャンセルポリシーIDが存在しない
		if (!empty($data[0]) && empty($cancel['id'])) {
			$error_msg .= __('指定されたキャンセルポリシーIDは存在しません。', true)."\n";
			$data[0] = 0;
		}
		// ホテルコードが未入力/存在しない
		if (empty($data[1])) {
			$error_msg .= __('ホテルコードが入力されていません。', true)."\n";
			$data[1] = 0;
		} else if ($hotel_id < 0) {
			$error_msg .= __('指定されたホテルコードは存在しません。', true)."\n";
			$data[1] = 0;
		}
		// ソート番号が未入力
		if (empty($data[2]) && $data[2] != 0) {
			$error_msg .= __('ソート番号が入力されていません。', true)."\n";
			$data[2] = 0;
		}
		// 宿泊期間開始が未入力
		if (empty($data[4])) {
			$error_msg .= __('宿泊期間開始が入力されていません。', true)."\n";
		}
		// 宿泊期間終了が未入力
		if (empty($data[5])) {
			$error_msg .= __('宿泊期間終了が入力されていません。', true)."\n";
		}
		// 手数料発生日開始が未入力
		if (empty($data[6]) && $data[6] != 0) {
			$error_msg .= __('手数料発生日開始が入力されていません。', true)."\n";
			$data[6] = 0;
		}
		// 手数料発生日終了が未入力
		if (empty($data[7]) && $data[7] != 0) {
			$error_msg .= __('手数料発生日終了が入力されていません。', true)."\n";
			$data[7] = 0;
		}
		// 手数料内訳が未入力/存在しない
		if (empty($data[8])) {
			if (empty($code_list['cancel_charge_const'])) {
				$data[8] = 0;
			} else {
				$error_msg .= __('手数料内訳が入力されていません。', true)."\n";
			}
		} else {
			if (empty($code_list['cancel_charge_const'])) {
				$data[8] = 0;
			} else if (!array_key_exists($data[8], $code_list['cancel_charge_const'])) {
				$error_msg .= __('指定された手数料内訳は存在しません。', true)."\n";
			}
		}
		// 手数料パーセントが未入力
		if (empty($data[9]) && $data[9] != 0) {
			$error_msg .= __('手数料パーセントが入力されていません。', true)."\n";
			$data[9] = 0;
		}
		$this->set_cancel_save_data($cancel, $data, $code_list, $hotel_id);

		return empty($error_msg) ? '' : $count.$prefix.$error_msg;
	}

	function contact_validate(&$contact, $data, $count, &$code_list, $hotel_id) {
		$error_msg = '';
		$prefix = __("行目:\n", true);

		// 緊急連絡先IDが存在しない
		if (!empty($data[0]) && empty($contact['id'])) {
			$error_msg .= __('指定された緊急連絡先IDは存在しません。', true)."\n";
			$data[0] = 0;
		}
		// ホテルコードが未入力/存在しない
		if (empty($data[1])) {
			$error_msg .= __('ホテルコードが入力されていません。', true)."\n";
			$data[1] = 0;
		} else if ($hotel_id < 0) {
			$error_msg .= __('指定されたホテルコードは存在しません。', true)."\n";
			$data[1] = 0;
		}
		// ホールセラーコードが未入力/存在しない
		if (empty($data[2])) {
			$error_msg .= __('ホールセラーコードが入力されていません。', true)."\n";
			$data[2] = 0;
		} else if (!array_key_exists($data[2], $code_list['hotel_agent'])) {
			$error_msg .= __('指定されたホールセラーコードは存在しません。', true)."\n";
			$data[2] = 0;
		} else {
			$data[2] = $code_list['hotel_agent'][$data[2]];
		}
		// 緊急連絡先名が未入力
		if (empty($data[3])) {
			$error_msg .= __('緊急連絡先名が入力されていません。', true)."\n";
		}
		// ソート番号が未入力
		if (empty($data[4])) {
			$error_msg .= __('ソート番号が入力されていません。', true)."\n";
			$data[4] = 0;
		}
		// 都市コードが未入力/存在しない
		if (empty($data[5])) {
			$error_msg .= __('都市コードが入力されていません。', true)."\n";
			$data[5] = 0;
		} else {
			if (!array_key_exists($data[5], $this->citys)) {
				$city = $this->City->find('first', array('conditions' => array('City.code' => $data[5], 'City.deleted is null')));
				if (empty($city)) {
					$error_msg .= __('指定された都市コードは存在しません。', true)."\n";
					$data[5] = 0;
				} else {
					$this->citys[$city['City']['code']] = array('country_id' => $city['City']['country_id'], 'state_id' => $city['City']['state_id'], 'city_id' => $city['City']['id'], );
				}
			}
		}
		// 緊急連絡先国際電話国番号が未入力
		if (empty($data[11])) {
			$error_msg .= __('緊急連絡先国際電話国番号が入力されていません。', true)."\n";
			$data[11] = 0;
		}
		// 緊急連絡先電話番号が未入力
		if (empty($data[12])) {
			$error_msg .= __('緊急連絡先電話番号が入力されていません。', true)."\n";
			$data[12] = 0;
		}
		$this->set_contact_save_data($contact, $data, $code_list, $hotel_id);

		return empty($error_msg) ? '' : $count.$prefix.$error_msg;
	}

	function set_contact_save_data(&$contact, $data, &$code_list, $hotel_id) {
		$data = $this->remove_double_quart($data);

		$contact['id'] = $contact['id'];		// 緊急連絡先ID
		$contact['hotel_id'] = $hotel_id;		// ホテルコード
		$contact['hotel_agent_id'] = $data[2];		// ホールセラーコード
		$contact['name'] = $data[3];		// 緊急連絡先名
		$contact['sort_no'] = $data[4];		// ソート番号
		// エリアコード
		if (array_key_exists($this->citys[$data[5]]['country_id'], $this->areas)) {
			$contact['area_id'] = $this->areas($this->citys[$data[5]]['country_id']);
		} else {
			$area_link_country = $this->AreaLinkCountry->find('first', array('conditions' => array('AreaLinkCountry.country_id' => $this->citys[$data[5]]['country_id'], 'AreaLinkCountry.deleted is null')));
			$contact['area_id'] = $area_link_country['AreaLinkCountry']['area_id'];
			$this->areas[$area_link_country['AreaLinkCountry']['country_id']] = $area_link_country['AreaLinkCountry']['area_id'];
		}
		// 国コード, 州コード, 都市コード
		if (array_key_exists($data[5], $this->citys)) {
			$contact['country_id'] = $this->citys[$data[5]]['country_id'];		// 国コード
			$contact['state_id'] = $this->citys[$data[5]]['state_id'];		// 州コード
			$contact['city_id'] = $this->citys[$data[5]]['city_id'];		// 都市コード
		}
		$contact['addr_1'] = $data[6];		// 緊急連絡先住所1
		$contact['addr_2'] = $data[7];		// 緊急連絡先住所2
		$contact['addr_3'] = $data[8];		// 緊急連絡先住所3
		$contact['remarks'] = $data[9];		// 備考
		$contact['postcode'] = $data[10];		// 緊急連絡先郵便番号
		$contact['tel_country_code'] = $data[11];		// 緊急連絡先国際電話国番号
		$contact['tel'] = $data[12];		// 緊急連絡先電話番号
	}

	function set_cancel_save_data(&$cancel, $data, &$code_list, $hotel_id) {
		$data = $this->remove_double_quart($data);

		$cancel['id'] = $cancel['id'];		// ホテル部屋ID
		$cancel['hotel_id'] = $hotel_id;		// ホテルコード
		$cancel['sort_no'] = $data[2];		// ソート番号
		$cancel['remarks'] = $data[3];		// 備考
		$cancel['term_from'] = $data[4];		// 宿泊期間開始
		$cancel['term_to'] = $data[5];		// 宿泊期間終了
		$cancel['charge_occur_from'] = $data[6];		// 手数料発生日開始
		$cancel['charge_occur_to'] = $data[7];		// 手数料発生日終了
		$cancel['charge_stat_id'] = $data[8];		// 手数料内訳
		$cancel['charge_percent'] = $data[9];		// 手数料パーセント
	}

	function set_room_save_data(&$room, &$room_lang, &$room_facility, $data, &$code_list, $hotel_id) {
		$data = $this->remove_double_quart($data);

		$room['id'] = $room['id'];		// ホテル部屋ID
		$room['hotel_agent_id'] = $data[1];		// ホールセラーコード
		$room['hotel_id'] = $hotel_id;		// ホテルコード
		$room_lang['id'] = $room_lang['id'];
		$room_lang['language_id'] = $data[3];		// 言語コード
		$room_lang['name'] = $data[4];		// 部屋名
		$room_lang['comment'] = $data[5];		// 部屋備考
		$room['room_bed_id'] = $data[6];		// 部屋コード
		$room['room_grade_id'] = $data[7];		// 部屋グレードコード
		$room['room_bath_id'] = $data[8];		// バスタブ有無
		$room['smoking_id'] = $data[9];		// 喫煙コード
		$room['meal_type_id'] = $data[10];		// 食事コード
		$room['breakfast_type_id'] = $data[11];		// 朝食コード
		$room['currency_id'] = $data[12];		// 通貨コード
		$room['price'] = $data[13];		// 価格
		$room['point'] = $data[14];		// ポイント
		$room['commission'] = $data[15];		// 手数料

		for ($i = 0; $i < count($room_facility); $i++) {
			$chk_data = trim($data[$i + HOTEL_ROOM_UPLOAD_COL_MIN]);
			if (!empty($chk_data)) {
				$room_facility[$i]['room_link_facility']['hotel_room_id'] = $data[0];
				$room_facility[$i]['room_link_facility']['room_facility_id'] = $room_facility[$i]['room_link_facility']['facility_id'];
				$room_facility[$i]['room_link_facility']['deleted'] = null;
			} else {
				if (!empty($hotel_facility[$i]['room_link_facility']['id'])) {
					$room_facility[$i]['room_link_facility']['hotel_room_id'] = $data[0];
					$room_facility[$i]['room_link_facility']['room_facility_id'] = $room_facility[$i]['room_link_facility']['facility_id'];
					$room_facility[$i]['room_link_facility']['deleted'] = date('Y-m-d H:i:s');
				}
			}
		}
	}

	function set_hotel_save_data(&$hotel, &$hotel_lang, &$hotel_facility, $data, &$code_list) {
		$data = $this->remove_double_quart($data);

		$hotel['id'] = $hotel['id'];	// ホテルID
		$hotel['code'] = $data[1];	// ホテルコード
		$hotel_lang['id'] = $hotel_lang['id'];	// ホテル言語ID
		$hotel_lang['hotel_id'] = $hotel['id'];
		$hotel_lang['language_id'] = $data[2];	// 言語コード
		$hotel_lang['name'] = $data[3];	// ホテル名
		$hotel_lang['comment'] = $data[4];	// ホテルコメント
		$hotel_lang['location_comment'] = $data[5];	// ホテルロケーションコメント
		$hotel_lang['addr_1'] = $data[6];	// ホテル住所1
		$hotel_lang['addr_2'] = $data[7];	// ホテル住所2
		$hotel_lang['addr_3'] = $data[8];	// ホテル住所3
		$hotel['hotel_grade_id'] = $data[9];	// ホテルグレードコード
		// 国コード, 州コード, 都市コード, 街コード
		if (array_key_exists($data[10], $this->citys)) {
			$hotel['country_id'] = $this->citys[$data[10]]['country_id'];		// 国コード
			$hotel['state_id'] = $this->citys[$data[10]]['state_id'];		// 州コード
			$hotel['city_id'] = $this->citys[$data[10]]['city_id'];		// 都市コード
			$hotel['town_id'] = 0;	// 街コード
		}
		$hotel['tel'] = $data[11];	// 電話番号
		$hotel['fax'] = $data[12];	// FAX
		$hotel['email'] = $data[13];	// email
		$hotel['postcode'] = $data[14];	// 郵便番号
		$hotel['total_room_number'] = $data[15];	// 部屋数
		$hotel['star_rate'] = $data[16];	// スターレート
		$hotel['latitude'] = $data[17];	// 緯度
		$hotel['longitude'] = $data[18];	// 経度
		$hotel['checkin'] = $data[19];	// チェックイン
		$hotel['checkout'] = $data[20];	// チェックアウト
		$hotel['display_stat'] = $data[21];	// 表示状態
		for ($i = 0; $i < count($hotel_facility); $i++) {
			$chk_data = trim($data[$i + HOTEL_UPLOAD_COL_MIN]);
			if (!empty($chk_data)) {
				$hotel_facility[$i]['hotel_link_facility']['hotel_id'] = $data[0];
				$hotel_facility[$i]['hotel_link_facility']['hotel_facility_id'] = $hotel_facility[$i]['hotel_link_facility']['facility_id'];
				$hotel_facility[$i]['hotel_link_facility']['deleted'] = null;
			} else {
				if (!empty($hotel_facility[$i]['hotel_link_facility']['id'])) {
					$hotel_facility[$i]['hotel_link_facility']['hotel_id'] = $data[0];
					$hotel_facility[$i]['hotel_link_facility']['hotel_facility_id'] = $hotel_facility[$i]['hotel_link_facility']['facility_id'];
					$hotel_facility[$i]['hotel_link_facility']['deleted'] = date('Y-m-d H:i:s');
				}
			}
		}
	}

	function save_room($charset, $split_char, $delimita, $uploadfile) {
		$file = fopen($uploadfile, 'r');
		$is_break = false;

		if ($file) {
			$count = 0;
			$this->HotelRoom->begin();
			$old_hotel_code = null;	// 直前の保存ホテルcode
			$hotel_id = null;		// DB登録したホテルID
			$room_id = null;
			$this->get_code_data($code_list, 'room');
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$room_skel = $this->ModelUtil->getSkeleton($this->HotelRoom);
			$room_lang_skel = $this->ModelUtil->getSkeleton($this->HotelRoomLanguage);
			$room_facility_skel = $this->ListGetter->getRoomLinkFacilityList($view_iso, -1);

			$errors = array();

			while ((!feof($file))) {
				$error_msg = '';
				$room = null;
				$room_lang = null;
				$room_facility = null;
				$line = mb_convert_encoding(fgets($file), "UTF-8", $charset);
				if (!$line && $line != '') {
					$is_break = true;
					break;
				}
				// 先頭は見出しなのでスキップ
				if ($count != 0 && $line != '') {
					$data = preg_split($split_char, $line);
					if (count($data) < HOTEL_ROOM_UPLOAD_COL_MIN) {
						$error_msg['csv'] = __('ファイル内容が不正です。', true);
					} else {
						// コードで大文字小文字が関係するものを成型
//						$data[1] = strtoupper($data[1]);		// ホールセラーコード
						$data[3] = strtolower($data[3]);		// 言語コード
						$data[6] = strtoupper($data[6]);		// 部屋コード
						$data[7] = strtoupper($data[7]);		// 部屋グレードコード
						$data[9] = strtoupper($data[9]);		// 喫煙コード
						$data[10] = strtoupper($data[10]);		// 食事コード
//						$data[11] = strtoupper($data[11]);		// 朝食コード
						$data[12] = strtoupper($data[12]);		// 通貨コード

						// データ登録
						if (empty($data[0])) {
							if (is_null($old_hotel_code) || ($old_hotel_code != $data[2])) {
								// ホテル部屋ID空 かつ 直前保存無し または 直前保存と今回の保存のホテルコードが違う
								// DBからホテルを検索
								$hotel = $this->get_hotel_by_code($data[2]);
								if (!empty($hotel) && !empty($hotel['Hotel'])) {
									$hotel_id = $hotel['Hotel']['id'];
								} else {
									$hotel_id = -1;
								}
							}
						} else if (!empty($data[0])) {
							// ホテル部屋IDが埋まっている場合
							// DB登録済みデータを取得するために、ホテル部屋を検索
							$room = $this->HotelRoom->find('first', array('conditions' => array('HotelRoom.id' => $data[0], 'HotelRoom.deleted is null')));
						}
						// 取得したホテル部屋をもとに関連データを取得
						if ($room && $room['HotelRoom']) {
							// ホテル部屋がDBにあった場合
							$room = $room['HotelRoom'];
							$hotel_id = $room['hotel_id'];
							$room_id =  $room['id'];

							// 関連データ(ホテル部屋言語/ホテル部屋設備)を取得
							$room_lang = $this->HotelRoomLanguage->find('first', array('conditions' => array('HotelRoomLanguage.hotel_room_id' => $room['id'], 'HotelRoomLanguage.language_id' => $code_list['language'][$data[3]], 'HotelRoomLanguage.deleted is null')));
							if ($room_lang && $room_lang['HotelRoomLanguage']) {
								$room_lang = $room_lang['HotelRoomLanguage'];
							}
							$room_facility = $this->ListGetter->getRoomLinkFacilityList($view_iso, $room_id);
						} else {
							// ホテルがDBに無かった場合
							$room = $room_skel;
							$room_lang = $room_lang_skel;
							$room_facility = $room_facility_skel;
						}
						$old_hotel_code = $data[2];
						$tmp_err = $this->room_validate($room, $room_lang, $room_facility, $data, $count, $code_list, $hotel_id);
						if (!empty($tmp_err)) {
							$error_msg['csv'] = $tmp_err;
						}
						$this->HotelRoom->create();
						$this->HotelRoom->set($room);
						// 保存処理
						$whitelist = array_keys($this->HotelRoom->getColumnTypes());
						if ($this->HotelRoom->validates($room)) {
							if (empty($error_msg) && $this->HotelRoom->save($room, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
								if (empty($room['id'])) {
									$room_id = $this->HotelRoom->getLastInsertID();
								} else {
									$room_id = $room['id'];
								}
								// HotelLanguageの保存
								$room_lang['hotel_room_id'] = $room_id;
								$this->HotelRoomLanguage->create();
								$this->HotelRoomLanguage->set($room_lang);
								$whitelist = array_keys($this->HotelRoomLanguage->getColumnTypes());

								if ($this->HotelRoomLanguage->validates($room_lang)) {
									if (empty($error_msg) && !$this->HotelRoomLanguage->save($room_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
										$error_msg['room_language'] = $this->HotelRoomLanguage->validationErrors;
									} else {
										// HotelLinkFacilityの保存
										$whitelist = array_keys($this->HotelRoomLinkRoomFacility->getColumnTypes());
										$rlf_count = 0;
										foreach ($room_facility as $rlfd) {
											$rlfd['room_link_facility']['hotel_room_id'] = $room_id;
											$this->HotelRoomLinkRoomFacility->create();
											$this->HotelRoomLinkRoomFacility->set($rlfd['room_link_facility']);
											if (!empty($rlfd['room_link_facility']['deleted']) || (empty($rlfd['room_link_facility']['id']) && !empty($rlfd['room_link_facility']['room_facility_id']))) {
												if ($this->HotelRoomLinkRoomFacility->validates($rlfd)) {
													if (empty($error_msg) && !$this->HotelRoomLinkRoomFacility->save($rlfd, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
														$error_msg['room_link_facility'][$rlf_count] = $this->HotelRoomLinkRoomFacility->validationErrors;
													}
												} else {
													$error_msg['room_link_facility'][$rlf_count] = $this->HotelRoomLinkRoomFacility->validationErrors;
												}
											}
											$rlf_count++;
										}
									}
								} else {
									$error_msg['room_language'] = $this->HotelRoomLanguage->validationErrors;
								}
							} else {
								$error_msg['room'] = $this->HotelRoom->validationErrors;
							}
						} else {
							$error_msg['room'] = $this->HotelRoom->validationErrors;
						}
					}
				}
				if (!empty($error_msg)) {
					$errors[$count] = $error_msg;
					$errors[$count]['prefix'] = $count.__("行目:\n", true);
				}
				$count++;
			}
			if (empty($errors)) {
				$this->HotelRoom->commit();
			} else {
				$this->HotelRoom->rollback();
				$this->set('errors', $errors);
			}
			fclose($file);
		}

		if ($is_break) {
			$this->Hotel->validationErrors = array('file' => __('ファイルの読み込みに失敗しました。', true));
		}
	}

	function save_cancel_charge($charset, $split_char, $delimita, $uploadfile) {
		$file = fopen($uploadfile, 'r');
		$is_break = false;

		if ($file) {
			$count = 0;
			$this->CancelCharge->begin();
			$old_hotel_code = null;	// 直前の保存ホテルcode
			$hotel_id = null;		// DB登録したホテルID
			$this->get_code_data($code_list, 'cancel');
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$cancel_skel = $this->ModelUtil->getSkeleton($this->CancelCharge);

			$errors = array();

			while ((!feof($file))) {
				$error_msg = '';
				$cancel = null;
				$line = mb_convert_encoding(fgets($file), "UTF-8", $charset);
				if (!$line && $line != '') {
					$is_break = true;
					break;
				}
				// 先頭は見出しなのでスキップ
				if ($count != 0 && $line != '') {
					$data = preg_split($split_char, $line);
					if (count($data) < CANCEL_CHARGE_UPLOAD_COL_MIN) {
						$error_msg['csv'] = __('ファイル内容が不正です。', true);
					} else {
						// データ登録
						if (empty($data[0])) {
							if (is_null($old_hotel_code) || ($old_hotel_code != $data[1])) {
								// ホテルID空 かつ 直前保存無し または 直前保存と今回の保存のホテルコードが違う
								// DBからホテルを検索
								$hotel = $this->get_hotel_by_code($data[1]);
								if (!empty($hotel) && !empty($hotel['Hotel'])) {
									$hotel_id = $hotel['Hotel']['id'];
								} else {
									$hotel_id = -1;
								}
							}
							$cancel = $cancel_skel;
						} else if (!empty($data[0])) {
							// キャンセルポリシーIDが埋まっている場合
							// DB登録済みデータを取得するために、キャンセルチャージを検索
							$cancel = $this->CancelCharge->find('first', array('conditions' => array('CancelCharge.id' => $data[0], 'CancelCharge.deleted is null')));
							$cancel = $cancel['CancelCharge'];
							$hotel_id = $cancel['hotel_id'];
						}
						$old_hotel_code = $data[1];
						$tmp_err = $this->cancel_validate($cancel, $data, $count, $code_list, $hotel_id);
						if (!empty($tmp_err)) {
							$error_msg['csv'] = $tmp_err;
						}
						$this->CancelCharge->create();
						$this->CancelCharge->set($cancel);
						// 保存処理
						$whitelist = array_keys($this->CancelCharge->getColumnTypes());
						if ($this->CancelCharge->validates($cancel)) {
							if (empty($error_msg) && !$this->CancelCharge->save($cancel, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
								$error_msg['cancel'] = $this->CancelCharge->validationErrors;
							}
						} else {
							$error_msg['cancel'] = $this->CancelCharge->validationErrors;
						}
					}
				}
				if (!empty($error_msg)) {
					$errors[$count] = $error_msg;
					$errors[$count]['prefix'] = $count.__("行目:\n", true);
				}
				$count++;
			}
			if (empty($errors)) {
				$this->CancelCharge->commit();
			} else {
				$this->CancelCharge->rollback();
				$this->set('errors', $errors);
			}
			fclose($file);
		}

		if ($is_break) {
			$this->Hotel->validationErrors = array('file' => __('ファイルの読み込みに失敗しました。', true));
		}
	}

	function save_emergency_contact($charset, $split_char, $delimita, $uploadfile) {
		$file = fopen($uploadfile, 'r');
		$is_break = false;

		if ($file) {
			$count = 0;
			$this->HotelEmergencyContact->begin();
			$old_hotel_code = null;	// 直前の保存ホテルcode
			$hotel_id = null;		// DB登録したホテルID
			$this->get_code_data($code_list, 'contact');
			$view_iso = $this->Session->read(VIEW_ISO_CODE);

			$contact_skel = $this->ModelUtil->getSkeleton($this->HotelEmergencyContact);

			$errors = array();

			while ((!feof($file))) {
				$error_msg = '';
				$contact = null;
				$line = mb_convert_encoding(fgets($file), "UTF-8", $charset);
				if (!$line && $line != '') {
					$is_break = true;
					break;
				}
				// 先頭は見出しなのでスキップ
				if ($count != 0 && $line != '') {
					$data = preg_split($split_char, $line);
					if (count($data) < EMERGENCY_CONTACT_UPLOAD_COL_MIN) {
						$error_msg['csv'] = __('ファイル内容が不正です。', true);
					} else {
						// データ登録
						if (empty($data[0])) {
							if (is_null($old_hotel_code) || ($old_hotel_code != $data[1])) {
								// ホテルID空 かつ 直前保存無し または 直前保存と今回の保存のホテルコードが違う
								// DBからホテルを検索
								$hotel = $this->get_hotel_by_code($data[1]);
								if (!empty($hotel) && !empty($hotel['Hotel'])) {
									$hotel_id = $hotel['Hotel']['id'];
								} else {
									$hotel_id = -1;
								}
							}
							$contact = $contact_skel;
						} else if (!empty($data[0])) {
							// キャンセルポリシーIDが埋まっている場合
							// DB登録済みデータを取得するために、キャンセルチャージを検索
							$contact = $this->HotelEmergencyContact->find('first', array('conditions' => array('HotelEmergencyContact.id' => $data[0], 'HotelEmergencyContact.deleted is null')));
							$contact = $contact['HotelEmergencyContact'];
							$hotel_id = $contact['hotel_id'];
						}
						$old_hotel_code = $data[1];
						$tmp_err = $this->contact_validate($contact, $data, $count, $code_list, $hotel_id);
						if (!empty($tmp_err)) {
							$error_msg['csv'] = $tmp_err;
						}
						$this->HotelEmergencyContact->create();
						$this->HotelEmergencyContact->set($contact);

						// 保存処理
						$whitelist = array_keys($this->HotelEmergencyContact->getColumnTypes());
						if ($this->HotelEmergencyContact->validates($contact)) {
							if (empty($error_msg) && !$this->HotelEmergencyContact->save($contact, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
								$error_msg['contact'] = $this->HotelEmergencyContact->validationErrors;
							}
						} else {
							$error_msg['contact'] = $this->HotelEmergencyContact->validationErrors;
						}
					}
				}
				if (!empty($error_msg)) {
					$errors[$count] = $error_msg;
					$errors[$count]['prefix'] = $count.__("行目:\n", true);
				}
				$count++;
			}
			if (empty($errors)) {
				$this->HotelEmergencyContact->commit();
			} else {
				$this->HotelEmergencyContact->rollback();
				$this->set('errors', $errors);
			}
			fclose($file);
		}

		if ($is_break) {
			$this->Hotel->validationErrors = array('file' => __('ファイルの読み込みに失敗しました。', true));
		}
	}

	function remove_double_quart($data) {
		if (is_array($data)) {
			$keys = array_keys($data);
			$result = array();
			foreach ($keys as $key) {
				$result[$key] = $this->_remove_dauble_quart($data[$key]);
			}
			return $result;
		} else {
			return $this->_remove_dauble_quart($data);
		}
	}

	function _remove_dauble_quart($data) {
		$pattern0 ='""';
		$pattern1 = '^".*"$';
		$pattern2 = '^"|"$';
		$data = mb_eregi_replace($pattern0, '"', $data);
		if (mb_ereg($pattern1 , $data)) {
			return trim(mb_eregi_replace($pattern2, '', $data));
		} else {
			return trim($data);
		}
	}

	function download() {
		if (!empty($this->data)) {
			$func = $this->data['Hotel']['down_func'];
			$charset = $this->data['Hotel']['charset'];
			$extension = null;
			$iso_code = $this->use_iso[$charset];

			if ($this->data['Hotel']['extension'] == 0) {
				$extension = ',';
			} else {
				$extension = "\t";
			}

			switch ($func) {
				case (0):
					$this->hotel_upload_skeleton_download($charset, $extension);
					break;
				case (1):
					$this->hotel_room_upload_skeleton_download($charset, $extension);
					break;
				case (2):
					$this->cancel_charge_upload_skeleton_download($charset, $extension);
					break;
				case (3):
					$this->hotel_emergency_contact_upload_skeleton_download($charset, $extension);
					break;
				case (10):
					$this->town_data_download($charset, $extension, $iso_code);
					break;
				case (11):
					$this->hotl_agent_download($charset, $extension, $iso_code);
					break;
				case (12):
					$this->language_download($charset, $extension, $iso_code);
					break;
				case (13):
					$this->hotel_grade_download($charset, $extension, $iso_code);
					break;
				case (14):
					$this->room_bed_download($charset, $extension, $iso_code);
					break;
				case (15):
					$this->smoking_download($charset, $extension, $iso_code);
					break;
				case (16):
					$this->meal_type_download($charset, $extension, $iso_code);
					break;
				case (17):
					$this->breakfast_type_download($charset, $extension, $iso_code);
					break;
				case (18):
					$this->currency_download($charset, $extension, $iso_code);
					break;
				case (19):
					$this->room_grade_download($charset, $extension, $iso_code);
					break;
				case (20):
					$this->cancel_charge_const_download($charset, $extension, $iso_code);
					break;
				default:
					break;
			}
		}
	}

	function get_view_list($view_iso = null, &$view_list = array()) {
		if (is_null($view_iso)) {
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		$download_name = array(
			'0' => __('ホテル一括登録雛型', true),
			'1' => __('ホテル部屋一括登録雛型', true),
			'2' => __('キャンセルポリシー一括登録雛型', true),
			'3' => __('緊急連絡先一括登録雛型', true),
			'10' => __('都市データCSV', true),
			'11' => __('ホールセラーデータCSV', true),
			'12' => __('言語データCSV', true),
			'13' => __('ホテルグレードデータCSV', true),
			'14' => __('部屋データCSV', true),
			'15' => __('喫煙データCSV', true),
			'16' => __('食事データCSV', true),
			'17' => __('朝食データCSV', true),
			'18' => __('通貨データCSV', true),
			'19' => __('部屋グレードデータCSV', true),
			'20' => __('手数料内訳データCSV', true),
		);

		$upload_name = array(
			'0' => __('ホテル', true),
			'1' => __('ホテル部屋', true),
			'2' => __('キャンセルポリシー', true),
			'3' => __('緊急連絡先', true),
		);

		$file_extension = array(
			'0' => __('CSV(カンマ区切り)', true),
			'1' => __('TSV(タブ区切り)', true),
		);

		$view_list['download_name'] = $download_name;
		$view_list['upload_name'] = $upload_name;
		$view_list['file_extension'] = $file_extension;
		$view_list['hotel_facility'] = $this->ListGetter->getHotelFacilityList($view_iso);
		$view_list['meal_type'] = $this->ListGetter->getMealTypeList($view_iso);
		$view_list['breakfast_type'] = $this->ListGetter->getBreakfastTypeList($view_iso);
		$view_list['currency'] = $this->ListGetter->getCurrencyList($view_iso);
		$view_list['cancel_charge_const'] = $this->ListGetter->getMiscInfoList($view_iso, 'cancel_charge_const');
		$view_list['room_grade'] = $this->ListGetter->getRoomGradeList($view_iso);
	}

	function set_view_list_data($view_list) {
		$keys = array_keys($view_list);
		foreach ($keys as $key) {
			$this->set($key, $view_list[$key]);
		}
	}

	function hotel_upload_skeleton_download($charset, $extension) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("hotel_upload_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$title = '';
		$title .= '"'.__('ホテルID',true).'"';
		$title .= $extension.'"'.__('ホテルコード',true).'"';
		$title .= $extension.'"'.__('言語コード',true).'"';
		$title .= $extension.'"'.__('ホテル名',true).'"';
		$title .= $extension.'"'.__('ホテルコメント',true).'"';
		$title .= $extension.'"'.__('ホテルロケーションコメント',true).'"';
		$title .= $extension.'"'.__('ホテル住所1',true).'"';
		$title .= $extension.'"'.__('ホテル住所2',true).'"';
		$title .= $extension.'"'.__('ホテル住所3',true).'"';
		$title .= $extension.'"'.__('ホテルグレードコード',true).'"';
		$title .= $extension.'"'.__('都市コード',true).'"';
		$title .= $extension.'"'.__('電話番号',true).'"';
		$title .= $extension.'"'.__('FAX',true).'"';
		$title .= $extension.'"'.__('email',true).'"';
		$title .= $extension.'"'.__('郵便番号',true).'"';
		$title .= $extension.'"'.__('部屋数',true).'"';
		$title .= $extension.'"'.__('スターレート',true).'"';
		$title .= $extension.'"'.__('緯度',true).'"';
		$title .= $extension.'"'.__('経度',true).'"';
		$title .= $extension.'"'.__('チェックイン',true).'"';
		$title .= $extension.'"'.__('チェックアウト',true).'"';
		$title .= $extension.'"'.__('表示状態',true).'"';

		$facility = $this->ListGetter->getHotelFacilityList($view_iso);
		$data = '';

		foreach ($facility as $fa) {
			$data .= $extension.'"'.$fa['hfl']['name'].'"';
		}
		$buf = $title.$data."\n";

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function hotel_room_upload_skeleton_download($charset, $extension) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("hotel_room_upload_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$title = '';
		$title .= '"'.__('ホテル部屋ID',true).'"';
		$title .= $extension.'"'.__('ホールセラーコード',true).'"';
		$title .= $extension.'"'.__('ホテルコード',true).'"';
		$title .= $extension.'"'.__('言語コード',true).'"';
		$title .= $extension.'"'.__('部屋名',true).'"';
		$title .= $extension.'"'.__('部屋備考',true).'"';
		$title .= $extension.'"'.__('部屋コード',true).'"';
		$title .= $extension.'"'.__('部屋グレードコード',true).'"';
		$title .= $extension.'"'.__('バスタブ有無',true).'"';
		$title .= $extension.'"'.__('喫煙コード',true).'"';
		$title .= $extension.'"'.__('食事コード',true).'"';
		$title .= $extension.'"'.__('朝食コード',true).'"';
		$title .= $extension.'"'.__('通貨コード',true).'"';
		$title .= $extension.'"'.__('価格',true).'"';
		$title .= $extension.'"'.__('ポイント',true).'"';
		$title .= $extension.'"'.__('手数料',true).'"';

		$facility = $this->ListGetter->getRoomFacilityList($view_iso);
		$data = '';

		foreach ($facility as $fa) {
			$data .= $extension.'"'.$fa['rfl']['name'].'"';
		}
		$buf = $title.$data."\n";

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function cancel_charge_upload_skeleton_download($charset, $extension) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("cancel_policy_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$title = '';
		$title .= '"'.__('キャンセルポリシーID',true).'"';
		$title .= $extension.'"'.__('ホテルコード',true).'"';
		$title .= $extension.'"'.__('ソート番号',true).'"';
		$title .= $extension.'"'.__('備考',true).'"';
		$title .= $extension.'"'.__('宿泊期間開始',true).'"';
		$title .= $extension.'"'.__('宿泊期間終了',true).'"';
		$title .= $extension.'"'.__('手数料発生日開始',true).'"';
		$title .= $extension.'"'.__('手数料発生日終了',true).'"';
		$title .= $extension.'"'.__('手数料内訳コード',true).'"';
		$title .= $extension.'"'.__('手数料パーセント',true).'"';

		$buf = $title."\n";

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function hotel_emergency_contact_upload_skeleton_download($charset, $extension) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("emergency_contact_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$title = '';
		$title .= '"'.__('緊急連絡先ID',true).'"';
		$title .= $extension.'"'.__('ホテルコード',true).'"';
		$title .= $extension.'"'.__('ホールセラーコード',true).'"';
		$title .= $extension.'"'.__('緊急連絡先名',true).'"';
		$title .= $extension.'"'.__('ソート番号',true).'"';
		$title .= $extension.'"'.__('都市コード',true).'"';
		$title .= $extension.'"'.__('緊急連絡先住所1',true).'"';
		$title .= $extension.'"'.__('緊急連絡先住所2',true).'"';
		$title .= $extension.'"'.__('緊急連絡先住所3',true).'"';
		$title .= $extension.'"'.__('備考',true).'"';
		$title .= $extension.'"'.__('緊急連絡先郵便番号',true).'"';
		$title .= $extension.'"'.__('緊急連絡先国際電話国番号',true).'"';
		$title .= $extension.'"'.__('緊急連絡先電話番号',true).'"';

		$buf = $title."\n";

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}


	function cancel_charge_const_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("cancel_policy_stat_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$cancel_charge_const = $this->ListGetter->getMiscInfoList($view_iso, 'cancel_charge_const');

		$data = '';
		foreach ($cancel_charge_const as $ccc) {
			$data .= '"'.$ccc['mil']['code_id'].'"'.$extension.'"'.$ccc['mil']['name'].'"'."\n";
		}

		$buf = '"'.__('手数料内訳コード', true).'"'.$extension.'"'.__('手数料内訳内容', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function room_grade_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("room_grade_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$room_grade = $this->ListGetter->getRoomGradeList($view_iso);

		$data = '';
		foreach ($room_grade as $rg) {
			$data .= '"'.$rg['rg']['code'].'"'.$extension.'"'.$rg['rgl']['name'].'"'."\n";
		}

		$buf = '"'.__('部屋グレードコード', true).'"'.$extension.'"'.__('部屋グレード名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function currency_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("currency_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$currency =  $this->ListGetter->getCurrencyList($view_iso);

		$data = '';
		foreach ($currency as $cu) {
			$data .= '"'.$cu['currency']['iso_code_a'].'"'.$extension.'"'.$cu['currency']['country_name'].'"'.$extension.'"'.$cu['currency']['currency_name'].'"'."\n";
		}

		$buf = '"'.__('通貨コード', true).'"'.$extension.'"'.__('国名', true).'"'.$extension.'"'.__('通貨名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function breakfast_type_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("breakfast_type_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$breakfast_type =  $this->ListGetter->getBreakfastTypeList($view_iso);

		$data = '';
		foreach ($breakfast_type as $bt) {
			$data .= '"'.$bt['bt']['code'].'"'.$extension.'"'.$bt['btl']['name'].'"'."\n";
		}

		$buf = '"'.__('朝食コード', true).'"'.$extension.'"'.__('朝食名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function meal_type_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("meal_type_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$meal_type = $this->ListGetter->getMealTypeList($view_iso);

		$data = '';
		foreach ($meal_type as $mt) {
			$data .= '"'.$mt['mt']['code'].'"'.$extension.'"'.$mt['mtl']['name'].'"'."\n";
		}

		$buf = '"'.__('食事コード', true).'"'.$extension.'"'.__('食事名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function smoking_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("smoking_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$smoking = $this->ListGetter->getSmokingList($view_iso);

		$data = '';
		foreach ($smoking as $sm) {
			$data .= '"'.$sm['s']['code'].'"'.$extension.'"'.$sm['sl']['name'].'"'."\n";
		}

		$buf = '"'.__('喫煙コード', true).'"'.$extension.'"'.__('喫煙名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function room_bed_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("room_bed_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$room_bed = $this->ListGetter->getRoomBedList($view_iso);

		$data = '';
		foreach ($room_bed as $rb) {
			$data .= '"'.$rb['rb']['code'].'"'.$extension.'"'.$rb['rbl']['name'].'"'."\n";
		}

		$buf = '"'.__('部屋コード', true).'"'.$extension.'"'.__('部屋名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function hotel_grade_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("hotel_grade_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$hotel_grade = $this->ListGetter->getHotelGradeList($view_iso);

		$data = '';
		foreach ($hotel_grade as $hg) {
			$data .= '"'.$hg['hg']['code'].'"'.$extension.'"'.$hg['hgl']['name'].'"'."\n";
		}

		$buf = '"'.__('ホテルグレードコード', true).'"'.$extension.'"'.__('ホテルグレード名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function language_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("language_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$language = $this->ListGetter->getLanguageList($view_iso);

		$data = '';
		foreach ($language as $la) {
			$data .= '"'.$la['ViewLanguage']['iso_code'].'"'.$extension.'"'.$la['ViewLanguage']['name'].'"'."\n";
		}

		$buf = '"'.__('言語コード', true).'"'.$extension.'"'.__('言語名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function hotl_agent_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("agent_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$agent = $this->ListGetter->getHotelAgentList();
		$data = '';
		foreach ($agent as $ag) {
			$data .= '"'.$ag['hotel_agent']['code'].'"'.$extension.'"'.$ag['hotel_agent']['name'].'"'."\n";
		}

		$buf = '"'.__('ホールセラーコード', true).'"'.$extension.'"'.__('ホールセラー名', true).'"'."\n". $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}

	function town_data_download($charset, $extension, $view_iso) {
		$this->autoRender = false; // Viewを使わないように
		Configure::write('debug', 0); // debugコードを出さないように

		$csv_file = sprintf("town_%s.csv", date("Ymd-hi")); // 適当にファイル名を指定
		header ("Content-disposition: attachment; filename=" . $csv_file);
		header ("Content-type: application/octet-stream; name=" . $csv_file);

		$data = '';
		$t_area = '';
		$t_country = '';
		$t_state = '';
		$t_city = '';

		$area = $this->ListGetter->getAreaList($view_iso);
		foreach ($area as $ar) {
			$area_id = $ar['al']['area_id'];
			$country = $this->ListGetter->getSelectCountryList($view_iso, $area_id);

			foreach ($country as $co) {
				$country_id = $co['cl']['country_id'];
				$state = $this->ListGetter->getSelectStateList($view_iso, $area_id, $country_id);

				if (!empty($state)) {
					foreach ($state as $st) {
						$state_id = $st['sl']['state_id'];
						$city = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);

						foreach ($city as $ci) {
							$data .= '"'.$ar['a']['code'].'"'.$extension.'"'.$ar['al']['name'].'"';
							$data .= $extension.'"'.$co['c']['iso_code_a3'].'"'.$extension.'"'.$co['cl']['name_long'].'"';
							$data .= $extension.'"'.$st['s']['iso_code_a'].'"'.$extension.'"'.$st['sl']['name'].'"';
							$data .= $extension.'"'.$ci['c']['code'].'"'.$extension.'"'.$ci['cl']['name'].'"';
							$data .= "\n";
						}
					}
				} else {
					$state_id = 0;
					$city = $this->ListGetter->getSelectCityList($view_iso, $area_id, $country_id, $state_id);

					foreach ($city as $ci) {
						$data .= '"'.$ar['a']['code'].'"'.$extension.'"'.$ar['al']['name'].'"';
						$data .= $extension.'"'.$co['c']['iso_code_a3'].'"'.$extension.'"'.$co['cl']['name_long'].'"';
						$data .= $extension.'""'.$extension.'""';
						$data .= $extension.'"'.$ci['c']['code'].'"'.$extension.'"'.$ci['cl']['name'].'"';
						$data .= "\n";
					}
				}
			}
		}
		$t_area = '"'.__('エリアコード', true).'"'.$extension.'"'.__('エリア名', true).'"';
		$t_country = $extension.'"'.__('国コード', true).'"'.$extension.'"'.__('国名', true).'"' ;
		$t_state = $extension.'"'.__('州コード', true).'"'.$extension.'"'.__('州名', true).'"';
		$t_city = $extension.'"'.__('都市コード', true).'"'.$extension.'"'.__('都市名', true).'"';

		$title = $t_area . $t_country . $t_state . $t_city . "\n";
		$buf = $title . $data;

		print(mb_convert_encoding($buf, $charset, "UTF-8")); // 出力

		return;
	}
}

?>