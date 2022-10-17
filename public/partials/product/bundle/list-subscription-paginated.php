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

    $n_subscriptions = count( $subscriptions );

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
                    <?php if( 0 < $n_subscriptions ): ?>
                    <tbody class="ls-data">
                        <?php 
                            foreach ($subscriptions as $download): 
                            $d_id = $download->ID;
                        
                            $product_id = get_post_meta($d_id, 'product_id', true);
                            $get_bundle_cat_id = carbon_get_post_meta( $product_id, 'bundle_category' );
                            $get_if_bundle = carbon_get_post_meta( $product_id, 'is_bundle' );

                            if( 'yes' === $get_if_bundle ):

                                $args = array(
                                    'limit' => -1,
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

                                 // pagination data
                                 $page       = $current_page; // test page
                                 $limit      = 10; //per page
                                 $totalPages = ceil( $n_products/ $limit ); //calculate total pages
                                 $page       = max($page, 1); //get 1 page when $_GET['page'] <= 0
                                 $page       = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
                                 $offset     = ($page - 1) * $limit;

                                if( $n_products > 0 ):

                                    //set array for pagination 
                                    $products = array_slice( $products, $offset, $limit );

                                    foreach ($products as $product):
                        ?>
                                    <tr>
                                            <td class="download-product" data-title="Product">
                                                <a href="<?php echo $product->get_permalink(); ?>"><?php echo $product->get_name(); ?></a></td>
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
                    </tbody>
                    <?php else: ?>
                        <tbody>
                            <tr>
                                <td>
                                    No Bundle Product
                                </td>
                            </tr>
                        </tbody>
                    <?php endif; ?>
                </table>

           
            
            <!-- navigation data -->
                <?php 
                    if( $n_products > 0 ):
                ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            
                            <?php if( 1 == $page ): ?>
                            
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="<?php echo intval($page - 1); ?>" aria-label="Previous" >
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php 
                                if( $totalPages == 1 ):
                                    // do nothing
                                else:
                                    for ($i=0; $i < $totalPages ; $i++):
                                    $link_active = ( $page == $i + 1 ) ? 'active' : '' ;
                            ?>
                                        <li class="page-item <?php echo $link_active; ?>">
                                            <a class="page-link" href="#" data-page="<?php echo $i + 1; ?>">
                                                <?php echo $i + 1; ?>
                                            </a>
                                        </li>    
                            <?php 
                                    endfor; 
                                endif;
                            ?>

                            <?php if( $totalPages == $page ): ?>

                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="<?php echo intval($page + 1); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <!-- end of navigation data -->

        </div>
        
</div>