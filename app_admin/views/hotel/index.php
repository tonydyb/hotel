<?php

$script = '';
$base_url = BASE_URL.'/request/';
$option_html = 'type: "POST", dataType: "html", timeout: 10000,';

$cls_area = '#Condition3AreaId';
$cls_country = '#Condition3CountryId';
$cls_state = '#Condition3StateId';
$cls_city = '#Condition3CityId';

$area_id = '$("select#Condition3AreaId option:selected").val()';
$country_id = '$("select#Condition3CountryId option:selected").val()';
$state_id = '$("select#Condition3StateId option:selected").val()';
$city_id = '$("select#Condition3CityId option:selected").val()';

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

			<h2><?php echo __('新規登録'); ?></h2>
			<p>
				<?php echo $html->link(__('新規登録', true), '/hotel/edit/'); ?>
			</p>

			<h2><?php echo __('ホテル一覧'); ?></h2>

			<p>
				<?php echo $form->create('Condition3', array('type' => 'post', 'action' => '/search' ,'name' => 'form_search', 'url'=>array('controller'=>'hotel'))); ?>
					<table>
						<tr>
							<th colspan="2"><?php echo __('ホテル検索'); ?></th>
						</tr>
						<tr>
							<td>
								<?php
									echo $form->text('keyword', array('size' => '30', 'value'=>$Condition3['keyword']));
									$opt = array();
									foreach ($hotel_agent as $ha) {
										$opt[trim($ha['hotel_agent']['id'])] = $ha['hotel_agent']['name'];
									}
									echo ($form->input('hotel_agent_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'empty' => '', 'selected' => $Condition3['hotel_agent_id'])));
									$opt = array(''=>__('状態', true), DISPLAY_STAT_EXIST=>'表示', DISPLAY_STAT_NOTEXIST=>'非表示', DISPLAY_STAT_DELETE=>'削除');
									echo ($form->input('display_stat', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Condition3['display_stat'])));
									$opt = array('value' => HOTEL_IMAGE_EXISTS, 'checked' => $Condition3['image_exists']);
									echo $form->checkbox('image_exists', null, $opt);
									echo __('画像あり');
								?>
								<?php echo $form->error('keyword'); ?>
							</td>
						</tr>
						<tr>
							<td>
								<table class="no_border">
									<tr class="no_border">
										<td class="no_border">
											<?php
												$opt = array();
												foreach ($area as $ara) {
													$opt[trim($ara['al']['area_id'])] = $ara['al']['name'];
												}
												$Condition3['area_id'] = empty($Condition3['area_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Condition3['area_id'];
												echo __('エリア' , true);
											?>
										</td>
										<td class="no_border">
											<?php
												echo $form->input('area_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Condition3['area_id']));
												echo $form->error('area_id');
											?>
										</td>
										<td class="no_border">
											<?php
												$opt = array();
												if (!empty($country)) {
													$opt['0'] = '';
													foreach ($country as $cnt) {
														$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
													}
												}
												$Condition3['country_id'] = empty($Condition3['country_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Condition3['country_id'];
												echo __('国' , true);
											?>
										</td>
										<td class="no_border">
											<?php
												echo ($form->input('country_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Condition3['country_id'])));
												echo $form->error('country_id');
											 ?>
										</td>
									</tr>
									<tr class="no_border">
										<td class="no_border">
											<?php
												$opt = array();
												if (!empty($state)) {
													$opt['0'] = '';
													foreach ($state as $sta) {
														$opt[trim($sta['sl']['state_id'])] = $sta['sl']['name'];
													}
												}
												$Condition3['state_id'] = empty($Condition3['state_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Condition3['state_id'];
												echo __('州' , true);
											?>
										</td>
										<td class="no_border">
											<?php
												echo ($form->input('state_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Condition3['state_id'])));
												echo $form->error('state_id');
											 ?>
										</td>
										<td class="no_border">
											<?php
												$opt = array();
												if (!empty($city)) {
													$opt['0'] = '';
													foreach ($city as $cty) {
														$opt[trim($cty['cl']['city_id'])] = $cty['cl']['name'];
													}
												}
												$Condition3['city_id'] = empty($Condition3['city_id']) ? DEFAULT_SELECTED_VALUE_ZERO : $Condition3['city_id'];
												echo __('都市' , true);
											?>
										</td>
										<td class="no_border">
											<?php
												echo ($form->input('city_id', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $Condition3['city_id'])));
												echo $form->error('city_id');
											 ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<?php
									$default = $construct->toArray($Condition3['created_from'], true);
									$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
									echo $form->dateTime('created_from', 'YMD', 'NONE', $default, $attr, true);
									echo __('～');
									$default = $construct->toArray($Condition3['created_to'], true);
									$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y')+1, 'separator' => ' / ', 'monthNames' => false);
									echo $form->dateTime('created_to', 'YMD', 'NONE', $default, $attr, true);
								?>
								<?php echo $form->error('created_from'); ?>
								<?php echo $form->error('created_to'); ?>
								<?php echo $form->submit(__('検索',true), array('div' => false)); ?>
							</td>
						</tr>
					</table>
					<br />

					<table>
						<tr>
							<th colspan="11" class="align-left font-pager">
								<?php echo $this->renderElement('paginator3'); ?>
							</th>
						</tr>
						<tr>
							<th colspan="2"><?php echo __('状態変更'); ?></th>
							<td colspan="9">
								<?php
									echo __('チェックしたホテルを');
									$opt = array(DISPLAY_STAT_EXIST=>'表示', DISPLAY_STAT_NOTEXIST=>'非表示', DISPLAY_STAT_DELETE=>'削除');
									echo ($form->input('Change.display_stat', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => DISPLAY_STAT_EXIST)));
									echo __('に');
								?>
								<?php $message1 = __('変更してよろしいですか。', true); ?>
								<?php echo $form->button(__('変更する',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_search\', \''.BASE_URL.'/hotel/change\', \'' . $message1 . '\');')); ?>
							</td>
						</tr>
						<tr>
							<th>
							</th>
 							<th>
								<?php echo __('ID'); ?>
								<div>
									[<?php echo $paginator->sort('▼', 'Hotel.id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'Hotel.id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th><?php echo __('エリア'); ?></th>
							<th><?php echo __('国'); ?></th>
							<th><?php echo __('都市'); ?></th>
							<th><?php echo __('ホテル名'); ?></th>
							<th>
								<?php echo __('コード'); ?>
								<div>
									[<?php echo $paginator->sort('▼', 'Hotel.code', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'Hotel.code', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('状態'); ?>
								<div>
									[<?php echo $paginator->sort('▼', 'Hotel.display_stat', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'Hotel.display_stat', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('部屋タイプ数'); ?>
							</th>
							<th>
								<?php echo __('登録日時'); ?>
								<div>
									[<?php echo $paginator->sort('▼', 'Hotel.created', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'Hotel.created', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th></th>
						</tr>
						<?php
							$i = 0;
							foreach ($Hotel as $data) {
						?>
							<tr>
								<td>
									<?php echo $form->checkbox('Change.checked.' . $i, array('value' => $data['Hotel']['id'])) ?>
								</td>
								<td><?php echo $data['Hotel']['id']; ?></td>
								<td><?php echo $Attached[$i]['area_name']; ?></td>
								<td><?php echo $Attached[$i]['country_name']; ?></td>
								<td><?php echo $Attached[$i]['city_name']; ?></td>
								<td><?php echo $Attached[$i]['name']; ?></td>
								<td><?php echo $data['Hotel']['code']; ?></td>
								<td class="font-gothic">
									<?php echo $data['Hotel']['display_stat'] == DISPLAY_STAT_EXIST ? __('○', true) : ($data['Hotel']['display_stat'] == DISPLAY_STAT_NOTEXIST ? __('△', true) : __('×', true)); ?>
								</td>
								<td><?php echo $data['0']['count(`HotelRoom`.`id`)']; ?></td>
								<td><?php echo $html->dmf($data['Hotel']['created']); ?></td>
								<td><?php echo $html->link(__('編集', true), '/hotel/edit/' . $data['Hotel']['id'] .'/'); ?></td>
							</tr>
						<?php
							$i++;
							}
						?>
					</table>
				<?php echo $form->end(); ?>
			</p>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->