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
		$page = get_page_by_title('Shop', OBJECT, 'page');

		//$gallery = $instance['gallery'];
		$args = array('product_cat' => 'haute-fromagerie');
		$gallery = wc_get_products( $args );

		$content = $instance['content'];
		$display_gallery =
		'<div class="container slick-container">
		 <div class="slick">';

		foreach ($gallery as $key => $value) {
			$display_gallery .= '<div data-src="'. $value->get_permalink() . '">';
			$display_gallery .= $value->get_image();
			$display_gallery .= '<h4 style="display:none;text-align: center;" class="title-slick title">' .$value->get_name() .'</h4>';
			$display_gallery .= '</div>';
		}
		$display_gallery .=  '</div>';
		$display_gallery .=  '</div>';

		$display_gallery .=  '<script>
		jQuery(document).ready(function( $ ) {

			var slider = $(".slick");
			var option = {
				  speed: 300,
				  slidesToShow: 1,
				  slidesToScroll: 1,
				  responsive: [
					  {
						breakpoint: 1025,
						settings: {
						  slidesToShow: 1,
						  slidesToScroll: 1,
						  infinite: true,
						  dots: true
						}
					  },
					  {
						breakpoint: 600,
						settings: {
						  slidesToShow: 1,
						  slidesToScroll: 1
						}
					  }

				  ],
			  };

			slider.slick(option);

			$(".slick").on("afterChange", function(event, slick, direction){
				$link = $(".slick-current:eq(0)").children().children().data("src");
				$(".haute-fr-btn").attr("href", $link);
			});

			var slider_gourmet = $(".slick-gourmet");
			slider_gourmet.slick(option);

			slider_gourmet .on("afterChange", function(event, slick, direction){
				$link = $(".slick-current:eq(1)").children().children().data("src");
				$(".haute-fr-gourmet-btn").attr("href", $link);
			});

			if (window.matchMedia("(max-width: 768px)").matches) {
				$(".title-slick").show();
				$(".fromage").hide();
			}

		});
		</script>';
	  ?>
	  <div class="row test">
		  <div class="col-3 bottom-border"></div> <h1 class=" col title-home haut-title"> Haute Fromagerie </h1> <div class="col-3 bottom-border"></div>
	  </div>
	  <div class="haut-fromage">
		  <div class="row align-items-center">
			  <div class="col-md-4 col-sm-12 slick2">
				  <?php  echo $display_gallery; ?>
			  </div>

			  <div class="col-md-2"></div>
			  <div class="col-md-6 col-sm-12">
				  <p class="text-discover">
					  <?php echo $content; ?>
				  </p>
				  <a class="haute-fr-btn" href="<?php echo $gallery[0]->get_permalink(); ?>"> <div class="go-shop"> Shop </div></a>
			  </div>
			  <?php self::print_haut_fromage(); ?>
		  </div>
	  </div>
	  <?php

  }
	public function print_haut_fromage()
	{
		$args = array('product_cat' => 'haute-fromagerie');
		$products = wc_get_products( $args );
		echo '<div class="row fromage">';
		foreach ($products as $key => $value) {
			echo '<div class="col text-center">';
			echo '<a href="' . $value->get_permalink() . '">';
			echo $value->get_image();
			echo '<div class="text-center">';
			echo '<h4 class="title">' .$value->get_name() .'</h4>';
			echo '</div>';
			echo '</a>';
			echo '</div>';
		}
		echo '</div>';
	}

	public function form( $instance )
	{
	    if ($instance) {
	        $gallery = $instance['gallery'];
			$content = $instance['content'];
	    } else {
	        $gallery = [];
			$content = '';
	    }

	    ?>

	     <?php
	        $i = 0;
	        if ( ! empty( $gallery ) ) {
	            foreach ( $gallery as $attachment_id ) {
					$img_gallery .=
					'<li class="image" data-id="'. $i .'">
						<img class="gallery-haut" style="max-width: 150px;" src="' . $attachment_id . '">
						<ul class="actions">
							<li><a href="#" onclick="deleteImg(' . $i .' );" data-delete='. $i .' class="delete tips" > Delete </a></li>
						</ul>
					</li>';

					$hidden .=
					'<li data-id="'. $i .'" >
						<input class="gallery-haut" name="' . $this->get_field_name("gallery") . '[' .  $i .']" type="hidden" value="' . $attachment_id .'"/>
					</li>';

	                ++$i;
	            }
	        }
	    ?>

		<div class="row">
			<div class="col-sm-12">
				<input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

				<ul class="product_images" id="img-gallery"> <?php echo $img_gallery ?></ul>
				<ul class="product_images" style="display:none" id="img-src"><?php echo $hidden ?></ul>

				<p class="add_product_images hide-if-no-js">
					<a href="#" id="add_images" data-choose="<?php esc_attr_e( 'Add images to product gallery', 'woocommerce' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'woocommerce' ); ?>"><?php _e( 'Add product gallery images', 'woocommerce' ); ?></a>
				</p>
			</div>
			<div class="col-sm-12">
				<p>
					<?php self::get_editor($content) ?>
				</p>
			</div>
		</div>

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

		$rand = (int) $new_instance['the_random_number'];
		$editor_content = $new_instance[ 'wp_editor_' . $rand ];

		$instance['content'] = $editor_content;

		return $instance;
	}

	public function get_editor($content)
	{
		$rand    = rand( 0, 999 );
		$ed_id   = $this->get_field_id( 'wp_editor_' . $rand );
		$ed_name = $this->get_field_name( 'wp_editor_' . $rand );
		$editor_id = $ed_id;

		$settings = array(
			'media_buttons' => false,
			'textarea_rows' => 3,
			'textarea_name' => $ed_name,
			'teeny'         => true,
		);

		printf(
			'<input type="hidden" id="%s" name="%s" value="%d" />',
			$this->get_field_id( 'the_random_number' ),
			$this->get_field_name( 'the_random_number' ),
			$rand
		);
		?>

		<script>
		jQuery(document).ready(
			function($) {
				$( '.widget-control-save' ).click(
					function() {
						// grab the ID of the save button
						var saveID   = $( this ).attr( 'id' );
						// grab the 'global' ID
						var ID       = saveID.replace( /-savewidget/, '' );
						// create the ID for the random-number-input with global ID and input-ID
						var numberID = ID + '-the_random_number';
						// grab the value from input field
						var randNum  = $( '#'+numberID ).val();
						// create the ID for the text tab
						var textTab  = ID + '-wp_editor_' + randNum + '-html';
						// trigger a click
						$( '#'+textTab ).trigger( 'click' );

					}
				);
			}
		);
		</script>
		<?php
		return wp_editor( $content, $editor_id, $settings );
	}
}

add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Haut_Fromage' );
    }
);
