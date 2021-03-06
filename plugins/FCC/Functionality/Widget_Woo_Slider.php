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
		echo '<h1 class="title-cheese text-center col-12">Our cheeses</h1>';
		echo '<div class="container slick-container">';

		echo '<div class="slick-woo">';

		foreach ($products as $key => $value) {
			$post_thumbnail_id = $value->get_image_id();
			$img_src = wp_get_attachment_image_src( $post_thumbnail_id, "full")[0];

			$data = get_post_meta($value->get_id(), "fcc_product_info");
			echo '<div class=" text-center">';
			//echo '<a href="' . $value->get_permalink() .'">'. $value->get_image(). '</a>';
			echo '<a href="' . $value->get_permalink() .'"><img src="' . $img_src .'" /></a>';
			echo '<div class="text-center">';
			echo '<h4 class="title">' .$value->get_name() .'</h4>';
			echo '<h6 class="sub-title">' . $data[0]["subtitle"] .'</h6>';
			echo '<a class="show-more" href="' . $value->get_permalink() .'">Discover</a>';
			echo '</div>';
			echo '</div>';

		}

		echo '</div>';
		echo '</div>';
		echo '<script async>

			jQuery(document).ready(function( $ ) {

				$(".slick-woo").slick({

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

	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		return $instance;
	}
} // Class wpb_widget ends here

add_action( 'widgets_init',  'register_widget_woo_slider' );
function register_widget_woo_slider() {
    register_widget( 'WP_Widget_Woo_Slider' );
}
