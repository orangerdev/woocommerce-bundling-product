<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
$current_user_id = (int) $current_user->ID;

// get subscribtion data

// getting all the records of the user by email for the subscription
$subscriptions = get_posts( array(
    'numberposts' => -1,
    'post_type' => 'ywsbs_subscription', // Subscription post type
    'orderby' => 'post_date', // ordered by date
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'user_id', //additional fields being used to get the data
            'value' => $current_user_id,
            'compare' => '='
        ),
        array(
            'key' => 'status',
            'value' => 'active', //active subscriptions
            'compare' => '='
            )
    )   

) );

?>

<div class="card mt-4"><!-- /card -->
		<div class="card-body"><!-- /card body -->
            <h6 class="card-title mb-4">Available Bundle Downloads</h6>

            <table class="woocommerce-table woocommerce-table--order-downloads shop_table shop_table_responsive order_details">
                <thead>
                    <tr>
                        <th class="download-bundle-product"><span class="nobr">Product</span></th>
                        <th class="download-bundle-category"><span class="nobr">Bundling Category</span></th>
                        <th class="download-bundle-file"><span class="nobr">Download</span></th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                        $n_subscriptions = count( $subscriptions );
                        
                        if( 0 < $n_subscriptions ):
                        foreach ($subscriptions as $download):
                            $d_id = $download->ID;
                            
                            $product_id = get_post_meta($d_id, 'product_id', true);
                            $get_bundle_cat_id = carbon_get_post_meta( $product_id, 'bundle_category' );
                            $get_if_bundle = carbon_get_post_meta( $product_id, 'is_bundle' );


                            if( 'yes' === $get_if_bundle ):
                            
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

                                $n_products = count($products);

                                if( $n_products > 0 ):

                                    foreach ($products as $product):

                                ?>

                                        <tr>
                                            <td class="download-product" data-title="Product">
                                                <a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->name; ?></a></td>
                                            <td class="download-remaining" data-title="Downloads remaining">
                                                <?php 
                                                    $term_obj_list = get_the_terms( $product->get_id(), 'tax_product_bundle' );
                                                    foreach( $term_obj_list as $cat_bundle ):
                                                        echo $cat_bundle->name;
                                                    endforeach;
                                                ?>
                                            </td>
                                            <td class="download-file" data-title="Download">
                                                <?php                                                 
                                                    //$files = $product->get_files();

                                                    $files = $product->get_downloads();

                                                    $resultstr = array();
                                                    foreach( $files as $key => $each_file ) {
                                                        $resultstr[] = '<a href="'.$each_file["file"].'" target="_blank">'.$each_file["name"].'</a>';
                                                    }

                                                    echo implode(", ",$resultstr);
                                                    
                                                ?>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td>
                                            No Bundle Product
                                        </td>
                                    </tr>
                                
                                <?php endif; ?>

                            <?php else: ?>

                                <tr>
                                    <td>
                                        No Bundle Product
                                    </td>
                                </tr>

                            <?php endif; ?>
                        
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td>
                                No Bundle Product
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
</div>
