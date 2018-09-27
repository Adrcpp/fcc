<?php
// Creating the widget
class Widget_Hero extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Hero',

			// Widget name will appear in UI
			__('Widget Hero', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Hero Image', 'wpb_widget_domain' ), )
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
		<div class="col-sm-12 product-filter parallax-window" data-parallax="scroll" >

			<h1 id="discover-hero" class="title-home text-center p-4 hero-title">
				discover our cheeses
			</h1>

			</div>
		</div>
		<script>
		jQuery(document).ready(function( $ ) {

			$('.parallax-window').parallax({imageSrc: '<?php echo get_site_url() . '/wp-content/uploads/2018/07/hero-disc.png'; ?>'});
			$('.parallax-window').parent().parent().css('padding-bottom', 0);

		});
		</script>
	 <?php
	}

	// Widget Backend
	public function form( $instance )
    {
		?>
		<p>
	        <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />

	        <?php
	            if ( $instance['image_uri'] != '' ) :
	                echo '<img class="custom_media_image" src="' . $instance['image_uri'] . '" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" /><br />';
	            endif;
	        ?>

	        <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" style="margin-top:5px;">

	        <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" />
	    </p>
		<?php
	}

	public function update( $new_instance, $old_instance )
    {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Hero' );
    }
);

add_action( 'wp_enqueue_scripts', function () {
		wp_enqueue_script( 'custom-script',  plugins_url() .  '/FCC/js/parrallax.js', array( 'jquery' ) );
	}
);
