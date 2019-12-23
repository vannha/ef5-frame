<?php
/**
 * Template part for displaying site branding
 *
*/
// Default Logo
$logo             = overcome_get_opts( 'logo', array( 'url' => '', 'id' => '' ) );
$logo_size        = overcome_get_opts( 'logo_size', array( 'width' => overcome_configs('logo_width'), 'height' => overcome_configs('logo_height'), 'units' => overcome_configs('logo_units') ) );

$logo_size_w      = overcome_extract_numbers($logo_size['width']) ? overcome_extract_numbers($logo_size['width']) : overcome_configs('logo_width') ;
$logo_size_h      = overcome_extract_numbers($logo_size['height']) ? overcome_extract_numbers($logo_size['height']): overcome_configs('logo_height');
$logo_size_retina = ($logo_size_w*2).'x'.($logo_size_h*2);
$logo_url         = get_template_directory_uri() . '/assets/images/logo/logo.png';
$logo_url_retina  = get_template_directory_uri() . '/assets/images/logo/logo-retina.png';
if ( !empty($logo['id']) ) {
    $logo_mime_type  = get_post_mime_type($logo['id']);
    if($logo_mime_type !== 'image/svg+xml'){
        $logo_url        =  overcome_get_image_url_by_size( [
            'id'   => $logo['id'], 
            'size' => $logo_size_w.'x'.$logo_size_h
        ]);
        $logo_url_retina =  overcome_get_image_url_by_size( [
            'id'   => $logo['id'], 
            'size' => $logo_size_retina
        ]);
    } else {
        $logo_url        =  $logo['url'];
        $logo_url_retina =  $logo['url'];
    }
}
// On Top Logo
$header_ontop           = overcome_get_opts('header_ontop','0');
$ontop_logo             = overcome_get_opts( 'ontop_logo', array( 'url' => '', 'id' => '' ) );
$ontop_logo_size        = overcome_get_opts( 'ontop_logo_maxh', array( 'width' => overcome_configs('logo_width'), 'height' => overcome_configs('logo_height'), 'units' => overcome_configs('logo_units') ) );
$ontop_logo_size_w      = overcome_extract_numbers($ontop_logo_size['width']) ?  overcome_extract_numbers($ontop_logo_size['width']) : overcome_configs('logo_width');
$ontop_logo_size_h      = overcome_extract_numbers($ontop_logo_size['height']) ? overcome_extract_numbers($ontop_logo_size['height']) : overcome_configs('logo_height');
$ontop_logo_size_retina = ($ontop_logo_size_w*2).'x'.($ontop_logo_size_h*2);
$ontop_logo_url         = get_template_directory_uri() . '/assets/images/logo/logo-ontop.png';
$ontop_logo_url_retina  = get_template_directory_uri() . '/assets/images/logo/logo-ontop-retina.png';
if ( !empty($ontop_logo['id']) ) {
    $logo_mime_type  = get_post_mime_type($ontop_logo['id']);
    if($logo_mime_type !== 'image/svg+xml'){
        $ontop_logo_url        =  overcome_get_image_url_by_size( [
            'id'   => $ontop_logo['id'], 
            'size' => $ontop_logo_size_w.'x'.$ontop_logo_size_h
        ]);
        $ontop_logo_url_retina = overcome_get_image_url_by_size( [
            'id'   => $ontop_logo['id'], 
            'size' => $ontop_logo_size_retina 
        ]);
    } else {
        $ontop_logo_url        =  $ontop_logo['url'];
        $ontop_logo_url_retina =  $ontop_logo['url'];
    }
}

// Sticky Logo 
$header_sticky           = overcome_get_opts('header_sticky','0');
$sticky_logo             = overcome_get_opts( 'sticky_logo', array( 'url' => '', 'id' => '' ) );

$sticky_logo_size        = overcome_get_opts( 'sticky_logo_maxh', array( 'width' => overcome_configs('logo_width'), 'height' => overcome_configs('logo_height'), 'units' => overcome_configs('logo_units') ) );
$sticky_logo_size_w      = overcome_extract_numbers($sticky_logo_size['width']) ? overcome_extract_numbers($sticky_logo_size['width']) : overcome_configs('logo_width');
$sticky_logo_size_h      = overcome_extract_numbers($sticky_logo_size['height']) ? overcome_extract_numbers($sticky_logo_size['height']) : overcome_configs('logo_height');
$sticky_logo_size_retina = ($sticky_logo_size_w*2).'x'.($sticky_logo_size_h*2);

$sticky_logo_url         = get_template_directory_uri() . '/assets/images/logo/logo-ontop.png';
$sticky_logo_url_retina  = get_template_directory_uri() . '/assets/images/logo/logo-ontop-retina.png';

if(empty($sticky_logo['id'])) {
    $sticky_logo['id'] = $logo['id'];
    $sticky_logo['url'] = $logo['url'];
}
if ( !empty($sticky_logo['id'] ))
{
    $logo_mime_type  = get_post_mime_type($sticky_logo['id']);
    if($logo_mime_type !== 'image/svg+xml'){
        $sticky_logo_url        = overcome_get_image_url_by_size( [
            'id'   => $sticky_logo['id'], 
            'size' => $sticky_logo_size_w.'x'.$sticky_logo_size_h
        ]);
        $sticky_logo_url_retina    = overcome_get_image_url_by_size( [
            'id'   => $sticky_logo['id'], 
            'size' => $sticky_logo_size_retina 
        ]);
    } else {
        $sticky_logo_url        =  $sticky_logo['url'];
        $sticky_logo_url_retina =  $sticky_logo['url'];
    }
}
// Show Logo
if ( has_custom_logo() ){
    // Custom logo from Appearance Customize
    the_custom_logo(); 
} else {
    // Default logo
    printf(
        '<a class="main-logo" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%4$s" srcset="%5$s %6$s" sizes="(max-width: %7$s) 100vw, %8$s" width="%9$s" height="%10$s"/></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url( $logo_url ),   
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url($logo_url_retina),
        esc_attr($logo_size_w).'w',
        esc_attr($logo_size_w).$logo_size['units'],
        esc_attr($logo_size_w).$logo_size['units'],
        esc_attr($logo_size_w),
        esc_attr($logo_size_h)
    );
    // On Top Logo 
    if ( $ontop_logo_url && $header_ontop )
    {
        printf(
            '<a class="ontop-logo" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%4$s" srcset="%5$s %6$s" sizes="(max-width: %7$s) 100vw, %8$s" width="%9$s" height="%10$s"/></a>',
                esc_url( home_url( '/' ) ),
                esc_attr( get_bloginfo( 'name' ) ),
                esc_url( $ontop_logo['url'] ),   
                esc_attr( get_bloginfo( 'name' ) ),
                esc_url($ontop_logo_url_retina),
                esc_attr($ontop_logo_size_w).'w',
                esc_attr($ontop_logo_size_w).$ontop_logo_size['units'],
                esc_attr($ontop_logo_size_w).$ontop_logo_size['units'],
                esc_attr($ontop_logo_size_w),
                esc_attr($ontop_logo_size_h)
        );
    }
    // Sticky Logo
    if ( $sticky_logo_url && $header_sticky)
    {
        printf(
            '<a class="sticky-logo" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%4$s" srcset="%5$s %6$s" sizes="(max-width: %7$s) 100vw, %8$s" width="%9$s" height="%10$s"/></a>',
                esc_url( home_url( '/' ) ),
                esc_attr( get_bloginfo( 'name' ) ),
                esc_url( $sticky_logo_url ),   
                esc_attr( get_bloginfo( 'name' ) ),
                esc_url($sticky_logo_url_retina),
                esc_attr($sticky_logo_size_w).'w',
                esc_attr($sticky_logo_size_w).$sticky_logo_size['units'],
                esc_attr($sticky_logo_size_w).$sticky_logo_size['units'],
                esc_attr($sticky_logo_size_w),
                esc_attr($sticky_logo_size_h)
        );
    }
}
