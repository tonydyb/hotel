$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#AreaCode").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/area/index';
        } else {
            var action = '/hotel/app_admin/area/index/code:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}