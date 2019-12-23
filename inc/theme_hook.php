<?php
/**
 * Primary Color 
 * use filter: 'ef5frame_primary_color';
 * @return string
 * @example add_filter('ef5frame_primary_color', function(){ return '#000000';});
*/
/**
 * Accent Color 
 * use filter : ef5frame_accent_color
 * @return string
 * @example add_filter('ef5frame_accent_color', function(){ return '#25d6a2';});
*/

/**
 * Page CSS Class
 * use filter: ef5frame_page_css_class
 * @return array
 * @example add_filter('ef5frame_page_css_class', function($cls) { $cls[] = 'yout-css-class';  return $cls;});
*/

/**
 * Header link color, 
 * use filter: ef5frame_header_link_color
 * 
 * @return array('regular' => '', 'hover' => '', 'active' => '')
 * @example add_filter('ef5frame_header_link_color', function(){ return ['regular' => 'black', 'hover' => 'red', 'active' => 'violet'];})
*/
/**
 * Header OnTop link color, 
 * use filter: ef5frame_ontop_link_color
 * 
 * @return array('regular' => '', 'hover' => '', 'active' => '')
 * @example add_filter('ef5frame_ontop_link_color', function(){ return ['regular' => 'black', 'hover' => 'red', 'active' => 'violet'];})
*/

/**
 * Header Sticky link color, 
 * use filter: ef5frame_sticky_link_color
 * 
 * @return array('regular' => '', 'hover' => '', 'active' => '')
 * @example add_filter('ef5frame_sticky_link_color', function(){ return ['regular' => 'black', 'hover' => 'red', 'active' => 'violet'];})
*/

/**
 * Dropdown Background color, 
 * use filter: ef5frame_dropdown_bg
 * 
 * @return string
 * @example add_filter('ef5frame_dropdown_bg', function(){ return 'rgba(#000000, 1)';})
*/

/**
 * Dropdown link color, 
 * use filter: ef5frame_dropdown_link_colors
 * 
 * @return array('regular' => '', 'hover' => '', 'active' => '')
 * @example add_filter('ef5frame_dropdown_link_colors', function(){ return ['regular' => 'white', 'hover' => 'red', 'active' => 'violet'];})
*/

/**
 * Logo Size
 * use filter: ef5frame_logo_size
 * @return array(width, height, units)
 * @example add_filter('ef5frame_logo_size', function() { return ['width' => '130', 'height' => '51', 'units' => 'px'];});
*/

/**
 * Show Default Post thumbnail
 * use filter : ef5frame_default_post_thumbnail
 * @return bool
 * @default false
 * @example add_filter('ef5frame_default_post_thumbnail', function(){ return false;});
*/
add_filter('ef5frame_default_post_thumbnail', function(){ return ef5frame_configs('ef5frame_default_post_thumbnail');});

/**
 * Default sidebar position 
 * use filter: ef5frame_archive_sidebar_position
 * @return string left / right / none
 * @example add_filter('ef5frame_archive_sidebar_position', function(){ return 'right';});
*/
add_filter('ef5frame_archive_sidebar_position', function(){ return 'bottom';});
/**
 * Default Archive grid columns
 * use filter : ef5frame_archive_grid_col
 * @return string 1 - 12
 * @example add_filter('ef5frame_archive_grid_col', function(){ return '8';});
*/

/**
 * Default Archive Pagination
 * use filter: ef5frame_loop_pagination
 * @return string 1 - 5
 * @example: add_filter('ef5frame_loop_pagination', function(){ return '3';});
*/

/**
 * Default Archive Pagination Prev Text
 * use filter: ef5frame_loop_pagination_prev_text
 * @return string 
 * @example: add_filter('ef5frame_loop_pagination_prev_text', function(){ return esc_html__('Previous', 'ef5-frame');});
*/

/**
 * Default Archive Pagination Next Text
 * use filter: ef5frame_loop_pagination_next_text
 * @return string 
 * @example: add_filter('ef5frame_loop_pagination_next_text', function(){ return esc_html__('Next', 'ef5-frame');});
*/

/**
 * Default Archive Pagination Sep Text
 * use filter: ef5frame_loop_pagination_sep_text
 * @return string 
 * @example: add_filter('ef5frame_loop_pagination_sep_text', function(){ return '<span class="d-none"></span>';});
*/

/**
 * Show post related by taxonomy
 * use filter: ef5frame_post_related_by
 * @return string
 * @default cat
 * @example add_filter('ef5frame_post_related_by', function(){return 'cat';});
*/

/**
 * Remove Supported post type for VC Element 
 * use filter : ef5frame_vc_post_type_list 
 * @return array
 * @example add_filter('ef5frame_vc_post_type_list', function($post_type){ $post_type[] = 'ef5_header_top'; return $post_type;});
*/

// Support Portfolio or Not
add_filter('ef5frame_cpts_portfolio',function(){ return true;});
// Support header Top
add_filter('ef5frame_cpts_header_top', function(){ return true;});
// Support Footer Top
add_filter('ef5frame_cpts_footer', function(){ return true;});

/**
 * Custom WooCommerce
 * Custom single images, loop images, gallery thumbnail, cart thumbnail size
 * 
*/
/**
 * WooCommerce loop thumbnail size
 * use filter: 
 * width: ef5frame_product_loop_image_w
 * height: ef5frame_product_loop_image_h
 * @return string
 * @example 
 * widht : apply_filters('ef5frame_product_loop_image_w', funtion(){ return '400';});
 * height : apply_filters('ef5frame_product_loop_image_h', funtion(){ return '400';});
*/

/**
 * WooCommerce single thumbnail size
 * use filter: 
 * width: ef5frame_product_single_image_w
 * height: ef5frame_product_single_image_h
 * @return string
 * @example 
 * widht : apply_filters('ef5frame_product_single_image_w', funtion(){ return '600';});
 * height : apply_filters('ef5frame_product_single_image_h', funtion(){ return '600';});
*/

/**
 * WooCommerce gallery thumbnail size
 * use filter: 
 * width: ef5frame_product_gallery_thumbnail_w
 * height: ef5frame_product_gallery_thumbnail_h
 * @return string
 * @example 
 * widht : apply_filters('ef5frame_product_gallery_thumbnail_w', funtion(){ return '100';});
 * height : apply_filters('ef5frame_product_gallery_thumbnail_h', funtion(){ return '100';});
*/

/**
 * WooCommerce cart thumbnail size
 * use filter: 
 * size: ef5frame_woocommerce_cart_item_thumbnail_size
 * @return string
 * @example 
 * size : apply_filters('ef5frame_woocommerce_cart_item_thumbnail_size', funtion(){ return '100x100';});
 * 
*/

/**
 * Add your theme spacing
*/
add_filter('ef5systems_spacings','ef5frame_spacings');
function ef5frame_spacings(){
	return [
		'custom1' => ['EF5Frame Space 01', 'Top 8px - Bottom 8px'],
	];
}

/**
 * Add your theme Gutter
*/
add_filter('ef5systems_gutters','ef5frame_gutters');
function ef5frame_gutters(){
	return [
		'20' => [
			'title' => 'EF5Frame Gutter 20', 
			'desc'  => '',
			'key'   => '20',
			'value' => '20px'
		]
	];
}

/**
 * Add your theme Color
*/
add_filter('ef5systems_colors','ef5frame_colors');
function ef5frame_colors(){
	return [
		'inherit' => ['Inherit', 'inherit'],
		'white'   => ['White', '#fff'],
		'overlay' => ['Overlay Background', 'rgba(0,0,0,0.5)'],
	];
}

/**
 * Custom OWL Nav Style
*/
add_filter('ef5systems_carousel_custom_nav_style', 'ef5frame_owl_custom_nav_style');
function ef5frame_owl_custom_nav_style(){
	return [
		esc_html__('EF5Frame Style 01','ef5-frame') => 'ef5frame-1'
	];
}
/**
 * Custom OWL Dots Style
*/
add_filter('ef5systems_carousel_custom_dots_style', 'ef5frame_owl_custom_dots_style');
function ef5frame_owl_custom_dots_style(){
	return [
		esc_html__('Custom 01','ef5-frame') => 'custom1'
	];
}
add_filter('ef5systems_carousel_custom_dot_color', 'ef5frame_owl_custom_dot_color');
function ef5frame_owl_custom_dot_color(){
	return [
		esc_html__('Custom 01','ef5-frame') => 'custom1',
	];
}
