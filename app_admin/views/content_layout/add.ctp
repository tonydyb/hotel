<?php
	echo $javascript->link('content_layout/content_layout_add');
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
<?php echo $form->createSingle('ContentLayout');?>
	<fieldset class="fieldset">
 		<legend><?php __('Add Content Layout');?></legend>
		<div>
		<table>
		<tr>
			<th style="text-align:left"><label><?php __('Language');?></label></th>
			<td>
				<select id="LanguageId" name="LanguageId">
					<?php foreach ($languages as $language) {?>
						<option value="<?php echo $language['language']['id']; ?>" <?php if (isset($_REQUEST["LanguageId"])) { echo $language['language']['id']==$_REQUEST["LanguageId"]?"selected='selected'":""; } ?>><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('CarrierType');?></label></th>
			<td>
				<select id="CarrierTypeId" name="CarrierTypeId">
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
				$str = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
\n<html xmlns=\"http://www.w3.org/1999/xhtml\">
\n<head>
<?php echo \$html->charset(); ?>
\n<meta http-equiv=\"Content-style-Type\" content=\"text/css\" />
\n<meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" />

<?php
	echo \$html->meta('icon');
	echo \$html->css('base');
	echo \$scripts_for_layout;

	//タイトル表示のため、この行を削除できません。
	echo '<title>' . \$title_for_layout . '</title>';
?>
\n</head>

<?php
	//コンテントページ表示のため、この行を削除できません。
	echo \$content_for_layout;
?>
\n</body>
\n</html>";

				echo $form->textarea('content', array(
					'cols' => '100',
					'rows' => '30',
					'value' => $str
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
	<div style="float:left;padding-right:5px;"><?php //echo $form->button('Submit', array('type'=>'button', 'class'=>'submitBtn')); ?></div>
<?php echo $form->end('Submit');?>

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