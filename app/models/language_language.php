<?php
class LanguageLanguage extends AppModel {

	var $name = 'LanguageLanguage';
	var $validate = array(
		'language_id' => array('numeric'),
		'iso_language_id' => array('numeric'),
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>