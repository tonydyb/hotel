<div id="top">
	<div id="header">
		<h1><a href="index.html"><?php echo __('メディア一覧'); ?></a></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">
			<h2><?php echo __('メディア一覧'); ?></h2>
			<p>
				<?php echo $form->create('Media', array('type' => 'post', 'action' => '/save' ,'name' => 'form_meida_edit', 'url'=>array('controller'=>'media'))); ?>
					<table>
						<tr>
							<th><?php echo __('ID'); ?></th>
							<th><?php echo __('メディアID'); ?></th>
							<th><?php echo __('メディア名'); ?></th>
							<th><?php echo __('サブメディアID'); ?></th>
							<th><?php echo __('サブメディア名'); ?></th>
							<th><?php echo __('受信パラメタ名'); ?></th>
							<th><?php echo __('送信パラメタ名'); ?></th>
							<th><?php echo __('入会時成果先'); ?></th>
							<th><?php echo __('タグ'); ?></th>
							<th>
								<?php echo $form->button(__('新規登録',true), array('div' => false, 'onclick' => 'location.href=\''.BASE_URL.'/media/edit/\'')); ?>
							</th>
						</tr>
						<?php foreach ($media_list as $media) { ?>
							<tr>
								<td>
									<?php
										echo $media['Media']['id'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['code'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['name'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['sub_code'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['sub_name'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['recv_param'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['send_param'];
									?>
								</td>
								<td>
									<?php
										echo $media['Media']['send_url'];
									?>
								</td>
								<td>
									<?php
										$tag = empty($media['Media']['send_param']) ? '' : '&'.$media['Media']['send_param'];
										$tag = MEDIA_TAG_URL.$media['Media']['code'].$tag;
										echo $form->text('Media.tag', array('size' => '50', 'value'=>$tag));
									?>
								</td>
								<td>
									<?php echo $form->button(__('編集',true), array('div' => false, 'onclick' => 'location.href=\''.BASE_URL.'/media/edit/'.$media['Media']['id'].'/\'')); ?>
									<?php $message1 = __('削除してよろしいですか。', true); ?>
									<?php echo $form->button(__('削除',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_meida_edit\', \''.BASE_URL.'/media/delete/'.$media['Media']['id'].'/\', \'' . $message1 . '\');')); ?>
								</td>
							</tr>
						<?php } ?>
					</table>
				<?php echo $form->end(); ?>
			</p>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->
