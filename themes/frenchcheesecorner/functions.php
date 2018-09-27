<?php
/**
 * _s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _s_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-right' => esc_html__( 'Right menu', '_s' ),
			'menu-left'  => esc_html__( 'Left menu', '_s' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', '_s_setup' );

/**
*	Add class to <a> link item of t
*/

function atg_menu_classes($classes, $item, $args) {
    $classes[] = 'nav-link';
  return $classes;
}
add_filter('nav_menu_css_class', 'atg_menu_classes', 1, 3);

function add_menuclass($ulclass) {
   return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
}
add_filter('wp_nav_menu','add_menuclass');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


/**
 * Load Jquery and Bootstrap
 */
function my_customs_scripts(){
    //wp_enqueue_script( 'script-handler', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array('jquery'), '1.4.1', true );
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.4.1', true );
	wp_enqueue_script( 'bootstrap.bundle-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '1.4.1', true );
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.9.0', true );

	//wp_register_script('filter_ajax_scripts', get_template_directory_uri() . '/js/filter_ajax_scripts.js');
	//wp_localize_script('filter_ajax_scripts', 'WPURLS', array( 'siteurl' => admin_url( 'admin-ajax.php' ) ));
	//wp_enqueue_script( 'filter_ajax_scripts', get_template_directory_uri() . '/js/filter_ajax_scripts.js', array('jquery'), array('jquery'), null, false );
	//wp_enqueue_script( 'filter_ajax_scripts' );
}

add_action( 'wp_enqueue_scripts', 'my_customs_scripts' );

function my_front_customs_styles() {
    wp_enqueue_style( 'bootstrap-4', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
	wp_enqueue_style( 'bootstrap-grid', get_template_directory_uri() . '/css/bootstrap-grid.min.css', false, '4', 'all' );
	wp_enqueue_style( 'bootstrap-reboot', get_template_directory_uri() . '/css/bootstrap-reboot.min.css', false, '4', 'all' );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', false, '1.9.0', 'all' );
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/css/slick-theme.css', false, '1.9.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'my_front_customs_styles' );
//add_action( 'admin_head', 'my_front_customs_styles' );


function remove_custom_field_meta_box()
{
    remove_meta_box("postcustom", "post", "normal");
}

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_site_url()  . '/wp-content/uploads/2018/07/header-logo-1.png'; ?> );
			width: 100%;
		    background-size: contain;
		    background-repeat: no-repeat;
		    padding-bottom: 30px;
        }
		body.login.login-action-login.wp-core-ui.locale-en-us {
		    background-color: black !important;
		}

		label {
		    font-size: larger !important;
			color:white;
			color: #ffffff !important;
		}
		a {
		    color: white !important;
		}
		form#loginform {
		    background-color: black;
		    border-color: white;
		    border-style: solid;
		}

		input#wp-submit {
		    background-color: black;
		    text-shadow: unset;
		    color: white;
		    border-color: white;
		    width: 113px;
		}

		input#wp-submit:hover {
			background-color: white;
			color: black;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function add_async_forscript($url)
{
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' async='async";
}
add_filter('clean_url', 'add_async_forscript', 11, 1);

if (!is_admin()) {
    function add_asyncdefer_attribute($tag, $handle) {
        // if the unique handle/name of the registered script has 'async' in it
        if (strpos($handle, 'async') !== false) {
            // return the tag with the async attribute
            return str_replace( '<script ', '<script async ', $tag );
        }
        // if the unique handle/name of the registered script has 'defer' in it
        else if (strpos($handle, 'defer') !== false) {
            // return the tag with the defer attribute
            return str_replace( '<script ', '<script defer ', $tag );
        }
        // otherwise skip
        else {
            return $tag;
        }
    }
    add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
}

/* Checkout page: default open shipping adress */
// add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );


/*********************************************************************************************/
/** WooCommerce - Modify each individual input type $args defaults /**
*********************************************************************************************/

add_filter('woocommerce_form_field_args','wc_form_field_args',10,3);

function wc_form_field_args( $args, $key, $value = null ) {
/*
** This is not meant to be here, but it serves as a reference
** of what is possible to be changed.
$defaults = array(
    'type'              => 'text',
    'label'             => '',
    'description'       => '',
    'placeholder'       => '',
    'maxlength'         => false,
    'required'          => false,
    'id'                => $key,
    'class'             => array(),
    'label_class'       => array(),
    'input_class'       => array(),
    'return'            => false,
    'options'           => array(),
    'custom_attributes' => array(),
    'validate'          => array(),
    'default'           => '',
);
*********************************************************************************************/

// Start field type switch case

switch ( $args['type'] ) {

    case "select" :  /* Targets all select input type elements, except the country and state select input types */
        $args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag
        $args['input_class'] = array('form-control', 'input-lg'); // Add a class to the form input itself
        //$args['custom_attributes']['data-plugin'] = 'select2';
        $args['label_class'] = array('control-label');
        $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself
    break;

    case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
        $args['class'][] = 'form-group single-country';
        $args['label_class'] = array('control-label');
    break;

    case "state" : /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */
        $args['class'][] = 'form-group'; // Add class to the field's html element wrapper
        $args['input_class'] = array('form-control', 'input-lg'); // add class to the form input itself
        //$args['custom_attributes']['data-plugin'] = 'select2';
        $args['label_class'] = array('control-label');
        $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
    break;


    case "password" :
    case "text" :
    case "email" :
    case "tel" :
    case "number" :
        $args['class'][] = 'form-group';
        //$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
        $args['input_class'] = array('form-control', 'input-lg');
        $args['label_class'] = array('control-label');
    break;

    case 'textarea' :
        $args['input_class'] = array('form-control', 'input-lg');
        $args['label_class'] = array('control-label');
    break;

    case 'checkbox' :
    break;

    case 'radio' :
    break;

    default :
        $args['class'][] = 'form-group';
        $args['input_class'] = array('form-control', 'input-lg');
        $args['label_class'] = array('control-label');
    break;
    }

    return $args;
}


add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );

function iconic_cart_count_fragments( $fragments ) {

    $fragments['#itemCount'] = '<span id="itemCount" style="display: block;" >' . WC()->cart->get_cart_contents_count() . '</span>';

    return $fragments;
}

add_filter("woocommerce_checkout_fields", "order_fields");

function order_fields($fields) {

    $order = array(
		"billing_email",
		"billing_civility",
        "billing_first_name",
        "billing_last_name",
		"billing_phone",
        "billing_address_1",
        "billing_address_2",
        "billing_postcode",
        "billing_country",
    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;
    return $fields;
}


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_civility'] = array(
        'label'     => __('Civility', 'woocommerce'),
		'type'      => 'select',
		'options'   =>	array(
		  'mrs' => 'Mrs',
		  'mr'  => 'Mr'
		),
	    'placeholder'   => _x('Civility', 'placeholder', 'woocommerce'),
	    'required'  => true,
	    'class'     => array('form-row-wide'),
	    'clear'     => true
     );

     return $fields;
}

/**
 * Display field value on the order edit page
 */

add_action( 'woocommerce_admin_order_data_after_billing_email', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Civility').':</strong> ' . get_post_meta( $order->get_id(), '_billing_civility', true ) . '</p>';
}

//
// function js_async_attr($tag){
//
// # Do not add defer or async attribute to these scripts
// $scripts_to_exclude = array('jquery-3.3.1.min.js', 'script2.js', 'script3.js');
//
// foreach($scripts_to_exclude as $exclude_script){
//  if(true == strpos($tag, $exclude_script ) )
//  return $tag;
// }
//
// # Defer or async all remaining scripts not excluded above
// return str_replace( ' src', ' defer="defer" src', $tag );
// }
// add_filter( 'script_loader_tag', 'js_async_attr', 10 );
