<?php

$script = '';
$base_url = '/app_admin/request/';
$option_html = 'type: "POST", dataType: "html", timeout: 10000,';

$cls_send_mail = '#RequestDataMailTemplateId';
$cls_mail_contents = '#RequestDataMailTemplateContents';
$mail_template_id = '$("select#RequestDataMailTemplateId option:selected").val()';
$mail_template_id_url = '+'.$mail_template_id.'+"/';
$mail_template_url = $base_url.'change_mail_template/"'.$mail_template_id_url;
$mail_template_func = 'function(data) { $("'.$cls_mail_contents.'").html(data); }';
$opt_mail_template = '{ url: "'.$mail_template_url.'", '.$option_html.' success: '.$mail_template_func.' }';

$mailtemplate_opt = '$(document).ready(function() { $("'.$cls_send_mail.'").change(function() { $.ajax('.$opt_mail_template.') }); });';

for ($count = 0; $count < 4; $count++) {
	$cls_area = '#RequestDataRequestHotel'.$count.'AreaId';
	$cls_country = '#RequestDataRequestHotel'.$count.'CountryId';
	$cls_state = '#RequestDataRequestHotel'.$count.'StateId';
	$cls_city = '#RequestDataRequestHotel'.$count.'CityId';
	$cls_hotel = '#RequestDataRequestHotel'.$count.'HotelId';
	$cls_room = '#RequestDataRequestHotel'.$count.'HotelRoomId';
	$cls_agent = '#RequestDataRequestHotel'.$count.'HotelAgentId';
	$cls_room_data = '#RequestDataRequestHotel'.$count.'RoomData';

	$area_id = '$("select#RequestDataRequestHotel'.$count.'AreaId option:selected").val()';
	$country_id = '$("select#RequestDataRequestHotel'.$count.'CountryId option:selected").val()';
	$state_id = '$("select#RequestDataRequestHotel'.$count.'StateId option:selected").val()';
	$city_id = '$("select#RequestDataRequestHotel'.$count.'CityId option:selected").val()';
	$hotel_id = '$("select#RequestDataRequestHotel'.$count.'HotelId option:selected").val()';
	$agent_id = '$("select#RequestDataRequestHotel'.$count.'HotelAgentId option:selected").val()';
	$room_id = '$("select#RequestDataRequestHotel'.$count.'HotelRoomId option:selected").val()';

	$area_id_url = '+'.$area_id.'+"/';
	$country_id_url = '+'.$country_id.'+"/';
	$state_id_url = '+'.$state_id.'+"/';
	$city_id_url = '+'.$city_id.'+"/';
	$hotel_id_url = '+'.$hotel_id.'+"/';
	$agent_id_url = '+'.$agent_id.'+"/';
	$room_id_url = '+'.$room_id.'+"/';
	$count_url = '+'.$count.'+"/';

	$area_url = $base_url.'change_area/"'.$area_id_url;
	$country_url = $base_url.'change_country/"'.$area_id_url.'"'.$country_id_url;
	$state_url = $base_url.'change_state/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url;
	$city_url = $base_url.'change_city/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url.'"'.$city_id_url;
	$hotel_url = $base_url.'change_hotel/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url.'"'.$city_id_url.'"'.$hotel_id_url.'"'.$agent_id_url;
	$room_url = $base_url.'change_room/"'.$room_id_url.'"'.$count_url;

	$area_func = 'function(data) { $("'.$cls_country.'").html(data); }';
	$country_func = 'function(data) { $("'.$cls_state.'").html(data); }';
	$state_func = 'function(data) { $("'.$cls_city.'").html(data); }';
	$city_func = 'function(data) { $("'.$cls_hotel.'").html(data); }';
	$hotel_func = 'function(data) { $("'.$cls_room.'").html(data); }';
	$room_func = 'function(data) { $("'.$cls_room_data.'").html(data); }';

	$opt_room = '{ url: "'.$room_url.'", '.$option_html.' success: '.$room_func.' }';
//	$opt_hotel = '{ url: "'.$hotel_url.'", '.$option_html.' success: '.$hotel_func.' }';
	$opt_hotel = '{ url: "'.$hotel_url.'", '.$option_html.' success: '.$hotel_func.', complete : function() { $.ajax('.$opt_room.') }}';
	$opt_city = '{ url: "'.$city_url.'", '.$option_html.' success: '.$city_func.', complete : function() { $.ajax('.$opt_hotel.') }}';
	$opt_state = '{ url: "'.$state_url.'", '.$option_html.' success: '.$state_func.', complete : function() { $.ajax('.$opt_city.') }}';
	$opt_country = '{ url: "'.$country_url.'", '.$option_html.' success: '.$country_func.', complete : function() { $.ajax('.$opt_state.') }}';
	$opt_area = '{ url: "'.$area_url.'", '.$option_html.' success: '.$area_func.', complete : function() {$.ajax('.$opt_country.') }}';


//	$.ajax(option1);


	$script .= '
		$(document).ready(function() {

			$("'.$cls_area.'").change(function() {
				$.ajax('.$opt_area.')
			});
			$("'.$cls_country.'").change(function() {
				$.ajax('.$opt_country.')
			});
			$("'.$cls_state.'").change(function() {
				$.ajax('.$opt_state.')
			});
			$("'.$cls_city.'").change(function() {
				$.ajax('.$opt_city.')
			});
			$("'.$cls_hotel.'").change(function() {
				$.ajax('.$opt_hotel.')
			});
			$("'.$cls_agent.'").change(function() {
				$.ajax('.$opt_hotel.')
			});
			$("'.$cls_room.'").change(function() {
				$.ajax('.$opt_room.')
			});
});';
}

	//                                      ↓ この空白ないとエラーになるし、JSPROGの直後は改行じゃないとだめ
	$this->addScript($javascript->codeBlock( <<<JSPROG
	$script
	$mailtemplate_opt
JSPROG
	));
//↑JSPROGの前に空白文字列とか入れるとエラーになる


?>
<div id="top">
	<div id="header">
		<h1><?php __('申込管理'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<div class="rgiht-menu">
			<a href="#bord"><?php echo __('伝言板') ?></a><br />
			<a href="#booking"><?php echo __('予約情報') ?></a><br />
			<a href="#visitor"><?php echo __('お客様情報') ?></a><br />
			<a href="#voucher"><?php echo __('領収書') ?></a><br />
			<a href="#mail"><?php echo __('メール配信') ?></a><br />
			</div>

			<h2><a id="bord"><?php __('申込データ保存'); ?></a></h2>
			<p>

			<?php echo $form->create('RequestData', array('type' => 'post', 'action' => '/save' ,'name' => 'form_request_edit', 'url'=>array('controller'=>'request'))); ?>
				<?php $message1 = __('保存してよろしいですか。', true); ?>
				<?php echo $form->button(__('データ保存',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/save\', \'' . $message1 . '\');')); ?>
				<?php $message2 = __('削除してよろしいですか。', true); ?>
				<?php echo $form->button(__('データ削除',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/delete\', \'' . $message2 . '\');')); ?>
				<br />
				<br />

				<table>
					<tr>
						<th><?php echo __('伝言板') ?></th>
						<td>
							<?php echo $form->textarea('RequestData.Request.message_bord', array('cols' => '80', 'rows' => '10', 'wrap' => 'off', 'label' => '', 'value'=>$request['message_bord'])); ?>
							<?php echo $form->error('RequestData.Request.message_bord'); ?>
						</td>
					</tr>
				</table>

				<br />

				<table>
					<tr>
						<th><?php echo __('担当') ?></th>
						<th><?php echo __('状態') ?></th>
						<th><?php echo __('決済') ?></th>
						<th><?php echo __('決済通貨') ?></th>
						<th><?php echo __('申込日') ?></th>
					</tr>
					<tr>
						<td>
							<?php
								$opt = array();
								foreach ($admin_user as $adm) {
									$opt[trim($adm['admin_user']['id'])] = $adm['admin_user']['name'];
								}
								$request['admin_user_id'] = empty($request['admin_user_id']) ? $loginUser['id'] : $request['admin_user_id'];
								echo ($form->input('RequestData.Request.admin_user_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['admin_user_id'])));
							?>
							<?php echo $form->error('RequestData.Request.admin_user_id'); ?>
						</td>
						<td>
							<?php
								$opt = array();
								foreach ($request_stat as $rs) {
									$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
								}
								$request['request_stat_id'] = empty($request['request_stat_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['request_stat_id'];
								echo ($form->input('RequestData.Request.request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['request_stat_id'])));
							?>
							<?php echo $form->error('RequestData.Request.request_stat_id'); ?>
						</td>
						<td>
							<?php
								$opt = array();
								foreach ($request_payment as $rp) {
									$opt[trim($rp['rpl']['request_payment_id'])] = $rp['rpl']['name'];
								}
								$request['request_payment_id'] = empty($request['request_payment_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['request_payment_id'];
								echo ($form->input('RequestData.Request.request_payment_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['request_payment_id'])));
							?>
							<?php echo $form->error('RequestData.Request.request_payment_id'); ?>
						</td>
						<td>
							<?php
								$opt = array();
								foreach ($currency as $cur) {
									$opt[trim($cur['currency']['currency_id'])] = $cur['currency']['iso_code_a'].CURRENCY_DELIMITER.$cur['currency']['country_name'].CURRENCY_DELIMITER.$cur['currency']['currency_name'];
								}
								$request['currency_id'] = empty($request['currency_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['currency_id'];
								echo ($form->input('RequestData.Request.currency_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['currency_id'])));
							?>
							<?php echo $form->error('RequestData.Request.currency_id'); ?>
						</td>
						<td>
							<?php
								$default = $construct->toArray($request['request_date']);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('RequestData.Request.request_date', 'YMD', 'NONE', $default, $attr, false);
							?>
							<?php echo $form->error('RequestData.Request.request_date'); ?>
						</td>
					</tr>
				</table>
				<br />
			</p>

			<h2><a id="booking"><?php echo __('予約情報') ?></a></h2>
			<p>

			<?php echo $form->button(__('予約情報更新',true), array('div' => 'false', 'onclick' => 'regist_no_message(\'form_mail\', \'/app_admin/request/refresh\', \');')); ?>
			<?php for ($count=0; $count <= 3; $count++) { ?>
				<table>
					<tr>
						<th><?php echo __('予約情報') ?></th>
						<td>
							<?php
								$opt = array();
								foreach ($individual_request_stat as $irs) {
									$opt[trim($irs['rsl']['request_stat_id'])] = $irs['rsl']['name'];
								}
								$request_hotel[$count]['request_stat_id'] = empty($request_hotel[$count]['request_stat_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request_hotel[$count]['request_stat_id'];
								echo ($form->input('RequestData.RequestHotel.'.$count.'.request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['request_stat_id'])));
							?>
							<?php echo $form->error('RequestData.RequestHotel.'.$count.'.request_stat_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('ホールセラー') ?></th>
						<td>
							<?php
								$opt = array();
								$first_agent = null;
								foreach ($hotel_agent as $ha) {
									$opt[trim($ha['hotel_agent']['id'])] = $ha['hotel_agent']['name'];
									if (is_null($first_agent)) {
										$first_agent = trim($ha['hotel_agent']['id']);
									}
								}
								$request_hotel[$count]['hotel_agent_id'] = empty($request_hotel[$count]['hotel_agent_id']) ? $first_agent : $request_hotel[$count]['hotel_agent_id'];
								echo ($form->input('RequestData.RequestHotel.'.$count.'.hotel_agent_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_agent_id'])));
							?>
							<?php echo $form->error('RequestData.RequestHotel.'.$count.'.hotel_agent_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('予約ID') ?></th>
						<td>
							<?php echo __('BookingID' ,true).$form->text('RequestData.RequestHotel.'.$count.'.hotel_agent_ref', array('size' => '30', 'value'=>$request_hotel[$count]['hotel_agent_ref'])); ?>
							<?php echo $form->error('RequestData.RequestHotel.'.$count.'.hotel_agent_ref'); ?>
							<?php echo __('BookingItemID' ,true).$form->text('RequestData.RequestHotel.'.$count.'.hotel_agent_item', array('size' => '30', 'value'=>$request_hotel[$count]['hotel_agent_item'])); ?>
							<?php echo $form->error('RequestData.RequestHotel.'.$count.'.hotel_agent_item'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('ホテル詳細') ?></th>
						<td>
							<table class="no_border">
								<tr class="no_border">
									<td class="no_border">
										<?php
											$opt = array();
											foreach ($area as $ara) {
												$opt[trim($ara['al']['area_id'])] = $ara['al']['name'];
											}
											$request_hotel[$count]['area_id'] = empty($request_hotel[$count]['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['area_id'];
											echo __('エリア' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo $form->input('RequestData.RequestHotel.'.$count.'.area_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['area_id']));
											echo $form->error('RequestHotel.'.$count.'.area_id');
										?>
									</td>
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($countrys[$count])) {
												foreach ($countrys[$count] as $cnt) {
													$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
												}
											}
											$request_hotel[$count]['country_id'] = empty($request_hotel[$count]['country_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['country_id'];
											echo __('国' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('RequestData.RequestHotel.'.$count.'.country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['country_id'])));
											echo $form->error('RequestHotel.'.$count.'.country_id');
										 ?>
									</td>
								</tr>
								<tr class="no_border">
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($states[$count])) {
												foreach ($states[$count] as $sta) {
													$opt[trim($sta['sl']['state_id'])] = $sta['sl']['name'];
												}
											}
											$request_hotel[$count]['state_id'] = empty($request_hotel[$count]['state_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['state_id'];
											echo __('州' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('RequestData.RequestHotel.'.$count.'.state_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['state_id'])));
											echo $form->error('RequestHotel.'.$count.'.state_id');
										 ?>
									</td>
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($citys[$count])) {
												foreach ($citys[$count] as $cty) {
													$opt[trim($cty['cl']['city_id'])] = $cty['cl']['name'];
												}
											}
											$request_hotel[$count]['city_id'] = empty($request_hotel[$count]['city_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['city_id'];
											echo __('都市' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('RequestData.RequestHotel.'.$count.'.city_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['city_id'])));
											echo $form->error('RequestHotel.'.$count.'.city_id');
										 ?>
									</td>
								</tr>
								<tr class="no_border">
									<td class="no_border">
										<?php
										$opt = array();
											if (!empty($hotels[$count])) {
												foreach ($hotels[$count] as $htl) {
													$opt[trim($htl['hl']['hotel_id'])] = $htl['hl']['name'];
												}
											}
											$request_hotel[$count]['hotel_id'] = empty($request_hotel[$count]['hotel_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['hotel_id'];
											echo __('ホテル' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('RequestData.RequestHotel.'.$count.'.hotel_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_id'])));
											echo $form->error('RequestHotel.'.$count.'.hotel_id');
										 ?>
									</td>
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($hotel_rooms[$count])) {
												foreach ($hotel_rooms[$count] as $hr) {
													$opt[trim($hr['hrl']['hotel_room_id'])] = $hr['hrl']['name'];
												}
											}
											$request_hotel[$count]['hotel_room_id'] = empty($request_hotel[$count]['hotel_room_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['hotel_room_id'];
											echo __('部屋' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('RequestData.RequestHotel.'.$count.'.hotel_room_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_room_id'])));
											echo $form->error('RequestHotel.'.$count.'.hotel_room_id');
										 ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th><?php echo __('チェックイン') ?></th>
						<td>
							<?php
								$default = $construct->toArray($request_hotel[$count]['checkin']);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								if (empty($request_hotel[$count]['checkin'])) {
									$default = null;
								}
								echo $form->dateTime('RequestHotel.'.$count.'.checkin', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('RequestHotel.'.$count.'.checkin'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('チェックアウト') ?></th>
						<td>
							<?php
								$default = $construct->toArray($request_hotel[$count]['checkout']);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								if (empty($request_hotel[$count]['checkout'])) {
									$default = null;
								}
								echo $form->dateTime('RequestHotel.'.$count.'.checkout', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('RequestHotel.'.$count.'.checkout'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('キャンセル期限') ?></th>
						<td>
							<?php
								$default = $construct->toArray($request_hotel[$count]['limit_date']);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								if (empty($request_hotel[$count]['limit_date'])) {
									$default = null;
								}
								echo $form->dateTime('RequestHotel.'.$count.'.limit_date', 'YMD', 'NONE', $default, $attr, true);
								echo '  '.$form->hour('RequestHotel.'.$count.'.limit_date', true, $default['hour'], array(), true);
							?>
							<?php echo $form->error('RequestHotel.'.$count.'.limit_date'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('部屋情報') ?></th>
						<td>
							<?php
								if (!empty($request_hotel[$count]['hotel_id']) && !empty($request_hotel[$count]['hotel_room_id'])) {
							 ?>
							<div id="RequestDataRequestHotel<?php echo $count ?>RoomData">
								<?php $room_detail = $room_data[$count]; ?>
								<?php if (!empty($room_detail)) { ?>
									<table class="font-size10pt">
										<tr class="font-size10pt">
											<th class="font-size10pt"><?php __('食事'); ?></th>
											<td class="font-size10pt">
												<?php
													echo $room_detail['room_data']['meal_name'];
												?>
											</td>
											<th class="font-size10pt"><?php __('朝食'); ?></th>
											<td class="font-size10pt">
												<?php
													echo $room_detail['room_data']['breakfast_name'];
												?>
											</td>
										</tr>
										<tr class="font-size10pt">
											<th class="font-size10pt"><?php __('風呂'); ?></th>
											<td class="font-size10pt" colspan="3">
												<?php
													echo $room_detail['room_data']['bath_name'];
												?>
											</td>
										</tr>
										<tr class="font-size10pt">
											<th class="font-size10pt"><?php __('料金'); ?></th>
											<td class="font-size10pt">
												<?php
													echo $number->format($room_detail['room_data']['price'], array('places' => PRICE_PLACES, 'before' => false, 'escape' => false, 'decimals' => '.', 'thousands' => ','));
													echo $form->input('RequestData.RequestHotel.'.$count.'.price', array('type'=>'hidden', 'value'=>$room_detail['room_data']['price']));
													echo $form->input('RequestData.RequestHotel.'.$count.'.point', array('type'=>'hidden', 'value'=>$room_detail['room_data']['point']));
												?>
											</td>
											<th class="font-size10pt"><?php __('通貨'); ?></th>
											<td class="font-size10pt">
												<?php
													echo $room_detail['room_data']['currency_name'];
													echo $form->input('RequestData.RequestHotel.'.$count.'.currency_id', array('type'=>'hidden', 'value'=>$room_detail['room_data']['currency_id']));
												?>
											</td>
										</tr>
									</table>
								<?php } ?>
							</div>
							<?php
								} else {
							 ?>
							<div id="RequestDataRequestHotel<?php echo $count ?>RoomData"></div>
							<?php
								}
							 ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('備考'); ?></th>
						<td>
							<?php echo $form->textarea('RequestData.RequestHotel.'.$count.'.comment', array('cols' => '40', 'rows' => '3', 'wrap' => 'off', 'label' => '', 'value'=>$request_hotel[$count]['comment'])); ?>
							<?php echo $form->error('RequestData.RequestHotel.'.$count.'.comment'); ?>
						</td>
					</tr>
				</table>
				<br />
			<?php } ?>

			<h2><a id="visitor"><?php echo __('お客様情報') ?></a></h2>
			<p>

				<table>
					<tr>
						<th><?php echo __('ID') ?></th>
						<td>
							<?php echo $request['customer_user_id']; ?>
							<?php echo $form->input('RequestData.Request.customer_user_id', array('type'=>'hidden', 'value'=>$request['customer_user_id'])); ?>
							<?php echo $form->input('RequestData.Request.country_id', array('type'=>'hidden', 'value'=>$request['country_id'])); ?>
							<?php echo $form->input('RequestData.Request.language_id', array('type'=>'hidden', 'value'=>$request['language_id'])); ?>
							<?php echo $form->input('RequestData.Request.first_name', array('type'=>'hidden', 'value'=>$request['first_name'])); ?>
							<?php echo $form->input('RequestData.Request.last_name', array('type'=>'hidden', 'value'=>$request['last_name'])); ?>
							<?php echo $form->input('RequestData.Request.gender_id', array('type'=>'hidden', 'value'=>$request['gender_id'])); ?>
							<?php echo $form->input('RequestData.Request.age', array('type'=>'hidden', 'value'=>$request['age'])); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('代表者') ?></th>
						<td>
							<?php echo __('名：', true).$form->text('RequestData.RequestHotelCustomerUser.0.first_name', array('size' => '25', 'value'=>$request_hotel_customer_user[0]['first_name'])); ?>
							<?php echo $form->error('first_name'); ?>
							<?php echo __('姓：', true).$form->text('RequestData.RequestHotelCustomerUser.0.last_name', array('size' => '25', 'value'=>$request_hotel_customer_user[0]['last_name'])); ?>
							<?php echo $form->error('last_name'); ?>
							<?php echo __('歳：', true).$form->text('RequestData.RequestHotelCustomerUser.0.age', array('size' => '3', 'value'=>$request_hotel_customer_user[0]['age'])); ?>
							<?php echo $form->error('age'); ?>
							<?php
								$opt = array();
								foreach ($gender as $gnd) {
									$opt[trim($gnd['gl']['gender_id'])] = $gnd['gl']['name'];
								}
								$request_hotel_customer_user[0]['gender_id'] = empty($request_hotel_customer_user[0]['gender_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel_customer_user[0]['gender_id'];
								echo ($form->input('RequestData.RequestHotelCustomerUser.0.gender_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[0]['gender_id'])));
							?>
							<?php echo $form->error('gender_id'); ?>
							<?php
//								$opt = array();
//								foreach ($adult as $adt) {
//									$opt[trim($adt['mil']['code_id'])] = $adt['mil']['name'];
//								}
//								echo ($form->input('RequestData.RequestHotelCustomerUser.0.adult_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE, 'disabled' => true)));
							?>
							<?php echo $form->hidden('RequestData.RequestHotelCustomerUser.0.leader', array('value'=>DEFAULT_SELECTED_VALUE_ONE)) ?>
							<?php echo $form->hidden('RequestData.RequestHotelCustomerUser.0.adult', array('value'=>DEFAULT_SELECTED_VALUE_ONE)) ?>
						</td>
					</tr>
					<?php for ($count = 1; $count <= 6; $count++) { ?>
						<tr>
							<th><?php echo __('同行者').$count ?></th>
							<td>
								<?php echo __('名：', true).$form->text('RequestData.RequestHotelCustomerUser.'.$count.'.first_name', array('size' => '25', 'value'=>$request_hotel_customer_user[$count]['first_name'])); ?>
								<?php echo $form->error('RequestData.RequestHotelCustomerUser.'.$count.'first_name'); ?>
								<?php echo __('姓：', true).$form->text('RequestData.RequestHotelCustomerUser.'.$count.'.last_name', array('size' => '25', 'value'=>$request_hotel_customer_user[$count]['last_name'])); ?>
								<?php echo $form->error('RequestData.RequestHotelCustomerUser.'.$count.'last_name'); ?>
								<?php echo __('歳：', true).$form->text('RequestData.RequestHotelCustomerUser.'.$count.'.age', array('size' => '3', 'value'=>$request_hotel_customer_user[$count]['age'])); ?>
								<?php echo $form->error('RequestData.RequestHotelCustomerUser.'.$count.'age'); ?>
								<?php
									$opt = array();
									foreach ($gender as $gnd) {
										$opt[trim($gnd['gl']['gender_id'])] = $gnd['gl']['name'];
									}
									$request_hotel_customer_user[$count]['gender_id'] = empty($request_hotel_customer_user[$count]['gender_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel_customer_user[$count]['gender_id'];
									echo ($form->input('RequestData.RequestHotelCustomerUser.'.$count.'.gender_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[$count]['gender_id'])));
								?>
								<?php echo $form->error('RequestData.RequestHotelCustomerUser.'.$count.'gender_id'); ?>
								<?php
									$opt = array();
									foreach ($adult as $adt) {
										$opt[trim($adt['mil']['code_id'])] = $adt['mil']['name'];
									}
									$request_hotel_customer_user['adult'] = empty($request_hotel_customer_user['adult']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel_customer_user['adult'];
									echo ($form->input('RequestData.RequestHotelCustomerUser.'.$count.'.adult', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[$count]['adult'])));
								?>
								<?php echo $form->error('RequestData.RequestHotelCustomerUser.'.$count.'.adult'); ?>
								<?php echo $form->hidden('RequestData.RequestHotelCustomerUser.'.$count.'.leader', array('value'=>DEFAULT_SELECTED_VALUE_ZERO)) ?>
								<input type="button" value="削除" onclick="clear_tgt_customer_data('<?php echo $count ?>')">
							</td>
						</tr>
					<?php } ?>
					<tr>
						<th><?php echo __('TEL'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.tel', array('size' => '50', 'value'=>$request['tel'])); ?>
							<?php echo $form->error('RequestData.Request.tel'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('携帯'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.tel_mobile', array('size' => '50', 'value'=>$request['tel_mobile'])); ?>
							<?php echo $form->error('RequestData.Request.tel_mobile'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('FAX'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.fax', array('size' => '50', 'value'=>$request['fax'])); ?>
							<?php echo $form->error('RequestData.Request.fax'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('メールアドレス'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.email', array('size' => '50', 'value'=>$request['email'])); ?>
							<?php echo $form->error('RequestData.Request.email'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('携帯メールアドレス'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.email_mobile', array('size' => '50', 'value'=>$request['email_mobile'])); ?>
							<?php echo $form->error('RequestData.Request.email_mobile'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('郵便番号'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.postcode', array('size' => '50', 'value'=>$request['postcode'])); ?>
							<?php echo $form->error('RequestData.Request.postcode'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所 国'); ?></th>
						<td>
							<?php
								$opt = array();
								$first_id = null;
								foreach ($country as $cnt) {
									$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									if (is_null($first_id)) { $first_id = $cnt['cl']['country_id']; }
								}
								$request['addr_country_id'] = empty($request['addr_country_id']) ? $first_id : $request['addr_country_id'];
								$selected = $request['addr_country_id'];
								echo ($form->input('RequestData.Request.addr_country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
							?>
							<?php echo $form->error('RequestData.Request.addr_country_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所1'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.addr_1', array('size' => '50', 'value'=>$request['addr_1'])); ?>
							<?php echo $form->error('RequestData.Request.addr_1'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所2'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.addr_2', array('size' => '50', 'value'=>$request['addr_2'])); ?>
							<?php echo $form->error('RequestData.Request.addr_2'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所3'); ?></th>
						<td>
							<?php echo $form->text('RequestData.Request.addr_3', array('size' => '50', 'value'=>$request['addr_3'])); ?>
							<?php echo $form->error('RequestData.Request.addr_3'); ?>
						</td>
					</tr>
				</table>

				<br />

				<table>
					<tr>
						<th colspan="2"><a id="voucher"><?php echo __('領収書') ?></a></th>
					</tr>
					<tr>
						<td colspan="2" class="align-center">
							<?php
								$opt = array();
								foreach ($receipt_status as $rs) {
									$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
								}
								$request_receipt['request_receipt']['request_receipt']['status'] = empty($request_receipt['request_receipt']['status']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_receipt['request_receipt']['status'];
								echo ($form->input('RequestData.RequestReceipt.status', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_receipt['request_receipt']['status'])));
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('領収書宛名'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.name', array('size' => '50', 'value'=>$request_receipt['request_receipt']['name'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.name'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('ご郵送先宛名'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.postname', array('size' => '50', 'value'=>$request_receipt['request_receipt']['postname'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.postname'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('郵便番号'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.postcode', array('size' => '50', 'value'=>$request_receipt['request_receipt']['postcode'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.postcode'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所 国'); ?></th>
						<td>
							<?php
								$opt = array();
								$first_id = null;
								foreach ($country as $cnt) {
									$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									if (is_null($first_id)) { $first_id = $cnt['cl']['country_id']; }
								}
								$request_receipt['request_receipt']['addr_country_id'] = empty($request_receipt['request_receipt']['addr_country_id']) ? $first_id : $request_receipt['request_receipt']['addr_country_id'];
								$selected = $request_receipt['request_receipt']['addr_country_id'];
								echo ($form->input('RequestData.RequestReceipt.addr_country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
							?>
							<?php echo $form->error('RequestData.RequestReceipt.addr_country_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所1'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.addr_1', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_1'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.addr_1'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所2'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.addr_2', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_2'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.addr_2'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('住所3'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.addr_3', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_3'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.addr_3'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('会社名'); ?></th>
						<td>
							<?php echo $form->text('RequestData.RequestReceipt.company', array('size' => '50', 'value'=>$request_receipt['request_receipt']['company'])); ?>
							<?php echo $form->error('RequestData.RequestReceipt.company'); ?>
						</td>
					</tr>
				</table>

				<br />

				<?php $message1 = __('保存してよろしいですか。', true); ?>
				<?php echo $form->button(__('データ保存',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/save\', \'' . $message1 . '\');')); ?>
				<?php $message2 = __('削除してよろしいですか。', true); ?>
				<?php echo $form->button(__('データ削除',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/delete\', \'' . $message2 . '\');')); ?>

				</p>

				<br />
				<br />

				<h2><a id="mail"><?php echo __('メール配信') ?></a></h2>
				<p>
					<table>
						<tr>
							<th><?php echo __('メールテンプレート名') ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($mail_template_name as $mtn) {
										$opt[trim($mtn['mtl']['id'])] = $mtn['mtl']['name'];
									}
									if (empty($request['id'])) {
										echo ($form->input('RequestData.MailTemplate.id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => '', 'disabled'=>true)));
									} else {
										echo ($form->input('RequestData.MailTemplate.id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => '')));
									}
								?>
								<?php echo $form->error('RequestData.MailTemplate.id'); ?>
							</td>
						</tr>
					</table>
					<br />
					<table id="RequestDataMailTemplateContents"></table>
				<?php echo $form->end(); ?>
			</p>
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
