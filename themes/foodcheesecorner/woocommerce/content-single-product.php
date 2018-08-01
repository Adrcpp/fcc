
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
	 $nex_post =  get_previous_post(false, '', 'product_cat');
	 $prev_post = get_next_post(false, '', 'product_cat');

	//var_dump($nex_post, $prev_post);
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
		<div class='next-fromage'> <a class="sub-title next-fromage-link" href="<?php echo $nex_post->guid; ?>" > <?php echo  $nex_post->post_title; ?>  > </a> </diV>
		<div class='prev-fromage'> <a class="sub-title next-fromage-link" href="<?php echo $prev_post->guid; ?>" > < <?php echo $prev_post->post_title; ?></a> </diV>
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

					<div class="short-descr-warpper">
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

						<div class="col-sm">

							<div class="wrap">

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
						<div class="col-sm">
						</div>
						<div class="col-sm description-tab">
							<?php echo $details['ingredients']; ?>
						</div>
						<div class="col-sm">
						</div>
					</div>
				</div>

				<div class="tab-pane container fade" id="nutrition-panel">
					<div class="row">
						<div class="col-sm">
						</div>
						<div class="col-sm description-tab">
							<?php echo $details['nutrition']; ?>
						</div>
						<div class="col-sm">
						</div>
					</div>
				</div>

				<div class="tab-pane container fade" id="reviews-panel">
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
</div>

<?php	Widget_Social::render_widget(); ?>


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
