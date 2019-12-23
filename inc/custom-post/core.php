<?php

/**
 * Add custom post type Header Top
 *
 * This custom post used for build Header Top section
 *
*/
add_filter('ef5_extra_post_types', 'ef5frame_cpts_header_top', 10 , 1);
function ef5frame_cpts_header_top($post_types)
{
    $header_top = apply_filters('ef5frame_cpts_header_top', false);
    if($header_top) {
        $post_types['ef5_header_top'] = array(
            'status'        => true,
            'name'          => esc_html__('EF5Frame Header Top', 'ef5-frame'),
            'singular_name' => esc_html__('EF5Frame Headers Top', 'ef5-frame'),
            'args'          => array(
                'description'         => 'Add custom Header Top Layout ',
                'public'              => true,
                'publicly_queryable'  => false,
                'show_ui'             => true,
                'show_in_rest'        => false,
                'rest_base'           => '',
                'has_archive'         => false,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => false,
                'exclude_from_search' => true,
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'hierarchical'        => false,
                'rewrite'             => false,
                'query_var'           => true,
                'menu_position'       => 20,
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => array( 'title', 'editor','thumbnail' ),
            ),
            
        );
    }
    return $post_types;
}


/**
 * Add custom post type Footer 
 * 
 * This custom post used for build Footer Top section
 *
 */
add_filter('ef5_extra_post_types', 'ef5frame_cpts_footer', 10 , 1);
function ef5frame_cpts_footer($post_types) {
    $enable_footer = apply_filters('ef5frame_cpts_footer', false);
    if($enable_footer) {
        $post_types['ef5_footer'] = array(
            'status'        => true,
            'name'          => esc_html__('EF5Frame Footer', 'ef5-frame'),
            'singular_name' => esc_html__('EF5Frame Footers', 'ef5-frame'),
            'args'          => array(
                'description'         => 'Add custom Footer Layout ',
                'public'              => true,
                'publicly_queryable'  => false,
                'show_ui'             => true,
                'show_in_rest'        => false,
                'rest_base'           => '',
                'has_archive'         => false,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => false,
                'exclude_from_search' => true,
                'capability_type'     => 'post',
                'map_meta_cap'        => true,
                'hierarchical'        => false,
                'rewrite'             => false,
                'query_var'           => true,
                'menu_position'       => 20,
                'menu_icon'           => 'dashicons-editor-insertmore',
                'supports'            => array( 'title', 'editor', 'thumbnail' ),
            ),
        );
    }
    return $post_types;    
}
