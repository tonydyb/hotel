<?php
	// バリデーション 半角英数字
	define('ALPHA_NUMERIC', '/^[a-z\d\s]*$/i');
	// バリデーション 数字開始で数字終了、ハイフンと数字のみ許可
	define('PHONE', '/^[0-9][-\d]*[0-9]$/i');

	define('DATETIME', '%^(?:(?:(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(\\/|-|\\.|\\x20)(?:0?2\\1(?:29)))|(?:(?:(?:1[6-9]|[2-9]\\d)?\\d{2})(\\/|-|\\.|\\x20)(?:(?:(?:0?[13578]|1[02])\\2(?:31))|(?:(?:0?[1,3-9]|1[0-2])\\2(29|30))|(?:(?:0?[1-9])|(?:1[0-2]))\\2(?:0?[1-9]|1\\d|2[0-8])))) ((0?[1-9]|1[012])(:[0-5]\d){0,2}([AP]M|[ap]m))$|^([01]\d|2[0-3])(:[0-5]\d){0,2}$%');
	// バリデーション ホテル コード
//	define('HOTEL_CODE', "/^[a-z\d-_\(\)']*$/i");
	define('HOTEL_CODE', "/^[!-~]*$/i");





?>