<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://orangerdev.com
 * @since             1.0.0
 * @package           Woocommerce_Bundling_Product
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Bundling Product
 * Plugin URI:        https://orangerdev.com
 * Description:       Buy a product and then get all access to selected products based on WooCommerce. Works well with YITH Subscription.
 * Version:           1.0.0
 * Author:            OrangerDev
 * Author URI:        https://orangerdev.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-bundling-product
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
define( 'WOOCOMMERCE_BUNDLING_PRODUCT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-bundling-product-activator.php
 */
function activate_woocommerce_bundling_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-bundling-product-activator.php';
	Woocommerce_Bundling_Product_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-bundling-product-deactivator.php
 */
function deactivate_woocommerce_bundling_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-bundling-product-deactivator.php';
	Woocommerce_Bundling_Product_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_bundling_product' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_bundling_product' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-bundling-product.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_bundling_product() {

	$plugin = new Woocommerce_Bundling_Product();
	$plugin->run();

}
run_woocommerce_bundling_product();
