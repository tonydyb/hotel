<?php
class HotelAgentController extends AppController {

	var $name = 'HotelAgent';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('HotelAgent', 'Page', 'CountryLanguage');
	var $components = array('SelectGetter', 'NameGetter');

	/**
	 * ホテルエイジェント一覧
	 */
	function index() {
		if (isset($this->passedArgs['name'])) {
			$name = $this->passedArgs['name'];
		} else {
			$name = null;
		}

		if (isset($this->passedArgs['code'])) {
			$code = $this->passedArgs['code'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListHotelAgent($this->getIsoId(), $name, $code);
		$this->paginate = array(
			'conditions'=>$cond,
			'order'=>'id ASC',
			'limit'=>20,
			'recursive'=>0
		);

		$this->set('countries', $this->SelectGetter->getCountry());
		$this->set('hotelAgents', $this->paginate('Page'));
	}

	/**
	 * ホテルエイジェント詳細
	 * @param $id
	 */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid HotelAgent', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('hotelAgent', $this->HotelAgent->read(null, $id));
		$tmp = $this->HotelAgent->read(null, $id);
		$this->set('countryName', $this->NameGetter->getCountryName($tmp['HotelAgent']['country_id']));
	}

	/**
	 * ホテルエイジェント新規登録
	 */
	function add() {
		$this->set('countries', $this->SelectGetter->getCountry());

		if (!empty($this->data)) {
			$this->HotelAgent->create();
			if ($this->HotelAgent->save($this->data)) {
				$this->Session->setFlash(__('The HotelAgent has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The HotelAgent could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * ホテルエイジェント編集
	 * @param $id
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid HotelAgent', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('countries', $this->SelectGetter->getCountry());
		if (!empty($this->data)) {
			if ($this->HotelAgent->save($this->data)) {
				$this->Session->setFlash(__('The HotelAgent has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The HotelAgent could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HotelAgent->read(null, $id);
		}
	}

	/**
	 * ホテルエイジェント削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for HotelAgent', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->HotelAgent->advDel($id)) {
			$this->Session->setFlash(__('HotelAgent deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The HotelAgent could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>