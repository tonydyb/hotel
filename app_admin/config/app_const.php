<?php
	define('BIRTHDAY_MINUS_YEAR', '120');	// 誕生年の最小値、操作年から何年前まで表示するか
	define('MIN_REGIST_YEAR', '2010');		// 登録日の最低値、何年からにするか
	define('CUS_SESSION', 'cus_condition');	// 会員情報検索検索条件
	define('CUS_SESSION_BASE', 'cus_condition_base');	// 会員情報検索検索条件
	define('VIEW_ISO_CODE', 'view_iso');
	define('CUS_VIEW_MAX', '20');			// 会員情報検索の1ページ結果数
	define('DEFAULT_SELECTED_VALUE_ONE', '1');	// 入力画面select系、デフォルト値
	define('DEFAULT_SELECTED_VALUE_ZERO', '0');	// 入力画面select系、デフォルト値
	define('ERROR_MSG', 'error_msg');		// エラー
	define('DEFAULT_ISO_CODE', 'en');		// デフォルトISOコード
	define('DEFAULT_ISO_ID', '25');		// 英語ISOコードのテーブルID
	define('JA_ISO_ID', '55');		// 日本語ISOコードのテーブルID
	define('ZH_ISO_ID', '139');		// 中国語【簡体字】ISOコードのテーブルID
	define('ZH_TW_ISO_ID', '141');		// 中国語【繁体字】ISOコードのテーブルID
	define('REQUEST_CONDITION', 'request_condition'); // リクエスト状態
	define('CURRENCY_DELIMITER',':');		// 通貨表示区切り文字
	define('ROOM_DELIMITER',':');		// 部屋表示区切り文字
	define('VIEW_MAX', '20');			// 検索の1ページ結果数
	define('ADULT', 'adult'); // 大人・子供
	define('ADULT_CODE_ADULT', '1'); // 大人・子供コード 大人
	define('GENDER_ID_MALE', '1'); // 性別コード 男
	define('RECEIPT_STATUS', 'request_receipt_status'); // 請求書状態
	define('REQUEST_MAIL_TEMPLATE', 'request_mail_template'); // 申し込み管理メールテンプレ
	define('UNNECESSARY_REQUEST_RECEIPT', '1'); // リクエスト請求書 不要
	define('REQUEST_CUSTOMER_USER_ADULT', '1'); // リクエストカスタマーユーザー 大人
	define('REQUEST_CUSTOMER_USER_LEADER', '1'); // リクエストカスタマーユーザー リーダー
	define('REQUEST_CUSTOMER_USER_OTHER', '0'); // リクエストカスタマーユーザー その他
	define('RS_VIEW_MAX', '20');
	define('RS_SESSION', 'rs_condition');	// 申し込み情報検索検索条件
	define('RS_SESSION_BASE', 'rs_condition_base');	// 申し込み情報検索検索条件
	define('REQUEST_SETTLEMENT_EXISTS', '1');	// カード決済あり
	define('REQUEST_SETTLEMENT_NOT_EXISTS', '2');	// カード決済なし
	define('REQUEST_SETTLEMENT_BOTH', '3');	// カード決済無視
	define('PRICE_PLACES', '2');	// 金額表示時精度
	define('BASE_URL', '/app_admin');	// ベースURL
	define('USER_BASE_URL', '/app_user');	// ベースURL
	define('CONTENT_BLOCK_ROOT_PATH', '../../app_user/views/pages/content_block/');	// CONTENT_BLOCK_ROOT_PATH
	define('CONTENT_BLOCK_ABSOLUTE_ROOT_PATH', '/app_user/views/pages/content_block/');	// CONTENT_BLOCK_ABSOLUTE_ROOT_PATH
	define('CONTENT_LAYOUT_ROOT_PATH', '../../app_user/views/layouts/content_layout/');	// CONTENT_LAYOUT_ROOT_PATH
	define('CONTENT_LAYOUT_ABSOLUTE_ROOT_PATH', '/app_user/views/pages/content_layout/');	// CONTENT_LAYOUT_ABSOLUTE_ROOT_PATH
	define('CONTENT_PAGE_ROOT_PATH', '../../app_user/views/pages/content_page/');	// CONTENT_PAGE_ROOT_PATH
	define('CONTENT_PAGE_ABSOLUTE_ROOT_PATH', '/app_user/views/pages/content_page/');	// CONTENT_PAGE_ABSOLUTE_ROOT_PATH
	define('CONTENT_IMAGE_ROOT_PATH', '../../app_user/webroot/image/');	// CONTENT_IMAGE_ROOT_PATH
	define('CONTENT_IMAGE_ABSOLUTE_ROOT_PATH', '/app_user/webroot/image/');	// CONTENT_IMAGE_ABSOLUTE_ROOT_PATH
	define('CONTENT_CSS_ROOT_PATH', '../../app_user/webroot/css/');	// CONTENT_CSS_ROOT_PATH
	define('CONTENT_CSS_ABSOLUTE_ROOT_PATH', '/hotel/app_user/webroot/css/');	// CONTENT_CSS_ABSOLUTE_ROOT_PATH
	define('REQUEST_CSV_MAX', '1000000'); // リクエストCSV最大取得件数
	define('SEND_MAIL_TO_USER', 'to_user');	// リクエスト メール送信 ユーザー宛
	define('EMAIL_CONST', 'email_const');	// EMAIL用定数取得用
	define('INDIVIDUAL_REQUEST_STAT_CANCEL', '5');	// 個別リクエストステータス キャンセル
	define('REQUEST_STAT_TEMPORARY_RESERVED', '1');	// リクエスト 仮予約
	define('REQUEST_STAT_RESERVED_RQ_NOVACANCIES', '2');	// リクエスト 予約済み(RQ・満室有り)
	define('REQUEST_STAT_REQUEST_RESERVED', '3');	// リクエスト 予約済み
	define('REQUEST_STAT_REQUEST_RESERVED_REMARKS_CHECKED', '4');	// リクエスト 予約済み 備考確認済み
	define('REQUEST_STAT_REQUEST', '5');	// リクエスト リクエスト
	define('REQUEST_STAT_NO_VACANCIES', '6');	// リクエスト 満室
	define('REQUEST_STAT_NOVACANCIES_REPAID', '7');	// リクエスト 満室返金済
	define('REQUEST_STAT_CORRESPONDS', '8');	// リクエスト 対応中
	define('REQUEST_STAT_CORRESPONDENCE_COMPLETION', '9');	// リクエスト 対応完了
	define('REQUEST_STAT_CANCEL', '10');	// リクエスト キャンセル
	define('REQUEST_STAT_CANCEL_REPAID', '11');	// リクエスト キャンセル返金済み
	define('REQUEST_STAT_DELETED', '12');	// リクエスト 削除済み
	define('REQUEST_PAYMENT_CREDIT', '2');	// 決済状態 与信
	define('REQUEST_PAYMENT_SALES_PROCESSING_COMPLETION', '3');	// 決済状態 売上処理完了
	define('DISPLAY_STAT_EXIST', '1');	// 表示状態 表示・存在
	define('DISPLAY_STAT_NOTEXIST', '0');	// 表示状態 非表示・無し
	define('DISPLAY_STAT_DELETE', '99');	// 表示状態 削除
	define('DELETE_FLAG_DELETE', '1');	// デリートフラグ 削除
	define('DELETE_FLAG_NOT_DELETE', '0');	// デリートフラグ 非削除
	define('HOTEL_IMAGE_ROOT_PATH', '/../../../app_user/webroot/img/hotel/');	// ホテルアップロード画像ルートディレクトリ
	define('HOTEL_IMAGE_ROOT_PATH_ON_MKDIR', '/../../app_user/webroot/img/hotel/');	// ホテルアップロード画像ルートディレクトリ
	define('HOTEL_IMAGE_ROOT_PATH_ON_APP_USER', '/../../img/hotel/');	// ホテルアップロード画像ルートディレクトリ
	define('SLASH', '/');	// スラッシュ
	define('HS_VIEW_MAX', '20');
	define('HS_SESSION', 'hs_condition');	// ホテル情報検索検索条件
	define('HS_SESSION_BASE', 'hs_condition_base');	// ホテル情報検索検索条件
	define('HOTEL_IMAGE_EXISTS', '1');	// ホテル画像あり
	define('CONTENT_DOCUMENT_TYPE_NAME_BRANCH', '0');	// コンテンツ 提出書類 種類用 枝番号
	define('CONTENT_DOCUMENT_MAIN_BRANCH', '1');	// コンテンツ 提出書類 メイン 枝番号
	define('CONTENT_DOCUMENT_LAST_BRANCH', '3');	// コンテンツ 提出書類 最終 枝番号
	define('CONTENT_DOCUMENT_ROOT_PATH', '/../../../app_user/views/elements/');	// コンテンツ提出書類ルートディレクトリ
	define('CONTENT_DOCUMENT_ROOT_PATH_ON_MKDIR', '../../app_user/views/elements/');	// コンテンツ提出書類ルートディレクトリ
	define('CONTENT_DOCUMENT_PATH_SUFFIX', 'html/');
	define('CONTENT_DOCUMENT_EXTENSION' , '.php');	// コンテンツ提出書類
	define('UPLOAD_FILE_TEMP_DIR', '../tmp/file/');	// アップロードファイルテンポラリ
	define('HOTEL_UPLOAD_COL_MIN', '22');	// ホテルアップロード最小カラム数
	define('HOTEL_ROOM_UPLOAD_COL_MIN', '16');	// ホテル部屋アップロード最小カラム数
	define('CANCEL_CHARGE_UPLOAD_COL_MIN', '10');	// キャンセル料アップロード最小カラム数
	define('EMERGENCY_CONTACT_UPLOAD_COL_MIN', '13');	// 緊急連絡先アップロード最小カラム数

?>