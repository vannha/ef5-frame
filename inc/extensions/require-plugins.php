<?php
add_action( 'tgmpa_register', 'overcome_required_redux_plugins' );
function overcome_required_redux_plugins() {
    $config = array(
        'default_path' => overcome_relative_path().'untheme.net/plugins/',
        'is_automatic' => true
    );
    $plugins = array(
        array(
            'name'               => esc_html__('Redux Framework','overcome'),
            'slug'               => 'redux-framework',
            'required'           => true,
        ),
    );
    tgmpa( $plugins, $config );
}
if(class_exists('ReduxFrameworkPlugin')){
    add_action( 'tgmpa_register', 'overcome_required_theme_plugins' );
    function overcome_required_theme_plugins() {
        $config = array(
            'default_path' => overcome_relative_path().'untheme.net/plugins/',
        );
        $plugins = array(
            array(
                'name'               => esc_html__('EF5 Systems','overcome'),
                'slug'               => 'ef5-systems',
                'source'             => 'ef5-systems.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('EF5 Import & Export','overcome'),
                'slug'               => 'ef5-import-export',
                'source'             => 'ef5-import-export.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('WPBakery Page Builder','overcome'),
                'slug'               => 'js_composer',
                'source'             => 'js_composer.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('Slider Revolution','overcome'),
                'slug'               => 'revslider',
                'source'             => 'revslider.zip',
                'required'           => true,
            ),
            array(
                'name'               => esc_html__('WooCommerce','overcome'),
                'slug'               => 'woocommerce',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Compare for WooCommerce','overcome'),
                'slug'               => 'woo-smart-compare',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Wishlist for WooCommerce','overcome'),
                'slug'               => 'woo-smart-quick-view',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WPC Smart Quick View for WooCommerce','overcome'),
                'slug'               => 'woo-smart-wishlist',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Contact Form 7','overcome'),
                'slug'               => 'contact-form-7',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Newsletter','overcome'),
                'slug'               => 'newsletter',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Goolge Captcha','overcome'),
                'slug'               => 'google-captcha',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('WP User Avatars','overcome'),
                'slug'               => 'wp-user-avatars',
                'required'           => false,
            ),
            array(
                'name'               => esc_html__('Classic Editor','overcome'),
                'slug'               => 'classic-editor',
                'required'           => false,
            ),
        );
        tgmpa( $plugins, $config );
    }
}
if(class_exists('VC_Manager')){
    add_action( 'tgmpa_register', 'overcome_required_vc_plugins' );
    function overcome_required_vc_plugins(){
        $config = array(
            'default_path' => overcome_relative_path().'untheme.net/plugins/',
        );
        $plugins = array(
            array(
                'name'               => esc_html__('WPBakery Templatera','overcome'),
                'slug'               => 'templatera',
                'source'             => 'templatera.zip',
                'required'           => true,
            ),
        );
        tgmpa( $plugins, $config );
    }
}