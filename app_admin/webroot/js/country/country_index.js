$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {
    $(".searchBtn").click(function () {
        var searchStr = $("#CountryIsoCodeA2").val();

        if (searchStr == '') {
            var action = '/hotel/app_admin/country/index';
        } else {
            var action = '/hotel/app_admin/country/index/iso_code_a2:'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}