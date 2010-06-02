<?php
class LoginController extends AppController {
	var $name = "Login";
	var $uses = array('AdminUser', 'ChangePassword');
	var $needAuth = true;	// ログイン必須のフラグ
	var $helpers = array('Javascript');

	function index () {
//		$this->Language->unbindModel(array('hasMany'=>array('AdminUser', 'HotelUser', 'HotelAgentUser', 'CustomerUser', 'Request')));
//		if (empty($view_language)) {
//			Configure::write('Config.language', parent::$view_language_iso_code);
//			$this->get_language_data();
//		}

		// web上で使用する変数にセットするのはこんな感じ
//		$this->set('pageTitle', __('海外ホテル予約'));
//		$this->addScript($javascript->codeBlock(’alert("alert in head!");))

		$this->set('css', 'login');
		$this->Session->delete('auth');
	}

	/***
	 * ログイン処理を行います。
	 * 入力されたaccount/passwordでadmin_userを検索し、存在する場合ログインします。
	 *
	 */
	function login() {
		// データが送られてきたら
		if (!empty($this->data)) {

			// データ取得
			$option['conditions'] = array('AdminUser.account' => $this->data['AdminUser']['account'], 'AdminUser.password' =>  $this->data['AdminUser']['password']);
			$admin_user = $this->AdminUser->find('all', $option);

			// [$admin_user]が空じゃなければ
			if (!empty($admin_user)) {
				// 値をセッションに格納
				$this->Session->write('auth', $admin_user);
				// リダイレクトする
				$this->redirect('/admin');
				exit;
			} else { // [$admin_user]が空ならログイン画面へ
				$this->AdminUser->set($admin_user);
				$this->AdminUser->invalidate("loginfailed", __('IDまたはパスワードが違います。', true));
				if (!$this->AdminUser->save()) {
					$this->render('/login/index');
				}
			}
		} else {
			$this->render('/login/index');
		}
	}

	function change_password() {
		$admin_user = $this->Session->read('auth');
		$login_user = $this->get_password_change_skeleton();

		$login_user['account'] = $admin_user[0]['AdminUser']['account'];
		$this->set('AdminUser', $login_user);
	}

	function get_password_change_skeleton() {
		$data = array();
		$data['account'] = '';
		$data['password'] = '';
		$data['old_password'] = '';
		$data['new_password1'] = '';
		$data['new_password2'] = '';
		return $data;
	}

	function change_password_submit() {
		if (!empty($this->data)) {
			$admin_user = $this->Session->read('auth');
			$login_user = $this->data['ChangePassword'];
			$login_user['old_password'] = $admin_user[0]['AdminUser']['password'];

			$this->ChangePassword->create();
			$this->ChangePassword->set($login_user);
			if ($this->ChangePassword->validates($login_user)) {
				$this->AdminUser->create();
				$this->AdminUser->set($login_user);
				$whitelist = array_keys($this->AdminUser->getColumnTypes());
				$this->AdminUser->query(CHANGE_PASSWORD_SQL, array($login_user['new_password1'], $admin_user[0]['AdminUser']['id']));

				$option['conditions'] = array('AdminUser.account' => $login_user['account'], 'AdminUser.password' => $login_user['new_password1']);
				$admin_user = $this->AdminUser->find('all', $option);
				if (!empty($admin_user)) {
					// 値をセッションに格納
					$this->Session->write('auth', $admin_user);
				}
			} else {
				$this->set('AdminUser', $login_user);
				$this->render('/login/change_password/');
			}
		} else {
			$admin_user = $this->Session->read('auth');
			$login_user = $this->get_password_change_skeleton();
			$login_user['account'] = $admin_user[0]['AdminUser']['account'];
			$this->set('AdminUser', $login_user);
			$this->render('/login/change_password/');
		}
	}

	/***
	 * ログオフします。
	 * セッションからログイン情報を削除します。
	 */
	function logoff() {
		$this->Session->delete('auth');
		$this->redirect('/login');
        exit;
	}

	function beforeFilter() {
		parent::beforeFilter();
		$this->set('css', 'login');
	}

	function change_language() {
		$this->Session->write(VIEW_ISO_CODE, $this->data['ViewLanguage']['iso']);
		$this->redirect($this->data['ViewLanguage']['redirect']);
		exit;
	}
}

?>