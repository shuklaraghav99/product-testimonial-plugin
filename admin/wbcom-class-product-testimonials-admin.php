<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/admin
 * @author     WPCOM <>
 */
class Wbcom_Product_Testimonials_Admin {

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
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->wbcom_plugin_name, plugin_dir_url( __FILE__ ) . 'css/wbcom-product-testimonials-admin.css', array(), $this->wbcom_version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->wbcom_plugin_name, plugin_dir_url( __FILE__ ) . 'js/wbcom-product-testimonials-admin.js', array( 'jquery' ), $this->wbcom_version, false );

	}

	/**
	 * Register the custom post type .
	 *
	 * @since    1.0.0
	 */
	public function wpcom_register_product_testimonial() {
		$labels = array(
			'name'                  => __('Product Testimonials','wbcom-product-testimonials'),
			'singular_name'         => __('Product Testimonial','wbcom-product-testimonials'),
			'menu_name'             => __('Product Testimonials','wbcom-product-testimonials'),
			'name_admin_bar'        => __('Product Testimonial','wbcom-product-testimonials'),
			'add_new'               => __('Add New','wbcom-product-testimonials'),
			'add_new_item'          => __('Add New Testimonial','wbcom-product-testimonials'),
			'new_item'              => __('New Testimonial','wbcom-product-testimonials'),
			'edit_item'             => __('Edit Testimonial','wbcom-product-testimonials'),
			'view_item'             => __('View Testimonial','wbcom-product-testimonials'),
			'all_items'             => __('All Testimonials','wbcom-product-testimonials'),
			'search_items'          => __('Search Testimonials','wbcom-product-testimonials'),
			'parent_item_colon'     => __('Parent Testimonials:','wbcom-product-testimonials'),
			'not_found'             => __('No testimonials found.','wbcom-product-testimonials'),
			'not_found_in_trash'    => __('No testimonials found in Trash.','wbcom-product-testimonials'),
			'featured_image'        => __('Testimonial Image','wbcom-product-testimonials'),
			'set_featured_image'    => __('Set featured image','wbcom-product-testimonials'),
			'remove_featured_image' => __('Remove featured image','wbcom-product-testimonials'),
			'use_featured_image'    => __('Use as featured image','wbcom-product-testimonials'),
		);
	
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_position'      => 5,
			'supports'           => array( 'title', 'editor' ),
			'taxonomies'         => array(),
			'has_archive'        => true,
			'rewrite'            => array( 'slug' => 'product-testimonials' ),
			'show_in_rest'       => true,
		);
	
		register_post_type( 'product_testimonial', $args );
	}

	/**
	 * Register Meta Box Fields
	 *
	 * @since    1.0.0
	 */
	public function wpcom_add_meta_boxes() {
		add_meta_box(
			'wpcm_testimonial_meta_box',
			__( 'Product Testimonial Details', 'wbcom-product-testimonials' ),
			array($this,'wpcom_testimonial_meta_box_cb'),
			'product_testimonial',
			'normal',
			'high'
		);
	}

	public function wpcom_testimonial_meta_box_cb( $post ) {
		wp_nonce_field( 'wpcm_save_testimonial', 'wpcm_testimonial_nonce' );
		$rating = get_post_meta( $post->ID, '_wpcm_rating', true );
		$verified_buyer = get_post_meta( $post->ID, '_wpcm_verified_buyer', true );
		$selected_product = get_post_meta( $post->ID, '_wpcm_product_id', true );
		// error_log('Selected Product ID: ' . $selected_product);
		
		$products = wc_get_products( array( 'limit' => -1 ) );
		?>
		<label for="wpcm_rating"><?php _e( 'Rating (1-5):', 'wbcom-product-testimonials' ); ?></label>
		<input type="number" id="wpcm_rating" name="wpcm_rating" min="1" max="5" value="<?php echo esc_attr( $rating ); ?>" />
		<br><br>
		
		<label for="wpcm_verified_buyer"><?php _e( 'Verified Buyer:', 'wbcom-product-testimonials' ); ?></label>
		<input type="checkbox" id="wpcm_verified_buyer" name="wpcm_verified_buyer" value="1" <?php checked( $verified_buyer, 1 ); ?> />
		<br><br>
		<label for="wpcm_product_id"><?php _e( 'Select a Product:', 'wbcom-product-testimonials' ); ?></label>
		<select name="wpcm_product_id" id="wpcm_product_id" class="widefat">
	
			<option value=""><?php _e( 'Select a Product:', 'wbcom-product-testimonials' ); ?></option>
			<?php
			foreach ( $products as $product ) {
				?>
				<option value="<?php echo esc_attr( $product->get_id() ); ?>" <?php selected( $selected_product, $product->get_id() ); ?>>
				<?php
				echo esc_html( $product->get_name() );
				?>
				</option>
				<?php
			}
			?>
		</select>
				<?php
	}

	/**
	 * Save Meta Box Data
	 *
	 * @since    1.0.0
	 */
	public function wpcom_save_meta_box_data( $post_id ) {
		if ( ! isset( $_POST['wpcm_testimonial_nonce'] ) || ! wp_verify_nonce( $_POST['wpcm_testimonial_nonce'], 'wpcm_save_testimonial' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['wpcm_rating'] ) ) {
			update_post_meta( $post_id, '_wpcm_rating', sanitize_text_field( $_POST['wpcm_rating'] ) );
		}
		if ( isset( $_POST['wpcm_product_id'] ) ) {
			$product_id = sanitize_text_field( $_POST['wpcm_product_id'] );
			update_post_meta( $post_id, '_wpcm_product_id', $product_id );
		}

		$verified_buyer = isset( $_POST['wpcm_verified_buyer'] ) && $_POST['wpcm_verified_buyer'] == '1' ? 1 : 0;
		update_post_meta( $post_id, '_wpcm_verified_buyer', $verified_buyer );
	}

	/**
	 * Register shortcode
	 *
	 * @since    1.0.0
	 */
	public function wpcom_register_product_testimonial_shortcode(){

		add_shortcode( 'product_testimonials', array($this,'wpcom_display_product_testimonials' ));
	}
	/**
	 * Callback of shortcode
	 *
	 * @since    1.0.0
	 */
	public function wpcom_display_product_testimonials( $atts ) {
		$atts = shortcode_atts( array(
			'product_id' => 0
		), $atts, 'product_testimonials' );
	
		if ( $atts['product_id'] == 0 ) {
			return 'Please provide a product ID.';
		}
	
		$args = array(
			'post_type'      => 'product_testimonial',
			'meta_key'       => '_wpcm_product_id',
			'meta_value'     => $atts['product_id'],
			'posts_per_page' => -1,
		);
		$testimonials = new WP_Query( $args );
		
	
		if ( $testimonials->have_posts() ) {
			$output = '<div class="product-testimonials">';
			while ( $testimonials->have_posts() ) {
				$testimonials->the_post();
				$rating = get_post_meta( get_the_ID(), '_wpcm_rating', true );
				$verified_buyer = get_post_meta( get_the_ID(), '_wpcm_verified_buyer', true );
	
				$output .= '<div class="wbcom_testimonial">';
				$output .= '<div class="wbcom_rating">' . str_repeat('★', $rating) . '</div>';
				$output .= '<div class="wbcom_content">' . get_the_content() . '</div>';
				$output .= $verified_buyer ? '<span class="verified">Verified Buyer</span>' : '';
				$output .= '</div>';
			}
			wp_reset_postdata();
			$output .= '</div>';
		} else {
			$output = 'No testimonials found for this product.';
		}
	
		return $output;
	}

	/**
	 * REST API Endpoint to Retrieve Testimonials
	 *
	 * @since    1.0.0
	 */
	public function wpcom_register_testimonials_endpoint() {
		register_rest_route( 'wpcom/v1', '/testimonials', array(
			'methods' => 'GET',
			'callback' => 'wpcom_get_testimonials',
			'args' => array(
				'product_id' => array(
					'required' => true,
					'validate_callback' => function( $param, $request, $key ) {
						return is_numeric( $param );
					},
				),
			),
			'permission_callback' => '__return_true',
		));
	}

	public function wpcom_get_testimonials( $data ) {
		$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
		if ($product_id <= 0) {
			return new WP_REST_Response( 'Invalid product ID', 400 );
		}
		$args = array(
			'post_type'      => 'product_testimonial',
			'meta_key'       => '_wpcm_product_id',
			'meta_value'     => $product_id,
			'posts_per_page' => -1,
		);
	
		$testimonials = new WP_Query( $args );
	
		if ( $testimonials->have_posts() ) {
			$response = [];
			while ( $testimonials->have_posts() ) {
				$testimonials->the_post();
				$response[] = array(
					'id'           => get_the_ID(),
					'title'        => get_the_title(),
					'content'      => get_the_content(),
					'rating'       => get_post_meta( get_the_ID(), '_wpcm_rating', true ),
					'verified'     => get_post_meta( get_the_ID(), '_wpcm_verified_buyer', true ),
				);
			}
			wp_reset_postdata();
			return new WP_REST_Response( $response, 200 );
		} else {
			return new WP_REST_Response( 'No testimonials found', 404 );
		}
	}

	/**
	 * Add testimonials under the description tab of the products
	 *
	 * @since    1.0.0
	 */
	public function wpcom_add_testimonials_to_description_tab($tabs) {
		if ( isset( $tabs['description'] ) && 'product' === get_post_type() ) {
			$tabs['description']['callback'] = array($this,'wpcom_display_testimonials_on_product_page');
		}
	  
		return $tabs;
	}

	public function wpcom_display_testimonials_on_product_page() {
		global $product;
		the_content();
		if ( is_product()) {
			$product_id = absint($product->get_id());
			
			echo '<div class="product-testimonials-main">';
			echo do_shortcode( '[product_testimonials product_id="' . $product_id . '"]' );
			echo '</div>';
		}
	}

	

	/**
	 * Register api endpoint for order details
	 *
	 * @since    1.0.0
	 */
	public function wbcom_register_order_details_endpoint() {
		register_rest_route( 'wbcom/v1', '/order-details', array(
			'methods'  => 'GET',
			'callback' => 'wbcom_get_order_details',
			'permission_callback' => 'wbcom_check_user_logged_in', 
			'args' => array(
				'order_id' => array(
					'required' => true,
					'validate_callback' => function($param, $request, $key) {
						return is_numeric($param);
					}
				),
			),
		));
	}

	/**
	 * Callback for user check
	 *
	 * @since    1.0.0
	 */
	public function wbcom_check_user_logged_in() {
		if ( is_user_logged_in() ) {
			return true;
		} else {
			return new WP_Error( 'rest_forbidden', 'You must be logged in to view order details', array( 'status' => 403 ) );
		}
	}
	

	/**
	 * Callback to get data 
	 *
	 * @since    1.0.0
	 */
	public function wbcom_get_order_details( $data ) {
		$order_id = absint($data['order_id']);
	
		$order = wc_get_order( $order_id );
		
		if ( !$order ) {
			return new WP_Error( 'order_not_found', 'Order not found', array( 'status' => 404 ) );
		}
	
		$customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();

		$order_total = $order->get_total();
	
		$items = $order->get_items();
		$products = array();
	
		foreach ( $items as $item_id => $item ) {
			$product = $item->get_product();
			if ( !$product ) {
				continue; 
			}
			$products[] = array(
				'product_name' => $product->get_name(),
				'quantity'     => $item->get_quantity(),
			);
		}
	
		$response_data = array(
			'customer_name' => $customer_name,
			'order_total'   => $order_total,
			'products'      => $products,
		);
	
		return rest_ensure_response( $response_data );
	}
	
}
