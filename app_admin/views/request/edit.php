<?php

$script = '';
$base_url = '/app_admin/request/';
$option_html = 'type: "POST", dataType: "html", timeout: 10000,';

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
				<a href="#mail"><?php echo __('メール配信') ?></a><br />
				<a href="#bord"><?php echo __('伝言板') ?></a><br />
				<a href="#visitor"><?php echo __('お客様情報') ?></a><br />
				<a href="#booking"><?php echo __('予約情報') ?></a><br />
				<a href="#receipt"><?php echo __('領収書') ?></a><br />
			</div>

			<?php echo $form->create('Request', array('type' => 'post', 'action' => '/save' ,'name' => 'form_request_edit', 'url'=>array('controller'=>'request'))); ?>

				<h2><a id="mail"></a><?php echo __('メール配信') ?></h2>
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
										echo ($form->input('MailTemplate.id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => '', 'disabled'=>true)));
									} else {
										echo ($form->input('MailTemplate.id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => '')));
									}
								?>
								<?php echo $form->error('MailTemplate.id'); ?>
							</td>
							<td>
								<?php echo $form->button(__('確認',true), array('div' => false, 'onclick' => 'new_window_submit(\'form_request_edit\', \''.BASE_URL.'/request/mail/\');')); ?>
							</td>
						</tr>
					</table>
					<br />
					<table id="MailTemplateContents"></table>
				</p>

				<h2><a id="bord"></a><?php __('申込データ保存'); ?></h2>
				<p>

					<?php $message1 = __('保存してよろしいですか。', true); ?>
					<?php echo $form->button(__('データ保存',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/save\', \'' . $message1 . '\');')); ?>
					<br />
					<br />

					<table>
						<tr>
							<th><?php echo __('伝言板') ?></th>
							<td>
								<?php echo $form->textarea('Request.message_bord', array('cols' => '80', 'rows' => '10', 'wrap' => 'off', 'label' => '', 'value'=>$request['message_bord'])); ?>
								<?php echo $form->error('Request.message_bord'); ?>
								<?php echo $form->input('Request.id', array('type'=>'hidden', 'value'=>$request['id'])); ?>
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
						</tr>
						<tr>
							<td>
								<?php
									$opt = array();
									foreach ($admin_user as $adm) {
										$opt[trim($adm['admin_user']['id'])] = $adm['admin_user']['name'];
									}
									$request['admin_user_id'] = empty($request['admin_user_id']) ? $loginUser['id'] : $request['admin_user_id'];
									echo ($form->input('Request.admin_user_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['admin_user_id'])));
								?>
								<?php echo $form->error('Request.admin_user_id'); ?>
							</td>
							<td>
								<?php
									$opt = array();
									foreach ($request_stat as $rs) {
										$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
									}
									$request['request_stat_id'] = empty($request['request_stat_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['request_stat_id'];
									echo ($form->input('Request.request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['request_stat_id'])));
								?>
								<?php echo $form->error('Request.request_stat_id'); ?>
							</td>
							<td>
								<?php
									$opt = array();
									foreach ($request_payment as $rp) {
										$opt[trim($rp['rpl']['request_payment_id'])] = $rp['rpl']['name'];
									}
									$request['request_payment_id'] = empty($request['request_payment_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['request_payment_id'];
									echo ($form->input('Request.request_payment_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['request_payment_id'])));
								?>
								<?php echo $form->error('Request.request_payment_id'); ?>
							</td>
							<td>
								<?php
									$opt = array();
									foreach ($currency as $cur) {
										$opt[trim($cur['currency']['currency_id'])] = $cur['currency']['iso_code_a'].CURRENCY_DELIMITER.$cur['currency']['country_name'].CURRENCY_DELIMITER.$cur['currency']['currency_name'];
									}
									$request['currency_id'] = empty($request['currency_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request['currency_id'];
									echo ($form->input('Request.currency_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['currency_id'])));
								?>
								<?php echo $form->error('Request.currency_id'); ?>
							</td>
						</tr>
					</table>

					<table>
						<tr>
							<th><?php echo __('申込日') ?></th>
							<th><?php echo __('予約確定日') ?></th>
						</tr>
						<tr>
							<td>
								<?php
									$default = $construct->toArray($request['request_date']);
									$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
									echo $form->dateTime('Request.request_date', 'YMD', 'NONE', $default, $attr, false);
								?>
								<?php echo $form->error('Request.request_date'); ?>
							</td>
							<td>
								<?php
									$default = $construct->toArray($request['fix_date']);
									$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
									echo $form->dateTime('Request.fix_date', 'YMD', 'NONE', $default, $attr, false);
								?>
								<?php echo $form->error('Request.fix_date'); ?>
							</td>
						</tr>
					</table>

					<br />
				</p>

				<h2><a id="visitor"></a><?php echo __('お客様情報(代表者)') ?></h2>
				<p>

					<table>
						<tr>
							<th><?php echo __('ID') ?></th>
							<td>
								<?php echo $request['customer_user_id']; ?>
								<?php echo $form->input('Request.customer_user_id', array('type'=>'hidden', 'value'=>$request['customer_user_id'])); ?>
								<?php echo $form->input('Request.country_id', array('type'=>'hidden', 'value'=>$request['country_id'])); ?>
								<?php echo $form->input('Request.language_id', array('type'=>'hidden', 'value'=>$request['language_id'])); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('代表者') ?></th>
							<td>
								<?php echo __('名：', true).$form->text('Request.first_name', array('size' => '25', 'value'=>$request['first_name'])); ?>
								<?php echo $form->error('first_name'); ?>
								<?php echo __('姓：', true).$form->text('Request.last_name', array('size' => '25', 'value'=>$request['last_name'])); ?>
								<?php echo $form->error('last_name'); ?>
								<?php echo __('歳：', true).$form->text('Request.age', array('size' => '3', 'value'=>$request['age'])); ?>
								<?php echo $form->error('age'); ?>
								<?php
									$opt = array();
									foreach ($gender as $gnd) {
										$opt[trim($gnd['gl']['gender_id'])] = $gnd['gl']['name'];
									}
									$request['gender_id'] = empty($request['gender_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request['gender_id'];
									echo ($form->input('Request.gender_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request['gender_id'])));
								?>
								<?php echo $form->error('gender_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('TEL'); ?></th>
							<td>
								<?php echo $form->text('Request.tel', array('size' => '50', 'value'=>$request['tel'])); ?>
								<?php echo $form->error('Request.tel'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯'); ?></th>
							<td>
								<?php echo $form->text('Request.tel_mobile', array('size' => '50', 'value'=>$request['tel_mobile'])); ?>
								<?php echo $form->error('Request.tel_mobile'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FAX'); ?></th>
							<td>
								<?php echo $form->text('Request.fax', array('size' => '50', 'value'=>$request['fax'])); ?>
								<?php echo $form->error('Request.fax'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メールアドレス'); ?></th>
							<td>
								<?php echo $form->text('Request.email', array('size' => '50', 'value'=>$request['email'])); ?>
								<?php echo $form->error('Request.email'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯メールアドレス'); ?></th>
							<td>
								<?php echo $form->text('Request.email_mobile', array('size' => '50', 'value'=>$request['email_mobile'])); ?>
								<?php echo $form->error('Request.email_mobile'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('郵便番号'); ?></th>
							<td>
								<?php echo $form->text('Request.postcode', array('size' => '50', 'value'=>$request['postcode'])); ?>
								<?php echo $form->error('Request.postcode'); ?>
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
									echo ($form->input('Request.addr_country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('Request.addr_country_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所1'); ?></th>
							<td>
								<?php echo $form->text('Request.addr_1', array('size' => '50', 'value'=>$request['addr_1'])); ?>
								<?php echo $form->error('Request.addr_1'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所2'); ?></th>
							<td>
								<?php echo $form->text('Request.addr_2', array('size' => '50', 'value'=>$request['addr_2'])); ?>
								<?php echo $form->error('Request.addr_2'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所3'); ?></th>
							<td>
								<?php echo $form->text('Request.addr_3', array('size' => '50', 'value'=>$request['addr_3'])); ?>
								<?php echo $form->error('Request.addr_3'); ?>
							</td>
						</tr>
					</table>
				</p>



				<h2><a id="booking"></a><?php echo __('予約情報') ?></h2>
				<p>
					<?php
						$pax_opt = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10',);
					?>
					<?php echo $form->button(__('予約情報更新',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_mail\', \'/app_admin/request/refresh\', \');')); ?>
					<?php for ($count = 0; $count < count($request_hotel); $count++) { ?>
						<?php
							$back_class = '';
							if (empty($request_hotel[$count]['id'])) {
								$back_color = ' color_silver';
								$back_class = 'class="color_silver" ';
							} else {
								$back_class = $request_hotel[$count]['request_stat_id'] == INDIVIDUAL_REQUEST_STAT_CANCEL ? 'class="color_silver" ' : '';
								$back_color =  empty($back_class) ? '' : ' color_silver';
							}
						 ?>
						<table>
							<tr>
								<th><?php echo __('予約情報') ?></th>
								<td <?php echo $back_class ?>>
									<?php
										$opt = array();
										foreach ($individual_request_stat as $irs) {
											$opt[trim($irs['rsl']['request_stat_id'])] = $irs['rsl']['name'];
										}
										$request_hotel[$count]['request_stat_id'] = empty($request_hotel[$count]['request_stat_id']) ? DEFAULT_SELECTED_VALUE_ONE : $request_hotel[$count]['request_stat_id'];
										echo ($form->input('RequestHotel.'.$count.'.request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['request_stat_id'])));
									?>
									<?php echo $form->error('RequestHotel.'.$count.'.request_stat_id'); ?>
									<?php echo $form->input('RequestHotel.'.$count.'.id', array('type'=>'hidden', 'value'=>$request_hotel[$count]['id'])); ?>
								</td>
							</tr>
							<tr>
								<th><?php echo __('ホールセラー') ?></th>
								<td <?php echo $back_class ?>>
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
										echo ($form->input('RequestHotel.'.$count.'.hotel_agent_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_agent_id'])));
									?>
									<?php echo $form->error('RequestHotel.'.$count.'.hotel_agent_id'); ?>
								</td>
							</tr>
							<tr>
								<th><?php echo __('予約ID') ?></th>
								<td <?php echo $back_class ?>>
									<?php echo __('BookingID' ,true).$form->text('RequestHotel.'.$count.'.hotel_agent_ref', array('size' => '30', 'value'=>$request_hotel[$count]['hotel_agent_ref'])); ?>
									<?php echo $form->error('RequestHotel.'.$count.'.hotel_agent_ref'); ?>
									<?php echo __('BookingItemID' ,true).$form->text('RequestHotel.'.$count.'.hotel_agent_item', array('size' => '30', 'value'=>$request_hotel[$count]['hotel_agent_item'])); ?>
									<?php echo $form->error('RequestHotel.'.$count.'.hotel_agent_item'); ?>
								</td>
							</tr>
							<tr>
								<th><?php echo __('ホテル詳細') ?></th>
								<td <?php echo $back_class ?>>
									<table class="no_border">
										<tr class="no_border">
											<td class="no_border<?php echo $back_color ?>">
												<?php
													$opt = array();
													foreach ($area as $ara) {
														$opt[trim($ara['al']['area_id'])] = $ara['al']['name'];
													}
													$request_hotel[$count]['area_id'] = empty($request_hotel[$count]['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['area_id'];
													echo __('エリア' , true);
												?>
											</td>
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo $form->input('RequestHotel.'.$count.'.area_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['area_id']));
													echo $form->error('RequestHotel.'.$count.'.area_id');
												?>
											</td>
											<td class="no_border<?php echo $back_color ?>">
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
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo ($form->input('RequestHotel.'.$count.'.country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['country_id'])));
													echo $form->error('RequestHotel.'.$count.'.country_id');
												 ?>
											</td>
										</tr>
										<tr class="no_border">
											<td class="no_border<?php echo $back_color ?>">
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
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo ($form->input('RequestHotel.'.$count.'.state_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['state_id'])));
													echo $form->error('RequestHotel.'.$count.'.state_id');
												 ?>
											</td>
											<td class="no_border<?php echo $back_color ?>">
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
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo ($form->input('RequestHotel.'.$count.'.city_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['city_id'])));
													echo $form->error('RequestHotel.'.$count.'.city_id');
												 ?>
											</td>
										</tr>
										<tr class="no_border">
											<td class="no_border<?php echo $back_color ?>">
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
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo ($form->input('RequestHotel.'.$count.'.hotel_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_id'])));
													echo $form->error('RequestHotel.'.$count.'.hotel_id');
												 ?>
											</td>
											<td class="no_border<?php echo $back_color ?>">
												<?php
													$opt = array();
													if (!empty($hotel_rooms[$count])) {
														foreach ($hotel_rooms[$count] as $hr) {
															if (!empty($hr['hrl']['name'])) {
																$opt[trim($hr['hrl']['hotel_room_id'])] = $hr['hrl']['name'].ROOM_DELIMITER.$hr['rbl']['name'];
															}
														}
													}
													$request_hotel[$count]['hotel_room_id'] = empty($request_hotel[$count]['hotel_room_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel[$count]['hotel_room_id'];
													echo __('部屋' , true);
												?>
											</td>
											<td class="no_border<?php echo $back_color ?>">
												<?php
													echo ($form->input('RequestHotel.'.$count.'.hotel_room_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel[$count]['hotel_room_id'])));
													echo $form->error('RequestHotel.'.$count.'.hotel_room_id');
												 ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<th><?php echo __('チェックイン') ?></th>
								<td <?php echo $back_class ?>>
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
								<td <?php echo $back_class ?>>
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
								<td <?php echo $back_class ?>>
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
								<td <?php echo $back_class ?>>
									<?php
										if (!empty($request_hotel[$count]['hotel_id']) && !empty($request_hotel[$count]['hotel_room_id'])) {
									 ?>
									<div id="RequestHotel<?php echo $count ?>RoomData">
										<?php $room_detail = $room_data[$count]; ?>
										<?php if (!empty($room_detail)) { ?>
											<table class="font-size10pt">
												<tr class="font-size10pt">
													<th class="font-size10pt"><?php __('食事'); ?></th>
													<td class="font-size10pt<?php echo $back_color ?>">
														<?php
															$opt = array();
															foreach ($meal_type as $mt) {
																$opt[trim($mt['mtl']['meal_type_id'])] = $mt['mtl']['name'];
															}
															$requestHotel[$count]['meal_type_id'] = empty($requestHotel[$count]['meal_type_id']) ? DEFAULT_SELECTED_VALUE_ONE : $requestHotel[$count]['meal_type_id'];
															echo ($form->input('RequestHotel.'.$count.'.meal_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_detail['room_data']['meal_type_id'])));
														?>
													</td>
													<th class="font-size10pt"><?php __('朝食'); ?></th>
													<td class="font-size10pt<?php echo $back_color ?>">
														<?php
															$opt = array();
															foreach ($breakfast_type as $bt) {
																$opt[trim($bt['btl']['breakfast_type_id'])] = $bt['btl']['name'];
															}
															$requestHotel[$count]['breakfast_type_id'] = empty($requestHotel[$count]['breakfast_type_id']) ? DEFAULT_SELECTED_VALUE_ONE : $requestHotel[$count]['breakfast_type_id'];
															echo ($form->input('RequestHotel.'.$count.'.breakfast_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_detail['room_data']['breakfast_type_id'])));
														?>
													</td>
												</tr>
												<tr class="font-size10pt">
													<th class="font-size10pt"><?php __('風呂'); ?></th>
													<td class="font-size10pt<?php echo $back_color ?>" colspan="3">
														<?php
															echo $room_detail['room_data']['bath_name'];
															echo $form->input('RequestHotel.'.$count.'.bath_name', array('type'=>'hidden', 'value'=>$room_detail['room_data']['bath_name']));
														?>
													</td>
												</tr>
												<tr class="font-size10pt">
													<th class="font-size10pt"><?php __('料金'); ?></th>
													<td class="font-size10pt<?php echo $back_color ?>">
														<?php
															echo $form->text('RequestHotel.'.$count.'.price', array('size' => '30', 'value'=>$room_detail['room_data']['price']));
															echo $form->input('RequestHotel.'.$count.'.point', array('type'=>'hidden', 'value'=>$room_detail['room_data']['point']));
														?>
													</td>
													<th class="font-size10pt"><?php __('通貨'); ?></th>
													<td class="font-size10pt<?php echo $back_color ?>">
														<?php
															$opt = array();
															foreach ($currency as $cur) {
																$opt[trim($cur['currency']['currency_id'])] = $cur['currency']['iso_code_a'].CURRENCY_DELIMITER.$cur['currency']['country_name'].CURRENCY_DELIMITER.$cur['currency']['currency_name'];
															}
															$requestHotel[$count]['currency_id'] = empty($requestHotel[$count]['currency_id']) ? DEFAULT_SELECTED_VALUE_ONE : $requestHotel[$count]['currency_id'];
															echo ($form->input('RequestHotel.'.$count.'.currency_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_detail['room_data']['currency_id'])));
														?>
													</td>
												</tr>
											</table>
										<?php } ?>
									</div>
									<?php
										} else {
									 ?>
									<div id="RequestHotel<?php echo $count ?>RoomData"></div>
									<?php
										}
									 ?>
								</td>
							</tr>
							<tr>
								<th><?php echo __('備考'); ?></th>
								<td <?php echo $back_class ?>>
									<?php echo $form->textarea('RequestHotel.'.$count.'.comment', array('cols' => '40', 'rows' => '3', 'wrap' => 'off', 'label' => '', 'value'=>$request_hotel[$count]['comment'])); ?>
									<?php echo $form->error('RequestHotel.'.$count.'.comment'); ?>
								</td>
							</tr>
						</table>
						<table>
							<?php for ($cnt = 0; $cnt < count($request_hotel_customer_user[$count]); $cnt++) { ?>
								<tr>
									<th><?php echo __('宿泊者').$cnt+1 ?></th>
									<td>
										<?php echo $form->hidden('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.id', array('value'=>$request_hotel_customer_user[$count][$cnt]['id'])); ?>
										<?php echo __('名：', true).$form->text('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.first_name', array('size' => '25', 'value'=>$request_hotel_customer_user[$count][$cnt]['first_name'])); ?>
										<?php echo __('姓：', true).$form->text('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.last_name', array('size' => '25', 'value'=>$request_hotel_customer_user[$count][$cnt]['last_name'])); ?>
										<?php echo __('歳：', true).$form->text('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.age', array('size' => '3', 'value'=>$request_hotel_customer_user[$count][$cnt]['age'])); ?>
										<?php
											$opt = array();
											foreach ($gender as $gnd) {
												$opt[trim($gnd['gl']['gender_id'])] = $gnd['gl']['name'];
											}
											$request_hotel_customer_user[$count][$cnt]['gender_id'] = empty($request_hotel_customer_user[$count][$cnt]['gender_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel_customer_user[$count][$cnt]['gender_id'];
											echo ($form->input('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.gender_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[$count][$cnt]['gender_id'])));
										?>
										<?php
											$opt = array();
											foreach ($adult as $adt) {
												$opt[trim($adt['mil']['code_id'])] = $adt['mil']['name'];
											}
											$request_hotel_customer_user[$count][$cnt]['adult'] = empty($request_hotel_customer_user[$count][$cnt]['adult']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_hotel_customer_user[$count][$cnt]['adult'];
											echo ($form->input('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.adult', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[$count][$cnt]['adult'])));
										?>
										<?php echo ($form->input('RequestHotelCustomerUser.'.$count.'.'.$cnt.'.leader', array('type' => 'select', 'options' => array(REQUEST_CUSTOMER_USER_OTHER => __('' ,true), REQUEST_CUSTOMER_USER_LEADER => __('代表' ,true),), 'label'=>'', 'div' => false, 'selected' => $request_hotel_customer_user[$count][$cnt]['leader']))); ?>
										<input type="button" value="削除" onclick="clear_tgt_customer_data('<?php echo $count ?>', '<?php echo $cnt ?>')">
										<?php
											if (isset($form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['first_name'])) {
												echo '<div class="error-message">'.$form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['first_name'].'</div>';
											}
											if (isset($form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['last_name'])) {
												echo '<div class="error-message">'.$form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['last_name'].'</div>';
											}
											if (isset($form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['age'])) {
												echo '<div class="error-message">'.$form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['age'].'</div>';
											}
											if (isset($form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['gender_id'])) {
												echo '<div class="error-message">'.$form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['gender_id'].'</div>';
											}
											if (isset($form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['adult'])) {
												echo '<div class="error-message">'.$form->validationErrors['RequestHotelCustomerUser'][$count][$cnt]['adult'].'</div>';
											}
										?>
									</td>
								</tr>
							<?php } ?>
						</table>
						<?php echo ($form->input('AddData.add_companion.'.$count, array('type' => 'select', 'options' => $pax_opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE))); ?>
						人
						<?php echo $form->button(__('宿泊者追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_request_edit\', \'/app_admin/request/add_companion/'.$count.'/\');')); ?>
						<br />
						<br />

<?php

//for ($count = 0; $count < 10; $count++) {
	$is_color = 0;

	if (empty($request_hotel[$count]['id'])) {
		$is_color = 1;
	} else {
		$back_class = $request_hotel[$count]['request_stat_id'] == INDIVIDUAL_REQUEST_STAT_CANCEL ? 'class="color_silver" ' : '';
		$back_color =  empty($back_class) ? '' : ' color_silver';
		$is_color = $request_hotel[$count]['request_stat_id'] == INDIVIDUAL_REQUEST_STAT_CANCEL ? 1 : 0;
	}

	$cls_area = '#RequestHotel'.$count.'AreaId';
	$cls_country = '#RequestHotel'.$count.'CountryId';
	$cls_state = '#RequestHotel'.$count.'StateId';
	$cls_city = '#RequestHotel'.$count.'CityId';
	$cls_hotel = '#RequestHotel'.$count.'HotelId';
	$cls_room = '#RequestHotel'.$count.'HotelRoomId';
	$cls_agent = '#RequestHotel'.$count.'HotelAgentId';
	$cls_room_data = '#RequestHotel'.$count.'RoomData';

	$area_id = '$("select#RequestHotel'.$count.'AreaId option:selected").val()';
	$country_id = '$("select#RequestHotel'.$count.'CountryId option:selected").val()';
	$state_id = '$("select#RequestHotel'.$count.'StateId option:selected").val()';
	$city_id = '$("select#RequestHotel'.$count.'CityId option:selected").val()';
	$hotel_id = '$("select#RequestHotel'.$count.'HotelId option:selected").val()';
	$agent_id = '$("select#RequestHotel'.$count.'HotelAgentId option:selected").val()';
	$room_id = '$("select#RequestHotel'.$count.'HotelRoomId option:selected").val()';

	$area_id_url = '+'.$area_id.'+"/';
	$country_id_url = '+'.$country_id.'+"/';
	$state_id_url = '+'.$state_id.'+"/';
	$city_id_url = '+'.$city_id.'+"/';
	$hotel_id_url = '+'.$hotel_id.'+"/';
	$agent_id_url = '+'.$agent_id.'+"/';
	$room_id_url = '+'.$room_id.'+"/';
	$count_url = '+'.$count.'+"/';
	$color_url = '+'.$is_color.'+"/';

	$area_url = $base_url.'change_area/"'.$area_id_url;
	$country_url = $base_url.'change_country/"'.$area_id_url.'"'.$country_id_url;
	$state_url = $base_url.'change_state/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url;
	$city_url = $base_url.'change_city/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url.'"'.$city_id_url;
	$hotel_url = $base_url.'change_hotel/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url.'"'.$city_id_url.'"'.$hotel_id_url.'"'.$agent_id_url;
	$room_url = $base_url.'change_room/"'.$room_id_url.'"'.$count_url.'"'.$color_url;

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
//}

?>


					<?php } ?>
					<?php echo ($form->input('AddData.add_request', array('type' => 'select', 'options' => $pax_opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE))); ?>
					件
					<?php echo $form->button(__('予約追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_request_edit\', \'/app_admin/request/add_request/\');')); ?>
					<br />
					<br />
<?php


	//                                      ↓ この空白ないとエラーになるし、JSPROGの直後は改行じゃないとだめ
	$this->addScript($javascript->codeBlock( <<<JSPROG
	$script
JSPROG
	));
//↑JSPROGの前に空白文字列とか入れるとエラーになる


?>
					<br />

					<table>
						<tr>
							<th colspan="2"><a id="receipt"></a><?php echo __('領収書') ?></th>
						</tr>
						<tr>
							<td colspan="2" class="align-center">
								<?php
									$opt = array();
									foreach ($receipt_status as $rs) {
										$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
									}
									$request_receipt['request_receipt']['request_receipt']['status'] = empty($request_receipt['request_receipt']['status']) ? DEFAULT_SELECTED_VALUE_ZERO : $request_receipt['request_receipt']['status'];
									echo ($form->input('RequestReceipt.status', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $request_receipt['request_receipt']['status'])));
								?>
								<?php echo $form->hidden('RequestReceipt.id', array('value'=>$request_receipt['request_receipt']['id'])) ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('領収書宛名'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.name', array('size' => '50', 'value'=>$request_receipt['request_receipt']['name'])); ?>
								<?php echo $form->error('RequestReceipt.name'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('ご郵送先宛名'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.postname', array('size' => '50', 'value'=>$request_receipt['request_receipt']['postname'])); ?>
								<?php echo $form->error('RequestReceipt.postname'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('郵便番号'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.postcode', array('size' => '50', 'value'=>$request_receipt['request_receipt']['postcode'])); ?>
								<?php echo $form->error('RequestReceipt.postcode'); ?>
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
									echo ($form->input('RequestReceipt.addr_country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('RequestReceipt.addr_country_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所1'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.addr_1', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_1'])); ?>
								<?php echo $form->error('RequestReceipt.addr_1'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所2'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.addr_2', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_2'])); ?>
								<?php echo $form->error('RequestReceipt.addr_2'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所3'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.addr_3', array('size' => '50', 'value'=>$request_receipt['request_receipt']['addr_3'])); ?>
								<?php echo $form->error('RequestReceipt.addr_3'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('会社名'); ?></th>
							<td>
								<?php echo $form->text('RequestReceipt.company', array('size' => '50', 'value'=>$request_receipt['request_receipt']['company'])); ?>
								<?php echo $form->error('RequestReceipt.company'); ?>
							</td>
						</tr>
					</table>

					<br />

					<?php $message1 = __('保存してよろしいですか。', true); ?>
					<?php echo $form->button(__('データ保存',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_request_edit\', \'/app_admin/request/save\', \'' . $message1 . '\');')); ?>

				</p>

			<?php echo $form->end(); ?>
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
