<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package EF5 Theme
 * @subpackage OverCome
 * @since 1.0.0
 * @author EF5 Team
 *
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>> 
    <?php overcome_page_loading(); ?>
    <div id="ef5-page" class="<?php overcome_page_css_class();?>">
    <?php overcome_header_top(); ?>
    <div id="ef5-header-wrap">
        <?php
            overcome_header_main(); 
            overcome_page_title();
        ?>
    </div>
    <div id="ef5-main" class="ef5-main">
