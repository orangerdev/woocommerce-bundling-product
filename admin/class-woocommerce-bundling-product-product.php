<?php


namespace Woocommerce_Bundling_Product_Admin\Admin;


use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Bundling_Product
 * @subpackage Woocommerce_Bundling_Product/admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
        $this->version = $version;
        
	}

	public function product_bundle_taxonomy()  {

		$labels = array(
			'name'                       => 'Bundle Categories',
			'singular_name'              => 'Bundle Category',
			'menu_name'                  => 'Bundle Category',
			'all_items'                  => 'All Bundle Categories',
			'parent_item'                => 'Parent Bundle Category',
			'parent_item_colon'          => 'Parent Bundle Category:',
			'new_item_name'              => 'New Bundle Category Name',
			'add_new_item'               => 'Add New Bundle Category',
			'edit_item'                  => 'Edit Bundle Category',
			'update_item'                => 'Update Bundle Category',
			'separate_items_with_commas' => 'Separate Bundle Category with commas',
			'search_items'               => 'Search Bundle Categories',
			'add_or_remove_items'        => 'Add or remove Bundle Categories',
			'choose_from_most_used'      => 'Choose from the most used Bundle Categories',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
		);
		register_taxonomy( 'tax_product_bundle', 'product', $args );
		
	}

    public function setup_custom_post_meta(){

        Container::make( 'post_meta', 'Bundle Product Setttings' )
            ->where( 'post_type', '=', 'product' )
            ->add_fields( array(				
				Field::make( 'radio', 'is_bundle', __( 'Get bundle product if buy this item?' ) )
				->set_width('30')
				->set_default_value( 'no' )
				->set_options( array(
					'yes' => __('Yes'),
					'no'  => __('No')
				) ),
				Field::make( 'select', 'bundle_category', __( 'Choose category of bundle product ( If Yes ).' ) )
					->set_default_value( 0 )
					->set_options('wbp_bundle_categories')
            ));


    }


}