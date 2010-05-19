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
function clear_tgt_customer_data(target_no) {
	var tgt1 = "RequestDataRequestHotelCustomerUser" + target_no + "FirstName";
	var tgt2 = "RequestDataRequestHotelCustomerUser" + target_no + "LastName";
	var tgt3 = "RequestDataRequestHotelCustomerUser" + target_no + "Age";
	var tgt4 = "RequestDataRequestHotelCustomerUser" + target_no + "GenderId";
	var tgt5 = "RequestDataRequestHotelCustomerUser" + target_no + "Adult";

	document.getElementById(tgt1).value = "";
	document.getElementById(tgt2).value = "";
	document.getElementById(tgt3).value = "";
	document.getElementById(tgt4).selectedIndex  = 0;
	document.getElementById(tgt5).selectedIndex  = 0;
}

//app_admin/request/editで使用
function copy_send_email_address(tgt_mobile) {
	if (tgt_mobile) {
		document.getElementById('RequestDataMailTemplateToEmail').value = document.getElementById('RequestDataRequestEmailMobile').value;
	} else {
		document.getElementById('RequestDataMailTemplateToEmail').value = document.getElementById('RequestDataRequestEmail').value;
	}
}

