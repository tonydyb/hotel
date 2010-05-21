<?php
	echo $javascript->link('jquery-ui-1.8.1.custom.min');
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

	<div id="list">
		<table class="listTable">
		<tr>
			<th><?php __('sort')?></th>
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
							$discount['Discount']['start_date'],
							$discount['Discount']['end_date'],
							array($html->link(__('Edit', true), array('action' => 'edit', $discount['Discount']['id'])), aa('class', 'actions')),
							array($html->link(__('Delete', true), array('action' => 'delete', $discount['Discount']['id']), array('class' => 'deleteLink'), 'Are you sure?'), aa('class', 'actions'))
						)
					)
				);
			}
		?>
		</tbody>
		</table>
		<?php echo $this->renderElement('message'); ?>
	</div>

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



