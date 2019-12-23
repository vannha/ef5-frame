<?php
if (!class_exists('ReduxFramework')) {
    return;
}
if (class_exists('ReduxFrameworkPlugin')) {
    //remove_ef5_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
    remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
}
$opt_name = overcome_get_theme_opt_name();
$theme = wp_get_theme();
$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type'            => class_exists('EF5Systems') ? 'submenu' : '',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Theme Options', 'overcome'),
    'page_title'           => esc_html__('Theme Options', 'overcome'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-admin-generic',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
//    'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => class_exists('EF5Systems') ? $theme->get('TextDomain') : '',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'theme-options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    ),
);

Redux::SetArgs($opt_name, $args);

/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('General', 'overcome'),
    'icon'   => 'el-icon-home',
    'fields' => array_merge(
        overcome_general_opts()
    )
));

/*--------------------------------------------------------------
# Header Top
--------------------------------------------------------------*/
Redux::setSection($opt_name, overcome_header_top_opts());
/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Header', 'overcome'),
    'icon'   => 'el-icon-website',
    'fields' => array_merge(
        overcome_header_opts(),
        overcome_header_atts()
    )
));

Redux::setSection($opt_name, overcome_header_main_logo());
/* Ontop Header */
Redux::setSection($opt_name, overcome_ontop_header_opts());
/* Sticky Header */
Redux::setSection($opt_name, overcome_sticky_header_opts());

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Dropdown & Mobile Menu', 'overcome'),
    'icon'       => 'el-icon-lines',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'dropdown_bg',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Dropdown Background', 'overcome'),
            'subtitle' => esc_html__('Choose dropdown background color', 'overcome'),
            'output'   => array(
                'background-color' => '.oc-header-menu .sub-menu',
            )
        ),
        array(
            'id'          => 'dropdown_text_color',
            'type'        => 'color_rgba',
            'title'       => esc_html__('Text Color', 'overcome'),
            'default'     => '',
            'output'      => array('.oc-header-menu ul'),
        ),
        array(
            'id'    => 'dropdown_link_colors',
            'type'  => 'link_color',
            'title' => esc_html__('Link colors', 'overcome'),
            'output' => array(
                'color' => '.oc-header-menu ul a'
            ),
        ),
    )
));
/*--------------------------------------------------------------
# Page Title area
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Page Title', 'overcome'),
    'icon'   => 'el-icon-map-marker',
    'fields' => overcome_page_title_opts()
));

/*--------------------------------------------------------------
# WordPress default content
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title' => esc_html__('Content', 'overcome'),
    'icon'  => 'el-icon-pencil'
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Archive', 'overcome'),
    'icon'       => 'el-icon-list',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'archive_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Widget Position', 'overcome'),
            'subtitle' => esc_html__('Select a sidebar position for blog home, archive, search...', 'overcome'),
            'options'  => overcome_sidebar_position_opts(),
            'default'  => overcome_archive_sidebar_position()
        ),
        array(
            'id'       => 'archive_nav_type',
            'type'     => 'button_set',
            'title'    => esc_html__('Posts Navigation Type', 'overcome'),
            'subtitle' => esc_html__('Set posts navigation type on all archive pages', 'overcome'),
            'options'  => array(
                '1' => esc_html__('Older / Newer', 'overcome'),
                //'2' => esc_html__('Paged', 'overcome'),
                '3' => esc_html__('Paged', 'overcome'),
                '4' => esc_html__('Next / Preview', 'overcome'),
                //'5' => esc_html__('Next / Preview', 'overcome')
            ),
            'default'  => apply_filters('overcome_loop_pagination', '3')
        ),
        array(
            'id'       => 'archive_author_on',
            'title'    => esc_html__('Author', 'overcome'),
            'subtitle' => esc_html__('Show author name on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        ),
        array(
            'id'       => 'archive_date_on',
            'title'    => esc_html__('Date', 'overcome'),
            'subtitle' => esc_html__('Show date posted on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        ),
        array(
            'id'       => 'archive_categories_on',
            'title'    => esc_html__('Categories', 'overcome'),
            'subtitle' => esc_html__('Show category names on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        ),
        array(
            'id'       => 'archive_tags_on',
            'title'    => esc_html__('Tags', 'overcome'),
            'subtitle' => esc_html__('Show tag names on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        ),
        array(
            'id'       => 'archive_comments_on',
            'title'    => esc_html__('Comments', 'overcome'),
            'subtitle' => esc_html__('Show comments count on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        ),
        array(
            'id'       => 'archive_share_on',
            'title'    => esc_html__('Share', 'overcome'),
            'subtitle' => esc_html__('Show share post to some socials network on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '0',
        ),
        array(
            'id'       => 'archive_readmore',
            'title'    => esc_html__('Read more', 'overcome'),
            'subtitle' => esc_html__('Show readmore button on archive page.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1',
        )
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Page', 'overcome'),
    'icon'       => 'el-icon-file-edit',
    'subsection' => true,
    'fields'     => array_merge(
        overcome_page_opts()
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Post', 'overcome'),
    'icon'       => 'el-icon-file-edit',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'post_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Layouts', 'overcome'),
            'subtitle' => esc_html__('select a layout for single...', 'overcome'),
            'options'  => overcome_sidebar_position_opts(),
            'default'  => overcome_post_sidebar_position()
        ),
        array(
            'id'       => 'post_date_on',
            'title'    => esc_html__('Date', 'overcome'),
            'subtitle' => esc_html__('Show date posted.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1'
        ),
        array(
            'id'       => 'post_author_on',
            'title'    => esc_html__('Author', 'overcome'),
            'subtitle' => esc_html__('Show author name.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1'
        ),
        array(
            'id'       => 'post_categories_on',
            'title'    => esc_html__('Categories', 'overcome'),
            'subtitle' => esc_html__('Show category names.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1'
        ),
        array(
            'id'       => 'post_tags_on',
            'title'    => esc_html__('Tags', 'overcome'),
            'subtitle' => esc_html__('Show tag names.', 'overcome'),
            'type'     => 'switch',
            'default'  => '1'
        ),
        array(
            'id'       => 'post_comments_on',
            'title'    => esc_html__('Comments Count', 'overcome'),
            'subtitle' => esc_html__('Show comments count.', 'overcome'),
            'type'     => 'switch',
            'default'  => '0'
        ),
        array(
            'id'       => 'post_share_on',
            'title'    => esc_html__('Share', 'overcome'),
            'subtitle' => esc_html__('Show share post to some socials network on each post.', 'overcome'),
            'type'     => 'switch',
            'default'  => '0',
        ),
        array(
            'id'       => 'post_author_info',
            'title'    => esc_html__('About Author', 'overcome'),
            'subtitle' => esc_html__('Show author bio.', 'overcome'),
            'type'     => 'switch',
            'default'  => '0'
        ),
        array(
            'id'       => 'post_related_on',
            'title'    => esc_html__('Related Post', 'overcome'),
            'subtitle' => esc_html__('Show related post by post tag.', 'overcome'),
            'type'     => 'switch',
            'default'  => '0'
        )
    )
));

/*--------------------------------------------------------------
# Portfolio
--------------------------------------------------------------*/
do_action('overcome_portfolio_theme_opts','overcome_portfolio_theme_opts');
/*Redux::setSection($opt_name, array(
    'title'  => esc_html__('Portfolio', 'overcome'),
    'icon'   => 'el el-th',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'portfolio_slug',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio slug rewrite', 'overcome'),
            'default' => esc_html__('portfolio', 'overcome')
        ),
        array(
            'id'      => 'portfolio_page',
            'type'    => 'select',
            'title'   => esc_html__('Portfolio Page', 'overcome'),
            'options' => overcome_list_page(['value' => '-1', 'label' => esc_html__('Archive page','overcome')]),
            'default' => esc_html__('-1', 'overcome')
        ),
    )
));*/
/*--------------------------------------------------------------
# Service
--------------------------------------------------------------*/
//Redux::setSection($opt_name, overcome_service_theme_opts());

/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Colors', 'overcome'),
    'icon'   => 'el-icon-file-edit',
    'fields' => array(
        array(
            'id'          => 'primary_color',
            'type'        => 'color',
            'title'       => esc_html__('Primary Color', 'overcome'),
            'transparent' => false,
        ),
        array(
            'id'          => 'accent_color',
            'type'        => 'color',
            'title'       => esc_html__('Accent Color', 'overcome'),
            'transparent' => false,
        ),
        array(
            'id'          => 'darkent_accent_color',
            'type'        => 'color',
            'title'       => esc_html__('Darkent Accent Color', 'overcome'),
            'transparent' => false,
        ),
        array(
            'id'          => 'lightent_accent_color',
            'type'        => 'color',
            'title'       => esc_html__('Lightent Accent Color', 'overcome'),
            'transparent' => false,
        ),
        array(
            'id'          => 'secondary_color',
            'type'        => 'color',
            'title'       => esc_html__('Secondary Color', 'overcome'),
            'transparent' => false,
        ),
    )
));

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Typography', 'overcome'),
    'icon'   => 'el-icon-text-width',
    'fields' => array(
        array(
            'id'          => 'font_main',
            'type'        => 'typography',
            'title'       => esc_html__('Main Font', 'overcome'),
            'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('body'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h1',
            'type'        => 'typography',
            'title'       => esc_html__('H1', 'overcome'),
            'subtitle'    => esc_html__('Heading 1 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h1', '.h1'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h2',
            'type'        => 'typography',
            'title'       => esc_html__('H2', 'overcome'),
            'subtitle'    => esc_html__('Heading 2 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h2', '.h2'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h3',
            'type'        => 'typography',
            'title'       => esc_html__('H3', 'overcome'),
            'subtitle'    => esc_html__('Heading 3 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h3', '.h3'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h4',
            'type'        => 'typography',
            'title'       => esc_html__('H4', 'overcome'),
            'subtitle'    => esc_html__('Heading 4 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h4', '.h4'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h5',
            'type'        => 'typography',
            'title'       => esc_html__('H5', 'overcome'),
            'subtitle'    => esc_html__('Heading 5 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h5', '.h5'),
            'units'       => 'px'
        ),
        array(
            'id'          => 'font_h6',
            'type'        => 'typography',
            'title'       => esc_html__('H6', 'overcome'),
            'subtitle'    => esc_html__('Heading 6 typography.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => array('h6', '.h6'),
            'units'       => 'px'
        )
    )
));

$custom_font_selectors_1 = Redux::getOption($opt_name, 'custom_font_selectors_1');
$custom_font_selectors_1 = !empty($custom_font_selectors_1) ? explode(',', $custom_font_selectors_1) : array();

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Extra Fonts', 'overcome'),
    'icon'       => 'el el-fontsize',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'custom_font_1',
            'type'        => 'typography',
            'title'       => esc_html__('Custom Font', 'overcome'),
            'subtitle'    => esc_html__('Typography option with each property can be called individually.', 'overcome'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'output'      => $custom_font_selectors_1,
            'units'       => 'px',

        ),
        array(
            'id'       => 'custom_font_selectors_1',
            'type'     => 'textarea',
            'title'    => esc_html__('CSS Selectors', 'overcome'),
            'subtitle' => esc_html__('Add css selectors to apply above font.', 'overcome'),
            'validate' => 'no_html'
        )
    )
));

/* Social Media */
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Social Media', 'overcome'),
    'desc'       => esc_html__('Add your socials network', 'overcome'),
    'icon'       => 'el el-twitter',
    'subsection' => false,
    'fields'     => array(
        array(
            'id'      => 'social_facebook_url',
            'type'    => 'text',
            'title'   => esc_html__('Facebook URL', 'overcome'), 
            'default' => '',
        ),
        array(
            'id'      => 'social_twitter_url',
            'type'    => 'text',
            'title'   => esc_html__('Twitter URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_pinterest_url',
            'type'    => 'text',
            'title'   => esc_html__('Pinterest URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_dribbble_url',
            'type'    => 'text',
            'title'   => esc_html__('Dribbble URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_inkedin_url',
            'type'    => 'text',
            'title'   => esc_html__('Inkedin URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_rss_url',
            'type'    => 'text',
            'title'   => esc_html__('Rss URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_instagram_url',
            'type'    => 'text',
            'title'   => esc_html__('Instagram URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_google_url',
            'type'    => 'text',
            'title'   => esc_html__('Google URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_skype_url',
            'type'    => 'text',
            'title'   => esc_html__('Skype URL', 'overcome'),
            'default' => '',
        ),
        
        array(
            'id'      => 'social_vimeo_url',
            'type'    => 'text',
            'title'   => esc_html__('Vimeo URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_youtube_url',
            'type'    => 'text',
            'title'   => esc_html__('Youtube URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_yelp_url',
            'type'    => 'text',
            'title'   => esc_html__('Yelp URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tumblr_url',
            'type'    => 'text',
            'title'   => esc_html__('Tumblr URL', 'overcome'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tripadvisor_url',
            'type'    => 'text',
            'title'   => esc_html__('Tripadvisor URL', 'overcome'),
            'default' => '',
        ),
    )
));

/**
 * Social API
 *
 * @author CMSSuperHeroes
 * @since 1.0.0
 */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('API', 'overcome'),
    'icon'   => 'dashicons dashicons-share',
    'fields' => array()
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Google Maps', 'overcome'),
    'icon'       => 'dashicons dashicons-googleplus',
    'desc'      => sprintf(__('Click here to <a href="%s" target="_blank">Get your google API key</a>','overcome'), 'https://developers.google.com/maps/documentation/javascript/get-api-key'),
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('API Key', 'overcome'),
            'id'        => 'google_api_key',
            'type'      => 'text',
            'default'   => '',
        )
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Twitter', 'overcome'),
    'icon'       => 'dashicons dashicons-twitter',
    'subsection' => true,
    'fields'     => array(
        
        array(
            'title'     => esc_html__('Consumer Key (API Key)', 'overcome'),
            'id'        => 'twitter_api_consumer_key',
            'type'      => 'text',
            'default'   => 'i90SevLFwZDscXPo3Wj89Y4eO',
        ),
        array(
            'title'     => esc_html__('Consumer Secret (API Secret)', 'overcome'),
            'id'        => 'twitter_api_consumer_secret',
            'type'      => 'text',
            'default'   => '61AmOoAxacZeQneXjCOzKZGRwXwcRFgMsIhhYnQ5JTAOvMdlmL',
        ),
        array(
            'title'     => esc_html__('Access Token', 'overcome'),
            'id'        => 'twitter_api_access_key',
            'type'      => 'text',
            'default'   => '107960275-v9RLlUdpW7xW0wbh0Xtg8X2mVFbaCDtFNAs8vwAc',
        ),
        array(
            'title'     => esc_html__('Access Token Secret', 'overcome'),
            'id'        => 'twitter_api_access_secret',
            'type'      => 'text',
            'default'   => 'VewAXAcJEyDpqlrDfDO40HbRq6rzkYPEHgXz3WNhxAbSv',
        ),
        array(
            'id'        => 'twitter_api_dasboard',
            'type'      => 'info',
            'style'     => 'warning',
            'desc'      => sprintf(__('These details are available in <a href="%s" target="_blank">Your Twitter dashboard</a>','overcome'), 'https://dev.twitter.com/apps')
        ),
    )
));
Redux::setSection($opt_name, array(
    'title'      => esc_html__('Instagram', 'overcome'),
    'icon'       => 'el el-instagram',
    'subsection' => true,
    'fields'     => array(
        array(
            'title'     => esc_html__('User ID', 'overcome'),
            'desc'      => esc_html__('Ex: https://www.instagram.com/zooka.studio/. Get zooka.studio','overcome'),
            'id'        => 'instagram_api_username',
            'type'      => 'text',
            'default'   => ''
        ),
        array(
            'title'     => esc_html__('API Key', 'overcome'),
            'subtitle'      => sprintf(__('Generate YOUR Instagram Access Token <a href="%s" target="_blank">Click Here</a>','overcome'), 'http://instagram.pixelunion.net/'),
            'desc'      => esc_html__('Copy and Paste YOUR Instagram Access Token here!','overcome'),
            'id'        => 'instagram_api_key',
            'type'      => 'text',
            'default'   => ''
        )
    )
));

/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/

Redux::setSection($opt_name, overcome_footer_opts());

/**
 # WooCommerce
*/
Redux::setSection($opt_name, overcome_woocommerce_theme_opts());

/*--------------------------------------------------------------
# Development
--------------------------------------------------------------*/
$gutenberg_opts = array();
if(!class_exists('Classic_Editor')){
    $gutenberg_opts = array(
        'id'       => 'gutenberg',
        'type'     => 'switch',
        'title'    => esc_html__('Gutenberg Editor', 'overcome'),
        'subtitle' => esc_html__('Choose Default to use default Editor from WordPress or other plugin like Visual Composer, WPBakery Page Builder, Classic Editor,...', 'overcome'),
        'description' => esc_html__('Disable option will remove Gutenberg Editor', 'overcome'),
        'on'       => esc_html__('Default', 'overcome'),
        'off'      => esc_html__('Disable', 'overcome'),
        'default'  => true
    );
}
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Development Tools', 'overcome'),
    'icon'   => 'el-icon-edit',
    'fields' => array(
        $gutenberg_opts,
        array(
            'id'          => 'dev_mode',
            'type'        => 'switch',
            'default'     => false,
            'title'       => esc_html__('Development Mode', 'overcome'),
            'subtitle'    => esc_html__('Not Recommended', 'overcome'),
            'description' => esc_html__('When it is ON, the css will be passed from sccc in all time.', 'overcome'),
        )
    ),
));