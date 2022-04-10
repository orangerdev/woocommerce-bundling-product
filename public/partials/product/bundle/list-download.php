<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

                        $n_new_array_bundle = count($new_array_bundle);

                        if( 0 < $n_new_array_bundle ):
                        
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
                                            $files = $product->get_files();

                                            $resultstr = array();
                                            foreach( $files as $key => $each_file ) {
                                                $resultstr[] = '<a href="'.$each_file["file"].'">'.$each_file["name"].'</a>';
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

                </tbody>
            </table>
        </div>
</div>
