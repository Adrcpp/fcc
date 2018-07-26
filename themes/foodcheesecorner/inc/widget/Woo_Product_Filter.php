<?php
// Creating the widget
class WP_Widget_Product_Filter extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'WP_Widget_Product_Filter',

			// Widget name will appear in UI
			__('Product Filter', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Product filter', 'wpb_widget_domain' ), )
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

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'parent'     => 24
		);

		$texture_cat = get_terms( 'product_cat', $cat_args );

		$cat_args["parent"] = 21;
		$milk_cat = get_terms( 'product_cat', $cat_args );
		//var_dump($milk_cat);
		$milk_options = "<option value='21'>Any</option>";
		$texture_options = "<option value='24'>Any</option>";

		foreach ($texture_cat as $key => $value) {
			$texture_options .= "<option value='". $value->term_id. "'>" . $value->name ."</option>";
		}

		foreach ($milk_cat as $key => $value) {
			$milk_options .= "<option value='". $value->term_id. "'>" . $value->name ."</option>";
		}

		echo '<div class="col-sm-12 product-filter bgimg-1">
			<div class="text-center p-4">
				Show me <select id="texture">'
				. $texture_options.
				'</select> cheese of

				<select id="milk">
				'. $milk_options .'
				</select> milk
			</div>
		</div>';
		$args = array();
		//$products = wc_get_products( $args );
		//var_dump($products[0]);

		$query = new WC_Product_Query();

		$products = $query->get_products();

		echo '<div class="container">
		<div id="products" class="row">';


		foreach ($products as $key => $value) {

			echo '<div class="col-sm-4 text-center">';
			echo $value->get_image();
			echo '<div class="text-center">';
			echo '<h4 class="title">' .$value->get_name() .'</h4>';
			echo '<a class="show-more" href="' . $value->get_permalink() .'">Show more</a>';
			echo '</div>';
			echo '</div>';

		}

		echo '</div></div>';
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
