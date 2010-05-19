<div id="top">
	<div id="header">
		<h1><?php __('会員登録・編集'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<h2><?php __('会員登録・編集'); ?></h2>
			<p>
				<?php echo $this->renderElement('customer_edit'); ?>
			</p>
		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
