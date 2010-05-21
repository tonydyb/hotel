<?php
	echo $javascript->link('city/city_index');
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
	<?php echo $this->renderElement('index_title', array("title" => __('City'))); ?>

	<div id="search">
		<table>
			<tr>
				<th style="text-align:left"><label><?php __('Country');?></label></th>
				<td>
					<select id="CountryId" name="CountryId">
						<option value="" <?php if (isset($this->passedArgs['country_id'])) { echo ''==$this->passedArgs['country_id']?"selected='selected'":""; } ?>></option>
						<?php foreach ($countries as $country) { ?>
							<option value="<?php echo $country['Country']['id']; ?>" <?php if (isset($this->passedArgs['country_id'])) { echo $country['Country']['id']==$this->passedArgs['country_id']?"selected='selected'":""; } ?>><?php echo ($country['CountryLanguage']['name']=='' ? 'no name':$country['CountryLanguage']['name']); ?></option>
						<?php } ?>
					</select>
				</td>
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

		<table class="listTable">
		<tr>
			<th><?php echo $paginator->sort(__('Id'));?></th>
			<th><?php echo $paginator->sort(__('Country'));?></th>
			<th><?php echo $paginator->sort(__('Code'));?></th>
			<th><?php echo $paginator->sort(__('Name'));?></th>
			<th class="actions"><?php __('Edit');?></th>
			<th class="actions"><?php __('Edit Name');?></th>
		</tr>
		<?php
			foreach ($cities as $city) {
				echo $html->tableCells(
					array(
						array(
							$city['City']['id'],
							$city['CountryLanguage']['name_long'],
							$city['City']['code'],
							$city['CityLanguage']['name'],
							array($html->link(__('Edit', true), array('action' => 'edit', $city['City']['id'])), aa('class','actions')),
							array($html->link(__('Edit Name', true), array('action' => 'editName', $city['City']['id'])), aa('class','actions')),
						)
					)
				);
 			}
 		?>
		</table>
	</div>

	<?php echo $this->renderElement('index_paging'); ?>
</div>

	<div style="clear:both"></div>
	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New City', true), array('action' => 'add')); ?></li>
		</ul>
	</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



