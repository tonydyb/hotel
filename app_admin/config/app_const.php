<?php
	define('BIRTHDAY_MINUS_YEAR', '120');	// 誕生年の最小値、操作年から何年前まで表示するか
	define('MIN_REGIST_YEAR', '2010');		// 登録日の最低値、何年からにするか
	define('CUS_SESSION', 'cus_condition');	// 会員情報検索検索条件
	define('CUS_SESSION_BASE', 'cus_condition\base');	// 会員情報検索検索条件
	define('VIEW_ISO_CODE', 'view_iso');
	define('CUS_VIEW_MAX', '20');			// 会員情報検索の1ページ結果数
	define('DEFAULT_SELECTED_VALUE_ONE', '1');	// 入力画面select系、デフォルト値
	define('DEFAULT_SELECTED_VALUE_ZERO', '0');	// 入力画面select系、デフォルト値
	define('ERROR_MSG', 'error_msg');		// エラー
	define('DEFAULT_ISO_CODE', 'en');		// デフォルトISOコード
	define('DEFAULT_ISO_ID', '25');		// 英語ISOコードのテーブルID
	define('REQUEST_CONDITION', 'request_condition'); // リクエスト状態
	define('CURRENCY_DELIMITER',':');		// 通貨表示区切り文字
	define('VIEW_MAX', '20');			// 検索の1ページ結果数
	define('ADULT', 'adult'); // 大人・子供
	define('RECEIPT_STATUS', 'request_receipt_status'); // 請求書状態
	define('REQUEST_MAIL_TEMPLATE', 'request_mail_template'); // 申し込み管理メールテンプレ
	define('UNNECESSARY_REQUEST_RECEIPT', '1'); // リクエスト請求書 不要
	define('REQUEST_CUSTOMER_USER_ADULT', '1'); // リクエストカスタマーユーザー 大人
	define('REQUEST_CUSTOMER_USER_LEADER', '1'); // リクエストカスタマーユーザー リーダー
	define('RS_VIEW_MAX', '20');
	define('RS_SESSION', 'rs_condition');	// 申し込み情報検索検索条件
	define('RS_SESSION_BASE', 'rs_condition_base');	// 申し込み情報検索検索条件
	define('REQUEST_SETTLEMENT_EXISTS', '1');	// カード決済あり
	define('REQUEST_SETTLEMENT_NOT_EXISTS', '2');	// カード決済なし
	define('REQUEST_SETTLEMENT_BOTH', '3');	// カード決済無視
	define('PRICE_PLACES', '2');	// 金額表示時精度
	define('BASE_URL', '/app_admin');	// ベースURL
?>