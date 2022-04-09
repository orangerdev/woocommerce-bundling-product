<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://orangerdev.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/includes
 * @author     OrangerDev <orangerdigiart@gmail.com>
 */
class Woocommerce_Bundling_Product_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-bundling-product',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
