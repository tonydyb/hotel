<?php
class Condition extends AppModel {

	var $name = 'Condition';
	var $useTable = false;

	var $_schema = array(
		'first_name'			=> array('type'=>'string', 'length'=>255),
		'last_name'				=> array('type'=>'string', 'length'=>255),
		'customer_type_id'		=> array('type'=>'integer'),
		'media_id'				=> array('type'=>'integer'),
		'email'					=> array('type'=>'string', 'length'=>255),
		'email_mobile'			=> array('type'=>'string', 'length'=>255),
		'carrier_type_id'		=> array('type'=>'integer'),
		'mail_magazine_type_id'	=> array('type'=>'integer'),
		'addr_country_id'		=> array('type'=>'integer'),
		'country_id'			=> array('type'=>'integer'),
		'day_from'				=> array('type'=>'datetime'),
		'day_to'				=> array('type'=>'datetime'),
	);


	var $validate =
	array(
		'first_name' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'last_name' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
//		'customer_type_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
//		'media_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
		'email' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'email_mobile' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
//		'carrier_type_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
//		'mail_magazine_type_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
//		'addr_country_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
//		'country_id' =>
//			array(
//				'valid_number' =>
//				array(
//					'rule' => VALID_NUMBER,
//					'required' => true,
//				),
//			),
		'day_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date', 'ymd'),
					'required' => true,
				),
			),
		'day_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date', 'ymd'),
					'required' => true,
				),
			),
		);

}
?>