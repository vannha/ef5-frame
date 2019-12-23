<?php
/**
 * Enable Export Sample Data 
*/
if(!function_exists('overcome_enable_export_mode')){
	add_filter('ef5_ie_export_mode', 'overcome_enable_export_mode');
	function overcome_enable_export_mode() {
	    return false;
	}
}
/**
 * Define theme option name
 * Required!!!
*/
add_filter('ef5_ie_options_name', 'overcome_options_name');
function overcome_options_name()
{
    //Example name of theme option is "cms_theme_options"
    return 'ef5_theme_options';
}
/**
 * Remove default post / page / extra page from required plugin
 * like :  Hello Word, Sample Page, Privacy Policy, Newsletter, Wishlist, ...
*/
add_action('ef5-ie-import-start', 'overcome_move_trash', 1);
if(!function_exists('overcome_move_trash')){
    function overcome_move_trash(){
        wp_trash_post(1);
        wp_trash_post(2);
        wp_trash_post(3);
        wp_trash_post(overcome_get_id_by_title('Privacy Policy'));
        wp_trash_post(overcome_get_id_by_title('Shop'));
        wp_trash_post(overcome_get_id_by_title('Cart'));
        wp_trash_post(overcome_get_id_by_title('Checkout'));
        wp_trash_post(overcome_get_id_by_title('My account'));
        wp_trash_post(overcome_get_id_by_title('Terms and Conditions'));
        wp_trash_post(overcome_get_id_by_title('Wishlist'));
        wp_trash_post(overcome_get_id_by_title('Newsletter'));
    }
}
/**
 * Remove default widgets after install WordPress
 * like : Search, Recent Posts, Recent Comments, Archives, Categories, Meta
*/
add_action('ef5-ie-import-start','overcome_removed_default_wp_widgets', 10, 2);
function overcome_removed_default_wp_widgets(){
    global $wp_registered_sidebars;
    $widgets = get_option('sidebars_widgets');
    foreach ($wp_registered_sidebars as $sidebar => $value) {
        unset($widgets[$sidebar]);
    }
    update_option('sidebars_widgets',$widgets);
}
/**
 * Set Default page.
 *
 * get array page title and update options.
 *
 */
function overcome_set_default_page(){
    $pages = array(
        'page_on_front'                 => 'Home',
        'page_for_posts'                => 'Blog',
        'page_for_privacy_policy'       => 'Privacy Policy',
        
        'woocommerce_shop_page_id'      => 'Shop',
        'woocommerce_cart_page_id'      => 'Cart',
        'woocommerce_checkout_page_id'  => 'Checkout',
        'woocommerce_myaccount_page_id' => 'My Account',
        'woocommerce_terms_page_id'     => 'Terms and Conditions',
    );
    foreach ($pages as $key => $page){
        $page = get_page_by_title($page);
        if(!isset($page->ID))
            return ;
        update_option($key, $page->ID);
    }
}
add_action('ef5-ie-import-finish', 'overcome_set_default_page');

/**
 * Extra option 
 * Update option for Extensions option like: WooCommerce, Newsletter, ...
 *
*/
add_filter('ef5_ie_extra_options', 'overcome_extra_options_name');
function overcome_extra_options_name($extra_options)
{
    $theme_extra_options = [
        'blogname',
        'blogdescription',
        'date_format',
        'time_format',
        'default_category',
        'posts_per_page',
        'show_on_front',
        'page_on_front',
        'page_for_posts',
        'page_for_privacy_policy',
        'wp_user_roles', 
        'woosw_page_id',
        'newsletter_main',
    ];
    $extra_options = array_merge($extra_options, $theme_extra_options);
    return $extra_options;
}