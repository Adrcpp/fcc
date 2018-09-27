( function( $ ) {
    "use strict";
    $( document ).ready(function() {
        //console.log( "ready!" );
    $('#nlt').submit(function (e) {
        var $form = $(this);
        //console.log($form);
        e.preventDefault();

        if ($('#checkbox-nlt').is(':checked')) {
            //console.log('checked');
            register($form);
        }
    });

    function register($form) {
        // console.log("register ..");
        var $data =
        {
            action: "newsletter",
            url: 'https://frenchcheesecorner.us19.list-manage.com/subscribe/post-json?u=566471b2380f7022f8b20cbcf&id=c35fa349d1',
            EMAIL: $('#mce-EMAIL').val(),
            ZIP : $('#mce-zip').val()
        };

        var test = $.ajax({
            type: "post",
            url: WPURLS.siteurl,
            data: $data,

        });
        test.done(function( data, textStatus, jqXHR ) {
            // console.log("done ..");
            // console.log(jqXHR.responseText);
            var response = jQuery.parseJSON( jqXHR.responseText );

            if (response.result == "error") {
                $('#error').append('<div class="alert alert-danger alert-dismissible" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                + response.msg + '</div>');
            } else {
                $('#error').append('<div class="alert alert-success alert-dismissible" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                + response.msg + '</div>');
            }

            $('.show-msg').show();

        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            // console.log("error ..");
            // console.log(jqXHR);
            // console.log(textStatus);
            // console.log(errorThrown);
            $('#error').append('<div class="alert alert-danger alert-dismissible" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>An error occured, please try again ...</div>');
            $('.show-msg').show();
        });
    }
});
})( jQuery );
