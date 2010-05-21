<?php
class MediaController extends AppController {
	var $name = "Media";
	var $needAuth = true;	// ログイン必須のフラグ
	var $components = array('ModelUtil', 'ListGetter', );
	var $uses = array('Media', );
	var $helpers = array('Number', );

	function index() {
		$media = $this->Media->find('all', array('conditions' => array('Media.deleted is null')));

		$this->set('media_list', $media);
	}

	function edit($media_id = null) {
		$media = null;
		if (is_null($media_id)) {
			$media = $this->ModelUtil->getSkeleton($this->Media);
		} else {
			$media = $this->Media->find('first', array('conditions' => array('Media.id' => $media_id, 'Media.deleted is null')));
			$media = $media['Media'];
		}

		$this->set('media', $media);
	}

	function save() {
		if (!empty($this->data)) {
			$this->Media->set($this->data);
			$whitelist = array_keys($this->Media->getColumnTypes());
			if (empty($this->data['Media']['price'])) {
				$this->data['Media']['price'] = 0;
			}
			if ($this->Media->save($this->data, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true))) {
				$this->redirect('/media/index/');
			} else {
				$this->set('media', $this->data['Media']);
				$this->render('/media/edit/');
			}
		}
	}

	function delete($media_id = null) {
		$media = $this->Media->find('first', array('conditions' => array('Media.id' => $media_id, 'Media.deleted is null')));

		if (!empty($media)) {
			$media['Media']['deleted'] = date("Y-m-d H:i:s");
			$whitelist = array_keys($this->Media->getColumnTypes());
			$this->Media->save($media, array('validate' => true, 'fieldList' => $whitelist, 'callbacks' => true));
			$this->redirect('/media/index/');
		}
	}
}

?>