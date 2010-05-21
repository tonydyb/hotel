
<table id="language">
<tr id="language">
<td id="language">
<?php
	echo $form->create('Login', array('type' => 'post','name' => 'formheader', 'action' => '/change_language'));
	$lang_opt = array();
	foreach ($view_lang as $lang) {
		$lang_opt[trim($lang['ViewLanguage']['iso_code'])] = $lang['ViewLanguage']['name'];
	}
	echo ($form->input('ViewLanguage.iso', array('type' => 'select', 'options' => $lang_opt, 'label'=>'', 'div' => false, 'selected' => $view_iso)));
	echo ($form->input('ViewLanguage.redirect', array('type' => 'hidden', 'value' => '/' . $this->name . '/' . $this->action)));
	echo $form->submit(__('変更',true), array('div' => false));
	echo $form->end();
?>
</td>
<td id="language">
<?php echo $html->link(__('パスワード変更', true), ''); ?>
</td>
<td id="language">
<?php echo $html->link(__('ログアウト', true), '/login/logoff/'); ?>
</td>
</tr>
</table>