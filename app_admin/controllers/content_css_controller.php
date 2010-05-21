<?php
class ContentCssController extends AppController {

	var $name = 'ContentCss';
	var $uses = array('ContentCss', 'Page');
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * コンテント　CSS一覧
	 */
	function index() {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		//$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (isset($this->passedArgs['language_id'])) {
			$language_id = $this->passedArgs['language_id'];
		} else {
			$language_id = -1;
		}

		if (isset($this->passedArgs['carrier_type_id'])) {
			$carrier_type_id = $this->passedArgs['carrier_type_id'];
		} else {
			$carrier_type_id = -1;
		}

		if (isset($this->passedArgs['alias'])) {
			$alias = $this->passedArgs['alias'];
		} else {
			$alias = null;
		}

		$cond = $this->Page->getSqlListContentCss($this->getIsoId(), $language_id, $carrier_type_id, $alias);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'language_id, carrier_type_id, alias, updated DESC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('csses', $this->paginate('Page'));
	}

	/**
	 * CSSファイルアプロード
	 */
	function upload() {
		if ($_REQUEST["LanguageId"] == 0) {
			$iso_code = 'common';
		} else {
			$iso_code = $this->getIsoCode($_REQUEST["LanguageId"]);
		}
		//$carrier_name = $this->getCarrierCode($_REQUEST["CarrierTypeId"]);
		if ($_REQUEST["CarrierTypeId"] == 1) {
			$uploaddir = CONTENT_CSS_ROOT_PATH . $iso_code . "/pc/";
		} else {
			$uploaddir = CONTENT_CSS_ROOT_PATH . $iso_code . "/mobile/";
		}

		if(!file_exists($uploaddir)) {
			$this->ModelUtil->mkdirRec($uploaddir);
		}

		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			$this->__add();
		} else {
			echo "error##";
		}
	}

	/**
	 * CSSファイルデータベースに登録
	 */
	function __add() {
		//if (!empty($this->data)) {
			$this->ContentCss->create();

			$this->ContentCss->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"],
						'alias' => basename($_FILES['userfile']['name'])
				)
			);
			$cnt = $this->ContentCss->find('count', array( 'conditions' => array('alias' => basename($_FILES['userfile']['name']), 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"], 'deleted' => NULL)));
			if (!$cnt) {
				if ($this->ContentCss->save($this->data)) {
					$this->Session->setFlash(__('The Css file has been saved', true));
				} else {
					$this->Session->setFlash(__('The Css file could not be saved. Please, try again.', true));
				}
			} else {
				if ($this->ContentCss->updateAll(array('updated' => 'now()'), array('alias' => basename($_FILES['userfile']['name']), 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"], 'deleted' => NULL))) {
					$this->Session->setFlash(__('The Css file has been updated', true));
				} else {
					$this->Session->setFlash(__('The Css file could not be updated. Please, try again.', true));
				}
			}
		//}
	}

	/**
	 * CSS ファイル削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Css file', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentCss->advDel($id)) {
			$this->Session->setFlash(__('Css file deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Css file could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>