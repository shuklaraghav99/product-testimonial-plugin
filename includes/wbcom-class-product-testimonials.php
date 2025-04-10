<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 * @author     WPCOM <>
 */
class Wbcom_Product_Testimonials {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wbcom_Product_Testimonials_Loader    $wbcom_loader    Maintains and registers all hooks for the plugin.
	 */
	protected $wbcom_loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wbcom_plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $wbcom_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wbcom_version    The current version of the plugin.
	 */
	protected $wbcom_version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WBCOM_PRODUCT_TESTIMONIALS_VERSION' ) ) {
			$this->wbcom_version = WBCOM_PRODUCT_TESTIMONIALS_VERSION;
		} else {
			$this->wbcom_version = '1.0.0';
		}
		$this->wbcom_plugin_name = 'product-testimonials';

		$this->wbcom_load_dependencies();
		$this->wbcom_set_locale();
		$this->wbcom_define_admin_hooks();
		$this->wbcom_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wbcom_Product_Testimonials_Loader. Orchestrates the hooks of the plugin.
	 * - Wbcom_Product_Testimonials_i18n. Defines internationalization functionality.
	 * - Wbcom_Product_Testimonials_Admin. Defines all hooks for the admin area.
	 * - Wbcom_Product_Testimonials_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wbcom_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wbcom-class-product-testimonials-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wbcom-class-product-testimonials-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wbcom-class-product-testimonials-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/wbcom-class-product-testimonials-public.php';

		$this->wbcom_loader = new Wbcom_Product_Testimonials_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wbcom_Product_Testimonials_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wbcom_set_locale() {

		$wbcom_plugin_i18n = new Wbcom_Product_Testimonials_i18n();

		$this->wbcom_loader->wbcom_add_action( 'plugins_loaded', $wbcom_plugin_i18n, 'wbcom_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wbcom_define_admin_hooks() {

		$wbcom_plugin_admin = new Wbcom_Product_Testimonials_Admin( $this->wbcom_get_plugin_name(), $this->wbcom_get_version() );

		$this->wbcom_loader->wbcom_add_action( 'admin_enqueue_scripts', $wbcom_plugin_admin, 'wbcom_enqueue_styles' );
		$this->wbcom_loader->wbcom_add_action( 'admin_enqueue_scripts', $wbcom_plugin_admin, 'wbcom_enqueue_scripts' );
		$this->wbcom_loader->wbcom_add_action( 'init', $wbcom_plugin_admin, 'wpcom_register_product_testimonial' );
		$this->wbcom_loader->wbcom_add_action( 'init', $wbcom_plugin_admin, 'wpcom_register_product_testimonial_shortcode' );
		$this->wbcom_loader->wbcom_add_action( 'add_meta_boxes', $wbcom_plugin_admin, 'wpcom_add_meta_boxes' );
		$this->wbcom_loader->wbcom_add_action( 'save_post', $wbcom_plugin_admin, 'wpcom_save_meta_box_data' );
		$this->wbcom_loader->wbcom_add_action( 'rest_api_init', $wbcom_plugin_admin, 'wpcom_register_testimonials_endpoint' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_product_tabs', $wbcom_plugin_admin, 'wpcom_add_testimonials_to_description_tab',99 );
		
		
		
		
		$this->wbcom_loader->wbcom_add_action( 'rest_api_init', $wbcom_plugin_admin, 'wbcom_register_order_details_endpoint' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function wbcom_define_public_hooks() {

		$wbcom_plugin_public = new Wbcom_Product_Testimonials_Public( $this->wbcom_get_plugin_name(), $this->wbcom_get_version() );

		$this->wbcom_loader->wbcom_add_action( 'wp_enqueue_scripts', $wbcom_plugin_public, 'wbcom_enqueue_styles' );
		$this->wbcom_loader->wbcom_add_action( 'wp_enqueue_scripts', $wbcom_plugin_public, 'wbcom_enqueue_scripts' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_checkout_fields', $wbcom_plugin_public, 'wpcom_add_checkout_field' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_checkout_update_order_meta', $wbcom_plugin_public, 'wpcom_save_checkout_field' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_admin_order_data_after_billing_address', $wbcom_plugin_public, 'wpcom_display_checkout_field_in_admin_order' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_cart_calculate_fees', $wbcom_plugin_public, 'wpcom_apply_accessories_cat_discount' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_before_shop_loop_item_title', $wbcom_plugin_public, 'wpcom_display_best_seller_badge' );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_single_product_summary', $wbcom_plugin_public, 'wpcom_display_best_seller_badge',5 );
		$this->wbcom_loader->wbcom_add_action( 'woocommerce_after_cart_totals', $wbcom_plugin_public, 'wpcom_display_free_gift_suggestion' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function wbcom_run() {
		$this->wbcom_loader->wbcom_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function wbcom_get_plugin_name() {
		return $this->wbcom_plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Product_Testimonials_Loader    Orchestrates the hooks of the plugin.
	 */
	public function wbcom_get_loader() {
		return $this->wbcom_loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function wbcom_get_version() {
		return $this->wbcom_version;
	}

}
