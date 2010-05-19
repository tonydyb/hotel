$(document).ready(function(){

	searchButtonClickedEventListener();

	/*$("a.deleteLink").click(function () {
		jConfirm('Are you sure?', 'Confirmation');
    });*/
});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#ContentBlockAlias").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/content_block/index';
        } else {
            var action = '/hotel/app_admin/content_block/index/alias:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}