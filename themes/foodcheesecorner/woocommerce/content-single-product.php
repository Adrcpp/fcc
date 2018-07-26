
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
<div id="product-<?php the_ID(); ?>">

	<?php
		$post_thumbnail_id = $product->get_image_id();
		$img_src = wp_get_attachment_image_src( $post_thumbnail_id, "full")[0]

	?>
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
<style>

.hero-title {
	font-size: 60px;
}

.prev {
	line-height: 0;
	position: absolute;
	top: 50%;
	display: block;
	width: 20px;
	height: 20px;
	padding: 0;
	-webkit-transform: translate(0, -50%);
	-ms-transform: translate(0, -50%);
	transform: translate(0, -50%);
	cursor: pointer;
	color: transparent;
	border: none;
	outline: none;
	background: transparent;
}

.next {
	line-height: 0;
	position: absolute;
	top: 50%;
	display: block;
	width: 20px;
	height: 20px;
	padding: 0;
	-webkit-transform: translate(0, -50%);
	-ms-transform: translate(0, -50%);
	transform: translate(0, -50%);
	cursor: pointer;
	color: transparent;
	border: none;
	outline: none;
	background: transparent;
	right: 0;
}
.warpper-hero {
	height: 60vh;
	background-color: black;
}

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

/* Place text in the middle of the image */
.hero-text {
	text-align: center;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	color: white;
	    width: 100%;
}
</style>
	<div class="summary entry-summary">
		<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
