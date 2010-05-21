<?php
class HotelAgent extends AppModel {

	var $name = 'HotelAgent';
	var $validate = array(
		'name' => array('notempty'),
		'code' => array('notempty'),
		'account' => array('notempty'),
		'password' => array('notempty'),
		'email' => array('email'),
		'tel' => array('phone'),
		'url' => array('url'),
		'commission' => array('decimal'),
		'amount' => array('decimal'),
		'percent' => array('decimal'),
		'amount_max' => array('decimal'),
		'percent_max' => array('decimal'),
		'fax' => array('notempty'),
		'postcode' => array('postal'),
		'addr_country_id' => array('numeric'),
		'addr_1' => array('notempty'),
		'addr_2' => array('notempty'),
		'addr_3' => array('notempty')
	);

}
?>