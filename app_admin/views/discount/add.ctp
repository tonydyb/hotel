<?php
	echo $html->css('themes/base/jquery.ui.all');
	echo $javascript->link('ui/jquery.ui.core');
	echo $javascript->link('ui/jquery.ui.widget');
	echo $javascript->link('ui/jquery.ui.datepicker');

	echo $javascript->link('discount/discount_add');
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
 		<legend><?php __('Add Discount');?></legend>
		<div>
		<table>
		<tr>
			<th style="text-align:left"><label><?php __('Name');?></label></th>
			<td>
			<?php
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
						<option value="<?php echo $discount_item['DiscountItem']['id']; ?>" <?php if (isset($this->data['DiscountItem']['id'])) { echo $discount_item['DiscountItem']['id']==$this->data['DiscountItem']['id']?"selected='selected'":""; } ?>><?php echo $discount_item['DiscountItem']['code']; ?></option>
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
						<option value="<?php echo $discount_type['DiscountType']['id']; ?>" <?php if (isset($this->data['DiscountType']['id'])) { echo $discount_type['DiscountType']['id']==$this->data['DiscountType']['id']?"selected='selected'":""; } ?>><?php echo $discount_type['DiscountType']['code']; ?></option>
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
			<?php echo $html->tag('input', null, array('id' => 'DiscountStartDate', 'name' => 'data[Discount][start_date]')); ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('End date');?></label></th>
			<td>
			<?php echo $html->tag('input', null, array('id' => 'DiscountEndDate', 'name' => 'data[Discount][end_date]')); ?>
			</td>
		</tr>
		</table>
		</div>
	</fieldset>
	<div style="float:left;padding-right:5px;"><?php echo $form->end('Submit');?></div>
<?php echo $form->end(); ?>

	<?php echo $this->renderElement('message'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Discount List', true), array('action' => 'index/'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->