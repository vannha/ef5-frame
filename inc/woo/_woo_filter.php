<?php
/**
 * add filter bar
*/
//add_action('ef5frame_woocommerce_before_shop_loop','ef5frame_woocommerce_filter_bar');
function ef5frame_woocommerce_filter_bar(){
    $attribute_array = [];
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    if (!empty($attribute_taxonomies)) {
    foreach ($attribute_taxonomies as $tax) {
        if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))) {
            $attribute_array[$tax->attribute_name] = $tax->attribute_label;
        }
    }
}
?>
	<div class="ef5-woo-filters row">
		<?php 
			$filtered_args = [
                'title' => '<h3 class="ef5-heading widgettitle">'.esc_html__('Active Filters','ef5-frame').'</h3>',
                'class' => 'widget widget_layered_nav_filters col-12',
            ];
            ef5frame_woo_filtered_list($filtered_args);

		    do_action('ef5frame_woocommerce_filter_orderby');
            
            // Filter by Attribute
            foreach ($attribute_array as $key => $value) {
                $filter_attr_args = [
                    'title'           => esc_html($value),
                    'attribute'       => $key,
                    'display_type'    => 'list',
                    'query_type'      => 'and'
                ];
                the_widget(
                    'WC_Widget_Layered_Nav',
                    $filter_attr_args,
                    array(
                        'before_widget' => '<div class="widget widget_layered_nav col">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h3 class="ef5-heading widgettitle">',
                        'after_title'   => '</h3>',
                    ) 
                );
            }
            // Rating Filter
            $filter_rating_args = [
                'title'           => esc_html__('Average Rating','ef5-frame'),
            ];
            the_widget(
                'WC_Widget_Rating_Filter',
                $filter_rating_args,
                array(
                    'before_widget' => '<div class="widget widget_rating_filter col">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="ef5-heading widgettitle">',
                    'after_title'   => '</h3>',
                ) 
            );
            $filter_by_price_args = [
                'title'           => esc_html__('Filter by Price','ef5-frame'),
            ];
            the_widget(
                'WC_Widget_Price_Filter',
                $filter_by_price_args,
                array(
                    'before_widget' => '<div class="widget widget_price_filter col">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h3 class="ef5-heading widgettitle">',
                    'after_title'   => '</h3>',
                ) 
            );

        ?>
	</div>
<?php
}