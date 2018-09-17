<?php
// Creating the widget
class Widget_Cheese_List extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Cheese_List',

			// Widget name will appear in UI
			__('Widget Cheese List', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Cheese List for footer', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
    public static function render_widget ()
    {
        self::widget(null, null);
    }

	public function widget( $args, $instance )
    {

      $query = new WC_Product_Query();
      $products = $query->get_products();

      echo '<div class="justify-content-center p-2">
      	<p class="title">Our cheeses</p>
      	<div>';

      foreach ($products as $key => $value) {

          echo '<a href="'. $value->get_permalink().'">
              <p class="footer-p">
                 ' . $value->get_name() . '
              </p>
          </a>';
        }

        echo '</div>
        </div>';
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
        register_widget( 'Widget_Cheese_List' );
    }
);
