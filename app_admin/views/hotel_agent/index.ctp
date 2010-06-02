<?php
	echo $html->css('themes/base/jquery.ui.all');
	echo $javascript->link('ui/jquery.ui.core');
	echo $javascript->link('ui/jquery.ui.widget');
	echo $javascript->link('ui/jquery.ui.datepicker');

	echo $javascript->link('hotel_agent/hotel_agent_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Hotel Agent'))); ?>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php __('id') ?></th>
			<th><?php __('name') ?></th>
			<th><?php __('code') ?></th>
			<th><?php __('account') ?></th>
			<th><?php __('email') ?></th>
			<th><?php __('tel') ?></th>
			<!--<th><?php __('fax') ?></th>-->
			<th><?php __('commission') ?></th>
			<th><?php __('amount') ?></th>
			<th><?php __('percent') ?></th>
			<th><?php __('amount_max') ?></th>
			<th><?php __('percent_max') ?></th>
			<!-- <th><?php echo $paginator->sort(__('url'));?></th> -->
			<th><?php __('country') ?></th>
			<!--<th><?php echo $paginator->sort(__('postcode'));?></th> -->
			<!--<th><?php echo $paginator->sort(__('addr1'));?></th>-->
			<!--<th><?php echo $paginator->sort(__('addr2'));?></th>-->
			<!--<th><?php echo $paginator->sort(__('addr3'));?></th>-->
			<th><?php __('created') ?></th>
			<th class="actions"><?php __('View');?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>
		<?php
			foreach ($hotelAgents as $hotelAgent) {
				echo $html->tableCells(
					array(
						array(
							$hotelAgent['HotelAgent']['id'],
							$hotelAgent['HotelAgent']['name'],
							$hotelAgent['HotelAgent']['code'],
							$hotelAgent['HotelAgent']['account'],
							$hotelAgent['HotelAgent']['email'],
							$hotelAgent['HotelAgent']['tel'],
							//$hotelAgent['HotelAgent']['fax'],
							$hotelAgent['HotelAgent']['commission'],
							$hotelAgent['HotelAgent']['amount'],
							$hotelAgent['HotelAgent']['percent'],
							$hotelAgent['HotelAgent']['amount_max'],
							$hotelAgent['HotelAgent']['percent_max'],
							//$hotelAgent['HotelAgent']['url'],
							$hotelAgent['CountryLanguage']['name'],
							//$hotelAgent['HotelAgent']['postcode'],
							//$hotelAgent['HotelAgent']['addr_1'],
							//$hotelAgent['HotelAgent']['addr_2'],
							//$hotelAgent['HotelAgent']['addr_3'],
							substr($hotelAgent['HotelAgent']['created'], 0, 10),
							array($html->link(__('View', true), array('action' => 'view', $hotelAgent['HotelAgent']['id'])), aa('class', 'actions')),
							array($html->link(__('Edit', true), array('action' => 'edit', $hotelAgent['HotelAgent']['id'])), aa('class', 'actions')),
							array($html->link(__('Delete', true), array('action' => 'delete', $hotelAgent['HotelAgent']['id']), array('class' => 'deleteLink'), 'Are you sure?'), aa('class', 'actions'))
						)
					)
				);
			}
		?>
		</table>
	</div>

	<?php echo $this->renderElement('index_paging'); ?>
	<?php echo $this->renderElement('message'); ?>
</div>
	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Hotel Agent', true), array('action' => 'add')); ?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



