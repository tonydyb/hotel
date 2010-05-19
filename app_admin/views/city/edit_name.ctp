
<div id="top">
	<div id="header">
		<h1><a href="index.html"></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

	<div id="main_contents" >
		<div id="title">
			<?php echo $names[0]['City']['code']; ?>
		</div>
		<div id="list">
			<table cellpadding="0" cellspacing="0" id="names">
				<tr>
					<th><?php echo __('Language'); ?></th>
					<th><?php echo __('Name'); ?></th>
				</tr>
				<?php foreach ($names as $name) { ?>
				<tr>
					<td>
						<?php echo $name['Language']['name']; ?>
					</td>
					<td>
						<?php echo $name['CityLanguage']['name']; ?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div id="form">
			<?php echo $form->create('City', array('action' => 'addName'));?>
			<?php echo $form->hidden("CityId", array("value" => $names[0]['City']['id'])); ?>
			<div style="float:left;padding-right:10px">
				<select style="width:200px" id="LanguageId" name="LanguageId">
					<?php foreach ($languages as $language) {?>
						<option value="<?php echo $language['language']['id']; ?>"><?php echo ($language['language_language']['name']=='' ? 'no name':$language['language_language']['name']); ?></option>
					<?php } ?>
				</select>
			</div>
			<div style="float:left"><?php echo $form->input('city name'); ?></div>
			<div style="float:left"><?php echo $form->submit('登録'); ?></div>
			<?php echo $form->end();?>
		</div>

		<?php echo $this->renderElement('message'); ?>
	</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('City List', true), array('action' => '/index'));?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->


