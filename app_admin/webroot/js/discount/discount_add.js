$(document).ready(function(){

	$('#DiscountStartDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#DiscountStartDate').datepicker('option', {dateFormat: 'yy-mm-dd'});

	$('#DiscountEndDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#DiscountEndDate').datepicker('option', {dateFormat: 'yy-mm-dd'});

});
