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
	// $details = array_merge ($saved, $defaults); // Merge the two in case any fields don't exist in the saved data
	$details = wp_parse_args ($saved, $defaults);

	?>

	<div class="row">
		<div class="col-sm-12">
			<h1> Subtitle </h1>
			<input id="subtitle" name="subtitle" type="text" value="<?php echo $details["subtitle"];?>"/>
		</div>

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
				   <div class="postbox">

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

				  <p class="form-field">
					<label for="">Serving per Container</label>
					<input type="text" class="short" style="" name="nutritions[serving]" value="<?php echo $details['nutritions']['serving']; ?>">
				  </p>
				  <p class="form-field">
					<label for="">Calories</label>
					<input type="number" class="short wc_input_price" style="" name="nutritions[cal]" value="<?php echo $details['nutritions']['cal']; ?>">
				  </p>


				  <table style="width:100%">
					  <tr>
						  <th>value</th>
						  <th>%</th>
					  </tr>
					  <tr>
						  <td >
							  <label class="product-nutrition" >Total fats</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[tot_fats][val]" id="nutritions[tot_fats][val]" value="<?php echo $details['nutritions']['tot_fats']['val']; ?>"
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[tot_fats][perc]" id="nutritions[tot_fats][perc]" value="<?php echo $details['nutritions']['tot_fats']['perc']; ?>" >
						  </td>
					  </tr>
					   <tr>
						  <td>
							  <label class="product-nutrition" for="">Satured fat</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[sat_fats][val]" id="" value="<?php echo $details['nutritions']['sat_fats']['val']; ?>" >
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[sat_fats][perc]" id="" value="<?php echo $details['nutritions']['sat_fats']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						 <td>
							 <label class="product-nutrition" for="">Trans fat</label>
							 <input type="text" class="short wc_input_price" style="" name="nutritions[trans_fats]" id="" value="<?php echo $details['nutritions']['trans_fats']; ?>" >
						 </td>
					 </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Cholesterol</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[chol_fats][val]" id="" value="<?php echo $details['nutritions']['chol_fats']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[chol_fats][perc]" id="" value="<?php echo $details['nutritions']['chol_fats']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Sodium</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[sodium][val]" id="" value="<?php echo $details['nutritions']['sodium']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[sodium][perc]" id="" value="<?php echo $details['nutritions']['sodium']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Total Carbohydrate</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[t_carb][val]" id="" value="<?php echo $details['nutritions']['t_carb']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[t_carb][perc]" id="" value="<?php echo $details['nutritions']['t_carb']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Dietary Fiber</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[fiber][val]" value="<?php echo $details['nutritions']['fiber']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[fiber][perc]" value="<?php echo $details['nutritions']['fiber']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Total Sugars</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[t_sugar][val]" id="" value="<?php echo $details['nutritions']['t_sugar']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[t_sugar][perc]" id="" value="<?php echo $details['nutritions']['t_sugar']['perc']; ?>">
						  </td>
					  </tr>


					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Includes Added Sugars</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[added]" id="" value="<?php echo $details['nutritions']['added'] ?>">
						  </td>

					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Proteins</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[protein]" id="" value="<?php echo $details['nutritions']['protein']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Vitamin D</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[vit_d][val]" id="" value="<?php echo $details['nutritions']['vit_d']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[vit_d][perc]" id="" value="<?php echo $details['nutritions']['vit_d']['perc']; ?>">
						  </td>
					  </tr>

					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Calcium</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[calcium][val]" value="<?php echo $details['nutritions']['calcium']['val']; ?>" id="">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[calcium][perc]" value="<?php echo $details['nutritions']['calcium']['perc']; ?>" id="">
						  </td>
					  </tr>
					  <tr>
						  <td>
							  <label class="product-nutrition" for="">Iron</label>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[iron][val]" id="" value="<?php echo $details['nutritions']['iron']['val']; ?>">
						  </td>
						  <td>
							  <input type="text" class="short wc_input_price" style="" name="nutritions[iron][perc]" id="" value="<?php echo $details['nutritions']['iron']['perc']; ?>">
						  </td>
					  </tr>
 				  <tr>
					  <td>
						  <label class="product-nutrition" for="">Potassium</label>
						  <input type="text" class="short wc_input_price" style="" name="nutritions[potassium][val]" id="" value="<?php echo $details['nutritions']['potassium']['val']; ?>">
					  </td>
					  <td>
						  <input type="text" class="short wc_input_price" style="" name="nutritions[potassium][perc]" id="" value="<?php echo $details['nutritions']['potassium']['perc']; ?>">
					  </td>
				  </tr>

				  </table>


			  </div>
			</div>
	  </div>

	  <style>.product-nutrition {width:140px;}</style>
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

	$sanitized = fcc_product_info_defaults();

	if ( isset ( $_POST['subtitle'] ) )
		$sanitized['subtitle'] = wp_filter_post_kses($_POST['subtitle']);

	if ( isset ( $_POST['image-product'] ) )
		$sanitized['image-product'] = wp_filter_post_kses($_POST['image-product']);

	if ( isset ( $_POST['shortdescr'] ) )
		$sanitized['shortdescr'] = wp_filter_post_kses($_POST['shortdescr'] );

	if ( isset ( $_POST['descr'] ) )
		$sanitized['description'] = wp_filter_post_kses($_POST['descr'] );

	if ( isset ( $_POST['ingr'] ) )
		$sanitized['ingredients'] = wp_filter_post_kses($_POST['ingr'] );

	if ( isset ( $_POST['nutritions'] ) )
		$sanitized['nutritions'] = $_POST['nutritions'];

	update_post_meta( $post->ID, 'fcc_product_info', $sanitized );
}
add_action( 'save_post', 'fcc_save_metabox', 1, 2 );


function fcc_product_info_defaults()
{
	return array(
		'subtitle'		=> '',
		'shortdescr'  	=> '',
		'image-product' => '',
		'description' 	=> '',
		'ingredients' 	=> '',
		'nutritions'  	=> array("serving"  => "Varied",
								"cal"       => 0,
								"tot_fats"  => ["val"=> 0, "perc"=> 0],
								"sat_fats"  => ["val"=> 0, "perc"=> 0],
								"trans_fats"=> 0,
								"chol_fats" => ["val"=> 0, "perc"=> 0],
								"sodium"    => ["val"=> 0, "perc"=> 0],
								"t_carb"    => ["val"=> 0, "perc"=> 0],
								"fiber"     => ["val"=> 0, "perc"=> 0],
								"t_sugar"   => ["val"=> 0, "perc"=> 0],
								"added"     => 0,
								"protein"   => 0,
								"vit_d"     => ["val"=> 0, "perc"=> 0],
								"calcium"   => ["val"=> 0, "perc"=> 0],
								"iron"      => ["val"=> 0, "perc"=> 0],
								"potassium" => ["val"=> 0, "perc"=> 0],
							),
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
