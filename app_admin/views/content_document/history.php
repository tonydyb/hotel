<div id="top">
	<div id="header">
		<h1><?php __('提出書類編集'); ?></h1>
	</div><!-- header end -->
	<div id="contents">
		<div id="main">
			<?php if (!empty($view_data)) { ?>
				<table>
					<tr>
						<th><a name="edit"></a><?php echo __('種類') ?></th>
						<td>
							<?php
								echo $view_data['content_document']['type_name'];
							?>
						</td>
					</tr>
					<tr>
						<th><?php echo __('概要') ?></th>
						<td><?php echo $view_data['content_document_language']['title']; ?></td>
					</tr>
					<tr>
						<th><?php echo __('ファイル名') ?></th>
						<td><?php echo $view_data['content_document']['file_name'] ?></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php
								echo $form->textarea('EditData.ContentDocumentLanguage.content', array('cols' => '100', 'rows' => '30', 'wrap' => 'off', 'label' => false, 'value'=>$view_data['content_document_language']['content']));
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="button" value="<?php echo __('閉じる') ?>" onClick="new_window_close()"; />
						</td>
					</tr>
				</table>
			<?php } ?>
		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->