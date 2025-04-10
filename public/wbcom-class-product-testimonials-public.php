<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/public
 * @author     WPCOM <>
 */
class Wbcom_Product_Testimonials_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wbcom_plugin_name    The ID of this plugin.
	 */
	private $wbcom_plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wbcom_version    The current version of this plugin.
	 */
	private $wbcom_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wbcom_plugin_name       The name of this plugin.
	 * @param      string    $wbcom_version    The version of this plugin.
	 */
	public function __construct( $wbcom_plugin_name, $wbcom_version ) {

		$this->wbcom_plugin_name = $wbcom_plugin_name;
		$this->wbcom_version = $wbcom_version;

	}

	/**
	 * Register the stylesheets for the public area.
	 *
	 * @since    1.0.0
	 */
	public function wbcom_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the wbcom_run() function
		 * defined in Product_Testimonials_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Testimonials_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wbcom_plugin_name, plugin_dir_url( __FILE__ ) . 'css/wbcom-product-testimonials-public.css', array(), $this->wbcom_version, 'all' );

	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function wbcom_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the wbcom_run() function
		 * defined in Product_Testimonials_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Testimonials_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wbcom_plugin_name, plugin_dir_url( __FILE__ ) . 'js/wbcom-product-testimonials-public.js', array( 'jquery' ), $this->wbcom_version, false );

	}

	/**
	 * Add field on the checkout page
	 *
	 * @since    1.0.0
	 */
	public function wpcom_add_checkout_field($fields) {
		
		$fields['order']['how_heard_about_us'] = array(
			'type'        => 'text',
			'label'       => __('How did you hear about us?', 'wbcom-product-testimonials'),
			'placeholder' => __('Enter your response', 'wbcom-product-testimonials'),
			'required'    => false,
			'clear'       => true
		);
		return $fields;
	}

	/**
	 * Save checkout field data
	 *
	 * @since    1.0.0
	 */
	public function wpcom_save_checkout_field($order_id) {
		if (!empty($_POST['how_heard_about_us'])) {
			update_post_meta($order_id, '_how_heard_about_us', sanitize_text_field($_POST['how_heard_about_us']));
		}
	}

	/**
	 * Show checkout field data on admin side
	 *
	 * @since    1.0.0
	 */
	public function wpcom_display_checkout_field_in_admin_order($order){
		$how_heard_about_us = get_post_meta($order->get_id(), '_how_heard_about_us', true);
		if (!empty($how_heard_about_us)) {
			echo '<p><strong>' . __('How did you hear about us?', 'wbcom-product-testimonials') . ':</strong> ' . esc_html($how_heard_about_us) . '</p>';
		}
	}

	/**
	 * Add 10% discount if accessories products > 3
	 *
	 * @since    1.0.0
	 */
	function wpcom_apply_accessories_cat_discount() {
		$wpcom_discount_percentage = 10; 
		$wpcom_accessories_count = 0;
		$wpcom_accessories_term = get_term_by('slug', 'accessories', 'product_cat');
		if (!$wpcom_accessories_term || is_wp_error($wpcom_accessories_term)) {
			return;
		}
		$wpcom_accessories_category_id = $wpcom_accessories_term->term_id;
		
		foreach (WC()->cart->get_cart() as $cart_item) {
			if (has_term($wpcom_accessories_category_id, 'product_cat', $cart_item['product_id'])) {
				$wpcom_accessories_count += $cart_item['quantity'];
			}
		}
	
		if ($wpcom_accessories_count <= 3) {
			return;
		}
		if ($wpcom_accessories_count > 3) {
			$cart_total = WC()->cart->get_subtotal();
			$discount_amount = $cart_total * ($wpcom_discount_percentage / 100);
			WC()->cart->add_fee(esc_html__('Accessories Discount(10%)', 'wbcom-product-testimonials'), -$discount_amount);
		}
	}

	/**
	 * Add Best seller badge on products
	 *
	 * @since    1.0.0
	 */
	public function wpcom_display_best_seller_badge() {
		global $product;
	
		$wpcom_total_sales = $product->get_total_sales();
	
		if ($wpcom_total_sales > 100) {
			echo '<span class="best_seller_badge">' . esc_html__('Best Seller', 'wbcom-product-testimonials') . '</span>';
		}
	}

	/**
	 * Add Free Gift Suggestion
	 *
	 * @since    1.0.0
	 */
	public function wpcom_display_free_gift_suggestion() {
		if (!is_cart()) return;
		$wpcom_cart_subtotal = WC()->cart->get_subtotal();
		if ($wpcom_cart_subtotal > 500) {
			echo '<div class="free-gift-suggestion">';
			echo '<p>' . esc_html__('Congrats! You qualify for a free gift. Add a free gift to your cart today!', 'wbcom-product-testimonials') . '</p>';
			echo '</div>';
		}
	}

}
