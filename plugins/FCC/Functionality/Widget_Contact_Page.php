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
								<a target="blank" href="https://twitter.com/FRCheeseCorner">

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
			<div class="show-msg" style="max-width: 600px;
    margin: auto;" id="error">

			</div>
			<div class="container pt-4">

				<form id="contact">
					<div class="form-contact pt-4">
						<div class="text-center pb-4">
							<h4 class="sub-title">Or send us a Message!</h4>
						</div>
						<div class="row pt-4">
							<div class="col-sm-6">
								<div class="form-group col-md-6">
									<label class="label-contact" for="name">Name</label>
									<input class="form-control" id="name" name="name" type="text" />
								</div>
								<div class="form-group col-md-6">
									<label class="label-contact" for="email">Email</label>
									<input class="form-control" name="email" id="email" type="text" />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="label-contact" for="message"> Your message</label>

									<textarea class="form-control" name="message" id="message" d="exampleFormControlTextarea1" rows="10"></textarea>
								</div>
							</div>
						</div>
					</div>
					<input class="submit-contact" type="submit" value="SEND"/>
				</form>

			</div>
		</div> <!-- Contact Page -->


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

	}

	public function update( $new_instance, $old_instance )
    {
		return $instance;
	}
}

/*
*  Add the ajax call in the front end for filtering the products:
*/
add_action( 'wp_ajax_send_mail', 'ajax_send_mail' );
add_action( 'wp_ajax_nopriv_send_mail', 'ajax_send_mail' );
function ajax_send_mail() {

	$admin_email = get_bloginfo('admin_email');

	if ($_POST["name"] != "" && $_POST["email"] != "" && $_POST["message"] != "")
	{
	    $name = $_POST["name"];
	    $msg = "You receive a message from the contact page: \n";
	    $msg .= "Name: "   . $name;
	    $msg .= "E-mail: " . $_POST["email"];
	    $msg .= "\n\n";
	    $msg .= "Message: \n";
	    $msg .= $_POST["message"];
	    $msg .= "\n\n";

	    $subject = utf8_decode("French Cheese Corner contact");
	    //$headers = array('Content-Type: text/html; charset=UTF-8', utf8_decode("From: " . $name . "&lt;". $_POST["email"]));
		$headers = 'From: ' . $admin_email . '\r\n' .
		'Reply-To: ' .$admin_email .' \r\n' .
    	'X-Mailer: PHP/' . phpversion();

	    header( "Content-Type: application/json" );
	    //if ( wp_mail($admin_email, $subject, utf8_decode($msg), $headers) )
	    if ( mail($_POST["email"], $subject, utf8_decode($msg), $headers) )
	   	 echo json_encode(["result" =>"success" , "msg" => "Your message has been sent! Thank you!"]);
	}

	echo json_encode(["result" => "error", "msg" => "An error occured ..."]);
    wp_die();
}

add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Contact_Page' );
    }
);
