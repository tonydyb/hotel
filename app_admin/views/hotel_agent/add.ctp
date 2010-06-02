<?php
	echo $javascript->link('hotel_agent/hotel_agent_add');
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
<?php echo $form->createSingle('HotelAgent');?>
	<fieldset class="fieldset">
 		<legend><?php __('Add Hotel Agent');?></legend>
		<div>
		<table>
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
			<th style="text-align:left"><label><?php __('Code');?></label></th>
			<td>
			<?php
				echo $form->input('code', array(
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
			<th style="text-align:left"><label><?php __('Account');?></label></th>
			<td>
			<?php
				echo $form->input('account', array(
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
			<th style="text-align:left"><label><?php __('Password');?></label></th>
			<td>
			<?php
				echo $form->input('password', array(
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
			<th style="text-align:left"><label><?php __('Email');?></label></th>
			<td>
			<?php
				echo $form->input('email', array(
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
			<th style="text-align:left"><label><?php __('Tel');?></label></th>
			<td>
			<?php
				echo $form->input('tel', array(
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
			<th style="text-align:left"><label><?php __('Fax');?></label></th>
			<td>
			<?php
				echo $form->input('fax', array(
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
			<th style="text-align:left"><label><?php __('Commission');?></label></th>
			<td>
			<?php
				echo $form->input('commission', array(
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
			<th style="text-align:left"><label><?php __('Amount');?></label></th>
			<td>
			<?php
				echo $form->input('amount', array(
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
			<th style="text-align:left"><label><?php __('Percent');?></label></th>
			<td>
			<?php
				echo $form->input('percent', array(
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
			<th style="text-align:left"><label><?php __('Amount Max');?></label></th>
			<td>
			<?php
				echo $form->input('amount_max', array(
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
			<th style="text-align:left"><label><?php __('Percent Max');?></label></th>
			<td>
			<?php
				echo $form->input('percent_max', array(
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
			<th style="text-align:left"><label><?php __('Url');?></label></th>
			<td>
			<?php
				echo $form->input('url', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
				),
				'style' => 'width:98%'
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Country');?></label></th>
			<td>
				<select id="HotelAgentCountryId" name="data[HotelAgent][country_id]">
				<?php foreach ($countries as $country) { ?>
					<option value="<?php echo $country['Country']['id']; ?>" <?php echo $country['Country']['id']==$this->data['HotelAgent']['country_id']?"selected='selected'":"" ?>><?php echo (trim($country['CountryLanguage']['name'])=="" ? "no name" : $country['CountryLanguage']['name']); ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Post Code');?></label></th>
			<td>
			<?php
				echo $form->input('postcode', array(
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
			<th style="text-align:left"><label><?php __('Address1');?></label></th>
			<td>
			<?php
				echo $form->input('addr_1', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
				),
				'style' => 'width:98%'
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Address2');?></label></th>
			<td>
			<?php
				echo $form->input('addr_2', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
				),
				'style' => 'width:98%'
				));
			?>
			</td>
		</tr>
		<tr>
			<th style="text-align:left"><label><?php __('Address3');?></label></th>
			<td>
			<?php
				echo $form->input('addr_3', array(
				'label' => false,
				'div' => false,
				'error' => array(
					'wrap' => 'div',
					'class' => 'formerror'
				),
				'style' => 'width:98%'
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
		<li><?php echo $html->link(__('Hotel Agent List', true), array('action' => 'index/'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->