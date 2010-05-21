<?php if (!is_null($mail_template['mail_template_language'])) { ?>
<tr>
	<th><?php echo __('メールタイトル') ?></th>
	<td>
		<?php echo $form->text('MailTemplate.title', array('size' => '100', 'value'=>$mail_template['mail_template_language']['title'])); ?>
		<?php echo $form->error('MailTemplate.title'); ?>
	</td>
</tr>
<tr>
	<th><?php echo __('メール内容') ?></th>
	<td>
		<?php echo $form->textarea('MailTemplate.contents', array('cols' => '80', 'rows' => '15', 'wrap' => 'off', 'label' => '', 'value'=>$mail_template['mail_template_language']['contents'])); ?>
		<?php echo $form->error('MailTemplate.contents'); ?>
	</td>
</tr>
<tr>
	<th><?php echo __('FROM(送信者)') ?></th>
	<td>
		<?php echo $form->text('MailTemplate.from_email', array('size' => '100', 'value'=>$mail_template['mail_template_language']['from_email'])); ?>
		<?php echo $form->error('MailTemplate.from_email'); ?>
	</td>
</tr>
<tr>
	<th><?php echo __('TO(宛先)') ?></th>
	<td>
		<?php echo $form->text('MailTemplate.to_email', array('size' => '100', 'value'=>'')); ?><br />
		<?php echo $form->button(__('メールアドレス',true), array('div' => 'false', 'onclick' => 'copy_send_email_address(false)')); ?>
		<?php echo $form->button(__('携帯メールアドレス',true), array('div' => 'false', 'onclick' => 'copy_send_email_address(true)')); ?>
	</td>
</tr>
<tr>
	<th><?php echo __('BCC') ?></th>
	<td>
		<?php echo $form->text('MailTemplate.from_bcc', array('size' => '100', 'value'=>$mail_template['mail_template_language']['bcc_email'])); ?>
		<?php echo $form->error('MailTemplate.from_bcc'); ?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php $message1 = __('メール送信します、よろしいですか。', true); ?>
		<?php echo $form->button(__('メール送信',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form_request_edit\', \''.BASE_URL.'/request/mail_send/'.SEND_MAIL_TO_USER.'/\', \'' . $message1 . '\');')); ?>
		<?php echo $form->button(__('確認',true), array('div' => 'false', 'onclick' => 'regist_no_message(\'form_request_edit\', \''.BASE_URL.'/request/confirm/\');')); ?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php echo __('メールアドレス：') ?>
		<?php echo $form->text('MailTemplate.test_to_email', array('size' => '40', 'value'=>$mail_template['mail_template_language']['test_to_email'])); ?>
		<?php echo $form->button(__('テストメール送信',true), array('div' => 'false', 'onclick' => 'new_window_submit(\'form_request_edit\', \''.BASE_URL.'/request/mail_send/\');')); ?>
	</td>
</tr>
<?php } ?>
