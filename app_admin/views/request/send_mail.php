<div id="top">
	<div id="header">
		<h1><?php __('申込管理 メール送信'); ?></h1>
	</div><!-- header end -->
	<div id="contents">
		<div id="main">
			<?php if (!is_null($smtp_errors)) { ?>
				<div class="error-message"><?php echo $smtp_errors; ?></div>
			<?php } else { ?>
				<div><?php echo __('メールを送信しました。'); ?></div>
			<?php } ?>
			<br />
			<input type="button" value="<?php echo __('閉じる') ?>" onClick="new_window_close()"; />
		</div> <!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
