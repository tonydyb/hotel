<div id="top">
	<div id="header">
		<h1><?php __('会員一覧'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<h2><?php __('新規登録'); ?></h2>
			<button onclick='location.href = "<?php echo BASE_URL ?>/customer_user/edit/";'><?php __('新規登録'); ?></button><br />
			<h2><?php __('会員一覧'); ?></h2>
			<p>
				<?php echo $form->create('Condition', array('type' => 'post', 'action' => '/search' ,'name' => 'form1', 'url'=>array('controller'=>'customer_user'))); ?>
					<table>
						<tr>
							<th colspan="4">会員検索</th>
						</tr>
						<tr>
							<th>
								<?php echo __('FirstName'); ?>
							</th>
							<td>
								<?php echo $form->text('first_name', array('size' => '25', 'value'=>$Condition['first_name'])); ?>
								<?php echo $form->error('first_name'); ?>
							</td>
							<th>
								<?php echo __('LastName'); ?>
							</th>
							<td>
								<?php echo $form->text('last_name', array('size' => '25', 'value'=>$Condition['last_name'])); ?>
								<?php echo $form->error('last_name'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('会員状態'); ?>
							</th>
							<td>
								<?php
									$customer_type_name = array();
									foreach ($customer_type as $ct) {
										$customer_type_name[trim($ct['ctl']['customer_type_id'])] = $ct['ctl']['name'];
									}
									$selected = $Condition['customer_type_id'];
									echo ($form->input('Condition.customer_type_id', array('type' => 'select', 'options' => $customer_type_name, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('customer_type_id'); ?>
							</td>
							<th>
								<?php echo __('メディア'); ?>
							</th>
							<td>
								<?php
									$media_name = array();
									foreach ($media as $med) {
										$media_name[trim($med['media']['id'])] = $med['media']['name'];
									}
									$selected = $Condition['media_id'];
									echo ($form->input('Condition.media_id', array('type' => 'select', 'options' => $media_name, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('media_id'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('メールアドレス'); ?>
							</th>
							<td>
								<?php echo $form->text('email', array('size' => '25', 'value'=>$Condition['email'])); ?>
								<?php echo $form->error('email'); ?>
							</td>
							<th>
								<?php echo __('携帯メールアドレス'); ?>
							</th>
							<td>
								<?php echo $form->text('email_mobile', array('size' => '25', 'value'=>$Condition['email_mobile'])); ?>
								<?php echo $form->error('email_mobile'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('キャリア'); ?>
							</th>
							<td>
								<?php
									$carrier_name = array();
									foreach ($carrier as $car) {
										$carrier_name[trim($car['carrier_type']['id'])] = $car['carrier_type']['name'];
									}
									$selected = $Condition['carrier_type_id'];
									echo ($form->input('Condition.carrier_type_id', array('type' => 'select', 'options' => $carrier_name, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('carrier_type_id'); ?>
							</td>
							<th>
								<?php echo __('メルマガ'); ?>
							</th>
							<td>
								<?php
									$magazine_name = array();
									foreach ($mail_magazine_type as $magazine) {
										$magazine_name[trim($magazine['mmtl']['mail_magazine_type_id'])] = $magazine['mmtl']['name'];
									}
									$selected = $Condition['mail_magazine_type_id'];
									echo ($form->input('Condition.mail_magazine_type_id', array('type' => 'select', 'options' => $magazine_name, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('mail_magazine_type_id'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('住所 国'); ?>
							</th>
							<td colspan="3">
								<?php
									$opt = array();
									foreach ($country as $cnt) {
										$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									}
									$selected = $Condition['addr_country_id'];
									echo ($form->input('Condition.addr_country_id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('addr_country_id'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('パスポート発行国'); ?>
							</th>
							<td colspan="3">
								<?php
									$opt = array();
									foreach ($country as $cnt) {
										$opt[trim($cnt['cl']['country_id'])] = $cnt['cl']['name_long'];
									}
									$selected = $Condition['country_id'];
									echo ($form->input('Condition.country_id', array('type' => 'select', 'options' => $opt, 'empty' => '', 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
								<?php echo $form->error('country_id'); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('登録日時'); ?>
							</th>
							<td colspan="3">
								<div class="toLeft">
									<?php
										$defaul = null;
										$default = $construct->toArray($Condition['day_from']);
										if (empty($Condition['day_from'])) {
											$default=array('year'=>MIN_REGIST_YEAR,'month'=>'1','day'=>'1');
										}
										$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y'), 'separator' => ' / ', 'monthNames' => false);
										echo $form->dateTime('Condition.day_from', 'YMD', 'NONE', $default, $attr, false);
									?>
									<?php echo __('～'); ?>
									<?php
										$default = $construct->toArray($Condition['day_to']);
										$attr = array('minYear' => MIN_REGIST_YEAR, 'maxYear' => date('Y'), 'separator' => ' / ', 'monthNames' => false);
										echo $form->dateTime('Condition.day_to', 'YMD', 'NONE', $default, $attr, false);
									?>
									<?php echo $form->error('day_from'); ?>
									<?php echo $form->error('day_to'); ?>
								</div>
								<div class="toRight">
									<?php echo $form->submit(__('検索',true), array('div' => 'false')); ?>
								</div>
							</td>
						</tr>
					</table>
				<?php echo $form->end(); ?>
				<br />

				<?php echo $form->create('mail_magazine', array('type' => 'post', 'action' => '/mail' ,'name' => 'form2', 'url'=>array('controller'=>'customer_user'))); ?>
					<table>
						<tr>
							<th colspan="14">
								<?php
									echo __('この条件内で、');
									$msg1 = sprintf(__('全員（現在 %s 名様）の', true), $paginator->params['paging']['CustomerUser']['count']);
									$msg2 = __('チェックをした会員の', true);
									$msg3 = __('チェックをしていない会員の', true);
									$opt = array('1' => $msg1 , '2' => $msg2, '3' => $msg3);
									$selected = DEFAULT_SELECTED_VALUE_ONE;
									echo $form->input('MailMagazine.check_status', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected));
								?>
								<?php
									$opt = array();
									foreach ($carrier as $car) {
										$opt[trim($car['carrier_type']['id'])] = $car['carrier_type']['name'] . __('アドレスに', true);
									}
									$selected = DEFAULT_SELECTED_VALUE_ONE;
									echo ($form->input('MailMagazine.carrier_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $selected)));
								?>
<!--
								<?php echo $form->submit(__('メール配信する',true), array('div' => false)); ?>
 -->
								<?php echo $form->submit(__('メール配信する',true), array('div' => false, 'disabled'=>true, 'style'=>'color:grey;')); ?>
							</th>
						</tr>
						<tr>
						<th colspan="14">
							<?php echo $this->renderElement('paginator'); ?>
						</th>
						</tr>
						<tr>
							<th></th>
							<th>
								<?php echo __('ID') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('firstName') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.first_name', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.first_name', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('lastName') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.last_name', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.last_name', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('キャリア') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.carrier_type_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.carrier_type_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('メディア') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.media_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.media_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('メールアドレス') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.email', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.email', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('着/不着') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.mail_delivery_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.mail_delivery_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('携帯メールアドレス') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.email_mobile', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.email_mobile', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th>
								<?php echo __('着/不着') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.mail_delivery_mobile_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.mail_delivery_mobile_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('メルマガ') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.mail_magazine_type_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.mail_magazine_type_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('会員状態') ?>
<!--
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.customer_type_id', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.customer_type_id', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
 -->
							</th>
							<th>
								<?php echo __('登録日時') ?>
								<div>
									[<?php echo $paginator->sort('▼', 'CustomerUser.created', array('url'=>array('direction'=>'asc'))); ?>/
									<?php echo $paginator->sort('▲', 'CustomerUser.created', array('url'=>array('direction'=>'desc'))); ?>]
								</div>
							</th>
							<th></th>
						</tr>
						<?php
							$mail_delivery_list = array();
							foreach ($mail_delivery as $md) {
								$mail_delivery_list[trim($md['mdl']['mail_delivery_id'])] = $md['mdl']['name'];
							}
						?>

						<?php $i = 1; ?>
						<?php foreach($CustomerUser as $view_data) { ?>
							<tr>
								<td>
									<?php echo $form->checkbox('MailMagazine.checked.' . $i, array('value' => $view_data['CustomerUser']['id'])) ?>
								</td>
								<td><?php echo $view_data['CustomerUser']['id']; ?></td>
								<td><?php echo $view_data['CustomerUser']['first_name']; ?></td>
								<td><?php echo $view_data['CustomerUser']['last_name']; ?></td>
								<td><?php echo $carrier_name[$view_data['CustomerUser']['carrier_type_id']]; ?></td>
								<td><?php echo $media_name[$view_data['CustomerUser']['media_id']]; ?></td>
								<td><?php echo $view_data['CustomerUser']['email']; ?></td>
								<td><?php echo $mail_delivery_list[$view_data['CustomerUser']['mail_delivery_id']]; ?></td>
								<td><?php echo $view_data['CustomerUser']['email_mobile']; ?></td>
								<td><?php echo $mail_delivery_list[$view_data['CustomerUser']['mail_delivery_mobile_id']]; ?></td>
								<td><?php echo $magazine_name[$view_data['CustomerUser']['mail_magazine_type_id']]; ?></td>
								<td><?php echo $customer_type_name[$view_data['CustomerUser']['customer_type_id']]; ?></td>
								<td><?php echo $view_data['CustomerUser']['created']; ?></td>
								<td><?php echo $html->link(__('詳細', true), '/customer_user/edit/' . $view_data['CustomerUser']['id'] .'/'); ?></td>
							</tr>
							<?php $i++ ?>
						<?php } ?>
					</table>
				<?php echo $form->end(); ?>
			</p>
		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
