$(document).ready(function(){

	submitButtonClickedEventListener();
});


var submitButtonClickedEventListener = function() {
    $(".submitBtn").click(function () {
        var action = '/app_admin/hotel_agent/add';

        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}