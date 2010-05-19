<?php
	echo $javascript->link('area/area_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Area'))); ?>

	<div id="search">
		<?php echo $form->create('Area'); ?>
			<div style="float:left;padding-right:5px;"><?php echo $form->input('code'); ?></div>
			<div style="float:left;padding-right:5px;"><?php echo $form->button('Search', array('type'=>'button', 'class'=>'searchBtn')); ?></div>
		<?php echo $form->end(); ?>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('id'));?></th>
			<th><?php echo $paginator->sort(__('code'));?></th>
			<th><?php echo $paginator->sort(__('name'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
			<th class="actions"><?php __('Area Link Country');?></th>
			<th class="actions"><?php __('Area Link City');?></th>
		</tr>

		<?php foreach($areas as $area) { ?>
			<tr>
				<td>
					<?php echo $area['area']['id']; ?>
				</td>
				<td>
					<?php echo $area['area']['code']; ?>
				</td>
				<td>
					<?php echo $area['area_language']['name']; ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit', true), array('action' => 'edit', $area['area']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit Name', true), array('action' => 'editName', $area['area']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit Country', true), array('action' => 'editCountry', $area['area']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit City', true), array('action' => 'editCity', $area['area']['id'])); ?>
				</td>
			</tr>
		<?php } ?>
		</table>
		<?php echo $this->renderElement('index_paging'); ?>
	</div>


</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Area', true), array('action' => 'add')); ?></li>
		</ul>
	</div>


		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



