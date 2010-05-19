<?php
class CustomerUserController extends AppController {
	var $name = "CustomerUser";
	var $uses = array('CustomerUser', 'CountryLanguage', 'GenderLanguage');
	var $needAuth = true;	// ログイン必須のフラグ

	function index () {
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
			$customer_user = $this->set('CustomerUser', array());
		} else {
			//引数がある場合、データを取得
			$sql = "select * from customer_user where id = ?";
			$customer_user = $this->CustomerUser->query($sql, array($customer_user_id));

			if (empty($customer_user)) {
				$customer_user = $this->set('CustomerUser', array());
			} else {
				$this->CustomerUser->set($customer_user);
				foreach ($customer_user as $data) {
					if ($data['customer_user']['account']) {
						$customer_user = $this->set('CustomerUser', array());
						break;
					}
				}
			}
		}
		// 取得データをセット
		$this->set('CustomerUser', $customer_user);

		// セッションから表示用のisoコードを取得
		$view_iso = $this->Session->read('view_iso');

		// 性別を取得
		$sql = "select gl.gender_id as gender_id, gl.name as name from language l join gender_language gl on (l.iso_code = ? and l.id = gl.language_id) order by gender_id asc";
		$data = $this->GenderLanguage->query($sql, array($view_iso));
		$this->set('gender', $data);

		// 国を取得
		$sql = "select cl.country_id as country_id, cl.name_long as name_long from language l join country_language cl on (l.iso_code = ? and l.id = cl.language_id) order by cl.name_long asc";
		$data = $this->CountryLanguage->query($sql, array($view_iso));
		$this->set('country', $data);

		// 言語は上部メニュー用に取得しているものを流用
	}

	/**
	 * データ保存処理
	 */
	function save() {
		if (!empty($this->data)) {
			$this->CustomerUser->create();
			$this->CustomerUser->set($this->data);
			// 日付(年月日別)を文字列に変換
			$this->data['CustomerUser']['birthday'] = strtotime($this->CustomerUser->deconstruct("CustomerUser.birthday", $this->data['CustomerUser']['birthday']));

			$whitelist = array(
							'id',
							'account',
							'password',
							'first_name',
							'last_name',
							'email',
							'email_mobile',
							'tel',
							'tel_mobile',
							'fax',
							'postcode',
							'addr_country_id',
							'addr_1',
							'addr_2',
							'addr_3',
							'gender_id',
							'birthday',
							'last_access',
							'language_id',
							'country_id',
							'created',
							'updated',
							'deleted',
						);

			$last_id = null;
			if ($this->CustomerUser->save($this->data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$last_id = $this->CustomerUser->getLastInsertID();
				if (!empty($last_id)) {
//					$this->redirect('/customer_user/edit/' . $last_id . '/');
					$this->Session->setFlash(__('会員情報を登録しました。'));
					exit;
				}
			} else {
				$this->edit($this->data['CustomerUser']['id']);
				$this->render('/customer_user/edit');
//				$this->redirect('/customer_user/edit/');
//				$this->Session->setFlash(__('会員情報の登録に失敗しました。'));
//				exit;
			}
		} else {
//			$this->redirect('/customer_user/edit/');
			$this->Session->setFlash(__('会員情報を入力してください。'));
			exit;
		}
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