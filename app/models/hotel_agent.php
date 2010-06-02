<?php
class HotelAgent extends AppModel {

	var $name = 'HotelAgent';
	var $validate = array(
		'name' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'last' => true,
				),
		),
		'code' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'account' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'password' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'email' => array(
			'email' =>
				array(
					'rule' => 'email',
				),
		),
		'tel' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'url' => array(
			'url' =>
				array(
					'rule' => 'url',
				),
		),
		'commission' => array(
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
		'percent' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'amount_max' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'percent_max' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
				),
		),
		'fax' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'postcode' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'country_id' => array('numeric'),
		'addr_1' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'addr_2' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		),
		'addr_3' => array(
			'notEmpty' =>
				array(
					'rule' => 'notEmpty',
				),
		)
	);

	var $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>