<div id="top">
	<div id="header">
		<h1><?php __('提出書類編集'); ?></h1>
		<div><?php echo $this->renderElement('headermenu'); ?></div>
	</div><!-- header end -->
	<div id="contents">
		<?php echo $this->renderElement('menu'); ?>
		<div id="main">

			<h2><?php echo __('提出書類編集'); ?></h2>

			<?php echo $form->create('ContentDocument', array('type' => 'post', 'action' => '/add_type' ,'name' => 'form_add_document', 'url'=>array('controller'=>'content_document'))); ?>
				<?php
					$types = array();
				?>
				<p>
					<table>
						<tr>
							<th>
								<?php echo __('使用言語'); ?>
							</th>
							<td>
								<?php
									$opt = array();
									$default_language_id = null;
									$default_language_name = null;
									foreach ($language as $lang) {
										$opt[trim($lang['ViewLanguage']['iso_code'])] = $lang['ViewLanguage']['name'];
										if (is_null($default_language_id) && $default_iso_code == $lang['ViewLanguage']['iso_code']) {
											$default_language_id = $lang['ViewLanguage']['ll_id'];
											$default_language_name = $lang['ViewLanguage']['name'];
										}
									}
									echo $form->input('ContentDocument.iso_code', array('type' => 'select', 'options' => $opt, 'label'=>false, 'div' => false, 'selected' => $default_iso_code));
									echo $form->input('ContentDocument.default_iso_code', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $default_iso_code));
									echo $form->input('ContentDocument.default_language_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $default_language_id));
									echo $form->input('ContentDocument.edit_content_document_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_content_document_id));
								?>
							</td>
							<td>
								<?php
									echo $form->button(__('読込',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_add_document\', \''.BASE_URL.'/content_document/change_language/\');'));
								?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo __('種類'); ?>
							</th>
							<td>
								<?php
									echo $form->text('ContentDocument.type_name', array('size' => '30', 'value'=>''));
									echo $form->error('ContentDocument.type_name');
								?>
							</td>
							<td>
								<?php
									$message1 = __('追加してよろしいですか。', true);
									echo $form->button(__('追加',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_add_document\', \''.BASE_URL.'/content_document/add_type\', \'' . $message1 . '\');'));
								?>
							</td>
						</tr>
					</table>
				</p>

				<p>
					<?php if (!empty($ContentDocument[0]['content_document']['id'])) { ?>
						<table>
							<?php for ($cnt = 0; $cnt < count($ContentDocument); $cnt++) { ?>
								<tr>
									<?php if (empty($ContentDocument[$cnt]['content_document_language']['id']) && empty($ContentDocument[$cnt]['content_document_language']['branch_no'])) { ?>
										<?php
											echo '<th colspan="2">';
											echo '<a name="'.$ContentDocument[$cnt]['content_document']['type_name'].'"></a>';
											echo $ContentDocument[$cnt]['content_document']['type_name'];
											echo '</th>';
											echo '<td>';
											if (empty($ContentDocument[$cnt + 1]['content_document']['id'])) {
												$message0 = __('「種類」を削除すると、その種類のデータがすべて削除されます。\n削除してよろしいですか。', true);
												echo $form->button(__('削除',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_add_document\', \''.BASE_URL.'/content_document/delete_type/'.$ContentDocument[$cnt]['content_document']['type_name'].'/\', \'' . $message0 . '\');'));
											}
											echo '</td>';
											$types[] = $ContentDocument[$cnt]['content_document']['type_name'];
										?>
										</tr>
										<tr>
											<th><?php echo __('概要'); ?></th>
											<th><?php echo __('ファイル名'); ?></th>
											<th>
											</th>
										</tr>
										<tr>
									<?php } else { ?>
										<td>
											<?php
												if (empty($ContentDocument[$cnt]['content_document_language']['id'])) {
													echo $form->text('ContentDocumentLanguage.'.$cnt.'.title', array('size' => '30', 'value'=>$ContentDocument[$cnt]['content_document_language']['title']));
													echo $form->error('ContentDocumentLanguage.'.$cnt.'.title');
												} else {
													echo $ContentDocument[$cnt]['content_document_language']['title'];
													echo $form->input('ContentDocumentLanguage.'.$cnt.'.title', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document_language']['title']));
												}
												if (!empty($edit_content_document_id) && $edit_content_document_id == $ContentDocument[$cnt]['content_document']['id']) {
													$edit_data['content_document'] = $ContentDocument[$cnt]['content_document'];
													$edit_data['content_document_language'] = $ContentDocument[$cnt]['content_document_language'];
												}
												echo $form->input('ContentDocumentLanguage.'.$cnt.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document_language']['id']));
												echo $form->input('ContentDocumentLanguage.'.$cnt.'.content_document_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document_language']['content_document_id']));
												echo $form->input('ContentDocumentLanguage.'.$cnt.'.language_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document_language']['language_id']));
												?>
										</td>
										<td>
											<?php
												if (empty($ContentDocument[$cnt]['content_document']['id'])) {
													echo $form->text('ContentDocument.'.$cnt.'.file_name', array('size' => '30', 'value'=>$ContentDocument[$cnt]['content_document']['file_name']));
													echo $form->error('ContentDocument.'.$cnt.'.file_name');
												} else {
													echo $ContentDocument[$cnt]['content_document']['file_name'];
													echo $form->input('ContentDocument.'.$cnt.'.file_name', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document']['file_name']));
												}
												echo $form->input('ContentDocument.'.$cnt.'.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document']['id']));
												echo $form->input('ContentDocumentLanguage.'.$cnt.'.branch_no', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document_language']['branch_no']));
												echo $form->input('ContentDocument.'.$cnt.'.type_name', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $ContentDocument[$cnt]['content_document']['type_name']));
											?>
										</td>
										<td>
											<?php
												if (empty($ContentDocument[$cnt]['content_document']['id'])) {
													$message1 = __('追加してよろしいですか。', true);
													echo $form->button(__('追加',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_add_document\', \''.BASE_URL.'/content_document/add_doc/'.$cnt.'/\', \'' . $message1 . '\');'));
												} else {
													echo $form->button(__('編集',true), array('div' => false, 'onclick' => 'regist_no_message(\'form_add_document\', \''.BASE_URL.'/content_document/edit/'.$ContentDocument[$cnt]['content_document']['id'].'/\');'));
													$message2 = __('他の言語で作成されたデータも削除されます。\n削除してよろしいですか。', true);
													echo $form->button(__('削除',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_add_document\', \''.BASE_URL.'/content_document/delete/'.$ContentDocument[$cnt]['content_document']['id'].'/\', \'' . $message2 . '\');'));
												}
											?>
										</td>
									<?php } ?>
								</tr>
							<?php } ?>
						</table>
					<?php } ?>
					<?php if (!empty($types)) { ?>
						<div class="rgiht-menu">
							<?php
								foreach ($types as $type) {
									echo '<a href="#'.$type.'">'.$type.'</a><br />';
								}
								if (!empty($edit_data)) {
									echo '<a href="#edit">編集データ</a><br />';
								}
							?>
						</div>
					<?php } ?>
					<br />
					<?php if (!empty($edit_data)) { ?>
						<table>
							<tr>
								<th><a name="edit"></a><?php echo __('種類') ?></th>
								<td>
									<?php
										echo $edit_data['content_document']['type_name'];
										echo $form->input('EditData.ContentDocument.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document']['id']));
										echo $form->input('EditData.ContentDocumentLanguage.branch_no', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document_language']['branch_no']));
										echo $form->input('EditData.ContentDocument.type_name', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document']['type_name']));
										echo $form->input('EditData.ContentDocument.file_name', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document']['file_name']));
										echo $form->input('EditData.ContentDocumentLanguage.id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document_language']['id']));
										echo $form->input('EditData.ContentDocumentLanguage.content_document_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document_language']['content_document_id']));
										echo $form->input('EditData.ContentDocumentLanguage.language_id', array('type' => 'hidden', 'label'=>false, 'div' => false, 'value' => $edit_data['content_document_language']['language_id']));
									?>
								</td>
							</tr>
							<tr>
								<th><?php echo __('概要') ?></th>
								<td><?php echo $form->text('EditData.ContentDocumentLanguage.title', array('size' => '100', 'value'=>$edit_data['content_document_language']['title'])); ?></td>
							</tr>
							<tr>
								<th><?php echo __('ファイル名') ?></th>
								<td><?php echo $edit_data['content_document']['file_name'] ?></td>
							</tr>
							<?php foreach ($history as $his) { ?>
								<?php if (!empty($his['content_document_language']['branch_no'])) { ?>
									<tr>
										<th><?php echo __('履歴', true).($his['content_document_language']['branch_no']-1); ?></th>
										<td>
											<?php echo $html->dmf($his['content_document_language']['updated']).' ';?>
											<?php echo $form->button(__('確認',true), array('div' => false, 'onclick' => 'new_window_submit2(\'form_add_document\', \''.BASE_URL.'/content_document/history/'.$his['content_document_language']['id'].'/\');')); ?>
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
							<tr>
								<td colspan="2">
									<?php
										echo $form->textarea('EditData.ContentDocumentLanguage.content', array('cols' => '100', 'rows' => '30', 'wrap' => 'off', 'label' => false, 'value'=>$edit_data['content_document_language']['content']));
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<?php
										$message1 = __('保存してよろしいですか。', true);
										echo $form->button(__('保存',true), array('div' => false, 'onclick' => 'regist_by_name(\'form_add_document\', \''.BASE_URL.'/content_document/save/\', \'' . $message1 . '\');'));
										echo $form->button(__('プレビュー',true), array('div' => false, 'onclick' => 'new_window_submit2(\'form_add_document\', \''.BASE_URL.'/content_document/preview/\');'));
									 ?>
								</td>
							</tr>
						</table>
					<?php } ?>
				</p>
			<?php echo $form->end(); ?>

		</div><!-- main end -->
	</div><!-- contents end -->
	<?php echo $this->renderElement('footer'); ?>
</div><!-- top end -->