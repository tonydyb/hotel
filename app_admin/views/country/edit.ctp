
<div id="top">
	<div id="header">
		<h1><a href="index.html"></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

<div id="main_contents" >
<?php echo $form->create('Country');?>
	<fieldset class="fieldset">
 		<legend><?php __('Edit Country');?></legend>
		<div>
			<table>
				<tr>
					<th style="text-align:left"><label><?php __('iso_code_n');?></label></th>
					<td>
					<?php
						echo $form->input('id', array(
							'label' => false,
							'div'=>'formfield',
							'error' => array(
								'wrap' => 'div',
								'class' => 'formerror'
							)
						));

						echo $form->input('iso_code_n', array(
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
					<th style="text-align:left"><label><?php __('iso_code_a2');?></label></th>
					<td>
					<?php
						echo $form->input('iso_code_a2', array(
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
					<th style="text-align:left"><label><?php __('iso_code_a3');?></label></th>
					<td>
					<?php
						echo $form->input('iso_code_a3', array(
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
			</table>
		</div>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Country', true), array('action' => '/index'));?></li>
	</ul>
</div>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->



