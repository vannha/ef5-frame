<?php
/**
 * Add Header Popup Nav Icon
 * @since 1.0
*/
if(!function_exists('ef5frame_header_popup_nav_icon')){
	function ef5frame_header_popup_nav_icon($args = []){
		$header_popup_nav = ef5frame_get_opts('header_popup_nav', '0');
		$header_popup_menu = ef5frame_get_opts('header_popup_menu', '0');
		if('0' === $header_popup_nav || 'none' === $header_popup_menu) return;

		if('-1' === ef5frame_get_page_opt('header_popup_nav', '-1'))
			$icon_type = ef5frame_get_theme_opt('header_popup_nav_icon_type','text');
		else
			$icon_type = ef5frame_get_opts('header_popup_nav_icon_type','text');

		$args = wp_parse_args($args, [
			'before' => '<span id="ef5-main-popup-nav" class="header-extra-icon">',
			'after'  => '</span>',
			'type'	 => $icon_type
		]);

		echo wp_kses_post($args['before']);
		switch ($args['type'] ) {
			case 'text':
				echo sprintf('<a href="#ef5-popupnav" class="ef5-header-popup tooltip nav-link" title="%s">%s</a>',
					esc_attr__('Open Menu','ef5-frame'),
					esc_html__('Menu','ef5-frame')
				);
				break;
			default:
				echo '<a href="#ef5-popupnav" class="ef5-header-popup tooltip nav-link">';
					ef5frame_header_mobile_nav_icon(['title' => esc_html__('Show Menu','ef5-frame'), 'class' => $args['type']]);
				echo '</a>';
				break;
		}
		echo wp_kses_post($args['after']);
	}
}

if(!function_exists('ef5frame_popup_nav')){
	function ef5frame_popup_nav($args = []){
		$header_popup_nav = ef5frame_get_opts('header_popup_nav', '0');
		$header_popup_menu = ef5frame_get_opts('header_popup_menu','0');
		if('0' === $header_popup_nav || 'none' === $header_popup_menu) return;
		$args = wp_parse_args($args, [
			'before' => '<div id="ef5-popupnav" class="mfp-hide text-center container">',
			'after'  => '</div>',
			'class'  => ''
		]);

		$menu_args =  array(
			'menu'                         => $header_popup_menu,
			'container'                    => 'div',
			'container_class'              => 'ef5-main-nav',
			'menu_id'                      => 'popup-nav',
			'menu_class'                   => 'popup-nav',
			'ef5frame_nav_extra_class' => 'popup-item'
		);
		if(has_nav_menu('ef5-primary')){
			$menu_args['theme_location'] = 'ef5-primary';
			$menu_args['walker'] = class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '';
		}

		echo wp_kses_post($args['before']);
			wp_nav_menu($menu_args);
			if(is_active_sidebar('sidebar-popup')){
				echo '<div id="sidebar-popup" class="text-start">';
				dynamic_sidebar('sidebar-popup');
				echo '</div>';
			}
		echo wp_kses_post($args['after']);
	}
}
add_action('wp_footer','ef5frame_popup_nav', 1);