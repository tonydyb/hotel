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
<?php echo $form->create('City');?>
	<fieldset class="fieldset">
 		<legend><?php __('Add City');?></legend>
		<div style="float:left">
			<label>Country</label>
			<select id="CountryId" name="CountryId">
				<?php foreach ($countries as $country) { ?>
					<option value="<?php echo $country['Country']['id']; ?>"><?php echo (trim($country['CountryLanguage']['name'])=="" ? "no name" : $country['CountryLanguage']['name']); ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="clear"></div>
	<?php
		/*echo $form->input('country_id', array(
			'label' => __(''),
			'div'=>'formfield',
			'error' => array(
				'wrap' => 'div',
				'class' => 'formerror'
				)
			));
		echo $form->input('state_id', array(
			'label' => __(''),
			'div'=>'formfield',
			'error' => array(
				'wrap' => 'div',
				'class' => 'formerror'
				)
			));*/
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
		<li><?php echo $html->link(__('City List', true), array('action' => 'index/'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->