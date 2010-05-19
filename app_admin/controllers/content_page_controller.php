<?php
class ContentPageController extends AppController {

	var $name = 'ContentPage';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentLayout', 'ContentPage', 'Page', 'Language');
	var $components = array('RequestHandler', 'SelectGetter');

	function index() {
		if (isset($this->passedArgs['alias'])) {
			$code = $this->passedArgs['alias'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListContentPage($this->getIsoId(), $code);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentLayout.name, ContentPage.alias, ContentPage.name, ContentPage.carrier_type_id, ContentPage.language_id, ContentPage.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentPages', $this->paginate('Page'));
	}

	function add() {
		$this->set('languages', $this->SelectGetter->getLanguage());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());
		$this->set('contentLayouts', $this->SelectGetter->getContentLayout());

		if (!empty($this->data)) {
			$this->ContentPage->create();
			$this->ContentPage->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"],
						'content_layout_id' => $_REQUEST["ContentLayoutId"]
				)
			);

			$cnt = $this->ContentPage->find('count', array( 'conditions' => array('ContentPage.alias' => $this->data['ContentPage']['alias'], 'ContentPage.language_id' => $_REQUEST["LanguageId"], 'ContentPage.carrier_type_id' => $_REQUEST["CarrierTypeId"])));
			if (!$cnt) {
				if ($this->ContentPage->save($this->data)) {
					$this->Session->setFlash(__('The ContentPage has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentPage could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentPage is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	function edit($id = null) {

	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentPage', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentPage->del($id)) {
			$this->Session->setFlash(__('ContentPage deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The ContentPage could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>