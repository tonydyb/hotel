

<div id="top">
	<div id="header">
		<h1><a href="index.html"></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

<div id="main_contents" >
<?php echo $html->css('form'); ?>
<?php echo $form->create('Area');?>
	<fieldset class="fieldset">
 		<legend><?php __('Add Area');?></legend>
		<?php
			echo $form->input('code', array(
				'label' => __(''),
				'div'=>'formfield',
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
					)
				));
		?>
	</fieldset>
<?php echo $form->end('Submit');?>

</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Area', true), array('action' => 'index'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



