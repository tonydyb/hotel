<?php
class ContentBlockController extends AppController {

	var $name = 'ContentBlock';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentBlock', 'Page', 'Language');
	var $components = array('RequestHandler', 'SelectGetter');

	function index() {
		if (isset($this->passedArgs['alias'])) {
			$code = $this->passedArgs['alias'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListContentBlock($this->getIsoId(), $code);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentBlock.alias, ContentBlock.name, ContentBlock.carrier_type_id, ContentBlock.language_id, ContentBlock.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentBlocks', $this->paginate('Page'));
	}

	function add() {
		$this->set('languages', $this->SelectGetter->getLanguage());
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
					$this->Session->setFlash(__('The ContentBlock has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentBlock could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentBlock is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	function edit($id = null) {
		$this->set('languages', $this->SelectGetter->getLanguage());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentBlock', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->ContentBlock->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);
			if ($this->ContentBlock->save($this->data)) {
				$this->Session->setFlash(__('The ContentBlock has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The ContentBlock could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentBlock->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentBlock', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentBlock->del($id)) {
			$this->Session->setFlash(__('ContentBlock deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The ContentBlock could not be deleted. Please, try again.', true), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

}
?>