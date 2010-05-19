<?php
class AdminController extends AppController {
	var $name = "Admin";
	var $uses = array();
	var $needAuth = true;	// ログイン必須のフラグ
	var $helpers = array('Javascript');

	function index () {
	}
}

?>