jQuery(function($){
	/*
	 * Select/Upload image(s) event
	 */
	$('body').on('click', '.upload_image_button', function(e){
		e.preventDefault();

    		var button = $(this),
    		    custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id,
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$(button).removeClass('button').html('<img class="true_pre_image" id="img" src="' + attachment.url + '" style="max-width:95%;display:block;" />')
			.next().val(attachment.id).next().show();
		})
		.open();
	});

	/*
	 * Remove image event
	 */
	$('body').on('click', '.remove_image_button', function(){
		$(this).hide().prev().val('').prev().addClass('button').html('Upload image');
		return false;
	});

	$( "#target" ).submit(function( event ) {

		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: { action: 'upload_img' , url: $('#img').attr('src'),  id: $('#header_img').val() },

			error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            },

		}).done(function( msg ) {
			console.log("Data Saved: " + msg );
		})

	  event.preventDefault();
	});
});
