<?php
class AreaController extends AppController {

	var $name = 'Area';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('Area', 'Page', 'AreaLanguage', 'Language', 'AreaLinkCountry', 'AreaLinkCity', 'Country', 'City');
	var $components = array('RequestHandler', 'SelectGetter');

	//var $needAuth = true;	// ログイン必須のフラグ

	/**
	 * エリア一覧画面
	 */
	function index() {
		if (isset($this->passedArgs['code'])) {
			$code = $this->passedArgs['code'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListArea($this->getIsoId(), $code);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('areas', $this->paginate('Page'));
	}

	/**
	 * エリア新規登録画面
	 */
	function add() {
		if (!empty($this->data)) {
			$this->Area->create();
			if ($this->Area->save($this->data)) {
				$this->Session->setFlash(__('The Area has been saved', true));
				$this->redirect(array('action' => 'editName/' . $this->Area->id));
			} else {
				$this->Session->setFlash(__('The Area could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * エリア編集画面
	 * @param $id
	 */
	function edit($id = null) {
		if ((!$id && empty($this->data))) {
			$this->Session->setFlash(__('Invalid Area', true));
			$this->redirect(array('action' => 'index'));
		}

		//既に削除されたのレコードは編集できません
		if(!$this->Area->find('count', array( 'conditions' => array('area.id' => !$id ? $this->data['Area']['id']:$id, 'area.deleted' => NULL)))) {
			$this->Session->setFlash(__('Invalid Area', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			if ($this->Area->save($this->data)) {
				$this->Session->setFlash(__('The Area has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Area could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Area->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Area->begin();	// Start transaction
		if ($this->Area->advDel($id)) {
			if ($this->AreaLanguage->advDelAll(array('AreaLanguage.area_id' => $id))
				&& $this->AreaLinkCountry->advDelAll(array('AreaLinkCountry.area_id' => $id))
				&& $this->AreaLinkCity->advDelAll(array('AreaLinkCity.area_id' => $id))
				/*
				 && $this->AreaLinkState->advDelAll(array('AreaLinkState.area_id' => $id))
				 && $this->AreaLinkTown->advDelAll(array('AreaLinkTown.area_id' => $id))
				 */) {

				$this->Area->commit();	// Persist the data

				$this->Session->setFlash(__('Area deleted', true));

				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Area->rollback();
			}
		} else {
			$this->Session->setFlash(__('The Area could not be deleted. Please, try again.', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * エリア名前編集画面
	 * @param $id
	 */
	function editName($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('names', $this->Area->query("select Area.id, Area.code, Language.name, AreaLanguage.name from (select * from area where isnull(area.deleted)) as Area
													left join (select * from area_language where isnull(area_language.deleted)) as AreaLanguage on Area.id=AreaLanguage.area_id
													left join (select language.id as id, LanguageLanguage.name as name from (select * from language where isnull(language.deleted)) as language
																left join (select * from language_language where iso_language_id=" . $this->getIsoId() . " and isnull(language_language.deleted)) as LanguageLanguage on LanguageLanguage.language_id = language.id) as Language on Language.id=AreaLanguage.language_id
													where Area.id=$id and isnull(Area.deleted)"));

		$this->set('languages', $this->SelectGetter->getLanguageMin());
	}

	/**
	 * エリア名前編集アクション
	 */
	function addName() {
		if (!empty($this->data)) {
			$num = $this->Area->AreaLanguage->find('count', array('conditions' => array('AreaLanguage.area_id' => $this->data['Area']['AreaId'], 'AreaLanguage.language_id' => $_REQUEST["LanguageId"])));
			if($num) {
				$result = $this->Area->AreaLanguage->find('first', array('conditions' => array('AreaLanguage.area_id' => $this->data['Area']['AreaId'], 'AreaLanguage.language_id' => $_REQUEST["LanguageId"])));
				$this->Area->AreaLanguage->set(
					array( 'id' => $result['AreaLanguage']['id'],
							'language_id' => $_REQUEST["LanguageId"],
							'area_id' => $this->data['Area']['AreaId'],
							'name' => $this->data['Area']['area name']
					)
				);

				if ($this->Area->AreaLanguage->save()) {
					$this->Session->setFlash(__('The AreaLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['Area']['AreaId']));
				} else {
					$this->Session->setFlash(__('The AreaLanguage could not be saved. Please, try again.', true));
				}
			} else {
				$this->Area->AreaLanguage->create();
				$this->Area->AreaLanguage->set(
					array( 'id' => null,
							'language_id' => $_REQUEST["LanguageId"],
							'area_id' => $this->data['Area']['AreaId'],
							'name' => $this->data['Area']['area name']
					)
				);

				if ($this->Area->AreaLanguage->save()) {
					$this->Session->setFlash(__('The AreaLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['Area']['AreaId']));
				} else {
					$this->Session->setFlash(__('The AreaLanguage could not be saved. Please, try again.', true));
				}
			}

		}
	}

	/**
	 * area_link_country編集画面
	 * @param $id
	 */
	function editCountry($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('names', $this->Area->query("select Area.id, Area.code, AreaLinkCountry.id, Country.id, Country.name from (select * from area where isnull(area.deleted)) as Area
													left join (select * from area_link_country where isnull(area_link_country.deleted)) as AreaLinkCountry on Area.id=AreaLinkCountry.area_id
													left join (select country.id as id, CountryLanguage.name_long as name from (select * from country where isnull(country.deleted)) as country
																left join (select * from country_language where language_id=" . $this->getIsoId() . " and isnull(country_language.deleted)) as CountryLanguage on CountryLanguage.country_id = country.id) as Country on Country.id=AreaLinkCountry.country_id
													where Area.id=$id and isnull(Area.deleted) order by Country.name"));

		//$this->set('area_link_country', $this->Area->AreaLinkCountry->findAll("area_id=$id and isnull(AreaLinkCountry.deleted)"));
		$this->set('countries', $this->SelectGetter->getCountry());

		$this->Session->write('area_id', $id);
	}

	/**
	 * area_link_country削除アクション
	 * @param $id
	 */
	function deleteCountry($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AreaLinkCountry', true));
			$this->redirect(array('action' => 'editCountry/' . $this->Session->read('area_id')));
		}
		if ($this->Area->AreaLinkCountry->del($id)) {
			$this->Session->setFlash(__('AreaLinkCountry deleted', true));
			$this->redirect(array('action' => 'editCountry/' . $this->Session->read('area_id')));
		}
		$this->Session->setFlash(__('The AreaLinkCountry could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'editCountry/' . $this->Session->read('area_id')));
	}

	/**
	 * area_link_country追加アクション
	 */
	function addCountry() {
		if (!empty($this->data)) {
			$num = $this->AreaLinkCountry->find('count', array('conditions' => array('AreaLinkCountry.area_id' => $this->data['Area']['AreaId'], 'AreaLinkCountry.country_id' => $_REQUEST["CountryId"])));
			if($num) {
				$this->Session->setFlash(__('The AreaLinkCountry already exists.', true));
				$this->redirect(array('action' => 'editCountry/' . $this->data['Area']['AreaId']));
			} else {
				$this->AreaLinkCountry->create();
				$this->AreaLinkCountry->set(
					array( 'id' => null,
							'country_id' => $_REQUEST["CountryId"],
							'area_id' => $this->data['Area']['AreaId'],
					)
				);

				if ($this->AreaLinkCountry->save()) {
					$this->Session->setFlash(__('The AreaLinkCountry has been saved', true), 'default', array('class' => 'notice'));
					$this->redirect(array('action' => 'editCountry/' . $this->data['Area']['AreaId']));
				} else {
					$this->Session->setFlash(__('The AreaLinkCountry could not be saved. Please, try again.', true));
					$this->redirect(array('action' => 'editCountry/' . $this->data['Area']['AreaId']));
				}
			}
		}
	}

	/**
	 * area_link_city編集画面
	 * @param $id
	 */
	function editCity($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('names', $this->Area->query("select Area.id, Area.code, AreaLinkCity.id, City.id, City.name from (select * from area where isnull(area.deleted)) as Area
													left join (select * from area_link_city where isnull(area_link_city.deleted)) as AreaLinkCity on Area.id=AreaLinkCity.area_id
													left join (select city.id as id, CityLanguage.name as name from (select * from city where isnull(city.deleted)) as city
																left join (select * from city_language where language_id=" . $this->getIsoId() . " and isnull(city_language.deleted)) as CityLanguage on CityLanguage.city_id = city.id) as City on City.id=AreaLinkCity.city_id
													where Area.id=$id and isnull(Area.deleted) order by City.name "));

		$this->set('area_link_city', $this->Area->AreaLinkCity->findAll("area_id=$id and isnull(AreaLinkCity.deleted)"));

		$tmpArr = $this->SelectGetter->getCountry();
		$countries = array();
		$countries[''] = __('-----select a country-----', true);
		foreach($tmpArr as $tmp) {
			$countries[$tmp['Country']['id']] = $tmp['Country']['iso_code_a2'] . "(" . $tmp['CountryLanguage']['name'] . ")";
		}
		$this->set('countries', $countries);

		$this->Session->write('area_id', $id);
	}

	/**
	 * area_link_city削除アクション
	 * @param $id
	 */
	function deleteCity($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for AreaLinkCity', true));
			$this->redirect(array('action' => 'editCity/' . $this->Session->read('area_id')));
		}
		if ($this->Area->AreaLinkCity->del($id)) {
			$this->Session->setFlash(__('AreaLinkCity deleted', true));
			$this->redirect(array('action' => 'editCity/' . $this->Session->read('area_id')));
		}
		$this->Session->setFlash(__('The AreaLinkCity could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'editCity/' . $this->Session->read('area_id')));
	}

	/**
	 * area_link_city追加アクション
	 */
	function addCity() {
		if (!empty($this->data)) {
			$num = $this->AreaLinkCity->find('count', array('conditions' => array('AreaLinkCity.area_id' => $this->data['Area']['AreaId'], 'AreaLinkCity.city_id' => $this->data['City']['id'])));
			if($num) {
				$this->Session->setFlash(__('The AreaLinkCity already exists.', true));
				$this->redirect(array('action' => 'editCity/' . $this->data['Area']['AreaId']));
			} else {
				$this->AreaLinkCity->create();
				$this->AreaLinkCity->set(
					array( 'id' => null,
							'city_id' => $this->data['City']['id'],
							'area_id' => $this->data['Area']['AreaId'],
					)
				);

				if ($this->AreaLinkCity->save()) {
					$this->Session->setFlash(__('The AreaLinkCity has been saved', true));
					$this->redirect(array('action' => 'editCity/' . $this->data['Area']['AreaId']));
				} else {
					$this->Session->setFlash(__('The AreaLinkCity could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
					$this->redirect(array('action' => 'editCity/' . $this->data['Area']['AreaId']));
				}
			}
		}
	}

	/**
	 * area_link_city国選択した時、都市データ更新のajaxアクション
	 */
	function update_select() {
	  if(!empty($this->data['Country']['id'])) {
	    $cou_id = (int)$this->data['Country']['id'];

	    $tmpArr = $this->SelectGetter->getCity($cou_id);
		$cities = array();
		$cities[''] = __('---select a city---', true);
		foreach($tmpArr as $tmp) {
			$cities[$tmp['City']['id']] = $tmp['City']['code'] . " (" . $tmp['CityLanguage']['name'] . ")";
		}

	    $this->set('options',$cities);
	  } else {
	  	$cities = array();
		$cities[''] = __('---select a city---', true);
		$this->set('options',$cities);
	  }
	}

}
?>