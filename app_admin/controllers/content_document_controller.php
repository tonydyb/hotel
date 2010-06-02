<?php
class ContentDocumentController extends AppController {
	var $name = "ContentDocument";
	var $helpers = array('Construct', 'Javascript');
	var $uses = array('ContentDocument', 'ContentDocumentLanguage', 'LanguageLanguage', );
	var $needAuth = true;	// ログイン必須のフラグ
	var $components = array('ModelUtil', 'ListGetter', 'MakeTemplateMessage', );

	function preview() {
		$url = $this->data['EditData']['ContentDocument']['type_name'].DS.CONTENT_DOCUMENT_PATH_SUFFIX.DS.$this->data['EditData']['ContentDocument']['type_name'];

//		$this->MakeTemplateMessage->template = $template;
//		$this->MakeTemplateMessage->layout_dir = $layout_dir;
//		$messages = $this->MakeTemplateMessage->make_message();
//		$message = '';
//		foreach ($messages as $msg) {
//			$message .= $msg."\n";
//		}
//
//		$view_data = array();
//		$view_data['ContentDocument'] = $this->data['EditData']['ContentDocument'];
//		$view_data['ContentDocumentLanguage'] = $this->data['EditData']['ContentDocumentLanguage'];
//		$view_data['ContentDocumentLanguage']['content'] = $message;
//
//		$this->set('view_data', $view_data);
//		$this->render('/content_document/history/');

		Configure::write('debug', 0);
		$this->layout = "no_layout";
		$this->render('../'.CONTENT_DOCUMENT_ROOT_PATH_ON_MKDIR.$url);
	}

	function file_upload($type_name, $file_name, $content) {
		$dir = $type_name;
		$path = WWW_ROOT.CONTENT_DOCUMENT_ROOT_PATH_ON_MKDIR.$dir.SLASH.CONTENT_DOCUMENT_PATH_SUFFIX;

		if(!file_exists($path)) {
			$this->ModelUtil->mkdirRec($path);
		}

		$path .= $file_name.CONTENT_DOCUMENT_EXTENSION;

		touch(str_replace('/', DS, $path));
		$file = fopen(str_replace('/', DS, $path), "w");
		fputs($file, $content);
		fclose($file);
	}

	function index($default_iso_code = null, $edit_content_document_id = null, $edit_history_id = null) {
		$view_iso = is_null($default_iso_code) ? $this->Session->read(VIEW_ISO_CODE) : $default_iso_code;

		$view_data = array();
		$this->get_view_data($default_iso_code, $view_data, $edit_content_document_id, $edit_history_id);

		$this->set_view_list_data($view_data);
	}

	function get_view_data($default_iso_code = null, &$view_data, $edit_content_document_id = null, $edit_history_id = null) {
		$view_iso = is_null($default_iso_code) ? $this->Session->read(VIEW_ISO_CODE) : $default_iso_code;

		$view_data['language'] = $this->ListGetter->getLanguageList($view_iso);
		$view_data['default_iso_code'] = $view_iso;
		$view_data['edit_content_document_id'] = $edit_content_document_id;
		$view_data['ContentDocument'] = $this->ListGetter->getContentDocumentList($view_iso, '0, 1');

		if (!is_null($edit_content_document_id)) {
			$view_data['history'] = $this->ListGetter->getContentDocumentList($view_iso, '2, 3', $edit_content_document_id);
			for ($i = 0; $i < count($view_data['ContentDocument']); $i++) {
				if ($view_data['ContentDocument'][$i]['content_document']['id'] == $edit_content_document_id) {
					$view_data['edit_data'] = $view_data['ContentDocument'][$i];
					break;
				}
			}
		}
		$view_data['ContentDocument'] = $this->make_view_list($view_data['ContentDocument']);
	}

	function make_view_list($data) {
		$doc = array();
		$doc_skel = array();
		$doc_skel['content_document'] = $this->get_content_document_skeleton();
		$doc_skel['content_document_language'] = $this->get_content_document_language_skeleton();
		$type_name = '';
		for ($i = 0; $i < count($data); $i++) {
			if ($type_name == '') {
				$type_name = $data[$i]['content_document']['type_name'];
			}
			if ($type_name != $data[$i]['content_document']['type_name']) {
				$doc[] = $this->get_add_data_skeleton($type_name);
				$type_name = $data[$i]['content_document']['type_name'];
				$doc[] = $data[$i];
			} else {
				$doc[] = $data[$i];
			}
		}
		$doc[] = $this->get_add_data_skeleton($type_name);
		return $doc;
	}

	function get_add_data_skeleton($type_name) {
		$doc_skel = array();
		$doc_skel['content_document'] = $this->get_content_document_skeleton();
		$doc_skel['content_document_language'] = $this->get_content_document_language_skeleton();
		$doc_skel['content_document']['type_name'] = $type_name;
		$doc_skel['content_document']['file_name'] = '';
		$doc_skel['content_document_language']['branch_no'] = CONTENT_DOCUMENT_MAIN_BRANCH;
		$doc_skel['content_document_language']['language_id'] = '';
		$doc_skel['content_document_language']['title'] = '';
		$doc_skel['content_document_language']['content'] = '';
		return $doc_skel;
	}

	function set_view_list_data($view_list) {
		$keys = array_keys($view_list);
		foreach ($keys as $key) {
			$this->set($key, $view_list[$key]);
		}
	}

	function history($content_document_language_id) {
		if (!empty($this->data)) {
			$iso_code = $this->data['ContentDocument']['iso_code'];
			$edit_content_document_id = $this->data['ContentDocument']['edit_content_document_id'];
			$history = $this->ListGetter->getContentDocumentList($iso_code, '2, 3', $edit_content_document_id);
			$view_data = null;

			for ($i = 0; $i < count($history); $i++) {
				if ($history[$i]['content_document_language']['id'] == $content_document_language_id) {
					$view_data = $history[$i];
				}
			}
			$this->set('view_data', $view_data);
		}
	}

	function save() {
		if (!empty($this->data)) {

			$iso_code = $this->data['ContentDocument']['iso_code'];
			$language_id = $this->data['ContentDocument']['default_language_id'];

			$add_doc = $this->data['EditData']['ContentDocument'];
			$add_doc_lang = $this->data['EditData']['ContentDocumentLanguage'];

			// 過去データを取っておく
			$history = $this->ListGetter->getContentDocumentList($iso_code, '1, 2, 3', $add_doc['id']);

			// データ更新
			$add_doc['branch_no'] = CONTENT_DOCUMENT_MAIN_BRANCH;
			$add_doc['deleted'] = null;
			$this->ContentDocument->create();
			$this->ContentDocument->set($add_doc);
			$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocument->getColumnTypes()));
			if ($this->ContentDocument->save($add_doc, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$add_doc_lang['id'] = null;
				$add_doc_lang['content_document_id'] = empty($add_doc['id']) ? $this->ContentDocument->getLastInsertID() : $add_doc['id'];
				$add_doc_lang['deleted'] = null;
				$this->ContentDocumentLanguage->create();
				$this->ContentDocumentLanguage->set($add_doc_lang);
				$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocumentLanguage->getColumnTypes()));
				if ($this->ContentDocumentLanguage->save($add_doc_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$this->file_upload($add_doc['type_name'], $add_doc['file_name'], $add_doc_lang['content']);

					// 過去データの削除と枝番の更新
					foreach ($history as $his) {
						$data = $his['content_document'];
						$data_lang = $his['content_document_language'];

						if ($data_lang['branch_no'] == CONTENT_DOCUMENT_LAST_BRANCH) {
							$data['deleted'] = date('Y-m-d H:i:s');
							$data_lang['deleted'] = date('Y-m-d H:i:s');
							$data_lang['branch_no'] = CONTENT_DOCUMENT_LAST_BRANCH + 1;
							$this->ContentDocument->create();
							$this->ContentDocument->set($data);
							$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocument->getColumnTypes()));
							$this->ContentDocument->save($data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true));
							$this->ContentDocumentLanguage->create();
							$this->ContentDocumentLanguage->set($data_lang);
							$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocumentLanguage->getColumnTypes()));
							$this->ContentDocumentLanguage->save($data_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true));
						} else {
							$data['deleted'] = null;
							$data_lang['deleted'] = null;
							$data_lang['branch_no'] = $data_lang['branch_no']+1;
							$this->ContentDocument->create();
							$this->ContentDocument->set($data);
							$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocument->getColumnTypes()));
							$this->ContentDocument->save($data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true));
							$this->ContentDocumentLanguage->create();
							$this->ContentDocumentLanguage->set($data_lang);
							$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocumentLanguage->getColumnTypes()));
							$this->ContentDocumentLanguage->save($data_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true));
						}
						$this->redirect('/content_document/index/');
					}
				} else {
					$this->index($iso_code);
					$this->render('/content_document/index/');
				}
			} else {
				$this->index($iso_code);
				$this->render('/content_document/index/');
			}
		}
	}

	function change_language() {
		if (!empty($this->data)) {
			$iso_code = $this->data['ContentDocument']['iso_code'];
			$this->redirect('/content_document/index/'.$iso_code.'/');
		}
	}

	function edit($edit_content_document_id) {
		if (!empty($this->data)) {
			$iso_code = $this->data['ContentDocument']['iso_code'];
			$this->redirect('/content_document/index/'.$iso_code.'/'.$edit_content_document_id.'/');
		}
	}

	function add_type() {
		if (!empty($this->data)) {
			$iso_code = $this->data['ContentDocument']['iso_code'];
			$type = $this->get_content_document_skeleton();
			$type['branch_no'] = 0;
			$type['type_name'] = $this->data['ContentDocument']['type_name'];
			$type['file_name'] = '';
			$type['deleted'] = null;

			$this->ContentDocument->validate = $this->ContentDocument->validate_add_type;
			$this->ContentDocument->create();
			$this->ContentDocument->set($type);
			if ($this->ContentDocument->validates($type)) {
				$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocument->getColumnTypes()));
				if ($this->ContentDocument->save($type, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$add_doc_lang =  $this->get_content_document_language_skeleton();
					$add_doc_lang['content_document_id'] = $this->ContentDocument->getLastInsertID();
					$add_doc_lang['branch_no'] = CONTENT_DOCUMENT_TYPE_NAME_BRANCH;
					$add_doc_lang['language_id'] = 0;;
					$add_doc_lang['title'] = '';
					$add_doc_lang['content'] = '';
					$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocumentLanguage->getColumnTypes()));
					if ($this->ContentDocumentLanguage->save($add_doc_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
						$this->redirect('/content_document/index/'.$iso_code.'/');
					} else {
						$this->index($iso_code);
						$this->render('/content_document/index/');
					}
				} else {
					$this->index($iso_code);
					$this->render('/content_document/index/');
				}
			} else {
				$this->index($iso_code);
				$this->render('/content_document/index/');
			}
		}
	}

	function add_doc($cnt) {
		if (!empty($this->data)) {
			$iso_code = $this->data['ContentDocument']['iso_code'];
			$language_id = $this->data['ContentDocument']['default_language_id'];

			$add_doc = $this->data['ContentDocument'][$cnt];
			$add_doc_lang = $this->data['ContentDocumentLanguage'][$cnt];
			$add_doc_lang['language_id'] = $language_id;
			$add_doc_lang['content'] = '';

			$this->ContentDocument->validate = $this->ContentDocument->validate_save;
			$this->ContentDocument->create();
			$this->ContentDocument->set($add_doc);
			$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocument->getColumnTypes()));
			if ($this->ContentDocument->save($add_doc, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$add_doc_lang['content_document_id'] = $this->ContentDocument->getLastInsertID();
				$add_doc_lang['branch_no'] = CONTENT_DOCUMENT_MAIN_BRANCH;
				$this->ContentDocumentLanguage->create();
				$this->ContentDocumentLanguage->set($add_doc_lang);
				$whitelist = $this->remove_not_save_column(array_keys($this->ContentDocumentLanguage->getColumnTypes()));
				if ($this->ContentDocumentLanguage->save($add_doc_lang, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
					$this->redirect('/content_document/index/'.$iso_code.'/');
				} else {
					$error = array();
					$error['ContentDocumentLanguage'][$cnt] = $this->ContentDocumentLanguage->validationErrors;
					$this->ContentDocumentLanguage->validationErrors = $error;
					$this->index($iso_code);
					$this->render('/content_document/index/');
				}
			} else {
				$error = array();
				$error['ContentDocument'][$cnt] = $this->ContentDocument->validationErrors;
				$this->ContentDocument->validationErrors = $error;
				$this->index($iso_code);
				$this->render('/content_document/index/');
			}
		}
	}

	function delete($content_document_id) {
		$this->ContentDocument->query(CONTENT_DOCUMENT_DELETE_SQL, array($content_document_id, ));
		$this->ContentDocumentLanguage->query(CONTENT_DOCUMENT_LANGUAGE_DELETE_SQL, array($content_document_id, ));

		$iso_code = $this->data['ContentDocument']['iso_code'];
		$this->redirect('/content_document/index/'.$iso_code.'/');
	}

	function delete_type($type_name) {
		if (!empty($this->data)) {
			$check_data = $this->ContentDocument->find('all', array('conditions' => array('ContentDocument.type_name' => $type_name, 'ContentDocument.deleted is null')));
			$ids = '';
			foreach ($check_data as $data) {
				if (!empty($ids)) {
					$ids .= ',';
				}
				$ids .= $data['ContentDocument']['id'];
			}
			$sql = sprintf(CONTENT_DOCUMENT_TYPE_DELETE_SQL, $ids);
			$this->ContentDocument->query($sql, array());
			$sql = sprintf(CONTENT_DOCUMENT_TYPE_LANGUAGE_DELETE_SQL, $ids);
			$this->ContentDocumentLanguage->query($sql, array());

			$iso_code = $this->data['ContentDocument']['iso_code'];
			$this->redirect('/content_document/index/'.$iso_code.'/');
		}
	}

	function remove_not_save_column(&$witelist) {
		unset($witelist['updated']);
		unset($witelist['created']);
	}

	function get_content_document_skeleton() {
		return $this->ModelUtil->getSkeleton($this->ContentDocument);
	}

	function get_content_document_language_skeleton() {
		return $this->ModelUtil->getSkeleton($this->ContentDocumentLanguage);
	}
}

?>