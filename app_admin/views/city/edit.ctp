
<div id="top">
	<div id="header">
		<h1><a href="index.html"></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

<div id="main_contents" >
<?php echo $form->create('City');?>
	<fieldset class="fieldset">
 		<legend><?php __('Edit City');?></legend>
	<?php
		echo $form->input('id', array(
				'label' => __(''),
				'div'=>'formfield',
				'error' => array(
				'wrap' => 'div',
				'class' => 'formerror'
				)
			));
	?>
	<div style="float:left">
		<label>Country</label>
		<select id="CountryId" name="CountryId">
			<?php foreach ($countries as $country) { ?>
				<option value="<?php echo $country['Country']['id']; ?>" <?php echo $this->data['City']['country_id']==$country['Country']['id']?"selected='selected'":"" ?>><?php echo (trim($country['CountryLanguage']['name'])=="" ? "no name" : $country['CountryLanguage']['name']); ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="clear"></div>
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
		<li><?php echo $html->link(__('List City', true), array('action' => '/index'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



