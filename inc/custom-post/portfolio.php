<?php
/**
 * Custom post type Portfolio
 * 
 * This custom make some custom to Portfolio
 *
 */
add_filter('ef5_extra_post_type_portfolio', '__return_false');

add_filter('ef5_extra_post_types', 'ef5frame_cpts_portfolio', 10 , 1);
function ef5frame_cpts_portfolio($post_types) {
	$supported_portfolio = apply_filters('ef5_extra_post_type_portfolio', false);
    if($supported_portfolio) {
	    $post_types['ef5_portfolio'] = array( 
	    	'status'        => true,
			'name'          => esc_html__('EF5Frame Portfolios', 'ef5-frame'),
			'singular_name' => esc_html__('EF5Frame Portfolio', 'ef5-frame'),
			'args'          => array(
				'menu_position' => 15,
				'menu_icon'     => 'dashicons-portfolio',
				'rewrite'       => array(
					'slug'       => ef5frame_get_theme_opt('portfolio_slug','ef5-frame'), 
					'with_front' => true
	            )
	        ) 
	    );
	}
    return $post_types;
}
add_filter('ef5_extra_taxonomies', 'ef5frame_cpts_portfolio_tax', 10 , 1);
function ef5frame_cpts_portfolio_tax($taxo) {
	$supported_portfolio = apply_filters('ef5_extra_post_type_portfolio', false);
    if($supported_portfolio) {
	    $taxo['portfolio_cat'] = array(
	        'taxonomy'   => esc_html__('Portfolio Category', 'ef5-frame'),
	        'taxonomies' => esc_html__('Portfolio Categories', 'ef5-frame'),
	    );
	    $taxo['portfolio_tag'] = array(
	        'taxonomy'   => esc_html__('Portfolio Tag', 'ef5-frame'),
	        'taxonomies' => esc_html__('Portfolio Tags', 'ef5-frame'),
	    );
	}
    return $taxo;
}