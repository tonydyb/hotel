$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#ContentPageAlias").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/content_page/index';
        } else {
            var action = '/hotel/app_admin/content_page/index/alias:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}