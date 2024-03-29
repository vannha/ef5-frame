<?php
/**
 * EF5Frame functions and definitions
 *
 * @package EF5 Theme
 * @subpackage EF5Frame
 * @since 1.0.0
 * @author EF5 Team
 *
*/
if(!function_exists('ef5frame_configs')){
    function ef5frame_configs($value){
        $configs = [
            'primary_color'         => '#303030',
            'accent_color'          => '#f5b91b',
            'secondary_color'       => '#e6a423',
            'thirdary_color'        => '#5580ff',
            'fourth_color'          => '#3b2e4d',
            'darkent_accent_color'  => '#e6a423',
            'lightent_accent_color' => '#ffdd65',
            'invalid_color'         => 'red',
            'color_red'             => 'red',
            'color_green'           => 'green',
            'white'                 => 'white',
            // Typo
            'google_fonts'          => 'Poppins:300,400,500,600,700',
            'body_bg'               => '#fff',
            'body_font'             => '\'Poppins\', sans-serif',
            'body_font_size'        => '15px',
            'body_font_size_large'  => '18px',
            'body_font_size_medium' => '16px',
            'body_font_size_small'  => '14px',
            'body_font_size_xsmall' => '13px',
            'body_font_size_xxsmall'=> '12px',
            'body_font_color'       => '#303030',
            'body_line_height'      => '1.6',
            'content_width'         => 1170,
            'h1_size'               => '36px',
            'h2_size'               => '30px',
            'h3_size'               => '22px',
            'h4_size'               => '18px',
            'h5_size'               => '16px',
            'h6_size'               => '14px',
            'heading_font'          => '\'Poppins\', sans-serif',
            'heading_color'         => 'var(--primary-color)',
            'heading_color_hover'   => 'var(--accent-color)',
            'heading_font_weight'   => 600,
            'meta_font'             => '\'Poppins\', sans-serif',    
            'meta_color'            => '#777777',    
            'meta_color_hover'      => 'var(--accent-color)',
            'text-grey'            => '#b0b0b0',
            // Boder
            'main_border'           => '1px solid #DDDDDD', 
            'main_border2'          => '2px solid #DDDDDD', 
            'main_border_color'     => '#DDDDDD', 
            // Thumbnail Size
            'large_size_w'                   => 770,
            'large_size_h'                   => 353,
            'medium_size_w'                  => 370,
            'medium_size_h'                  => 250,
            'thumbnail_size_w'               => 86,
            'thumbnail_size_h'               => 80,
            'post_thumbnail_size_w'          => 1170,
            'post_thumbnail_size_h'          => 500,
            'ef5frame_default_post_thumbnail' => true,
            'ef5frame_thumbnail_is_bg'        => true,
            // Header 
            'logo_width'       => '192',
            'logo_height'      => '38',
            'logo_units'       => 'px',
            'main_menu_height' => '100px',
            'header_sidewidth' => '320px',
            // Menu Color
            'menu_link_color_regular' => 'var(--primary-color)',
            'menu_link_color_hover' => 'var(--accent-color)',
            'menu_link_color_active' => 'var(--accent-color)',
            // Menu Ontop Color
            'ontop_link_color_regular' => 'var(--primary-color)',
            'ontop_link_color_hover' => 'var(--accent-color)',
            'ontop_link_color_active' => 'var(--accent-color)',
            // Menu Sticky Color
            'sticky_link_color_regular' => 'var(--primary-color)',
            'sticky_link_color_hover' => 'var(--accent-color)',
            'sticky_link_color_active' => 'var(--accent-color)',
            // Dropdown
            'dropdown_bg'      => 'rgba(0,0,0, 1)',
            'dropdown_regular' => '#c0c0c0',
            'dropdown_hover'   => 'var(--accent-color)',
            'dropdown_active'  => 'var(--accent-color)',
            // Comments 
            'cmt_avatar_size'  => 100,
            'cmt_border'       => '1px solid #DDDDDD',
            // WooCommerce,
            'ef5frame_product_single_image_w' => '455',
            'ef5frame_product_single_image_h' => '605',

            'ef5frame_product_loop_image_w' => '205',
            'ef5frame_product_loop_image_h' => '162',

            'ef5frame_product_gallery_thumbnail_w' => '115',
            'ef5frame_product_gallery_thumbnail_h' => '140',

            'ef5frame_product_gallery_thumbnail_v_w' => '115',
            'ef5frame_product_gallery_thumbnail_v_h' => '140',

            'ef5frame_product_gallery_thumbnail_h_w' => '115',
            'ef5frame_product_gallery_thumbnail_h_h' => '140',

            'ef5frame_product_gallery_thumbnail_space' => '14',

            // API 
            'google_api_key' => apply_filters('ef5systems-google-api-key', false)

        ];
        return $configs[$value];
    }
}
function ef5frame_relative_path(){
    if(is_ssl())
        return 'https://';
    else 
        return 'http://';
}
if (!function_exists('ef5frame_setup')) {
    function ef5frame_setup()
    {
        // Make theme available for translation.
        load_theme_textdomain('ef5-frame', get_template_directory() . '/languages');

        // Custom Header
        add_theme_support("custom-header");

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title.
        add_theme_support('title-tag');
        
        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails'); 
        set_post_thumbnail_size(ef5frame_configs('post_thumbnail_size_w'), ef5frame_configs('post_thumbnail_size_h'), 1);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'ef5-primary'     => esc_html__('Primary Menu', 'ef5-frame'),
            'ef5-menu-icon'   => esc_html__('Menu with Icon', 'ef5-frame')
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('ef5frame_custom_background_args', array(
            'default-color' => '#ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for core custom logo.
        add_theme_support('custom-logo', array(
            'width'       => ef5frame_configs('logo_width'),
            'height'      => ef5frame_configs('logo_height'),
            'flex-width'  => true,
            'flex-height' => true,
        ));
        add_theme_support('post-formats', array(
            'gallery',
            'video',
            'audio',
            'quote',
            'link',
            'image'
        ));

        /* WooCommerce */
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');    
        /*
         * Add style for editor
        */
        ef5frame_require_folder( '/inc/editor',get_template_directory());
        /**
         * Load custom font icon
        */
        ef5frame_require_folder( '/assets/icon_fonts',get_template_directory());
    }
    add_action('after_setup_theme', 'ef5frame_setup');
}

function ef5frame_update(){
    /* Change default image thumbnail sizes in wordpress */
    $thumbnail_size = array(
        'large_size_w'        => ef5frame_configs('large_size_w'),
        'large_size_h'        => ef5frame_configs('large_size_h'),
        'large_crop'          => 1, 
        'medium_size_w'       => ef5frame_configs('medium_size_w'),
        'medium_size_h'       => ef5frame_configs('medium_size_h'),
        'medium_crop'         => 1, 
        'thumbnail_size_w'    => ef5frame_configs('thumbnail_size_w'),
        'thumbnail_size_h'    => ef5frame_configs('thumbnail_size_h'),
        'thumbnail_crop'      => 1,
    );
    foreach ($thumbnail_size as $option => $value) {
        if (get_option($option, '') != $value)
            update_option($option, $value);
    }
}
add_action('after_switch_theme', 'ef5frame_update');

/* add editor styles */
function ef5frame_editor_styles()
{
    add_editor_style('assets/admin/css/editor.css');
}
add_action('admin_init', 'ef5frame_editor_styles');

/* add admin styles */
function ef5frame_admin_style()
{
    wp_enqueue_style('ef5-frame', get_template_directory_uri() . '/assets/admin/css/admin.css');
}
add_action('admin_enqueue_scripts', 'ef5frame_admin_style');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
// Set up the content width value based on the theme's design and stylesheet.
if (!isset($content_width))
    $content_width = apply_filters('ef5frame_content_width', 1170);
function ef5frame_content_width()
{
    $GLOBALS['content_width'] = apply_filters('ef5frame_content_width', 1170);
}
add_action('after_setup_theme', 'ef5frame_content_width', 0);

/**
 * Incudes file
 *
*/
if(!function_exists('ef5frame_require_folder')){
    function ef5frame_require_folder($foldername,$path)
    {
        $dir = $path . DIRECTORY_SEPARATOR . $foldername;
        if (!is_dir($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), array('..', '.'));
        foreach ($files as $file) {
            $patch = $dir . DIRECTORY_SEPARATOR . $file;
            if (file_exists($patch) && strpos($file, ".php") !== false) {
                require_once $patch;
            }
        }
    }
}

/**
 * Register widget area.
 */
function ef5frame_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Blog Widgets', 'ef5-frame'),
        'id'            => 'sidebar-main',
        'description'   => esc_html__('Add widgets here to appear below Blog content.', 'ef5-frame'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="ef5-heading h3 widgettitle">',
        'after_title'   => '</div>',
    ));
    if(class_exists('EF5Systems')){
        register_sidebar(array(
            'name'          => esc_html__('Hidden Navigation Menu', 'ef5-frame'),
            'id'            => 'sidebar-nav',
            'description'   => esc_html__('Add widgets here to appear when click on Hidden Navigation Icon.', 'ef5-frame'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="ef5-heading h3 widgettitle">',
            'after_title'   => '</div>',
        ));
    }
    if(class_exists('WooCommerce')){
        register_sidebar(array(
            'name'          => esc_html__('Shop Widgets', 'ef5-frame'),
            'id'            => 'sidebar-shop',
            'description'   => esc_html__('Add widgets here to appear in widget area of single product', 'ef5-frame'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="ef5-heading h3 widgettitle">',
            'after_title'   => '</div>',
        ));
    }
}
add_action('widgets_init', 'ef5frame_widgets_init');
/**
 * Script Debug
 * Add suffix '.min' to scripts file
 *
*/
if(!function_exists('ef5frame_script_debug')){
    function ef5frame_script_debug() {
        $suffix   = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
        $dev_mode = ef5frame_get_opts('dev_mode', true);
        if(!$dev_mode) $suffix = '.min';
        return apply_filters( 'ef5frame_get_dev_mode', $suffix );
    }
}
/**
 * Enqueue scripts and styles.
 */
add_action('wp_footer', 'ef5frame_scripts', 0);
function ef5frame_scripts()
{
    $min = ef5frame_script_debug();
    // Comment
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    // Custom Options
    $filter_reset = function_exists('ef5systems_uri') ? ef5systems_uri() : '';
    $ef5frame_ajax_opts = array(
        'ajaxurl'             => admin_url( 'admin-ajax.php' ),
        'primary_color'       => ef5frame_configs('primary_color'),
        'accent_color'        => ef5frame_configs('accent_color'),
        'darkent_accent_color'        => ef5frame_configs('darkent_accent_color'),
        'lightent_accent_color'        => ef5frame_configs('lightent_accent_color'),
        'shop_url'            => function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id( 'shop' )) : '',
        'filter_reset'        => ( strpos($filter_reset,'filter_') !== false || strpos($filter_reset,'min_price') !== false || strpos($filter_reset,'max_price') || strpos($filter_reset, 'rating_filter')) ? 'true' : 'false',
        'filter_clear_text'   => esc_html__('Clear All', 'ef5-frame'),
        'is_rtl'              => is_rtl() ? 'true' : 'false'
    );
    // Scripts
    wp_enqueue_script('ef5-frame', get_template_directory_uri() . '/assets/js/theme'.$min.'.js', array('jquery'), '', true);
    wp_localize_script( 'ef5-frame', 'ef5frame_ajax_opts', $ef5frame_ajax_opts);
}

add_action('wp_enqueue_scripts', 'ef5frame_styles', 0);
function ef5frame_styles()
{
    $min = ef5frame_script_debug();
    
    // Theme Style
    wp_enqueue_style('ef5-frame', get_template_directory_uri() . '/assets/css/theme'.$min.'.css', array(), wp_get_theme()->get( 'Version' ) );
    // add CSS Variations
    $ef5frame_inline_styles = ef5frame_inline_styles();
    wp_add_inline_style( 'ef5-frame', $ef5frame_inline_styles );
    
}

add_action('wp_footer', 'ef5frame_ef5systems_styles');
function ef5frame_ef5systems_styles(){
    if(wp_script_is('font-awesome5')){
        // Call libs css
        wp_enqueue_style('font-awesome5');
        wp_enqueue_style('font-awesome5-shim');
        wp_enqueue_style('hint');
    } else {
        wp_enqueue_style('font-awesome5', get_template_directory_uri() . '/assets/icon_fonts/awesome5/css/all.css', array(), wp_get_theme()->get( 'Version' ));
        wp_enqueue_style('font-awesome5-shim', get_template_directory_uri() . '/assets/icon_fonts/awesome5/css/v4-shims.min.css', array('font-awesome5'), wp_get_theme()->get( 'Version' ));
        wp_enqueue_style('font-overcome', get_template_directory_uri() . '/assets/icon_fonts/overcome/overcome.css', array(), wp_get_theme()->get( 'Version' ));
    }
}

function ef5frame_inline_styles() {
    ob_start();
    $preset_primary_color = $primary_color = ef5frame_get_opts( 'primary_color', apply_filters('ef5frame_primary_color', ef5frame_configs('primary_color')) );
    $preset_accent_color = $accent_color = ef5frame_get_opts( 'accent_color', apply_filters('ef5frame_accent_color', ef5frame_configs('accent_color')) );
    $darkent_accent_color  = ef5frame_get_opts( 'darkent_accent_color', apply_filters('ef5frame_darkent_accent_color', ef5frame_configs('darkent_accent_color')) );
    $lightent_accent_color  = ef5frame_get_opts( 'lightent_accent_color', apply_filters('ef5frame_lightent_accent_color', ef5frame_configs('lightent_accent_color')) );
    $preset_secondary_color = ef5frame_get_opts( 'secondary_color', apply_filters('ef5frame_secondary_color',ef5frame_configs('secondary_color') ));

    $thirdary_color = ef5frame_get_opts( 'thirdary_color', apply_filters('ef5frame_thirdary_color',ef5frame_configs('thirdary_color') ));
    $fourth_color = ef5frame_get_opts( 'fourth_color', apply_filters('ef5frame_fourth_color',ef5frame_configs('fourth_color') ));
    $main_menu_height = ef5frame_get_opts( 'main_menu_height', ['height' => ef5frame_configs('main_menu_height')]);
    // CSS Variable
    printf(':root{
        --primary-color:%s;
        --accent-color:%s;
        --accent-color-05:%s;
        --accent-color-03:%s;
        --darkent-accent-color:%s;
        --lightent-accent-color:%s;
        --secondary-color:%s;
        --thirdary-color: %s;
        --thirdary-color-05: %s;
        --thirdary-color-03: %s;
        --fourth-color: %s;
        --fourth-color-07: %s;
        }', 
        $preset_primary_color,
        $preset_accent_color,
        ef5frame_hex2rgba($preset_accent_color, 0.5),
        ef5frame_hex2rgba($preset_accent_color, 0.3),
        $darkent_accent_color,
        $lightent_accent_color,
        $preset_secondary_color,
        $thirdary_color,
        ef5frame_hex2rgba($thirdary_color, 0.5),
        ef5frame_hex2rgba($thirdary_color, 0.3),
        $fourth_color,
        ef5frame_hex2rgba($fourth_color, 0.7)
    );
    // Header Variable
    $header_bg = ef5frame_get_opts('header_bg',[
        'background-color'      => '#fff',
        'background-image'      => 'inherit',
        'background-size'       => 'inherit',
        'background-repeat'     => 'inherit',
        'background-attachment' => 'inherit', 
        'background-position'   => 'inherit' 
    ]);
    $header_text_color = ef5frame_get_opts('header_text_color',['color' => '', 'alpha' => '', 'rgba' => 'inherit']);
    $header_ontop_top_space = ef5frame_get_opts('header_ontop_top_space',['height' => '']);
    printf(
        ':root{
            --main-menu-height:%s;
            --header-text-color: %s;
            --header-bg-color: %s;
            --header-bg-image: %s;
            --header-bg-size: %s;
            --header-bg-repeat: %s;
            --header-bg-attachment: %s;
            --header-bg-position: %s;
            --header_ontop_top_space: %s;
        }',
        $main_menu_height['height'],
        $header_text_color['rgba'],
        $header_bg['background-color'],
        $header_bg['background-image'],
        $header_bg['background-size'],
        $header_bg['background-repeat'],
        $header_bg['background-attachment'],
        $header_bg['background-position'],
        $header_ontop_top_space['height']
    );
    /* Default Header Color */
    $header_link_color = ef5frame_get_opts('header_link_colors',apply_filters('ef5frame_header_link_color', ['regular' => $primary_color, 'hover' => $accent_color, 'active' => $accent_color]) );
    printf(':root{
            --header_regular: %1$s;
            --header_hover: %2$s;
            --header_active: %3$s;
        }', 
        $header_link_color['regular'],
        $header_link_color['hover'],
        $header_link_color['active']
    );
    /* Ontop Header Color */
    $ontop_link_color = ef5frame_get_opts('ontop_link_colors', apply_filters('ef5frame_ontop_link_color', ['regular' => $primary_color, 'hover' => $accent_color, 'active' => $accent_color]) );
    printf(':root{
            --ontop_regular: %1$s;
            --ontop_hover: %2$s;
            --ontop_active: %3$s;
        }', 
        $ontop_link_color['regular'],
        $ontop_link_color['hover'],
        $ontop_link_color['active']
    );
    /* Sticky Header Color */
    $sticky_link_color = ef5frame_get_opts('sticky_link_colors',apply_filters('ef5frame_sticky_link_color',['regular' => '#FFFFFF', 'hover' => $accent_color, 'active' => $accent_color]));    
    printf(':root{
            --sticky_regular: %1$s;
            --sticky_hover: %2$s;
            --sticky_active: %3$s;
        }', 
        $sticky_link_color['regular'],
        $sticky_link_color['hover'],
        $sticky_link_color['active']
    );
    /* Dropdown && Mobile */
    $dropdown_bg_opt = ef5frame_get_opts('dropdown_bg',['rgba' => apply_filters('ef5frame_dropdown_bg', ef5frame_configs('dropdown_bg'))]);

    $dropdown_link_colors = ef5frame_get_opts('dropdown_link_colors', apply_filters('ef5frame_dropdown_link_colors',['regular' => ef5frame_configs('dropdown_regular'), 'hover' => ef5frame_configs('dropdown_hover'), 'active' => ef5frame_configs('dropdown_active')]) );
    printf(':root{
            --dropdown_regular: %1$s;
            --dropdown_hover: %2$s;
            --dropdown_active: %3$s;
            --dropdown_bg: %4$s;
        }', 
        $dropdown_link_colors['regular'],
        $dropdown_link_colors['hover'],
        $dropdown_link_colors['active'],
        $dropdown_bg_opt['rgba']
    );
    return ob_get_clean();
}

/**
 * Remove all Font Awesome from 3rd extension 
 * to use only font-awesome latest from our theme
 * //'font-awesome',
 * //'gglcptch',
*/
add_filter('ef5_remove_styles', 'ef5frame_remove_styles');
function ef5frame_remove_styles($styles){
    $_styles = [
        'newsletter'
    ];
    $styles = array_merge($styles, $_styles);
    return $styles;
}


/**
 * Register Google Fonts
 *
 * https://gist.github.com/kailoon/e2dc2a04a8bd5034682c
 * https://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 *
*/
function ef5frame_fonts_url() {
    $font_url = add_query_arg( 
        'family', 
        urlencode(ef5frame_configs('google_fonts')), 
        "//fonts.googleapis.com/css"
    );
    return $font_url;
}
function ef5frame_font_scripts() {
    wp_enqueue_style( 'ef5-fonts', ef5frame_fonts_url() );
}
add_action( 'wp_enqueue_scripts', 'ef5frame_font_scripts' );

function ef5frame_default_value($param, $default){
    return !empty($param) ? $param : $default;
}
/**
 * All Theme Function
*/
ef5frame_require_folder('inc', get_template_directory());
ef5frame_require_folder('inc/extends', get_template_directory());
ef5frame_require_folder('inc/classes', get_template_directory());
ef5frame_require_folder('inc/walker', get_template_directory());
ef5frame_require_folder('inc/core', get_template_directory());
ef5frame_require_folder('inc/functions', get_template_directory());
ef5frame_require_folder('inc/theme-options', get_template_directory());
ef5frame_require_folder('inc/custom-post', get_template_directory());
ef5frame_require_folder('inc/icons', get_template_directory());

if(class_exists('EF5Systems_MegaMenu_Walker')){
    ef5frame_require_folder('inc/mega-menu', get_template_directory());
}

if(function_exists('register_ef5_widget')){
    ef5frame_require_folder('inc/widgets', get_template_directory());
}

if(class_exists('VC_Manager') && class_exists('EF5Systems')){
    ef5frame_require_folder('vc_extends', get_template_directory());
    add_action('vc_after_init', 'ef5frame_vc_after_init');
    function ef5frame_vc_after_init(){ 
        ef5frame_require_folder('vc_elements', get_template_directory());
    }
}

if(class_exists('WooCommerce')){
    ef5frame_require_folder('inc/woo', get_template_directory());
}
/**
 * Custom Extensions
 * Custom some extension used in theme
 *
*/
ef5frame_require_folder('inc/extensions', get_template_directory());