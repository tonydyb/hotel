<div class="country view">
<h2><?php  __('Country');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Iso Code N'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['iso_code_n']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Iso Code A2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['iso_code_a2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Iso Code A3'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['iso_code_a3']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['updated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Deleted'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $country['Country']['deleted']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Country', true), array('action' => 'edit', $country['Country']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Country', true), array('action' => 'delete', $country['Country']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $country['Country']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Country', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Country', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List City', true), array('controller' => 'city', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New City', true), array('controller' => 'city', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Customer User', true), array('controller' => 'customer_user', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Customer User', true), array('controller' => 'customer_user', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Hotel', true), array('controller' => 'hotel', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Hotel', true), array('controller' => 'hotel', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Request', true), array('controller' => 'request', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Request', true), array('controller' => 'request', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List State', true), array('controller' => 'state', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New State', true), array('controller' => 'state', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related City');?></h3>
	<?php if (!empty($country['City'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('Code'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['City'] as $city):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $city['id'];?></td>
			<td><?php echo $city['country_id'];?></td>
			<td><?php echo $city['state_id'];?></td>
			<td><?php echo $city['code'];?></td>
			<td><?php echo $city['created'];?></td>
			<td><?php echo $city['updated'];?></td>
			<td><?php echo $city['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'city', 'action' => 'view', $city['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'city', 'action' => 'edit', $city['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'city', 'action' => 'delete', $city['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $city['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New City', true), array('controller' => 'city', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Customer User');?></h3>
	<?php if (!empty($country['CustomerUser'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Account'); ?></th>
		<th><?php __('Password'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Email Mobile'); ?></th>
		<th><?php __('Tel'); ?></th>
		<th><?php __('Tel Mobile'); ?></th>
		<th><?php __('Fax'); ?></th>
		<th><?php __('Postcode'); ?></th>
		<th><?php __('Addr Country Id'); ?></th>
		<th><?php __('Addr 1'); ?></th>
		<th><?php __('Addr 2'); ?></th>
		<th><?php __('Addr 3'); ?></th>
		<th><?php __('Gender Id'); ?></th>
		<th><?php __('Birthday'); ?></th>
		<th><?php __('Last Access'); ?></th>
		<th><?php __('Language Id'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['CustomerUser'] as $customerUser):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $customerUser['id'];?></td>
			<td><?php echo $customerUser['account'];?></td>
			<td><?php echo $customerUser['password'];?></td>
			<td><?php echo $customerUser['name'];?></td>
			<td><?php echo $customerUser['email'];?></td>
			<td><?php echo $customerUser['email_mobile'];?></td>
			<td><?php echo $customerUser['tel'];?></td>
			<td><?php echo $customerUser['tel_mobile'];?></td>
			<td><?php echo $customerUser['fax'];?></td>
			<td><?php echo $customerUser['postcode'];?></td>
			<td><?php echo $customerUser['addr_country_id'];?></td>
			<td><?php echo $customerUser['addr_1'];?></td>
			<td><?php echo $customerUser['addr_2'];?></td>
			<td><?php echo $customerUser['addr_3'];?></td>
			<td><?php echo $customerUser['gender_id'];?></td>
			<td><?php echo $customerUser['birthday'];?></td>
			<td><?php echo $customerUser['last_access'];?></td>
			<td><?php echo $customerUser['language_id'];?></td>
			<td><?php echo $customerUser['country_id'];?></td>
			<td><?php echo $customerUser['created'];?></td>
			<td><?php echo $customerUser['updated'];?></td>
			<td><?php echo $customerUser['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'customer_user', 'action' => 'view', $customerUser['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'customer_user', 'action' => 'edit', $customerUser['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'customer_user', 'action' => 'delete', $customerUser['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customerUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Customer User', true), array('controller' => 'customer_user', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Hotel');?></h3>
	<?php if (!empty($country['Hotel'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Code'); ?></th>
		<th><?php __('Hotel Grade Id'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('State Id'); ?></th>
		<th><?php __('City Id'); ?></th>
		<th><?php __('Town Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['Hotel'] as $hotel):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $hotel['id'];?></td>
			<td><?php echo $hotel['code'];?></td>
			<td><?php echo $hotel['hotel_grade_id'];?></td>
			<td><?php echo $hotel['country_id'];?></td>
			<td><?php echo $hotel['state_id'];?></td>
			<td><?php echo $hotel['city_id'];?></td>
			<td><?php echo $hotel['town_id'];?></td>
			<td><?php echo $hotel['created'];?></td>
			<td><?php echo $hotel['updated'];?></td>
			<td><?php echo $hotel['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'hotel', 'action' => 'view', $hotel['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'hotel', 'action' => 'edit', $hotel['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'hotel', 'action' => 'delete', $hotel['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $hotel['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Hotel', true), array('controller' => 'hotel', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Request');?></h3>
	<?php if (!empty($country['Request'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Customer User Id'); ?></th>
		<th><?php __('Admin User Id'); ?></th>
		<th><?php __('Request Stat Id'); ?></th>
		<th><?php __('Request Payment Id'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Language Id'); ?></th>
		<th><?php __('Currency Id'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Point'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Email Mobile'); ?></th>
		<th><?php __('Tel'); ?></th>
		<th><?php __('Tel Mobile'); ?></th>
		<th><?php __('Fax'); ?></th>
		<th><?php __('Zipcode'); ?></th>
		<th><?php __('Addr Country Id'); ?></th>
		<th><?php __('Addr 1'); ?></th>
		<th><?php __('Addr 2'); ?></th>
		<th><?php __('Addr 3'); ?></th>
		<th><?php __('Gender Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['Request'] as $request):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $request['id'];?></td>
			<td><?php echo $request['customer_user_id'];?></td>
			<td><?php echo $request['admin_user_id'];?></td>
			<td><?php echo $request['request_stat_id'];?></td>
			<td><?php echo $request['request_payment_id'];?></td>
			<td><?php echo $request['country_id'];?></td>
			<td><?php echo $request['language_id'];?></td>
			<td><?php echo $request['currency_id'];?></td>
			<td><?php echo $request['price'];?></td>
			<td><?php echo $request['point'];?></td>
			<td><?php echo $request['name'];?></td>
			<td><?php echo $request['email'];?></td>
			<td><?php echo $request['email_mobile'];?></td>
			<td><?php echo $request['tel'];?></td>
			<td><?php echo $request['tel_mobile'];?></td>
			<td><?php echo $request['fax'];?></td>
			<td><?php echo $request['zipcode'];?></td>
			<td><?php echo $request['addr_country_id'];?></td>
			<td><?php echo $request['addr_1'];?></td>
			<td><?php echo $request['addr_2'];?></td>
			<td><?php echo $request['addr_3'];?></td>
			<td><?php echo $request['gender_id'];?></td>
			<td><?php echo $request['created'];?></td>
			<td><?php echo $request['updated'];?></td>
			<td><?php echo $request['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'request', 'action' => 'view', $request['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'request', 'action' => 'edit', $request['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'request', 'action' => 'delete', $request['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $request['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Request', true), array('controller' => 'request', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related State');?></h3>
	<?php if (!empty($country['State'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Country Id'); ?></th>
		<th><?php __('Iso Code A'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($country['State'] as $state):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $state['id'];?></td>
			<td><?php echo $state['country_id'];?></td>
			<td><?php echo $state['iso_code_a'];?></td>
			<td><?php echo $state['created'];?></td>
			<td><?php echo $state['updated'];?></td>
			<td><?php echo $state['deleted'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'state', 'action' => 'view', $state['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'state', 'action' => 'edit', $state['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'state', 'action' => 'delete', $state['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $state['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New State', true), array('controller' => 'state', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
