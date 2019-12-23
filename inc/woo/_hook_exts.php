<?php
/**
 * Custom WooCommerce Extensions
 * Like : 
 * - WPClever: Compare, Wishlist, Quick View
*/

/**
 * Custom Woo Smart Quick View
 *
 * Change Quick View button position
 *
*/
$wc_quickview_to_attrs = apply_filters('overcome_wc_quickview_to_attrs', '1');
if(class_exists('WPcleverWoosq') && $wc_quickview_to_attrs === '1'){
    add_filter( 'woosq_button_position', function() { return '0';  } );
    add_action('overcome_woocommerce_loop_product_add_to_cart', function(){
        global $product;
        $woosq_text = apply_filters('woosq_button_text', get_option( 'woosq_button_text', esc_html__( 'Quick view', 'overcome' ) ));
        echo '<div class="woosmart-icon quickview-icon hint--top-'.overcome_align2().'" data-hint="'.esc_html($woosq_text).'">'.do_shortcode('[woosq id="'.$product->get_id().'" type="link"]').'</div>';
    },1);
}
/**
 * Custom Woo Smart Add to Wishlist
 *
 * Change Add to Wishlist button position
 *
*/
$wc_wishlist_to_attrs = apply_filters('overcome_wc_wishlist_to_attrs', '1');
if(class_exists('WPcleverWoosw')){
	// Loop 
	if($wc_wishlist_to_attrs === '1'){
	    add_filter( 'woosw_button_position_archive', function() { return '0'; } );
	    add_action('overcome_woocommerce_loop_product_add_to_cart', function(){
	        global $product;
            $woosw_text  = apply_filters( 'woosw_button_text', get_option( 'woosw_button_text', esc_html__( 'Add to Wishlist', 'overcome' ) ) );
	        $woosw_text_added  = apply_filters( 'woosw_button_text_added', get_option( 'woosw_button_text_added', esc_html__( 'Browse Wishlist', 'overcome' ) ) );
	        echo '<div class="woosmart-icon wishlist-icon hint--top-'.overcome_align2().'" data-selected="'.esc_html($woosw_text_added).'" data-hint="'.esc_html($woosw_text).'">'.do_shortcode('[woosw id="'.$product->get_id().'" type="link"]').'</div>';
	    },2);
	}
    // Single
    add_filter( 'woosw_button_position_single', function() {
        return '0';
    } );
    add_action('woocommerce_after_add_to_cart_button', function(){
        global $product;
        $woosw_text  = apply_filters( 'woosw_button_text', get_option( 'woosw_button_text', esc_html__( 'Add to Wishlist', 'overcome' ) ) );
        $woosw_text_added  = apply_filters( 'woosw_button_text_added', get_option( 'woosw_button_text_added', esc_html__( 'Browse Wishlist', 'overcome' ) ) );
        echo '<div class="wc-single-btn woosmart-btn wishlist-btn hint--bounce hint--bottom" data-selected="'.esc_html($woosw_text_added).'" data-hint="'.esc_html($woosw_text).'">'.do_shortcode('[woosw id="'.$product->get_id().'"]').'</div>';
    },12);
}

/**
 * Custom Woo Smart Compare
 * 
 * Change Compare button position
 *
*/
$wc_compare_to_attrs = apply_filters('overcome_wc_compare_to_attrs', '1');
if(class_exists('WPcleverWooscp')){
    // Loop
    if($wc_compare_to_attrs === '1'){
        add_filter( 'filter_wooscp_button_archive', function() { return '0'; } );
        add_action('overcome_woocommerce_loop_product_add_to_cart', 'overcome_wooscp_icon', 3);
        function overcome_wooscp_icon(){
            global $product;
            $wooscp_text = apply_filters('wooscp_button_text', get_option( '_wooscp_button_text', esc_html__( 'Compare', 'overcome' ) ));
            echo '<div class="woosmart-icon compare-icon hint--top-'.overcome_align2().'" data-selected="'.esc_html__('Open Compared List','overcome').'" data-hint="'.esc_html($wooscp_text).'">'.do_shortcode('[wooscp id="'.$product->get_id().'" type="link"]').'</div>';
        }
    }

    // Single 
    add_filter( 'filter_wooscp_button_single', function() { return '0'; } ); 
    add_action('woocommerce_after_add_to_cart_button', 'overcome_wooscp_button', 10);
    function overcome_wooscp_button(){
        global $product;
        $wooscp_text = apply_filters('wooscp_button_text', get_option( '_wooscp_button_text', esc_html__( 'Compare', 'overcome' ) ));
        echo '<div class="wc-single-btn woosmart-btn compare-btn hint--bounce hint--bottom" data-selected="'.esc_html__('Open Compared List','overcome').'" data-hint="'.esc_html($wooscp_text).'">'.do_shortcode('[wooscp id="'.$product->get_id().'"]').'</div>';
    }
}