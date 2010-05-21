<div id="top">
	<div id="header">
		<h1><?php __('申込管理 メール送信'); ?></h1>
	</div><!-- header end -->
	<div id="contents">
		<div id="main">
			<?php if (!is_null($mail_template['MailTemplateLanguage'])) { ?>
				<?php echo $form->create('MailTemplate', array('type' => 'post', 'action' => '/send_mail' ,'name' => 'form_mail', 'url'=>array('controller'=>'request'))); ?>
					<table>
						<tr>
							<th><?php echo __('メールタイトル') ?></th>
							<td>
								<?php echo $form->text('title', array('size' => '100', 'value'=>$mail_template['MailTemplateLanguage']['title'])); ?>
								<?php echo $form->error('title'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メール内容') ?></th>
							<td>
								<?php echo $form->textarea('contents', array('cols' => '80', 'rows' => '15', 'wrap' => 'off', 'label' => '', 'value'=>$mail_template['MailTemplateLanguage']['contents'])); ?>
								<?php echo $form->error('contents'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('FROM(送信者)') ?></th>
							<td>
								<?php echo $form->text('from_email', array('size' => '100', 'value'=>$mail_template['MailTemplateLanguage']['from_email'])); ?>
								<?php echo $form->error('from_email'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('TO(宛先)') ?></th>
							<td>
								<?php echo $form->text('to_email', array('size' => '100', 'value'=>'')); ?><br />
								<?php echo $form->button(__('メールアドレス',true), array('div' => 'false', 'onclick' => 'copy_send_email_address(false)')); ?>
								<?php echo $form->button(__('携帯メールアドレス',true), array('div' => 'false', 'onclick' => 'copy_send_email_address(true)')); ?>
								<?php echo __('※複数のアドレスに送信する場合は、「,」カンマで区切って入力してください'); ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('BCC') ?></th>
							<td>
								<?php echo $form->text('from_bcc', array('size' => '100', 'value'=>$mail_template['MailTemplateLanguage']['bcc_email'])); ?>
								<?php echo $form->error('from_bcc'); ?>
								<?php echo __('※複数のアドレスに送信する場合は、「,」カンマで区切って入力してください'); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php $message1 = __('メール送信します、よろしいですか。', true); ?>
								<?php echo $form->button(__('メール送信',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_mail\', \''.BASE_URL.'/request/send_mail/'.SEND_MAIL_TO_USER.'/\', \'' . $message1 . '\');')); ?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php echo __('メールアドレス：') ?>
								<?php echo $form->text('test_to_email', array('size' => '40', 'value'=>$mail_template['MailTemplateLanguage']['test_to_email'])); ?>
								<?php echo $form->button(__('テストメール送信',true), array('div' => 'false', 'onclick' => 'regist_no_message(\'form_mail\', \''.BASE_URL.'/request/send_mail/\');')); ?>
							</td>
						</tr>
					</table>
				<?php echo $form->end(); ?>
			<?php } ?>
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
