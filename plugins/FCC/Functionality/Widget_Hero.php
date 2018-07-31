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

			<h1 id="select-filter" class="title-home text-center p-4">
				discover our cheeses
			</h1>

			</div>
		</div>
		<script>
		jQuery(document).ready(function( $ ) {

			$('.parallax-window').parallax({imageSrc: 'http://localhost/wordpress/wp-content/uploads/2018/07/hero-disc.png'});
			$('.parallax-window').parent().parent().css('padding-bottom', 0);
		});
		</script>
	 <?php
	}

	// Widget Backend
	public function form( $instance )
    {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
