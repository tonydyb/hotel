<?php
class ContentLayout extends AppModel {

	var $name = 'ContentLayout';
	var $validate = array(
		'language_id' => array('numeric'),
		'carrier_type_id' => array('numeric'),
		'name' => array('notempty'),
		'alias' => array('notempty'),
		'title' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CarrierType' => array(
			'className' => 'CarrierType',
			'foreignKey' => 'carrier_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ContentPage' => array(
			'className' => 'ContentPage',
			'foreignKey' => 'content_layout_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>