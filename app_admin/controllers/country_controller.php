<?php
class CountryController extends AppController {

	var $name = 'Country';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('Country', 'Page', 'CountryLanguage', 'Language');
	var $components = array('SelectGetter');

	/**
	 * 国一覧
	 */
	function index() {
		if (isset($this->passedArgs['iso_code_a2'])) {
			$code = $this->passedArgs['iso_code_a2'];
		} else {
			$code = null;
		}

		$cond = $this->Page->getSqlListCountry($this->getIsoId(), $code);
		$this->paginate = array(
			'conditions'=>$cond,
			'order'=>'id ASC',
			'limit'=>20,
			'recursive'=>0
		);

		$this->set('country', $this->paginate('Page'));
	}

	/**
	 * 国新規登録
	 */
	function add() {
		if (!empty($this->data)) {
			$this->Country->create();
			if ($this->Country->save($this->data)) {
				$this->Session->setFlash(__('The Country has been saved', true));
				$this->redirect(array('action' => '/index'));
			} else {
				$this->Session->setFlash(__('The Country could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * 国編集
	 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Country', true));
			$this->redirect(array('action' => '/index'));
		}
		//既に削除されたのレコードは編集できません
		if(!$this->Country->find('count', array( 'conditions' => array('country.id' => !$id ? $this->data['Country']['id']:$id, 'country.deleted' => NULL)))) {
			$this->Session->setFlash(__('Invalid Country', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			if ($this->Country->save($this->data)) {
				$this->Session->setFlash(__('The Country has been saved', true));
				$this->redirect(array('action' => '/index'));
			} else {
				$this->Session->setFlash(__('The Country could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Country->read(null, $id);
		}
	}

//	function delete($id = null) {
//		if (!$id) {
//			$this->Session->setFlash(__('Invalid id for Country', true));
//			$this->redirect(array('action' => '/index'));
//		}
//		if ($this->Country->advDel($id)) {
//			$this->Session->setFlash(__('Country deleted', true));
//			$this->redirect(array('action' => '/index'));
//		}
//		$this->Session->setFlash(__('The Country could not be deleted. Please, try again.', true));
//		$this->redirect(array('action' => '/index'));
//	}

	/**
	 * 国名前編集
	 */
	function editName($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Area', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->set('names', $this->Country->query("select Country.id, Country.iso_code_a2, Language.name, CountryLanguage.name_long as name from (select * from country where isnull(country.deleted)) as Country
													left join (select * from country_language where isnull(country_language.deleted)) as CountryLanguage on Country.id=CountryLanguage.country_id
													left join (select language.id as id, LanguageLanguage.name as name from (select * from language where isnull(language.deleted)) as language
																left join (select * from language_language where iso_language_id=" . $this->getIsoId() . " and isnull(language_language.deleted)) as LanguageLanguage on LanguageLanguage.language_id = language.id) as Language on Language.id=CountryLanguage.language_id
													where Country.id=$id and isnull(Country.deleted)"));

		$this->set('languages', $this->SelectGetter->getLanguageMin());
	}

	/**
	 * 国名前編集アクション
	 */
	function addName() {
		if (!empty($this->data)) {
			$num = $this->Country->CountryLanguage->find('count', array('conditions' => array('CountryLanguage.country_id' => $this->data['Country']['CountryId'], 'CountryLanguage.language_id' => $_REQUEST["LanguageId"])));
			if($num) {
				$result = $this->Country->CountryLanguage->find('first', array('conditions' => array('CountryLanguage.country_id' => $this->data['Country']['CountryId'], 'CountryLanguage.language_id' => $_REQUEST["LanguageId"])));
				$this->Country->CountryLanguage->set(
					array( 'id' => $result['CountryLanguage']['id'],
							'language_id' => $_REQUEST["LanguageId"],
							'country_id' => $this->data['Country']['CountryId'],
							'name' => $this->data['Country']['country name'],
							'name_long' => $this->data['Country']['country name'],
					)
				);

				if ($this->Country->CountryLanguage->save()) {
					$this->Session->setFlash(__('The CountryLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['Country']['CountryId']));
				} else {
					$this->Session->setFlash(__('The CountryLanguage could not be saved. Please, try again.', true));
				}
			} else {
				$this->Country->CountryLanguage->create();
				$this->Country->CountryLanguage->set(
					array( 'id' => null,
							'language_id' => $_REQUEST["LanguageId"],
							'country_id' => $this->data['Country']['CountryId'],
							'name' => $this->data['Country']['country name'],
							'name_long' => $this->data['Country']['country name'],
					)
				);

				if ($this->Country->CountryLanguage->save()) {
					$this->Session->setFlash(__('The CountryLanguage has been saved', true));
					$this->redirect(array('action' => 'editName/' . $this->data['Country']['CountryId']));
				} else {
					$this->Session->setFlash(__('The CountryLanguage could not be saved. Please, try again.', true));
				}
			}

		}
	}
}
?>