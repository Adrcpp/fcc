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
            $('#cheese-count').empty();
            $('#products').append(msg.result);

            if (msg.count > 1) {
                $count = msg.count +" cheeses for you.";
            } else {
                $count = msg.count + " cheese for you.";
            }

            $('#cheese-count').append("<div class='border-result'><p class='result-filter'> We have " + $count +" </p> </div>");
            $('#cheese-count').show();
        })

      event.preventDefault();

    };
});

jQuery(document).ready(function($){
        // This button will increment the value
        $(document).on("click", '.qtyplus', function(e){

            console.log("click");
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('field');
            // Get its current value
            var input = $(this).parent().parent().children('.input-q');
            var currentVal = parseInt($(input).val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment only if value is < 20
                if (currentVal < 20)
                {
                  $(input).val(currentVal + 1);
                  $('.qtyminus').val('-').removeAttr('style');
                }
                else
                {
                    $('.qtyplus').val('+').css('color','#aaa');
                    $('.qtyplus').val('+').css('cursor','not-allowed');
                }
            } else {
                // Otherwise put a 0 there
                $(input).val(1);

            }
        });
    // This button will decrement the value till 0
    $(document).on("click", '.qtyminus', function(e) {
        console.log("click");

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var input = $(this).parent().parent().children('.input-q');
        // Get its current value
        var currentVal = parseInt($(input).val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 1) {
            // Decrement one only if value is > 1
            $(input).val(currentVal - 1);
             $('.qtyplus').val('+').removeAttr('style');
        } else {
            // Otherwise put a 0 there
            $(input).val(1);
            $('.qtyminus').val('-').css('color','#aaa');
            $('.qtyminus').val('-').css('cursor','not-allowed');
        }
    });
});
