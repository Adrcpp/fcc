jQuery(document).ready(function( $ ) {

    $('#texture').change(function(){
        $data = { action: 'filter_product' , milk: $('#milk').val(),  texture: $('#texture').val() };
        post_ajax($data);
    });


    $('#milk').change(function(){
        $data = { action: 'filter_product' , milk: $('#milk').val(),  texture: $('#texture').val() };
        post_ajax($data);
    });

    function post_ajax($data)
    {
        $.ajax({
            url: WPURLS.siteurl,
            type: "POST",
            data: $data,

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
            $('#products').empty();
            $('#products').append(msg.result);
        })

      event.preventDefault();

    };
});
