
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
	?>
	<div class="bg-black">
	<div class="warpper-hero jumbotron vertical-center">
		<div class="hero-image">
			<div class="hero-text">
				<h1 class="hero-title"><?php echo $product->get_name(); ?></h1>
				<p><?php $product->get_title(); ?></p>
				<button>Hire me</button>
				<div class='prev'><?php echo next_post_link('%link', '&larr; PREVIOUS', false, ' ', 'product_cat');; ?> </diV>
					<div class='next'><?php echo previous_post_link('%link', 'NEXT &rarr;', false, ' ', 'product_cat');; ?> </div>
				</div>
			</div>
		</div>

		<?php
			$args = array(
					'delimiter' => '/',
			);
		?>

		<?php woocommerce_breadcrumb( $args ); ?>

		</div>

		<?php  $details = get_product_infos($product->get_id());  ?>


		<!-- Nav tabs -->
		<div class="bg-black ">

		<div class="container">

			<!-- Gallery + short descr -->
			<div class="row gallery-product-info">

				<div class="col-sm-4" id="product-gallery">
				<?php
					global $product;

					$attachment_ids = $product->get_gallery_attachment_ids();

					echo '<div class="container slick-container">';
					echo '<div class="slick">';
					foreach ($attachment_ids as $id) {
						echo '<div>';
						echo '<img style="max-width: 200px;margin: auto;" src="' .  wp_get_attachment_url( $id ) . '">';
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

				<div class="col-sm-6 text-center">
					<h1 class="title-white">Short description</h1>

					<div class="">
						<?php echo $details['shortdescr']; ?>
					</div>

				</div>

			</div>


			<!-- TAB -->
			<ul class="nav-product-info nav nav-tabs nav-fill">
				<li class="nav-item ">
					<a class="nav-link active product-info-tab first-tab" data-toggle="tab" href="#description-panel">Description</a>
				</li>
				<li class="nav-item">
					<a class="nav-link product-info-tab " data-toggle="tab" href="#ingredients-panel">Ingredients</a>
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

						<div class="col-sm">

							<div class="wrap">
								<!-- self::image_uploader_field() -->
								<div>
									<?php

									if (!empty($details['image-product'])) {
										echo '<img class="true_pre_image" id="img" src="' . $details['image-product'] . '" style="max-width:95%;display:block;" />';
									}  else {
										echo '<img class="true_pre_image" id="img" src="" style="max-width:95%;display:block;" />';
									}
									?>

								</div>
							</div>
						</div>

						<div class="col-sm text-center" >
							<h1 class="title-white">Description</h1>

							<div class="postbox">
								<?php $details['description']; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane container fade" id="ingredients-panel">
					<div class="row">
						<div class="col-sm">
							<?php $details['ingredients']; ?>
						</div>
					</div>
				</div>

				<div class="tab-pane container fade" id="nutrition-panel">
					<div class="row">
						<div class="col-sm">
							<?php $details['nutrition']; ?>
						</div>
					</div>
				</div>

				<div class="tab-pane container fade" id="reviews-panel">
				</div>


					<input type='button' class='btn button-next prev' name='next' id="next" value='Next' />


					<input type='button' class='btn button-previous next' name='previous' id="prev" value='Previous' />

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
				  echo $product->get_image();
				  echo '<div class="text-center">';
				  echo '<h4 class="title">' .$product->get_name() . '</h4>';
				  echo '<a class="show-more" href="' . $product->get_permalink() .'">Show more</a>';
				  echo '</div>';
				  echo '</div>';
		  	  }

			  echo '</div>';
			  echo '</div>';
		  	?>
		  </div>


		</div> <!-- container -->
	</div> <!-- BG BLACK -->


<?php	Widget_Social::render_widget(); ?>


<script>
jQuery(function($) {
	$('#next').click(function() {
		console.log("click");
		console.log($('a.nav-link.active'));
	 	//$('a.nav-link.active').removeClass('.active').next('a.nav-link').addClass('.active');
		$('a.nav-link.active').next().css( "background", "yellow" )
	});

	 $('#prev').click(function(){
	 $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});
});
</script>
<style>

.hero-image {
    /* The image used */
    background-image: url("<?php echo $img_src ?>");

    /* Set a specific height */
    height: 50vh;

    /* Position and center the image to scale nicely on all screens */
    background-position: center;
    background-repeat: no-repeat;
    background-size: auto;
    position: relative;
    width: 100%;
}

</style>
