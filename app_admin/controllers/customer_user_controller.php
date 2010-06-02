<?php
class CustomerUserController extends AppController {
	var $name = "CustomerUser";
	var $helpers = array('Construct', 'Javascript');
	var $uses = array('CustomerUser', 'CountryLanguage', 'GenderLanguage', 'CarrierType', 'Media', 'CustomerTypeLanguage', 'MailMagazineTypeLanguage', 'MailDeliveryLanguage', 'Condition',);
	var $needAuth = true;	// ログイン必須のフラグ
	var $components = array('ModelUtil', 'ListGetter');

	function index ($base_condition = null) {
		$cnd = null;
		$cnd_db = null;
		if ($this->Session->check(CUS_SESSION)) {
			$cnd = $this->Session->read(CUS_SESSION);
		} else {
			// 検索データ用スケルトン作成
			$cnd = $this->makeSearchSkeleton();
			$this->Session->write(CUS_SESSION, $cnd);
			$this->Session->write(CUS_SESSION_BASE, $cnd);
		}

		if (empty($cnd['day_from'])) {
			$cnd['day_from'] = date('Y-m-d', strtotime(MIN_REGIST_YEAR . "-1-1"));
		}
		if (empty($cnd['day_to'])) {
			$cnd['day_to'] = date('Y-m-d');
		}

		if (!is_null($base_condition)) {
			$cnd = $base_condition;
			$this->set('Condition', $this->Session->read(CUS_SESSION));
			$this->Session->write(CUS_SESSION_BASE, $cnd);
		} else {
			$this->set('Condition', $cnd);
		}

		$cnd_db = $cnd;

		$cnd_db['day_to'] = date('Y-m-d', strtotime('+1 day', strtotime($cnd_db['day_to'])));

		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		$this->getGenderList($view_iso);
		$this->getCountryList($view_iso);
		$this->getCarrierTypeList();
		$this->getMediaList();
		$this->getCustomerTypeList($view_iso);
		$this->getMailMagazineTypeList($view_iso);
		$this->getMailDeliveryList($view_iso);

		// データを取得する
		$whitelist = array(
				'id',
				'first_name',
				'last_name',
				'email',
				'email_mobile',
				'addr_country_id',
				'country_id',
				'carrier_type_id',
				'media_id',
				'mail_delivery_id',
				'mail_delivery_mobile_id',
				'customer_type_id',
				'mail_magazine_type_id',
				'created',
				'deleted',
				);

		$where = $this->makeSearchCondition($cnd_db);
		$search_cond = array(
			'conditions' => $where,			// 検索条件
			'fields' => $whitelist,			// 取得するカラム
			'page' => 1,					// 数値,最初に表示するページ。デフォルトは1,'last'(小文字)も可*1
			'limit' => CUS_VIEW_MAX,		// 数値：showでも可。デフォルトは20
			'sort' => 'id',					// ソートkey：order*2 でもよい。重なった場合はsortが優先される。
			'direction' => 'asc'			// asc or desc:デフォルトはasc
//			'recursive' => 					// findAllに与える。
			 );
		$this->paginate=$search_cond;
		$this->set('CustomerUser', $this->paginate('CustomerUser'));
//		$this->set('Condition', $cnd);
	}

	function search($page = 1) {
		$base_condition = $this->Session->read(CUS_SESSION_BASE);
		if(!empty($this->data)) {
			if (checkdate($this->data['Condition']['day_from']['month'], $this->data['Condition']['day_from']['day'], $this->data['Condition']['day_from']['year'])) {
				$this->data['Condition']['day_from'] = date('Y-m-d', strtotime($this->data['Condition']['day_from']['year'].'-'.$this->data['Condition']['day_from']['month'].'-'.$this->data['Condition']['day_from']['day']));
			} else {
				$this->data['Condition']['day_from'] = $this->data['Condition']['day_from']['year'].'-'.$this->data['Condition']['day_from']['month'].'-'.$this->data['Condition']['day_from']['day'];
			}
			if (checkdate($this->data['Condition']['day_to']['month'], $this->data['Condition']['day_to']['day'], $this->data['Condition']['day_to']['year'])) {
				$this->data['Condition']['day_to'] = date('Y-m-d', strtotime($this->data['Condition']['day_to']['year'].'-'.$this->data['Condition']['day_to']['month'].'-'.$this->data['Condition']['day_to']['day']));
			} else {
				$this->data['Condition']['day_to'] = $this->data['Condition']['day_to']['year'].'-'.$this->data['Condition']['day_to']['month'].'-'.$this->data['Condition']['day_to']['day'];
			}
			$this->Condition->set($this->data);
			$this->Session->write(CUS_SESSION, $this->data['Condition']);
			if ($this->Condition->validates($this->data)) {
				$this->index(null);
				$this->render('/customer_user/index/');
			} else {
				$this->index($base_condition);
				$this->render('/customer_user/index/');
			}
		}
	}

	function makeSearchCondition($cnd) {
		$where = array();
		// LIKE
		if (!empty($cnd['first_name'])) {
			$where = array_merge($where, array("CustomerUser.first_name LIKE" => "%" .$cnd['first_name']. "%"));
		}
		if (!empty($cnd['last_name'])) {
			$where = array_merge($where, array("CustomerUser.last_name LIKE" => "%" .$cnd['last_name']. "%"));
		}
		if (!empty($cnd['email'])) {
			$where = array_merge($where, array("CustomerUser.email LIKE" => "%" .$cnd['email']. "%"));
		}
		if (!empty($cnd['email_mobile'])) {
			$where = array_merge($where, array("CustomerUser.email_mobile LIKE" => "%" .$cnd['email_mobile']. "%"));
		}
		if (!empty($cnd['addr_country_id'])) {
			$where = array_merge($where, array("CustomerUser.addr_country_id" => $cnd['addr_country_id']));
		}
		if (!empty($cnd['media_id'])) {
			$where = array_merge($where, array("CustomerUser.media_id" => $cnd['media_id']));
		}
		if (!empty($cnd['country_id'])) {
			$where = array_merge($where, array("CustomerUser.country_id" => $cnd['country_id']));
		}
		if (!empty($cnd['carrier_type_id'])) {
			$where = array_merge($where, array("CustomerUser.carrier_type_id" => $cnd['carrier_type_id']));
		}
		if (!empty($cnd['mail_magazine_type_id'])) {
			$where = array_merge($where, array("CustomerUser.mail_magazine_type_id" => $cnd['mail_magazine_type_id']));
		}
		if (!empty($cnd['customer_type_id'])) {
			$where = array_merge($where, array("CustomerUser.customer_type_id" => $cnd['customer_type_id']));
		}
		$where = array_merge($where, array('CustomerUser.created BETWEEN ? AND ?' => array(date($cnd['day_from']), date($cnd['day_to']))));
		$where = array_merge($where, array('CustomerUser.deleted' => null));

		return array("AND" => $where);
	}

	function makeSearchSkeleton() {
		return array(
		"first_name" => "",
		"last_name" => "",
		"customer_type_id" => "",
		"media_id" => "",
		"email" => "",
		"email_mobile" => "",
		"carrier_type_id" => "",
		"mail_magazine_type_id" => "",
		"addr_country_id" => "",
		"country_id" => "",
		"day_from" => null,
		"day_to" => null,
		"page" => "1",
		);
	}

	/**
	 * 新規作成
	 */
	function add() {
		// 引数nullで編集を呼ぶ
		$this->get_data(null);
	}

	/**
	 * 編集
	 * @param unknown_type $customer_user_id
	 */
	function edit($customer_user_id = null) {
		// データ取得処理を呼ぶ
		$this->get_data($customer_user_id);
	}

	/**
	 * データ取得処理
	 * @param $customer_user_id
	 */
	function get_data($customer_user_id) {
		if (empty($customer_user_id)) {
			// 引数がない場合、空をセット
			if (empty($this->data)) {
				$customer_user = $this->ModelUtil->getSkeleton($this->CustomerUser);
			} else {
				$customer_user = $this->data['CustomerUser'];
			}
		} else {
			//引数がある場合、データを取得
			$customer_user = $this->CustomerUser->query(CUSTOMER_USER_SQL, array($customer_user_id));
			if (empty($customer_user)) {
				$customer_user = $this->ModelUtil->getSkeleton($this->CustomerUser);
			} else {
				foreach ($customer_user as $data) {
					if (empty($data['customer_user']['account'])) {
						$customer_user = $this->ModelUtil->getSkeleton($this->CustomerUser);
						break;
					}
					$this->CustomerUser->set($data['customer_user']);
					$customer_user = $data['customer_user'];
				}
			}
		}
		// 取得データをセット
		$this->set('CustomerUser', $customer_user);

		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);

		// 性別を取得
//		$data = $this->GenderLanguage->query(GENDER_LIST_SQL, array($view_iso));
//		$this->set('gender', $data);
		$this->getGenderList($view_iso);

		// 国を取得
//		$data = $this->CountryLanguage->query(COUNTRY_LIST_SQL, array($view_iso));
//		$this->set('country', $data);
		$this->getCountryList($view_iso);

		$this->getCarrierTypeList();
		$this->getMediaList();
		$this->getCustomerTypeList($view_iso);
		$this->getMailMagazineTypeList($view_iso);
		$this->getMailDeliveryList($view_iso);

// 言語は上部メニュー用に取得しているものを流用
	}

	/**
	 * データ保存処理
	 */
	function save() {
		if (!empty($this->data)) {
			$this->CustomerUser->create();
			$this->CustomerUser->set($this->data);
			// 日付(年月日別)を文字列に変換し、yyyy-MM-ddに成形
			if (checkdate($this->data['CustomerUser']['birthday']['month'], $this->data['CustomerUser']['birthday']['day'], $this->data['CustomerUser']['birthday']['year'])) {
				$this->data['CustomerUser']['birthday'] = date('Y-m-d', strtotime($this->CustomerUser->deconstruct("CustomerUser.birthday", $this->data['CustomerUser']['birthday'])));
			} else {
				$this->data['CustomerUser']['birthday'] = $this->CustomerUser->deconstruct("CustomerUser.birthday", $this->data['CustomerUser']['birthday']);
			}
			$whitelist = array_keys($this->CustomerUser->getColumnTypes());
			$last_id = null;
			if ($this->CustomerUser->save($this->data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$this->redirect('/customer_user/index/');
			} else {
				$this->edit($this->data['CustomerUser']['id']);
				$this->render('/customer_user/edit');
			}
		}
	}

	/**
	 * 性別リストを取得し、コントローラにセットします。
	 *
	 */
	function getGenderList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 性別を取得
//		$data = $this->GenderLanguage->query(GENDER_LIST_SQL, array($view_iso));
		$data = $this->ListGetter->getGenderList($view_iso);
		$this->set('gender', $data);
	}

	/**
	 * 国リストを取得し、コントローラにセットします。
	 *
	 */
	function getCountryList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

//		$data = $this->CountryLanguage->query(COUNTRY_LIST_SQL, array($view_iso));
		$data = $this->ListGetter->getCountryList($view_iso);
		$this->set('country', $data);
	}

	/**
	 * キャリアリストを取得し、コントローラにセットします。
	 *
	 */
	function getCarrierTypeList() {
//		$data = $this->CarrierType->query(CARRIER_TYPE_LIST_SQL);
		$data = $this->ListGetter->getCarrierTypeList();
		$this->set('carrier', $data);
	}

	/**
	 * メディアリストを取得し、コントローラにセットします。
	 *
	 */
	function getMediaList() {
//		$data = $this->CarrierType->query(MEDIA_LIST_SQL);
		$data = $this->ListGetter->getMediaList();
		$this->set('media', $data);
	}

	/**
	 * 会員状態リストを取得し、コントローラにセットします。
	 *
	 */
	function getCustomerTypeList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// 会員状態を取得
//		$data = $this->CustomerTypeLanguage->query(CUSTOMER_TYPE_LIST_SQL, array($view_iso));
		$data = $this->ListGetter->getCustomerTypeList($view_iso);
		$this->set('customer_type', $data);
	}

	/**
	 * メルマガ状態リストを取得し、コントローラにセットします。
	 *
	 */
	function getMailMagazineTypeList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// メルマガ状態を取得
//		$data = $this->MailMagazineTypeLanguage->query(MAIL_MAGAZINE_TYPE_LIST_SQL, array($view_iso));
		$data = $this->ListGetter->getMailMagazineTypeList($view_iso);
		$this->set('mail_magazine_type', $data);
	}

	/**
	 * メール配布状態リストを取得し、コントローラにセットします。
	 *
	 */
	function getMailDeliveryList($view_iso = null) {
		if (is_null($view_iso)) {
			// セッションから表示用のisoコードを取得
			$view_iso = $this->Session->read(VIEW_ISO_CODE);
		}

		// メール配布状態を取得
//		$data = $this->MailDeliveryLanguage->query(MAIL_DELIVERY_LIST_SQL, array($view_iso));
		$data = $this->ListGetter->getMailDeliveryList($view_iso);
		$this->set('mail_delivery', $data);
	}

	function init() {
		$this->Session->delete(CUS_SESSION);
		$this->redirect('/customer_user/index/');
	}

	/**
	 * レンダリング前処理
	 */
	function beforeRender(){
		parent::beforeRender();

		// viewのelementsの検索で、自コントローラ下のelementディレクトリを検索するように追加
		$paths =& Configure::getInstance();
		// $viewPaths の先頭に追加すると優先
		array_unshift($paths->viewPaths, VIEWS.$this->viewPath.DS);
	}

}

?>