$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $("#searchLink").click(function () {
        var searchStr = $("#iso_code_a2").val();

        if (searchStr == '') {
            var action = '/app_admin/country/index';
        } else {
            var action = '/app_admin/country/index/iso_code_a2:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}