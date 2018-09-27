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
							<a class="social-fcc p-4" href="">
								<img class="img-store" src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/wholefood.png" width="100">
							</a>
							<a class="social-fcc p-4"  href="">
								<img class="img-store" src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/walmart.jpg.png" width="150">
							</a>
							<a class="social-fcc p-4" href="">
								<img class="img-store" src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/target.png" width="160">
							</a>
							<a class="social-fcc p-4" href="">
								<img class="img-store" src="<?php echo get_site_url() ?>/wp-content/uploads/2018/07/trader-joe.png" width="180">
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

				<div class="show-msg" id="error">

				</div>
			</div>
			<form id="nlt" action="https://frenchcheesecorner.us19.list-manage.com/subscribe/post-json?u=566471b2380f7022f8b20cbcf&amp;id=c35fa349d1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div class="row"><!-- START CELL-->

					<div class="col-sm-3"> </div>
					<div class="col-sm-9">
						<input class="store-input" type="text" name="zip" id="mce-zip" placeholder="Zipcode"> </input>
						<input class="store-input" type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email address" required> </input>
						<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_566471b2380f7022f8b20cbcf_c35fa349d1" tabindex="-1" value=""></div>
					    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class=" subscribe">

					</div>
				</div>
				<div class="row"><!-- START CELL-->
					<div class="col-sm-3"> </div>
					<div class="col-sm-5">
						<input class="store-input" id="checkbox-nlt" name="checkbox" type="checkbox" checked> </input>
						<label>Subscribe to our Newsletter</label>
					</div>
					<div class="col-sm-4"> </div>
				</div>
			</form>
		</div>
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
/*
*  Add the ajax call in the front end for filtering the products:
*/
add_action( 'wp_ajax_newsletter', 'ajax_newsletter' );
add_action( 'wp_ajax_nopriv_newsletter', 'ajax_newsletter' );

function ajax_newsletter()
{
	header( "Content-Type: application/json" );
	header('Access-Control-Allow-Origin: *');

	$url = $_POST['url'];
	$email = $_POST['EMAIL'];
	$zip = $_POST['ZIP'];
	$myvars = 'EMAIL=' . urlencode($email) . "&MERGE4=" . urlencode($zip) . "&b_566471b2380f7022f8b20cbcf_c35fa349d1=&subscribe=Subscribe";
	// ."&MMERGE6%5Baddr1%5D=.&MMERGE6%5Baddr2%5D=.&MMERGE6%5Bstate%5D=.&MMERGE6%5Bzip%5D=.&MMERGE6%5Bcountry%5D=USA".

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_POST, 1 );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $myvars);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$postResult = curl_exec($ch);

	// if ($response === false) {
    //      throw new Exception(curl_error($ch), curl_errno($ch));
    // }
	// var_dump($postResult);
	// var_dump(@curl_getinfo($ch));

	echo $postResult;
	curl_close($ch);
	wp_die();
}


add_action( 'widgets_init',  function () {
        register_widget( 'Widget_Find_Store' );
    }
);
