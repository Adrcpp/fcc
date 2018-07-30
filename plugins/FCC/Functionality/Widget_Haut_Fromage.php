<?php
// Creating the widget
class Widget_Haut_Fromage extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Haut_Fromage',

			// Widget name will appear in UI
			__('Widget Haut Fromage', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Haut Fromage', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
    public static function render_widget ()
    {
        self::widget(null, null);
    }

	public function widget( $args, $instance )
    {
	  ?>
        <div class="row test">
            <div class="col-3 bottom-border"></div> <h1 class=" col title-home haut-title"> Haute Fromagerie </h1> <div class="col-3 bottom-border"></div>
        </div>
		<div class="haut-fromage">

		</div>
	 <?php
	}

	public function form( $instance )
	{
	    var_dump($instance);
	    if ($instance) {
	        $gallery = $instance['gallery'];
	    } else {
	        $gallery = [];
	    }

	    ?>



	     <?php
	        $i = 0;
	        if ( ! empty( $gallery ) ) {
	            foreach ( $gallery as $attachment_id ) {
	                //
	                // echo '
	                // <a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'woocommerce' ) . '">' . __( 'Delete', 'woocommerce' ) . '</a>';

	                // rebuild ids to be saved
	                $img_gallery .= "<img class='gallery-haut' style='max-width: 150px;' data-id='". $i ."' src=" . $attachment_id . ">";
	                $hidden .= '<input class="gallery-haut" type="text" name="' . $this->get_field_name("gallery") . '[' . $i .']" data-id="'.  $i . '" value="' . $attachment_id . '"/>';
	                ++$i;
	            }
	        }
	    ?>


	      <input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />


	    <ul class="product_images" id="img-gallery"> <?php echo $img_gallery ?></ul>
	    <p style="display:none" id="img-src"><?php echo $hidden ?></p>

		 <p class="add_product_images hide-if-no-js">
	         <a href="#" id="add_images" data-choose="<?php esc_attr_e( 'Add images to product gallery', 'woocommerce' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'woocommerce' ); ?>"><?php _e( 'Add product gallery images', 'woocommerce' ); ?></a>
	     </p>

	    <script>
	    var $index = <?php echo $i ?>;
	    var $name = "<?php echo $this->get_field_name("gallery"); ?> ";
		$name = jQuery.trim($name);
	    console.log("index = " + $index);
	    jQuery('#add_images').click(function(e) {
	        e.preventDefault();
	        var image = wp.media({
	            title: 'Upload Image',
	            multiple: true
	        }).open()
	        .on('select', function(e){
	            console.log(image.state().get('selection'));
	            console.log(image.state());
	            var uploaded_image = image.state().get('selection').first();
	            // var image_url = uploaded_image.toJSON().url;
	            // var image_id = uploaded_image.toJSON().id;

	            var selection = image.state().get('selection');

	            selection.map( function( attachment ) {
	                attachment = attachment.toJSON();

	                var $add = '<li class="image" data-id="'+ $index +'">  \
	                    <img class="gallery-haut" style="max-width: 150px;" src="' +attachment.url+ '"> \
	                    <ul class="actions"> \
	                        <li><a href="#" onclick="deleteImg(' + $index +' );" data-delete='+ $index +' class="delete tips" > Delete </a></li> \
	                    </ul> \
	                </li>'
	                $("#img-gallery").append($add);
	                $("#img-src").append('<li data-id="'+ $index +'" ><input class="gallery-haut" name="' + $name + '[' +  $index +']" type="hidden" value="' + attachment.url +'"/></li>');

	                $index += 1;
	            });
	            console.log("index = " + $index);
	        });

	    });

	    function deleteImg($id) {
	        //$id = $(this).data('delete');
	        console.log("delete = " + $id);

	        $("li[data-id='" + $id + "']").each(function(){
	            console.log($(this));
	            $(this).remove();
	        });

	    }
	    </script>
	     <?php
	}

	public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['gallery'] = array();

        if (isset($new_instance['gallery'])) {
            foreach ($new_instance['gallery'] as $key => $value) {
                if (!empty(trim($value))) {
                    $instance['gallery'][$key] = $new_instance['gallery'][$key];
                }
            }
        }

        return $instance;
	}

    // function fcc_save_haut_fromage( $post_id, $post ) {
    //
    //     $sanitized = [];
    // 	if ( isset ( $_POST['gallery'] ) )
    // 		$sanitized['gallery'] = wp_filter_post_kses($_POST['gallery']);
    //
    //     //die(var_dump($sanitized));
    // 	update_post_meta( $post->ID, 'fcc_haut_fromage', $sanitized );
    // }

}

add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Haut_Fromage' );
    }
);

//
// <?php
// if ( metadata_exists( 'post', $post->ID, '_product_image_gallery' ) ) {
//     $product_image_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );
// } else {
//     // Backwards compatibility.
//     $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_exclude_image&meta_value=0' );
//     $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
//     $product_image_gallery = implode( ',', $attachment_ids );
// }
// $attachments         = array_filter( explode( ',', $product_image_gallery ) );
// $update_meta         = false;
// $updated_gallery_ids = array();
// if ( ! empty( $attachments ) ) {
//     foreach ( $attachments as $attachment_id ) {
//         $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
//         // if attachment is empty skip
//         if ( empty( $attachment ) ) {
//             $update_meta = true;
//             continue;
//         }
//         echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
//         ' . $attachment . '
//         <ul class="actions">
//         <li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'woocommerce' ) . '">' . __( 'Delete', 'woocommerce' ) . '</a></li>
//         </ul>
//         </li>';
//         // rebuild ids to be saved
//         $updated_gallery_ids[] = $attachment_id;
//     }
//     // need to update product meta to set new gallery ids
//     if ( $update_meta ) {
//         update_post_meta( $post->ID, '_product_image_gallery', implode( ',', $updated_gallery_ids ) );
//     }
// }
//



/* SAVE */
