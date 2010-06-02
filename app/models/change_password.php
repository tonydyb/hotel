<?php
class ChangePassword extends AppModel {

	var $name = 'ChangePassword';
	var $useTable = false;

	var $_schema = array(
		'account'			=> array('type'=>'string', 'length'=>255),
		'password'			=> array('type'=>'string', 'length'=>255),
		'old_password'		=> array('type'=>'string', 'length'=>255),
		'new_password1'		=> array('type'=>'string', 'length'=>255),
		'new_password2'		=> array('type'=>'string', 'length'=>255),
	);


	var $validate =
	array(
		'password' =>
			array(
				'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => ALPHA_NUMERIC,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
				'confirmPassword' =>
				array(
					'rule' => array('confirmFields', 'old_password'),
				),
			),
		'new_password1' =>
			array(
				'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => ALPHA_NUMERIC,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'new_password2' =>
			array(
				'notEmpty' =>
				array(
					'rule' => 'notEmpty',
					'required' => true,
					'last' => true,
				),
				'alphaNumeric' =>
				array(
					'rule' => ALPHA_NUMERIC,
					'last' => true,
				),
				'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
					'last' => true,
				),
				'confirmPassword' =>
				array(
					'rule' => array('confirmFields', 'new_password1'),
				),
			),
	);

	function confirmFields($data, $target) {
		$source = '';
		if (isset($target)) {
			$source = array_shift($data);
		}
		return $source == $this->data[$this->name][$target];
	}
}
?>