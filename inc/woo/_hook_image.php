<?php
/**
 * Product Image Thumbnail Size 
 * @since 1.0
 * @since WC 3.x
 * @author Chinh Duong Manh
 * @source https://docs.woocommerce.com/document/image-sizes-theme-developers/
*/

function ef5frame_wc_thumbnail_value($value){
    $image_size_single_width  = ef5frame_configs('ef5frame_product_single_image_w');
    $image_size_single_height = ef5frame_configs('ef5frame_product_single_image_h');

    $thumbnail_image_width  = ef5frame_configs('ef5frame_product_loop_image_w');
    $thumbnail_image_height = ef5frame_configs('ef5frame_product_loop_image_h');;

    $custom_width  = $thumbnail_image_width;
    $custom_height = $thumbnail_image_height;

    $wc_gallery_thumbnail_w = ef5frame_configs('ef5frame_product_gallery_thumbnail_w');
    $wc_gallery_thumbnail_h = ef5frame_configs('ef5frame_product_gallery_thumbnail_h');


    $wc_gallery_thumbnail  = array(
        'width'  => $wc_gallery_thumbnail_w,
        'height' => $wc_gallery_thumbnail_h,
        'crop'   => 1,
    );

    $image_size_thumbnail = array(
        'width'  => $custom_width,
        'height' => $custom_height,
        'crop'   => 1,
    );

    $image_size_single = array(
        'width'  => $image_size_single_width,
        'height' => $image_size_single_height,
        'crop'   => 1,
    );
    switch ($value) {
        case 'image_size_single_width':
            return $image_size_single_width;
            break;
        case 'image_size_single_height':
            return $image_size_single_height;
            break;
        case 'thumbnail_image_width':
            return $thumbnail_image_width;
            break;
        case 'thumbnail_image_height':
            return $thumbnail_image_height;
            break;
        case 'custom_width':
            return $custom_width;
            break;
        case 'custom_height':
            return $custom_height;
            break;
        case 'wc_gallery_thumbnail_w':
            return $wc_gallery_thumbnail_w;
            break;
        case 'wc_gallery_thumbnail_h':
            return $wc_gallery_thumbnail_h;
            break;
        case 'wc_gallery_thumbnail':
            return $wc_gallery_thumbnail;
            break;
        case 'image_size_thumbnail':
            return $image_size_thumbnail;
            break;
        case 'image_size_single':
            return $image_size_single;
            break;
    }
}

/* Loop Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
    return ef5frame_wc_thumbnail_value('image_size_thumbnail');
} ); */

/* Single Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_single', function( $size ) {
    return ef5frame_wc_thumbnail_value('image_size_single');
} );*/
/* Gallery Thumbnail Size */
/*add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return ef5frame_wc_thumbnail_value('wc_gallery_thumbnail');
} );*/

/**
 * Unset image width theme support.
 */
function ef5frame_modify_wc_theme_support() {
    global $image_size_single_width, $thumbnail_image_width, $custom_width, $custom_height;
    $theme_support = get_theme_support( 'woocommerce' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();
 
    unset( $theme_support['single_image_width'], $theme_support['thumbnail_image_width'] );
 
    remove_theme_support( 'woocommerce' );

    add_theme_support( 'woocommerce', $theme_support );

    update_option( 'woocommerce_single_image_width', ef5frame_wc_thumbnail_value('image_size_single_width') );
    update_option( 'woocommerce_thumbnail_image_width', ef5frame_wc_thumbnail_value('thumbnail_image_width') );

    update_option( 'woocommerce_thumbnail_cropping', 'custom' );
    update_option( 'woocommerce_thumbnail_cropping_custom_width', ef5frame_wc_thumbnail_value('custom_width') );
    update_option( 'woocommerce_thumbnail_cropping_custom_height', ef5frame_wc_thumbnail_value('custom_height') );
}
//add_action( 'after_setup_theme', 'ef5frame_modify_wc_theme_support', 10 );