<div id="top">
	<div id="header">
		<h1><a href="index.html"><?php echo __('メディア登録・編集'); ?></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<h2><?php echo __('メディア登録・編集'); ?></h2>
			<p>
				<?php echo $form->create('Media', array('type' => 'post', 'action' => '/save' ,'name' => 'form_meida_edit', 'url'=>array('controller'=>'media'))); ?>
					<table>
						<tr>
							<th><?php echo __('ID'); ?></th>
							<td>
								<?php
									echo $media['id'];
									echo $form->input('Media.id', array('type'=>'hidden', 'value'=>$media['id']));
									echo $form->error('Media.id');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メディアID'); ?></th>
							<td>
								<?php
									echo $form->text('Media.code', array('size' => '50', 'value'=>$media['code']));
									echo $form->error('Media.code');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('メディア名'); ?></th>
							<td>
								<?php
									echo $form->text('Media.name', array('size' => '50', 'value'=>$media['name']));
									echo $form->error('Media.name');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('サブメディアID'); ?></th>
							<td>
								<?php
									echo $form->text('Media.sub_code', array('size' => '50', 'value'=>$media['sub_code']));
									echo $form->error('Media.sub_code');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('サブメディア名'); ?></th>
							<td>
								<?php
									echo $form->text('Media.sub_name', array('size' => '50', 'value'=>$media['sub_name']));
									echo $form->error('Media.sub_name');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('受信パラメタ名'); ?></th>
							<td>
								<?php
									echo $form->text('Media.recv_param', array('size' => '50', 'value'=>$media['recv_param']));
									echo $form->error('Media.recv_param');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('送信パラメタ名'); ?></th>
							<td>
								<?php
									echo __('※送信パラメータが複数ある場合、「&」で区切って入力してください<br />');
									echo $form->text('Media.send_param', array('size' => '50', 'value'=>$media['send_param']));
									echo $form->error('Media.send_param');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('入会時成果先'); ?></th>
							<td>
								<?php
									echo $form->text('Media.send_url', array('size' => '50', 'value'=>$media['send_url']));
									echo $form->error('Media.send_url');
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('出稿単価'); ?></th>
							<td>
								<?php
									echo $form->text('Media.price', array('size' => '50', 'value'=>$media['price']));
									echo $form->error('Media.price');
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php $message1 = __('保存してよろしいですか。', true); ?>
								<?php echo $form->button(__('保存',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_meida_edit\', \''.BASE_URL.'/media/save\', \'' . $message1 . '\');')); ?>
							</td>
						</tr>
					</table>
				<?php echo $form->end(); ?>
			</p>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
