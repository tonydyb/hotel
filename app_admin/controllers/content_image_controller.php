<?php
class ContentImageController extends AppController {

	var $name = 'ContentImage';
	var $uses = array('ContentImage', 'Page');
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * 画像一覧
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

		$cond = $this->Page->getSqlListContentImage($this->getIsoId(), $language_id, $carrier_type_id, $alias);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'language_id, carrier_type_id, alias, type, updated DESC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('images', $this->paginate('Page'));
	}

	/**
	 * 画像アプロード
	 */
	function upload() {
		if ($_REQUEST["LanguageId"] == 0) {
			$iso_code = 'common';
		} else {
			$iso_code = $this->getIsoCode($_REQUEST["LanguageId"]);
		}
		//$carrier_name = $this->getCarrierCode($_REQUEST["CarrierTypeId"]);
		if ($_REQUEST["CarrierTypeId"] == 1) {
			$uploaddir = CONTENT_IMAGE_ROOT_PATH . $iso_code . "/pc/";
		} else {
			$uploaddir = CONTENT_IMAGE_ROOT_PATH . $iso_code . "/mobile/";
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
	 * 画像データ登録
	 */
	function __add() {
		//if (!empty($this->data)) {
			$this->ContentImage->create();
			$name = split("\.", basename($_FILES['userfile']['name']));
			$pre = $name[count($name)-1];
			$pre = strtolower($pre);
			if($pre == "jpeg") {
				$pre = "jpg";
			}

			$this->ContentImage->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"],
						'alias' => basename($_FILES['userfile']['name']),
						'type' => $pre
				)
			);
			$cnt = $this->ContentImage->find('count', array( 'conditions' => array('alias' => basename($_FILES['userfile']['name']), 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"], 'deleted' => NULL)));
			if (!$cnt) {
				if ($this->ContentImage->save($this->data)) {
					$this->Session->setFlash(__('The Image has been saved', true));
					//$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The Image could not be saved. Please, try again.', true));
				}
			} else {
				if ($this->ContentImage->updateAll(array('updated' => 'now()'), array('alias' => basename($_FILES['userfile']['name']), 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"], 'deleted' => NULL))) {
					$this->Session->setFlash(__('The Image has been updated', true));
				} else {
					$this->Session->setFlash(__('The Image could not be updated. Please, try again.', true));
				}
			}
		//}
	}

	/**
	 * 画像削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Image', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentImage->advDel($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Image could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>