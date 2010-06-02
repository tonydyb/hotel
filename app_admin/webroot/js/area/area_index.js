$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $("#searchLink").click(function () {
        var searchStr = $("#code").val();

        if (searchStr == '') {
            var action = '/app_admin/area/index';
        } else {
            var action = '/app_admin/area/index/code:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}