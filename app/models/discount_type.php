<?php
class DiscountType extends AppModel {

	var $name = 'DiscountType';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Discount' => array(
			'className' => 'Discount',
			'foreignKey' => 'discount_type_id',
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