$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#ContentLayoutAlias").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/content_layout/index';
        } else {
            var action = '/hotel/app_admin/content_layout/index/alias:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}