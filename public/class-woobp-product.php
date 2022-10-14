<?php

namespace Woocommerce_Bundling_Product_Public;

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
class Product {

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

    public function show_bundle_product_download(){

		$downloads     = WC()->customer->get_downloadable_products();
		$has_downloads = (bool) $downloads;
				
		if( true === $has_downloads ){
			
			ob_start();
			include plugin_dir_path( __FILE__ ) . 'partials/product/bundle/list-download.php';
			echo ob_get_clean();
			
		}else{
			// do nothing
		}		

	}

	public function show_bundle_product_subscription(){
		
		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/product/bundle/list-subscription.php';
		echo ob_get_clean();
				

	}

	public function get_paginated_data(){

		if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die( 'Close The Door!');
        }

		$current_page = ( $_POST['page'] ) ? $_POST['page'] : 1 ;

		ob_start();
		include plugin_dir_path( __FILE__ ) . 'partials/product/bundle/list-subscription-paginated.php';
		$data = ob_get_contents();
        ob_end_clean();

		wp_send_json( $data );
        wp_die();

	}

}
