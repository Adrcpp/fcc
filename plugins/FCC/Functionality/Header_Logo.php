<?php

namespace Functionality;

class Header_Logo {

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
        add_action( 'admin_enqueue_scripts', array($this, 'include_myuploadscript') );
        add_action( 'admin_menu',            array($this, 'wpdocs_register_my_custom_menu_page') );
        add_action( 'wp_ajax_upload_img',    array($this, 'ajax_upload_img') );
    }

    public function include_myuploadscript() {
        /*
         * I recommend to add additional conditions just to not to load the scipts on each page
         * like:
         * if ( !in_array('post-new.php','post.php') ) return;
         */
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_script( 'myuploadscript', plugins_url() .  '/FCC/js/customscript.js', array('jquery'), array('jquery'), null, false );
    }

    public function wpdocs_register_my_custom_menu_page(){
	    add_menu_page(
	        __( 'Custom Menu Title', 'textdomain' ), // page title
	        'Header Logo',		                     // menu name
	        'manage_options',                        // capability required for this menu to be displayed to the user
	        'menu_logo_header',                      // The slug name to refer to this menu by. Should be unique
	        array($this, 'print_options_page'),      // Callback function that create the page
	        '',					                     // icon
	        6					                     // position
	    );
	}

    /*
    *   Print html admin page
    */
    public function print_options_page() {

        if ( isset( $_REQUEST['saved'] ) ) {
            echo '<div class="updated"><p>Saved.</p></div>';
        }

        echo '<div class="wrap"><form method="post" enctype="multipart/form-data" id="target">'
        . self::image_uploader_field()
        . '<p class="submit">
            <input name="save" type="submit" class="button-primary" value="Save changes" />
            </p></form>
            </div>';
    }

    /*
    *   Render the logo image and add button
    */
    public function image_uploader_field() {
        $image = ' button">Upload image';
        $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
        $display = 'none';    // display state ot the "Remove image" button

        global $wpdb;
        $value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s LIMIT 1" , "header_logo_menu") );

        if ( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
            $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
            $display = 'inline-block';
        }

        return '
        <div>
            <a href="#" class="upload_image_button' . $image . '</a>
            <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
            <a href="#" class="remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
        </div>';
    }

    /**
    *	Add ajax for uploading attachment and create / update a post_meta
    *   meta_key = header_logo_menu
    */
    public function ajax_upload_img() {

        // Get ajax parameter - Url and id of the post attachment
        $img_src = sanitize_text_field($_POST['url']);
        $id_attachment = sanitize_text_field($_POST['id']);

        // get old post id if exist
        global $wpdb;
        $value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s LIMIT 1" , "header_logo_menu") );

        if ($value) {
            $return = update_post_meta($value, "header_logo_menu", $id_attachment);
        } else {
            $return = update_post_meta($id_attachment, "header_logo_menu", $id_attachment);
        }

        header( "Content-Type: application/json" );
        echo json_encode(["test" => $return]);

        wp_die();
    }

    public static function get_header_menu_logo()
    {
    	global $wpdb;
    	$value = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s LIMIT 1" , "header_logo_menu") );

    	if ( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
    		// $image_attributes[0] - image URL
    		// $image_attributes[1] - image width
    		// $image_attributes[2] - image height
    		echo '<a class="logo-top" href="'. get_home_url() .'"><img src="' . $image_attributes[0] . '" class="img-fluid px-4 header-logo" /></a>';
    	}
    }
}
