<?php
class Discount extends AppModel {

	var $name = 'Discount';
	var $validate = array(
		'name' => array('notempty'),
		'discount_item_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'discount_item_val' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'discount_type_id' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'amount' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'sort' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'start_date' => array('date'),
		'end_date' => array('date')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'DiscountItem' => array(
			'className' => 'DiscountItem',
			'foreignKey' => 'discount_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DiscountType' => array(
			'className' => 'DiscountType',
			'foreignKey' => 'discount_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>