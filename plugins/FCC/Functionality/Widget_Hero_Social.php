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
				  <a target="_blank" class="social-link" href="<?php echo $instance['social_twitter']; ?>">
					  <div class="p-2">

	                          <img src="<?php echo get_site_url() . "/wp-content/uploads/2018/07/twitter-1.png"; ?>" >
	                          <h5 class="title-social">Tweet with us</h5>
	                          <p class="subtitle-social">
	                              On Twitter
	                          </p>

	                  </div>
				  </a>
				  <a target="_blank" class="social-link"  href="<?php echo $instance['social_facebook'] ?>">
                  <div class="p-2">

                          <img src="<?php echo get_site_url() . "/wp-content/uploads/2018/07/facebook-1.png"; ?>" >
                          <h5 class="title-social">Like us</h5>
                          <p class="subtitle-social">
                          On facebook
                          </p>

                  </div>
				  </a>
				  <a target="_blank"  class="social-link" href="<?php echo $instance['social_instagram']  ?>">
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
          $('.parallax-window').parallax({imageSrc: '<?php echo $instance['image_uri'] ?>'});

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
		?>
		<table class="form-table">
		<p>
	        <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />
			<div>
		        <?php
		            if ( $instance['image_uri'] != '' )
		                echo '<img class="custom_media_image" src="' .  $instance['image_uri'] . '" style="margin:0;padding:0;max-width:100px;display:inline-block" /><br />';
					else
						echo '<img class="custom_media_image" style="margin:0;padding:0;max-width:100px;float:left;display:none;" /><br />';
		        ?>
			</div>
	        <input type="text" style="display:none" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" style="margin-top:5px;">
			<input type="button" class="button button-primary custom_media_button" id="custom_media_button" value="Upload Image" style="margin-top:5px;" />

		</p>

		<tr>
		    <th scope="row">
		         <label for="<?php echo $this->get_field_id('social_twitter'); ?>">Twitter's link</label><br />
		    </th>

		    <td>
				<input type="text"  class="widefat custom_media_url" name="<?php echo $this->get_field_name('social_twitter'); ?>" id="<?php echo $this->get_field_id('social_twitter'); ?>" value="<?php echo $instance['social_twitter']; ?>" style="margin-top:5px;">
		    </td>
		</tr>
		<tr>
		    <th scope="row">
				<label for="<?php echo $this->get_field_id('social_facebook'); ?>">Facebook's link</label><br />
		    </th>
		    <td>
				<input type="text"  class="widefat custom_media_url" name="<?php echo $this->get_field_name('social_facebook'); ?>" id="<?php echo $this->get_field_id('social_facebook'); ?>" value="<?php echo $instance['social_facebook']; ?>" style="margin-top:5px;">
		    </td>
		</tr>
		<tr>
			<th scope="row">
				<label for="<?php echo $this->get_field_id('social_instagram'); ?>">Instagram's link</label><br />
			</th>

			<td>
				<input type="text"  class="widefat custom_media_url" name="<?php echo $this->get_field_name('social_instagram'); ?>" id="<?php echo $this->get_field_id('social_instagram'); ?>" value="<?php echo $instance['social_instagram']; ?>" style="margin-top:5px;">
				<br>
			</td>
		</tr>
</table>
		<?php
	}

	public function update( $new_instance, $old_instance )
    {
		return $new_instance;
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

add_action('admin_enqueue_scripts', function() {
	    wp_enqueue_media();
		wp_enqueue_script('image-widget',  plugins_url() .  '/FCC/js/image-widget.js', false, '1.0', true);
	}
);
