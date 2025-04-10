<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 * @author     WPCOM <>
 */
class Wbcom_Product_Testimonials_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function wbcom_load_plugin_textdomain() {

		load_plugin_textdomain(
			'wbcom-product-testimonials',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
