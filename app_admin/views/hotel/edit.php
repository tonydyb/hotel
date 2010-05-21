<?php
$script = '';
$hec_script = '';
$base_url = '/app_admin/hotel/';
$option_html = 'type: "POST", dataType: "html", timeout: 10000,';

$cls_area = '#HotelAreaId';
$cls_country = '#HotelCountryId';
$cls_state = '#HotelStateId';
$cls_city = '#HotelCityId';

$area_id = '$("select#HotelAreaId option:selected").val()';
$country_id = '$("select#HotelCountryId option:selected").val()';
$state_id = '$("select#HotelStateId option:selected").val()';
$city_id = '$("select#HotelCityId option:selected").val()';

$area_id_url = '+'.$area_id.'+"/';
$country_id_url = '+'.$country_id.'+"/';
$state_id_url = '+'.$state_id.'+"/';
$city_id_url = '+'.$city_id.'+"/';

$area_url = $base_url.'change_area/"'.$area_id_url;
$country_url = $base_url.'change_country/"'.$area_id_url.'"'.$country_id_url;
$state_url = $base_url.'change_state/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url;
$city_url = $base_url.'change_city/"'.$area_id_url.'"'.$country_id_url.'"'.$state_id_url.'"'.$city_id_url;

$area_func = 'function(data) { $("'.$cls_country.'").html(data); }';
$country_func = 'function(data) { $("'.$cls_state.'").html(data); }';
$state_func = 'function(data) { $("'.$cls_city.'").html(data); }';

$opt_state = '{ url: "'.$state_url.'", '.$option_html.' success: '.$state_func.' }';
$opt_country = '{ url: "'.$country_url.'", '.$option_html.' success: '.$country_func.', complete : function() { $.ajax('.$opt_state.') }}';
$opt_area = '{ url: "'.$area_url.'", '.$option_html.' success: '.$area_func.', complete : function() {$.ajax('.$opt_country.') }}';


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
});';
?>

<div id="top">
	<div id="header">
		<h1><?php __('ホテル管理'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

			<?php echo $form->create('Hotel', array('type' => 'post', 'action' => '/save' ,'name' => 'form_hotel_edit', 'url'=>array('controller'=>'hotel'))); ?>

				<h2><a id="mail"><?php echo __('ホテル編集') ?></a></h2>
				<p>
					<table>
						<tr>
							<th><?php echo __('登録使用言語'); ?></th>
							<td>
								<?php
									$opt = array();
									$default_id = null;
									foreach ($language as $lang) {
										$opt[trim($lang['ViewLanguage']['ll_id'])] = $lang['ViewLanguage']['name'];
										if (is_null($default_id) && $lang['ViewLanguage']['iso_code'] == $default_iso_code) { $default_id = $lang['ViewLanguage']['ll_id']; }
									}
									$HotelLanguage['language_id'] = empty($HotelLanguage['language_id']) ? $default_iso_code : $HotelLanguage['language_id'];
									echo ($form->input('HotelLanguage.language_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $HotelLanguage['language_id'])));
									echo $form->error('HotelLanguage.language_id');
									echo __('※登録データをどの言語のときに表示するか。');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('No'); ?></th>
							<td>
								<?php
									echo $Hotel['id'];
									echo $form->input('Hotel.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $Hotel['id']));
									echo $form->input('HotelLanguage.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $HotelLanguage['id']));
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('エリア'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($area as $ar) {
										$opt[trim($ar['al']['area_id'])] = $ar['al']['name'];
									}
									$Hotel['area_id'] = empty($Hotel['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['area_id'];
									echo ($form->input('Hotel.area_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['area_id'])));
									echo $form->error('Hotel.area_id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('国'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($country as $cr) {
										$opt[trim($cr['cl']['country_id'])] = $cr['cl']['name_long'];
									}
									$Hotel['country_id'] = empty($Hotel['country_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['country_id'];
									echo ($form->input('Hotel.country_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['country_id'])));
									echo $form->error('Hotel.country_id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('州'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($state as $st) {
										$opt[trim($st['sl']['state_id'])] = $st['sl']['name'];
									}
									$Hotel['state_id'] = empty($Hotel['state_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['state_id'];
									echo ($form->input('Hotel.state_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['state_id'])));
									echo $form->error('Hotel.state_id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('都市'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($city as $cy) {
										$opt[trim($cy['cl']['city_id'])] = $cy['cl']['name'];
									}
									$Hotel['city_id'] = empty($Hotel['city_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['city_id'];
									echo ($form->input('Hotel.city_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['city_id'])));
									echo $form->error('Hotel.city_id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('コード'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.code', array('size' => '50', 'value'=>$Hotel['code']));
									echo $form->error('Hotel.code');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('ホテル名'); ?></th>
							<td>
								<?php
									echo $form->text('HotelLanguage.name', array('size' => '50', 'value'=>$HotelLanguage['name']));
									echo $form->error('HotelLanguage.name');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('説明'); ?></th>
							<td>
								<?php
									echo $form->textarea('HotelLanguage.comment', array('cols' => '50', 'rows' => '5', 'wrap' => 'off', 'label' => false, 'value'=>$HotelLanguage['comment']));
									echo $form->error('HotelLanguage.comment');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('ロケーション説明'); ?></th>
							<td>
								<?php
									echo $form->textarea('HotelLanguage.location_comment', array('cols' => '50', 'rows' => '5', 'wrap' => 'off', 'label' => false, 'value'=>$HotelLanguage['location_comment']));
									echo $form->error('HotelLanguage.location_comment');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('スターレート'); ?></th>
							<td>
								<?php
									$opt = array();
									for ($i = 0; $i <= 5; $i++) {
										$star = '';
										for ($j = 0; $j < $i; $j++) {
											$star .= __('★', true);
										}
										$opt[$i] = $star;
									}
									$Hotel['star_rate'] = empty($Hotel['star_rate']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['star_rate'];
									echo ($form->input('Hotel.star_rate', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['star_rate'])));
									echo $form->error('Hotel.star_rate');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('部屋数'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.total_room_number', array('size' => '50', 'value'=>$Hotel['total_room_number']));
									echo $form->error('Hotel.total_room_number');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('郵便番号'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.postcode', array('size' => '50', 'value'=>$Hotel['postcode']));
									echo $form->error('Hotel.postcode');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所1'); ?></th>
							<td>
								<?php
									echo $form->text('HotelLanguage.addr_1', array('size' => '50', 'value'=>$HotelLanguage['addr_1']));
									echo $form->error('HotelLanguage.addr_1');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所2'); ?></th>
							<td>
								<?php
									echo $form->text('HotelLanguage.addr_2', array('size' => '50', 'value'=>$HotelLanguage['addr_2']));
									echo $form->error('HotelLanguage.addr_2');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所3'); ?></th>
							<td>
								<?php
									echo $form->text('HotelLanguage.addr_3', array('size' => '50', 'value'=>$HotelLanguage['addr_3']));
									echo $form->error('HotelLanguage.addr_3');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('TEL'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.tel', array('size' => '50', 'value'=>$Hotel['tel']));
									echo $form->error('Hotel.tel');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FAX'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.fax', array('size' => '50', 'value'=>$Hotel['fax']));
									echo $form->error('Hotel.fax');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('EMail'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.email', array('size' => '50', 'value'=>$Hotel['email']));
									echo $form->error('Hotel.email');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('緯度'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.latitude', array('size' => '50', 'value'=>$Hotel['latitude']));
									echo $form->error('Hotel.latitude');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('経度'); ?></th>
							<td>
								<?php
									echo $form->text('Hotel.longitude', array('size' => '50', 'value'=>$Hotel['longitude']));
									echo $form->error('Hotel.longitude');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('チェックイン'); ?></th>
							<td>
								<?php
									echo $form->hour('Hotel.checkin', true, $Hotel['checkin']['hour'], array(), true);
									echo $form->minute('Hotel.checkin', $Hotel['checkin']['min'], array(), true);
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('チェックアウト'); ?></th>
							<td>
								<?php
									echo $form->hour('Hotel.checkout', true, $Hotel['checkout']['hour'], array(), true);
									echo $form->minute('Hotel.checkout', $Hotel['checkout']['min'], array(), true);
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('状態'); ?></th>
							<td>
								<?php
									$opt = array(DISPLAY_STAT_EXIST=>__('表示', true), DISPLAY_STAT_NOTEXIST=>__('非表示', true));
									echo ($form->input('Hotel.display_stat', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Hotel['display_stat'])));
									echo $form->error('Hotel.display_stat');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('ホテル使用言語'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($language as $lang) {
										$opt[trim($lang['ViewLanguage']['ll_id'])] = $lang['ViewLanguage']['name'];
									}
									$Hotel['language_id'] = empty($Hotel['language_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Hotel['language_id'];
									echo ($form->input('Hotel.language_id', array('type' => 'select', 'options' => $opt, 'empty'=>'', 'label'=>false, 'div' => false, 'selected' => $Hotel['language_id'])));
									echo $form->error('Hotel.language_id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('設備情報'); ?></th>
							<td>
								<?php
									$col_max = 4;	// 内部テーブル横方向MAX
									$row_max = count($HotelLinkFacility) / $col_max;	// 内部テーブル 縦方向最大値を算出 商
									$idx = 0; //現在の配列番号
									if (!empty($HotelLinkFacility)) {
										echo '<table>';
										for ($i = 0; $i < $row_max; $i++) {
											echo '<tr class="font-size10pt">';
											for ($j = 0; $j < $col_max; $j++) {
												if (isset($HotelLinkFacility[$idx])) {
													echo '<th class="font-size10pt">'.$HotelLinkFacility[$idx]['hotel_link_facility']['facility_name'].'</th>';
												} else {
													echo '<th></th>';
												}
												echo '<td class="font-size10pt">';
												if (isset($HotelLinkFacility[$idx])) {
													$opt = array(DISPLAY_STAT_NOTEXIST=>__('無', true), $HotelLinkFacility[$idx]['hotel_link_facility']['facility_id']=>__('有', true), );
													$select = empty($HotelLinkFacility[$idx]['hotel_link_facility']['hotel_facility_id']) ? DISPLAY_STAT_NOTEXIST : $HotelLinkFacility[$idx]['hotel_link_facility']['facility_id'];
													echo ($form->input('HotelLinkFacility.'.$idx.'.hotel_facility_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $select)));
													echo $form->input('HotelLinkFacility.'.$idx.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $HotelLinkFacility[$idx]['hotel_link_facility']['id']));
												}
												echo '</td>';
												$idx++;
											}
											echo '</tr>';
										}
										echo '</table>';
									}
								?>
							</td>
						</tr>
					</table>
					</p>
				<p>
					<?php
						$add_opt = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9', '10'=>'10',);
						$bath_opt = array(DISPLAY_STAT_NOTEXIST=>__('無', true), DISPLAY_STAT_EXIST=>__('有', true), );
						$grade_opt = array();
						$room_type_opt = array();
						$smoke_opt = array();
						$meal_opt = array();
						$breakfast_opt = array();
						$currency_opt = array();

						foreach ($hotel_grade as $tmp) {
							$grade_opt[trim($tmp['hgl']['hotel_grade_id'])] = $tmp['hgl']['name'];
						}
						foreach ($room_bed as $tmp) {
							$room_type_opt[trim($tmp['rbl']['room_bed_id'])] = $tmp['rbl']['name'];
						}
						foreach ($smoking as $tmp) {
							$smoke_opt[trim($tmp['sl']['smoking_id'])] = $tmp['sl']['name'];
						}
						foreach ($meal_type as $tmp) {
							$meal_opt[trim($tmp['mtl']['meal_type_id'])] = $tmp['mtl']['name'];
						}
						foreach ($breakfast_type as $tmp) {
							$breakfast_opt[trim($tmp['btl']['breakfast_type_id'])] = $tmp['btl']['name'];
						}
						foreach ($currency as $tmp) {
							$currency_opt[trim($tmp['currency']['currency_id'])] = $tmp['currency']['iso_code_a'].CURRENCY_DELIMITER.$tmp['currency']['country_name'].CURRENCY_DELIMITER.$tmp['currency']['currency_name'];
						}
					?>
				</p>
				<p>
					<table>
						<tr>
							<th><?php echo __('部屋情報'); ?></th>
							<td>
								<table>
									<tr>
										<th class="font-size10pt"><?php echo __('部屋名'); ?></th>
										<th class="font-size10pt"><?php echo __('グレード'); ?></th>
										<th class="font-size10pt"><?php echo __('部屋タイプ'); ?></th>
										<th class="font-size10pt"><?php echo __('風呂'); ?></th>
										<th class="font-size10pt"><?php echo __('喫煙'); ?></th>
										<th class="font-size10pt"><?php echo __('食事'); ?></th>
										<th class="font-size10pt"><?php echo __('朝食'); ?></th>
										<th class="font-size10pt"><?php echo __('価格'); ?></th>
										<th class="font-size10pt"><?php echo __('手数料'); ?></th>
										<th class="font-size10pt"><?php echo __('備考'); ?></th>
										<th class="font-size10pt"><?php echo __('削除'); ?></th>
									</tr>
									<?php for($room_count = 0; $room_count < count($HotelRoom); $room_count++) {?>
										<tr>
											<td>
												<?php
													echo $form->text('HotelRoomLanguage.'.$room_count.'.name', array('size' => '15', 'value'=>$HotelRoomLanguage[$room_count]['name']));
													echo $form->error('HotelRoomLanguage.'.$room_count.'.name');
													echo ($form->input('HotelRoom.'.$room_count.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['id'])));
													echo ($form->input('HotelRoomLanguage.'.$room_count.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $HotelRoomLanguage[$room_count]['id'])));
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['room_grade_id'] = empty($HotelRoom[$room_count]['room_grade_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['room_grade_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.room_grade_id', array('type' => 'select', 'options' => $grade_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['room_grade_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.room_grade_id');
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['room_bed_id'] = empty($HotelRoom[$room_count]['room_bed_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['room_bed_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.room_bed_id', array('type' => 'select', 'options' => $room_type_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['room_bed_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.room_bed_id');
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['room_bath_id'] = empty($HotelRoom[$room_count]['room_bath_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['room_bath_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.room_bath_id', array('type' => 'select', 'options' => $bath_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['room_bath_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.room_bath_id');
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['smoking_id'] = empty($HotelRoom[$room_count]['smoking_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['smoking_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.smoking_id', array('type' => 'select', 'options' => $smoke_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['smoking_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.smoking_id');
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['meal_type_id'] = empty($HotelRoom[$room_count]['meal_type_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['meal_type_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.meal_type_id', array('type' => 'select', 'options' => $meal_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['meal_type_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.meal_type_id');
												?>
											</td>
											<td>
												<?php
													$HotelRoom[$room_count]['breakfast_type_id'] = empty($HotelRoom[$room_count]['breakfast_type_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['breakfast_type_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.breakfast_type_id', array('type' => 'select', 'options' => $breakfast_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['breakfast_type_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.breakfast_type_id');
												?>
											</td>
											<td>
												<?php
													echo $form->text('HotelRoom.'.$room_count.'.price', array('size' => '15', 'value'=>$HotelRoom[$room_count]['price']));
													$HotelRoom[$room_count]['currency_id'] = empty($HotelRoom[$room_count]['currency_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelRoom[$room_count]['currency_id'];
													echo ($form->input('HotelRoom.'.$room_count.'.currency_id', array('type' => 'select', 'options' => $currency_opt, 'label'=>false, 'div' => false, 'selected' => $HotelRoom[$room_count]['currency_id'])));
													echo $form->error('HotelRoom.'.$room_count.'.price');
													echo $form->error('HotelRoom.'.$room_count.'.currency_id');
												?>
											</td>
											<td>
												<?php
													echo $form->text('HotelRoom.'.$room_count.'.commission', array('size' => '15', 'value'=>$HotelRoom[$room_count]['commission']));
													echo $form->error('HotelRoom.'.$room_count.'.commission');
												?>
											</td>
											<td rowspan="2">
												<?php
													echo $form->textarea('HotelRoomLanguage.'.$room_count.'.comment', array('cols' => '40', 'rows' => '3', 'wrap' => 'off', 'label' => false, 'value'=>$HotelRoomLanguage[$room_count]['comment']));
													echo $form->error('HotelRoomLanguage.'.$room_count.'.comment');
												?>
											</td>
											<td rowspan="2">
												<?php
													$option = array('value' => '1', 'checked' => $HotelRoom[$room_count]['delete']);
													echo $form->checkbox('HotelRoom.'.$room_count.'.delete', null, $option);
												?>
											</td>
											<tr>
												<th class="font-size10pt"><?php echo __('部屋設備'); ?></th>
												<td colspan="8" class="font-size10pt">
													<?php
														$col_max = 8;	// 内部テーブル横方向MAX
														$row_max = count($HotelRoomLinkRoomFacility[$room_count]) / $col_max;	// 内部テーブル 縦方向最大値を算出 商
														$idx = 0; //現在の配列番号
														if (!empty($HotelRoomLinkRoomFacility[$room_count])) {
															echo '<table>';
															for ($i = 0; $i < $row_max; $i++) {
																echo '<tr class="font-size10pt">';
																for ($j = 0; $j < $col_max; $j++) {
																	if (isset($HotelRoomLinkRoomFacility[$room_count][$idx])) {
																		echo '<th class="font-size10pt">'.$HotelRoomLinkRoomFacility[$room_count][$idx]['room_link_facility']['facility_name'].'</th>';
																	} else {
																		echo '<th></th>';
																	}
																	echo '<td class="font-size10pt">';
																	if (isset($HotelRoomLinkRoomFacility[$room_count][$idx])) {
																		$opt = array(DISPLAY_STAT_NOTEXIST=>__('無', true), $HotelRoomLinkRoomFacility[$room_count][$idx]['room_link_facility']['facility_id']=>__('有', true), );
																		$select = empty($HotelRoomLinkRoomFacility[$room_count][$idx]['room_link_facility']['room_facility_id']) ? DISPLAY_STAT_NOTEXIST : $HotelRoomLinkRoomFacility[$room_count][$idx]['room_link_facility']['facility_id'];
																		echo ($form->input('HotelRoomLinkRoomFacility.'.$room_count.'.'.$idx.'.room_facility_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $select)));
																		echo $form->input('HotelRoomLinkRoomFacility.'.$room_count.'.'.$idx.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $HotelRoomLinkRoomFacility[$room_count][$idx]['room_link_facility']['id']));
																	}
																	echo '</td>';
																	$idx++;
																}
																echo '</tr>';
															}
															echo '</table>';
														}
													?>
												</td>
											</tr>
										</tr>
									<?php } ?>
								</table>
								<?php echo ($form->input('AddData.add_room', array('type' => 'select', 'options' => $add_opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE))); ?>
								部屋
								<?php echo $form->button(__('追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_edit\', \'/app_admin/hotel/add_room/\');')); ?>
							</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<th><?php echo __('画像'); ?></th>
							<td>
								<div class="color_orangered"><?php echo __('※画像ファイルのアップ時に当画面に戻ってきた場合、画像ファイルは選択しなおしになります。'); ?></div>
								<table>
									<tr>
										<th class="font-size10pt"><?php echo __('画像説明'); ?></th>
										<th class="font-size10pt"><?php echo __('コード'); ?></th>
										<th colspan="3" class="font-size10pt"><?php echo __('画像'); ?></th>
										<th class="font-size10pt"><?php echo __('削除'); ?></th>
									</tr>
									<?php for($pic_count = 0; $pic_count < count($HotelImage); $pic_count++) {?>
										<?php $img_path = ''; ?>
										<tr>
											<td>
												<?php
													echo $form->text('HotelImageLanguage.'.$pic_count.'.name', array('size' => '20', 'value'=>$HotelImageLanguage[$pic_count]['name']));
													echo $form->error('HotelImageLanguage.'.$pic_count.'.name');
													echo ($form->input('HotelImage.'.$pic_count.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $HotelImage[$pic_count]['id'])));
													echo ($form->input('HotelImageLanguage.'.$pic_count.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $HotelImageLanguage[$pic_count]['id'])));
												?>
											</td>
											<td>
												<?php
													echo $form->text('HotelImage.'.$pic_count.'.code', array('size' => '10', 'value'=>$HotelImage[$pic_count]['code']));
													echo $form->error('HotelImage.'.$pic_count.'.code');
												?>
											</td>
											<td>
												<?php
													$img_path = $HotelImage[$pic_count]['image_url'].$HotelImage[$pic_count]['image_file'];
													if (!empty($HotelImage[$pic_count]['image_url'])) {
														echo '<img border="0" src="'.$img_path.'" width="50" height="50" alt="'.$HotelImageLanguage[$pic_count]['name'].'">';
													}
												?>
											</td>
											<td>
												<?php
													echo $img_path;
												?>
											</td>
											<td>
												<?php
													echo $form->file('HotelImage.'.$pic_count.'.pic', array('value' => 'HotelImage['.$pic_count.'][\'pic\']'));
												?>
											</td>
											<td>
												<?php
													$option = array('value' => '1', 'checked' => $HotelImage[$pic_count]['delete']);
													echo $form->checkbox('HotelImage.'.$pic_count.'.delete', null, $option);
												?>
											</td>
										</tr>
									<?php } ?>
								</table>
								<?php echo ($form->input('AddData.add_pic', array('type' => 'select', 'options' => $add_opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE))); ?>
								画像
								<?php echo $form->button(__('追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_edit\', \'/app_admin/hotel/add_pic/\');')); ?>
							</td>
						</tr>
					</table>
				</p>
				<p>
					<table>
						<tr>
							<th><?php echo __('キャンセル<br />ポリシー'); ?></th>
							<td>
								<div class="color_orangered"><?php echo __('※キャンセル期間：左側「0」で予約当日から。右側「0」でチェックイン当日まで。'); ?></div>
								<table>
									<tr>
										<th class="font-size10pt"><?php echo __('ソート');?></th>
										<th class="font-size10pt"><?php echo __('発生期間');?></th>
										<th class="font-size10pt"><?php echo __('キャンセル期間');?></th>
										<th class="font-size10pt"><?php echo __('料金');?></th>
										<th class="font-size10pt"><?php echo __('備考');?></th>
										<th class="font-size10pt"><?php echo __('削除');?></th>
									</tr>
									<?php
										$cancel_opt = array();
										foreach ($cancel_charge_const as $ccc) {
											$cancel_opt[trim($ccc['mil']['code_id'])] = $ccc['mil']['name'];
										}
									 ?>
									<?php for($cancel_count = 0; $cancel_count < count($CancelCharge); $cancel_count++) {?>
										<tr>
											<td>
												<?php
													echo $form->text('CancelCharge.'.$cancel_count.'.sort_no', array('size' => '2', 'value'=>$CancelCharge[$cancel_count]['sort_no']));
													echo $form->error('CancelCharge.'.$cancel_count.'.sort_no');
													echo $form->input('CancelCharge.'.$cancel_count.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'selected' => $CancelCharge[$cancel_count]['id']));
												?>
											</td>
											<td>
												<?php
													$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
													echo $form->dateTime('CancelCharge.'.$cancel_count.'.term_from', 'YMD', 'NONE', $CancelCharge[$cancel_count]['term_from'], $attr, true);
													echo __('～');
													echo $form->dateTime('CancelCharge.'.$cancel_count.'.term_to', 'YMD', 'NONE', $CancelCharge[$cancel_count]['term_to'], $attr, true);
													echo $form->error('CancelCharge.'.$cancel_count.'.term_from');
													echo $form->error('CancelCharge.'.$cancel_count.'.term_to');
												 ?>
											</td>
											<td class="font-size10pt">
												<?php
													echo __('チェックイン');
													echo $form->text('CancelCharge.'.$cancel_count.'.charge_occur_from', array('size' => '2', 'value'=>$CancelCharge[$cancel_count]['charge_occur_from']));
													echo __('日前から');
													echo $form->text('CancelCharge.'.$cancel_count.'.charge_occur_to', array('size' => '2', 'value'=>$CancelCharge[$cancel_count]['charge_occur_to']));
													echo __('日前まで');
													echo $form->error('CancelCharge.'.$cancel_count.'.charge_occur_from');
													echo $form->error('CancelCharge.'.$cancel_count.'.charge_occur_to');
												?>
											</td>
											<td class="font-size10pt">
												<?php
													$CancelCharge[$cancel_count]['charge_stat_id'] = empty($CancelCharge[$cancel_count]['charge_stat_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CancelCharge[$cancel_count]['charge_stat_id'];
													echo ($form->input('CancelCharge.'.$cancel_count.'.charge_stat_id', array('type' => 'select', 'options' => $cancel_opt, 'empty'=>'', 'label'=>false, 'div' => false, 'selected' => $CancelCharge[$cancel_count]['charge_stat_id'])));
													echo $form->text('CancelCharge.'.$cancel_count.'.charge_percent', array('size' => '2', 'value'=>$CancelCharge[$cancel_count]['charge_percent']));
													echo __('％');
													echo $form->error('CancelCharge.'.$cancel_count.'.charge_stat_id');
													echo $form->error('CancelCharge.'.$cancel_count.'.charge_percent');
												?>
											</td>
											<td>
												<?php
													echo $form->text('CancelCharge.'.$cancel_count.'.remarks', array('size' => '40', 'value'=>$CancelCharge[$cancel_count]['remarks']));
													echo $form->error('CancelCharge.'.$cancel_count.'.remarks');
												?>
											</td>
											<td>
												<?php
													$option = array('value' => '1', 'checked' => $CancelCharge[$cancel_count]['delete']);
													echo $form->checkbox('CancelCharge.'.$cancel_count.'.delete', null, $option);
												?>
											</td>
										</tr>
									<?php } ?>
								</table>
								<?php echo ($form->input('AddData.add_cancel', array('type' => 'select', 'options' => $add_opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE))); ?>
								ポリシー
								<?php echo $form->button(__('追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_edit\', \'/app_admin/hotel/add_cancel/\');')); ?>
							</td>
						</tr>
					<table>
				</p>
				<p>
					<table>
						<tr>
							<th><?php echo __('緊急連絡先'); ?></th>
							<td>
								<div class="color_orangered"><?php echo __('※英語で入力してください'); ?></div>
								<table>
									<?php
										$area_opt = array();
										foreach ($area as $ar) {
											$area_opt[trim($ar['al']['area_id'])] = $ar['al']['name'];
										}
										$delete = '';
										$name = '';
										$sort = '';
										$area = '';
										$country = '';
										$state = '';
										$city = '';
										$adr1 = '';
										$adr2 = '';
										$adr3 = '';
										$post = '';
										$prefix = '';
										$tel = '';
										$remark = '';
										for ($hec_count = 0; $hec_count < count($HotelEmergencyContact); $hec_count++) {
											$option = array('value' => '1', 'checked' => $HotelEmergencyContact[$hec_count]['delete']);
											$delete .= '<td>';
											$delete .= $form->checkbox('HotelEmergencyContact.'.$hec_count.'.delete', null, $option);
											$delete .= $form->error('HotelEmergencyContact.'.$hec_count.'.delete');
											$delete .= '</td>';

											$name .= '<td>';
											$name .= $form->text('HotelEmergencyContact.'.$hec_count.'.name', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['name']));
											$name .= $form->error('HotelEmergencyContact.'.$hec_count.'.name');
											$name .= '</td>';

											$sort .= '<td>';
											$sort .= $form->text('HotelEmergencyContact.'.$hec_count.'.sort_no', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['sort_no']));
											$sort .= $form->error('HotelEmergencyContact.'.$hec_count.'.sort_no');
											$sort .= '</td>';

											$area .= '<td>';
											$HotelEmergencyContact[$hec_count]['area_id'] = empty($HotelEmergencyContact[$hec_count]['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelEmergencyContact[$hec_count]['area_id'];
											$area .= $form->input('HotelEmergencyContact.'.$hec_count.'.area_id', array('type' => 'select', 'options' => $area_opt, 'label'=>false, 'div' => false, 'selected' => $HotelEmergencyContact[$hec_count]['area_id']));
											$area .= $form->error('HotelEmergencyContact.'.$hec_count.'.area_id');
											$area .= '</td>';

											$opt = array();
											foreach ($hec_country[$hec_count] as $cr) {
												$opt[trim($cr['cl']['country_id'])] = $cr['cl']['name_long'];
											}
											$country .= '<td>';
											$HotelEmergencyContact[$hec_count]['country_id'] = empty($HotelEmergencyContact[$hec_count]['country_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelEmergencyContact[$hec_count]['country_id'];
											$country .= $form->input('HotelEmergencyContact.'.$hec_count.'.country_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $HotelEmergencyContact[$hec_count]['country_id']));
											$country .= $form->error('HotelEmergencyContact.'.$hec_count.'.country_id');
											$country .= '</td>';

											$opt = array();
											foreach ($hec_state[$hec_count] as $st) {
												$opt[trim($st['sl']['state_id'])] = $st['sl']['name'];
											}
											$state .= '<td>';
											$HotelEmergencyContact[$hec_count]['state_id'] = empty($HotelEmergencyContact[$hec_count]['state_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelEmergencyContact[$hec_count]['state_id'];
											$state .= $form->input('HotelEmergencyContact.'.$hec_count.'.state_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $HotelEmergencyContact[$hec_count]['state_id']));
											$state .= $form->error('HotelEmergencyContact.'.$hec_count.'.state_id');
											$state .= '</td>';

											$opt = array();
											foreach ($hec_city[$hec_count] as $cy) {
												$opt[trim($cy['cl']['city_id'])] = $cy['cl']['name'];
											}
											$city .= '<td>';
											$HotelEmergencyContact[$hec_count]['city_id'] = empty($HotelEmergencyContact[$hec_count]['city_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $HotelEmergencyContact[$hec_count]['city_id'];
											$city .= $form->input('HotelEmergencyContact.'.$hec_count.'.city_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $HotelEmergencyContact[$hec_count]['city_id']));
											$city .= $form->error('HotelEmergencyContact.'.$hec_count.'.city_id');
											$city .= '</td>';

											$adr1 .= '<td>';
											$adr1 .= $form->text('HotelEmergencyContact.'.$hec_count.'.addr_1', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['addr_1']));
											$adr1 .= $form->error('HotelEmergencyContact.'.$hec_count.'.addr_1');
											$adr1 .= '</td>';

											$adr2 .= '<td>';
											$adr2 .= $form->text('HotelEmergencyContact.'.$hec_count.'.addr_2', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['addr_2']));
											$adr2 .= $form->error('HotelEmergencyContact.'.$hec_count.'.addr_2');
											$adr2 .= '</td>';

											$adr3 .= '<td>';
											$adr3 .= $form->text('HotelEmergencyContact.'.$hec_count.'.addr_3', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['addr_3']));
											$adr3 .= $form->error('HotelEmergencyContact.'.$hec_count.'.addr_3');
											$adr3 .= '</td>';

											$post .= '<td>';
											$post .= $form->text('HotelEmergencyContact.'.$hec_count.'.postcode', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['postcode']));
											$post .= $form->error('HotelEmergencyContact.'.$hec_count.'.postcode');
											$post .= '</td>';

											$prefix .= '<td>';
											$prefix .= $form->text('HotelEmergencyContact.'.$hec_count.'.tel_country_code', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['tel_country_code']));
											$prefix .= $form->error('HotelEmergencyContact.'.$hec_count.'.tel_country_code');
											$prefix .= '</td>';

											$tel .= '<td>';
											$tel .= $form->text('HotelEmergencyContact.'.$hec_count.'.tel', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['tel']));
											$tel .= $form->error('HotelEmergencyContact.'.$hec_count.'.tel');
											$tel .= '</td>';

											$remark .= '<td>';
											$remark .= $form->text('HotelEmergencyContact.'.$hec_count.'.remarks', array('size' => '40', 'value'=>$HotelEmergencyContact[$hec_count]['remarks']));
											$remark .= $form->error('HotelEmergencyContact.'.$hec_count.'.remarks');
											$remark .= '</td>';

$hec_cls_area = '#HotelEmergencyContact'.$hec_count.'AreaId';
$hec_cls_country = '#HotelEmergencyContact'.$hec_count.'CountryId';
$hec_cls_state = '#HotelEmergencyContact'.$hec_count.'StateId';
$hec_cls_city = '#HotelEmergencyContact'.$hec_count.'CityId';

$hec_area_id = '$("select#HotelEmergencyContact'.$hec_count.'AreaId option:selected").val()';
$hec_country_id = '$("select#HotelEmergencyContact'.$hec_count.'CountryId option:selected").val()';
$hec_state_id = '$("select#HotelEmergencyContact'.$hec_count.'StateId option:selected").val()';
$hec_city_id = '$("select#HotelEmergencyContact'.$hec_count.'CityId option:selected").val()';

$hec_area_id_url = '+'.$hec_area_id.'+"/';
$hec_country_id_url = '+'.$hec_country_id.'+"/';
$hec_state_id_url = '+'.$hec_state_id.'+"/';
$hec_city_id_url = '+'.$hec_city_id.'+"/';

$hec_area_url = $base_url.'change_area/"'.$hec_area_id_url;
$hec_country_url = $base_url.'change_country/"'.$hec_area_id_url.'"'.$hec_country_id_url;
$hec_state_url = $base_url.'change_state/"'.$hec_area_id_url.'"'.$hec_country_id_url.'"'.$hec_state_id_url;
$hec_city_url = $base_url.'change_city/"'.$hec_area_id_url.'"'.$hec_country_id_url.'"'.$hec_state_id_url.'"'.$hec_city_id_url;

$hec_area_func = 'function(data) { $("'.$hec_cls_country.'").html(data); }';
$hec_country_func = 'function(data) { $("'.$hec_cls_state.'").html(data); }';
$hec_state_func = 'function(data) { $("'.$hec_cls_city.'").html(data); }';

$hec_opt_state = '{ url: "'.$hec_state_url.'", '.$option_html.' success: '.$hec_state_func.' }';
$hec_opt_country = '{ url: "'.$hec_country_url.'", '.$option_html.' success: '.$hec_country_func.', complete : function() { $.ajax('.$hec_opt_state.') }}';
$hec_opt_area = '{ url: "'.$hec_area_url.'", '.$option_html.' success: '.$hec_area_func.', complete : function() {$.ajax('.$hec_opt_country.') }}';


$hec_script .= '
	$(document).ready(function() {
		$("'.$hec_cls_area.'").change(function() {
			$.ajax('.$hec_opt_area.')
		});
		$("'.$hec_cls_country.'").change(function() {
			$.ajax('.$hec_opt_country.')
		});
		$("'.$hec_cls_state.'").change(function() {
			$.ajax('.$hec_opt_state.')
		});
});';
										}
									?>
									<tr>
										<th class="font-size10pt"><?php echo __('削除'); ?></th>
										<?php echo $delete; ?>
									<tr>
									<tr>
										<th class="font-size10pt"><?php echo __('連絡先名称'); ?></th>
										<?php echo $name; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('ソート'); ?></th>
										<?php echo $sort; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('エリア'); ?></th>
										<?php echo $area; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('国'); ?></th>
										<?php echo $country; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('州'); ?></th>
										<?php echo $state; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('都市'); ?></th>
										<?php echo $city; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('住所1'); ?></th>
										<?php echo $adr1; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('住所2'); ?></th>
										<?php echo $adr2; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('住所3'); ?></th>
										<?php echo $adr3; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('郵便番号'); ?></th>
										<?php echo $post; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('電話国番号'); ?></th>
										<?php echo $prefix; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('電話番号'); ?></th>
										<?php echo $tel; ?>
									<tr>
									</tr>
										<th class="font-size10pt"><?php echo __('備考'); ?></th>
										<?php echo $remark; ?>
									</tr>
								</table>
								<?php echo $form->button(__('連絡先追加',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_edit\', \'/app_admin/hotel/add_contact/\');')); ?>
							</td>
						</tr>
					</table>
				</p>
<?php
	//                                      ↓ この空白ないとエラーになるし、JSPROGの直後は改行じゃないとだめ
	$this->addScript($javascript->codeBlock( <<<JSPROG
	$script
	$hec_script
JSPROG
	));
//↑JSPROGの前に空白文字列とか入れるとエラーになる
?>
			<?php echo $form->end(); ?>
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
