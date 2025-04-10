<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              
 * @since             1.0.0
 * @package           Wbcom_Product_Testimonials
 *
 * @wordpress-plugin
 * Plugin Name:       Product Testimonials
 * Plugin URI:        
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            WPCOM
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wbcom-product-testimonials
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WBCOM_PRODUCT_TESTIMONIALS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/wbcom-class-product-testimonials-activator.php
 */
function wbcom_activate_product_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wbcom-class-product-testimonials-activator.php';
	Wbcom_Product_Testimonials_Activator::wbcom_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/wbcom-class-product-testimonials-deactivator.php
 */
function wbcom_deactivate_product_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wbcom-class-product-testimonials-deactivator.php';
	Wbcom_Product_Testimonials_Deactivator::wbcom_deactivate();
}

register_activation_hook( __FILE__, 'wbcom_activate_product_testimonials' );
register_deactivation_hook( __FILE__, 'wbcom_deactivate_product_testimonials' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/wbcom-class-product-testimonials.php';

//Plugin Constant
if ( !defined( 'WBCOM_DIR' ) ) {
	define('WBCOM_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WBCOM_URL' ) ) {
	define('WBCOM_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WBCOM_HOME' ) ) {
	define('WBCOM_HOME', home_url() );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wbcom_run_product_testimonials() {

	$plugin = new Wbcom_Product_Testimonials();
	$plugin->wbcom_run();

}
wbcom_run_product_testimonials();
