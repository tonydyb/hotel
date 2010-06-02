
<div id="top">
	<div id="header">
		<h1><?php __('ホテル一括登録'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<?php echo $form->create('Hotel', array('type' => 'post', 'enctype' => 'multipart/form-data', 'action' => '/save' ,'name' => 'form_hotel_batch', 'url'=>array('controller'=>'hotel_batch_regist'))); ?>
				<h2><a name="hotel"></a><?php echo __('ホテル一括登録') ?></h2>
				<p>
					<?php
						if (!empty($errors)) {
							echo '<div class="error-message">'.__('エラーのため登録を中止しました。', true).'</div><br />';
						}
						$opt = array();
						$lang_id = array_key_exists($language_id , $use_charset) ? $language_id : DEFAULT_ISO_ID;
						foreach ($use_charset as $name => $charset) {
							$opt[$charset] = $name;
						}
					?>
					<table class="no_border">
						<tr class="no_border">
							<td colspan="3" class="no_border">
								<?php
									echo $form->input('charset', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ZERO));
									echo __('で');
									echo $form->input('extension', array('type' => 'select', 'options' => $file_extension, 'label'=>false, 'div' => false, 'selected' => DEFAULT_SELECTED_VALUE_ZERO));
									echo __('ファイルの');
								?>
							</td>
						</tr>
						<tr class="no_border">
							<td colspan="3" class="no_border">
								&nbsp;
							</td>
						</tr>
						<tr class="no_border">
							<td class="no_border">
								<?php
									echo $form->radio('down_func', $download_name, array('value' => DEFAULT_SELECTED_VALUE_ZERO, 'legend' => false, 'separator' => '<br>'));
									echo '<br />'.__('を', true);
									echo $form->button(__('ダウンロード',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_batch\', \''.BASE_URL.'/hotel_batch_regist/download/\');'));
								?>
							</td>
							<td class="no_border">
								&nbsp;&nbsp;&nbsp;
							</td>
							<td class="no_border align_top">
								<?php
									echo $form->file('file', array('value' => ''));
									echo __('を', true).'<br />';
									echo $form->error('file');
									echo $form->radio('up_func', $upload_name, array('value' => DEFAULT_SELECTED_VALUE_ZERO, 'legend' => false, 'separator' => '<br>'));
									echo '<br />'.__('として', true);
									echo $form->button(__('アップロード',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_hotel_batch\', \''.BASE_URL.'/hotel_batch_regist/upload/\');')).'<br />';
									echo __('<span class="color_orangered">※1行目のデータは表題とみなして登録されません。</span>');
								?>
							</td>
						</tr>

					</table>
				</p>
			<?php echo $form->end(); ?>

			<div>
				<?php
					$hotel_fld = array(
						'id' => __('ホテルID', true),
						'code' => __('ホテルコード', true),
						'hotel_grade_id' => __('ホテルグレードコード', true),
						'city_id' => __('都市コード', true),
						'tel' => __('電話番号', true),
						'fax' => __('FAX', true),
						'email' => __('email', true),
						'postcode' => __('郵便番号', true),
						'total_room_number' => __('部屋数', true),
						'star_rate' => __('スターレート', true),
						'latitude' => __('緯度', true),
						'longitude' => __('経度', true),
						'display_stat' => __('表示状態', true),
						'checkin' => __('チェックイン', true),
						'checkout' => __('チェックアウト', true),
					);
					$hotel_lang_fld = array(
						'name' => __('ホテル名', true),
						'comment' => __('ホテルコメント', true),
						'location_comment' => __('ホテルロケーションコメント', true),
						'addr_1' => __('ホテル住所1', true),
						'addr_2' => __('ホテル住所2', true),
						'addr_3' => __('ホテル住所3', true),
					);
					$room_fld = array(
						'id' => 'ホテル部屋ID',
						'hotel_agent_id' => 'ホールセラーコード',
						'hotel_id' => 'ホテルコード',
						'room_bed_id' => '部屋コード',
						'room_grade_id' => '部屋グレードコード',
						'room_bath_id' => 'バスタブ有無',
						'smoking_id' => '喫煙コード',
						'meal_type_id' => '食事コード',
						'breakfast_type_id' => '朝食コード',
						'currency_id' => '通貨コード',
						'price' => '価格',
						'point' => 'ポイント',
						'commission' => '手数料',
					);
					$room_lang_fld = array(
						'language_id' => '言語コード',
						'name' => '部屋名',
						'comment' => '部屋備考',
					);
					$cancel_fld = array(
						'id' => 'キャンセルポリシーID',
						'hotel_id' => 'ホテルコード',
						'sort_no' => 'ソート番号',
						'remarks' => '備考',
						'term_from' => '宿泊期間開始',
						'term_to' => '宿泊期間終了',
						'charge_occur_from' => '手数料発生日開始',
						'charge_occur_to' => '手数料発生日終了',
						'charge_stat_id' => '手数料内訳',
						'charge_percent' => '手数料パーセント',
					);
					$contact_fld = array(
						'id' => '緊急連絡先ID',
						'hotel_id' => 'ホテルコード',
						'hotel_agent_id' => 'ホールセラーコード',
						'name' => '緊急連絡先名',
						'sort_no' => 'ソート番号',
						'city_id' => '都市コード',
						'addr_1' => '緊急連絡先住所1',
						'addr_2' => '緊急連絡先住所2',
						'addr_3' => '緊急連絡先住所3',
						'remarks' => '備考',
						'postcode' => '緊急連絡先郵便番号',
						'tel_country_code' => '緊急連絡先国際電話国番号',
						'tel' => '緊急連絡先電話番号',
					);
					if (isset($errors)) {
						echo '<div class="error-message">';
						foreach ($errors as $error) {
							if (is_array($error)) {
								if (array_key_exists('csv', $error)) {
									echo str_replace("\n", '<br />', $error['csv']);
								}
								if (array_key_exists('hotel', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['hotel'] as $h_err => $msg) {
										echo array_key_exists($h_err, $hotel_fld) ? $hotel_fld[$h_err].':'.$msg.'<br />' : '';
									}
								}
								if (array_key_exists('hotel_language', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['hotel_language'] as $hl_err => $msg) {
										echo array_key_exists($hl_err, $hotel_lang_fld) ? $hotel_lang_fld[$hl_err].':'.$msg.'<br />' : '';
									}
								}
								if (array_key_exists('room', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['room'] as $r_err => $msg) {
										echo array_key_exists($r_err, $room_fld) ? $room_fld[$r_err].':'.$msg.'<br />' : '';
									}
								}
								if (array_key_exists('room_language', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['room_language'] as $rl_err => $msg) {
										echo array_key_exists($rl_err, $room_lang_fld) ? $room_lang_fld[$rl_err].':'.$msg.'<br />' : '';
									}
								}
								if (array_key_exists('cancel', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['cancel'] as $cc_err => $msg) {
										echo array_key_exists($cc_err, $cancel_fld) ? $cancel_fld[$cc_err].':'.$msg.'<br />' : '';
									}
								}
								if (array_key_exists('contact', $error)) {
									if (!array_key_exists('csv', $error)) {
										echo str_replace("\n", '<br />', $error['prefix']);
									}
									foreach ($error['contact'] as $c_err => $msg) {
										echo array_key_exists($c_err, $contact_fld) ? $contact_fld[$c_err].':'.$msg.'<br />' : '';
									}
								}
							}
						}
						echo '</div>';
					}
				?>
			</div>
		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
