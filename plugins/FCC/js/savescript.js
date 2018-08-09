jQuery(function($){

	$( "#target" ).submit(function( event ) {
    
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: { action: 'save_footer_content' , content: tinyMCE.activeEditor.getContent() },

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
