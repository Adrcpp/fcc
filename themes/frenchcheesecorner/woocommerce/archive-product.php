<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

?>
<header class="woocommerce-products-header">


	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
$page_title = $wp_query->post->post_title;

if ( woocommerce_product_loop() && $page_title == "") {


	echo '<div class="container-fluid bg-black">
	<div id="cheese-count"></div>
	<div class="container">
	<div id="products" class="row">';

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {

			the_post();


			$data = get_post_meta(get_the_ID(), "fcc_product_info");
			$value = wc_get_product( get_the_ID() );
			//
			// echo '<div class="col-sm-4 text-center">';
			// echo $value->get_image();
			// echo '<div class="text-center">';
			// echo '<h4 class="title">' .$value->get_name() .'</h4>';
			// echo '<h6 class="sub-title">' . $data[0]["subtitle"] .'</h6>';
			// // echo '<div class="product-q"> <a class="show-more" href="' . $value->get_permalink() .'">Shop now</a> ' ;
			//
			// echo '<div class="product-q"> <a class="show-more" href="' . get_site_url() . "/?add-to-cart=" . $value->get_id() .'&quantity=1">Shop now</a> ' ;
			//
			// echo '<input type="text" class="quantity-product input-q" name="quantity" value="1" class="qty" style="margin-bottom: 0px !important" onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
			//     <div class="plus-minus">
			//
			//         <input type="button" value="+" class="qtyplus stack input-q"  field="quantity" style="font-weight: bold;" />
			//         <input type="button" value="-" class="qtyminus stack input-q" field="quantity" style="font-weight: bold;" />
			//     </div>
			// </div>';
			// echo '</div>';
			// echo '</div>';


			echo '<div class="col-sm-4 text-center">';
			echo '<a  href="' . $value->get_permalink() . '">' . $value->get_image() .'</a>';
			echo '<div class="text-center">';
			echo '<h4 class="title">' .$value->get_name() .'</h4>';
			echo '<h6 class="sub-title">' . $data[0]["subtitle"] .'</h6>';
			// echo '<div class="product-q"> <a class="show-more" href="' . $value->get_permalink() .'">Shop now</a> ' ;

			echo '<div class="product-q"> <a class="show-more" href="' . $value->get_permalink() . '">Discover</a> </div>' ;
			echo '</div>';
			echo '</div>';
		}
	}
	echo '</div></div></div>';
	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );

	Widget_Social::render_widget(true);
}


get_footer( 'shop' );
