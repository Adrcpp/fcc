<?php
/*
Plugin Name:  Food Corner Cheese plugin
Plugin URI:
Description:  Add different functionnality for customing the front end
Version:      0.1
Author:       Adrien CESARO
Author URI:
License:      GPL2
License URI:
Text Domain:  wporg
Domain Path:  /languages
*/
namespace FCC;

use Functionality\Footer_Builder;
use Functionality\Header_Logo;

class FCC_Plugin {

    function __construct()
    {
        spl_autoload_register(function($class){

            $filename = __DIR__ . '\\' . $class . '.php';
            //var_dump($filename);
            if (!file_exists($filename)) {
                return false; // End autoloader function and skip to the next if available.
            }
            include $filename;
            return true; // End autoloader successfully.
        });

        self::init();
    }
    /*
    *   Singleton
    */

    public static function singleton()
    {
        static $single;
        return empty( $single ) ? $single = new self() : $single;
    }

    /*
    *   Init:: register js / css
    *
    */
    public function init()
    {
        Footer_Builder::singleton();
        Header_Logo::singleton();
    }
}

FCC_Plugin::singleton();
