<?php
// Creating the widget
class Widget_Contact_Page extends WP_Widget {

	function __construct() {
		parent::__construct(

			// Base ID of your widget
			'Widget_Contact_Page ',

			// Widget name will appear in UI
			__('Contact Page', 'wpb_widget_domain'),

			// Widget description
			array( 'description' => __( 'Contact Page', 'wpb_widget_domain' ), )
		);
	}
	public function widget( $args, $instance )
    {
		?>
		<div class="bg-black container-fluid contact-page">
			<div class="container">
				<div class="col text-center container" >
					<h1 class="title-home title-white hero-title">contact</h1>
					<h4 class="sub-title">Follow us on Social Media</h4>
					<div class="">
						<div class="text-center social-header social-contact row">

							<div class="p-2 col">
								<a target="blank" href="https://www.facebook.com/FrenchCheeseCorner/">
									<img src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/facebook-1.png" >
									<h5 class="title-social">Like us</h5>
									<p class="subtitle-social">
										On Facebook
									</p>
								</a>
							</div>
							<div class="p-2 col">
								<a target="blank" href="https://www.instagram.com/frenchcheesecorner/">

									<img src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/insta.png" >
									<h5 class="title-social">Follow us</h5>
									<p class="subtitle-social">
										On Instagram
									</p>
								</a>
							</div>
							<div class="p-2 col">
								<a target="blank" href="">

									<img src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/twitter-1.png">
									<h5 class="title-social">Tweet with us</h5>
									<p class="subtitle-social">
										On Twitter
									</p>
								</a>
							</div>

						</div>
					</div>
				</div>
			</div>


			<div class="pt-4"></div>
			<hr/>
			<div class="pt-4"></div>

			<div class="container pt-4">

				<form>
					<div class="form-contact pt-4">
						<div class="text-center pb-4">
							<h4 class="sub-title">Or send us a Message!</h4>
						</div>
						<div class="row pt-4">
							<div class="col-sm-6">
								<div class="form-group col-md-6">
									<label class="label-contact" for="name">Name</label>
									<input class="form-control" name="name" type="text" />
								</div>
								<div class="form-group col-md-6">
									<label class="label-contact" for="email">Email</label>
									<input class="form-control" name="email" type="text" />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="label-contact" for="message"> Your message</label>

									<textarea class="form-control" name="message" d="exampleFormControlTextarea1" rows="10"></textarea>
								</div>
							</div>
						</div>
					</div>
					<input class="submit-contact" type="submit" value="SEND"/>
				</form>

			</div>
		</div> <!-- Contact Page -->



		<!-- Begin MailChimp Signup Form -->
		<!-- <link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
			/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
			   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
		<form action="https://frenchcheesecorner.us19.list-manage.com/subscribe/post?u=566471b2380f7022f8b20cbcf&amp;id=c35fa349d1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		    <div id="mc_embed_signup_scroll">
			<label for="mce-EMAIL">Subscribe to our mailing list</label>
			<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required> -->
		    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		    <!-- <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_566471b2380f7022f8b20cbcf_c35fa349d1" tabindex="-1" value=""></div>
		    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		    </div>
		</form>
		</div> -->

		<!--End mc_embed_signup-->






		<style>
			.before-row {
				padding-bottom: 0;
			}
		</Style>
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
        register_widget( 'Widget_Contact_Page' );
    }
);
