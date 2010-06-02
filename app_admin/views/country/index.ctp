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
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('iso_code_a2');?></label></th>
				<td>
					<?php echo $html->tag('input', null, array('id' => 'iso_code_a2', 'value' => isset($this->passedArgs['iso_code_a2']) ? $this->passedArgs['iso_code_a2']:'')); ?>
				</td>
				<td><a href="#" id="searchLink">Search</a></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php __('id');?></th>
			<th><?php __('iso_code_n');?></th>
			<th><?php __('iso_code_a2');?></th>
			<th><?php __('iso_code_a3');?></th>
			<th><?php __('name');?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
		</tr>
		<?php
			foreach ($country as $country) {
				echo $html->tableCells(
					array(
						array(
							$country['Country']['id'],
							$country['Country']['iso_code_n'],
							$country['Country']['iso_code_a2'],
							$country['Country']['iso_code_a3'],
							$country['CountryLanguage']['name'],
							array($html->link(__('Edit', true), array('action' => 'edit', $country['Country']['id'])), aa('class', 'actions')),
							array($html->link(__('Edit Name', true), array('action' => 'editName', $country['Country']['id'])), aa('class', 'actions'))
						)
					)
				);
			}
		?>
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



