<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       
 * @since      1.0.0
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Wbcom_Product_Testimonials
 * @subpackage Wbcom_Product_Testimonials/includes
 * @author     WPCOM <>
 */
class Wbcom_Product_Testimonials_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $wbcom_actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $wbcom_actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $wbcom_filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $wbcom_filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->wbcom_actions = array();
		$this->wbcom_filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $wbcom_hook             The name of the WordPress action that is being registered.
	 * @param    object               $wbcom_component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $wbcom_callback         The name of the function definition on the $wbcom_component.
	 * @param    int                  $wbcom_priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $wbcom_accepted_args    Optional. The number of arguments that should be passed to the $wbcom_callback. Default is 1.
	 */
	public function wbcom_add_action( $wbcom_hook, $wbcom_component, $wbcom_callback, $wbcom_priority = 10, $wbcom_accepted_args = 1 ) {
		$this->wbcom_actions = $this->wbcom_add( $this->wbcom_actions, $wbcom_hook, $wbcom_component, $wbcom_callback, $wbcom_priority, $wbcom_accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $wbcom_hook             The name of the WordPress filter that is being registered.
	 * @param    object               $wbcom_component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $wbcom_callback         The name of the function definition on the $wbcom_component.
	 * @param    int                  $wbcom_priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $wbcom_accepted_args    Optional. The number of arguments that should be passed to the $wbcom_callback. Default is 1
	 */
	public function wbcom_add_filter( $wbcom_hook, $wbcom_component, $wbcom_callback, $wbcom_priority = 10, $wbcom_accepted_args = 1 ) {
		$this->wbcom_filters = $this->wbcom_add( $this->wbcom_filters, $wbcom_hook, $wbcom_component, $wbcom_callback, $wbcom_priority, $wbcom_accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $wbcom_hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $wbcom_hook             The name of the WordPress filter that is being registered.
	 * @param    object               $wbcom_component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $wbcom_callback         The name of the function definition on the $component.
	 * @param    int                  $wbcom_priority         The priority at which the function should be fired.
	 * @param    int                  $wbcom_accepted_args    The number of arguments that should be passed to the $wbcom_callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function wbcom_add( $wbcom_hooks, $wbcom_hook, $wbcom_component, $wbcom_callback, $wbcom_priority, $wbcom_accepted_args ) {

		$wbcom_hooks[] = array(
			'hook'          => $wbcom_hook,
			'component'     => $wbcom_component,
			'callback'      => $wbcom_callback,
			'priority'      => $wbcom_priority,
			'accepted_args' => $wbcom_accepted_args
		);

		return $wbcom_hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function wbcom_run() {

		foreach ( $this->wbcom_filters as $wbcom_hook ) {
			add_filter( $wbcom_hook['hook'], array( $wbcom_hook['component'], $wbcom_hook['callback'] ), $wbcom_hook['priority'], $wbcom_hook['accepted_args'] );
		}

		foreach ( $this->wbcom_actions as $wbcom_hook ) {
			add_action( $wbcom_hook['hook'], array( $wbcom_hook['component'], $wbcom_hook['callback'] ), $wbcom_hook['priority'], $wbcom_hook['accepted_args'] );
		}

	}

}
