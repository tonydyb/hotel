<?php
class Country extends AppModel {

	var $name = 'Country';
	var $validate = array(
		'iso_code_n' => array(
			'numeric' =>
				array(
					'rule' => 'numeric',
					'last' => true,
				),
		),
		'iso_code_a2' => array(
            'alphaNumeric' => array(
					'rule' => 'alphanumeric',
					'last' => true,
				),
            'length' => array(
				'rule' => array('custom', '/^[a-zA-Z]{2,2}$/i'),
				'message' => 'Only letters, 2 characters'
				)
        ),
		'iso_code_a3' => array(
            'alphaNumeric' => array(
					'rule' => 'alphanumeric',
					'last' => true,
				),
            'length' => array(
				'rule' => array('custom', '/^[a-zA-Z]{3,3}$/i'),
				'message' => 'Only letters, 3 characters'
				)
        )

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'CountryLanguage' => array(
			'className' => 'CountryLanguage',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CustomerUser' => array(
			'className' => 'CustomerUser',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Hotel' => array(
			'className' => 'Hotel',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Request' => array(
			'className' => 'Request',
			'foreignKey' => 'country_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'country_id',
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