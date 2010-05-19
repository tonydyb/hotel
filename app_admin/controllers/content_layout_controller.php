<?php
class ContentLayoutController extends AppController {

	var $name = 'ContentLayout';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentLayout', 'ContentPage', 'Page', 'Language');
	var $components = array('RequestHandler', 'SelectGetter');

	function index() {
		if (isset($this->passedArgs['alias'])) {
			$code = $this->passedArgs['alias'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListContentLayout($this->getIsoId(), $code);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentLayout.name, ContentLayout.alias, ContentLayout.carrier_type_id, ContentLayout.language_id, ContentLayout.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentLayouts', $this->paginate('Page'));
	}

	function add() {
		$this->set('languages', $this->SelectGetter->getLanguage());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!empty($this->data)) {
			$this->ContentLayout->create();
			$this->ContentLayout->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);

			$cnt = $this->ContentLayout->find('count', array( 'conditions' => array('alias' => $this->data['ContentLayout']['alias'], 'language_id' => $_REQUEST["LanguageId"], 'carrier_type_id' => $_REQUEST["CarrierTypeId"])));
			if (!$cnt) {
				if ($this->ContentLayout->save($this->data)) {
					$this->Session->setFlash(__('The ContentLayout has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentLayout could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentLayout is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	function edit($id = null) {
		$this->set('languages', $this->SelectGetter->getLanguage());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentLayout', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->ContentLayout->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);
			if ($this->ContentLayout->save($this->data)) {
				$this->Session->setFlash(__('The ContentLayout has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The ContentLayout could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentLayout->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentLayout', true));
			$this->redirect(array('action' => 'index'));
		}
		$cnt = $this->ContentPage->find('count', array( 'conditions' => array('content_layout_id' => $id)));
		if (!$cnt) {
			if ($this->ContentLayout->del($id)) {
				$this->Session->setFlash(__('ContentLayout deleted', true));
				$this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Session->setFlash(__('Can not delete layout that still contains pages. Please, delete all this layout`s pages first.', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Session->setFlash(__('The ContentLayout could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>