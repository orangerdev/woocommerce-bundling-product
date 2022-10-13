<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://orangerdev.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/public
 * @author     OrangerDev <orangerdigiart@gmail.com>
 */
class Woocommerce_Bundling_Product_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Bundling_Product_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Bundling_Product_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woobp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_Bundling_Product_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_Bundling_Product_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woobp-public.js', array( 'jquery' ), $this->version, false );
		$settings = array(
			'ajax_url'  => admin_url( 'admin-ajax.php' ),
			'my_subscription'      => [
				'action'    => 'get_paginated_data',
				'nonce'     => wp_create_nonce( 'ajax-nonce' )
			]
		);

		wp_localize_script( $this->plugin_name, 'my_account_vars', $settings);

		// get current page here
		if ( is_page() ):
			
    		// Get the page slug using queried object
			$parent_slug		= get_queried_object()->post_name;

			// get last segment of URL
			$link 				= $_SERVER['REQUEST_URI'];
			$link_array 		= explode('/',$link);
			$n_link_array 		= count( $link_array ); 
			$n_path_location 	= intval( $n_link_array - 2 );

			$segment_path		= $link_array[$n_path_location];

			if( 'my-account' == $parent_slug && 'my-subscription' == $segment_path ):				
				wp_enqueue_script( $this->plugin_name.'-pagination', plugin_dir_url( __FILE__ ) . 'js/woobp-pagination.js', array( 'jquery' ), $this->version, false );
			endif;
			
		endif;
		// get last segment of url here

	}

}
