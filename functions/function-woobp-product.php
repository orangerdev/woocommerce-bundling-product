<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function woobp_bundle_categories(){
    
    $terms = get_terms([
        'taxonomy' => 'tax_product_bundle',
        'hide_empty' => false,
    ]);

    $list_bundle_categories = array(); 

    $list_bundle_categories[0] = '--- Please Select ---';

    foreach ($terms as $term) {
        $list_bundle_categories[$term->term_taxonomy_id] = $term->name;       
    }

    return $list_bundle_categories;
}

function woobp_list_download( $downloads ){
    
    $_data = array();
    $arr_data = array();

    foreach ($downloads as $v) {
        if (isset($_data[$v['product_id']])) {
            // found duplicate
            continue;
        }
        // remember unique item
        $_data[$v['product_id']] = $v;
    }

    // if you need a zero-based array, otheriwse work with $_data
    $data = array_values($_data);

    $_arr_bundle = array();

    foreach ($data as $download){
                            
        $product_id = $download['product_id'];
        $get_bundle_cat_id = carbon_get_post_meta( $product_id, 'bundle_category' );
        $get_if_bundle = carbon_get_post_meta( $product_id, 'is_bundle' );

        if( 'yes' === $get_if_bundle ){

            $_arr_bundle[] = $get_bundle_cat_id;

        }else{
            // do nothing
        }

    }

    $new_array_bundle = array_unique( $_arr_bundle );

    return $new_array_bundle;


}

function woobp_list_bundle_download( $get_bundle_cat_id ){
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'tax_product_bundle',
                'field' => 'term_id',
                'terms' => $get_bundle_cat_id
            )
        )
    );

    $products = wc_get_products( $args );

    return $products;
}
