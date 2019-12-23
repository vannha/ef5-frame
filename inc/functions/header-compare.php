<?php
/**
 * Header WC Compare
 * Need WooCommerce and WooCommerce Smart Compare to work 
 * https://wordpress.org/plugins/woo-smart-compare/
 * @since 1.0.0
*/
if(!function_exists('overcome_header_compare')){
	function overcome_header_compare($args = []){
		$args = wp_parse_args($args, [
			'before' => '',
			'after'  => '', 
			'icon'	 => 'fal fa-random'
		]);
		$show_compare = overcome_get_opts('header_wishlist', '0');
		if(!class_exists( 'WooCommerce' ) || !class_exists('WPcleverWooscp') || '0' === $show_compare) return;
		$_wooscp_open_button = str_replace(array('.','#'),'',get_option('_wooscp_open_button','ef5-header-compare-icon'));
		echo wp_kses_post($args['before']);
	?>
		<span class="wooscp-menu-item menu-item-type-wooscp"><a href="javascript:void(0);" class="<?php echo esc_attr($_wooscp_open_button);?>  header-icon has-badge"><span class="<?php echo esc_attr($args['icon']); ?>"></span><span class="header-count wooscp-menu-item-inner" data-count="0"></span></a></span>
	<?php
		echo wp_kses_post($args['after']);
	}
}
