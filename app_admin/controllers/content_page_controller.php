<?php
class ContentPageController extends AppController {

	var $name = 'ContentPage';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentLayout', 'ContentPage', 'Page', 'Language');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * コンテント　ページ一覧
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

		$cond = $this->Page->getSqlListContentPage($this->getIsoId(), $language_id, $carrier_type_id, $alias);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentLayout.name, ContentPage.alias, ContentPage.name, ContentPage.carrier_type_id, ContentPage.language_id, ContentPage.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentPages', $this->paginate('Page'));
	}

	/**
	 * コンテント　ページ追加
	 */
	function add() {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
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
					//ファイルに書き込み
					if(!$this->__writeFile(false)) {
						$this->Session->setFlash(__('Wirte ContentPage file failed', true));
					} else {
						$this->Session->setFlash(__('The ContentPage has been saved', true));
					}

					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentPage could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentPage is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	/**
	 * コンテント　ページ編集
	 * @param unknown_type $id
	 */
	function edit($id = null) {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());
		$this->set('contentLayouts', $this->SelectGetter->getContentLayout());

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentPage', true));
			$this->redirect(array('action' => 'index'));
		}
		//既に削除されたのレコードは編集できません
//		if(!$this->ContentPage->find('count', array( 'conditions' => array('ContentPage.id' => !$id ? $this->data['ContentPage']['id']:$id, 'ContentPage.deleted' => NULL)))) {
//			$this->Session->setFlash(__('Invalid ContentPage2', true), 'default', array('class' => 'error'));
//			$this->redirect(array('action' => 'index'));
//		}

		if (!empty($this->data)) {
			$this->ContentPage->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"],
						'content_layout_id' => $_REQUEST["ContentLayoutId"]
				)
			);
			if ($this->ContentPage->save($this->data)) {
				//ファイルに書き込み
				if(!$this->__writeFile(true)) {
					$this->Session->setFlash(__('Wirte ContentPage file failed', true));
				} else {
					$this->Session->setFlash(__('The ContentPage has been saved', true));
				}

				$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The ContentPage could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentPage->read(null, $id);
		}
	}

	/**
	 * コンテント　ページ削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentPage', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->ContentPage->advDel($id)) {
			$this->Session->setFlash(__('ContentPage deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The ContentPage could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * コンテントctpファイル作成
	 */
	function __writeFile($isEdit = true) {
		$rootPath = CONTENT_PAGE_ROOT_PATH;

		$iso_code = $this->getIsoCode($_REQUEST["LanguageId"]);
		$carrier_name = $this->getCarrierCode($_REQUEST["CarrierTypeId"]);
		$file_name = $this->data['ContentPage']['alias'];

		if ($isEdit) {
			//旧ファイルを削除
			$oldFileStr = $rootPath . $this->getIsoCode($this->data['ContentPage']["oldLanguageId"]) . "/" . $this->getCarrierCode($this->data['ContentPage']["oldCarrierTypeId"]) . "/" . $this->data['ContentPage']["oldAlias"] . ".ctp";
			if(file_exists($oldFileStr)) {
				unlink($oldFileStr);
			}
		}

		$newFileStr = $rootPath . $iso_code . "/" . $carrier_name . "/" . $file_name . ".ctp";
		$path =  $rootPath . $iso_code . "/" . $carrier_name;

		//フォルド作成
		if(!file_exists($path)) {
			$this->ModelUtil->mkdirRec($path);
		}

		//新コンテントctpファイル新規
		touch($newFileStr);

		if (!empty($_REQUEST["ContentLayoutId"])) {
			$layout = $this->ContentLayout->find('first', array( 'conditions' => array('ContentLayout.id' => $_REQUEST["ContentLayoutId"]), 'fields' => array('alias', 'language_id', 'carrier_type_id', 'meta_keyword', 'meta_description')));
			$layout_name = $this->getIsoCode($layout['ContentLayout']['language_id']) . "/" . $this->getCarrierCode($layout['ContentLayout']['carrier_type_id']) . "/" . $layout['ContentLayout']['alias'];
		}

		$str = "<?php \n";
		if (!empty($this->data['ContentPage']['title'])) {
			$str .= "\$this->pageTitle = '" . $this->data['ContentPage']['title'] . "';\n";
		}
		if (!empty($this->data['ContentPage']['meta_keyword']) || isset($layout)) {
			$str .= "echo \$html->meta('keywords', '" . (isset($layout) ? $layout['ContentLayout']['meta_keyword']:"") . " " . $this->data['ContentPage']['meta_keyword'] . "', array('type' => 'keywords'), false);\n";
		}
		if (!empty($this->data['ContentPage']['meta_description']) || isset($layout)) {
			$str .= "echo \$html->meta('description', '" . (isset($layout) ? $layout['ContentLayout']['meta_description']:"") . " " . $this->data['ContentPage']['meta_description'] . "', array('type' => 'description'), false);\n";
		}

		if (!empty($_REQUEST["ContentLayoutId"])) {
			$str .= "\$this->layout = 'content_layout/" . $layout_name . "';";
		}

		$str .= " \n?>\n";

		$str .= $this->data['ContentPage']['content'];

		return file_put_contents($newFileStr, $str);
	}

}
?>