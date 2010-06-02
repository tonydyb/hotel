<?php
	echo $html->css('themes/redmond/jquery-ui-1.8.1.custom');
	echo $javascript->link('discount/jquery-ui-1.8.1.custom.min');

	echo $javascript->link('ui/i18n/jquery.ui.datepicker-ja');
	echo $javascript->link('ui/i18n/jquery.ui.datepicker-zh-TW');
	echo $javascript->link('ui/i18n/jquery.ui.datepicker-zh-CN');
	echo $javascript->link('ui/i18n/jquery.ui.datepicker-en-GB');

	echo $javascript->link('discount/discount_edit');
?>

<div id="top">
	<div id="header">
		<h1><a href="index.html"></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

<div id="main_contents" >
<?php echo $form->create('Discount');?>
	<fieldset class="fieldset">
 		<legend><?php __('Edit Discount');?></legend>
		<div>
		<table>
		<tr>
			<th style="text-align:left"><label><?php __('Name');?></label></th>
			<td>
			<?php
				echo $form->input('id', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
					)
				));

				echo $form->input('name', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
					)
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Item');?></label></th>
			<td>
				<select id="Discount/discount_item_id" name="data[Discount][discount_item_id]">
					<?php foreach ($discount_items as $discount_item) {?>
						<option value="<?php echo $discount_item['DiscountItem']['id']; ?>" <?php if (isset($this->data['Discount']['discount_item_id'])) { echo $discount_item['DiscountItem']['id']==$this->data['Discount']['discount_item_id']?"selected='selected'":""; } ?>><?php echo $discount_item['DiscountItem']['code']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Item Value');?></label></th>
			<td>
			<?php
				echo $form->input('discount_item_val', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
					)
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Type');?></label></th>
			<td>
				<select id="Discount/discount_type_id" name="data[Discount][discount_type_id]">
					<?php foreach ($discount_types as $discount_type) {?>
						<option value="<?php echo $discount_type['DiscountType']['id']; ?>" <?php if (isset($this->data['Discount']['discount_type_id'])) { echo $discount_type['DiscountType']['id']==$this->data['Discount']['discount_type_id']?"selected='selected'":""; } ?>><?php echo $discount_type['DiscountType']['code']; ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Amount');?></label></th>
			<td>
			<?php
				echo $form->input('amount', array(
					'label' => false,
					'div' => false,
					'error' => array(
						'wrap' => 'div',
						'class' => 'formerror'
					)
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Start date');?></label></th>
			<td>
			<?php echo $html->tag('input', null, array('id' => 'DiscountStartDate', 'name' => 'data[Discount][start_date]', 'value' => substr($this->data['Discount']['start_date'], 0, 10))); ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('End date');?></label></th>
			<td>
			<?php echo $html->tag('input', null, array('id' => 'DiscountEndDate', 'name' => 'data[Discount][end_date]', 'value' => substr($this->data['Discount']['end_date'], 0, 10))); ?>
			</td>
		</tr>
		</table>
		</div>
	</fieldset>
	<div style="float:left;padding-right:5px;"><?php //echo $form->button('Submit', array('type'=>'button', 'class'=>'submitBtn')); ?></div>
<?php echo $form->end('Submit'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Discount List', true), array('action' => '/index'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->

<?php
	echo $html->tag('hidden', null, array('id'=>'viewIso', 'value'=> $session->read('view_iso')));
?>

