<?php
// Creating the widget
class Widget_Find_Store extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Find_Store',

			// Widget name will appear in UI
			__('Find Store', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Find Store', 'wpb_widget_domain' ), )
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
		<div class="container-fluid pt-5">
			<div class="before-row"><!-- ROW -->
				<div class="row"><!-- START CELL-->
					<div class="textwidget">
						<h5 class="title-home">Find our cheeses in these shops </h5>
					</div>
				</div>
			</div>

			<div class="before-row"><!-- ROW -->
				<div class="row"><!-- START CELL-->

				</div>
			</div>

			<div class="before-row"><!-- ROW -->
				<div class="row"><!-- START CELL-->
					<div class="textwidget">
						<div class="col-sm-12 text-center">
							<a class="social-fcc p-4" href="https://www.facebook.com/FrenchCheeseCorner/">
								<img src="http://localhost/wordpress/wp-content/uploads/2018/07/wholefood.png" width="100">
							</a>
							<a class="social-fcc p-4"  href="https://www.instagram.com/frenchcheeseboard/?hl=en">
								<img src="http://localhost/wordpress/wp-content/uploads/2018/07/walmart.jpg.png" width="150">
							</a>
							<a class="social-fcc p-4" href="https://twitter.com/frenchboard?lang=en">
								<img src="http://localhost/wordpress/wp-content/uploads/2018/07/target.png" width="160">
							</a>
							<a class="social-fcc p-4" href="https://twitter.com/frenchboard?lang=en">
								<img src="http://localhost/wordpress/wp-content/uploads/2018/07/trader-joe.png" width="180">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container"><!-- ROW -->
			<div class="row text-center"><!-- START CELL-->
				<div class="col-sm-12"><!-- START CELL-->
					<p>Can't find your store in the list ? Tell where you'd like to find our</p>
					<p>Saint Agur, and we will do our best to reach your store</p>
				</div>

			</div>
			<div class="row"><!-- START CELL-->

				<div class="col-sm-3"> </div>
				<div class="col-sm-9">
					<input class="store-input" type="text" placeholder="City"> </input>
					<input class="store-input" type="text" placeholder="Email"> </input>
				</div>
			</div>
			<div class="row"><!-- START CELL-->
				<div class="col-sm-3"> </div>
				<div class="col-sm-5">
					<input class="store-input" type="checkbox" placeholder="City"> </input>
					<label>Subscribe to our Newsletter</label>
				</div>
				<div class="col-sm-4"> </div>
			</div>
		</div>

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
        register_widget( 'Widget_Find_Store' );
    }
);
