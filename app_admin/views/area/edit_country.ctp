
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
			<?php echo $names[0]['Area']['code']; ?>
		</div>

		<div id="list">
			<table cellpadding="0" cellspacing="0" id="names">
				<tr>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Delete'); ?></th>
				</tr>
				<?php foreach ($names as $name) {
						if ($name['AreaLinkCountry']['id'] != NULL) {
				?>
				<tr>
					<td>
						<?php echo (trim($name['Country']['name'])=="" ? "no name" : $name['Country']['name']); ?>
					</td>
					<td>
						<?php echo $html->link(__('Delete', true), array('action' => 'deleteCountry', $name['AreaLinkCountry']['id']), array('class' => 'deleteLink'), 'Are you sure?');?>
					</td>
				</tr>
				<?php }
					}
				 ?>
			</table>
		</div>

		<div id="form">
			<?php echo $form->create('Area', array('action' => 'addCountry'));?>
				<?php echo $form->hidden("AreaId", array("value" => $names[0]['Area']['id'])); ?>
				<div style="padding-top:10px;padding-bottom:10px">
					<select id="CountryId" name="CountryId">
						<?php foreach ($countries as $country) { ?>
							<option value="<?php echo $country['Country']['id']; ?>"><?php echo (trim($country['CountryLanguage']['name'])=="" ? "no name" : $country['CountryLanguage']['name']); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="clear"></div>
				<div style="float:left"><?php echo $form->submit('追加'); ?></div>
			<?php echo $form->end();?>
		</div>

		<?php echo $this->renderElement('message'); ?>
	</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('List Area', true), array('action' => '/index'));?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->


