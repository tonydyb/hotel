<?php
class DiscountController extends AppController {

	var $name = 'Discount';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('Discount');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * 料金一覧
	 */
	function index() {
		$this->Discount->recursive = 0;
		$this->set('count', $this->Discount->find('count', array( 'conditions' => array('Discount.deleted' => null))));
		$this->set('discounts', $this->Discount->find('all', array( 'conditions' => array('Discount.deleted' => null), 'order' => 'sort asc')));
	}

	/**
	 * 料金新規登録
	 */
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
				array(
					'sort' => $maxSort
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

	/**
	 * 料金編集
	 * @param $id
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Discount', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('discount_items', $this->SelectGetter->getDiscountItem());
		$this->set('discount_types', $this->SelectGetter->getDiscountType());

		if (!empty($this->data)) {
			//$this->data['Discount']['amount'] = (double)($this->data['Discount']['amount']);
			//$this->data['Discount']['start_date'] = substr($this->data['Discount']['start_date'], 0, 10) . " 00:00:00";
			//$this->data['Discount']['end_date'] = "'" . substr($this->data['Discount']['end_date'], 0, 10) . " 23:59:59'";
			//print_r($this->data);
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

	/**
	 * 料金削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Discount', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Discount->begin();
		$discount = $this->Discount->find('first', array('conditions' => array('Discount.id' => $id), 'fields' => array('sort')));
		$sort = $discount['Discount']['sort'];
		if ($this->Discount->advDel($id)) {
			if($this->Discount->updateAll(array('Discount.sort' => 'Discount.sort - 1'), array('Discount.sort > ' => $sort, 'Discount.deleted' => null))) {
				$this->Discount->commit();
				$this->Session->setFlash(__('Discount deleted', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Discount->rollback();
			}
		} else {
			$this->Session->setFlash(__('The Discount could not be deleted. Please, try again.', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * 料金順番設定
	 */
	function saveSort() {
		if (isset($_REQUEST['sort'])) {
			$sort = $_REQUEST['sort'];

			for ($i = 0; $i < count($sort); $i++) {
				mysql_query("UPDATE `discount` SET `sort`=" . ($i+1) . " WHERE `id`='" . $sort[$i] . "'") or die(mysql_error());
			}
		}

		$this->Session->setFlash(__('Order saved', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>