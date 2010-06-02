<?php
class ContentDocumentLanguage extends AppModel {

	var $name = 'ContentDocumentLanguage';

//  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `content_document_id` int(11) unsigned NOT NULL,
//  `branch_no` int(11) unsigned NOT NULL,
//  `language_id` int(11) unsigned NOT NULL,
//  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `content` text COLLATE utf8_unicode_ci NOT NULL,
//  `created` datetime NOT NULL,
//  `updated` datetime NOT NULL,
//  `deleted` datetime DEFAULT NULL,

	var $validate =
	array(
		'title' =>
			array(
			'maxLength' =>
				array(
					'rule' => array('maxLength', '255', ),
				),
			),
		'branch_no' =>
			array(
			'notEmpty' =>
				array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'last' => true,
				),
			'numeric' =>
				array(
					'rule' => array('numeric', ),
					'last' => true,
				),
			),
		);
}
?>