$(document).ready(function(){

	searchButtonClickedEventListener();

});

var searchButtonClickedEventListener = function() {
    $("#searchLink").click(function () {
        var searchStr = '';
        if ($('#LanguageId2 option:selected').val() != '') {
        	searchStr = 'language_id:' + $('#LanguageId2 option:selected').val();
        }
        if ($('#CarrierTypeId2 option:selected').val() != 0) {
        	if (searchStr != '') {
        		searchStr += '/';
        	}
        	searchStr += 'carrier_type_id:' + $('#CarrierTypeId2 option:selected').val();
        }
        if ($('#alias').val() != '') {
        	if (searchStr != '') {
        		searchStr += '/';
        	}
        	searchStr += 'alias:' + $('#alias').val();
        }

        if (searchStr == '') {
            var action = '/app_admin/content_page/index';
        } else {
            var action = '/app_admin/content_page/index/'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}