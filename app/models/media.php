<?php
class Media extends AppModel {

	var $name = 'Media';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `sub_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `sub_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `recv_param` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `send_param` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `send_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `price` decimal(15,4) NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,


	var $validate =
	array(
		'code' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'name' =>
			array(
				'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'required' => true,
				),
			),
		'sub_code' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'sub_name' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'recv_param' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'send_param' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'send_url' =>
			array(
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'price' =>
			array(
				'decimal' =>
				array(
					'rule' => array('decimal_check', 4),
				),
			),
		);

	function decimal_check($num, $places = 4) {
		foreach ($num as $data) {
			if (empty($data)) {
				return true;
			}

			$regex = '/^[-+]?[0-9]*\.?[0-9]{0,'.$places.'}$/';
			return preg_match($regex, $data);
		}
	}

}
?>