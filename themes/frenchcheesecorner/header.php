<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" type="image/png" href="<?php echo get_site_url() . "/wp-content/uploads/2018/09/favicon.png"; ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

<div id="page" class="container-fluid p-0">
  <div class="header-wrapper">



  <div class="header-navbar">
  <div class="container">

	<nav class="navbar navbar-expand-lg p-0 navbar-light">

		<div class="col text-center navbar-toggler header-logo-btn" >
			<?php
				use Functionality\Header_Logo;
				Header_Logo::get_menu_logo_button();
				if (is_user_logged_in()) {
					echo "<style>.header-navbar, .header-wrapper {top:32px !important;} </style>";
				}
			?>
		</div>

		<div class="collapse navbar-collapse justify-content-md-center text-center" id="navbarSupportedContent">

			<div class="col row">

				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-left',
					'menu_class'	 => 'navbar-nav px-2 col-xs-12 col-md-12',
					'menu_id'        => 'menu-left',
					'container'		 => '',
					'container_class'=> 'nav-item',
				) );
				?>
			</div>
			<div class="col header-col">
				<?php

				Header_Logo::get_header_menu_logo(true);
				?>
			</div>
			<div class="col">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-right',
					'menu_class'	 => 'navbar-nav px-2',
					'menu_id'        => 'menu-right',
					'container'		 => '',
					'container_class'=> 'nav-item',
				) );
				?>
			</div>
		</div>
	</nav><!-- #site-navigation -->

</div>
</div>
<button class="navbar-toggler custom-pos" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon custom-hamb"></span>
</button>

<!-- <div id="cart-container">
  <div id="cart">
	<a class="cart-top" href="<?php // echo WC()->cart->get_cart_url(); ?>"> <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i> </a>
  </div>
  <span id="itemCount"></span>
</div> -->

</div>
	<div id="content" class="container-fluid p-0">

<!--
<script>

	(function( $ ) {
			var itemCount = <?php //echo WC()->cart->get_cart_contents_count(); ?>;

			$('.add').click(function (){
			  itemCount ++;
			  $('#itemCount').html(itemCount).css('display', 'block');
			});

			$('#itemCount').html(itemCount).css('display', 'block');

	})( jQuery );

</script> -->
