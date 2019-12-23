<?php
/**
 * Widget Layered Nav
 * Change count output
*/
if(!function_exists('overcome_wc_attr_count_span')){
	add_filter('woocommerce_layered_nav_term_html', 'overcome_woocommerce_layered_nav_term_html');
    function overcome_woocommerce_layered_nav_term_html($term_html) {
        //$term_html = str_replace('"> <span class="count">(', ' <span class="count">', $term_html);
        $term_html = str_replace('</a> <span class="count">(', ' <span class="count">', $term_html);
        $term_html = str_replace(')</span>', '</span></a>', $term_html);
        return $term_html;
    }
}

/**
 * Widget Product Categories
 * Change count output
*/
if(class_exists('WC_Widget_Product_Categories')){
	include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';
	if(!function_exists('overcome_woocommerce_product_categories_widget_args')){
		add_filter('woocommerce_product_categories_widget_args', 'overcome_woocommerce_product_categories_widget_args', 10, 1);
		function overcome_woocommerce_product_categories_widget_args($list_args){
			$list_args['walker'] = new OverCome_WC_Product_Cat_List_Walker();
			return $list_args;
		}
	}

	class OverCome_WC_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker{
		public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
			$cat_id = intval( $cat->term_id );

			$output .= '<li class="ef5-menu-item ef5-cat-item ef5-cat-item-' . $cat_id;

			if ( $args['current_category'] === $cat_id ) {
				$output .= ' current-cat';
			}

			if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
				$output .= ' cat-parent';
			}

			if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat_id, $args['current_category_ancestors'], true ) ) {
				$output .= ' current-cat-parent';
			}

			$output .= '"><a href="' . get_term_link( $cat_id, $this->tree_type ) . '"><span class="title">' . apply_filters( 'list_product_cats', $cat->name, $cat ).'</span>';

			if ( $args['show_count'] ) {
				$output .= ' <span class="count">' . $cat->count . '</span>';
			}

			if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
				$output .= overcome_widget_expander();
			}

			$output .= '</a>';
		}
	}
}
