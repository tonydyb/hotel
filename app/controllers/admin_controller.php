<?php
class AdminController extends AppController {
	var $name = "Admin";
	var $uses = array();
	var $needAuth = true;	// ログイン必須のフラグ

	function index () {
	}

	function change_language() {
		$this->Session->write('view_iso', $this->data['ViewLanguage']['iso']);
		$this->redirect($this->data['ViewLanguage']['redirect']);
		exit;
	}
}

?>