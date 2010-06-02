<?php
class Condition3 extends AppModel {

	var $name = 'Condition3';
	var $useTable = false;

	var $_schema = array(
		'keyword'			=> array('type'=>'string', 'length'=>255),
		'area_id'			=> array('type'=>'integer'),
		'country_id'		=> array('type'=>'integer'),
		'state_id'			=> array('type'=>'integer'),
		'city_id'			=> array('type'=>'integer'),
		'display_stat'		=> array('type'=>'integer'),
		'hotel_agent_id'	=> array('type'=>'integer'),
		'image_exists'		=> array('type'=>'integer'),
		'created_from'		=> array('type'=>'datetime'),
		'created_to'		=> array('type'=>'datetime'),
	);


	var $validate =
	array(
		'keyword' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'created_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
				),
			),
		'created_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
				),
			),
		);
}
?>