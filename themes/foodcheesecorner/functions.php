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

	wp_register_script('filter_ajax_scripts', get_template_directory_uri() . '/js/filter_ajax_scripts.js');
	wp_localize_script('filter_ajax_scripts', 'WPURLS', array( 'siteurl' => admin_url( 'admin-ajax.php' ) ));
	//wp_enqueue_script( 'filter_ajax_scripts', get_template_directory_uri() . '/js/filter_ajax_scripts.js', array('jquery'), array('jquery'), null, false );
	wp_enqueue_script( 'filter_ajax_scripts' );
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


require get_template_directory() . '/inc/widget/Woo_Slider.php';
require get_template_directory() . '/inc/widget/Woo_Product_Filter.php';
// Register and load the widget
function wpb_load_widget() {
	register_widget( 'WP_Widget_Woo_Slider' );
	register_widget( 'WP_Widget_Product_Filter' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


function ajax_filter_product() {

	$milk = sanitize_text_field($_POST['milk']);
	$texture = sanitize_text_field($_POST['texture']);

	$is_unique = false;
	$all = false;

	if ($texture == 24 && $milk == 21) {
		$all = true;
	}

	if ($texture == 24) {
		$is_unique = true;
		$texture = null;
	}

	if ($milk == 21) {
		$is_unique = true;
		$milk = null;
	}

	$query = new WC_Product_Query();
	$products = $query->get_products();
	$resp = "";
	$count = 0;

	foreach ($products as $key => $value) {
		$cat_ids = $value->get_category_ids();
		if ( isSelected($all, $cat_ids, $is_unique, $milk, $texture) ) {

			 $resp .= '<div class="col-sm-4 text-center">';
			 $resp .= $value->get_image();
			 $resp .= '<div class="text-center">';
			 $resp .= '<h4 class="title">' .$value->get_name() .'</h4>';
			 $resp .= '<a class="show-more" href="' . $value->get_permalink() .'">Show more</a>';
			 $resp .= '</div>';
			 $resp .= '</div>';
			 ++$count;
		 }

	 }

	header( "Content-Type: application/json" );
	echo json_encode(["result" => $resp, "count" => $count]);

	wp_die();
}

function isSelected($all, $cat_ids, $is_unique, $milk, $texture)
{
	if ($all == true)
		return true;

	if ($is_unique) {
		if ($milk != null) {
			return in_array($milk, $cat_ids);
		} else {
			return in_array($texture, $cat_ids);
		}
	}
	return (count(array_diff([$texture, $milk], $cat_ids)) == 0 );
}

add_action('wp_ajax_filter_product', 'ajax_filter_product');


add_action( 'woocommerce_product_options_general_product_data', 'misha_option_group' );

function misha_option_group() {
	echo '<div class="option_group">test</div>';
}


/******************
*
*	META test
*
******************/
function wpdocs_register_meta_boxes() {
    add_meta_box( 'meta-box-id', __( 'My Meta Box', 'textdomain' ), 'wpdocs_my_display_callback', 'product', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
	 wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
?>
	  <div class="form-group">
	    <label for="exampleInputEmail1">Email address</label>
	    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
	    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Password</label>
	    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
	  </div>
	  <div class="form-check">
	    <input type="checkbox" class="form-check-input" id="exampleCheck1">
	    <label class="form-check-label" for="exampleCheck1">Check me out</label>
	  </div>

<?php
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
}
add_action( 'save_post', 'wpdocs_save_meta_box' );


add_filter( 'get_user_option_meta-box-order_post', 'metabox_order' );
function metabox_order( $order ) {
    return array(
        'normal' => join(
            ",",
            array(       // vvv  Arrange here as you desire
                'customdiv-post',
				'commentsdiv',
                'editor',
                'slugdiv',
            )
        ),
    );
}

add_action( 'init', function() {
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'page', 'editor' );
	remove_post_type_support( 'product', 'editor' );
}, 99);

function remove_custom_field_meta_box()
{
    remove_meta_box("postcustom", "post", "normal");
}

/******************
*
*	META GALLERY
*
******************/
function render( $post ) {
	wp_nonce_field( 'gallery_meta_box', 'gallery_meta_box_nonce' );
	//$ids = get_post_meta( $post->ID, $this->meta_key(), true );
	if ( ! $ids ) {
		$ids = array();
	}
	?>
	<div id="truongwp-gallery-container" class="gallery">
		<?php foreach ( $ids as $id ) : ?>
			<div id="gallery-image-<?php echo absint( $id ); ?>" class="gallery-item">
				<?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>

				<a href="#" class="gallery-remove">&times;</a>

				<input type="hidden" name="gallery_meta_box[]" value="<?php echo absint( $id ); ?>">
			</div>
		<?php endforeach; ?>
	</div>

	<a href="#" id="truongwp-add-gallery"><?php esc_html_e( 'Set gallery images', 'gallery-meta-box' ); ?></a>

	<input type="hidden" id="truongwp-gallery-ids" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">
	<?php
}

function add() {
	add_meta_box(
		'truongwp-gallery',
		__( 'Gallery', 'gallery-meta-box' ),
		'render',
	 	'product', 'normal', 'high'
	);
}
add_action( 'add_meta_boxes', 'add' );

/**
 * Enqueue necessary js and css.
 */
function enqueue() {

	wp_enqueue_style( 'truongwp-gallery-meta-box', get_template_directory_uri() . '/css/gallery-meta-box.css', array(), false );
	wp_enqueue_script( 'truongwp-gallery-meta-box', get_template_directory_uri() .'/js/gallery-meta-box.js', array( 'backbone', 'jquery' ), false, true );
}

add_action( 'admin_enqueue_scripts',  'enqueue'  );
add_action( 'admin_footer',  'js_template' );

function js_template() {

	?>
	<script type="text/html" id="tmpl-gallery-meta-box-image">
		<div id="gallery-image-{{{ data.id }}}" class="gallery-item">
			<img src="{{{ data.url }}}">

			<a href="#" class="gallery-remove">&times;</a>

			<input type="hidden" name="gallery_meta_box[]" value="{{{ data.id }}}">
		</div>
	</script>
	<?php
}
