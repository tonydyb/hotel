<div id="top">
	<div id="header">
		<h1><?php __('パスワード変更'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<?php echo $form->create('ChangePassword', array('type' => 'post', 'action' => '/send_mail' ,'name' => 'form_change_password', 'url'=>array('controller'=>'login'))); ?>
				<table>
					<tr>
						<th><?php echo __('アカウント') ?></th>
						<td>
							<?php echo $AdminUser['account'] ?>
							<?php echo $form->input('account', array('type'=>'hidden', 'value'=>$AdminUser['account'])); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('旧パスワード') ?></th>
						<td>
							<?php echo $form->text('password', array('type' => 'password', 'size' => '30', 'value'=>$AdminUser['password'])); ?>
							<?php echo $form->error('password'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('新パスワード') ?></th>
						<td>
							<?php echo $form->text('new_password1', array('type' => 'password', 'size' => '30', 'value'=>$AdminUser['new_password1'])); ?>
							<?php echo $form->error('new_password1'); ?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('新パスワード(確認)') ?></th>
						<td>
							<?php echo $form->text('new_password2', array('type' => 'password', 'size' => '30', 'value'=>$AdminUser['new_password2'])); ?>
							<?php echo $form->error('new_password2'); ?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<?php $message1 = __('パスワードを変更します。よろしいですか。', true); ?>
							<?php echo $form->button(__('変更',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_change_password\', \''.BASE_URL.'/login/change_password_submit/\', \'' . $message1 . '\');')); ?>
						</td>
					</tr>
				</table>
			<?php echo $form->end(); ?>
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
