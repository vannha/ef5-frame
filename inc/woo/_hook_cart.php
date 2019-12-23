<?php
/**
 * Change cart item thumbnail size 
*/
if(!function_exists('overcome_woocommerce_cart_item_thumbnail')){
	add_filter('woocommerce_cart_item_thumbnail','overcome_woocommerce_cart_item_thumbnail', 10, 3);
	function  overcome_woocommerce_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key){
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$thumbnail_id = get_post_thumbnail_id($product_id);
		$thumbnail = overcome_image_by_size(['id' => $thumbnail_id, 'size' => apply_filters('overcome_woocommerce_cart_item_thumbnail_size', '100x100'),'echo'   => false]);
		return $thumbnail;
	}
}

/**
 * Change Cart Item Name output
 *
 * Add Product Brand at Top
 * Filter: woocommerce_cart_item_name
*/

if(!function_exists('overcome_woocommerce_cart_item_name')){
	add_filter('woocommerce_cart_item_name','overcome_woocommerce_cart_item_name', 10, 3);
	function overcome_woocommerce_cart_item_name($name, $cart_item, $cart_item_key){
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

		$terms = get_the_terms($product_id, 'pa_brand');
        if(!is_wp_error($terms)){
            $count = count($terms);
        } else {
            $count = 0;
        }
        $brand = '';
        if(is_array($terms) && $count > 0) {
        	$brand = '<div class="cart-item-brand">';       
            foreach ( $terms as $term ) {
                $brand .=  '<div class="wc-brand '.strtolower(str_replace(array(' ','&','amp;'), '-', $term->name)).'">'.$term->name.'</div>';
            }
         	$brand .= '</div>';
        }

		$name = '<div class="cart-item-name-wrap">';
			$name .= $brand;

			if ( ! $product_permalink ) {
				$name .= $_product->get_name();
			} else {
				$name .= sprintf( '<a class="cart-item-name" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() );
			}
		$name .= '</div>';
		return $name;
	}
}

/**
 * Custom Cart Actions Layout
*/
if(!function_exists('overcome_woocommerce_cart_actions')){
	add_filter('woocommerce_cart_actions','overcome_woocommerce_cart_actions', 10);
	remove_action('woocommerce_cart_collaterals','woocommerce_cart_totals',10);
	function overcome_woocommerce_cart_actions(){
		?>
		<div class="ef5-cart-actions-wrap row">
			<div class="col-lg-6">
				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="ef5-cart-coupon coupon">
						<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'overcome' ); ?>" />
						<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'overcome' ); ?>"><?php esc_attr_e( 'Apply coupon', 'overcome' ); ?></button>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>
			</div>
			<div class="ef5-cart-totals col-lg-6">
				<?php woocommerce_cart_totals(); ?>
			</div>
		</div>
		
		<?php
	}
}

/**
 * After Cart Table 
 *
 * Add Back to Shop button
 * Add Clear Cart Button
 * Add Update Cart Button
 * Add Process to Checkout button
 *
*/
if(!function_exists('overcome_woocommerce_after_cart_table')){
	add_action('woocommerce_after_cart_table','overcome_woocommerce_after_cart_table', 1);
	/**
	 * Change proceed to checkout button position
	*/
	remove_action('woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);

	function overcome_woocommerce_after_cart_table(){
	?>
	<div class="ef5-after-cart-table row justify-content-between gutters-30">
		<div class="col-lg-6 col-left align-items-center d-md-flex justify-content-lg-start justify-content-center text-center">
			<?php do_action('overcome_woocommerce_after_cart_table_left'); ?>
		</div>
		<div class="col-lg-6 col-right align-items-center d-md-flex justify-content-lg-end justify-content-center">
			<button type="submit" class="btn button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'overcome' ); ?>"><span class="fa fa-refresh">&nbsp;&nbsp;</span><span><?php esc_html_e( 'Update cart', 'overcome' ); ?></span></button>
			<a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button ef5-btn accent outline ef5-btn-lg">
				<span class="far fa-plus">&nbsp;&nbsp;</span><span><?php esc_html_e( 'Order Now', 'overcome' ); ?></span>
			</a>
		</div>
	</div>
	<?php
	}
}
/* Return Shop Button */
if(!function_exists('overcome_woocommerce_return_shop')){
	add_action('overcome_woocommerce_after_cart_table_left', 'overcome_woocommerce_return_shop');
	function overcome_woocommerce_return_shop(){
		if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
			<a class="ef5-btn accent fill ef5-btn-lg" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<span class="far fa-shopping-basket">&nbsp;&nbsp;</span><span><?php esc_html_e( 'Continue Shopping', 'overcome' ); ?></a>
			</a>
		<?php endif; 
	}
}

// check for empty-cart get param to clear the cart
if(!function_exists('overcome_woocommerce_clear_cart_url')){
	add_action( 'init', 'overcome_woocommerce_clear_cart_url' );
	function overcome_woocommerce_clear_cart_url() {
		if ( isset( $_GET['empty-cart'] ) ) {
			WC()->cart->empty_cart();
		}
	}
}
if(!function_exists('overcome_woocommerce_clear_cart_button')){
	add_action('overcome_woocommerce_after_cart_table_left', 'overcome_woocommerce_clear_cart_button');
	function overcome_woocommerce_clear_cart_button(){
		$link = wc_get_cart_url();
        $link = add_query_arg( 'empty-cart', '', $link );
		?>
			<a class="ef5-btn red outline ef5-btn-lg" href="<?php echo esc_url($link);?>"><span class="far fa-times">&nbsp;&nbsp;</span><span><?php esc_html_e( 'Clear Shopping Cart', 'overcome' ); ?></span></a>
		<?php
	}
}

/**
 * Custom Cross Sells Columns and Limit
 * 
*/
add_filter('woocommerce_cross_sells_columns', function() { return apply_filters('overcome_woocommerce_cross_sells_columns', '4');});
add_filter('woocommerce_cross_sells_total', function() { return apply_filters('overcome_woocommerce_cross_sells_columns', '4');});
