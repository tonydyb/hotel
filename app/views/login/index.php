<div id="top">
	<div id="contents" class="align-center">
		<div id="title"><h2><?php __('海外ホテル予約 管理者ログイン'); ?></h2></div>
		<div>
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
		</div>
		<div>
			<?php echo $form->create('', array('type' => 'post', 'action' => '/login')); ?>
				<table class="margin-center">
					<tr>
						<th class="align-right"><?php __('ID'); ?></th>
						<td>
							<?php echo $form->text('AdminUser.account'); ?>
						</td>
					</tr>
					<tr>
						<th class="align-right"><?php __('パスワード'); ?></th>
						<td>
							<?php echo $form->password('AdminUser.password'); ?>
						</td>
					</tr>
				</table>
				<? echo $form->error('AdminUser.loginfailed'); ?>
				<?php echo $form->submit(__('ログイン',true), array('div' => 'false')); ?>
			<?php echo $form->end(); ?>
		</div>
	</div><!-- contents end -->
</div><!-- top end -->

