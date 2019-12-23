<?php
if(!function_exists('overcome_woocommerce_get_price_html')){
	add_filter('woocommerce_get_price_html', 'overcome_woocommerce_get_price_html', 10, 1);
	function overcome_woocommerce_get_price_html($price){
		$class = is_singular('product') ? 'single' : 'loop';
		return '<div class="ef5-products-price '.esc_attr($class).'">'.$price.'</div>';
	}
}