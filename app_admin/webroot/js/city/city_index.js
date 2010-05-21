$(document).ready(function(){

	searchButtonClickedEventListener();

});


var searchButtonClickedEventListener = function() {

	$("#searchLink").click(function () {
        var searchStr = '';
        if ($('#CountryId option:selected').val() != '') {
        	searchStr = 'country_id:' + $('#CountryId option:selected').val();
        }
        if ($('#code').val() != '') {
        	if (searchStr != '') {
        		searchStr += '/';
        	}
        	searchStr += 'code:' + $('#code').val();
        }

        if (searchStr == '') {
            var action = '/hotel/app_admin/city/index';
        } else {
            var action = '/hotel/app_admin/city/index/'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}