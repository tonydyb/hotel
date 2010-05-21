<?php
	echo $javascript->link('content_page/content_page_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('Content Page'))); ?>

	<div id="search">
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('Language');?></label></th>
				<td>
					<select id="LanguageId2" name="LanguageId2">
						<option value="" <?php if (isset($this->passedArgs['language_id'])) { echo ''==$this->passedArgs['language_id']?"selected='selected'":""; } ?>></option>
						<?php foreach ($languages as $language) {?>
							<option value="<?php echo $language['language']['id']; ?>" <?php if (isset($this->passedArgs['language_id'])) { echo $language['language']['id']==$this->passedArgs['language_id']?"selected='selected'":""; } ?>><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
						<?php } ?>
					</select>
				</td>
				<th style="text-align:left"><label><?php __('CarrierType');?></label></th>
				<td>
					<select id="CarrierTypeId2" name="CarrierTypeId2">
						<option value="" <?php if (isset($this->passedArgs['carrier_type_id'])) { echo ''==$this->passedArgs['carrier_type_id']?"selected='selected'":""; } ?>></option>
						<?php foreach ($carrierTypes as $carrierType) {?>
							<option value="<?php echo $carrierType['CarrierType']['id']; ?>" <?php if (isset($this->passedArgs['carrier_type_id'])) { echo $carrierType['CarrierType']['id']==$this->passedArgs['carrier_type_id']?"selected='selected'":""; } ?>><?php echo ($carrierType['CarrierType']['name']); ?></option>
						<?php } ?>
					</select>
				</td>
				<th style="text-align:left"><label><?php __('Alias');?></label></th>
				<td>
					<?php echo $html->tag('input', null, array('id' => 'alias', 'value' => isset($this->passedArgs['alias']) ? $this->passedArgs['alias']:'')); ?>
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
			<th><?php echo $paginator->sort(__('id'));?></th>
			<th><?php echo $paginator->sort(__('layout name'));?></th>
			<th><?php echo $paginator->sort(__('name'));?></th>
			<th><?php echo $paginator->sort(__('alias'));?></th>
			<th><?php echo $paginator->sort(__('carrier_type'));?></th>
			<th><?php echo $paginator->sort(__('language'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>
		<?php
			foreach($contentPages as $contentPage) {
				echo $html->tableCells(
					array(
						array(
							$contentPage['ContentPage']['id'],
							$contentPage['ContentLayout']['name'],
							$contentPage['ContentPage']['name'],
							$contentPage['ContentPage']['alias'],
							$contentPage['CarrierType']['name'],
							$contentPage['LanguageLanguage']['name'],
							array($html->link(__('Edit', true), array('action' => 'edit', $contentPage['ContentPage']['id'])), aa('class', 'actions')),
							array($html->link(__('Delete', true), array('action' => 'delete', $contentPage['ContentPage']['id']), array('class' => 'deleteLink'), 'Are you sure?'), aa('class', 'actions'))						)
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
			<li><?php echo $html->link(__('New ContentPage', true), array('action' => 'add')); ?></li>
		</ul>
	</div>


		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



