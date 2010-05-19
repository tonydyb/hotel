<?php

$script = '';
$base_url = BASE_URL.'/request/';
$option_html = 'type: "POST", dataType: "html", timeout: 10000,';

$cls_area = '#Condition2AreaId';
$cls_country = '#Condition2CountryId';
$cls_state = '#Condition2StateId';
$cls_city = '#Condition2CityId';

$area_id = '$("select#Condition2AreaId option:selected").val()';
$country_id = '$("select#Condition2CountryId option:selected").val()';
$state_id = '$("select#Condition2StateId option:selected").val()';
$city_id = '$("select#Condition2CityId option:selected").val()';

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


	//                                      ↓ この空白ないとエラーになるし、JSPROGの直後は改行じゃないとだめ
	$this->addScript($javascript->codeBlock( <<<JSPROG
	$script
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
			<h2><?php echo __('検索条件') ?></h2>
			<?php echo $form->create('Condition2', array('type' => 'post', 'action' => '/search' ,'name' => 'form_search', 'url'=>array('controller'=>'request'))); ?>
				<table>
					<tr>
						<th><?php echo __('申し込み日') ?></th>
						<td>
							<?php
								$default = $construct->toArray($condition2['request_date_from'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('request_date_from', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo __('～'); ?>
							<?php
								$default = $construct->toArray($condition2['request_date_to'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('request_date_to', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('request_date_from'); ?>
							<?php echo $form->error('request_date_to'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('予約確定日') ?></th>
						<td>
							<?php
								$default = $construct->toArray($condition2['fix_date_from'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('fix_date_from', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo __('～'); ?>
							<?php
								$default = $construct->toArray($condition2['fix_date_to'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('fix_date_to', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('fix_date_from'); ?>
							<?php echo $form->error('fix_date_to'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('チェックイン日') ?></th>
						<td>
							<?php
								$default = $construct->toArray($condition2['checkin_from'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('checkin_from', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo __('～'); ?>
							<?php
								$default = $construct->toArray($condition2['checkin_to'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('checkin_to', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('checkin_from'); ?>
							<?php echo $form->error('checkin_to'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('チェックアウト日') ?></th>
						<td>
							<?php
								$default = $construct->toArray($condition2['checkout_from'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('checkout_from', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo __('～'); ?>
							<?php
								$default = $construct->toArray($condition2['checkout_to'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('checkout_to', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('checkout_from'); ?>
							<?php echo $form->error('checkout_to'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('キャンセル期限') ?></th>
						<td>
							<?php
								$default = $construct->toArray($condition2['limit_date_from'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('limit_date_from', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo __('～'); ?>
							<?php
								$default = $construct->toArray($condition2['limit_date_to'], true);
								$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
								echo $form->dateTime('limit_date_to', 'YMD', 'NONE', $default, $attr, true);
							?>
							<?php echo $form->error('limit_date_from'); ?>
							<?php echo $form->error('limit_date_to'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('キーワード') ?></th>
						<td>
							<?php echo $form->text('keyword', array('size' => '50', 'value'=>$condition2['keyword'])); ?>
							<?php echo $form->error('keyword'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('金額') ?></th>
						<td>
							<?php echo $form->text('price', array('size' => '50', 'value'=>$condition2['price'])); ?>
							<?php echo $form->error('price'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('エリア') ?></th>
						<td>
							<table class="no_border">
								<tr class="no_border">
									<td class="no_border">
										<?php
											$opt = array();
											foreach ($area as $ara) {
												$opt[trim($ara['al']['area_id'])] = $ara['al']['name'];
											}
											$condition2['area_id'] = empty($condition2['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $condition2['area_id'];
											echo __('エリア' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo $form->input('area_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $condition2['area_id']));
											echo $form->error('area_id');
										?>
									</td>
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($countrys)) {
												foreach ($countrys as $cnt) {
													$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
												}
											}
											$condition2['country_id'] = empty($condition2['country_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $condition2['country_id'];
											echo __('国' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('country_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $condition2['country_id'])));
											echo $form->error('country_id');
										 ?>
									</td>
								</tr>
								<tr class="no_border">
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($states)) {
												foreach ($states as $sta) {
													$opt[trim($sta['sl']['state_id'])] = $sta['sl']['name'];
												}
											}
											$condition2['state_id'] = empty($condition2['state_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $condition2['state_id'];
											echo __('州' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('state_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $condition2['state_id'])));
											echo $form->error('state_id');
										 ?>
									</td>
									<td class="no_border">
										<?php
											$opt = array();
											if (!empty($citys)) {
												foreach ($citys as $cty) {
													$opt[trim($cty['cl']['city_id'])] = $cty['cl']['name'];
												}
											}
											$condition2['city_id'] = empty($condition2['city_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $condition2['city_id'];
											echo __('都市' , true);
										?>
									</td>
									<td class="no_border">
										<?php
											echo ($form->input('city_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $condition2['city_id'])));
											echo $form->error('city_id');
										 ?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th><?php echo __('担当') ?></th>
						<td>
							<?php
								$opt = array();
								foreach ($admin_user as $adm) {
									$opt[trim($adm['admin_user']['id'])] = $adm['admin_user']['name'];
								}
								$request['admin_user_id'] = empty($request['admin_user_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request['admin_user_id'];
								echo ($form->input('admin_user_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'empty' => '', 'selected' => $request['admin_user_id'])));
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('ホールセラー') ?></th>
						<td>
							<?php
								$opt = array();
								foreach ($hotel_agent as $ha) {
									$opt[trim($ha['hotel_agent']['id'])] = $ha['hotel_agent']['name'];
								}
								echo ($form->input('hotel_agent_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'empty' => '', 'selected' => $condition2['hotel_agent_id'])));
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('メディア') ?></th>
						<td>
							<?php
								$media_name = array();
								foreach ($media as $med) {
									$media_name[trim($med['media']['id'])] = $med['media']['name'];
								}
								$selected = $condition2['media_id'];
								echo ($form->input('media_id', array('type' => 'select', 'options' => $media_name, 'empty' => '', 'label'=>false, 'div' => false, 'selected' => $selected)));
							?>
							<?php echo $form->error('media_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('状態') ?></th>
						<td>
							<?php
								$opt = array();
								foreach ($request_stat as $rs) {
									$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
								}
//								$request['request_stat_id'] = empty($request['request_stat_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $request['request_stat_id'];
//								echo ($form->input('request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'empty'=>'', 'div' => false, 'selected' => $request['request_stat_id'])));
								echo $form->input("request_stat_id", array('type' => 'select', 'multiple' => 'checkbox', 'options' => $opt, 'label' => false, 'selected' => $condition2['request_stat_id']));
							?>
							<?php echo $form->error('request_stat_id'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('カード決済') ?></th>
						<td>
							<?php
								$list = array('1'=>'<span style="color:red">あり</span>','2'=>'なし','3'=>'両方',);
								$default = empty($condition2['request_settlement_id']) ? 3 : $condition2['request_settlement_id'];
								echo $form->input('request_settlement_id', array('type'=> 'radio', 'options' => $list, 'legend' => false, 'div' => false, 'label' => false, 'separator' => '<br />', 'value' => $default));
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('カード承認番号') ?></th>
						<td>
							<input type="text" size="50" />
						</td>
					</tr>
				</table>
				<?php echo $form->submit(__('検索',true), array('div' => false)); ?>
				<?php echo $form->submit(__('CSV出力',true), array('div' => false)); ?>
			<?php echo $form->end(); ?>
		</p>
		<h2><?php echo __('検索結果'); ?></h2>
			<?php echo $form->create('RequestChange', array('type' => 'post', 'action' => '/change' ,'name' => 'form_change', 'url'=>array('controller'=>'request'))); ?>
				<table>
					<tr>
						<th><?php echo __('状態変更'); ?></th>
						<td colspan="15">
							<?php
								echo __('チェックした予約を');
								$opt = array();
								foreach ($request_stat as $rs) {
									$opt[trim($rs['mil']['code_id'])] = $rs['mil']['name'];
								}
								echo ($form->input('request_stat_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ONE)));
								echo __('に');
							?>
							<?php $message1 = __('変更してよろしいですか。', true); ?>
							<?php echo $form->button(__('変更する',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_change\', \''.BASE_URL.'/request/change\', \'' . $message1 . '\');')); ?>
						</td>
					</tr>
					<tr>
						<th colspan="15" class="align-left font-pager">
							<?php echo $this->renderElement('paginator2'); ?>
						</th>
					</tr>

					<tr>
						<th>&nbsp;</th>
						<th><?php echo __('No'); ?></th>
						<th><?php echo __('氏名・状態'); ?></th>
						<th><?php echo __('連絡先'); ?></th>
						<th><?php echo __('申込日'); ?></th>
						<th><?php echo __('予約確定日'); ?></th>
						<th><?php echo __('金額'); ?></th>
						<th><?php echo __('決済状況・リクエストID'); ?></th>
						<th><?php echo __('メディア'); ?></th>
						<th><?php echo __('予約状況'); ?></th>
						<th><?php echo __('キャンセル期限'); ?></th>
						<th><?php echo __('チェックイン日<br />チェックアウト日'); ?></th>
						<th><?php echo __('エリア<br />ホテル名'); ?></th>
						<th><?php echo __('部屋名'); ?></th>
						<th><?php echo __('バウチャー'); ?></th>
					</tr>
					<?php $i = 1; $sub_id = 0; ?>
					<?php foreach($Request as $view_data) { ?>
						<?php
							$count = $sub_id;
							while($count < count($Attached)) {
								if ($Attached[$count]['Request']['id'] == $view_data['Request']['id']) {
									$count++;
								} else {
									break;
								}
							}
							$count = $count - $sub_id;
							$first_data = true;
						 ?>
						<tr>
							<td id="search-result"  rowspan="<?php echo $count; ?>">
								<?php echo $html->link($html->image("/img/btn.gif"), '/request/edit/'.$view_data['Request']['id'].'/',null,null,false); ?>
								<br />
								<?php echo $form->checkbox('RequestChenge.checked.' . $i++, array('value' => $view_data['Request']['id'])); ?>
							</td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['Request']['id'] ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['Request']['first_name'].' '.$view_data['Request']['last_name'] ?><br /><?php echo $view_data['MiscInfoLanguage']['name'] ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['Request']['tel'] ?><br /><?php echo $view_data['Request']['tel_mobile'] ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $html->df($view_data['Request']['request_date']); ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $html->df($view_data['Request']['fix_date']); ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['Currency']['iso_code_a'].' '.$number->format($view_data['Request']['price'], array('places' => PRICE_PLACES, 'before' => false, 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['RequestPaymentLanguage']['name'] ?><br /><?php echo $view_data['RequestSettlement']['auth_request_id'] ?></td>
							<td id="search-result" rowspan="<?php echo $count; ?>"><?php echo $view_data['Media']['name'] ?></td>
							<?php for ($j = $sub_id; $j < $sub_id + $count; $j++) { ?>
								<?php $sub_data = $Attached[$j]; ?>
								<?php echo $first_data ? '' : '<tr><span id="subtr" />'; ?>
								<?php $first_data = false; ?>
								<td id="search-result"><?php echo $sub_data['RequestStatLanguage']['name'] ?></td>
								<td id="search-result"><?php echo $html->dmf($sub_data['RequestHotel']['limit_date']); ?></td>
								<td id="search-result"><?php echo $html->df($sub_data['RequestHotel']['checkin']); ?><br /><?php echo $html->df($sub_data['RequestHotel']['checkout']); ?></td>
								<td id="search-result">
									<?php if (!empty($sub_data['AreaLanguage']['name'])) { echo $sub_data['AreaLanguage']['name'].'/'; } ?>
									<?php if (!empty($sub_data['CountryLanguage']['name'])) { echo $sub_data['CountryLanguage']['name'].'/'; } ?>
									<?php if (!empty($sub_data['StateLanguage']['name'])) { echo $sub_data['StateLanguage']['name'].'/'; } ?>
									<?php if (!empty($sub_data['CityLanguage']['name'])) { echo $sub_data['CityLanguage']['name']; } ?>
									<br />
									<?php echo $sub_data['HotelLanguage']['name'] ?>
								</td>
								<td id="search-result"><?php echo $sub_data['HotelRoomLanguage']['name'] ?></td>
								<td id="search-result">html</td>
								<?php echo $first_data ? '' : '<span id="subtr" /></tr >'; ?>
							<?php } ?>
					<?php
							$sub_id = $count;
						}
					 ?>
				</table>
			<?php echo $form->end(); ?>
			<br />
			</p>
		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->