<?php

namespace Functionality;


class Footer_Builder {

    function __construct()
    {
        self::init();
    }

    public static function singleton()
    {
        static $single;
        return empty( $single ) ? $single = new self() : $single;
    }

    private function init()
    {
        add_action( 'admin_menu', array($this, 'wpdocs_register_footer_menu_page') );
        add_action( 'wp_ajax_save_footer_content', array($this, 'ajax_save_footer_content') );
        add_action( 'admin_enqueue_scripts', array($this, 'include_save_footerscript') );
        add_action( 'init', array($this, 'create_post_type') );
    }

    /*
    *   Register page in admin board
    */
    function wpdocs_register_footer_menu_page(){
        add_menu_page(
            __( 'Custom Menu Title', 'textdomain' ),     // page title
            'Footer',		                             // menu name
            'manage_options',                            // capability required for this menu to be displayed to the user
            'footer_logo_header',                        // The slug name to refer to this menu by. Should be unique
            array($this, 'print_footercustom_page'),     // Callback function that create the page
            '',					                         // icon
            6					                         // position
        );
        //add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'print_options_page' );

        //add_menu_page('FeaturedJobs', 'Featured Jobs', 'edit_posts', admin_url('post.php?post=60&action=edit'), 6);
    }


    function print_footercustom_page()
    {
        $url = get_site_url() . "/wp-admin/post.php?post=60&action=edit";
        header("Location: $url"); /* Redirect browser */
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
          'post_type' => 'fcc_footer_content'
        );

        if ( $post = get_page_by_title( "fcc_footer_content", OBJECT, 'fcc_footer_content' ) )
            $content_footer["ID"] = $post->ID;

        $return = wp_insert_post( $content_footer );

        header( "Content-Type: application/json" );
        echo json_encode(["test" => $return, "content" => $content]);

        wp_die();
    }


    function include_save_footerscript() {
        /*
         * I recommend to add additional conditions just to not to load the scipts on each page
         * like:
         * if ( !in_array('post-new.php','post.php') ) return;
         */
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        wp_enqueue_script( 'myuploadscript', plugins_url() .  '/FCC/js/savescript.js', array('jquery'), array('jquery'), null, false );
    }


    function get_footer_content()
    {
        $post = get_page_by_title( "fcc_footer_content", OBJECT, 'fcc_footer_content' );
        echo do_shortcode($post->post_content);
    }

    function create_post_type() {
        register_post_type( 'fcc_footer_content',
            array(
                'labels' => array(
                    'name' => __( 'FCC Footer' ),
                    'singular_name' => __( 'FCC Footer' )
                ),
                'public'             => true,
                'has_archive'        => false,
                'show_ui'            => true,
                'show_in_menu'       => false,
            )
        );
    }

}




 ?>
