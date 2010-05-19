<?php
	echo $javascript->link('country/country_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Country'))); ?>

	<div id="search">
		<?php echo $form->create('Country'); ?>
			<div style="float:left;padding-right:5px;"><?php echo $form->input('iso_code_a2'); ?></div>
			<div style="float:left;padding-right:5px;"><?php echo $form->button('Search', array('type'=>'button', 'class'=>'searchBtn')); ?></div>
		<?php echo $form->end(); ?>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('id'));?></th>
			<th><?php echo $paginator->sort(__('iso_code_n'));?></th>
			<th><?php echo $paginator->sort(__('iso_code_a2'));?></th>
			<th><?php echo $paginator->sort(__('iso_code_a3'));?></th>
			<th><?php echo $paginator->sort(__('name'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
		</tr>
		<?php foreach ($country as $country): ?>
			<tr>
				<td>
					<?php echo $country['Country']['id']; ?>
				</td>
				<td>
					<?php echo $country['Country']['iso_code_n']; ?>
				</td>
				<td>
					<?php echo $country['Country']['iso_code_a2']; ?>
				</td>
				<td>
					<?php echo $country['Country']['iso_code_a3']; ?>
				</td>
				<td>
					<?php echo $country['CountryLanguage']['name']; ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit', true), array('action' => 'edit', $country['Country']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit Name', true), array('action' => 'editName', $country['Country']['id'])); ?>
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
			<li><?php echo $html->link(__('New Country', true), array('action' => 'add')); ?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



