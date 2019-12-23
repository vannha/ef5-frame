<?php
/**
 * Single Product Message
 *
 * Added to cart message 
*/
if(!function_exists('overcome_wc_add_to_cart_message_html')){
	add_filter('wc_add_to_cart_message_html','overcome_wc_add_to_cart_message_html', 10, 3);
	function overcome_wc_add_to_cart_message_html($message, $products, $show_qty){
		$titles = array();
		$count  = 0;

		if ( ! is_array( $products ) ) {
			$products = array( $products => 1 );
			$show_qty = false;
		}

		if ( ! $show_qty ) {
			$products = array_fill_keys( array_keys( $products ), 1 );
		}

		foreach ( $products as $product_id => $qty ) {
			/* translators: %s: product name */
			$titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'overcome' ), strip_tags( get_the_title( $product_id ) ) ), $product_id );
			$count   += $qty;
		}

		$titles = array_filter( $titles );
		/* translators: %s: product name */
		$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'overcome' ), wc_format_list_of_items( $titles ) );
		// Output success messages.
		if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
			$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
			$message   = sprintf( '<span class="text">%s</span> <a href="%s" tabindex="1" class="button wc-forward msg-viewcart ef5-btn fill accent ef5-btn-df">%s</a>',esc_html( $added_text ), esc_url( $return_to ), esc_html__( 'Continue shopping', 'overcome' ));
		} else {
			$message = sprintf( '<span class="text">%s</span> <a href="%s" tabindex="1" class="button wc-forward msg-viewcart ef5-btn fill accent ef5-btn-df">%s</a>',esc_html( $added_text ), esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View cart', 'overcome' ));
		}

		return $message;
	}
}