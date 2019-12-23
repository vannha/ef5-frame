<?php
/**
 * Remove all defautl product data to make new html output structure
*/
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

/**
 * rewrite html  output
*/
if(!function_exists('overcome_woocommerce_shop_loop_products')){
	add_action('woocommerce_before_shop_loop_item','overcome_woocommerce_shop_loop_products', 0);
	function overcome_woocommerce_shop_loop_products(){
	?>
		<div class="ef5-loop-products ef5-box-shadow transition hoverdir-wrap push text-center">
			<?php do_action('overcome_woocommerce_before_shop_loop_products_inner') ?>
			<div class="ef5-loop-products-inner">
				<?php do_action('overcome_woocommerce_shop_loop_products'); ?>
			</div>
			<?php do_action('overcome_woocommerce_after_shop_loop_products_inner') ?>
		</div>
	<?php
	}
}

/**
 * Loop Product Images
 * Add loop product image wrapped in a div 
 * animate style: push, slide,slide-top, fade-in
 *
*/
if(!function_exists('overcome_woocommerce_loop_product_thumbnail')){
	add_action('overcome_woocommerce_shop_loop_products','overcome_woocommerce_loop_product_thumbnail',1);
	function overcome_woocommerce_loop_product_thumbnail(){
		global $product;
		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $gallery   = get_post_meta( $product->get_id(), '_product_image_gallery', true );
        $hover_img = woocommerce_get_product_thumbnail();
        if ( ! empty( $gallery ) ) {
            $gallery        = explode( ',', $gallery );
            $first_image_id = $gallery[0];
            $hover_img      = wp_get_attachment_image( $first_image_id,
                $image_size,
                false,
                array( 'class' => 'hover-image') );
        }
	?>
		<div class="ef5-wc-loop-images">
			<div class="ef5-wc-loop-before-img"><?php do_action('overcome_before_woocommerce_loop_product_thumbnail'); ?></div>
			<div class="ef5-wc-loop-img">
				<?php 
					echo '<div class="static-content">'.woocommerce_get_product_thumbnail().'</div>';
					echo '<div class="hover-content no-padding">'.overcome_html($hover_img).'</div>';
				?>
			</div>
			<div class="ef5-wc-loop-after-img"><?php do_action('overcome_after_woocommerce_loop_product_thumbnail'); ?></div>
		</div>
	<?php
	}
}
/**
 * Loop Product Rating
*/
add_action('overcome_woocommerce_shop_loop_products','woocommerce_template_loop_rating',2);

/**
 * Change loop Product title
*/
if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	add_action('overcome_woocommerce_shop_loop_products', 'woocommerce_template_loop_product_title', 3);
	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<div class="ef5-heading ef5-loop-product-title text-small"><a href="'.get_the_permalink().'">' . get_the_title() . '</a></div>';
	}
}

/**
 * Loop Product Price
*/
if(!function_exists('overcome_woocommerce_template_loop_price')){
	add_action('overcome_woocommerce_shop_loop_products','overcome_woocommerce_template_loop_price',4);
	function overcome_woocommerce_template_loop_price(){
	?>
		<div class="ef5-loop-products-price ef5-heading font-style-700 text-accent"><?php
			global $product;
			$price_html = $product->get_price_html();
			printf('%1$s', $product->get_price_html());
		?></div>
	<?php
	}
}

/**
 * Loop Product Add to cart
*/
if(!function_exists('overcome_woocommerce_loop_product_add_to_cart')){
	add_action('overcome_woocommerce_shop_loop_products','overcome_woocommerce_loop_product_add_to_cart',99);
	add_action('overcome_woocommerce_loop_product_add_to_cart', 'woocommerce_template_loop_add_to_cart');
	function overcome_woocommerce_loop_product_add_to_cart(){
		?>
		<div class="ef5-loop-product-add-to-cart">
			<?php do_action('overcome_woocommerce_loop_product_add_to_cart'); ?>
		</div>
		<?php
	}
}

/**
 * Change loop add_to_cart button class
 *
*/
/**
 * Filter just the args for adding a custom css class or data attribute
 * @example add_filter( 'woocommerce_loop_add_to_cart_args', 'filter_woocommerce_loop_add_to_cart_args', 10, 2 );
 */
function filter_woocommerce_loop_add_to_cart_args( $args, $product ) {
	$args['class'] = str_replace('button', 'btn', $args['class']);
	$args['attributes']['data-ef5'] = 'value';
	return $args;
}
/**
 * Filter change html output structure
 * Just add span tag
 * @example add_filter('woocommerce_loop_add_to_cart_link', 'overcome_woocommerce_loop_add_to_cart_link', 10, 3);
*/
function overcome_woocommerce_loop_add_to_cart_link( $html, $product, $args=[]){
	$args = wp_parse_args($args, [
        'attributes'=>[]
    ]);
	$html = sprintf( '<a href="%s" data-quantity="%s" class="%s" %s><span>%s</span></a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	);
	return $html;
}

/**
 * Override loop template and show quantities next to add to cart buttons
 * @example add_filter( 'woocommerce_loop_add_to_cart_link', 'overcome_quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
 */

function overcome_quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
		$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';
		$html .= '</form>';
	}
	return $html;
}