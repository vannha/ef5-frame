<?php
/**
 * Header WC Cart 
 * @since 1.0.0
*/
if(!function_exists('overcome_header_cart')){
	function overcome_header_cart($args = []){
		if(!class_exists( 'WooCommerce' )) return;
		$args = wp_parse_args($args, [
			'before' => '',
			'after'  => '', 
			'icon'	 => 'flaticon-shopping-cart',
			'style'	 => '1'
		]);
		$show_cart = overcome_get_opts('header_cart', '0');
		if('0' === $show_cart) return;
		wp_enqueue_script( 'magnific-popup' );
 		wp_enqueue_style( 'magnific-popup' );
		$cart_classes = ['ef5-header-popup', 'ef5-header-cart-icon', 'header-icon', 'style-'.$args['style']];
		switch ($args['style']) {
			case '2':
				# code...
				break;
			default:
				$cart_classes[] = 'has-badge';
				break;
		}
		echo overcome_html($args['before']);
	?>
		<a href="#ef5-cart-popup" class="<?php echo implode(' ', $cart_classes);?>"><span class="icon <?php echo esc_attr($args['icon']);?>"><span class="header-count cart_total style-<?php echo esc_attr($args['style']);?>"><?php overcome_woocommerce_cart_counter(['style' => $args['style']]); ?></span></span></a>
	<?php
		echo overcome_html($args['after']);
	}
}
/**
 * Add Header WooCommerce Cart 
 * @since 1.0.0
 */
if(!function_exists('overcome_header_wc_cart')){
	function overcome_header_wc_cart() { 
	    if(!class_exists('WooCommerce')) return;
	    $show_cart = overcome_get_opts('header_cart', '0');
	    if('0' === $show_cart) return;
	    ?>
	    <div id="ef5-cart-popup" class="cartform mfp-hide container">
	    	<div class="row justify-content-center">
	    		<div class="col-auto">
			        <div class="widget_shopping_cart">
			            <div class="widget_shopping_cart_content">
			                <?php woocommerce_mini_cart(); ?>
			            </div>
			        </div>
			    </div>
			</div>
	    </div>
	    <?php
	}
	add_action('wp_footer', 'overcome_header_wc_cart');
}
if(!function_exists('overcome_woocommerce_add_to_cart_fragments')){
	add_filter('woocommerce_add_to_cart_fragments', 'overcome_woocommerce_add_to_cart_fragments', 10, 1 );
    function overcome_woocommerce_add_to_cart_fragments( $fragments ) {
    	if(!class_exists('WooCommerce')) return;
        ob_start();
        $header_layout = overcome_get_opts('header_layout','1');
    	switch ($header_layout) {
    		case '5':
    			$cart_style = '2';
    			break;
    		
    		default:
    			$cart_style = '1';
    			break;
    	}
        ?>
        <span class="header-count cart_total style-<?php echo esc_attr($cart_style);?>"><?php overcome_woocommerce_cart_counter(['style' => '2']); ?></span>
        <?php
        $fragments['.cart_total'] = ob_get_clean();
        return $fragments;
    }
}

if(!function_exists('overcome_woocommerce_cart_counter')){
	function overcome_woocommerce_cart_counter($args=[]){
		$args = wp_parse_args($args, [
			'style' => '1'
		]);
		switch ($args['style']) {
			case '2':
				$count = WC()->cart->cart_contents_count;
				break;
			
			default:
				$count = WC()->cart->cart_contents_count;
				break;
		}
		echo overcome_html($count);
	}
}
