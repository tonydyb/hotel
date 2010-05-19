<?php
	echo $javascript->link('content/content_block_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Content Block'))); ?>

	<div id="search">
		<?php echo $form->create('ContentBlock'); ?>
			<div style="float:left;padding-right:5px;"><?php echo $form->input('alias'); ?></div>
			<div style="float:left;padding-right:5px;"><?php echo $form->button('Search', array('type'=>'button', 'class'=>'searchBtn')); ?></div>
		<?php echo $form->end(); ?>
	</div>
	<div class="clear"></div>

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('id'));?></th>
			<th><?php echo $paginator->sort(__('name'));?></th>
			<th><?php echo $paginator->sort(__('alias'));?></th>
			<th><?php echo $paginator->sort(__('carrier_type'));?></th>
			<th><?php echo $paginator->sort(__('language'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>

		<?php foreach($contentBlocks as $contentBlock) { ?>
			<tr>
				<td>
					<?php echo $contentBlock['ContentBlock']['id']; ?>
				</td>
				<td>
					<?php echo $contentBlock['ContentBlock']['name']; ?>
				</td>
				<td>
					<?php echo $contentBlock['ContentBlock']['alias']; ?>
				</td>
				<td>
					<?php echo $contentBlock['CarrierType']['name']; ?>
				</td>
				<td>
					<?php echo $contentBlock['LanguageLanguage']['name']; ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Edit', true), array('action' => 'edit', $contentBlock['ContentBlock']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $html->link(__('Delete', true), array('action' => 'delete', $contentBlock['ContentBlock']['id']), array('class' => 'deleteLink'), 'Are you sure?'); ?>
				</td>
			</tr>
		<?php } ?>
		</table>
		<?php echo $this->renderElement('index_paging'); ?>
	</div>
	<?php echo $this->renderElement('message'); ?>

</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New ContentBlock', true), array('action' => 'add')); ?></li>
		</ul>
	</div>


		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



