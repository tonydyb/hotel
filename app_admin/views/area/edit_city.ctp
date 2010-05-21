
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
						if ($name['AreaLinkCity']['id'] != NULL) {
				?>
				<tr>
					<td>
						<?php echo (trim($name['City']['name'])=="" ? "no name" : $name['City']['name']); ?>
					</td>
					<td>
						<?php echo $html->link(__('Delete', true), array('action' => 'deleteCity', $name['AreaLinkCity']['id']), array('class' => 'deleteLink'), 'Are you sure?');?>
					</td>
				</tr>
				<?php }
					}
				 ?>
			</table>
		</div>

		<div id="form">
			<?php echo $form->create('Area', array('action' => 'addCity'));?>
				<?php echo $form->hidden("AreaId", array("value" => $names[0]['Area']['id'])); ?>
<div id="countryCity" style="padding-top:10px;padding-bottom:10px">
<?php
echo $form->select('Country.id', array('options'=>$countries), null, array('id' => 'countries'), false);
echo "<img id='loading' src='../../webroot/img/loading.gif' style='display: none' />";

echo "<div id='citiesDiv' style='padding-top:5px;padding-bottom:5px;width:30px;'>" . $form->select('City.id',array('options'=>array(''=>'---select a city---')), null, array('id' =>'cities'), false) . "</div>";
?>
</div>

			<div style="float:left"><?php echo $form->submit('Add'); ?></div>
			<?php echo $form->end();?>
<?php
$options = array('url' => 'update_select', 'update'=>'citiesDiv', 'indicator'=>'loading');
echo $ajax->observeField('countries',$options);
?>
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


