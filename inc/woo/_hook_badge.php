<?php
/**
 * Add new product Badge
 * Like: Hot, New, Sale, ...
 * Use: Product Attributes
*/
if(!function_exists('overcome_woocommerce_loop_attributes')){
	add_action('overcome_woocommerce_before_shop_loop_products_inner', 'overcome_woocommerce_loop_attributes', 0);
	function overcome_woocommerce_loop_attributes(){
		?>
		<div class="ef5-loop-atts row justify-content-between">
			<div class="ef5-loop-badge col-auto"><?php do_action('overcome_woocommerce_loop_attributes_left'); ?></div>
			<div class="col-auto"><?php do_action('overcome_woocommerce_loop_attributes_right'); ?></div>
		</div>
		<?php
	}
}
/**
 * Loop Loop product sale
*/
if(!function_exists('overcome_woocommerce_sale')){
    add_action('overcome_woocommerce_before_shop_loop_products_inner','overcome_woocommerce_sale',0);
    function overcome_woocommerce_sale(){
        global $product;
        if(!$product->is_on_sale()) return;
        if($product->get_type() == 'variable'){
            $regular_price = $product->get_variation_regular_price('max');
            $sales_price = $product->get_variation_sale_price('max');
        }else{
            $regular_price = $product->get_regular_price();
            $sales_price = $product->get_sale_price();
        }
        if(isset($regular_price) && $regular_price > 0 && isset($sales_price)){
            $percentage = round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 );
        ?>
        <span class="ef5-badge ef5-corner-ribbon top-left bg-accent shadow font-style-700 text-xxsmall">
            <?php printf( '- %s', $percentage . '%' ) ?>
        </span>
    <?php 
        }
    }
}
/* Loop Product Badge Attributes */ 
if(!function_exists('overcome_woocommerce_show_product_loop_badges')){
	add_action('overcome_woocommerce_before_shop_loop_products_inner', 'overcome_woocommerce_show_product_loop_badges', 1);
    function overcome_woocommerce_show_product_loop_badges(){
        global $post, $product;
        $terms = get_the_terms($product->get_id(), 'pa_badge');

        $is_on_sale = $product->is_on_sale();
        if($is_on_sale){
            $pos = ['top-right', 'bottom-right', 'bottom-left', 'top-left'];
        } else {
            $pos = ['top-left', 'top-right', 'bottom-right','bottom-left'];
        }
        $pos_index = '-1';
        $badge_class = 'ef5-badge ef5-corner-ribbon bg-accent shadow font-style-700 text-xxsmall';
        if(!is_wp_error($terms) && $terms !== false){
            $count = count($terms);
        } else {
            $count = 0;
        }
        if ( is_array($terms) && $count > 0 ){
            foreach ( $terms as $term ) {
                $pos_index ++;
                echo '<span class="'.esc_attr($badge_class).' '.strtolower($term->name).' '.$pos[$pos_index].'">'.$term->name.'</span>';
            }
        }
    }
}