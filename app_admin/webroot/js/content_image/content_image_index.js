$(document).ready(function(){

	uploadClickedEventListener();
	searchButtonClickedEventListener();
});


var uploadClickedEventListener = function() {
	new AjaxUpload('uploadLink', {
        action: '/app_admin/content_image/upload',
		data : {
			'key1' : "This data won't",
			'key2' : "be send because",
			'key3' : "we will overwrite it"
		},
		//responseType: 'json',
		onSubmit : function(file , ext){
            // Allow only images. You should add security check on the server-side.
			if (ext && /^(jpg|png|jpeg|gif|JPG|JPEG|PNG|GIF)$/.test(ext)){
				/* Setting data */
				this.setData({
					'LanguageId': $('#LanguageId option:selected').val(),
					'CarrierTypeId': $('#CarrierTypeId option:selected').val()
				});
				$('#upload .text').text('Uploading ' + file);
			} else {
				// extension is not allowed
				$('#upload .text').text('Error: only jpg|png|gif images are allowed');
				// cancel upload
				return false;
			}
		},
		onComplete : function(file, response){
			/*var str = response.split("##");
			$('#upload .text').text(response);

			#('.listTable').append();

			var str1 = $('#counter').text().split(" ");
			$('#counter').text(str1[0] + ' ' + (parseInt(str1[1])+1) + ' ' +str1[2]);*/
			window.location.replace("/app_admin/content_image/index");
		}
	});
}

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
            var action = '/app_admin/content_image/index';
        } else {
            var action = '/app_admin/content_image/index/'+searchStr;
        }
        $('form')
            .attr('action', action)
            .attr('method', 'POST')
            .submit();
        return false;
    });
}