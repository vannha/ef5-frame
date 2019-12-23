<?php
/**
 * Template part for displaying the primary menu of the site
 */
$header_menu   = overcome_get_opts('header_menu','');
if('none' === $header_menu) return;

/* Mega Menu */
$megamenu = apply_filters('ef5_enable_megamenu', false);
$args =  array(
    'theme_location' => 'ef5-primary',
    'menu'           => $header_menu,
    'container'      => '',
    'menu_id'        => 'ef5-header-menu',
    'menu_class'     => overcome_header_menu_class(),
    'link_before'	 => '<span class="menu-title">',
    'link_after'	 => '</span>',	
    'walker'         => ($megamenu && class_exists( 'EF5Systems_MegaMenu_Walker' )) ? new EF5Systems_MegaMenu_Walker : new OverCome_Main_Menu_Walker,
    'fallback_cb' =>   'overcome_header_menu_fallback'
);
wp_nav_menu($args);
