<?php
	echo $javascript->link('content/content_layout_add');
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
<?php echo $form->create('ContentLayout');?>
	<fieldset class="fieldset">
 		<legend><?php __('Add Content Layout');?></legend>
		<div>
		<table>
		<tr>
			<th style="text-align:left"><label><?php __('Language');?></label></th>
			<td>
				<select style="width:200px" id="LanguageId" name="LanguageId">
					<?php foreach ($languages as $language) {?>
						<option value="<?php echo $language['language']['id']; ?>" <?php if (isset($_REQUEST["LanguageId"])) { echo $language['language']['id']==$_REQUEST["LanguageId"]?"selected='selected'":""; } ?>><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('CarrierType');?></label></th>
			<td>
				<select style="width:50px" id="CarrierTypeId" name="CarrierTypeId">
					<?php foreach ($carrierTypes as $carrierType) {?>
						<option value="<?php echo $carrierType['CarrierType']['id']; ?>" <?php if (isset($_REQUEST["CarrierTypeId"])) { echo $carrierType['CarrierType']['id']==$_REQUEST["CarrierTypeId"]?"selected='selected'":""; } ?>><?php echo ($carrierType['CarrierType']['name']); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Name');?></label></th>
			<td>
			<?php
				echo $form->input('name', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
					)
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Alias');?></label></th>
			<td>
			<?php
				echo $form->input('alias', array(
				'label' => false,
				'div' => false,
				'error' => array(
				'wrap' => 'div',
				'class' => 'formerror'
					)
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Title');?></label></th>
			<td>
			<?php
				echo $form->input('title', array(
						'label' => false,
						'div' => false,
						'style' => 'width:90%',
						'error' => array(
							'wrap' => 'div',
							'class' => 'formerror'
						)
					)
				);
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Content');?></label></th>
			<td>
			<?php
				echo $form->textarea('content', array(
					'cols' => '100',
					'rows' => '30'
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('meta keyword');?></label></th>
			<td>
			<?php
				echo $form->textarea('meta_keyword', array(
					'cols' => '100',
					'rows' => '5'
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('meta description');?></label></th>
			<td>
			<?php
				echo $form->textarea('meta_description', array(
					'cols' => '100',
					'rows' => '10'
				));
			?>
			</td>
		</tr>
		</table>
		</div>
	</fieldset>
	<div style="float:left;padding-right:5px;"><?php echo $form->button('Submit', array('type'=>'button', 'class'=>'submitBtn')); ?></div>
<?php echo $form->end(); ?>

	<?php echo $this->renderElement('message'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Content Layout List', true), array('action' => 'index/'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->