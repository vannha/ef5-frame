<?php
/**
 * Filtered list
*/
function ef5frame_woo_filtered_list($args = []){
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}
	$args = wp_parse_args($args, [
		'title' => '<h3 class="ef5-heading widgettitle">'.esc_html__('Active Filters','ef5-frame').'</h3>'
	]);
	$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
	$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0; // WPCS: input var ok, CSRF ok.
	$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0; // WPCS: input var ok, CSRF ok.
	$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // WPCS: sanitization ok, input var ok, CSRF ok.
	$base_link          = ef5frame_get_current_page_url();

	if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) ) {
		echo '<div class="'.esc_attr($args['class']).'">';
		if(!empty($args['title'])) echo ef5frame_html($args['title']);
		echo '<ul>';

		// Attributes.
		if ( ! empty( $_chosen_attributes ) ) {
			foreach ( $_chosen_attributes as $taxonomy => $data ) {
				foreach ( $data['terms'] as $term_slug ) {
					$term = get_term_by( 'slug', $term_slug, $taxonomy );
					if ( ! $term ) {
						continue;
					}

					$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
					$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array(); // WPCS: input var ok, CSRF ok.
					$current_filter = array_map( 'sanitize_title', $current_filter );
					$new_filter     = array_diff( $current_filter, array( $term_slug ) );

					$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

					if ( count( $new_filter ) > 0 ) {
						$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
					}

					echo '<li class="chosen"><a class="hint--top" rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'ef5-frame' ) . '" href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a></li>';
				}
			}
		}

		if ( $min_price ) {
			$link = remove_query_arg( 'min_price', $base_link );
			/* translators: %s: minimum price */
			echo '<li class="chosen"><a class="hint--top" rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'ef5-frame' ) . '" href="' . esc_url( $link ) . '">' . sprintf( __( 'Min %s', 'ef5-frame' ), wc_price( $min_price ) ) . '</a></li>'; // WPCS: XSS ok.
		}

		if ( $max_price ) {
			$link = remove_query_arg( 'max_price', $base_link );
			/* translators: %s: maximum price */
			echo '<li class="chosen"><a class="hint--top" rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'ef5-frame' ) . '" href="' . esc_url( $link ) . '">' . sprintf( __( 'Max %s', 'ef5-frame' ), wc_price( $max_price ) ) . '</a></li>'; // WPCS: XSS ok.
		}

		if ( ! empty( $rating_filter ) ) {
			foreach ( $rating_filter as $rating ) {
				$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
				$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );

				/* translators: %s: rating */
				echo '<li class="chosen"><a class="hint--top" rel="nofollow" aria-label="' . esc_attr__( 'Remove filter', 'ef5-frame' ) . '" href="' . esc_url( $link ) . '">' . sprintf( esc_html__( 'Rated %s out of 5', 'ef5-frame' ), esc_html( $rating ) ) . '</a></li>';
			}
		}

		echo '<li class="chosen remove-all"><a href="'.get_permalink( wc_get_page_id( 'shop' )).'">'.esc_attr__('Clear All','ef5-frame').'</a></li>';

		echo '</ul>';
		echo '</div>';
	}
}
