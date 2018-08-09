<?php
// Creating the widget
class WP_Widget_Woo_Slider extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'WP_Widget_Woo_Slider',

			// Widget name will appear in UI
			__('Product Slider', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Product slider', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		// before and after widget arguments are defined by themes
		// echo $args['before_widget'];
		// if ( ! empty( $title ) )
		// echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'wpb_widget_domain' );
		// echo $args['after_widget'];

		$args = array();
		$products = wc_get_products( $args );
		// var_dump($products[0]);
		echo '<h1 class="title-cheese text-center col-12">Our cheese</h1>';

		echo '<div class="container slick-container">';

		echo '<div class="slick">';
		foreach ($products as $key => $value) {
			echo '<div>';
			echo $value->get_name();
			echo $value->get_image();
			echo '</div>';
		}

		echo '</div>';
		echo '</div>';
		echo '<script>

		jQuery(document).ready(function( $ ) {

			$(".slick").slick({


				  speed: 300,
				  slidesToShow: 3,
				  slidesToScroll: 3,
				  responsive: [
					  {
						breakpoint: 1025,
						settings: {
						  slidesToShow: 2,
						  slidesToScroll: 2,
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

					]
				});


		});

		</script>';
	}

	// Widget Backend
	public function form( $instance ) {
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

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here
