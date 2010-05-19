<!--
//				<?php echo $form->create('CustomerUser', array('type' => 'post', 'action' => '/save', 'url'=>array('controller'=>'customer_user'))); ?>
 -->
				<?php echo $form->create('CustomerUser', array('type' => 'post', 'action' => '/save' ,'name' => 'form_customer_edit', 'url'=>array('controller'=>'customer_user'))); ?>

					<table>
						<tr><th colspan="2"><?php echo __('会員情報'); ?></th></tr>
						<tr>
							<th><?php echo __('No'); ?></th>
							<td>
								<?php echo $CustomerUser['id'] ?>
								<?php echo $form->hidden('id', array('value'=>$CustomerUser['id'])); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('アカウント'); ?></th>
							<td>
								<?php echo $form->text('account', array('size' => '50', 'value'=>$CustomerUser['account'])); ?>
								<?php echo $form->error('account'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('パスワード'); ?></th>
							<td>
								<?php echo $form->text('password', array('size' => '50', 'value'=>$CustomerUser['password'])); ?>
								<?php echo $form->error('password'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FirstName'); ?></th>
							<td>
								<?php echo $form->text('first_name', array('size' => '50', 'value'=>$CustomerUser['first_name'])); ?>
								<?php echo $form->error('first_name'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('LastName'); ?></th>
							<td>
								<?php echo $form->text('last_name', array('size' => '50', 'value'=>$CustomerUser['last_name'])); ?>
								<?php echo $form->error('last_name'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メールアドレス'); ?></th>
							<td>
								<?php echo $form->text('email', array('size' => '50', 'value'=>$CustomerUser['email'])); ?>
								<?php
									$opt = array();
									foreach ($mail_delivery as $md) {
										$opt[trim($md['mdl']['mail_delivery_id'])] = $md['mdl']['name'];
									}
									$CustomerUser['mail_delivery_id'] = empty($CustomerUser['mail_delivery_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['mail_delivery_id'];
									echo ($form->input('CustomerUser.mail_delivery_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['mail_delivery_id'])));
								?>
								<?php echo $form->error('email'); ?>
								<?php echo $form->error('mail_delivery_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯メールアドレス'); ?></th>
							<td>
								<?php echo $form->text('email_mobile', array('size' => '50', 'value'=>$CustomerUser['email_mobile'])); ?>
								<?php
									$opt = array();
									foreach ($mail_delivery as $md) {
										$opt[trim($md['mdl']['mail_delivery_id'])] = $md['mdl']['name'];
									}
									$CustomerUser['mail_delivery_mobile_id'] = empty($CustomerUser['mail_delivery_mobile_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['mail_delivery_mobile_id'];
									echo ($form->input('CustomerUser.mail_delivery_mobile_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['mail_delivery_mobile_id'])));
								?>
								<?php echo $form->error('email_mobile'); ?>
								<?php echo $form->error('mail_delivery_mobile_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('TEL'); ?></th>
							<td>
								<?php echo $form->text('tel', array('size' => '50', 'value'=>$CustomerUser['tel'])); ?>
								<?php echo $form->error('tel'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯'); ?></th>
							<td>
								<?php echo $form->text('tel_mobile', array('size' => '50', 'value'=>$CustomerUser['tel_mobile'])); ?>
								<?php echo $form->error('tel_mobile'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FAX'); ?></th>
							<td>
								<?php echo $form->text('fax', array('size' => '50', 'value'=>$CustomerUser['fax'])); ?>
								<?php echo $form->error('fax'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('郵便番号'); ?></th>
							<td>
								<?php echo $form->text('postcode', array('size' => '50', 'value'=>$CustomerUser['postcode'])); ?>
								<?php echo $form->error('postcode'); ?>
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
									$CustomerUser['addr_country_id'] = empty($CustomerUser['addr_country_id']) ? $first_id : $CustomerUser['addr_country_id'];
									$selected = $CustomerUser['addr_country_id'];
									echo ($form->input('CustomerUser.addr_country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('addr_country_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所1'); ?></th>
							<td>
								<?php echo $form->text('addr_1', array('size' => '50', 'value'=>$CustomerUser['addr_1'])); ?>
								<?php echo $form->error('addr_1'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所2'); ?></th>
							<td>
								<?php echo $form->text('addr_2', array('size' => '50', 'value'=>$CustomerUser['addr_2'])); ?>
								<?php echo $form->error('addr_2'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所3'); ?></th>
							<td>
								<?php echo $form->text('addr_3', array('size' => '50', 'value'=>$CustomerUser['addr_3'])); ?>
								<?php echo $form->error('addr_3'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('性別'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($gender as $gnd) {
										$opt[$gnd['gl']['gender_id']] = $gnd['gl']['name'];
									}
									$CustomerUser['gender_id'] = empty($CustomerUser['gender_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['gender_id'];
									echo ($form->input('gender_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'selected'=>$CustomerUser['gender_id'])));
								?>
								<?php echo $form->error('gender_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('誕生日'); ?></th>
							<td>
								<?php
									$default = $construct->toArray($CustomerUser['birthday']);
									$attr = array('minYear' => date('Y')-BIRTHDAY_MINUS_YEAR, 'maxYear' => date('Y'), 'separator' => ' / ', 'monthNames' => false);
									echo $form->dateTime('CustomerUser.birthday', 'YMD', 'NONE', $default, $attr, false);
								?>
								<?php echo $form->error('birthday'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('最終アクセス'); ?></th>
							<td>
								<?php echo $CustomerUser['last_access'] ?>
								<?php echo $form->hidden('last_access', array('value'=>$CustomerUser['last_access'])); ?>
								<?php echo $form->error('last_access'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('言語'); ?></th>
							<td>
								<?php
									$opt = array();
									$first_id = null;
									foreach ($view_lang as $lang) {
										$opt[trim($lang['ViewLanguage']['ll_id'])] = $lang['ViewLanguage']['name'];
										if (is_null($first_id)) { $first_id = $lang['ViewLanguage']['ll_id']; }
									}
									$CustomerUser['language_id'] = empty($CustomerUser['language_id']) ? $first_id : $CustomerUser['language_id'];
									echo ($form->input('CustomerUser.language_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['language_id'])));
								?>
								<?php echo $form->error('language_id'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('パスポート発行国'); ?></th>
							<td>
								<?php
									$opt = array();
									$first_id = null;
									foreach ($country as $cnt) {
										$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
										if (is_null($first_id)) { $first_id = $cnt['cl']['country_id']; }
									}
									$CustomerUser['country_id'] = empty($CustomerUser['country_id']) ? $first_id : $CustomerUser['country_id'];
									echo ($form->input('CustomerUser.country_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['country_id'])));
								?>
								<?php echo $form->error('country_id'); ?>
							</td>
 						</tr>

						<tr>
							<th><?php echo __('キャリア'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($carrier as $car) {
										$opt[trim($car['carrier_type']['id'])] = $car['carrier_type']['name'];
									}
									$CustomerUser['carrier_type_id'] = empty($CustomerUser['carrier_type_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['carrier_type_id'];
									echo ($form->input('CustomerUser.carrier_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['carrier_type_id'])));
								?>
								<?php echo $form->error('carrier_type_id'); ?>
							</td>
 						</tr>
						<tr>
							<th><?php echo __('メディア'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($media as $med) {
										$opt[trim($med['media']['id'])] = $med['media']['name'];
									}
									$CustomerUser['media_id'] = empty($CustomerUser['media_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['media_id'];
									echo ($form->input('CustomerUser.media_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'selected' => $CustomerUser['media_id'])));
								?>
								<?php echo $form->error('media_id'); ?>
							</td>
 						</tr>
						<tr>
							<th><?php echo __('会員状態'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($customer_type as $ct) {
										$opt[trim($ct['ctl']['customer_type_id'])] = $ct['ctl']['name'];
									}
									$CustomerUser['customer_type_id'] = empty($CustomerUser['customer_type_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['customer_type_id'];
									echo ($form->input('CustomerUser.customer_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['customer_type_id'])));
								?>
								<?php echo $form->error('customer_type_id'); ?>
							</td>
 						</tr>
						<tr>
							<th><?php echo __('メルマガ'); ?></th>
							<td>
								<?php
									$opt = array();
									foreach ($mail_magazine_type as $mt) {
										$opt[trim($mt['mmtl']['mail_magazine_type_id'])] = $mt['mmtl']['name'];
									}
									$CustomerUser['mail_magazine_type_id'] = empty($CustomerUser['mail_magazine_type_id']) ? DEFAULT_SELECTED_VALUE_ONE : $CustomerUser['mail_magazine_type_id'];
									echo ($form->input('CustomerUser.mail_magazine_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['mail_magazine_type_id'])));
								?>
								<?php echo $form->error('mail_magazine_type_id'); ?>
							</td>
 						</tr>

						<tr>
							<th><?php echo __('登録日時'); ?></th>
							<td>
								<?php
									if (!empty($CustomerUser['created'])) {
										echo $CustomerUser['created'];
									}
								 ?>
								<?php echo $form->error('created'); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php $message = __('保存してよろしいですか。', true); ?>
								<?php echo $form->button(__('登録',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_customer_edit\', \'/app_admin/customer_user/save\', \'' . $message . '\');')); ?>
							</td>
						</tr>
					</table>
				<?php echo $form->end(); ?>
