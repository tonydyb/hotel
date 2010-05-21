<?php
class ContentLayoutController extends AppController {

	var $name = 'ContentLayout';
	var $helpers = array('Html', 'Form', 'Javascript','Ajax');
	var $uses = array('ContentLayout', 'ContentPage', 'Page', 'Language');
	var $components = array('ModelUtil', 'RequestHandler', 'SelectGetter');

	/**
	 * コンテント　レイアウト一覧
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

		$cond = $this->Page->getSqlListContentLayout($this->getIsoId(), $language_id, $carrier_type_id, $alias);
		$this->paginate = array(
				'conditions'=>$cond,
				'order'=>'ContentLayout.name, ContentLayout.alias, ContentLayout.carrier_type_id, ContentLayout.language_id, ContentLayout.id ASC',
				'limit'=>VIEW_MAX,
				'recursive'=>0
			);

		$this->set('contentLayouts', $this->paginate('Page'));
	}

	/**
	 * コンテント　レイアウト新規登録
	 */
	function add() {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
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
					//ファイルに書き込み
					if(!$this->__writeFile(false)) {
						$this->Session->setFlash(__('Wirte ContentLayout file failed', true));
					} else {
						$this->Session->setFlash(__('The ContentLayout has been saved', true));
					}

					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The ContentLayout could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
				}
			} else {
				$this->Session->setFlash(__('The ContentLayout is already exist.', true), 'default', array('class' => 'error'));
			}
		}
	}

	/**
	 * コンテント　レイアウト編集
	 * @param $id
	 */
	function edit($id = null) {
		$this->set('languages', $this->SelectGetter->getLanguageMin());
		$this->set('carrierTypes', $this->SelectGetter->getCarrierType());

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ContentLayout', true));
			$this->redirect(array('action' => 'index'));
		}
		//既に削除されたのレコードは編集できません
//		if(!$this->ContentLayout->find('count', array( 'conditions' => array('ContentLayout.id' => !$id ? $this->data['ContentLayout']['id']:$id, 'ContentLayout.deleted' => NULL)))) {
//			$this->Session->setFlash(__('Invalid ContentLayout', true), 'default', array('class' => 'error'));
//			$this->redirect(array('action' => 'index'));
//		}

		if (!empty($this->data)) {
			$this->ContentLayout->set(
				array(  'language_id' => $_REQUEST["LanguageId"],
						'carrier_type_id' => $_REQUEST["CarrierTypeId"]
				)
			);
			if ($this->ContentLayout->save($this->data)) {
				//ファイルに書き込み
				if(!$this->__writeFile(true)) {
					$this->Session->setFlash(__('Wirte ContentLayout file failed', true));
				} else {
					$this->Session->setFlash(__('The ContentLayout has been saved', true));
				}

				$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The ContentLayout could not be saved. Please, try again.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentLayout->read(null, $id);
		}
	}

	/**
	 * コンテント　レイアウト削除
	 * @param $id
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ContentLayout', true));
			$this->redirect(array('action' => 'index'));
		}
		$cnt = $this->ContentPage->find('count', array( 'conditions' => array('content_layout_id' => $id)));
		if (!$cnt) {
			if ($this->ContentLayout->advDel($id)) {
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

	/**
	 * コンテントctpファイル作成
	 */
	function __writeFile($isEdit = true) {
		$rootPath = CONTENT_LAYOUT_ROOT_PATH;

		$iso_code = $this->getIsoCode($_REQUEST["LanguageId"]);
		$carrier_name = $this->getCarrierCode($_REQUEST["CarrierTypeId"]);
		$file_name = $this->data['ContentLayout']['alias'];

		$fileStr = $rootPath . $iso_code . "/" . $carrier_name . "/" . $file_name . ".ctp";
		$path =  $rootPath . $iso_code . "/" . $carrier_name;

		if ($isEdit) {
			//旧ファイルを削除
			$oldFileStr = $rootPath . $this->getIsoCode($this->data['ContentLayout']["oldLanguageId"]) . "/" . $this->getCarrierCode($this->data['ContentLayout']["oldCarrierTypeId"]) . "/" . $this->data['ContentLayout']["oldAlias"] . ".ctp";
			if(file_exists($oldFileStr)) {
				unlink($oldFileStr);
			}

			if($oldFileStr != $fileStr) {
				//すべてこのlayoutを使ってるのpageを変更
				$contentPages = $this->ContentPage->find('all', array( 'conditions' => array('content_layout_id' => $this->data['ContentLayout']["id"])));
				foreach($contentPages as $contentPage) {
					$this->__reBuildPageFile($contentPage);
				}
			}
		}

		if(!file_exists($path)) {
			$this->ModelUtil->mkdirRec($path);
		}

		if(file_exists($fileStr)) {
			unlink($fileStr);
		}

		touch($fileStr);

		$str = "<?php \n";
		if (!empty($this->data['ContentLayout']['title'])) {
			$str .= "\$this->pageTitle = '" . $this->data['ContentLayout']['title'] . "';\n";
		}
		if (!empty($this->data['ContentLayout']['meta_keyword'])) {
			$str .= "echo \$html->meta('keywords', '" . $this->data['ContentLayout']['meta_keyword'] . "', array('type' => 'keywords'), false);\n";
		}
		if (!empty($this->data['ContentLayout']['meta_description'])) {
			$str .= "echo \$html->meta('description', '" . $this->data['ContentLayout']['meta_description'] . "', array('type' => 'description'), false);\n";
		}
		$str .= " ?>\n";

		$str .= $this->data['ContentLayout']['content'];

		return file_put_contents($fileStr, $str);
	}

	/**
	 * コンテントページctpファイル作成
	 */
	function __reBuildPageFile($contentPage) {
		$pageRootPath = CONTENT_PAGE_ROOT_PATH;

		$iso_code1 = $this->getIsoCode($contentPage['ContentPage']['language_id']);
		$carrier_name1 = $this->getCarrierCode($contentPage['ContentPage']['carrier_type_id']);
		$file_name1 = $contentPage['ContentPage']['alias'];

		$fileStr1 = $pageRootPath . $iso_code1 . "/" . $carrier_name1 . "/" . $file_name1 . ".ctp";
		$path1 =  $pageRootPath . $iso_code1 . "/" . $carrier_name1;
		//旧ファイルを削除
		if(file_exists($fileStr1)) {
			unlink($fileStr1);
		}

		//フォルド作成
		if(!file_exists($path1)) {
			$this->ModelUtil->mkdirRec($path1);
		}

		//新コンテントctpファイル新規
		touch($fileStr1);

		$str = "<?php \n";
		if (!empty($contentPage['ContentPage']['title'])) {
			$str .= "\$this->pageTitle = '" . $contentPage['ContentPage']['title'] . "';\n";
		}
		if (!empty($contentPage['ContentPage']['meta_keyword'])) {
			$str .= "echo \$html->meta('keywords', '" . $contentPage['ContentPage']['meta_keyword'] . "', array('type' => 'keywords'), false);\n";
		}
		if (!empty($contentPage['ContentPage']['meta_description'])) {
			$str .= "echo \$html->meta('description', '" . $contentPage['ContentPage']['meta_description'] . "', array('type' => 'description'), false);\n";
		}

		$layout = $this->ContentLayout->find('first', array( 'conditions' => array('ContentLayout.id' => $this->data['ContentLayout']["id"]), 'fields' => array('alias', 'language_id', 'carrier_type_id')));
		$layout_name = $this->getIsoCode($layout['ContentLayout']['language_id']) . "/" . $this->getCarrierCode($layout['ContentLayout']['carrier_type_id']) . "/" . $layout['ContentLayout']['alias'];
		$str .= "\$this->layout = 'content_layout/" . $layout_name . "';";

		$str .= " \n?>\n";

		$str .= $contentPage['ContentPage']['content'];

		file_put_contents($fileStr1, $str);
	}
}
?>