$(document).ready(function(){

	var dt = $('#startDate').val();
	var dt2 = $('#endDate').val();

	$('#startDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#startDate').datepicker('option', {dateFormat: 'yy-mm-dd'});
	if(dt) {
		$('#startDate').datepicker('setDate', dt);
	}

	$('#endDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#endDate').datepicker('option', {dateFormat: 'yy-mm-dd'});
	if(dt2) {
		$('#endDate').datepicker('setDate', dt2);
	}

});
