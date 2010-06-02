<?php
	// CUSTOMER_USER をIDで1件取得用 第一引数 customer_user_id
	define('CUSTOMER_USER_SQL', 'select * from customer_user where id = ? and isnull(deleted)');
	// 言語リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('LANGUAGE_LIST_SQL', 'select * from (select L1.id as id, LL.language_id as ll_id, L1.iso_code as iso, LL.name as name, L2.iso_code as iso_code from language L1 join language_language LL on (L1.iso_code = ? and L1.id = LL.iso_language_id  and isnull(L1.deleted) and isnull(LL.deleted)) join language L2 on (LL.language_id = L2.id and isnull(L2.deleted)) order by LL.name asc) ViewLanguage');
	// 性別リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('GENDER_LIST_SQL', 'select gl.gender_id as gender_id, gl.name as name from language l join gender_language gl on (l.iso_code = ? and l.id = gl.language_id and isnull(l.deleted) and isnull(gl.deleted)) order by gender_id asc');
	// 国リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('COUNTRY_LIST_SQL', 'select cl.country_id as country_id, cl.name_long as name_long from language l join country_language cl on (l.iso_code = ? and l.id = cl.language_id and isnull(l.deleted) and isnull(cl.deleted)) order by cl.name_long asc');
	// 会員状態リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('CUSTOMER_TYPE_LIST_SQL', 'select ctl.customer_type_id, ctl.name from language l join customer_type_language ctl on (l.iso_code = ? and l.id = ctl.language_id and isnull(l.deleted) and isnull(ctl.deleted)) order by ctl.customer_type_id asc');
	// メルマガ状態リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('MAIL_MAGAZINE_TYPE_LIST_SQL', 'select mmtl.mail_magazine_type_id, mmtl.name from language l join mail_magazine_type_language mmtl on (l.iso_code = ? and l.id = mmtl.language_id and isnull(l.deleted) and isnull(mmtl.deleted)) order by mmtl.mail_magazine_type_id asc');
	// キャリアリスト取得用
	define('CARRIER_TYPE_LIST_SQL', 'select * from carrier_type where isnull(deleted) order by id asc');
	// メディアリスト取得用
	define('MEDIA_LIST_SQL', 'select * from media where isnull(deleted) order by name,id asc');
	// メール到着状態リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('MAIL_DELIVERY_LIST_SQL', 'select mdl.mail_delivery_id, mdl.name from language l join mail_delivery_language mdl on (l.iso_code = ? and l.id = mdl.language_id and isnull(l.deleted) and isnull(mdl.deleted)) order by mdl.mail_delivery_id asc');
	// admin_userの名前リスト取得用
	define('ADMIN_USER_LIST_SQL', 'select id, name, email from admin_user where isnull(deleted) order by name');
	// 雑インフォリスト取得用 第一引数 ISOコード 第二引数 MISC_INFO.CODE
	define('MISC_INFO_LIST_SQL', 'SELECT mil.code_id, mil.name FROM language l JOIN misc_info_language mil ON (l.iso_code = ? AND l.id = mil.language_id AND isnull(l.deleted) AND isnull(mil.deleted)) JOIN misc_info mi ON (mi.id = mil.misc_info_id AND mi.code = ? AND isnull(mi.deleted)) ORDER BY mil.code_id ASC');
	// 決済状態リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('REQUEST_PAYMENT_LIST_SQL', 'SELECT rpl.request_payment_id, rpl.name FROM language l JOIN request_payment_language rpl ON (l.iso_code = ? AND l.id = rpl.language_id AND isnull(l.deleted) AND isnull(rpl.deleted)) ORDER BY rpl.request_payment_id ASC');
	// 決済通貨リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('REQUEST_CURRENCY_LIST_SQL', 'SELECT * FROM (SELECT co.id AS country_id, col.name_long AS country_name, c.id AS currency_id, c.iso_code_a AS iso_code_a, cl.name AS currency_name FROM language l JOIN currency_language cl ON (l.iso_code = ? AND l.id = cl.language_id AND isnull(l.deleted) AND isnull(cl.deleted)) JOIN currency c ON (c.id = cl.currency_id AND isnull(c.deleted)) JOIN country co ON (c.country_id = co.id AND isnull(co.deleted)) JOIN country_language col ON (co.id = col.country_id AND col.language_id = l.id AND isnull(col.deleted)) ORDER BY c.iso_code_a, col.name_long ASC) currency');
	// REQUEST をIDで1件取得用 第一引数 request_id
	define('REQUEST_SQL', 'select * from request where id = ? and isnull(deleted)');
	// 個別リクエスト状況リスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('REQUEST_STAT_LIST_SQL', 'SELECT rsl.request_stat_id, rsl.name FROM language l JOIN request_stat_language rsl ON (l.iso_code = ? AND l.id = rsl.language_id AND isnull(l.deleted) AND isnull(rsl.deleted)) ORDER BY rsl.request_stat_id ASC');
	// REQUEST_HOTEL をREQUEST_IDで取得用 第一引数 request_id
	define('REQUEST_HOTEL_LIST_SQL', 'select * from request_hotel where request_id = ? and isnull(deleted) order by id');
	// HOTEL_AGENT を取得用
	define('HOTEL_AGENT_LIST_SQL', 'select * from hotel_agent where isnull(deleted) order by name');
	// エリアリスト取得用(表示言語のもののみ) 第一引数 ISOコード
	define('AREA_LIST_SQL', 'SELECT al.area_id, al.name, a.code FROM language l JOIN area_language al ON (l.iso_code = ? AND l.id = al.language_id AND isnull(l.deleted) AND isnull(al.deleted)) JOIN area a ON (al.area_id = a.id AND UPPER(LEFT (a.code, 5)) != \'CITY_\') ORDER BY al.name ASC');
	// 国リスト取得用 第一引数 ISOコード 第二引数 AREA_ID
	define('SELECT_COUNTRY_LIST_SQL', 'SELECT cl.country_id, cl.name_long, c.iso_code_a3 FROM language l JOIN country_language cl ON (l.iso_code = ? AND l.id = cl.language_id AND isnull(l.deleted) AND isnull(cl.deleted)) JOIN country c ON (cl.country_id = c.id AND c.deleted IS NULL) WHERE cl.country_id IN (SELECT country_id FROM area_link_country WHERE area_id = ?) ORDER BY cl.name_long ASC');
	// 州リスト取得用 第一引数 ISOコード 第二引数 AREA_ID
	define('SELECT_STATE_LIST_SQL', 'SELECT sl.state_id, sl.name, s.iso_code_a FROM language l JOIN state_language sl ON (l.iso_code = ? AND l.id = sl.language_id AND isnull(l.deleted) AND isnull(sl.deleted)) JOIN area_link_state als ON (area_id = ? AND isnull(als.created)) JOIN state s ON (als.state_id = s.id AND isnull(s.created) %s) ORDER BY sl.name ASC');
	// 都市リスト取得用 第一引数 ISOコード 第二引数 sprintfで条件を追加
	define('SELECT_CITY_LIST_SQL', 'SELECT cl.city_id, cl.name, c.code FROM language l JOIN city_language cl ON (l.iso_code = ? AND l.id = cl.language_id AND isnull(l.deleted) AND isnull(cl.deleted)) JOIN city c ON (cl.city_id = c.id AND isnull(c.deleted) %s) ORDER BY cl.name ASC');
	// ホテルリスト取得用 第一引数 ISOコード 第二引数 sprintfで条件を追加
	define('SELECT_HOTEL_LIST_SQL', 'SELECT hl.hotel_id, hl.name FROM language l JOIN hotel_language hl ON (l.iso_code = ? AND l.id = hl.language_id AND isnull(l.deleted) AND isnull(hl.deleted)) JOIN hotel h ON (h.id = hl.hotel_id AND isnull(h.deleted) %s) ORDER BY hl.name ASC');
	// 部屋リスト取得用 第一引数 ISOコード 第二引数 sprintfで条件を追加
	define('SELECT_ROOM_LIST_SQL', 'SELECT hrl.hotel_room_id, hrl.name, rbl.name FROM language l JOIN hotel_room_language hrl ON (l.iso_code = ? AND l.id = hrl.language_id AND isnull(l.deleted) AND isnull(hrl.deleted)) JOIN hotel_room hr ON (hr.id = hrl.hotel_room_id AND isnull(hr.deleted) %s) JOIN room_bed_language rbl ON (rbl.room_bed_id = hr.room_bed_id AND l.id = rbl.language_id AND isnull(rbl.deleted)) ORDER BY hrl.name ASC');
	// 部屋情報取得用 第一引数 ISOコード 第二引数 HOTEL_ROOM_ID
	define('SELECT_ROOM_DATA', 'SELECT * FROM (SELECT hr.id AS hotel_room_id, hr.hotel_agent_id AS hotel_agent_id, hr.commission AS commission, rbl.name AS bed_name, rgl.name AS grade_name, mil.name AS bath_name, sl.name AS smoking_name, cl.currency_id AS currency_id, cl.name AS currency_name, c.iso_code_a AS currency_code, hr.price AS price, hr.point AS point, mtl.name AS meal_name, mtl.meal_type_id AS meal_type_id, btl.name AS breakfast_name, btl.breakfast_type_id AS breakfast_type_id FROM language l JOIN hotel_room_language hrl ON (l.id = hrl.language_id AND l.iso_code = ? AND hrl.hotel_room_id = ? AND isnull(l.deleted) AND isnull(hrl.deleted)) JOIN hotel_room hr ON (hr.id = hrl.hotel_room_id AND isnull(hr.deleted)) JOIN currency c ON (c.id = hr.currency_id AND isnull(c.deleted)) LEFT JOIN room_bed_language rbl ON (hr.room_bed_id = rbl.room_bed_id AND isnull(rbl.deleted) AND l.id = rbl.language_id) LEFT JOIN room_grade_language rgl ON (hr.room_grade_id = rgl.room_grade_id AND isnull(rgl.deleted) AND l.id = rgl.language_id) LEFT JOIN misc_info_language mil ON (hr.room_bath_id = mil.code_id AND mil.misc_info_code = \'room_bath_id\' AND isnull(mil.deleted) AND l.id = mil.language_id) LEFT JOIN smoking_language sl ON (hr.smoking_id = sl.smoking_id AND isnull(sl.deleted) AND l.id = sl.language_id) LEFT JOIN currency_language cl ON (hr.currency_id = cl.currency_id AND isnull(cl.deleted) AND l.id = cl.language_id) LEFT JOIN meal_type_language mtl ON (hr.meal_type_id = mtl.meal_type_id AND isnull(mtl.deleted) AND l.id = mtl.language_id) LEFT JOIN breakfast_type_language btl ON (hr.breakfast_type_id = btl.breakfast_type_id AND isnull(btl.deleted) AND l.id = btl.language_id)) room_data');
	// REQUEST_HOTEL_CUSTOMER_USER をREQUEST_IDで取得用 第一引数 request_id 第二引数 request_hotel_id
	define('REQUEST_HOTEL_CUSTOMER_USER_LIST_SQL', 'select * from request_hotel_customer_user where request_id = ? and request_hotel_id = ? and isnull(deleted) order by leader desc, id asc');
	// REQUEST_RECEIPT をREQUEST_IDで取得用 第一引数 request_id
	define('REQUEST_RECEIPT_SQL', 'select * from request_receipt where request_id = ? and isnull(deleted)');
	// メールテンプレ名称取得用 第一引数 ISOコード 第二引数 mail_template_code
	define('MAIL_TEMPLATE_NAME_LIST_SQL', 'select mtl.id, mtl.name from language l join mail_template_language mtl on (l.iso_code = ? and l.id = mtl.language_id and mtl.mail_template_code = ? and isnull(l.deleted) and isnull(mtl.deleted)) order by mtl.code_id');
	// メールテンプレラングエッジ取得用 第一引数 id
	define('MAIL_TEMPLATE_LANGUAGE_BY_ID_SQL', 'select * from mail_template_language where id = ?');
	// HOTEL をIDで1件取得用 第一引数 hotel_id
	define('HOTEL_SQL', 'select * from hotel where id = ? and isnull(deleted)');
	// AREA_LINK_COUNTRY を件取得用 第一引数 country_id
	define('AREA_LINK_COUNTRY_LIST_SQL', 'select * from area_link_country where country_id = ? and isnull(deleted)');
	// 申込管理 一覧表示 付属データ取得用 第一引数 ISOコード 第二引数 request_id(IN句)
	define('REQUEST_LIST_ATTACHED_DATA_SQL', 'SELECT Request.id, RequestHotel.id, RequestStatLanguage.name, RequestHotel.limit_date, RequestHotel.checkin, RequestHotel.checkout, HotelLanguage.name, AreaLanguage.name, CountryLanguage.name, StateLanguage.name, CityLanguage.name, HotelRoomLanguage.name FROM request Request JOIN request_hotel RequestHotel ON (RequestHotel.request_id = Request.id) INNER JOIN hotel Hotel ON (Hotel.id = RequestHotel.hotel_id) INNER JOIN hotel_Language AS HotelLanguage ON (HotelLanguage.hotel_id = RequestHotel.hotel_id) INNER JOIN LANGUAGE LANGUAGE ON (HotelLanguage.Language_id = LANGUAGE.id) INNER JOIN area_link_country AreaLinkCountry ON (Hotel.country_id = AreaLinkCountry.country_id) INNER JOIN hotel_room_Language HotelRoomLanguage ON (HotelRoomLanguage.hotel_room_id = RequestHotel.hotel_room_id AND HotelRoomLanguage.Language_id = LANGUAGE.id) INNER JOIN request_stat_Language RequestStatLanguage ON (RequestStatLanguage.request_stat_id = RequestHotel.request_stat_id AND RequestStatLanguage.Language_id = LANGUAGE.id) LEFT JOIN area_Language AreaLanguage ON (AreaLinkCountry.area_id = AreaLanguage.area_id AND LANGUAGE.id = AreaLanguage.Language_id) LEFT JOIN country_Language CountryLanguage ON (Hotel.country_id = CountryLanguage.country_id AND LANGUAGE.id = CountryLanguage.Language_id) LEFT JOIN state_Language StateLanguage ON (Hotel.state_id = StateLanguage.state_id AND LANGUAGE.id = StateLanguage.Language_id) LEFT JOIN city_Language CityLanguage ON (Hotel.city_id = CityLanguage.city_id AND LANGUAGE.id = CityLanguage.Language_id) WHERE isnull(Request.deleted) AND isnull(Hotel.deleted) AND isnull(RequestHotel.deleted) AND isnull(AreaLinkCountry.deleted) AND isnull(HotelLanguage.deleted) AND isnull(LANGUAGE.deleted) AND isnull(HotelRoomLanguage.deleted) AND isnull(RequestStatLanguage.deleted) AND isnull(AreaLanguage.deleted) AND isnull(CountryLanguage.deleted) AND isnull(StateLanguage.deleted) AND isnull(CityLanguage.deleted) AND isnull(HotelLanguage.deleted) AND LANGUAGE.iso_code = ? AND Request.id IN (%s) ORDER BY Request.id desc, RequestHotel.id asc');
	// リクエスト リクエストステータスID一括更新用 第一引数 request_stat_id 第二引数 sprintfで id を指定
	define('REQUEST_STAT_ID_CHANGE_SQL', 'UPDATE request SET request_stat_id = ? WHERE id IN (%s)');
	// キャンセル料発生時期限など 第一引数 request_hotel_id
	define('CANCEL_CHARGE_LIST_SQL', 'SELECT * FROM (SELECT cancel_charge.id, cancel_charge.hotel_id, cancel_charge.sort_no, cancel_charge.term_from, cancel_charge.term_to, SUBDATE(checkin, INTERVAL charge_occur_from + 1 DAY) AS from_date, SUBDATE(checkin, INTERVAL charge_occur_to + 1 DAY) AS to_date, cancel_charge.charge_occur_from, cancel_charge.charge_occur_to, cancel_charge.charge_stat_id, cancel_charge.charge_percent, cancel_charge.remarks FROM request_hotel rh JOIN cancel_charge ON (rh.hotel_id = cancel_charge.hotel_id AND rh.deleted IS NULL AND cancel_charge.deleted IS NULL AND rh.id = ? AND term_from <= checkin AND checkin <= term_to)) cancel_charge');
	// バウチャーに必要なデータを取得します 第一引数 request_hotel_id 第二引数 ISOコード
	define('VAUCHER_DATA_SQL', 'SELECT * FROM (SELECT DISTINCT rh.*, h.tel AS hotel_tel, h.fax AS hotel_fax, h.email AS hotel_email, h.postcode AS hotel_postcode, hl.name AS hotel_name, hl.addr_1 AS hotel_addr_1, hl.addr_2 AS hotel_addr_2, hl.addr_3 AS hotel_addr_3, hrl.name AS hotel_room_name, btl.name AS breakfast_name, cl.name_long AS country, cil.name AS city, sl.name AS STATE, l.id AS language_id FROM request_hotel rh JOIN language l ON (rh.id = ? AND l.iso_code = ? AND rh.deleted IS NULL AND l.deleted IS NULL) JOIN hotel_language hl ON (hl.hotel_id = rh.hotel_id AND l.id = hl.language_id AND hl.deleted IS NULL) JOIN hotel h ON (rh.hotel_id = h.id AND h.deleted IS NULL) JOIN country_language cl ON (cl.country_id = h.country_id AND cl.language_id = l.id AND cl.deleted IS NULL) JOIN city_language cil ON (cil.city_id = h.city_id AND cil.language_id = l.id AND cil.deleted IS NULL) JOIN hotel_room hr ON (rh.hotel_room_id = hr.id AND hr.deleted IS NULL) JOIN hotel_room_language hrl ON (hr.id = hrl.hotel_room_id AND hrl.language_id = l.id AND hrl.deleted IS NULL) LEFT JOIN breakfast_type_language btl ON (hr.hotel_id = hr.breakfast_type_id = btl.breakfast_type_id AND btl.language_id = l.id AND btl.deleted IS NULL) LEFT JOIN state_language sl ON (sl.id = h.state_id AND sl.language_id = l.id AND sl.deleted IS NULL)) voucher_data');
	// 食事タイプリスト取得用 第一引数 ISOコード
	define('MEAL_TYPE_LIST_SQL', 'SELECT mtl.meal_type_id, mtl.name, mt.code FROM language l JOIN meal_type_language mtl ON (l.iso_code = ? AND l.id = mtl.language_id AND isnull(l.deleted) AND isnull(mtl.deleted)) JOIN meal_type mt ON (mtl.meal_type_id = mt.id AND mt.deleted IS NULL)');
	// 朝食タイプリスト取得用 第一引数 ISOコード
	define('BREAKFAST_TYPE_LIST_SQL', 'SELECT btl.breakfast_type_id, btl.name, bt.code FROM language l JOIN breakfast_type_language btl ON (l.iso_code = ? AND l.id = btl.language_id AND isnull(l.deleted) AND isnull(btl.deleted)) JOIN breakfast_type bt ON (btl.breakfast_type_id = bt.id AND bt.deleted IS NULL)');
	// ホテル設備リスト取得用 第一引数 ISOコード
	define('HOTEL_FACILITY_LIST_SQL', 'SELECT hfl.hotel_facility_id, hfl.name FROM language l JOIN hotel_facility_language hfl ON (l.id = hfl.language_id AND l.deleted IS NULL AND hfl.deleted IS NULL AND l.iso_code = ?) order by hfl.hotel_facility_id');
	// ホテルリンク設備リスト取得用 第一引数 ISOコード 第二引数 sprintfで条件を追加
	define('HOTEL_LINK_FACILITY_LIST_SQL', 'SELECT * FROM (SELECT hfl.name AS facility_name, hfl.hotel_facility_id as facility_id, hlf.* FROM language l JOIN hotel_facility_language hfl ON (l.id = hfl.language_id AND l.deleted IS NULL AND hfl.deleted IS NULL AND l.iso_code = ?) LEFT JOIN hotel_link_facility hlf ON (hlf.hotel_facility_id = hfl.hotel_facility_id AND hlf.deleted IS NULL %s) ORDER BY hfl.hotel_facility_id) hotel_link_facility');
	// ホテルグレードリスト取得用 第一引数 ISOコード
	define('HOTEL_GRADE_LIST_SQL', 'SELECT hgl.hotel_grade_id, hgl.name, hg.code FROM language l JOIN hotel_grade_language hgl ON (l.id = hgl.language_id AND l.deleted IS NULL AND hgl.deleted IS NULL AND l.iso_code = ?) JOIN hotel_grade hg ON (hgl.hotel_grade_id = hg.id AND hg.deleted IS NULL) ORDER BY hgl.name');
	// 部屋ベッドリスト取得用 第一引数 ISOコード
	define('ROOM_BED_LIST_SQL', 'SELECT rbl.room_bed_id, rbl.name, rb.code FROM language l JOIN room_bed_language rbl ON (l.id = rbl.language_id AND l.deleted IS NULL AND rbl.deleted IS NULL AND l.iso_code = ?) JOIN room_bed rb ON (rbl.room_bed_id = rb.id AND rb.deleted IS NULL) ORDER BY rbl.name');
	// タバコリスト取得用 第一引数 ISOコード
	define('SMOKING_LIST_SQL', 'SELECT sl.smoking_id, sl.name, s.code FROM language l JOIN smoking_language sl ON (l.id = sl.language_id AND l.deleted IS NULL AND sl.deleted IS NULL AND l.iso_code = ?) JOIN smoking s ON (sl.smoking_id = s.id AND s.deleted IS NULL) ORDER BY sl.name');
	// 部屋設備リスト取得用 第一引数 ISOコード
	define('ROOM_FACILITY_LIST_SQL', 'SELECT rfl.room_facility_id, rfl.name FROM language l JOIN room_facility_language rfl ON (l.id = rfl.language_id AND l.deleted IS NULL AND rfl.deleted IS NULL AND l.iso_code = ?) ORDER BY rfl.room_facility_id');
	// 部屋リンク設備リスト取得用 第一引数 ISOコード 第二引数 sprintfで条件を追加
	define('ROOM_LINK_FACILITY_LIST_SQL', 'SELECT * FROM (SELECT rfl.name AS facility_name, rfl.room_facility_id AS facility_id, hrlrf.* FROM language l JOIN room_facility_language rfl ON (l.id = rfl.language_id AND l.deleted IS NULL AND rfl.deleted IS NULL AND l.iso_code = ?) LEFT JOIN hotel_room_link_room_facility hrlrf ON (hrlrf.room_facility_id = rfl.room_facility_id AND hrlrf.deleted IS NULL %s) ORDER BY rfl.room_facility_id) room_link_facility');
	// 部屋グレードリスト取得用 第一引数 ISOコード
	define('ROOM_GRADE_LIST_SQL', 'SELECT rgl.room_grade_id, rgl.name, rg.code FROM language l JOIN room_grade_language rgl ON (l.id = rgl.language_id AND l.deleted IS NULL AND rgl.deleted IS NULL AND l.iso_code = ?) JOIN room_grade rg ON (rgl.room_grade_id = rg.code AND rg.deleted IS NULL) ORDER BY rgl.name');
	// ホテル言語リスト 使用言語分取得用(表示言語、またはその他保存されている言語でデータ取得) 第一引数 ISOコード 第二引数 hotel_id 第三引数 ISOコード 第四引数 hotel_id
	define('USED_HOTEL_LANGUAGE_SQL', 'SELECT hotel_language.* FROM hotel JOIN language ON (language.iso_code = ? AND language.deleted IS NULL) JOIN hotel_language ON (hotel.id = ? AND hotel.id = hotel_language.hotel_id AND hotel.deleted IS NULL AND hotel_language.deleted IS NULL AND language.id = hotel_language.language_id) UNION ALL SELECT hotel_language.* FROM hotel JOIN language ON (language.iso_code != ? AND language.deleted IS NULL) JOIN hotel_language ON (hotel.id = ? AND hotel.id = hotel_language.hotel_id AND hotel.deleted IS NULL AND hotel_language.deleted IS NULL AND language.id = hotel_language.language_id) LIMIT 1');
	// ホテル 表示ステータス一括更新用 第一引数 display_stat 第二引数 sprintfで id を指定
	define('HOTEL_DISPLAY_STAT_CHANGE_SQL', 'UPDATE hotel SET display_stat = ? WHERE id IN (%s)');
	// コンテンツ 提出書類一覧取得用 第一引数 ISOコード 第二引数 sprintfで branch_no を指定
	define('CONTENT_DOCUMENT_LIST_SQL', 'SELECT content_document.*, content_document_language.* FROM content_document JOIN language ON (language.iso_code = ? AND language.deleted IS NULL AND content_document.deleted IS NULL %1$s) LEFT JOIN content_document_language ON (language.id = content_document_language.language_id AND content_document_language.deleted IS NULL AND content_document_language.content_document_id = content_document.id %2$s) ORDER BY content_document.type_name, content_document_language.branch_no, content_document.file_name, content_document.id');
	// コンテンツ 提出書類削除用 第一引数 sprintfで content_document_id を指定
	define('CONTENT_DOCUMENT_TYPE_DELETE_SQL', 'UPDATE content_document SET deleted = sysdate() WHERE deleted IS null AND id IN (%s)');
	// コンテンツ 提出書類言語削除用 第一引数 sprintfで content_document_id を指定
	define('CONTENT_DOCUMENT_TYPE_LANGUAGE_DELETE_SQL', 'UPDATE content_document_language SET deleted = sysdate() WHERE deleted IS null AND content_document_id IN (%s)');
	// コンテンツ 提出書類削除用 第一引数 content_document_id
	define('CONTENT_DOCUMENT_DELETE_SQL', 'UPDATE content_document SET deleted = sysdate() WHERE deleted IS null AND id = ?');
	// コンテンツ 提出書類言語削除用 第一引数 content_document_id
	define('CONTENT_DOCUMENT_LANGUAGE_DELETE_SQL', 'UPDATE content_document_language SET deleted = sysdate() WHERE deleted IS null AND content_document_id = ?');
	// パスワード変更用 第一引数 パスワード 第二引数 ID
	define('CHANGE_PASSWORD_SQL', 'UPDATE admin_user SET password = ? WHERE id = ?');



?>
