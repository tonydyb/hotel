$(document).ready(function(){

	$(".listTable tbody.content").sortable({
		axis : 'y',
		cursor: 'crosshair',
		disabled: true,
		opacity: 0.8,
	});

	//$(".listTable tbody.content").disableSelection();

	$(".listTable tbody.content").bind("sortchange", function(event, ui) {
		if ($("#submitSortBtn").attr("disabled") == true) {
			$("#submitSortBtn").attr("disabled", false);
		}
	});

	$(".listTable tbody.content").bind("update", function(element, ui) {

	});

	submitSortButtonClickedEventListener();
	enableSortButtonClickedEventListener();

});

var submitSortButtonClickedEventListener = function() {
    $("#submitSortBtn").click(function () {
    	var data = $(".listTable tbody.content").sortable("serialize");
    	var action = '/app_admin/discount/saveSort?'+data;
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}

var enableSortButtonClickedEventListener = function() {
    $("#enableSortBtn").click(function () {
    	var disabled = $(".listTable tbody.content").sortable("option", "disabled");
		if ($("#enableSortBtn").val() == 0) {
			$("#enableSortBtn").val(1);
			$("#enableSortBtn").text('Disable sort');
			$(".listTable tbody.content").sortable("option", "disabled", false);
		} else {
			$("#enableSortBtn").val(0);
			$("#enableSortBtn").text('Enable sort');
			$(".listTable tbody.content").sortable("option", "disabled", true);
		}
    });
}
