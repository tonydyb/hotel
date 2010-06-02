$(document).ready(function(){

	var dt = $('#DiscountStartDate').val();
	var dt2 = $('#DiscountEndDate').val();

	$('#DiscountEndDate').datepicker({
		changeMonth: true,
		changeYear: true
	});
	$('#DiscountStartDate').datepicker({
		changeMonth: true,
		changeYear: true
	});

	$.datepicker.setDefaults($.datepicker.regional['']);
	if ($('#viewIso').val() == 'ja') {
		$('#DiscountStartDate').datepicker('option', $.datepicker.regional['ja']);
		$('#DiscountEndDate').datepicker('option', $.datepicker.regional['ja']);
	} else if ($('#viewIso').val() == 'zh') {
		$('#DiscountStartDate').datepicker('option', $.datepicker.regional['zh-CN']);
		$('#DiscountEndDate').datepicker('option', $.datepicker.regional['zh-CN']);
	} else if ($('#viewIso').val() == 'zh-tw') {
		$('#DiscountStartDate').datepicker('option', $.datepicker.regional['zh-TW']);
		$('#DiscountEndDate').datepicker('option', $.datepicker.regional['zh-TW']);
	}

	$('#DiscountStartDate').datepicker('option', {dateFormat: 'yy-mm-dd'});
	$('#DiscountEndDate').datepicker('option', {dateFormat: 'yy-mm-dd'});

	var minDate = $('#DiscountStartDate').datepicker( "option", "minDate" );
	$('#DiscountStartDate').datepicker( "option", "minDate", new Date(2009, 1 - 1, 1) );

	var maxDate = $('#DiscountStartDate').datepicker( "option", "maxDate" );
	$('#DiscountStartDate').datepicker( "option", "maxDate", '+5y' );

	var minDate = $('#DiscountEndDate').datepicker( "option", "minDate" );
	$('#DiscountEndDate').datepicker( "option", "minDate", new Date(2009, 1 - 1, 1) );

	var maxDate = $('#DiscountEndDate').datepicker( "option", "maxDate" );
	$('#DiscountEndDate').datepicker( "option", "maxDate", '+5y' );

	if(dt) {
		$('#DiscountStartDate').datepicker('setDate', dt);
	}
	if(dt2) {
		$('#DiscountEndDate').datepicker('setDate', dt2);
	}
});
