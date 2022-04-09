<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wbp_bundle_categories(){
    
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
