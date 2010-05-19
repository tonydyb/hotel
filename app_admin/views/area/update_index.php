<p>
<?php echo $paginator->counter(array(
			'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
			));
		?>
</p>
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
