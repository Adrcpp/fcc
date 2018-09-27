<?php
// Creating the widget
class Widget_Social extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Social',

			// Widget name will appear in UI
			__('Widget FCC Social', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Widget Social', 'wpb_widget_domain' ), )
		);
	}

	// Creating widget front-end
    public static function render_widget ($insta = false)
    {
        self::widget(null, null, $insta);
    }

	public function widget( $args, $instance, $insta = true)
    {
		$content = "";
		if ($insta) {
	        $content ='
	        <div class="before-row pt-5"><!-- ROW -->
	            <div class="row"><!-- START CELL-->
	                <div class="textwidget">
	                    <h1 class="title-home">Recipes &amp; pairings</h1>
	                </div>
	            </div>
	        </div>

	        <div class="before-row"><!-- ROW -->
	            <div class="row"><!-- START CELL-->
	                [instagram-feed num=6 cols=6 showfollow=false]
	            </div>
	         </div>';
		 }
		 $content .= '
	        <div class="before-row"><!-- ROW -->
	            <div class="row"><!-- START CELL-->
	                <div class="textwidget"><h1 class="title-home">follows us</h1>
	                    <div class="col-sm-12 text-center">
						<a class="social-fcc" target="_blank" href="https://www.facebook.com/FrenchCheeseCorner/">
							<img src="'.  get_site_url() . '/wp-content/uploads/2018/07/facebook-2.png" width="45">
						</a>
						<a class="social-fcc" target="_blank"  href="https://www.instagram.com/frenchcheeseboard/?hl=en">
							<img src="'.  get_site_url() . '/wp-content/uploads/2018/07/insta-1.png" width="50">
						</a>
						<a class="social-fcc" target="_blank"  href="https://twitter.com/FRCheeseCorner">
							<img src="'.  get_site_url() . '/wp-content/uploads/2018/07/twitter-2.png" width="45">
						</a>
	                </div>
	                </div>
			   </div>
	        </div>';

        echo do_shortcode($content);
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
        register_widget( 'Widget_Social' );
    }
);
