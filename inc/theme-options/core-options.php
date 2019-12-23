<?php
/**
 * Theme Options 
 * Site Boxed
 * Add option repeated Boxed theme/ meta option
*/
if(!function_exists('overcome_general_opts')){
    function overcome_general_opts($args = []){
        $args = wp_parse_args($args, [
            'default'   => false
        ]);
        $default_value              = $args['default'] ? '-1' : '0';
        $force_output               = $args['default'] ? true : false;
        $default_dropdown_opts      = $args['default'] ? array('-1' => esc_html__('Default','overcome')) : array();
        $default_page_loading_value = $args['default'] ? '-1' : 'fading-circle';

        if($args['default'] === true){
            $options_layout = array(
                '-1'       => esc_html__('Default','overcome'),
                'boxed'    => esc_html__('Boxed','overcome'),
                'bordered' => esc_html__('Bordered','overcome'),
            );
            $default_layout = '-1';

            $options_boxed = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
        } else {
            $options_layout = array(
                '-1'       => esc_html__('Default','overcome'),
                'boxed'    => esc_html__('Boxed','overcome'),
                'bordered' => esc_html__('Bordered','overcome'),
            );
            $default_layout = '-1';
            
            $options_boxed = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
        }
        return array(
            array(
                'id'       => 'body_bg',
                'type'     => 'background',
                'title'    => esc_html__('Body Background', 'overcome'),
                'subtitle' => esc_html__('Choose background style for body', 'overcome'),
                'output'   => array('body')
            ),       
            array(
                'id'       => 'site_layout',
                'type'     => 'button_set',
                'title'    => esc_html__('Layout', 'overcome'),
                'subtitle' => esc_html__('Choose site layout', 'overcome'),
                'options'  => $options_layout,
                'default'  => $default_layout,
            ),
            array(
                'id'       => 'boxed_content_bg',
                'type'     => 'background',
                'title'    => esc_html__('Boxed Content Background', 'overcome'),
                'subtitle' => esc_html__('Choose background style for boxed content', 'overcome'),
                'required' => array(
                    array('site_layout', '=', 'boxed')
                ),
                'output'   => array('.site-boxed .ef5-page'),
                'force_output' => $force_output
            ),
            array(
                'id'       => 'site_bordered_w',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'title'    => esc_html__('Bordered Width', 'overcome'),
                'subtitle' => esc_html__('Enter bordered with.', 'overcome'),
                'units'    => array('px'),
                'default'  => array(
                    'padding-top'    => '50px',
                    'padding-right'  => '50px',
                    'padding-bottom' => '50px',
                    'padding-left'   => '50px',
                    'units'          => 'px'
                ),
                'required' => array(
                    array('site_layout', '=', 'bordered')
                ),
                'force_output' => $force_output,
                //'output'       => array('.site-bordered')
            ),
            array(
                'id'       => 'bordered_content_bg',
                'type'     => 'background',
                'title'    => esc_html__('Bordered Content Background', 'overcome'),
                'subtitle' => esc_html__('Choose background style for bordered content', 'overcome'),
                'required' => array(
                    array('site_layout', '=', 'bordered')
                ),
                'output'   => array('.site-bordered .ef5-page'),
                'force_output' => $force_output
            ),
            array(
                'id'       => 'show_page_loading',
                'type'     => 'button_set',
                'title'    => esc_html__('Enable Page Loading', 'overcome'),
                'subtitle' => esc_html__('Enable Page Loading Effect When You Load Site', 'overcome'),
                'options'  => $options_boxed,
                'default'  => $default_value,
            ),
            array(
                'title'     => esc_html__('Page Loadding Style','overcome'),
                'subtitle'  => esc_html__('Select Style Page Loadding.','overcome'),
                'id'        => 'page_loading_style',
                'type'      => 'select',
                'options'   => overcome_page_loading_styles($args['default']),
                'default'   => $default_page_loading_value,
                'required'  => array('show_page_loading', '=', '1' )
            ),
            array(
                'id'       => 'back_totop_on',
                'type'     => 'button_set',
                'title'    => esc_html__('Back to Top Button', 'overcome'),
                'subtitle' => esc_html__('Show back to top button when scrolled down.', 'overcome'),
                'options'  => $options_boxed,
                'default'  => $default_value,
            )
        );
    }
}

/**
 * Theme Options 
 * Header Top Area 
 * Add option repeated for theme/ meta option
*/
if(!function_exists('overcome_header_top_opts')){
    function overcome_header_top_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = $args['default'] ? '-1' : '';
        return array(
            'title'  => esc_html__('Header Top', 'overcome'),
            'icon'   => 'el el-website',
            'fields' => array(
                array(
                    'id'          => 'header_top',
                    'type'        => 'image_select',
                    'title'       => esc_html__('Layout', 'overcome'),
                    'subtitle'    => esc_html__('Select a layout for upper header top area.', 'overcome'),
                    'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom header layout first.','overcome'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=ef5_header_top' ) ) . '">','</a>'),
                    'options'     => overcome_list_post_thumbnail('ef5_header_top', $args['default']),
                    'default'     => $default_value
                )
            )
        );
    }
}

/**
 * Theme Options 
 * Add option repeated for theme/ meta option
*/
if(!function_exists('overcome_header_layout')){
    function overcome_header_layout($default = false){
        $layouts = [];
        if($default){
            $layouts['-1'] = get_template_directory_uri() . '/assets/images/default.png';
            $layouts['none'] = get_template_directory_uri() . '/assets/images/none.png';
        }
        $layouts['1'] = get_template_directory_uri() . '/assets/images/header/header-1.png';
        $layouts['2'] = get_template_directory_uri() . '/assets/images/header/header-2.png';
        $layouts['5'] = get_template_directory_uri() . '/assets/images/header/header-5.png';
        $layouts['6'] = get_template_directory_uri() . '/assets/images/header/header-6.png';
        $layouts['7'] = get_template_directory_uri() . '/assets/images/header/header-7.png';
        $layouts['8'] = get_template_directory_uri() . '/assets/images/header/header-8.png';
        
        return $layouts;
    }
}

if(!function_exists('overcome_header_opts')){
    function overcome_header_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = '1';
        $default_menu = '0';
        if($args['default'] === true){
            $options_width = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            
            $default_value = $default_menu = $default_width_value = '-1';
        } else {
            $options_width = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_width_value = '0';
        }
        return array(
            array(
                'id'       => 'header_layout',
                'type'     => 'image_select',
                'title'    => esc_html__('Layout', 'overcome'),
                'subtitle' => esc_html__('Select a layout for header.', 'overcome'),
                'options'  => overcome_header_layout($args['default']),
                'default'  => $default_value
            ),
            array(
                'id'       => 'header_menu',
                'type'     => 'select',
                'options'  => overcome_get_nav_menu(['default' => $args['default'],'none' => true]),
                'default'  => $default_menu,
                'title'    => esc_html__('Header Menu', 'overcome'),
                'subtitle' => esc_html__('Choose a menu to show', 'overcome'),
            ),
            array(
                'id'       => 'header_design',
                'type'     => 'info',
                'style'    => 'success',
                'title'    => esc_html__('Header Design', 'overcome'),
                'subtitle' => esc_html__('Custom header style like: background, text color, link color, border style, ...', 'overcome'),
            ),
            array(
                'title'    => esc_html__('Header Width', 'overcome'),
                'subtitle' => esc_html__('Make header content full width or not', 'overcome'),
                'id'       => 'header_fullwidth',
                'type'     => 'button_set',
                'options'  => $options_width,
                'default'  => $default_width_value,
                'required' => array(
                    array('header_layout' ,'!=', '3')
                )
            ),
            array(
                'title'    => esc_html__('Menu Height', 'overcome'),
                'subtitle' => esc_html__('Enter the height for Menu', 'overcome'),
                'id'       => 'main_menu_height',
                'type'     => 'dimensions',
                'width'    => false,
                'units'    => array('px'),
                'default'  => array(),
                'required' => array(
                    array('header_layout' ,'!=', '3')
                ),
                'force_output' => true
            ),
            array(
                'title'    => esc_html__('Header Width', 'overcome'),
                'subtitle' => esc_html__('Enter the width for side navigation header', 'overcome'),
                'id'       => 'header_sidewidth',
                'type'     => 'dimensions',
                'height'   => false,
                'units'     => array('px'),
                'required' => array(
                    array('header_layout' ,'=', '3')
                ),
                'force_output' => true
            ),
            array(
                'id'     => 'header_bg',
                'type'   => 'background',
                'title'  => esc_html__('Background', 'overcome'),
                'output' => array('.header-default')
            ),
            array(
                'id'          => 'header_text_color',
                'type'        => 'color_rgba',
                'title'       => esc_html__('Text Color', 'overcome'),
                'default'     => '',
                'output'      => array('.header-default')
            ),
            array(
                'id'    => 'header_link_colors',
                'type'  => 'link_color',
                'title' => esc_html__('Link colors', 'overcome'),
            ),
            array(
                'id'       => 'header_border',
                'type'     => 'border',
                'all'      => false,
                'color'    => false,
                'title'    => esc_html__('Border Style', 'overcome'),
                'subtitle' => esc_html__('Add your custom border design', 'overcome'),
                'output'   => array('.header-default')
            ),
            array(
                'id'       => 'header_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__('Border Color', 'overcome'),
                'subtitle' => esc_html__('Add your custom border color', 'overcome'),
                'output'   => array(
                    'border-color' => '.header-default'
                )
            )
        ); 
    }
}

/**
 * Theme Option:
 * Header Attributes 
 *
*/
if(!function_exists('overcome_header_atts')){
    function overcome_header_atts($default = false){
        $header_side_nav_icon_type = array(
            'icon'            => esc_html__('Icon Only','overcome'),
            'separator-left'  => esc_html__('Icon with separator left','overcome'),
            'separator-right' => esc_html__('Icon with separator right','overcome'),
        );
        $header_popup_nav_icon_type = array(
            'text'            => esc_html__('Text','overcome'),
            'icon'            => esc_html__('Icon Only','overcome'),
            'separator-left'  => esc_html__('Icon with separator left','overcome'),
            'separator-right' => esc_html__('Icon with separator right','overcome'),
        );
        $header_mobile_nav_icon_type = array(
            'icon' => esc_html__('Icon','overcome'),
            'text' => esc_html__('Text','overcome'),
        );
        $header_atts_icon_style = array(
            'icon' => esc_html__('Icon','overcome')
        );
        if($default){
            $options = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = $default_helper_menu_value = $default_popup_menu = $header_mobile_nav_icon_type_value = $header_side_nav_icon_type_value = $header_popup_nav_icon_type_value = $header_atts_icon_style_value = '-1';
            $default_helper_menu = [
                'default' => true,
                'none'    => true
            ];
            $header_mobile_nav_icon_type['-1'] = esc_html__('Default','overcome');
            $header_side_nav_icon_type['-1']   = esc_html__('Default','overcome');
            $header_popup_nav_icon_type['-1']  = esc_html__('Default','overcome');
            $header_atts_icon_style['-1']      = esc_html__('Default','overcome');
        } else {
            $options = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '0';
            
            $default_helper_menu_value = '';
            $default_helper_menu  = [];
            $default_popup_menu = '0';
            $header_mobile_nav_icon_type_value = 'icon';
            $header_side_nav_icon_type_value = 'icon';
            $header_popup_nav_icon_type_value = 'text';
            $header_atts_icon_style_value = 'icon';
        }
        return array_merge(
            array(
                array(
                    'id'       => 'header_attr',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Header Attributes', 'overcome'),
                    'subtitle' => esc_html__('Choose header attributes to show', 'overcome'),
                ),
                array(
                    'title'    => esc_html__('Mobile Menu Icon Style', 'overcome'),
                    'subtitle' => esc_html__('Choose style of mobile menu icon', 'overcome'),
                    'id'       => 'header_mobile_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_mobile_nav_icon_type,
                    'default'  => $header_mobile_nav_icon_type_value,
                ),
                array(
                    'title'    => esc_html__('Helper Menu', 'overcome'),
                    'subtitle' => esc_html__('Show/Hide helper menu', 'overcome'),
                    'id'       => 'header_helper_menu',
                    'type'     => 'select',
                    'options'  => overcome_get_nav_menu($default_helper_menu),
                    'default'  => $default_helper_menu_value
                ),
                array(
                    'title'    => esc_html__('Icon Style', 'overcome'),
                    'subtitle' => esc_html__('Choose style attributes icon', 'overcome'),
                    'id'       => 'header_atts_icon_style',
                    'type'     => 'select',
                    'options'  => $header_atts_icon_style,
                    'default'  => $header_atts_icon_style_value,
                ),
                array(
                    'title'    => esc_html__('Show Social', 'overcome'),
                    'subtitle' => esc_html__('Show/Hide social icon', 'overcome'),
                    'id'       => 'header_social',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),

                array(
                    'title'    => esc_html__('Show Search', 'overcome'),
                    'subtitle' => esc_html__('Show/Hide search icon', 'overcome'),
                    'id'       => 'header_search',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                )
            ),
            overcome_header_wc_attrs($options, $default_value),
            overcome_header_donate(['default' => $default]),
            overcome_header_contact_attrs($options, $default, $default_value),
            overcome_header_contact_plain_text_attrs($options, $default_value),
            array(
                array(
                    'title'    => esc_html__('Show Nav Widget', 'overcome'),
                    'subtitle' => esc_html__('Show/Hide side menu', 'overcome'),
                    'desc'     => sprintf(esc_html__('When this option is YES, you need add widget to %sNav Widget%s area','overcome'),'<a href="' . esc_url( admin_url( 'widgets.php#sidebar-nav' ) ) . '" target="_blank">','</a>'),
                    'id'       => 'header_side_nav',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),
                array(
                    'title'    => esc_html__('Nav Widget Icon Style', 'overcome'),
                    'subtitle' => esc_html__('Choose style of side menu icon', 'overcome'),
                    'id'       => 'header_side_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_side_nav_icon_type,
                    'default'  => $header_side_nav_icon_type_value,
                    'required' => array('header_side_nav', '=', '1'),
                ),
                array(
                    'title'    => esc_html__('Show Popup Menu', 'overcome'),
                    'subtitle' => esc_html__('Show/Hide poup menu', 'overcome'),
                    'id'       => 'header_popup_nav',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),
                array(
                    'title'    => esc_html__('Popup Menu Icon Style', 'overcome'),
                    'subtitle' => esc_html__('Choose style of icon: Text or Icon', 'overcome'),
                    'id'       => 'header_popup_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_popup_nav_icon_type,
                    'default'  => $header_popup_nav_icon_type_value,
                    'required' => array('header_popup_nav', '=', '1'),
                ),
                array(
                    'id'       => 'header_popup_menu',
                    'type'     => 'select',
                    'options'  => overcome_get_nav_menu(['default' => $default, 'none' => true]),
                    'default'  => $default_popup_menu,
                    'required' => array('header_popup_nav', '=', '1'),
                    'title'    => esc_html__('Popup Menu', 'overcome'),
                    'subtitle' => esc_html__('Choose a menu to show', 'overcome'),
                )
            ),
            overcome_header_signin_signup_opts(['default' => $default]),
            array(
                array(
                    'id'       => 'header_side_copyright',
                    'type'     => 'textarea',
                    'default'  => sprintf('&copy; OverCome. by <a href="%s">SpyroPress</a>', esc_url('spyropress.com')),
                    'required' => array('header_layout', '=', '3'),
                    'title'    => esc_html__('Copyright Text', 'overcome'),
                    'subtitle' => esc_html__('Enter your copyright text', 'overcome'),
                )
            )

        );
    }
}

/**
 * Theme Options 
 * Show cart, wishlist, ... icon
 * Require WooCommerce, WooCommerce Smash Wishlist, and more to work
 *
*/
function overcome_header_wc_attrs($options, $default_value){
    if(!class_exists('WooCommerce')) return array();
    $opts = [
        array(
            'title'    => esc_html__('Show Cart', 'overcome'),
            'subtitle' => esc_html__('Show/Hide cart icon', 'overcome'),
            'id'       => 'header_cart',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        )
    ];
    if(class_exists('WPcleverWoosw')){
        $opts[] = array(
            'title'    => esc_html__('Show Wishlist', 'overcome'),
            'subtitle' => esc_html__('Show/Hide Wishlist icon', 'overcome'),
            'id'       => 'header_wishlist',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        );
    }
    if(class_exists('WPcleverWooscp')){
        $opts[] = array(
            'title'    => esc_html__('Show Compare', 'overcome'),
            'subtitle' => esc_html__('Show/Hide Compare icon', 'overcome'),
            'id'       => 'header_compare',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        );
    }
    return $opts;
}
/**
 * Theme Options 
 * Show Contact button
 * Require Contact form 7 to work
 *
*/
function overcome_header_contact_attrs($options, $default, $default_value){
    if(!class_exists('WPCF7')) return array();
    $opts = [
         array(
            'title'    => esc_html__('Show Contact', 'overcome'),
            'subtitle' => esc_html__('Show/Hide contact button', 'overcome'),
            'id'       => 'header_contact',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        ),
        array(
            'title'    => esc_html__('Contact Form', 'overcome'),
            'subtitle' => esc_html__('Choose an contact form', 'overcome'),
            'id'       => 'header_contact_form',
            'type'     => 'select',
            'options'  => overcome_get_list_cf7($default),
            'default'  => $default_value,
            'required' => array(
                array('header_contact', '!=', '-1'),
                array('header_contact', '!=', '0')
            )
        )
    ];
    
    return $opts;
}

/**
 * Theme Options 
 * Show Contact Plain Info
 * hot line, working hour, address, email,
 *
*/
function overcome_header_contact_plain_text_attrs($options, $default_value){
    $opts = [
         array(
            'title'    => esc_html__('Show Plain Contact Info', 'overcome'),
            'subtitle' => esc_html__('Show/Hide contact plain text info', 'overcome'),
            'id'       => 'header_contact_plain',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
            'required' => array(
                array('header_layout', '=', array('1','2','5','6','6-white','7','8')),
            )
        ),
        array(
            'title'    => esc_html__('Icon 1', 'overcome'),
            'id'       => 'header_contact_plain_icon1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-phone-handset or flaticon-telephone','overcome')
        ),
        array(
            'title'    => esc_html__('Title 1', 'overcome'),
            'id'       => 'header_contact_plain_text1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: (+88)222.888.66','overcome')
        ),
        array(
            'title'    => esc_html__('Description 1', 'overcome'),
            'id'       => 'header_contact_plain_subtext1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Free call','overcome')
        ),
        array(
            'title'    => esc_html__('Icon 2', 'overcome'),
            'id'       => 'header_contact_plain_icon2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-clock or flaticon-clock','overcome')
        ),
        array(
            'title'    => esc_html__('Title 2', 'overcome'),
            'id'       => 'header_contact_plain_text2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: 8:00 AM - 6:00 PM','overcome')
        ),
        array(
            'title'    => esc_html__('Description 2', 'overcome'),
            'id'       => 'header_contact_plain_subtext2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Monday - Friday','overcome')
        ),
        array(
            'title'    => esc_html__('Icon 3', 'overcome'),
            'id'       => 'header_contact_plain_icon3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-map-marker or flaticon-location-pin','overcome')
        ),
        array(
            'title'    => esc_html__('Title 3', 'overcome'),
            'id'       => 'header_contact_plain_text3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: 99 Kellen Motorway','overcome')
        ),
        array(
            'title'    => esc_html__('Description 3', 'overcome'),
            'id'       => 'header_contact_plain_subtext3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Wallis and Futuna','overcome')
        ),
        array(
            'title'    => esc_html__('Title 3 (Sub)', 'overcome'),
            'id'       => 'header_contact_plain_sub_text3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Closed on','overcome')
        ),
        array(
            'title'    => esc_html__('Description 3 (Sub)', 'overcome'),
            'id'       => 'header_contact_plain_sub_subtext3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Weekends','overcome')
        ),

    ];
    
    return $opts;
}

/**
 * Theme Options 
 * Show SingIn / SingUp button
 * Require CSH Login Plugin
 *
*/
if(!function_exists('overcome_header_signin_signup_opts')){
    function overcome_header_signin_signup_opts($args = []){
        if(!function_exists('cshlg_add_login_form')) return array();
        $args = wp_parse_args($args,[
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '0';
        }
        return array (
            array(
                'title'    => esc_html__('Show SignIn', 'overcome'),
                'subtitle' => esc_html__('Show/Hide SignIn Button', 'overcome'),
                'id'       => 'header_signin',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('SignIn Label', 'overcome'),
                'id'       => 'header_signin_label',
                'type'     => 'text',
                'default'  => esc_html__('Sign In','overcome'),
                'required' => array('header_signin', '!=', '0')
            ),
            array(
                'title'    => esc_html__('Show SignUp', 'overcome'),
                'subtitle' => esc_html__('Show/Hide SignUp Button', 'overcome'),
                'id'       => 'header_signup',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('SignUp Label', 'overcome'),
                'id'       => 'header_signup_label',
                'type'     => 'text',
                'default'  => esc_html__('Sign Up','overcome'),
                'required' => array('header_signup', '!=', '0')
            )
        );
    }
}

/**
 * Theme Options 
 * Show SingIn / SingUp button
 * Require CSH Login Plugin
 *
*/
if(!function_exists('overcome_header_donate')){
    function overcome_header_donate($args = []){
        if(!class_exists('EF5Payments')) return array();
        $args = wp_parse_args($args,[
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '0';
        }
        return array (
            array(
                'title'    => esc_html__('Show Donate', 'overcome'),
                'subtitle' => esc_html__('Show/Hide Donate Button', 'overcome'),
                'id'       => 'header_donate',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('Button Label', 'overcome'),
                'id'       => 'header_donate_label',
                'type'     => 'text',
                'default'  => esc_html__('Donate Now','overcome'),
                'required' => array('header_donate', '!=', '0')
            ),
            array(
                'title'    => esc_html__('Donate for?', 'overcome'),
                'subtitle' => esc_html__('Choose default item for donate, if not, the first item will choose','overcome'),
                'id'       => 'header_donate_item',
                'type'     => 'select',
                'options'  => overcome_list_post('ef5_donation'),
                'default'  => '',
                'required' => array('header_donate', '!=', '0')
            )
        );
    }
}

/**
 * Main Logo
*/
if(!function_exists('overcome_header_main_logo')){
    function overcome_header_main_logo($args = []){
        $args = wp_parse_args($args, [
            'subsection' => true
        ]);
        return array(
            'title'      => esc_html__('Logo', 'overcome'),
            'icon'       => 'el-icon-picture',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'             => 'logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Logo', 'overcome'),
                    'subtitle'       => esc_html__('Choose your logo. If not set, default Logo will be used', 'overcome')
                ),
                array(
                    'id'       => 'logo_size',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'overcome'),
                    'subtitle' => esc_html__('Enter size (width x height) for your logo, just in case the logo is too large. If not set, default size will be used', 'overcome'),
                    'units'     => array('px'),
                    'default'   => array(),
                ),
            )
        );
    }
}

/**
 * Main Logo
*/
if(!function_exists('overcome_header_page_logo')){
    function overcome_header_page_logo($args = []){
        $args = wp_parse_args($args, [
            'subsection' => true
        ]);
        return array(
            'title'      => esc_html__('Logo', 'overcome'),
            'icon'       => 'el-icon-picture',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'             => 'logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Main Logo', 'overcome'),
                    'subtitle'       => esc_html__('Choose your logo. If not set, default Logo will be used', 'overcome')
                ),
                array(
                    'id'             => 'sticky_logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Sticky Logo', 'overcome'),
                    'subtitle'       => esc_html__('Choose your sticky logo. If not set, default Logo will be used', 'overcome')
                ),
                array(
                    'id'       => 'logo_size',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'overcome'),
                    'subtitle' => esc_html__('Enter size (width x height) for your logo, just in case the logo is too large. If not set, default size will be used', 'overcome'),
                    'units'     => array('px'),
                    'default'   => array(),
                ),
            )
        );
    }
}

/**
 * Ontop Header 
*/
if(!function_exists('overcome_ontop_header_opts')){
    function overcome_ontop_header_opts($args = []){
        $args = wp_parse_args($args, [
            'default'    => false,
            'subsection' => true
        ]);
        $force_output = $args['default'] ? true : false;
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '0';
        }
        return array(
            'title'      => esc_html__('On Top Header', 'overcome'),
            'icon'       => 'el-icon-credit-card ',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'       => 'header_ontop',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Header On top', 'overcome'),
                    'subtitle' => esc_html__('Header will be on top when applicable.', 'overcome'),
                    'options'  => $options,
                    'default'  => $default_value
                ),
                array(
                    'id'       => 'header_ontop_top_space',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Top Space', 'overcome'),
                    'subtitle' => esc_html__('Add a space from top to header', 'overcome'),
                    'units'    => array('px'),
                    'width'    => false,
                    'default'  => array(),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('On top Logo', 'overcome'),
                    'subtitle' => esc_html__('Custon Logo', 'overcome'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo',
                    'type'     => 'media',
                    'title'    => esc_html__('On top Logo', 'overcome'),
                    'subtitle' => esc_html__('If not set, default logo will be used.', 'overcome'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo_maxh',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'overcome'),
                    'subtitle' => esc_html__('Enter size for your logo in on top header, just in case the logo is too large. If not set, default size will be used', 'overcome'),
                    'units'     => array('px'),
                    'default'  => array(),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_header_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Header Design', 'overcome'),
                    'subtitle' => esc_html__('Custom on top header style like: background, color, space, ...', 'overcome'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'     => 'ontop_header_bg',
                    'type'   => 'color_rgba',
                    'title'  => esc_html__('Background', 'overcome'),
                    'output' => array(
                        'background-color' => '.header-ontop'
                    ),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'          => 'ontop_header_text_color',
                    'type'        => 'color_rgba',
                    'title'       => esc_html__('Text Color', 'overcome'),
                    'default'     => '',
                    'output'      => array(
                        'color' => '.header-ontop'
                    ),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'    => 'ontop_link_colors',
                    'type'  => 'link_color',
                    'title' => esc_html__('Link colors', 'overcome'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'header_ontop_border',
                    'type'     => 'border',
                    'all'      => false,
                    'color'    => false,
                    'title'    => esc_html__('Border Style', 'overcome'),
                    'subtitle' => esc_html__('Add your custom border design', 'overcome'),
                    'output'   => array('.header-ontop'),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'header_ontop_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__('Border Color', 'overcome'),
                    'subtitle' => esc_html__('Add your custom border color', 'overcome'),
                    'output'   => array(
                        'border-color' => '.header-ontop'
                    ),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                )
            )
        );
    }
}

/**
 * Header Sticky Options
*/
if(!function_exists('overcome_sticky_header_opts')){
    function overcome_sticky_header_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'    => false,
            'subsection' => true
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','overcome'),
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','overcome'),
                '0'  => esc_html__('No','overcome'),
            );
            $default_value = '0';
        }
        return array(
            'title'      => esc_html__('Sticky Header', 'overcome'),
            'icon'       => 'el-icon-credit-card ',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'       => 'header_sticky',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Sticky Header', 'overcome'),
                    'subtitle' => esc_html__('Header will be sticked when applicable.', 'overcome'),
                    'options'  => $options,
                    'default'  => $default_value
                ),
                array(
                    'id'       => 'sticky_logo_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Sticky Logo', 'overcome'),
                    'subtitle' => esc_html__('Custon Logo', 'overcome'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_logo',
                    'type'     => 'media',
                    'title'    => esc_html__('Sticky Header Logo', 'overcome'),
                    'subtitle' => esc_html__('If not set, default logo will be used.', 'overcome'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_logo_maxh',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'overcome'),
                    'subtitle' => esc_html__('Enter size for your logo on sticky header, just in case the logo is too large.', 'overcome'),
                    'units'     => array('px'),
                    'default'  => array(),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_header_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Sticky Header Design', 'overcome'),
                    'subtitle' => esc_html__('Custom sticky header style like: background, color, space, ...', 'overcome'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'     => 'sticky_header_bg',
                    'type'   => 'color_rgba',
                    'title'  => esc_html__('Background', 'overcome'),
                    'output' => array(
                        'background-color' => '.header-sticky'
                    ),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'          => 'sticky_header_text_color',
                    'type'        => 'color_rgba',
                    'title'       => esc_html__('Text Color', 'overcome'),
                    'default'     => '',
                    'output'      => array('.header-sticky'),
                    'required' => array('header_sticky','=', '1')
                ),
                array(
                    'id'    => 'sticky_link_colors',
                    'type'  => 'link_color',
                    'title' => esc_html__('Link colors', 'overcome'),
                    'output' => array(
                        'color' => '.header-sticky a'
                    ),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'header_sticky_border',
                    'type'     => 'border',
                    'all'      => false,
                    'color'    => false,
                    'title'    => esc_html__('Border Style', 'overcome'),
                    'subtitle' => esc_html__('Add your custom border design', 'overcome'),
                    'output'   => array('.header-sticky'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'header_sticky_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__('Border Color', 'overcome'),
                    'subtitle' => esc_html__('Add your custom border color', 'overcome'),
                    'output'   => array(
                        'border-color' => '.header-sticky'
                    ),
                    'required' => array('header_sticky', '=', '1')
                )
            )
        );
    }
}
/**
 * Theme Options
 * Page title options
*/
if(!function_exists('overcome_page_title_opts')){
    function overcome_page_title_opts($args=[]){
        $args = wp_parse_args($args,[
            'default' => false
        ]);
        $force_output = $args['default'] ? true : false;
        $default_value = '1';

        $custom_title = $custom_desc = '';

        $ptitle_layout = [
            '1' => get_template_directory_uri() . '/assets/images/page-title/01.png',
            '2' => get_template_directory_uri() . '/assets/images/page-title/02.png',
        ];
        $breadcrumb_on_opts = array(
            '1'  => esc_html__('Show','overcome'), 
            '0'  => esc_html__('Hide','overcome'), 
         );
        if($args['default']){
            $default_value = '-1';
            $ptitle_layout = [
                '-1'   => get_template_directory_uri() . '/assets/images/default.png',
                'none' => get_template_directory_uri() . '/assets/images/none.png'
            ] + $ptitle_layout;

            $custom_title = array(
                'id'       => 'custom_title',
                'type'     => 'text',
                'title'    => esc_html__('Custom Title', 'overcome'),
                'subtitle' => esc_html__('Use custom title for this page. The default title will be used on document title.', 'overcome')
            );

            $custom_desc = array(
                'id'       => 'custom_desc',
                'type'     => 'textarea',
                'title'    => esc_html__('Custom description', 'overcome'),
                'subtitle' => esc_html__('Show custom page description under page title', 'overcome')
            );

            $breadcrumb_on_opts = [
                '-1'  => esc_html__('Default','overcome')
            ] + $breadcrumb_on_opts;
        }
        return array(
            array(
                'id'       => 'ptitle_layout',
                'type'     => 'image_select',
                'title'    => esc_html__('Layout', 'overcome'),
                'subtitle' => esc_html__('Select a layout for page title.', 'overcome'),
                'options'  => $ptitle_layout,
                'default'  => $default_value
            ),
            $custom_title,
            $custom_desc,
            array(
                'id'           => 'ptitle_color',
                'type'         => 'color_rgba',
                'title'        => esc_html__('Title Color', 'overcome'),
                'subtitle'     => esc_html__('Page title color.', 'overcome'),
                'output'       => array(
                    'color' => '.ef5-pagetitle .page-title'
                ),
                'force_output' => $force_output,
                'default'      => ''
            ),
            array(
                'id'       => 'ptitle_parallax',
                'type'     => 'media',
                'title'    => esc_html__('Parallax Image', 'overcome'),
                'subtitle' => esc_html__('Choose your image', 'overcome'),
            ),
            array(
                'id'       => 'ptitle_parallax_overlay',
                'type'     => 'color_rgba',
                'title'    => esc_html__('Parallax Overlay Color', 'overcome'),
                'subtitle' => esc_html__('Add parallax overlay color.', 'overcome'),
                'output'   => array(
                    'background-color' => '.ef5-pagetitle .parallax:before'
                ),
                'force_output' => $force_output,
                'default'      => ''
            ),
            array(
                'id'           => 'ptitle_paddings',
                'type'         => 'spacing',
                'title'        => esc_html__('Paddings', 'overcome'),
                'subtitle'     => esc_html__('Enter inner space.', 'overcome'),
                'mode'         => 'padding',
                'units'        => array('px'),
                'output'       => array('#ef5-page .ef5-pagetitle'),
                'force_output' => $force_output,
                'default'      => array()
            ),
            array(
                'id'           => 'ptitle_margins',
                'type'         => 'spacing',
                'title'        => esc_html__('Margin', 'overcome'),
                'subtitle'     => esc_html__('Enter outer space.', 'overcome'),
                'mode'         => 'margin',
                'units'        => array('px'),
                'force_output' => $force_output,
                'output'       => array('#ef5-page .ef5-pagetitle-wrap'),
                'default'      => array()
            ),
            array(
                'id'      => 'breadcrumb_on',
                'type'    => 'button_set',
                'options' => $breadcrumb_on_opts,
                'title'   => esc_html__('Breadcrumb', 'overcome'),
                'default' => $default_value
            ),
            array(
                'id'          => 'breadcrumb_color',
                'type'        => 'color',
                'title'       => esc_html__('Breadcrumb Text Color', 'overcome'),
                'subtitle'    => esc_html__('Select text color for breadcrumb', 'overcome'),
                'transparent' => false,
                'output'      => array('.ef5-pagetitle-wrap .breadcrumb'),
                'force_output'=> $force_output,
                'required'    => array('breadcrumb_on', '=', true)
            ),
            array(
                'id'           => 'breadcrumb_link_colors',
                'type'         => 'link_color',
                'title'        => esc_html__('Breadcrumb Link Colors', 'overcome'),
                'subtitle'     => esc_html__('Select link colors for breadcrumb', 'overcome'),
                'output'       => array('.ef5-pagetitle-wrap .breadcrumb a'),
                'force_output' => $force_output,
                'default'      => array(),
                'required'     => array('breadcrumb_on', '=', true)
            )
        );
    }
}
/**
 * Widget Options
 * sidebar position
*/
function overcome_sidebar_position_opts($default = false){
    $options_default = array('-1' => esc_html__('Default','overcome'));
    $options =  array(
        'none'   => esc_html__('No Widget', 'overcome'),
        'center' => esc_html__('No Widget - Content Center', 'overcome'),
        'left'   => esc_html__('Left', 'overcome'),
        'right'  => esc_html__('Right', 'overcome'),
        'bottom' => esc_html__('Below Content', 'overcome')
    );
    if($default)
        return $options_default+$options;
    else 
        return $options;
}

/* Page Options */
if(!function_exists('overcome_page_opts')){
    function overcome_page_opts($default = false){
        $default_value = overcome_page_sidebar_position();
        if($default){
            $default_value = '-1';
        }
        return array(
            array(
                'id'       => 'page_sidebar_pos',
                'type'     => 'button_set',
                'title'    => esc_html__('Layouts', 'overcome'),
                'subtitle' => esc_html__('select a layout for single...', 'overcome'),
                'options'  => overcome_sidebar_position_opts($default),
                'default'  => $default_value
            )
        );
    }
}

/**
 * WooCommerce Options
*/
if(!function_exists('overcome_woocommerce_theme_opts')){
    function overcome_woocommerce_theme_opts($default = false){
        $gallery_layout = $gallery_thumb_position        = array();
        $default_value          = 'none';
        $default_gallery_layout = 'simple';
        $default_gallery_thumb_position = 'thumb-right';
        if($default){
            $gallery_layout['-1']         = esc_html__('Default','overcome');
            $gallery_thumb_position['-1'] = esc_html__('Default','overcome');
            $default_value                = '-1';
            $default_gallery_layout       = '-1';
            $default_gallery_thumb_position       = '-1';
        }
        $gallery_layout['simple']     = esc_html__('Simple', 'overcome');
        $gallery_layout['thumbnail_v'] = esc_html__('Thumbnail Vertical', 'overcome');
        $gallery_layout['thumbnail_h'] = esc_html__('Thumbnail Horizontal', 'overcome');

        $gallery_thumb_position['thumb-left'] = esc_html__('Left','overcome');
        $gallery_thumb_position['thumb-right'] = esc_html__('Right','overcome');

        return array(
            'title'      => esc_html__('WooCommerce', 'overcome'),
            'icon'       => 'el el-shopping-cart',
            'subsection' => false,
            'fields'     => array(
                array(
                    'id'       => 'loop_product_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Loop Products Design', 'overcome'),
                    'subtitle' => esc_html__('Custom products design, ...', 'overcome'),
                ),
                array(
                    'id'       => 'products_per_page',
                    'type'     => 'slider',
                    'title'    => esc_html__('Number Products', 'overcome'),
                    'subtitle' => esc_html__('Choose number products to show on archive page, ...', 'overcome'),
                    'default'   => 12,
                    'min'       => 1,
                    'step'      => 1,
                    'max'       => 50,
                    'display_value' => 'label'
                ),
                array(
                    'id'       => 'products_columns',
                    'type'     => 'slider',
                    'title'    => esc_html__('Products Columns', 'overcome'),
                    'subtitle' => esc_html__('Choose products columns show on archive page, ...', 'overcome'),
                    'default'   => 4,
                    'min'       => 1,
                    'step'      => 1,
                    'max'       => 6,
                    'display_value' => 'label'
                ),
                array(
                    'id'       => 'shop_sidebar_pos',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'overcome'),
                    'subtitle' => esc_html__('select a layout for products page', 'overcome'),
                    'options'  => overcome_sidebar_position_opts(),
                    'default'  => overcome_shop_sidebar_position()
                ),
                array(
                    'id'       => 'single_product_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Single Product Design', 'overcome'),
                    'subtitle' => esc_html__('Custom single product design, ...', 'overcome'),
                ),
                array(
                    'id'       => 'product_gallery_layout',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'overcome'),
                    'subtitle' => esc_html__('select a layout for single...', 'overcome'),
                    'options'  => $gallery_layout,
                    'default'  => $default_gallery_layout
                ),
                array(
                    'id'       => 'product_gallery_thumb_position',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Thumbnail Position', 'overcome'),
                    'subtitle' => esc_html__('select a position for gallery thumbnail', 'overcome'),
                    'options'  => $gallery_thumb_position,
                    'default'  => $default_gallery_thumb_position,
                    'required' => array(
                        array('product_gallery_layout', '=', 'thumbnail_v')
                    )
                ),
                array(
                    'id'       => 'product_share_on',
                    'title'    => esc_html__('Share', 'overcome'),
                    'subtitle' => esc_html__('Show share product to some socials network on each post.', 'overcome'),
                    'type'     => 'switch',
                    'default'  => '0',
                ),
                array(
                    'id'       => 'product_sidebar_pos',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'overcome'),
                    'subtitle' => esc_html__('select a layout for single product page', 'overcome'),
                    'options'  => overcome_sidebar_position_opts(),
                    'default'  => overcome_product_sidebar_position()
                ),
            )
        );
    }
}

/**
 * Theme Options 
 * Footer Area 
 * Add option repeated for theme/ meta option
*/
if(!function_exists('overcome_footer_opts')){
    function overcome_footer_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = $args['default'] ? '-1' : '';
        $force_output  = $args['default'] ? true : false;
        return array(
            'title'  => esc_html__('Footer', 'overcome'),
            'icon'   => 'el el-website',
            'fields' => array(
                array(
                    'id'          => 'footer_layout',
                    'type'        => 'image_select',
                    'title'       => esc_html__('Layout', 'overcome'),
                    'subtitle'    => esc_html__('Select a layout for upper footer area.', 'overcome'),
                    'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','overcome'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=ef5_footer' ) ) . '">','</a>'),
                    'placeholder' => esc_html__('Default','overcome'),
                    'options'     => overcome_list_post_thumbnail('ef5_footer', $args['default']),
                    'default'     => $default_value
                ),
                array(
                    'id'             => 'footer_margin',
                    'type'           => 'spacing',
                    'mode'           => 'margin',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Footer margin', 'overcome'),
                    'subtitle'       => esc_html__('Enter outer space', 'overcome'),
                    'force_output'   => $force_output,
                    'output'         => array(
                        '#ef5-footer'
                    )
                ),
            )
        );
    }
}