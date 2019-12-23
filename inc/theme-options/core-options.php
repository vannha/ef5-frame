<?php
/**
 * Theme Options 
 * Site Boxed
 * Add option repeated Boxed theme/ meta option
*/
if(!function_exists('ef5frame_general_opts')){
    function ef5frame_general_opts($args = []){
        $args = wp_parse_args($args, [
            'default'   => false
        ]);
        $default_value              = $args['default'] ? '-1' : '0';
        $force_output               = $args['default'] ? true : false;
        $default_dropdown_opts      = $args['default'] ? array('-1' => esc_html__('Default','ef5-frame')) : array();
        $default_page_loading_value = $args['default'] ? '-1' : 'fading-circle';

        if($args['default'] === true){
            $options_layout = array(
                '-1'       => esc_html__('Default','ef5-frame'),
                'boxed'    => esc_html__('Boxed','ef5-frame'),
                'bordered' => esc_html__('Bordered','ef5-frame'),
            );
            $default_layout = '-1';

            $options_boxed = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
        } else {
            $options_layout = array(
                '-1'       => esc_html__('Default','ef5-frame'),
                'boxed'    => esc_html__('Boxed','ef5-frame'),
                'bordered' => esc_html__('Bordered','ef5-frame'),
            );
            $default_layout = '-1';
            
            $options_boxed = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
        }
        return array(
            array(
                'id'       => 'body_bg',
                'type'     => 'background',
                'title'    => esc_html__('Body Background', 'ef5-frame'),
                'subtitle' => esc_html__('Choose background style for body', 'ef5-frame'),
                'output'   => array('body')
            ),       
            array(
                'id'       => 'site_layout',
                'type'     => 'button_set',
                'title'    => esc_html__('Layout', 'ef5-frame'),
                'subtitle' => esc_html__('Choose site layout', 'ef5-frame'),
                'options'  => $options_layout,
                'default'  => $default_layout,
            ),
            array(
                'id'       => 'boxed_content_bg',
                'type'     => 'background',
                'title'    => esc_html__('Boxed Content Background', 'ef5-frame'),
                'subtitle' => esc_html__('Choose background style for boxed content', 'ef5-frame'),
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
                'title'    => esc_html__('Bordered Width', 'ef5-frame'),
                'subtitle' => esc_html__('Enter bordered with.', 'ef5-frame'),
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
                'title'    => esc_html__('Bordered Content Background', 'ef5-frame'),
                'subtitle' => esc_html__('Choose background style for bordered content', 'ef5-frame'),
                'required' => array(
                    array('site_layout', '=', 'bordered')
                ),
                'output'   => array('.site-bordered .ef5-page'),
                'force_output' => $force_output
            ),
            array(
                'id'       => 'show_page_loading',
                'type'     => 'button_set',
                'title'    => esc_html__('Enable Page Loading', 'ef5-frame'),
                'subtitle' => esc_html__('Enable Page Loading Effect When You Load Site', 'ef5-frame'),
                'options'  => $options_boxed,
                'default'  => $default_value,
            ),
            array(
                'title'     => esc_html__('Page Loadding Style','ef5-frame'),
                'subtitle'  => esc_html__('Select Style Page Loadding.','ef5-frame'),
                'id'        => 'page_loading_style',
                'type'      => 'select',
                'options'   => ef5frame_page_loading_styles($args['default']),
                'default'   => $default_page_loading_value,
                'required'  => array('show_page_loading', '=', '1' )
            ),
            array(
                'id'       => 'back_totop_on',
                'type'     => 'button_set',
                'title'    => esc_html__('Back to Top Button', 'ef5-frame'),
                'subtitle' => esc_html__('Show back to top button when scrolled down.', 'ef5-frame'),
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
if(!function_exists('ef5frame_header_top_opts')){
    function ef5frame_header_top_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = $args['default'] ? '-1' : '';
        return array(
            'title'  => esc_html__('Header Top', 'ef5-frame'),
            'icon'   => 'el el-website',
            'fields' => array(
                array(
                    'id'          => 'header_top',
                    'type'        => 'image_select',
                    'title'       => esc_html__('Layout', 'ef5-frame'),
                    'subtitle'    => esc_html__('Select a layout for upper header top area.', 'ef5-frame'),
                    'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom header layout first.','ef5-frame'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=ef5_header_top' ) ) . '">','</a>'),
                    'options'     => ef5frame_list_post_thumbnail('ef5_header_top', $args['default']),
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
if(!function_exists('ef5frame_header_layout')){
    function ef5frame_header_layout($default = false){
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

if(!function_exists('ef5frame_header_opts')){
    function ef5frame_header_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = '1';
        $default_menu = '0';
        if($args['default'] === true){
            $options_width = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            
            $default_value = $default_menu = $default_width_value = '-1';
        } else {
            $options_width = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_width_value = '0';
        }
        return array(
            array(
                'id'       => 'header_layout',
                'type'     => 'image_select',
                'title'    => esc_html__('Layout', 'ef5-frame'),
                'subtitle' => esc_html__('Select a layout for header.', 'ef5-frame'),
                'options'  => ef5frame_header_layout($args['default']),
                'default'  => $default_value
            ),
            array(
                'id'       => 'header_menu',
                'type'     => 'select',
                'options'  => ef5frame_get_nav_menu(['default' => $args['default'],'none' => true]),
                'default'  => $default_menu,
                'title'    => esc_html__('Header Menu', 'ef5-frame'),
                'subtitle' => esc_html__('Choose a menu to show', 'ef5-frame'),
            ),
            array(
                'id'       => 'header_design',
                'type'     => 'info',
                'style'    => 'success',
                'title'    => esc_html__('Header Design', 'ef5-frame'),
                'subtitle' => esc_html__('Custom header style like: background, text color, link color, border style, ...', 'ef5-frame'),
            ),
            array(
                'title'    => esc_html__('Header Width', 'ef5-frame'),
                'subtitle' => esc_html__('Make header content full width or not', 'ef5-frame'),
                'id'       => 'header_fullwidth',
                'type'     => 'button_set',
                'options'  => $options_width,
                'default'  => $default_width_value,
                'required' => array(
                    array('header_layout' ,'!=', '3')
                )
            ),
            array(
                'title'    => esc_html__('Menu Height', 'ef5-frame'),
                'subtitle' => esc_html__('Enter the height for Menu', 'ef5-frame'),
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
                'title'    => esc_html__('Header Width', 'ef5-frame'),
                'subtitle' => esc_html__('Enter the width for side navigation header', 'ef5-frame'),
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
                'title'  => esc_html__('Background', 'ef5-frame'),
                'output' => array('.header-default')
            ),
            array(
                'id'          => 'header_text_color',
                'type'        => 'color_rgba',
                'title'       => esc_html__('Text Color', 'ef5-frame'),
                'default'     => '',
                'output'      => array('.header-default')
            ),
            array(
                'id'    => 'header_link_colors',
                'type'  => 'link_color',
                'title' => esc_html__('Link colors', 'ef5-frame'),
            ),
            array(
                'id'       => 'header_border',
                'type'     => 'border',
                'all'      => false,
                'color'    => false,
                'title'    => esc_html__('Border Style', 'ef5-frame'),
                'subtitle' => esc_html__('Add your custom border design', 'ef5-frame'),
                'output'   => array('.header-default')
            ),
            array(
                'id'       => 'header_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__('Border Color', 'ef5-frame'),
                'subtitle' => esc_html__('Add your custom border color', 'ef5-frame'),
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
if(!function_exists('ef5frame_header_atts')){
    function ef5frame_header_atts($default = false){
        $header_side_nav_icon_type = array(
            'icon'            => esc_html__('Icon Only','ef5-frame'),
            'separator-left'  => esc_html__('Icon with separator left','ef5-frame'),
            'separator-right' => esc_html__('Icon with separator right','ef5-frame'),
        );
        $header_popup_nav_icon_type = array(
            'text'            => esc_html__('Text','ef5-frame'),
            'icon'            => esc_html__('Icon Only','ef5-frame'),
            'separator-left'  => esc_html__('Icon with separator left','ef5-frame'),
            'separator-right' => esc_html__('Icon with separator right','ef5-frame'),
        );
        $header_mobile_nav_icon_type = array(
            'icon' => esc_html__('Icon','ef5-frame'),
            'text' => esc_html__('Text','ef5-frame'),
        );
        $header_atts_icon_style = array(
            'icon' => esc_html__('Icon','ef5-frame')
        );
        if($default){
            $options = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = $default_helper_menu_value = $default_popup_menu = $header_mobile_nav_icon_type_value = $header_side_nav_icon_type_value = $header_popup_nav_icon_type_value = $header_atts_icon_style_value = '-1';
            $default_helper_menu = [
                'default' => true,
                'none'    => true
            ];
            $header_mobile_nav_icon_type['-1'] = esc_html__('Default','ef5-frame');
            $header_side_nav_icon_type['-1']   = esc_html__('Default','ef5-frame');
            $header_popup_nav_icon_type['-1']  = esc_html__('Default','ef5-frame');
            $header_atts_icon_style['-1']      = esc_html__('Default','ef5-frame');
        } else {
            $options = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
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
                    'title'    => esc_html__('Header Attributes', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose header attributes to show', 'ef5-frame'),
                ),
                array(
                    'title'    => esc_html__('Mobile Menu Icon Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose style of mobile menu icon', 'ef5-frame'),
                    'id'       => 'header_mobile_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_mobile_nav_icon_type,
                    'default'  => $header_mobile_nav_icon_type_value,
                ),
                array(
                    'title'    => esc_html__('Helper Menu', 'ef5-frame'),
                    'subtitle' => esc_html__('Show/Hide helper menu', 'ef5-frame'),
                    'id'       => 'header_helper_menu',
                    'type'     => 'select',
                    'options'  => ef5frame_get_nav_menu($default_helper_menu),
                    'default'  => $default_helper_menu_value
                ),
                array(
                    'title'    => esc_html__('Icon Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose style attributes icon', 'ef5-frame'),
                    'id'       => 'header_atts_icon_style',
                    'type'     => 'select',
                    'options'  => $header_atts_icon_style,
                    'default'  => $header_atts_icon_style_value,
                ),
                array(
                    'title'    => esc_html__('Show Social', 'ef5-frame'),
                    'subtitle' => esc_html__('Show/Hide social icon', 'ef5-frame'),
                    'id'       => 'header_social',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),

                array(
                    'title'    => esc_html__('Show Search', 'ef5-frame'),
                    'subtitle' => esc_html__('Show/Hide search icon', 'ef5-frame'),
                    'id'       => 'header_search',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                )
            ),
            ef5frame_header_wc_attrs($options, $default_value),
            ef5frame_header_donate(['default' => $default]),
            ef5frame_header_contact_attrs($options, $default, $default_value),
            ef5frame_header_contact_plain_text_attrs($options, $default_value),
            array(
                array(
                    'title'    => esc_html__('Show Nav Widget', 'ef5-frame'),
                    'subtitle' => esc_html__('Show/Hide side menu', 'ef5-frame'),
                    'desc'     => sprintf(esc_html__('When this option is YES, you need add widget to %sNav Widget%s area','ef5-frame'),'<a href="' . esc_url( admin_url( 'widgets.php#sidebar-nav' ) ) . '" target="_blank">','</a>'),
                    'id'       => 'header_side_nav',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),
                array(
                    'title'    => esc_html__('Nav Widget Icon Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose style of side menu icon', 'ef5-frame'),
                    'id'       => 'header_side_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_side_nav_icon_type,
                    'default'  => $header_side_nav_icon_type_value,
                    'required' => array('header_side_nav', '=', '1'),
                ),
                array(
                    'title'    => esc_html__('Show Popup Menu', 'ef5-frame'),
                    'subtitle' => esc_html__('Show/Hide poup menu', 'ef5-frame'),
                    'id'       => 'header_popup_nav',
                    'type'     => 'button_set',
                    'options'  => $options,
                    'default'  => $default_value,
                ),
                array(
                    'title'    => esc_html__('Popup Menu Icon Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose style of icon: Text or Icon', 'ef5-frame'),
                    'id'       => 'header_popup_nav_icon_type',
                    'type'     => 'select',
                    'options'  => $header_popup_nav_icon_type,
                    'default'  => $header_popup_nav_icon_type_value,
                    'required' => array('header_popup_nav', '=', '1'),
                ),
                array(
                    'id'       => 'header_popup_menu',
                    'type'     => 'select',
                    'options'  => ef5frame_get_nav_menu(['default' => $default, 'none' => true]),
                    'default'  => $default_popup_menu,
                    'required' => array('header_popup_nav', '=', '1'),
                    'title'    => esc_html__('Popup Menu', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose a menu to show', 'ef5-frame'),
                )
            ),
            ef5frame_header_signin_signup_opts(['default' => $default]),
            array(
                array(
                    'id'       => 'header_side_copyright',
                    'type'     => 'textarea',
                    'default'  => sprintf('&copy; EF5Frame. by <a href="%s">SpyroPress</a>', esc_url('spyropress.com')),
                    'required' => array('header_layout', '=', '3'),
                    'title'    => esc_html__('Copyright Text', 'ef5-frame'),
                    'subtitle' => esc_html__('Enter your copyright text', 'ef5-frame'),
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
function ef5frame_header_wc_attrs($options, $default_value){
    if(!class_exists('WooCommerce')) return array();
    $opts = [
        array(
            'title'    => esc_html__('Show Cart', 'ef5-frame'),
            'subtitle' => esc_html__('Show/Hide cart icon', 'ef5-frame'),
            'id'       => 'header_cart',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        )
    ];
    if(class_exists('WPcleverWoosw')){
        $opts[] = array(
            'title'    => esc_html__('Show Wishlist', 'ef5-frame'),
            'subtitle' => esc_html__('Show/Hide Wishlist icon', 'ef5-frame'),
            'id'       => 'header_wishlist',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        );
    }
    if(class_exists('WPcleverWooscp')){
        $opts[] = array(
            'title'    => esc_html__('Show Compare', 'ef5-frame'),
            'subtitle' => esc_html__('Show/Hide Compare icon', 'ef5-frame'),
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
function ef5frame_header_contact_attrs($options, $default, $default_value){
    if(!class_exists('WPCF7')) return array();
    $opts = [
         array(
            'title'    => esc_html__('Show Contact', 'ef5-frame'),
            'subtitle' => esc_html__('Show/Hide contact button', 'ef5-frame'),
            'id'       => 'header_contact',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
        ),
        array(
            'title'    => esc_html__('Contact Form', 'ef5-frame'),
            'subtitle' => esc_html__('Choose an contact form', 'ef5-frame'),
            'id'       => 'header_contact_form',
            'type'     => 'select',
            'options'  => ef5frame_get_list_cf7($default),
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
function ef5frame_header_contact_plain_text_attrs($options, $default_value){
    $opts = [
         array(
            'title'    => esc_html__('Show Plain Contact Info', 'ef5-frame'),
            'subtitle' => esc_html__('Show/Hide contact plain text info', 'ef5-frame'),
            'id'       => 'header_contact_plain',
            'type'     => 'button_set',
            'options'  => $options,
            'default'  => $default_value,
            'required' => array(
                array('header_layout', '=', array('1','2','5','6','6-white','7','8')),
            )
        ),
        array(
            'title'    => esc_html__('Icon 1', 'ef5-frame'),
            'id'       => 'header_contact_plain_icon1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-phone-handset or flaticon-telephone','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Title 1', 'ef5-frame'),
            'id'       => 'header_contact_plain_text1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: (+88)222.888.66','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Description 1', 'ef5-frame'),
            'id'       => 'header_contact_plain_subtext1',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Free call','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Icon 2', 'ef5-frame'),
            'id'       => 'header_contact_plain_icon2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-clock or flaticon-clock','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Title 2', 'ef5-frame'),
            'id'       => 'header_contact_plain_text2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: 8:00 AM - 6:00 PM','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Description 2', 'ef5-frame'),
            'id'       => 'header_contact_plain_subtext2',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Monday - Friday','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Icon 3', 'ef5-frame'),
            'id'       => 'header_contact_plain_icon3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your font icon class, ex: lnr lnr-map-marker or flaticon-location-pin','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Title 3', 'ef5-frame'),
            'id'       => 'header_contact_plain_text3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: 99 Kellen Motorway','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Description 3', 'ef5-frame'),
            'id'       => 'header_contact_plain_subtext3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Wallis and Futuna','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Title 3 (Sub)', 'ef5-frame'),
            'id'       => 'header_contact_plain_sub_text3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Closed on','ef5-frame')
        ),
        array(
            'title'    => esc_html__('Description 3 (Sub)', 'ef5-frame'),
            'id'       => 'header_contact_plain_sub_subtext3',
            'type'     => 'text',
            'default'  => '',
            'required' => array(
                array('header_contact_plain', '=', '1'),
            ),
            'description' => esc_html__('Enter your text, ex: Weekends','ef5-frame')
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
if(!function_exists('ef5frame_header_signin_signup_opts')){
    function ef5frame_header_signin_signup_opts($args = []){
        if(!function_exists('cshlg_add_login_form')) return array();
        $args = wp_parse_args($args,[
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '0';
        }
        return array (
            array(
                'title'    => esc_html__('Show SignIn', 'ef5-frame'),
                'subtitle' => esc_html__('Show/Hide SignIn Button', 'ef5-frame'),
                'id'       => 'header_signin',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('SignIn Label', 'ef5-frame'),
                'id'       => 'header_signin_label',
                'type'     => 'text',
                'default'  => esc_html__('Sign In','ef5-frame'),
                'required' => array('header_signin', '!=', '0')
            ),
            array(
                'title'    => esc_html__('Show SignUp', 'ef5-frame'),
                'subtitle' => esc_html__('Show/Hide SignUp Button', 'ef5-frame'),
                'id'       => 'header_signup',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('SignUp Label', 'ef5-frame'),
                'id'       => 'header_signup_label',
                'type'     => 'text',
                'default'  => esc_html__('Sign Up','ef5-frame'),
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
if(!function_exists('ef5frame_header_donate')){
    function ef5frame_header_donate($args = []){
        if(!class_exists('EF5Payments')) return array();
        $args = wp_parse_args($args,[
            'default' => false
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '0';
        }
        return array (
            array(
                'title'    => esc_html__('Show Donate', 'ef5-frame'),
                'subtitle' => esc_html__('Show/Hide Donate Button', 'ef5-frame'),
                'id'       => 'header_donate',
                'type'     => 'button_set',
                'options'  => $options,
                'default'  => $default_value,
            ),
            array(
                'title'    => esc_html__('Button Label', 'ef5-frame'),
                'id'       => 'header_donate_label',
                'type'     => 'text',
                'default'  => esc_html__('Donate Now','ef5-frame'),
                'required' => array('header_donate', '!=', '0')
            ),
            array(
                'title'    => esc_html__('Donate for?', 'ef5-frame'),
                'subtitle' => esc_html__('Choose default item for donate, if not, the first item will choose','ef5-frame'),
                'id'       => 'header_donate_item',
                'type'     => 'select',
                'options'  => ef5frame_list_post('ef5_donation'),
                'default'  => '',
                'required' => array('header_donate', '!=', '0')
            )
        );
    }
}

/**
 * Main Logo
*/
if(!function_exists('ef5frame_header_main_logo')){
    function ef5frame_header_main_logo($args = []){
        $args = wp_parse_args($args, [
            'subsection' => true
        ]);
        return array(
            'title'      => esc_html__('Logo', 'ef5-frame'),
            'icon'       => 'el-icon-picture',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'             => 'logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Logo', 'ef5-frame'),
                    'subtitle'       => esc_html__('Choose your logo. If not set, default Logo will be used', 'ef5-frame')
                ),
                array(
                    'id'       => 'logo_size',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'ef5-frame'),
                    'subtitle' => esc_html__('Enter size (width x height) for your logo, just in case the logo is too large. If not set, default size will be used', 'ef5-frame'),
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
if(!function_exists('ef5frame_header_page_logo')){
    function ef5frame_header_page_logo($args = []){
        $args = wp_parse_args($args, [
            'subsection' => true
        ]);
        return array(
            'title'      => esc_html__('Logo', 'ef5-frame'),
            'icon'       => 'el-icon-picture',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'             => 'logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Main Logo', 'ef5-frame'),
                    'subtitle'       => esc_html__('Choose your logo. If not set, default Logo will be used', 'ef5-frame')
                ),
                array(
                    'id'             => 'sticky_logo',
                    'type'           => 'media',
                    'library_filter' => array('gif','jpg','jpeg','png','svg'),
                    'title'          => esc_html__('Sticky Logo', 'ef5-frame'),
                    'subtitle'       => esc_html__('Choose your sticky logo. If not set, default Logo will be used', 'ef5-frame')
                ),
                array(
                    'id'       => 'logo_size',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'ef5-frame'),
                    'subtitle' => esc_html__('Enter size (width x height) for your logo, just in case the logo is too large. If not set, default size will be used', 'ef5-frame'),
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
if(!function_exists('ef5frame_ontop_header_opts')){
    function ef5frame_ontop_header_opts($args = []){
        $args = wp_parse_args($args, [
            'default'    => false,
            'subsection' => true
        ]);
        $force_output = $args['default'] ? true : false;
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '0';
        }
        return array(
            'title'      => esc_html__('On Top Header', 'ef5-frame'),
            'icon'       => 'el-icon-credit-card ',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'       => 'header_ontop',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Header On top', 'ef5-frame'),
                    'subtitle' => esc_html__('Header will be on top when applicable.', 'ef5-frame'),
                    'options'  => $options,
                    'default'  => $default_value
                ),
                array(
                    'id'       => 'header_ontop_top_space',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Top Space', 'ef5-frame'),
                    'subtitle' => esc_html__('Add a space from top to header', 'ef5-frame'),
                    'units'    => array('px'),
                    'width'    => false,
                    'default'  => array(),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('On top Logo', 'ef5-frame'),
                    'subtitle' => esc_html__('Custon Logo', 'ef5-frame'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo',
                    'type'     => 'media',
                    'title'    => esc_html__('On top Logo', 'ef5-frame'),
                    'subtitle' => esc_html__('If not set, default logo will be used.', 'ef5-frame'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_logo_maxh',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'ef5-frame'),
                    'subtitle' => esc_html__('Enter size for your logo in on top header, just in case the logo is too large. If not set, default size will be used', 'ef5-frame'),
                    'units'     => array('px'),
                    'default'  => array(),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'ontop_header_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Header Design', 'ef5-frame'),
                    'subtitle' => esc_html__('Custom on top header style like: background, color, space, ...', 'ef5-frame'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'     => 'ontop_header_bg',
                    'type'   => 'color_rgba',
                    'title'  => esc_html__('Background', 'ef5-frame'),
                    'output' => array(
                        'background-color' => '.header-ontop'
                    ),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'          => 'ontop_header_text_color',
                    'type'        => 'color_rgba',
                    'title'       => esc_html__('Text Color', 'ef5-frame'),
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
                    'title' => esc_html__('Link colors', 'ef5-frame'),
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'header_ontop_border',
                    'type'     => 'border',
                    'all'      => false,
                    'color'    => false,
                    'title'    => esc_html__('Border Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Add your custom border design', 'ef5-frame'),
                    'output'   => array('.header-ontop'),
                    'force_output' => $force_output,
                    'required' => array('header_ontop', '=', '1')
                ),
                array(
                    'id'       => 'header_ontop_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__('Border Color', 'ef5-frame'),
                    'subtitle' => esc_html__('Add your custom border color', 'ef5-frame'),
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
if(!function_exists('ef5frame_sticky_header_opts')){
    function ef5frame_sticky_header_opts($args=[]){
        $args = wp_parse_args($args, [
            'default'    => false,
            'subsection' => true
        ]);
        if($args['default']){
            $options = array(
                '-1' => esc_html__('Default','ef5-frame'),
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '-1';
        } else {
            $options = array(
                '1'  => esc_html__('Yes','ef5-frame'),
                '0'  => esc_html__('No','ef5-frame'),
            );
            $default_value = '0';
        }
        return array(
            'title'      => esc_html__('Sticky Header', 'ef5-frame'),
            'icon'       => 'el-icon-credit-card ',
            'subsection' => $args['subsection'],
            'fields'     => array(
                array(
                    'id'       => 'header_sticky',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Sticky Header', 'ef5-frame'),
                    'subtitle' => esc_html__('Header will be sticked when applicable.', 'ef5-frame'),
                    'options'  => $options,
                    'default'  => $default_value
                ),
                array(
                    'id'       => 'sticky_logo_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Sticky Logo', 'ef5-frame'),
                    'subtitle' => esc_html__('Custon Logo', 'ef5-frame'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_logo',
                    'type'     => 'media',
                    'title'    => esc_html__('Sticky Header Logo', 'ef5-frame'),
                    'subtitle' => esc_html__('If not set, default logo will be used.', 'ef5-frame'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_logo_maxh',
                    'type'     => 'dimensions',
                    'title'    => esc_html__('Logo Size', 'ef5-frame'),
                    'subtitle' => esc_html__('Enter size for your logo on sticky header, just in case the logo is too large.', 'ef5-frame'),
                    'units'     => array('px'),
                    'default'  => array(),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'sticky_header_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Sticky Header Design', 'ef5-frame'),
                    'subtitle' => esc_html__('Custom sticky header style like: background, color, space, ...', 'ef5-frame'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'     => 'sticky_header_bg',
                    'type'   => 'color_rgba',
                    'title'  => esc_html__('Background', 'ef5-frame'),
                    'output' => array(
                        'background-color' => '.header-sticky'
                    ),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'          => 'sticky_header_text_color',
                    'type'        => 'color_rgba',
                    'title'       => esc_html__('Text Color', 'ef5-frame'),
                    'default'     => '',
                    'output'      => array('.header-sticky'),
                    'required' => array('header_sticky','=', '1')
                ),
                array(
                    'id'    => 'sticky_link_colors',
                    'type'  => 'link_color',
                    'title' => esc_html__('Link colors', 'ef5-frame'),
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
                    'title'    => esc_html__('Border Style', 'ef5-frame'),
                    'subtitle' => esc_html__('Add your custom border design', 'ef5-frame'),
                    'output'   => array('.header-sticky'),
                    'required' => array('header_sticky', '=', '1')
                ),
                array(
                    'id'       => 'header_sticky_border_color',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__('Border Color', 'ef5-frame'),
                    'subtitle' => esc_html__('Add your custom border color', 'ef5-frame'),
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
if(!function_exists('ef5frame_page_title_opts')){
    function ef5frame_page_title_opts($args=[]){
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
            '1'  => esc_html__('Show','ef5-frame'), 
            '0'  => esc_html__('Hide','ef5-frame'), 
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
                'title'    => esc_html__('Custom Title', 'ef5-frame'),
                'subtitle' => esc_html__('Use custom title for this page. The default title will be used on document title.', 'ef5-frame')
            );

            $custom_desc = array(
                'id'       => 'custom_desc',
                'type'     => 'textarea',
                'title'    => esc_html__('Custom description', 'ef5-frame'),
                'subtitle' => esc_html__('Show custom page description under page title', 'ef5-frame')
            );

            $breadcrumb_on_opts = [
                '-1'  => esc_html__('Default','ef5-frame')
            ] + $breadcrumb_on_opts;
        }
        return array(
            array(
                'id'       => 'ptitle_layout',
                'type'     => 'image_select',
                'title'    => esc_html__('Layout', 'ef5-frame'),
                'subtitle' => esc_html__('Select a layout for page title.', 'ef5-frame'),
                'options'  => $ptitle_layout,
                'default'  => $default_value
            ),
            $custom_title,
            $custom_desc,
            array(
                'id'           => 'ptitle_color',
                'type'         => 'color_rgba',
                'title'        => esc_html__('Title Color', 'ef5-frame'),
                'subtitle'     => esc_html__('Page title color.', 'ef5-frame'),
                'output'       => array(
                    'color' => '.ef5-pagetitle .page-title'
                ),
                'force_output' => $force_output,
                'default'      => ''
            ),
            array(
                'id'       => 'ptitle_parallax',
                'type'     => 'media',
                'title'    => esc_html__('Parallax Image', 'ef5-frame'),
                'subtitle' => esc_html__('Choose your image', 'ef5-frame'),
            ),
            array(
                'id'       => 'ptitle_parallax_overlay',
                'type'     => 'color_rgba',
                'title'    => esc_html__('Parallax Overlay Color', 'ef5-frame'),
                'subtitle' => esc_html__('Add parallax overlay color.', 'ef5-frame'),
                'output'   => array(
                    'background-color' => '.ef5-pagetitle .parallax:before'
                ),
                'force_output' => $force_output,
                'default'      => ''
            ),
            array(
                'id'           => 'ptitle_paddings',
                'type'         => 'spacing',
                'title'        => esc_html__('Paddings', 'ef5-frame'),
                'subtitle'     => esc_html__('Enter inner space.', 'ef5-frame'),
                'mode'         => 'padding',
                'units'        => array('px'),
                'output'       => array('#ef5-page .ef5-pagetitle'),
                'force_output' => $force_output,
                'default'      => array()
            ),
            array(
                'id'           => 'ptitle_margins',
                'type'         => 'spacing',
                'title'        => esc_html__('Margin', 'ef5-frame'),
                'subtitle'     => esc_html__('Enter outer space.', 'ef5-frame'),
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
                'title'   => esc_html__('Breadcrumb', 'ef5-frame'),
                'default' => $default_value
            ),
            array(
                'id'          => 'breadcrumb_color',
                'type'        => 'color',
                'title'       => esc_html__('Breadcrumb Text Color', 'ef5-frame'),
                'subtitle'    => esc_html__('Select text color for breadcrumb', 'ef5-frame'),
                'transparent' => false,
                'output'      => array('.ef5-pagetitle-wrap .breadcrumb'),
                'force_output'=> $force_output,
                'required'    => array('breadcrumb_on', '=', true)
            ),
            array(
                'id'           => 'breadcrumb_link_colors',
                'type'         => 'link_color',
                'title'        => esc_html__('Breadcrumb Link Colors', 'ef5-frame'),
                'subtitle'     => esc_html__('Select link colors for breadcrumb', 'ef5-frame'),
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
function ef5frame_sidebar_position_opts($default = false){
    $options_default = array('-1' => esc_html__('Default','ef5-frame'));
    $options =  array(
        'none'   => esc_html__('No Widget', 'ef5-frame'),
        'center' => esc_html__('No Widget - Content Center', 'ef5-frame'),
        'left'   => esc_html__('Left', 'ef5-frame'),
        'right'  => esc_html__('Right', 'ef5-frame'),
        'bottom' => esc_html__('Below Content', 'ef5-frame')
    );
    if($default)
        return $options_default+$options;
    else 
        return $options;
}

/* Page Options */
if(!function_exists('ef5frame_page_opts')){
    function ef5frame_page_opts($default = false){
        $default_value = ef5frame_page_sidebar_position();
        if($default){
            $default_value = '-1';
        }
        return array(
            array(
                'id'       => 'page_sidebar_pos',
                'type'     => 'button_set',
                'title'    => esc_html__('Layouts', 'ef5-frame'),
                'subtitle' => esc_html__('select a layout for single...', 'ef5-frame'),
                'options'  => ef5frame_sidebar_position_opts($default),
                'default'  => $default_value
            )
        );
    }
}

/**
 * WooCommerce Options
*/
if(!function_exists('ef5frame_woocommerce_theme_opts')){
    function ef5frame_woocommerce_theme_opts($default = false){
        $gallery_layout = $gallery_thumb_position        = array();
        $default_value          = 'none';
        $default_gallery_layout = 'simple';
        $default_gallery_thumb_position = 'thumb-right';
        if($default){
            $gallery_layout['-1']         = esc_html__('Default','ef5-frame');
            $gallery_thumb_position['-1'] = esc_html__('Default','ef5-frame');
            $default_value                = '-1';
            $default_gallery_layout       = '-1';
            $default_gallery_thumb_position       = '-1';
        }
        $gallery_layout['simple']     = esc_html__('Simple', 'ef5-frame');
        $gallery_layout['thumbnail_v'] = esc_html__('Thumbnail Vertical', 'ef5-frame');
        $gallery_layout['thumbnail_h'] = esc_html__('Thumbnail Horizontal', 'ef5-frame');

        $gallery_thumb_position['thumb-left'] = esc_html__('Left','ef5-frame');
        $gallery_thumb_position['thumb-right'] = esc_html__('Right','ef5-frame');

        return array(
            'title'      => esc_html__('WooCommerce', 'ef5-frame'),
            'icon'       => 'el el-shopping-cart',
            'subsection' => false,
            'fields'     => array(
                array(
                    'id'       => 'loop_product_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Loop Products Design', 'ef5-frame'),
                    'subtitle' => esc_html__('Custom products design, ...', 'ef5-frame'),
                ),
                array(
                    'id'       => 'products_per_page',
                    'type'     => 'slider',
                    'title'    => esc_html__('Number Products', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose number products to show on archive page, ...', 'ef5-frame'),
                    'default'   => 12,
                    'min'       => 1,
                    'step'      => 1,
                    'max'       => 50,
                    'display_value' => 'label'
                ),
                array(
                    'id'       => 'products_columns',
                    'type'     => 'slider',
                    'title'    => esc_html__('Products Columns', 'ef5-frame'),
                    'subtitle' => esc_html__('Choose products columns show on archive page, ...', 'ef5-frame'),
                    'default'   => 4,
                    'min'       => 1,
                    'step'      => 1,
                    'max'       => 6,
                    'display_value' => 'label'
                ),
                array(
                    'id'       => 'shop_sidebar_pos',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'ef5-frame'),
                    'subtitle' => esc_html__('select a layout for products page', 'ef5-frame'),
                    'options'  => ef5frame_sidebar_position_opts(),
                    'default'  => ef5frame_shop_sidebar_position()
                ),
                array(
                    'id'       => 'single_product_design',
                    'type'     => 'info',
                    'style'    => 'success',
                    'title'    => esc_html__('Single Product Design', 'ef5-frame'),
                    'subtitle' => esc_html__('Custom single product design, ...', 'ef5-frame'),
                ),
                array(
                    'id'       => 'product_gallery_layout',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'ef5-frame'),
                    'subtitle' => esc_html__('select a layout for single...', 'ef5-frame'),
                    'options'  => $gallery_layout,
                    'default'  => $default_gallery_layout
                ),
                array(
                    'id'       => 'product_gallery_thumb_position',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Thumbnail Position', 'ef5-frame'),
                    'subtitle' => esc_html__('select a position for gallery thumbnail', 'ef5-frame'),
                    'options'  => $gallery_thumb_position,
                    'default'  => $default_gallery_thumb_position,
                    'required' => array(
                        array('product_gallery_layout', '=', 'thumbnail_v')
                    )
                ),
                array(
                    'id'       => 'product_share_on',
                    'title'    => esc_html__('Share', 'ef5-frame'),
                    'subtitle' => esc_html__('Show share product to some socials network on each post.', 'ef5-frame'),
                    'type'     => 'switch',
                    'default'  => '0',
                ),
                array(
                    'id'       => 'product_sidebar_pos',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'ef5-frame'),
                    'subtitle' => esc_html__('select a layout for single product page', 'ef5-frame'),
                    'options'  => ef5frame_sidebar_position_opts(),
                    'default'  => ef5frame_product_sidebar_position()
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
if(!function_exists('ef5frame_footer_opts')){
    function ef5frame_footer_opts($args = []){
        $args = wp_parse_args($args, [
            'default' => false
        ]);
        $default_value = $args['default'] ? '-1' : '';
        $force_output  = $args['default'] ? true : false;
        return array(
            'title'  => esc_html__('Footer', 'ef5-frame'),
            'icon'   => 'el el-website',
            'fields' => array(
                array(
                    'id'          => 'footer_layout',
                    'type'        => 'image_select',
                    'title'       => esc_html__('Layout', 'ef5-frame'),
                    'subtitle'    => esc_html__('Select a layout for upper footer area.', 'ef5-frame'),
                    'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','ef5-frame'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=ef5_footer' ) ) . '">','</a>'),
                    'placeholder' => esc_html__('Default','ef5-frame'),
                    'options'     => ef5frame_list_post_thumbnail('ef5_footer', $args['default']),
                    'default'     => $default_value
                ),
                array(
                    'id'             => 'footer_margin',
                    'type'           => 'spacing',
                    'mode'           => 'margin',
                    'units'          => array('px'),
                    'units_extended' => 'false',
                    'title'          => esc_html__('Footer margin', 'ef5-frame'),
                    'subtitle'       => esc_html__('Enter outer space', 'ef5-frame'),
                    'force_output'   => $force_output,
                    'output'         => array(
                        '#ef5-footer'
                    )
                ),
            )
        );
    }
}