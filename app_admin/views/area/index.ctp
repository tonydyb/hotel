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
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('Code');?></label></th>
				<td>
					<?php echo $html->tag('input', null, array('id' => 'code', 'value' => isset($this->passedArgs['code']) ? $this->passedArgs['code']:'')); ?>
				</td>
				<td><a href="#" id="searchLink">Search</a></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<?php
			$paginator->options(array('url' => $this->passedArgs));

			$code = 'Code';
			if ($session->read('view_iso') == 'ja') {
				$code = 'コード';
			}
		?>
		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort('ID', 'id');?></th>
			<th><?php echo $paginator->sort($code, 'code');?></th>
			<th><?php __('Name');?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
			<th class="actions"><?php __('Area Link Country');?></th>
			<th class="actions"><?php __('Area Link City');?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>
		<?php
			foreach($areas as $area) {
				echo $html->tableCells(
					array(
						array(
							$area['Area']['id'],
							$area['Area']['code'],
							isset($area['AreaLanguage'][0]['name']) ? $area['AreaLanguage'][0]['name'] : '',
							array($html->link(__('Edit', true), array('action' => 'edit', $area['Area']['id'])), aa('class','actions')),
							array($html->link(__('Edit Name', true), array('action' => 'editName', $area['Area']['id'])), aa('class','actions')),
							array($html->link(__('Edit Country', true), array('action' => 'editCountry', $area['Area']['id'])), aa('class','actions')),
							array($html->link(__('Edit City', true), array('action' => 'editCity', $area['Area']['id'])), aa('class','actions')),
							array($html->link(__('Delete', true), array('action' => 'delete', $area['Area']['id']), array('class' => 'deleteLink'), 'Are you sure?'), aa('class','actions'))
						)
					)
				);
			}
		?>
		</table>
		<?php echo $this->renderElement('index_paging'); ?>
	</div>
	<?php echo $this->renderElement('message'); ?>

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



