				<?php echo $form->create('CustomerUser', array('type' => 'post', 'action' => '/save', 'url'=>array('controller'=>'customer_user'))); ?>
					<table>
						<tr><th colspan="2"><?php echo __('会員情報') ?></th></tr>
						<tr>
							<th><?php echo __('No') ?></th>
							<td>
								<?php echo $CustomerUser['id'] ?>
								<?php echo $form->hidden('id', array('value'=>$CustomerUser['last_access'])) ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('アカウント') ?></th>
							<td>
								<?php echo $form->text('account', array('size' => '50')); ?>
								<?php echo $form->error('account');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('パスワード') ?></th>
							<td>
								<?php echo $form->text('password', array('size' => '50')); ?>
								<?php echo $form->error('password');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FirstName') ?></th>
							<td>
								<?php echo $form->text('first_name', array('size' => '50', 'label' => 'first_name:')); ?>
								<?php echo $form->error('first_name');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('LastName') ?></th>
							<td>
								<?php echo $form->text('last_name', array('size' => '50', 'label' => 'last_name:')); ?>
								<?php echo $form->error('last_name');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メールアドレス') ?></th>
							<td>
								<?php echo $form->text('email', array('size' => '50')); ?>
								<?php echo $form->error('email');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯メールアドレス') ?></th>
							<td>
								<?php echo $form->text('email_mobile', array('size' => '50')); ?>
								<?php echo $form->error('email_mobile');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('TEL') ?></th>
							<td>
								<?php echo $form->text('tel', array('size' => '50')); ?>
								<?php echo $form->error('tel');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('携帯') ?></th>
							<td>
								<?php echo $form->text('tel_mobile', array('size' => '50')); ?>
								<?php echo $form->error('tel_mobile');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FAX') ?></th>
							<td>
								<?php echo $form->text('fax', array('size' => '50')); ?>
								<?php echo $form->error('fax');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('郵便番号') ?></th>
							<td>
								<?php echo $form->text('postcode', array('size' => '50')); ?>
								<?php echo $form->error('postcode');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所 国') ?></th>
							<td>
								<?php
									$lang_opt = array();
									foreach ($country as $cnt) {
										$cnt_opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									}
									echo ($form->input('CustomerUser.addr_country_id', array('type' => 'select', 'options' => $cnt_opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['addr_country_id'])));
								?>
								<?php echo $form->error('addr_country_id');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所1') ?></th>
							<td>
								<?php echo $form->text('addr_1', array('size' => '50')); ?>
								<?php echo $form->error('addr_1');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所2') ?></th>
							<td>
								<?php echo $form->text('addr_2', array('size' => '50')); ?>
								<?php echo $form->error('addr_2');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('住所3') ?></th>
							<td>
								<?php echo $form->text('addr_3', array('size' => '50')); ?>
								<?php echo $form->error('addr_3');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('性別') ?></th>
							<td>
								<?php
									$gender_opt = array();
									foreach ($gender as $gnd) {
										$gender_opt[$gnd['gl']['gender_id']] = $gnd['gl']['name'];
									}
									echo ($form->input('gender_id', array('type' => 'select', 'options' => $gender_opt, 'label'=>'', 'selected'=>$CustomerUser['gender_id'])));
								?>
								<?php echo $form->error('gender_id');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('誕生日') ?></th>
							<td>
								<?php
								$attr = array('minYear' => date('Y')-120, 'maxYear' => date('Y'), 'separator' => ' / ', 'monthNames' => false, 'selected'=>$CustomerUser['birthday']);
								echo $form->dateTime('CustomerUser.birthday', 'YMD', 'NONE', date('Y-m-d'), $attr);
								?>
								<?php echo $form->error('birthday');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('最終アクセス') ?></th>
							<td>
								<?php echo $CustomerUser['last_access'] ?>
								<?php echo $form->error('last_access');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('言語') ?></th>
							<td>
								<?php
									$lang_opt = array();
									foreach ($view_lang as $lang) {
										$lang_opt[trim($lang['ViewLanguage']['ll_id'])] = $lang['ViewLanguage']['name'];
									}
									echo ($form->input('CustomerUser.language_id', array('type' => 'select', 'options' => $lang_opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['language_id'])));
								?>
								<?php echo $form->error('language_id');?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('国') ?></th>
							<td>
								<?php
									$lang_opt = array();
									foreach ($country as $cnt) {
										$cnt_opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									}
									echo ($form->input('CustomerUser.country_id', array('type' => 'select', 'options' => $cnt_opt, 'label'=>'', 'div' => false, 'selected' => $CustomerUser['country_id'])));
								?>
								<?php echo $form->error('country_id');?>
							</td>
 						</tr>
						<tr>
							<th><?php echo __('登録日時') ?></th>
							<td>
								<?php echo $CustomerUser['created'] ?>
								<?php echo $form->error('created');?>
							</td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $form->submit(__('登録',true), array('div' => 'false')); ?></td>
						</tr>
					</table>
				<?php echo $form->end(); ?>
