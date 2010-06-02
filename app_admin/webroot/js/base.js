//registの使い方
//<?php $message = __('保存してよろしいですか。', true); ?>
//<?php echo $form->button(__('登録',true), array('div' => 'false', 'onclick' => 'regist_by_name(\'form1\', \'/app_admin/customer_user/save\', \'' . $message . '\');')); ?>

function regist_by_name(formname, target, message) {
	if(window.confirm(message)) {
		document.forms[formname].action = target;
		document.forms[formname].method ='post';
		document.forms[formname].submit();
	}
}

function regist(target, message) {
	if(window.confirm(message)) {
		document.forms[0].action = target;
		document.forms[0].method ='post';
		document.forms[0].submit();
	}
}

function regist_no_message(formname, target) {
	document.forms[formname].action = target;
	document.forms[formname].method ='post';
	document.forms[formname].submit();
}

// app_admin/request/editで使用
function new_window_submit(formname, target) {
	var select = document.getElementById('MailTemplateId').value;

	if (select > 0) {
		var win = window.open("about:blank", "new_window", "WindowStyle");
		document.forms[formname].target = "new_window";
		document.forms[formname].action = target;
		document.forms[formname].submit();
	}
}

// app_admin/request/mailで使用
function new_window_close() {
	if(document.all){
		window.opener = true;
	}
	window.close();
}

// app_admin/request/editで使用
function clear_tgt_customer_data(target_no1, target_no2) {
	var tgt1 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "FirstName";
	var tgt2 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "LastName";
	var tgt3 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "Age";
	var tgt4 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "GenderId";
	var tgt5 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "Adult";
	var tgt6 = "RequestHotelCustomerUser" + target_no1 + "" + target_no2 + "Leader";

	document.getElementById(tgt1).value = "";
	document.getElementById(tgt2).value = "";
	document.getElementById(tgt3).value = "";
	document.getElementById(tgt4).selectedIndex  = 0;
	document.getElementById(tgt5).selectedIndex  = 0;
	document.getElementById(tgt6).selectedIndex  = 0;
}

// app_admin/request/editで使用
function copy_send_email_address(tgt_mobile) {
	if (tgt_mobile) {
		document.getElementById('MailTemplateToEmail').value = window.opener.document.getElementById('RequestEmailMobile').value;
	} else {
		document.getElementById('MailTemplateToEmail').value = window.opener.document.getElementById('RequestEmail').value;
	}
}

// app_admin/content_document/indexで使用
function new_window_submit2(formname, target) {
	var win = window.open("about:blank", "new_window", "WindowStyle");
	document.forms[formname].target = "new_window";
	document.forms[formname].action = target;
	document.forms[formname].submit();
}

