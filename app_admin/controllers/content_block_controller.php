<?php
class ContentBlockController extends AppController {

	var $name = 'ContentBlock';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentBlock', 'Page', 'Language');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * コンテントブログ一覧
	 */
	function index() {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (isset($this->passedArgs['language_id'])) {
			$language_id = $this->passedArgs['language_id'];
		} else {
			$language_id = null;
		}

		if (isset($this->passedArgs['carrier_type_id'])) {
			$carrier_type_id = $this->passedArgs['carrier_type_id'];
		} else {
			$carrier_type_id = null;
		}

		if (isset($this->passedArgs['alias'])) {
			$alias = $this->passedArgs['alias'];
		} else {
			$alias = null;
		}

		$cond = $this->Page->getSqlListContentBlock($this->getIsoId(), $language_id, $carrier_type_id, $alias);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentBlock.alias, ContentBlock.name, ContentBlock.carrier_type_id, ContentBlock.language_id, ContentBlock.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentBlocks', $this->paginate('Page'));
	}

	/**
	 * コンテントブログ新規登録
	 */
	function add() {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!empty($this->data)) {
			$this->ContentBlock->create();
			$this->ContentBlock->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);

			$cnt = $this->ContentBlock->find('count', array( 'conditions' => array('alias' => $this->data['ContentBlock']['alias'], 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"])));
			if (!$cnt) {
				if ($this->ContentBlock->save($this->data)) {
					//ファイルに書き込み
					if(!$this->__writeFile(false)) {
						$this->Session->setFlash(__('Wirte ContentBlock file failed', true));
					} else {
						$this->Session->setFlash(__('The ContentBlock has been saved', true));
					}
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentBlock could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentBlock is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	/**
	 * コンテントブログ編集
	 * @param $id
	 */
	function edit($id = null) {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentBlock', true));
			$this->redirect(array('action' => 'index'));
		}
		//既に削除されたのレコードは編集できません
//		if(!$this->ContentBlock->find('count', array( 'conditions' => array('ContentBlock.id' => !$id ? $this->data['ContentBlock']['id']:$id, 'ContentBlock.deleted' => NULL)))) {
//			$this->Session->setFlash(__('Invalid ContentBlock2', true), 'default', array('class' => 'error'));
//			$this->redirect(array('action' => 'index'));
//		}

		if (!empty($this->data)) {
			$this->ContentBlock->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);
			if ($this->ContentBlock->save($this->data)) {
				//ファイルに書き込み
				if(!$this->__writeFile(true)) {
					$this->Session->setFlash(__('Wirte ContentBlock file failed', true));
				} else {
					$this->Session->setFlash(__('The ContentBlock has been saved', true));
				}
				$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The ContentBlock could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentBlock->read(null, $id);
		}
	}

	/**
	 * コンテントブログ削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentBlock', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentBlock->advDel($id)) {
			$this->Session->setFlash(__('ContentBlock deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The ContentBlock could not be deleted. Please, try again.', true), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * コンテントctpファイル作成
	 */
	function __writeFile($isEdit = true) {
		$rootPath = CONTENT_BLOCK_ROOT_PATH;

		$iso_code = $this->getIsoCode($_REQUEST["LanguageId"]);
		$carrier_name = $this->getCarrierCode($_REQUEST["CarrierTypeId"]);
		$file_name = $this->data['ContentBlock']['alias'];

		$newFileStr = $rootPath . $iso_code . "/" . $carrier_name . "/" . $file_name . ".ctp";
		$path =  $rootPath . $iso_code . "/" . $carrier_name;

		if ($isEdit) {
			//旧ファイルを削除
			$oldFileStr = $rootPath . $this->getIsoCode($this->data['ContentBlock']["oldLanguageId"]) . "/" . $this->getCarrierCode($this->data['ContentBlock']["oldCarrierTypeId"]) . "/" . $this->data['ContentBlock']["oldAlias"] . ".ctp";
			if(file_exists($oldFileStr)) {
				unlink($oldFileStr);
			}
		}

		if(!file_exists($path)) {
			$this->ModelUtil->mkdirRec($path);
		}

		touch($newFileStr);

		return file_put_contents($newFileStr, $this->data['ContentBlock']['content']);
	}
}
?>
