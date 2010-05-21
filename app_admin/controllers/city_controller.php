<?php
class CityController extends AppController {

	var $name = 'City';
	var $helpers = array('Html', 'Form');
	var $uses = array('Country', 'Page', 'CountryLanguage', 'City', 'CityLanguage', 'Language');
	var $components = array('SelectGetter');

	/**
	 * 都市一覧
	 */
	function index() {
		$this->set('countries', $this->SelectGetter->getCountry());

		if (isset($this->passedArgs['country_id'])) {
			$country_id = $this->passedArgs['country_id'];
		} else {
			$country_id = null;
		}

		if (isset($this->passedArgs['code'])) {
			$code = $this->passedArgs['code'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListCity($this->getIsoId(), $country_id, $code);
		$this->paginate = array(
			'conditions'=>$cond,
			'order'=>'id ASC',
			'limit'=>20,
			'recursive'=>0
		);

		$this->set('cities', $this->paginate('Page'));
	}

	/**
	 * 都市新規登録
	 */
	function add() {
		$this->set('countries', $this->SelectGetter->getCountry());

		if (!empty($this->data)) {
			$this->City->create();
			$this->City->set(
				array( 'country_id' => $_REQUEST["CountryId"],
						'state_id' => 0,
						'code' => $this->data['City']['code']
				)
			);
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The City has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The City could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * 都市編集
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid City', true));
			$this->redirect(array('action' => 'index'));
		}

		//既に削除されたのレコードは編集できません
		if(!$this->City->find('count', array( 'conditions' => array('city.id' => !$id ? $this->data['City']['id']:$id, 'city.deleted' => NULL)))) {
			$this->Session->setFlash(__('Invalid City', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('countries', $this->SelectGetter->getCountry());
		if (!empty($this->data)) {
			$this->City->set(
				array( 'country_id' => $_REQUEST["CountryId"],
						'code' => $this->data['City']['code']
				)
			);
			if ($this->City->save($this->data)) {
				$this->Session->setFlash(__('The City has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The City could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->City->read(null, $id);
		}
	}

//	function delete($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid id for City', true));
//			$this->redirect(array('action' => 'index'));
//		}
//		if ($this->City->del($id)) {
//			$this->Session->setFlash(__('City deleted', true));
//			$this->redirect(array('action' => 'index'));
//		}
//		$this->Session->setFlash(__('The City could not be deleted. Please, try again.', true));
//		$this->redirect(array('action' => 'index'));
//	}

	/**
	 * 都市名前編集
	 */
	function editName($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('names', $this->City->query("select City.id, City.code, Language.name, CityLanguage.name from (select * from city where isnull(city.deleted)) as City
													left join (select * from city_language where isnull(city_language.deleted)) as CityLanguage on City.id=CityLanguage.city_id
													left join (select language.id as id, LanguageLanguage.name as name from (select * from language where isnull(language.deleted)) as language
																left join (select * from language_language where iso_language_id=" . $this->getIsoId() . " and isnull(language_language.deleted)) as LanguageLanguage on LanguageLanguage.language_id = language.id) as Language on Language.id=CityLanguage.language_id
													where City.id=$id and isnull(City.deleted)"));

		$this->set('languages', $this->SelectGetter->getLanguageMin());
	}

	/**
	 * 都市名前編集アクション
	 */
	function addName() {
		if (!empty($this->data)) {
			$num = $this->City->CityLanguage->find('count', array('conditions' => array('CityLanguage.city_id' => $this->data['City']['CityId'], 'CityLanguage.language_id' => $_REQUEST["LanguageId"])));
			if($num) {
				$result = $this->City->CityLanguage->find('first', array('conditions' => array('CityLanguage.city_id' => $this->data['City']['CityId'], 'CityLanguage.language_id' => $_REQUEST["LanguageId"])));
				$this->City->CityLanguage->set(
					array( 'id' => $result['CityLanguage']['id'],
							'language_id' => $_REQUEST["LanguageId"],
							'city_id' => $this->data['City']['CityId'],
							'name' => $this->data['City']['city name']
					)
				);

				if ($this->City->CityLanguage->save()) {
					$this->Session->setFlash(__('The CityLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['City']['CityId']));
				} else {
					$this->Session->setFlash(__('The CityLanguage could not be saved. Please, try again.', true));
				}
			} else {
				$this->City->CityLanguage->create();
				$this->City->CityLanguage->set(
					array( 'id' => null,
							'language_id' => $_REQUEST["LanguageId"],
							'city_id' => $this->data['City']['CityId'],
							'name' => $this->data['City']['city name']
					)
				);

				if ($this->City->CityLanguage->save()) {
					$this->Session->setFlash(__('The CityLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['City']['CityId']));
				} else {
					$this->Session->setFlash(__('The CityLanguage could not be saved. Please, try again.', true));
				}
			}

		}
	}

}
?>