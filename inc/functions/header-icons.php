<?php
/**
 * All header icon
 *
*/
if(!function_exists('ef5frame_header_mobile_menu_icon')){
	function ef5frame_header_mobile_menu_icon(){
		$header_menu = ef5frame_get_opts('header_menu');
		if($header_menu === 'none') return;
		if('-1' === ef5frame_get_page_opt('header_mobile_nav_icon_type','icon'))
			$icon_style = ef5frame_get_theme_opt('header_mobile_nav_icon_type','icon');
		else 
			$icon_style = ef5frame_get_opts('header_mobile_nav_icon_type','icon');

		switch ($icon_style) {
			case 'text':
				echo '<span id="ef5-main-menu-mobile" class="text d-inline d-xl-none"><span class="btn-nav-mobile open-menu">'.esc_html__('Menu','ef5-frame').'</span></span>';
				break;
			default:
				ef5frame_header_mobile_nav_icon(['id' => 'ef5-main-menu-mobile','class' => 'header-icon d-inline d-xl-none']);
			break;
		}
	}
}

/**
 * Add Header Mobile Nav Icon 
 * @since 1.0
*/
if(!function_exists('ef5frame_header_mobile_nav_icon')){
	function ef5frame_header_mobile_nav_icon($args = []){
		$args = wp_parse_args($args, [
			'before'    => '',
			'after'     => '',
			'id' 		=> '',
			'class' 	=> '',
			'title'     => esc_html__('Show menu','ef5-frame')
		]);
		echo wp_kses_post($args['before']);
		$wrap_classes = ['btn-nav-mobile-wrap', $args['class']];
		$classes = ['btn-nav-mobile open-menu'];
	?>
		<span <?php if(!empty($args['id'])) : ?> id="<?php echo esc_attr($args['id']);?>" <?php endif; ?> class="<?php echo trim(implode(' ', $wrap_classes)); ?>">
	        <span class="<?php echo trim(implode(' ', $classes)); ?>" title="<?php echo esc_attr($args['title']);?>">
	            <span></span>
	        </span>
	    </span>
	<?php
		echo wp_kses_post($args['after']);
	}
}