<?php
	echo $javascript->link('discount/jquery-ui-1.8.1.custom.min');
	echo $javascript->link('discount/discount_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Discount'))); ?>
	<p id="counter"><?php __("total $count records"); ?></p>

<?php echo $form->create('Discount');?>
	<div id="list">
		<table class="listTable">
		<tr>
			<th><?php __('order');?></th>
			<th><?php __('name')?></th>
			<th><?php __('item')?></th>
			<th><?php __('item value')?></th>
			<th><?php __('type')?></th>
			<th><?php __('amount')?></th>
			<th><?php __('start date')?></th>
			<th><?php __('end date')?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>
		<tbody class="content">
		<?php
			foreach($discounts as $discount) {
				echo $html->tableCells(
					array(
						array(
							$discount['Discount']['sort'],
							$discount['Discount']['name'],
							$discount['DiscountItem']['code'],
							$discount['Discount']['discount_item_val'],
							$discount['DiscountType']['code'],
							$discount['Discount']['amount'],
							substr($discount['Discount']['start_date'], 0, 10),
							substr($discount['Discount']['end_date'], 0, 10),
							array($html->link(__('Edit', true), array('action' => 'edit', $discount['Discount']['id'])), aa('class', 'actions')),
							array($html->link(__('Delete', true), array('action' => 'delete', $discount['Discount']['id']), array('class' => 'deleteLink'), 'Are you sure?'), aa('class', 'actions'))
						)
					),
					array('id' => 'sort_' . $discount['Discount']['id']),
					array('id' => 'sort_' . $discount['Discount']['id'])
				);
			}
		?>
		</tbody>
		</table>
		<?php echo $this->renderElement('message'); ?>
	</div>
<?php
	echo $html->tag('button', 'Enable sort', array('type' => 'button', 'id' => 'enableSortBtn', 'value' => 0));
	echo $html->tag('button', 'Apply sort', array('type' => 'button', 'id' => 'submitSortBtn', 'value' => 0, 'disabled' => true));
?>
<?php echo $form->end(); ?>
</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Discount', true), array('action' => 'add')); ?></li>
		</ul>
	</div>


		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



