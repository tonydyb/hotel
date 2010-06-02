$(document).ready(function(){

	submitButtonClickedEventListener();
});


var submitButtonClickedEventListener = function() {
    $(".submitBtn").click(function () {
        var action = '/app_admin/content_page/edit';

        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}