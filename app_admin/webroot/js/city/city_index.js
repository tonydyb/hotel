$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#CityCode").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/city/index';
        } else {
            var action = '/hotel/app_admin/city/index/code:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}