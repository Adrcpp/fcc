<?php
/*
Plugin Name:  Footer Custom Menu
Plugin URI:
Description:  Set Footer of the site
Version:      20160911
Author:       Adrien CESARO
Author URI:
License:      GPL2
License URI:
Text Domain:  wporg
Domain Path:  /languages
*/

function wpdocs_register_footer_menu_page(){
    add_menu_page(
        __( 'Custom Menu Title', 'textdomain' ), // page title
        'Footer menu',		  // menu name
        'manage_options',     // capability required for this menu to be displayed to the user
        'footer_logo_header',   // The slug name to refer to this menu by. Should be unique
        'print_footercustom_page', // Callback function that create the page
        '',					  // icon
        6					  // position
    );
    //add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'print_options_page' );
}
add_action( 'admin_menu', 'wpdocs_register_footer_menu_page' );


function print_footercustom_page()
{

    $post = get_page_by_title( "fcc_footer_content", OBJECT, 'post' );

    if ( $post->post_content ) {
        $content = $post->post_content;
    } else {
        $content = "";
    }

    echo "
        <div class='wrap'>
          <h2>Footer editor</h2>
            <form method='post' id='target'>";

                  wp_editor( $content, 'special_content', $settings = array('textarea_rows'=> '10') );
                  submit_button('Save', 'primary');

          echo " </form>
          </div>
    ";
}
/**
*	Add ajax for uploading attachment and create / update a post_meta
*   meta_key = header_logo_menu
*/
function ajax_save_footer_content() {

    // Get ajax parameter -
    $content = $_POST['content'];
    $user_id = get_current_user_id();
    $content_footer = array(
      'post_title'    => "fcc_footer_content",
      'post_content'  => $content,
      'post_status'   => 'publish',
      'post_author'   => $user_id,
      'post_type' => 'post'
    );

    if ( $post = get_page_by_title( "fcc_footer_content", OBJECT, 'post' ) )
        $content_footer["ID"] = $post->ID;

    $return = wp_insert_post( $content_footer );

    header( "Content-Type: application/json" );
    echo json_encode(["test" => $return, "content" => $content]);

    wp_die();
}
add_action('wp_ajax_save_footer_content', 'ajax_save_footer_content');

function include_save_footerscript() {
    /*
     * I recommend to add additional conditions just to not to load the scipts on each page
     * like:
     * if ( !in_array('post-new.php','post.php') ) return;
     */
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script( 'myuploadscript', plugins_url() .  '/footercustom/js/savescript.js', array('jquery'), array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'include_save_footerscript' );

function get_footer_content()
{
    $post = get_page_by_title( "fcc_footer_content", OBJECT, 'post' );

    echo $post->post_content;
}

?>
