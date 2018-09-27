( function( $ ) {
    "use strict";
    $( document ).ready(function() {
        //console.log( "ready!" );
    $('#contact').submit(function (e) {
        var $form = $(this);
        //console.log($form);
        e.preventDefault();
        sendMail($form);
    });

    function sendMail($form) {
        // console.log("register ..");
        var $data =
        {
            action: "send_mail",
            name: $('#name').val(),
            email: $('#email').val(),
            message : $('#message').val()
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

            $('#error').append('<div class="alert alert-danger alert-dismissible" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>An error occured, please try again ...</div>');
            $('.show-msg').show();
        });
    }
});
})( jQuery );
