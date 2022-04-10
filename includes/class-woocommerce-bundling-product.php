<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://orangerdev.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/includes
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
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/includes
 * @author     OrangerDev <orangerdigiart@gmail.com>
 */
class Woocommerce_Bundling_Product {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_Bundling_Product_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

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
		if ( defined( 'WOOCOMMERCE_BUNDLING_PRODUCT_VERSION' ) ) {
			$this->version = WOOCOMMERCE_BUNDLING_PRODUCT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woocommerce-bundling-product';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woocommerce_Bundling_Product_Loader. Orchestrates the hooks of the plugin.
	 * - Woocommerce_Bundling_Product_i18n. Defines internationalization functionality.
	 * - Woocommerce_Bundling_Product_Admin. Defines all hooks for the admin area.
	 * - Woocommerce_Bundling_Product_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-bundling-product-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-bundling-product-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-bundling-product-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-bundling-product-product.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-bundling-product-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-bundling-product-public-product.php';


		/**
		 * The functions responsible for defining all helper functions
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions/function-wbp-product.php';

		$this->loader = new Woocommerce_Bundling_Product_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_Bundling_Product_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_Bundling_Product_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin = new Woocommerce_Bundling_Product_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'after_setup_theme',					$admin, 'load_carbon_fields',	999);
		$this->loader->add_action( 'admin_enqueue_scripts', 			$admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', 			$admin, 'enqueue_scripts' );
		

		$product = new Woocommerce_Bundling_Product_Admin\Admin\Product( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', 									$product, 'product_bundle_taxonomy', 0 );
		$this->loader->add_action( 'carbon_fields_register_fields',			$product, 'setup_custom_post_meta' );	
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$public = new Woocommerce_Bundling_Product_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );


		$product = new Woocommerce_Bundling_Product_Public\Product( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'woocommerce_after_account_downloads',	$product, 'show_bundle_product_download', 0 );
		$this->loader->add_action( 'ywsbs_my_subscriptions_view_after',		$product, 'show_bundle_product_subscription', 0 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_Bundling_Product_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
