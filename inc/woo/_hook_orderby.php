<?php
/**
 * Output the product sorting options.
 * Custom html output layout 
 * Display as list
 */
if ( ! function_exists( 'ef5frame_woocommerce_catalog_ordering_list' ) ) {
    /**
     * Products Filter
     * Filter By Order
     * add_action('ef5frame_woocommerce_filter_orderby', 'ef5frame_woocommerce_catalog_ordering_list', 2);
    */
    
    function ef5frame_woocommerce_catalog_ordering_list() {
        if(is_active_sidebar('shop-filter')) return; 
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => esc_html__( 'Default sorting', 'ef5-frame' ),
            'popularity' => esc_html__( 'Sort by popularity', 'ef5-frame' ),
            'rating'     => esc_html__( 'Sort by average rating', 'ef5-frame' ),
            'date'       => esc_html__( 'Sort by newness', 'ef5-frame' ),
            'price'      => esc_html__( 'Sort by price: low to high', 'ef5-frame' ),
            'price-desc' => esc_html__( 'Sort by price: high to low', 'ef5-frame' ),
        ) );

        $default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
        $orderby         = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.

        if ( wc_get_loop_prop( 'is_search' ) ) {
            $catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'ef5-frame' ) ), $catalog_orderby_options );

            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
            unset( $catalog_orderby_options['rating'] );
        }

        if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
            $orderby = current( array_keys( $catalog_orderby_options ) );
        }
        ?>
        <div class="widget orderby col">
            <h3 class="ef5-heading widgettitle"><?php esc_html_e('Sort By','ef5-frame');?></h3>
            
            <ul class="orderby">
                <?php foreach ( $catalog_orderby_options as $id => $name ) :
                    $link = ef5frame_get_current_page_url();        
                    $link = add_query_arg( 'orderby', $id, $link );
                ?>
                    <li>
                        <a href="<?php echo esc_url( $link ); ?>" data-order="<?php echo esc_attr( $id ); ?>"
                           class="ef5-filter <?php if ( selected( $orderby, $id, false ) ) {
                               echo 'chosen active';
                           } ?>"><?php echo esc_html( $name ); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input type="hidden" name="paged" value="1" />
            <?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
        </div>
        <?php

    }
}
if(!function_exists('ef5frame_woocommerce_get_catalog_ordering_args')){
    add_filter( 'woocommerce_get_catalog_ordering_args', 'ef5frame_woocommerce_get_catalog_ordering_args' );
    function ef5frame_woocommerce_get_catalog_ordering_args( $args ) {
      
      $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        if ( 'on_sale' == $orderby_value ) {
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'desc';
            $args['meta_key'] = '_sale_price';
        }
        if('bestselling' == $orderby_value){
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'desc';
            $args['meta_key'] = 'total_sales';
        }
        
        return $args;
    }
}
if(!function_exists('ef5frame_woocommerce_default_catalog_orderby_options')){
    add_filter( 'woocommerce_default_catalog_orderby_options', 'ef5frame_woocommerce_default_catalog_orderby_options' );
    add_filter( 'woocommerce_catalog_orderby', 'ef5frame_woocommerce_default_catalog_orderby_options' );
    function ef5frame_woocommerce_default_catalog_orderby_options( $sortby ) {
        $sortby['on_sale']     = esc_html__('Sort by On Sale','ef5-frame');
        $sortby['bestselling'] = esc_html__('Sort by Best Selling','ef5-frame');
        return $sortby;
    }
}