<?php
class Condition2 extends AppModel {

	var $name = 'Condition2';
	var $useTable = false;

	var $_schema = array(
		'request_date_from'		=> array('type'=>'datetime'),
		'request_date_to'		=> array('type'=>'datetime'),
		'fix_date_from'			=> array('type'=>'datetime'),
		'fix_date_to'			=> array('type'=>'datetime'),
		'checkin_from'			=> array('type'=>'datetime'),
		'checkin_to'			=> array('type'=>'datetime'),
		'checkout_from'			=> array('type'=>'datetime'),
		'checkout_to'			=> array('type'=>'datetime'),
		'limit_date_from'		=> array('type'=>'datetime'),
		'limit_date_to'			=> array('type'=>'datetime'),

		'keyword'				=> array('type'=>'string', 'length'=>255),
		'price'					=> array('type'=>'decimal'),
		'area_id'				=> array('type'=>'integer'),
		'country_id'			=> array('type'=>'integer'),
		'state_id'				=> array('type'=>'integer'),
		'city_id'				=> array('type'=>'integer'),

		'admin_user_id'			=> array('type'=>'integer'),
		'hotel_agent_id'		=> array('type'=>'integer'),
		'request_stat_id'		=> array('type'=>'integer'),
		'request_payment_id'	=> array('type'=>'integer'),
		'media_id'				=> array('type'=>'integer'),

	);


	var $validate =
	array(
		'price' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '16', ),
//					'required' => true,
				),
				'decimal' =>
				array(
					'rule' => array('decimal_check', 4),
//					'required' => true,
				),
			),
		'keyword' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
//					'required' => true,
				),
			),
		'request_date_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'request_date_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'fix_date_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'fix_date_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'checkin_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'checkin_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'checkout_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'checkout_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'limit_date_from' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
		'limit_date_to' =>
			array(
				'date' =>
				array(
					'rule' => array('date_check', 'Ymd'),
//					'required' => true,
				),
			),
	);

	function decimal_check($num, $places = 4) {
		foreach ($num as $data) {
			if (empty($data)) {
				return true;
			}

			$regex = '/^[-+]?[0-9]*\.?[0-9]{0,'.$places.'}$/';
			return ereg($regex, $data);
		}
	}

	function date_check($datetime, $format = 'Ymd') {
		foreach ($datetime as $data) {
			if (empty($datetime)) {
				return true;
			}

			$tmpdate = $this->toArray($data);
			return checkdate($tmpdate['month'], $tmpdate['day'], $tmpdate['year']);
		}
	}

	function toArray($date = null, $isNullOK = false) {
		$keys = array('year','month','day','hour','min','sec');

		if (empty($date) && !$isNullOK) {
			$date = date("Y-m-d H:i:s");
		} else if(empty($date) && $isNullOK) {
			return array_combine($keys, array('','','','','',''));
		}

		$values = sscanf($date, '%d-%d-%d %d:%d:%d');
		return array_combine($keys, $values);
	}
}
?>