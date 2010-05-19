<?php
	echo $javascript->link('city/city_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('City'))); ?>

	<div id="search">
		<?php echo $form->create('City'); ?>
			<div style="float:left;padding-right:5px;"><?php echo $form->input('code'); ?></div>
			<div style="float:left;padding-right:5px;"><?php echo $form->button('Search', array('type'=>'button', 'class'=>'searchBtn')); ?></div>
		<?php echo $form->end(); ?>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('Id'));?></th>
			<th><?php echo $paginator->sort(__('Country'));?></th>
			<th><?php echo $paginator->sort(__('Code'));?></th>
			<th><?php echo $paginator->sort(__('Name'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
		</tr>
		<?php foreach ($cities as $city): ?>
			<tr>
				<td>
					<?php echo $city['City']['id']; ?>
				</td>
				<td>
					<?php echo $city['CountryLanguage']['name_long']; ?>
				</td>
				<td>
					<?php echo $city['City']['code']; ?>
				</td>
				<td>
					<?php echo $city['CityLanguage']['name']; ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit', true), array('action' => 'edit', $city['City']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit Name', true), array('action' => 'editName', $city['City']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>

	<?php echo $this->renderElement('index_paging'); ?>
</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New City', true), array('action' => 'add')); ?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



