<?php
class DiscountController extends AppController {

	var $name = 'Discount';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('Discount');
	var $components = array('RequestHandler', 'SelectGetter');

	function index() {
		$this->Discount->recursive = 0;
		$this->set('count', $this->Discount->find('count', array( 'conditions' => array('Discount.deleted' => null))));
		$this->set('discounts', $this->Discount->find('all', array( 'conditions' => array('Discount.deleted' => null), 'order' => 'sort asc')));
	}

	function add() {
		$this->set('discount_items', $this->SelectGetter->getDiscountItem());
		$this->set('discount_types', $this->SelectGetter->getDiscountType());

		$sort = $this->Discount->query("select max(sort) as sort from discount where isnull(deleted);");
		if(!$sort[0][0]['sort']) {
			$maxSort = 1;
		} else {
			$maxSort = $sort[0][0]['sort'] + 1;
		}

		if (!empty($this->data)) {

			$this->Discount->create();
			$this->Discount->set(
				array( 'sort' => $maxSort
				)
			);

			if ($this->Discount->save($this->data)) {
				$this->Session->setFlash(__('The Discount has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Discount could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Discount', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Discount->save($this->data)) {
				$this->Session->setFlash(__('The Discount has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Discount could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Discount->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Discount', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Discount->advDel($id)) {
			$this->Session->setFlash(__('Discount deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Discount could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>