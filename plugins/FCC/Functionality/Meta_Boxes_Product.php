<?php
/******************
*
*	META GALLERY
*
******************/


function render( $post ) {

	//var_dump($post->ID);
	// Security field
	// This validates that submission came from the
	// actual dashboard and not the front end or
	// a remote server.
	wp_nonce_field( 'fcc_product_info_nonce', 'fcc_product_info_process' );

	$saved = get_post_meta( $post->ID, 'fcc_product_info', true );
	$defaults = fcc_product_info_defaults();
	$details = wp_parse_args( $saved, $defaults ); // Merge the two in case any fields don't exist in the saved data
	//n die(var_dump($saved, $details));
	?>

	<div class="row">

		<div class="col-sm" id="product-gallery">
			<h1>Set the gallery</h1>
		</div>

		<div class="col-sm">
			<h1>Short description</h1>

			<div class="postbox">
				<button type="button" class="handlediv" aria-expanded="true">
					<span class="screen-reader-text">Toggle panel: Short description</span>
					<span class="toggle-indicator" aria-hidden="true"></span>
				</button>
				<h2 class="hndle ui-sortable-handle"><span>Short description</span></h2>
				<div class="inside">
					<?php wp_editor( $details['shortdescr'], 'shortdescr' ); ?>
				</div>
			</div>
		</div>

	</div>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link active" data-toggle="tab" href="#description-panel">Description</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#ingredients-panel">Ingredients</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" data-toggle="tab" href="#nutrition-panel">Nutrition</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#reviews-panel">Reviews</a>
	  </li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
	  <div class="tab-pane container active" id="description-panel">
		  <div class="row product-tab">

			  <div class="col-sm text-center">
				  <h1>Set image</h1>
				  <div class="wrap text-center">

						<div>
							<?php
								// var_dump($details);
								if (!empty($details['image-product'])) {
									echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:250px;display:block;" />';
								}  else {
									echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
								}

							?>
							<p id="action-image" class='btn btn-primary'> Choose an image </p>

							<p class="description">
							<?php
								$html = "";
								$value = "";
								if ($details['image-product']  == '') {
									$html .= __( 'You have no file attached to this product.', 'umb' );
								} else {
									$value = $details['image-product'];
								} // end if
								echo $html;
							?>
							</p><!-- /.description -->
							<input type="hidden" id="image-product" name="image-product" value="<?php echo $value; ?>">
						</div>
		          </div>
			  </div>

			  <div class="col-sm" >
				  <h1>Set description</h1>

				  <div class="postbox">
					  <?php wp_editor( $details['description'], 'descr' ); ?>
				  </div>
			  </div>
		  </div>
	  </div>

	  <div class="tab-pane container fade" id="ingredients-panel">
		  <div class="row">
			  <div class="col-sm">
				  <?php wp_editor( $details['ingredients'], 'ingr' ); ?>
			  </div>
		  </div>
	  </div>

	  <div class="tab-pane container fade" id="nutrition-panel">
		  <div class="row">
			  <div class="col-sm">
				  <?php wp_editor( $details['nutrition'], 'nutr' ); ?>
			  </div>
			</div>
	  </div>


	  <div class="tab-pane container fade" id="reviews-panel">

	  </div>
	  </div>
	<?php
}

function add() {
	add_meta_box(
		'fcc_product_info',
		__( 'Product description page', 'gallery-meta-box' ),
		'render',
	 	'product', 'normal', 'high'
	);
}
add_action( 'add_meta_boxes', 'add' );


function fcc_save_metabox( $post_id, $post ) {
	// Verify that our security field exists. If not, bail.
	// if ( !isset( $_POST['fcc_product_info_process'] ) ) return;
	// // Verify data came from edit/dashboard screen
	//
	// if ( !wp_verify_nonce( $_POST['fcc_product_info_process'], 'fcc_product_info_nonce' ) ) {
	// 	return $post->ID;
	// }
	// // Verify user has permission to edit post
	// if ( !current_user_can( 'edit_post', $post->ID )) {
	// 	return $post->ID;
	// }
	// Check that our custom fields are being passed along
	// This is the `name` value array. We can grab all
	// of the fields and their values at once.
	// if ( !isset( $_POST['_namespace_custom_metabox'] ) ) {
	// 	return $post->ID;
	// }
	/**
	 * Sanitize all data
	 * This keeps malicious code out of our database.
	 */
	// Set up an empty array
	// $sanitized = array();
	// // Loop through each of our fields
	// foreach ( $_POST['_namespace_custom_metabox'] as $key => $detail ) {
	// 	// Sanitize the data and push it to our new array
	// 	// `wp_filter_post_kses` strips our dangerous server values
	// 	// and allows through anything you can include a post.
	// 	$sanitized[$key] = wp_filter_post_kses( $detail );
	// }
	// // Save our submissions to the database
	$sanitized = fcc_product_info_defaults();

	if ( isset ( $_POST['image-product'] ) )
		$sanitized['image-product'] = wp_filter_post_kses($_POST['image-product']);

	if ( isset ( $_POST['shortdescr'] ) )
		$sanitized['shortdescr'] = wp_filter_post_kses($_POST['shortdescr'] );

	if ( isset ( $_POST['descr'] ) )
		$sanitized['description'] = wp_filter_post_kses($_POST['descr'] );

	if ( isset ( $_POST['ingr'] ) )
		$sanitized['ingredients'] = wp_filter_post_kses($_POST['ingr'] );

	if ( isset ( $_POST['nutr'] ) )
		$sanitized['nutrition'] = wp_filter_post_kses($_POST['nutr'] );

	update_post_meta( $post->ID, 'fcc_product_info', $sanitized );
}
add_action( 'save_post', 'fcc_save_metabox', 1, 2 );

function fcc_product_info_defaults()
{
	return array(
		'shortdescr'  	=> '',
		'image-product' => '',
		'description' 	=> '',
		'ingredients' 	=> '',
		'nutrition'  	=> '',
		'reviews'     	=> '',
	);
}

/**
 * Enqueue necessary js and css.
 */
function enqueue()
{
	wp_enqueue_style(  'truongwp-gallery-meta-box',  plugins_url() . '/FCC/css/fcc-plugin.css', array(), false );
	wp_enqueue_script( 'truongwp-gallery-meta-box',  plugins_url() . '/FCC/js/fcc-plugin.js', array( 'backbone', 'jquery' ), false, true );

	if (get_current_screen()->post_type == 'product') {
		wp_enqueue_style( 'bootstrap-4', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
		wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri() . '/css/bootstrap-grid.min.css', false, '4', 'all' );
		wp_enqueue_style( 'bootstrap-reboot', get_template_directory_uri() . '/css/bootstrap-reboot.min.css', false, '4', 'all' );
		wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.4.1', true );
		wp_enqueue_script( 'bootstrap.bundle-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '1.4.1', true );
	}
}
add_action( 'admin_enqueue_scripts',  'enqueue'  );

function get_product_infos($id)
{
	$saved = get_post_meta( $id, 'fcc_product_info', true );
	$defaults = fcc_product_info_defaults();
	$details = wp_parse_args( $saved, $defaults );

	return $details;
}
