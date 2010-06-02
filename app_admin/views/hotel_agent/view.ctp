<?php
	//echo $javascript->link('hotel_agent/hotel_agent_view');
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
	<fieldset class="fieldset">
 		<legend><?php __('Hotel Agent Detail');?></legend>
		<div>
		<table>
		<tr>
			<th style="text-align:left"><label><?php __('Name');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['name']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Code');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['code']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Account');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['account']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Password');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['password']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Email');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['email']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Tel');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['tel']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Fax');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['fax']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Commission');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['commission']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Amount');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['amount']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Percent');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['percent']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Amount Max');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['amount_max']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Percent Max');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['percent_max']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Url');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['url']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Country');?></label></th>
			<td>
				<?php echo $countryName; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Post Code');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['postcode']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Address1');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['addr_1']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Address2');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['addr_2']; ?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Address3');?></label></th>
			<td>
			<?php echo $hotelAgent['HotelAgent']['addr_3']; ?>
			</td>
		</tr>
		</table>
		</div>
	</fieldset>
	<div style="float:left;padding-right:5px;"><?php echo $html->link(__('Edit', true), array('action' => 'edit', $hotelAgent['HotelAgent']['id'])); ?></div>

	<?php echo $this->renderElement('message'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Hotel Agent List', true), array('action' => 'index/'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->