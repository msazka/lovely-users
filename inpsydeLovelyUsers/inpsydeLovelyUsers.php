<?php
/**
 * Plugin Name:       Inspyde - Lovely-Users
 * Plugin URI:        
 * Description:       Shows a list of lovely users implemented by modular approach
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
        $object = new LovelyUsersApi();
        $object->init();  
}


// use Inpsyde\Modularity\Properties;
// $properties = Properties\PluginProperties::new('wp-content/plugins/inpsydeLovelyUsers/inpsydeLovelyUsers.php');
// - `PluginProperties::network(): bool` - returns if the Plugin is only network-wide usable.
// $isActive = PluginProperties::isActive(): bool` - returns if the current Plugin is active.
// - `PluginProperties::isNetworkActive(): bool` - returns if the current Plugin is network-wide active.
// - `PluginProperties::isMuPlugin(): bool` - returns if the current Plugin is a must-use Plugin.



