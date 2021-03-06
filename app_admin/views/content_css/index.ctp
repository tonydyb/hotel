<?php
	echo $javascript->link('content_css/content_css_index');
	echo $javascript->link('content_image/ajaxupload');
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
	<?php echo $this->renderElement('index_title', array("title" => __('CSS'))); ?>

	<div id="upload">
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('Language');?></label></th>
				<td>
					<select id="LanguageId" name="LanguageId">
						<option value="0" <?php if (isset($_REQUEST["LanguageId"])) { echo 0==$_REQUEST["LanguageId"]?"selected='selected'":""; } ?>><?php __('Common') ?></option>
						<?php foreach ($languages as $language) {?>
							<option value="<?php echo $language['language']['id']; ?>" <?php if (isset($_REQUEST["LanguageId"])) { echo $language['language']['id']==$_REQUEST["LanguageId"]?"selected='selected'":""; } ?>><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
						<?php } ?>
					</select>
				</td>
				<th style="text-align:left"><label><?php __('CarrierType');?></label></th>
				<td>
					<select id="CarrierTypeId" name="CarrierTypeId">
						<option value="1" <?php if (isset($_REQUEST["CarrierTypeId"])) { echo 1==$_REQUEST["CarrierTypeId"]?"selected='selected'":""; } ?>>pc</option>
						<option value="2" <?php if (isset($_REQUEST["CarrierTypeId"])) { echo 2==$_REQUEST["CarrierTypeId"]?"selected='selected'":""; } ?>>mobile</option>
					</select>
				</td>
				<td><a href="#" id="uploadLink">Upload Css</a></td>
			</tr>
		</table>
	</div>
	<hr/>
	<div class="clear"></div>

	<div id="search">
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('Language');?></label></th>
				<td>
					<select id="LanguageId2" name="LanguageId2">
						<option value="" <?php if (isset($this->passedArgs['language_id'])) { echo ''==$this->passedArgs['language_id']?"selected='selected'":""; } ?>></option>
						<option value="0" <?php if (isset($this->passedArgs['language_id'])) { echo 0==$this->passedArgs['language_id']?"selected='selected'":""; } ?>><?php __('Common') ?></option>
						<?php foreach ($languages as $language) {?>
							<option value="<?php echo $language['language']['id']; ?>" <?php if (isset($this->passedArgs['language_id'])) { echo $language['language']['id']==$this->passedArgs['language_id']?"selected='selected'":""; } ?>><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
						<?php } ?>
					</select>
				</td>
				<th style="text-align:left"><label><?php __('CarrierType');?></label></th>
				<td>
					<select id="CarrierTypeId2" name="CarrierTypeId2">
						<option value="0" <?php if (isset($this->passedArgs['carrier_type_id'])) { echo 0==$this->passedArgs['carrier_type_id']?"selected='selected'":""; } ?>></option>
						<option value="1" <?php if (isset($this->passedArgs['carrier_type_id'])) { echo 1==$this->passedArgs['carrier_type_id']?"selected='selected'":""; } ?>>pc</option>
						<option value="2" <?php if (isset($this->passedArgs['carrier_type_id'])) { echo 2==$this->passedArgs['carrier_type_id']?"selected='selected'":""; } ?>>mobile</option>
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

	<div id="list">
		<?php echo $this->renderElement('index_counter'); ?>

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('language'));?></th>
			<th><?php echo $paginator->sort(__('carrier_type'));?></th>
			<th><?php echo $paginator->sort(__('alias'));?></th>
			<th><?php echo $paginator->sort(__('tag'));?></th>
			<th class="actions"><?php __('Delete');?></th>
		</tr>
		<?php
			foreach($csses as $css) {
				echo $html->tableCells(
					array(
						array(
							($css['ContentCss']['language_id']==0 ? 'Common' : $css['LanguageLanguage']['name']),
							($css['ContentCss']['carrier_type_id']==1 ? 'PC' : 'Mobile'),
							$css['ContentCss']['alias'],
							$html->tag('textarea', "<?php echo \$html->css(" . "\"\$css_path/" . basename($css['ContentCss']['alias'], '.css') . "\"); ?>", array('readOnly' => true, 'rows' => '1', 'cols' => '60')),
							$html->link(__('Delete', true), array('action' => 'delete', $css['ContentCss']['id']), array('class' => 'deleteLink'), 'Are you sure?')
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

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



