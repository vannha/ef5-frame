<?php
add_action( 'tgmpa_register', 'ef5frame_required_redux_plugins' );
function ef5frame_required_redux_plugins() {
    $config = array(
        'default_path' => ef5frame_relative_path().'untheme.net/plugins/',
        'is_automatic' => true
    );
    $plugins = array(
        array(
            'name'               => esc_html__('Redux Framework','ef5-frame'),
            'slug'               => 'redux-framework',
            'required'           => true,
        ),
    );
    tgmpa( $plugins, $config );
}
if(class_exists('ReduxFrameworkPlugin')){
    add_action( 'tgmpa_register', 'ef5frame_required_theme_plugins' );
    function ef5frame_required_theme_plugins() {
        $config = array(
            'default_path' => ef5frame_relative_path().'untheme.net/plugins/',
        );
        $plugins = array(
            array(
                'name'               => esc_html__('EF5 Systems','ef5-frame'),
                'slug'               => 'ef5-systems',
                'source'             => 'ef5-systems.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('EF5 Import & Export','ef5-frame'),
                'slug'               => 'ef5-import-export',
                'source'             => 'ef5-import-export.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('WPBakery Page Builder','ef5-frame'),
                'slug'               => 'js_composer',
                'source'             => 'js_composer.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Slider Revolution','ef5-frame'),
                'slug'               => 'revslider',
                'source'             => 'revslider.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('WooCommerce','ef5-frame'),
                'slug'               => 'woocommerce',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Compare for WooCommerce','ef5-frame'),
                'slug'               => 'woo-smart-compare',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Wishlist for WooCommerce','ef5-frame'),
                'slug'               => 'woo-smart-quick-view',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Quick View for WooCommerce','ef5-frame'),
                'slug'               => 'woo-smart-wishlist',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Contact Form 7','ef5-frame'),
                'slug'               => 'contact-form-7',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Newsletter','ef5-frame'),
                'slug'               => 'newsletter',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Goolge Captcha','ef5-frame'),
                'slug'               => 'google-captcha',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WP User Avatars','ef5-frame'),
                'slug'               => 'wp-user-avatars',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Classic Editor','ef5-frame'),
                'slug'               => 'classic-editor',
                'required'           => false,
            ),
        );
        tgmpa( $plugins, $config );
    }
}
if(class_exists('VC_Manager')){
    add_action( 'tgmpa_register', 'ef5frame_required_vc_plugins' );
    function ef5frame_required_vc_plugins(){
        $config = array(
            'default_path' => ef5frame_relative_path().'untheme.net/plugins/',
        );
        $plugins = array(
            array(
                'name'               => esc_html__('WPBakery Templatera','ef5-frame'),
                'slug'               => 'templatera',
                'source'             => 'templatera.zip',
                'required'           => true,
            ),
        );
        tgmpa( $plugins, $config );
    }
}