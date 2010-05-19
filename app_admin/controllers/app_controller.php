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
class AppController extends Controller {
	// Viewテンプレートの拡張子をctpから変更
	var $ext = '.php';

	// ログインを必須とするかどうかのフラグ
	var $needAuth = false;
	var $helpers = array('Construct', 'Javascript', 'Ajax');

	// 表示用言語設定用
	var $uses = array('ViewLanguage');

	function beforeFilter() {
		// 多言語対応
		App::import('core', 'l10n');

		// 表示用言語 現在選択されているものをセッションから取得
		$view_iso = $this->Session->read(VIEW_ISO_CODE);
		// 表示用言語 選択肢用データをセッションから取得
//		$view_lang = $this->Session->read('view_lang');

		// 初期設定
		if (empty($view_iso)) {
			$view_iso = DEFAULT_ISO_CODE;
			$this->Session->write(VIEW_ISO_CODE, $view_iso);
		}
		$view_lang = $this->get_language_data($view_iso);
		$this->set(VIEW_ISO_CODE, $view_iso);
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
					$this->redirect('/login');
					exit;
				}
			}
		}
	}

	function get_language_data($view_iso) {
		$lang = $this->ViewLanguage->query(LANGUAGE_LIST_SQL, array($view_iso));

		$language = array();
		foreach ($lang as $ln) {
			$language[$ln['ViewLanguage']['iso_code']] = $ln;
		}
//		$this->Session->write('view_lang', $language);

		return $language;
	}

	/**
	 * 言語IDを取得
	 */
	function getIsoId() {
		$sql = "select id from language where iso_code='" . $this->Session->read('view_iso') . "'";
		$result = mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			if (mysql_num_rows($result)) {
				$row = mysql_fetch_row($result);
				return $row[0];
			} else {
				return DEFAULT_ISO_ID;
			}
		}
	}

}

?>