<?php
/**
 * Plugin Name:       Inspyde - Lovely-Users
 * Plugin URI:        
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Azka Asif
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages

*/ 
'use strict';
defined('ABSPATH') or die("die");
use InpsydeLovelyUsers\LovelyUsersApi;
if (file_exists(plugin_dir_path(__FILE__) . '/vendor/autoload.php')) {
    require_once(plugin_dir_path(__FILE__) . '/vendor/autoload.php');
    flush_rewrite_rules();
    // if ( is_plugin_active( plugin_dir_path(__FILE__) ) ) {
        $object = new LovelyUsersApi();
        $object->init();
    // }
    
    // InpsydeLovelyUsers\LovelyUsersApi::init();
    
}



