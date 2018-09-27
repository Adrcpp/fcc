( function( $ ) {

    jQuery(document).ready( function($) {
        /*function media_upload(button_class) {
            var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

            $('body').on('click', button_class, function(e) {
                var button_id ='#'+$(this).attr('id');
                var self = $(button_id);
                var send_attachment_bkp = wp.media.editor.send.attachment;
                var button = $(button_id);
                var id = button.attr('id').replace('_button', '');
                _custom_media = true;
                wp.media.editor.send.attachment = function(props, attachment){
                    if ( _custom_media  ) {
                        $('.custom_media_id').val(attachment.id);
                        $('.custom_media_url').val(attachment.url);
                        $('.custom_media_image').attr('src',attachment.url).css('display','block');
                    } else {
                        return _orig_send_attachment.apply( button_id, [props, attachment] );
                    }
                }
                wp.media.editor.open(button);
                    return false;
            });
        }
        media_upload('.custom_media_button.button');*/



        $('body').on('click', '.custom_media_button.button', function(e) {
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
                $('.custom_media_id').val(attachment.id);
                $('.custom_media_url').val(attachment.url);
                $('.custom_media_image').attr('src',attachment.url).css('display','block');
            })
            .open();
        });







    });

})( jQuery );
