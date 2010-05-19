<?php
/* SVN FILE: $Id: app_model.php 7945 2008-12-19 02:16:01Z gwoo $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {


	/**
	 * Concatenate a field name with each validation error message in replaceValidationErrorMessagesI18n().
	 * Field name is set with gettext __()
	 *   true: Concatenate
	 *   false: not Concatenate
	 *
	 * @var boolean
	 * @access protected
	 */
	var $_withFieldName = false;
//	var $_withFieldName = true;


	/**
	 * Error messages
	 *
	 * @var array
	 * @access protected
	 */
	var $_error_messages = array();


	/**
	 * Define default validation error messages
	 * $default_error_messages can include gettext __() value.
	 *
	 * @return array
	 * @access protected
	 */
	function _getDefaultErrorMessagesI18n(){
		//Write Default Error Message
		// 参照：http://d.hatena.ne.jp/cakephper/20090727/1248691184
		$default_error_messages = array(
			'empty_invalid'		=> __('必ず入力してください。', true),
			'number_invalid'	=> __('数字で入力してください。', true),
			'email_invalid'		=> __('メールアドレスの形式が正しくありません。', true),
			'year_invalid'		=> __('日付形式(%2$s)で入力してください。', true),
			'notEmpty'			=> __('必ず入力してください。', true),
			'notSelected'		=> __('必ず選択してください。', true),
			'alphaNumeric'		=> __('半角英数字で入力してください。', true),
			'between'			=> __('%1$d文字以上%2$d文字以内の半角数字を入力してください。', true),
			'blank'				=> __('空でなければなりません。', true),
			'cc'				=> __('クレジットカード番号として正しくありません。', true),
			'comparison'		=> __('入力値%2$s%3$sを満たす値を入力してください。', true),
			'custom'			=> __('入力値が正しくありません。', true),
			'date'				=> __('入力された日付が不正です。', true),
			'decimal'			=> __('小数点第%2$d位までの半角数字を入力してください。', true),
			'email'				=> __('メールアドレスの形式が正しくありません。', true),
			'equalTo'			=> __('入力値が"%2$s"と一致しません。', true),
			'extension'			=> __('拡張子が正しくありません。', true),
			'file'				=> __('', true),	//実装されていない
			'ip'				=> __('IPアドレス形式で入力してください。', true),
			'minLength'			=> __('%2$d文字以上で入力してください', true),
			'maxLength'			=> __('%2$d文字以内で入力してください', true),
			'money'				=> __('入力値が正しくありません。', true),//通貨?
			'multiple'			=> __('', true),	//実装されていない
			'numeric'			=> __('半角数字を入力してください。', true),
			'phone'				=> __('数字とハイフン(-)しか使用できません。', true),
			'postal'			=> __('郵便番号形式で入力してください。', true),
			'range'				=> __('%2$dより大きく%3$dより小さい数字を入力してください。', true),
			'ssn'				=> __('ソーシャルセキュリティナンバー形式で入力してください。', true),
			'url'				=> __('URL形式で入力してください。', true),
			'userDefined'		=> __('入力値が正しくありません。', true),
		);

		return $default_error_messages;
	}


	/**
	 * Set validation error messages.
	 *
	 * To change default validation error messages,
	 *  set $add_error_message in each model.
	 *
	 * @param array $add_error_message
	 * @param boolean $all_change_flag
	 *    true: change all default validation error messages
	 *    false: merge $add_error_message with default validation error messages
	 * @access public
	 */
	function setErrorMessageI18n( $add_error_message = null, $all_change_flag=false ) {


		$default_error_messages = $this->_getDefaultErrorMessagesI18n();

		if( !empty( $add_error_message ) && is_array( $add_error_message ) ){
			if( $all_change_flag ){
				$default_error_messages = $add_error_message;
			}else{
				$default_error_messages = array_merge( $default_error_messages, $add_error_message );
			}
			$this->_error_messages = $default_error_messages;

		}elseif( empty($this->_error_messages)  ){
			$this->_error_messages = $default_error_messages;
		}


	}

	/**
	 * get validation error messages
	 *
	 * @return array
	 * @access protected
	 */
	function _getErrorMessageI18n(){
		return $this->_error_messages;
	}


	/**
	 * Replace validation error messages for i18n
	 *
	 * @access public
	 */
	function replaceValidationErrorMessagesI18n(){
		$this->setErrorMessageI18n();

		foreach( $this->validate as $fieldname => $ruleSet ){
			foreach( $ruleSet as $rule => $rule_info ){

				$rule_option = array();
				if(!empty($this->validate[$fieldname][$rule]['rule'])) {
					$rule_option = $this->validate[$fieldname][$rule]['rule'];
				}

				$error_message_list = $this->_getErrorMessageI18n();
				$error_message = ( array_key_exists($rule, $error_message_list ) ? $error_message_list[$rule] : null ) ;

				if( !empty( $error_message ) ) {
					$this->validate[$fieldname][$rule]['message'] = vsprintf($error_message, $rule_option);
				}elseif( !empty($this->validate[$fieldname][$rule]['message']) ){
					$this->validate[$fieldname][$rule]['message'] = __( $this->validate[$fieldname][$rule]['message'], true);
				}


				if( $this->_withFieldName && !empty($this->validate[$fieldname][$rule]['message']) ){
					$this->validate[$fieldname][$rule]['message'] = __( $fieldname ,true) . ' : ' . $this->validate[$fieldname][$rule]['message'];
				}
			}
		}
	}


	function beforeValidate(){
		$this->replaceValidationErrorMessagesI18n();
		return true;
	}

	function begin()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->begin($this);
	}

	function commit()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->commit($this);
	}

	function rollback()
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$db->rollback($this);
	}

}
?>