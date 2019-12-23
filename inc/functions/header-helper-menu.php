<?php
/**
 * Header Helper Menu 
*/
if(!function_exists('overcome_header_helper_menu')){
    function overcome_header_helper_menu($args = []){
        $header_helper_menu = overcome_get_opts('header_helper_menu','-1');
        if(!is_nav_menu($header_helper_menu)) return;
        $args = wp_parse_args($args,[
            'class'      => 'justify-content-end',
            'menu_class' => 'd-flex align-items-center'
        ]);
        $container_class = trim(implode(' ', ['ef5-header-helper', 'align-items-center', 'd-none', 'd-xl-flex', $args['class']]));
        $menu_class      = trim(implode(' ', ['ef5-header-helper-menu', $args['menu_class']]));
        $args =  array(
            'menu'           => $header_helper_menu,
            'container'      => 'div',
            'container_class'=> $container_class,
            'depth'          => '1',
            'menu_id'        => 'ef5-header-helper-menu',
            'menu_class'     => $menu_class,
            'fallback_cb'    => false
        );
        wp_nav_menu($args);
    }
}