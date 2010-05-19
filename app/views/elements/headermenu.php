
<table id="language">
<tr>
<td>
<?php
	echo $form->create('Admin', array('type' => 'post', 'action' => '/change_language'));
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
<td>
<a href="">パスワード変更</a>&nbsp;
</td>
<td>
<a href="/login/logoff">ログアウト</a>
</td>
</tr>
</table>