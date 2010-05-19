<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
config('app');
class AppController extends Controller {
	// Viewテンプレートの拡張子をctpから変更
	var $ext = '.php';
	// ログインを必須とするかどうかのフラグ
	var $needAuth = false;

	// 表示用言語設定用
	var $uses = array('ViewLanguage');

	function beforeFilter() {
		// 多言語対応
		App::import('core', 'l10n');

		// 表示用言語 現在選択されているものをセッションから取得
		$view_iso = $this->Session->read('view_iso');
		// 表示用言語 選択肢用データをセッションから取得
//		$view_lang = $this->Session->read('view_lang');

		// 初期設定
		if (empty($view_iso)) {
			$view_iso = 'en';
			$this->Session->write('view_iso', $view_iso);
		}
		$view_lang = $this->get_language_data($view_iso);
		$this->set('view_iso', $view_iso);
		$this->set('view_lang', $view_lang);
		// 多言語対応 表示設定切り替え
		Configure::write('Config.language', $view_iso);

		// ユーザー画面用
		if ($this->name != "Login") {
			// セッションから取り出したログイン情報をセット
			$auth = $this->Session->read('auth');
			$this->set('auth', $auth);

			// ログイン必須の機能でログインされていない場合はログイン画面へ転送
			if ($this->needAuth && $this->action != 'login') {
				if (empty($auth)) {
					$this->redirect('/');
					exit;
				}
			}
		}
	}

	function get_language_data($view_iso) {
		$sql = "select * from (select L1.id as id, LL.language_id as ll_id, L1.iso_code as iso, LL.name as name, L2.iso_code as iso_code from language L1 join language_language LL on (L1.iso_code = ? and L1.id = LL.iso_language_id) join language L2 on (LL.language_id = L2.id) order by LL.name asc) ViewLanguage";

		$lang = $this->ViewLanguage->query($sql, array($view_iso));

		$language = array();
		foreach ($lang as $ln) {
			$language[$ln['ViewLanguage']['iso_code']] = $ln;
		}
//		$this->Session->write('view_lang', $language);

		return $language;
	}
}

?>