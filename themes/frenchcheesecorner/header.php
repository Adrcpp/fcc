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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

<div id="page" class="container-fluid p-0">
  <div class="header-navbar">
  <div class="container">
	<nav class="navbar navbar-expand-lg p-0 navbar-light">

		<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		</button> -->


		<div class="col text-center navbar-toggler header-logo-btn" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<?php
				use Functionality\Header_Logo;
				Header_Logo::get_menu_logo_button();
				if (is_user_logged_in()) {
					echo "<style>.header-navbar {top:32px !important;}</style>";
				}
			?>
		</div>

		<div class="collapse navbar-collapse justify-content-md-center text-center" id="navbarSupportedContent">

			<div class="col row">
				<ul class="col-xs-0 col-md-6 col-lg-6"></ul>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-left',
					'menu_class'	 => 'navbar-nav px-2 col-xs-12 col-md-6',
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
	<div id="content" class="container-fluid p-0">
