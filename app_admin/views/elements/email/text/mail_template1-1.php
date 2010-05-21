<?php define('ENTER', "\n") ?>
<?php echo $request['first_name'].' '.$request['last_name']; ?>様

この度は<?php echo $system['system_name']; ?>をご利用いただきまして、
誠にありがとうございます。
以下の通りご予約が完了いたしました。

<?php $count = 0; ?>
<?php foreach($request_hotel as $hotel) { ?>
<?php if ($hotel['request_stat_id'] == REQUEST_STAT_NO_VACANCIES) { ?>
下記内容でお申し込みをいただきましたが、ご予約操作中に空室が全て埋まってしまい、
お部屋をお取りできませんでした。
大変申し訳ございませんでした。全額ご返金させていただきます。
カード決済を弊社にて取り消しさせていただきますが、締め日等タイミングによっては
一旦お客様へご請求がある場合がございますのでご了承下さい。
この度はご希望に添えず、申し訳ございませんでした。
<?php } else if ($hotel['request_stat_id'] == REQUEST_STAT_REQUEST) { ?>
ご予約が現地確認扱いとなりました。
現地ホテルへ問い合わせを行っており、通常48時間以内にホテルより回答がございます。
（弊社営業時間やホテルの都合等により回答が遅れる場合がございます）
成否が分かり次第、お客様へ成否をご連絡いたしますので、今しばらくお待ち下さい。
なお、ホテル側から満席回答があった場合は全額ご返金させていただきます。
カード決済を弊社にて取り消しさせていただきますが、締め日等タイミングによっては
一旦お客様へご請求がある場合がございますのでご了承下さい。
※リクエスト状態でのキャンセルは所定のキャンセル料を申し受けますのでご了承下さい。
<?php } ?>

▽宿泊者情報
<?php foreach($companion[$count] as $comp) { ?>
<?php if ($comp['pax_no'] == 0) { ?>
[ 宿泊者1(代表者) ]<?php echo $comp['first_name'].' '.$comp['last_name']; ?> 様 <?php echo $comp['age']; ?>歳 <?php echo $comp['gender']; ?>性
<?php } else { ?>
[ 宿泊者<?php echo $comp['pax_no']+1; ?> ]<?php echo $comp['first_name'].' '.$comp['last_name']; ?> 様 <?php echo $comp['age']; ?>歳 <?php echo $comp['gender']; ?>性
<?php } ?>
<?php } ?>

▽ご予約<?php echo $hotel['count']; ?><?php echo ENTER ?>
[ ご予約状況 ] <?php echo $hotel['request_stat']; ?><?php echo ENTER ?>
[ ホテル名 ] <?php echo $hotel['hotel']; ?><?php echo ENTER ?>
<?php
$addr = '';
$addr .= !empty($hotel['addr_3']) ? (empty($addr) ? $hotel['addr_3'] : ','.$hotel['addr_3']) : '';
$addr .= !empty($hotel['addr_2']) ? (empty($addr) ? $hotel['addr_2'] : ','.$hotel['addr_2']) : '';
$addr .= !empty($hotel['addr_1']) ? (empty($addr) ? $hotel['addr_1'] : ','.$hotel['addr_1']) : '';
$addr .= !empty($hotel['city']) ? (empty($addr) ? $hotel['city'] : ','.$hotel['city']) : '';
$addr .= !empty($hotel['state']) ? (empty($addr) ? $hotel['state'] : ','.$hotel['state']) : '';
$addr .= !empty($hotel['country']) ? (empty($addr) ? $hotel['country'] : ','.$hotel['country']) : '';
$addr .= !empty($hotel['area']) ? (empty($addr) ? $hotel['area'] : ','.$hotel['area']) : '';
$addr .= !empty($hotel['postcode']) ? (empty($addr) ? $hotel['postcode'] : ','.$hotel['postcode']) : '';
?>
[ 所在地 ] <?php echo $addr; ?><?php echo ENTER ?>
[ TEL ] <?php echo $hotel['tel']; ?><?php echo ENTER ?>
[ FAX ] <?php echo $hotel['fax']; ?><?php echo ENTER ?>
[ チェックイン日 ] <?php echo $hotel['checkin']['year'].'/'.$hotel['checkin']['month'].'/'.$hotel['checkin']['day']; ?><?php echo ENTER ?>
[ チェックアウト日 ] <?php echo $hotel['checkout']['year'].'/'.$hotel['checkout']['month'].'/'.$hotel['checkout']['day']; ?><?php echo ENTER ?>
[ ご利用泊数 ] <?php echo $hotel['stay_count']; ?>泊
[ 部屋タイプ ] <?php echo $hotel['hotel_room']; ?><?php echo ENTER ?>
[ 朝食 ] <?php echo empty($hotel['breakfast_name']) ? 'Not Included' : $hotel['breakfast_name']; ?><?php echo ENTER ?>
<?php if ($hotel['request_stat_id'] == REQUEST_STAT_REQUEST_RESERVED || $hotel['request_stat_id'] == REQUEST_STAT_REQUEST_RESERVED_REMARKS_CHECKED) { ?>
[ BookingID ] <?php echo $hotel['hotel_agent_ref']; ?><?php echo ENTER ?>
[ バウチャーURL ] <?php echo $hotel['voucher_url']; ?><?php echo ENTER ?>
<?php } ?>
[ キャンセル期限 ]
<?php if (empty($hotel['limit_date']['year'])) { ?>
<?php echo $hotel['limit_date']['year'].'/'.$hotel['limit_date']['month'].'/'.$hotel['limit_date']['day'] ?>日以前：宿泊料金の3％（キャンセル手数料）
<?php } ?>
<?php foreach($hotel['cancel_charge'] as $charge) { ?>
<?php if ($charge['charge_occur_from'] == 0 && $charge['charge_occur_to'] == 0) { ?>
キャンセルされた場合:<?php echo CANCEL_CHARGE_TYPE_1 == $charge['charge_stat_id'] ? '最初の1泊分の'.$charge['charge_percent'].'%のキャンセル料' : '宿泊料金の'.$charge['charge_percent'].'%のキャンセル料'; ?><?php echo ENTER ?>
<?php } else if ($charge['charge_occur_from'] == 0) { ?>
<?php echo $charge['to_date']['year']; ?>年<?php echo $charge['to_date']['month']; ?>月<?php echo $charge['to_date']['day']; ?>日 までにキャンセルされた場合:<?php echo CANCEL_CHARGE_TYPE_1 == $charge['charge_stat_id'] ? '最初の1泊分の'.$charge['charge_percent'].'%のキャンセル料' : '宿泊料金の'.$charge['charge_percent'].'%のキャンセル料'; ?><?php echo ENTER ?>
<?php } ?>
<?php echo $charge['from_date']['year']; ?>年<?php echo $charge['from_date']['month']; ?>月<?php echo $charge['from_date']['day']; ?>日 ～ <?php echo $charge['to_date']['year']; ?>年<?php echo $charge['to_date']['month']; ?>月<?php echo $charge['to_date']['day']; ?>日にキャンセルされた場合:<?php echo CANCEL_CHARGE_TYPE_1 == $charge['charge_stat_id'] ? '最初の1泊分の'.$charge['charge_percent'].'%のキャンセル料' : '宿泊料金の'.$charge['charge_percent'].'%のキャンセル料'; ?><?php echo ENTER ?>
<?php } ?>
[ その他ご要望 ]<?php echo $hotel['comment'] ?><?php echo ENTER ?>
※ご要望はホテルにお伝えいたしますが、確約はいたしかねますのでご了承下さい。
<?php $count++; ?>
<?php } ?>

[ 受付日 ]<?php echo $request['request_date']['year']; ?>年<?php echo $request['request_date']['month']; ?>月<?php echo $request['request_date']['day']; ?>日

▽料金
支払い方法：カード決済
総額 : <?php echo $request['price'].' '.$request['currency']; ?><?php echo ENTER ?>


<?php if ($request['request_payment_id'] == REQUEST_PAYMENT_CREDIT || $request['request_payment_id'] == REQUEST_PAYMENT_SALES_PROCESSING_COMPLETION) { ?>
カード決済が完了致しました。
予約時にご入力頂いたカードに株式会社サイバートラベル(もしくは格安トラベル)より請求いたします。
<?php } ?>

↓↓↓↓↓↓↓↓↓必ずお読み下さい↓↓↓↓↓↓↓↓↓

■チェックイン
※ご予約のお部屋の確保は保証されておりますが、ホテル到着が大幅に遅れる場合
（現地時間でチェックイン当日の18時を 越える場合）は、直接ホテルへ電話連絡してください。
※「バウチャー」を必ず印刷し、チェックイン時にフロントにてご提示下さい
※ツアー番号をたずねられた場合は、「バウチャー」またはこの「予約確認メール」
にある番号をお伝えください。

■予約確認
※お客様のご予約情報はチェックイン日の約3日前を目安にホテルへ連絡いたしますので、
ホテルに直接お問い合わせされる 場合はご注意ください。

■変更・取消について
宿泊の変更・取り消しが生じた場合は速やかにご連絡下さい。

■現地緊急連絡
※緊急の場合には、「緊急連絡先」にて電話でのご予約変更・キャンセルをお受けいたします。
※万一、お客様のご都合や何らかの事情でチェックイン当日にホテルに到着できない場合は必ず
「バウチャー（英語）」 にある「緊急連絡先」にご連絡ください。

▽注意事項
ツインルームやトリプルルームのベッドの数は、必ずしも人数と一致いたしません。
ホテルによっては、ツインルームにダブルベッド(１台)を設置し、トリプルには
ツインルームに簡易ベッドもしくはソファーベッドを設置するところもございますのでご了承ください。

▽キャンセルポリシー
■変更・取消料/変更・取消手数料
予約詳細の通り。
ただし、変更・取消料がかからない期間での変更・取消は、変更・取消手数料としてご予約総額の3%を頂戴いたします。

※ 手数料は、変更・取消の弊社確認日時（日本時間）を起点に計算いたします。
※ チェックイン日の18時までにご連絡なしに宿泊されなかった場合（NO-SHOW）残りの予約は全てキャンセルされます。
この際、宿泊代金は返金できませんのでご了承ください。
※受付時間が「対応時間」外の場合は、翌営業日以降に処理いたします。
※処理する日時によっては変更・キャンセル料が発生する場合もございますので、ご了承ください。
※基本的に、メールでの受付とさせていただきます。緊急時のみお電話ください。

■「格安トラベル」コールセンター
　対応言語　　　	：　日本語
　対応時間　　　	：　月曜から金曜日　11:00から18:00（日本時間）
　定休日　　　　	：　土曜・日曜・祝祭日・年末年始
　対応内容　　　	：　変更・キャンセルのみ
　メールアドレス	：　hotel@kakuyasutravel.com
　電話番号　　　	：　03-5774-5805（緊急時のみ）

<?php echo $this->renderElement('/email/text/hotel_company'); ?>