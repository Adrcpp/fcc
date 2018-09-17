
<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined( 'ABSPATH' ) || exit;
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}


global $product;

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/woocommerce/theme.css">
<div id="product-<?php the_ID(); ?>">

	<?php
	$post_thumbnail_id = $product->get_image_id();
	$img_src = wp_get_attachment_image_src( $post_thumbnail_id, "full")[0];

	global $product;
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	foreach ($terms as $key => $cat) {
		if (strpos($cat->name, 'Haute') !== false)
			$term = $cat;
	}

	 // $nex_post get_next_post('%link', '<', false, ' ', 'product_cat');
	 $nex_post  =  get_previous_post(false, '', 'product_cat');
	 $prev_post = get_next_post(false, '', 'product_cat');

	?>

	<div class="bg-black ">
	<div class="warpper-hero jumbotron vertical-center ">
		<div class=" hero-image col-sm-12 parallax-window">
			<div class="hero-text">
				<h1 class="hero-title"><?php echo $product->get_name(); ?></h1>
				<p> <?php $product->get_title(); ?></p>
				<h3 class="sub-title"> <?php echo $term->name; ?></h3>
			</div>
		</div>
		<div class='next-fromage'><?php if ($nex_post->guid): ?> <a class="sub-title next-fromage-link" href="<?php echo $nex_post->guid; ?>" > <?php echo  $nex_post->post_title; ?>  > </a> <?php endif ?></diV>
		<div class='prev-fromage'><?php if ($prev_post->guid): ?> <a class="sub-title next-fromage-link" href="<?php echo $prev_post->guid; ?>" > < <?php echo $prev_post->post_title; ?></a> <?php endif ?></diV>
	</div>
		<?php

			$args = array(
				'delimiter' => '>',
			);
		?>

		<?php woocommerce_breadcrumb( $args ); ?>

		</div>

		<?php  $details = get_product_infos($product->get_id());  ?>


		<!-- Nav tabs -->
		<div class="bg-black ">
		<h1 class="title-white text-center"><?php echo $product->get_name(); ?></h1>
		<h5 class="sub-title text-center"> <?php echo $details['subtitle']; ?></h5>
		<div class="container">

			<!-- Gallery + short descr -->
			<div class="row gallery-product-info">

				<div class="col-sm-6" id="product-gallery">
				<?php
					global $product;

					$attachment_ids = $product->get_gallery_attachment_ids();

					echo '<div class="slick-product">';
					echo '<div class="slick">';
					foreach ($attachment_ids as $id) {
						echo '<div>';
						echo '<img style="max-width: 300px;margin: auto;" src="' .  wp_get_attachment_url( $id ) . '">';
						echo '</div>';
					}

					echo '</div>';
					echo '</div>';
					echo '<script>

					jQuery(document).ready(function( $ ) {

						$(".slick").slick({


							  speed: 300,
							  slidesToShow: 1,
							  slidesToScroll: 1,
							  dots: true,
							  responsive: [
								  {
									breakpoint: 1025,
									settings: {
									  slidesToShow: 2,
									  slidesToScroll: 2,
									  infinite: true,
									  dots: true
									}
								  },
								  {
									breakpoint: 600,
									settings: {
									  slidesToShow: 1,
									  slidesToScroll: 1
									}
								  }

								]
							});

					});

					</script>';

				?>
				</div>

				<div class="col-sm-6">

					<div class="short-descr-warpper">
						<?php echo $details['shortdescr']; ?>
					</div>

					<!-- <div class="product-q"> <a class="show-more pdt-shop-btn" href="<?php echo get_site_url() .  "/?add-to-cart="  . $product->get_id() . "&quantity=1" ?>">Shop now</a>
						<input type="text" class="quantity-product input-q" name="quantity" value="1" class="qty" style="margin-bottom: 0px !important" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
						<div class="plus-minus">
							<input type="button" value="+" class="qtyplus stack input-q"  field="quantity" style="font-weight: bold;" />
							<input type="button" value="-" class="qtyminus stack input-q" field="quantity" style="font-weight: bold;" />
						</div>
					</div> -->

				</div>

			</div>


			<!-- TAB -->
			<ul class="nav-product-info nav nav-tabs nav-fill nav-fill">
				<li class="nav-item ">
					<a class="nav-link active product-info-tab first-tab" data-toggle="tab" href="#description-panel">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link product-info-tab " data-toggle="tab" id="test" href="#ingredients-panel">Ingredients</a>
				</li>
				<li class="nav-item">
					<a class="nav-link product-info-tab" data-toggle="tab" href="#nutrition-panel">Nutrition</a>
				</li>
				<li class="nav-item">
					<a class="nav-link product-info-tab last-tab" data-toggle="tab" href="#reviews-panel">Reviews</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content product-info-tab-content">

				<div class="tab-pane container active" id="description-panel">
					<div class="row">

						<div class="col-sm align-center">

							<div class="wrap">

								<div class="zoom-photo">
									<?php

									if (!empty($details['image-product'])) {
										echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:95%;display:block;" />';
										?>
										<script>
										jQuery(document).ready(function( $ ) {
											$(".zoom-photo").zoom();
										});
										</script>
										<?php
									}  else {
										echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
									}
									?>

								</div>
							</div>
						</div>

						<div class="col-sm text-center align-center" >
							<div>
								<h1 class="title-tab">Description</h1>
								<div class="description-tab">
									<?php echo $details['description']; ?>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- END Description panel-->

				<div class="tab-pane container fade" id="ingredients-panel">
					<div class="row">
						<div class="col-sm align-center">

							<div class="wrap">

								<div class="zoom-photo">
									<?php

									if (!empty($details['image-product'])) {
										echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:95%;display:block;" />';
										?>
										<script>
										jQuery(document).ready(function( $ ) {
											$(".zoom-photo").zoom();
										});
										</script>
										<?php
									}  else {
										echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
									}
									?>

								</div>
							</div>
						</div>

						<div class="col-sm description-tab">
							<?php echo $details['ingredients']; ?>
						</div>

					</div>
				</div>

				<div class="tab-pane container fade" id="nutrition-panel">
					<div class="row">
						<div class="col-sm align-center">

							<div class="wrap">

								<div class="zoom-photo">
									<?php

									if (!empty($details['image-product'])) {
										echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:95%;display:block;" />';
										?>
										<script>
										jQuery(document).ready(function( $ ) {
											$(".zoom-photo").zoom();
										});
										</script>
										<?php
									}  else {
										echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
									}
									?>

								</div>
							</div>
						</div>

						<div class="col-sm description-tab">

							<div class="wpnf-label " id="wpnf-500"><div class="heading">
								Nutrition Facts
							</div>

							<hr class="hr-small">

							<div class="wpnf_servings item_row wpnf_cf">
								 <?php
								 if ($details['nutritions']['serving'] == "Varied")
								 	echo $details['nutritions']['serving'];
								 else
								  	echo "About" . $details['nutritions']['serving'];
								 ?> Servings Per Container
							</div>

							<strong> Serving size</strong> <span class="f-right">  1oz. (30g) </span>
							<hr class="hr-big">
							<div class="item_row wpnf_cf no-border">
								<span class="f-left">Amount per serving</span><br>
								<span class="f-left">
									<strong class="wpnf_item_title calories">Calories</strong>
								</span>
								<span class="f-right calories-tot"><?php echo $details['nutritions']['cal']; ?></span>
							</div>

							<hr class="hr-big">

							<div class="amount-per small item_row wpnf_cf">
								<span class="f-left">Amount</span>
								<span class="f-right">% Daily Value*</span>
							</div>

							<div class="item_row wpnf_cf">
								<span class="f-left">
									<strong class="wpnf_item_title">Total Fat </strong>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['tot_fats']['val']; ?>g</span>
								</span> <span class="f-right"><strong><?php echo $details['nutritions']['tot_fats']['perc']; ?>%</strong></span>
							</div>
							<div class="indent item_row wpnf_cf">
								<span class="f-left">
									<span class="wpnf_item_title">Saturated Fat </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['sat_fats']['val']; ?>g</span>
								</span> <span class="f-right"><strong><?php echo $details['nutritions']['sat_fats']['perc']; ?>%</strong></span>
							</div>
							<div class="indent item_row wpnf_cf">
								<span>
									<span class="wpnf_item_title">Trans Fat </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['trans_fats']; ?>g</span>
								</span>
							</div>
							<div class="item_row wpnf_cf">
								<span class="f-left">
									<strong class="wpnf_item_title">Cholesterol </strong>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['chol_fats']['val']; ?>mg</span>
								</span> <span class="f-right"><strong><?php echo $details['nutritions']['chol_fats']['perc']; ?>%</strong></span>
							</div>

							<div class="item_row wpnf_cf">
								<span class="f-left">
									<strong class="wpnf_item_title">Sodium </strong>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['sodium']['val']; ?>mg</span>
								</span> <span class="f-right"><strong><?php echo $details['nutritions']['sodium']['perc']; ?>%</strong></span>
							</div>
							<div class="item_row wpnf_cf">
								<span class="f-left">
									<strong class="wpnf_item_title">Total Carbohydrate </strong>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['t_carb']['val']; ?>g</span>
								</span>
								<span class="f-right"><strong><?php echo $details['nutritions']['t_carb']['perc']; ?>%</strong></span>
							</div>
								<div class="indent item_row wpnf_cf">
									<span>
										<span class="wpnf_item_title small-items">Dietary Fiber</span>
										<span class="wpnf_item_tot"><?php echo $details['nutritions']['fiber']['val']; ?>g</span>
									</span>
									<span class="f-right"><strong><?php echo $details['nutritions']['fiber']['perc']; ?>%</strong></span>
								</div>

								<div class="indent item_row wpnf_cf">
									<span>
										<span class="wpnf_item_title small-items">Total Sugars </span>
										<span class="wpnf_item_tot"><?php echo $details['nutritions']['t_sugar']['val']; ?>g</span>
									</span>
								</div>

								<div class="indent-double item_row wpnf_cf">
									<span>
										<span class="wpnf_item_title small-items">Includes</span>
										<span class="wpnf_item_tot small-items"><?php echo $details['nutritions']['added']; ?>g Added Sugars</span>
									</span>
									<span class="f-right"><strong><?php echo $details['nutritions']['t_sugar']['perc']; ?>%</strong></span>
								</div>


							<div class="item_row wpnf_cf">
								<span class="f-left">
									<strong class="wpnf_item_title">Protein </strong>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['protein']; ?>g</span>
								</span>
							</div>

							<hr class="hr-big">
							<div class="item_row wpnf_cf no-border">
								<span class="f-left">
									<span class="wpnf_item_title small-items">Vitamin D </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['vit_d']['val']; ?>mg</span>
								</span> <span class="f-right"><?php echo $details['nutritions']['vit_d']['perc']; ?>%</span>
							</div>
							<div class="item_row wpnf_cf">
								<span class="f-left">
									<span class="wpnf_item_title small-items">Calcium </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['calcium']['val']; ?>mg</span>
								</span> <span class="f-right"><?php echo $details['nutritions']['calcium']['perc']; ?>%</span>
							</div>

							<div class="item_row wpnf_cf">
								<span class="f-left">
									<span class="wpnf_item_title small-items">Iron </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['iron']['val']; ?>mg</span>
								</span> <span class="f-right"><?php echo $details['nutritions']['iron']['perc']; ?>%</span>
							</div>

							<div class="item_row wpnf_cf">
								<span class="f-left">
									<span class="wpnf_item_title small-items">Potassium </span>
									<span class="wpnf_item_tot"><?php echo $details['nutritions']['potassium']['val']; ?>mg</span>
								</span> <span class="f-right"><?php echo $details['nutritions']['potassium']['perc']; ?>%</span>
							</div>
						<hr>

						<div class="small wpnf_cf"> *The Daily Values tells you how much a nutrient in a serving of food contributes to a daily diet.</div></div>
						</div>

					</div>
				</div>

				<div class="tab-pane container fade" id="reviews-panel">
					<div class="row">
						<div class="col-sm align-center">

							<div class="wrap">

								<div class="zoom-photo">
									<?php

									if (!empty($details['image-product'])) {
										echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:95%;display:block;" />';
										?>
										<script>
										jQuery(document).ready(function( $ ) {
											$(".zoom-photo").zoom();
										});
										</script>
										<?php
									}  else {
										echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
									}
									?>

								</div>
							</div>
						</div>
						<div class="col-sm text-center align-center" >
							<?php comments_template(); ?>
						</div>
					</div>
				</div>


				<div class='prev-tab' name='next' id="prev"> < </div>
				<div class='next-tab' name='previous' id="next"> > </div>

		  </div>


		  <div class="cross-sell">
		  	<h1 class="title-white text-center p-8"> you may also like ...</h1>
		  	<?php

		  		global $product;
		  		$cross_sell_ids = $product->get_cross_sell_ids();

				echo '<div class="container cross-product">';
		  	  	echo '<div class="row">';

		  		foreach ( $cross_sell_ids as $id ) {

		  		  $product = wc_get_product( $id );

				  echo '<div class="col-sm-4 text-center">';
				  echo '<a  href="' . $product->get_permalink() .'">' . $product->get_image(). '</a>';
				  echo '<div class="text-center">';
				  echo '<a  href="' . $product->get_permalink() .'"><h4 class="title">' .$product->get_name() . '</h4></a>';
				  echo '<a class="show-more" href="' . $product->get_permalink() .'">Discover</a>';
				  echo '</div>';
				  echo '</div>';
		  	  }

			  echo '</div>';
			  echo '</div>';
		  	?>
		  </div>


		</div> <!-- container -->
	</div> <!-- BG BLACK -->
</div>

<?php	Widget_Social::render_widget(true); ?>

<script>
jQuery(function($) {
	$('#next').click(function() {
		$('a.nav-link.active').parent().next('li').find('a').trigger('click');
	});

	 $('#prev').click(function(){
		$('a.nav-link.active').parent().prev('li').find('a').trigger('click');
	});

});
jQuery(document).ready(function( $ ) {
	$('.parallax-window').parallax({imageSrc: '<?php echo $img_src ?>', zIndex: 12 });
});
</script>

<style>

.hero-image {
    /* The image used */
    /*background-image: url("<?php echo $img_src ?>");*/

    /* Set a specific height */
    height: 50vh;
	z-index: 12;
    /* Position and center the image to scale nicely on all screens */
    /* background-position: center;
    background-repeat: no-repeat;
    background-size: auto;
    position: relative; */
    max-width: 400px;
	margin:auto;
}
</style>
