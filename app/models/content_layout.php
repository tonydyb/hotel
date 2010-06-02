<?php
class ContentLayout extends AppModel {

	var $name = 'ContentLayout';
	var $validate = array(
		'language_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'carrier_type_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'name' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'last' => true,
				),
		),
		'alias' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'last' => true,
				),
		),
		'title' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'last' => true,
				),
		)
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