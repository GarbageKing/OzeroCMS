$(document).ready(function(){

	new ClipboardJS('.copy-stuff');

	$('form #tags').change(function(){ 
		var appender;
		if($('form #tag-string').val().trim().length > 0){ console.log($('form #tag-string').val());
			appender = ', ';
		} else {
			appender = '';
		}
		if($('form #tags').val() != '')
		$('form #tag-string').val($('form #tag-string').val() + appender + $('form #tags option:selected').text());
	});

	$('#body').summernote({        
        tabsize: 2,
        height: 500,
        callbacks : {
	        onImageUpload: function(files, editor, welEditable) { 
	            sendFile(files[0], editor, welEditable);
	        }
    	}
     });

	function sendFile(file, editor, welEditable) { 
        data = new FormData();
        data.append("file", file);
        $.ajax({
        	headers: {
		        'X-CSRF-Token': globals.csrfToken
		    },
            data: data,
            type: "POST",
            url: globals.base_url+"articles/upload_files",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) { 
            	var image = $('<img>').attr('src', globals.base_url + 'webroot/uploads/' + url);
            	$('#body').summernote("insertNode", image[0]);            	
            }
        });
    }

    $('button.answer-comment-id.btn').click(function(){

    	var answer_id = $(this).data('id');
    	var answer_user = $(this).data('user');
    	var the_form = $('#comment_body').closest('form');

    	the_form.find('input[name="answers"]').val(answer_id);
    	$('.answer-user-name').remove();
    	the_form.prepend('<span class="answer-user-name">Answering '+answer_user+' <span class="answer-user-name-del"><i class="fas fa-times-circle"></i></span></span>');

    });

    $('body').on('click', '.answer-user-name-del', function(){
    	$(this).parent().remove();
    	$('#comment_body').closest('form').find('input[name="answers"]').val('');
    });

    $('#sort_articles').change(function(){
        window.location.href = window.location.href.split('?')[0]+'?sort=created&direction='+$('#sort_articles').val();
    });

    if($(window.location.href.indexOf("sort=created&direction") > -1)){
        var direction = window.location.href.split('sort=created&direction=')[1];

        $('#sort_articles option').removeAttr('selected');
        $('#sort_articles').val(direction);
    }
});