<?php
// Creating the widget
class Widget_Hero_Social extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Hero_Social',

			// Widget name will appear in UI
			__('Widget Hero Social', 'wpb_widget_domain'),

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
        <div class="row caption" >
          <div class="col-sm-4 col-xs-12">
          </div>
          <div class="col-sm-4 col-xs-12">
          </div>
          <div class="col-sm-4 col-xs-12" id="big-scr">

              <div class="text-center social-header d-flex flex-column justify-content-around" id="socialBig">
				  <a target="_blank" class="social-link "href="https://www.facebook.com/FrenchCheeseCorner/">
				  <div class="p-2">

                          <img src="<?php echo get_site_url() . "/wp-content/uploads/2018/07/twitter-1.png"; ?>" >
                          <h5 class="title-social">Tweet with us</h5>
                          <p class="subtitle-social">
                              On Twitter
                          </p>

                  </div>
				   </a>
				  <a target="_blank" class="social-link"  href="">
                  <div class="p-2">

                          <img src="<?php echo get_site_url() . "/wp-content/uploads/2018/07/facebook-1.png"; ?>" >
                          <h5 class="title-social">Like us</h5>
                          <p class="subtitle-social">
                          On facebook
                          </p>

                  </div>
				  </a>
				    <a target="_blank"  class="social-link" href="https://www.instagram.com/frenchcheesecorner/">
                  <div class="p-2">

                          <img src="<?php echo get_site_url() . "/wp-content/uploads/2018/07/insta.png"; ?>" >
                          <h5 class="title-social">Follow us</h5>
                          <p class="subtitle-social">
                          On Instagram
                          </p>

                  </div>
				    </a>
              </div>
          </div>
        </div>

        <script>
        jQuery(document).ready(function( $ ) {
          $('.parallax-window').parallax({imageSrc: '<?php echo get_site_url() . '/wp-content/uploads/2018/07/home-1-e1531660484436.png'; ?>'});

		  function handleSocial() {
			  if ($(window).width() < 745) {
				   $('#socialBig').appendTo($('#idtest').parent()).removeClass("flex-column").addClass("socialBig");
				   $('.caption').css('display', 'none');
			  } else {
				  $('#socialBig').appendTo($('#big-scr')).removeClass("socialBig").addClass("flex-column");
				  $('.caption').css('display', 'flex');
			  }
		  }

		  handleSocial();

		  $( window ).resize(function() {
		   	handleSocial();
		  });

        });
        </script>
	 <?php
	}

	// Widget Backend
	public function form( $instance )
    {

	}

	public function update( $new_instance, $old_instance )
    {

	}
}

add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Hero_Social' );
    }
);

add_action( 'wp_enqueue_scripts', function () {
		wp_enqueue_script( 'custom-script',  plugins_url() .  '/FCC/js/parrallax.js', array( 'jquery' ) );
    }
);
