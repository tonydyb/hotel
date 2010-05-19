<?php
class LoginController extends AppController {
	var $name = "Login";
	var $uses = array('AdminUser');
	var $needAuth = true;	// ログイン必須のフラグ

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
		}
	}

	/***
	 * ログオフします。
	 * セッションからログイン情報を削除します。
	 */
	function logoff() {
		$this->Session->delete('auth');
		$this->redirect('/');
        exit;
	}

	function beforeFilter() {
		parent::beforeFilter();
		$this->set('css', 'login');
	}
}

?>