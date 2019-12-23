<?php
/**
 * Get current page URL with various filtering props supported by WC.
 *
 * @return string
 * @since  3.3.0
 */
function overcome_get_current_page_url() {
	if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
		$link = home_url();
	} elseif ( is_shop() ) {
		$link = get_permalink( wc_get_page_id( 'shop' ) );
	} elseif ( is_product_category() ) {
		$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
	} elseif ( is_product_tag() ) {
		$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
	} else {
		$queried_object = get_queried_object();
		$link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
	}

	// Min/Max.
	if ( isset( $_GET['min_price'] ) ) {
		$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
	}

	if ( isset( $_GET['max_price'] ) ) {
		$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
	}

	// Order by.
	if ( isset( $_GET['orderby'] ) ) {
		$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
	}

	/**
	 * Search Arg.
	 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
	 */
	if ( get_search_query() ) {
		$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
	}

	// Post Type Arg.
	if ( isset( $_GET['post_type'] ) ) {
		$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );
	}

	// Min Rating Arg.
	if ( isset( $_GET['rating_filter'] ) ) {
		$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
	}

	// All current filters.
	if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
		foreach ( $_chosen_attributes as $name => $data ) {
			$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
			if ( ! empty( $data['terms'] ) ) {
				$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
			}
			if ( 'or' === $data['query_type'] ) {
				$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
			}
		}
	}

	return $link;
}