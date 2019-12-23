<?php
/**
 * Build Single Product Gallery and Summary layout 
 *
*/

if(!function_exists('overcome_woocommerce_before_single_product_summary')){
	add_action('woocommerce_before_single_product_summary','overcome_woocommerce_before_single_product_summary', 0);
	function overcome_woocommerce_before_single_product_summary(){
		$classes = ['ef5-wc-img-summary', overcome_get_opts('product_gallery_layout','simple')];
		echo '<div class="'.trim(implode(' ', $classes)).'">';
	}
}
if(!function_exists('overcome_woocommerce_after_single_product_summary')){
	add_action('woocommerce_after_single_product_summary','overcome_woocommerce_after_single_product_summary', 0);
	function overcome_woocommerce_after_single_product_summary(){
		echo '</div>';
	}
}

/**
 * Wrap Product Image / Gallery in a Div
 * add new acction to add new content
 * new acction: overcome_before_single_product_gallery, overcome_after_single_product_gallery
*/
add_action('woocommerce_before_single_product_summary', function() {
	echo '<div class="ef5-product-gallery-wrap"><div class="ef5-product-gallery-inner">';
}, 0);
add_action('woocommerce_before_single_product_summary', function() { 
	do_action('overcome_before_single_product_gallery');
}, 1);
add_action('woocommerce_before_single_product_summary', function() { 
	do_action('overcome_after_single_product_gallery');
}, 999);
add_action('woocommerce_before_single_product_summary', function() {
	echo '</div></div>';
}, 1000);

/**
 * Wrap gallery in div
*/
if(!function_exists('overcome_woocommerce_single_gallery')){
	/**
	 * Add product attributes to inside gallery
	 * 
	 * add product badge: hot, new, sale, ...
	 * Hook: woocommerce_product_thumbnails
	*/
	remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10);
	remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_images', 20);

	add_action('woocommerce_before_single_product_summary','overcome_woocommerce_single_gallery', 1);
	add_action('overcome_woocommerce_single_gallery', 'overcome_woocommerce_sale', 1);
	add_action('overcome_woocommerce_single_gallery', 'overcome_woocommerce_show_product_loop_badges', 2);
	add_action('overcome_woocommerce_single_gallery', 'woocommerce_show_product_images', 3);

	function overcome_woocommerce_single_gallery(){
		$class = overcome_get_opts('product_gallery_thumb_position', 'thumb-right');
		?>
		<div class="ef5-single-product-gallery-wraps <?php echo esc_attr($class);?>">
		<div class="ef5-single-product-gallery-wraps-inner">
			<?php do_action('overcome_woocommerce_single_gallery'); ?>
		</div>
		</div>
		<?php
	}
}

/**
 * Add Custom CSS class to Gallery
*/
add_filter('woocommerce_single_product_image_gallery_classes','overcome_woocommerce_single_product_image_gallery_classes');
function overcome_woocommerce_single_product_image_gallery_classes($class){
	$class[] = 'ef5-'.overcome_get_opts('product_gallery_layout', 'simple');
	$class[] = overcome_get_opts('product_gallery_thumb_position', 'thumb-right');
	return $class;
}

/**
 * Single Product 
 *
 * Gallery style with thumbnail carousel in bottom
 *
*/
if(!function_exists('overcome_wc_single_product_gallery_layout')){
	add_filter('woocommerce_single_product_carousel_options', 'overcome_wc_single_product_gallery_layout' );
    function overcome_wc_single_product_gallery_layout($options){
        $gallery_layout = overcome_get_opts('product_gallery_layout', 'simple');

        $options['prevText']     = '<span class="flex-prev-icon"></span>';
		$options['nextText']     = '<span class="flex-next-icon"></span>';

        switch ($gallery_layout) {
	        case 'thumbnail_v':
				$options['directionNav'] = true;
				$options['controlNav']   = false;
	            $options['sync'] = '.wc-gallery-sync';
	            break;
	    
	        case 'thumbnail_h':
	            $options['directionNav'] = true;
				$options['controlNav']   = false;
	            $options['sync'] = '.wc-gallery-sync';
	            break;
	    }
	    return $options;
    }
}

/**
 * Single Product Gallery
 *
 * Add thumbnail product gallery 
 *
*/
if(!function_exists('overcome_product_gallery_thumbnail_sync')){
	add_action('overcome_after_single_product_gallery', 'overcome_product_gallery_thumbnail_sync');
	function overcome_product_gallery_thumbnail_sync($args=[]){
		global $product;
		$gallery_layout = overcome_get_opts('product_gallery_layout', 'simple');
		$product_gallery_thumb_position = overcome_get_opts('product_gallery_thumb_position', 'thumb-right');
        $args = wp_parse_args($args, [
            'gallery_layout' => $gallery_layout
        ]);
        $post_thumbnail_id = $product->get_image_id();
    	$attachment_ids = array_merge( (array)$post_thumbnail_id , $product->get_gallery_image_ids() );

        if('simple' === $args['gallery_layout'] || empty($attachment_ids[0])) return;
        $flex_class = '';

        $thumb_v_w = overcome_configs('overcome_product_gallery_thumbnail_v_w');
        $thumb_v_h = overcome_configs('overcome_product_gallery_thumbnail_v_h');

        $thumb_h_w = round((overcome_configs('overcome_product_single_image_w') - overcome_configs('overcome_product_gallery_thumbnail_space')*4)/4);
        $thumb_h_h = overcome_configs('overcome_product_gallery_thumbnail_h_h');

        $thumb_margin = overcome_configs('overcome_product_gallery_thumbnail_space');

        switch ($args['gallery_layout']) {
	        case 'thumbnail_v':
				$thumbnail_size = $thumb_v_w.'x'.$thumb_v_h;
				$thumb_w        = $thumb_v_w;
				$thumb_h        = $thumb_v_h;
				$flex_class     = 'flex-vertical';
	            break;
	    
	        case 'thumbnail_h':
	            $thumbnail_size = $thumb_h_w.'x'.$thumb_h_h;
	            $thumb_w = $thumb_h_w;
	            $thumb_h = $thumb_h_h;
	            $flex_class = 'flex-horizontal';
	            break;

	    }
	    $gallery_css_class = ['wc-gallery-sync', $gallery_layout, $product_gallery_thumb_position];
    ?>
    	<div class="<?php echo trim(implode(' ', $gallery_css_class));?>" data-thumb-w="<?php echo esc_attr($thumb_w);?>" data-thumb-h="<?php echo esc_attr($thumb_h);?>" data-thumb-margin="<?php echo esc_attr($thumb_margin); ?>">
			<div class="wc-gallery-sync-slides flexslider <?php echo esc_attr($flex_class);?>">
	            <?php foreach ( $attachment_ids as $attachment_id ) { ?>
	                <div class="wc-gallery-sync-slide flex-control-thumb"><?php overcome_image_by_size(['id' => $attachment_id, 'size' => $thumbnail_size]);?></div>
	            <?php } ?>
	        </div>
	    </div>
    <?php
	}
}

/*
 * Single Product title
*/
if ( ! function_exists( 'woocommerce_template_single_title' ) ) {

	/**
	 * Output the product title.
	 */
	function woocommerce_template_single_title() {
		the_title( '<div class="product-single-title ef5-heading h2">', '</div>' );
	}
}
/**
 * Single Product Price
**/
if ( ! function_exists( 'woocommerce_template_single_price' ) ) {
	/**
	 * Output the product price.
	 */
	function woocommerce_template_single_price() {
		global $product;
		echo overcome_html($product->get_price_html());
	}
}
/**
 * Single Product Quantity Form
*/
if(!function_exists('overcome_woocommerce_quantity_input_args')){
	add_filter('woocommerce_quantity_input_args','overcome_woocommerce_quantity_input_args');
	function overcome_woocommerce_quantity_input_args($args){
		$args['product_name'] = '';
		return $args;
	}
}
/**
 * Single Product Meta
*/
if ( ! function_exists( 'woocommerce_template_single_meta' ) ) {

	/**
	 * Output the product meta.
	 */
	function woocommerce_template_single_meta() {
		global $product;
	?>
	<div class="ef5-product-meta">
		<?php do_action( 'woocommerce_product_meta_start' ); ?>

		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

			<span class="ef5-sku-wrapper meta-item">
				<span class="ef5-heading font-style-700 text-uppercase"><?php esc_html_e( 'SKU:', 'overcome' ); ?></span> <span class="sku"><?php if($sku = $product->get_sku() ) echo esc_html( $sku); else  echo esc_html__( 'N/A', 'overcome' ); ?></span>
			</span>

		<?php endif; ?>

		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted-in meta-item"><span class="ef5-heading font-style-700 text-uppercase">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'overcome' ) . '</span> ', '</span>' ); ?>

		<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged-as meta-item"><span class="ef5-heading font-style-700 text-uppercase">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'overcome' ) . '</span> ', '</span>' ); ?>

		<?php do_action( 'woocommerce_product_meta_end' ); ?>

	</div>
	<?php
	}
}
// Product meta share
if(!function_exists('overcome_woocommerce_product_meta_end')){
	add_action('woocommerce_product_meta_end','overcome_woocommerce_product_meta_end', 0);
	function overcome_woocommerce_product_meta_end(){
		$show_share = overcome_get_theme_opt( 'product_share_on', '0');
		if(!$show_share) return;
        wp_enqueue_script('sharethis');
        global $product;
        $url   = get_the_permalink();
        $image = get_the_post_thumbnail_url($product->get_id());
        $title = get_the_title();
		?>
		<span class="meta-item">
			<span class="ef5-heading font-style-700 text-uppercase"><?php esc_html_e('Share:','overcome'); ?></span>
			<span class="meta-share">
                <a data-hint="<?php esc_attr_e('Share this post to Facebook','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="facebook" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce facebook st-custom-button"><span class="fab fa-facebook-f"></span></a>
                <a data-hint="<?php esc_attr_e('Share this post to Twitter','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="twitter" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce twitter st-custom-button"><span class="fab fa-twitter"></span></a>
                <a data-hint="<?php esc_attr_e('Share this post to Google Plus','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="googleplus" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce googleplus st-custom-button"><span class="fab fa-google-plus"></span></a>
                <a data-hint="<?php esc_attr_e('Share this post to Pinterest','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="pinterest" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce pinterest st-custom-button"><span class="fab fa-pinterest"></span></a>
                <a data-hint="<?php esc_attr_e('Share this post to','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="sharethis" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce sharethis st-custom-button"><span class="fa fa-share-alt"></span></a>
			</span>
		</span>
		<?php
	}
}

/**
 * Product Tabs
 * 
 * remove description/additional info heading
*/
add_filter('woocommerce_product_description_heading', function(){ return false;});
add_filter('woocommerce_product_additional_information_heading', function(){ return false;});


/*
 * Change column of related product
 * https://docs.woocommerce.com/document/change-number-of-related-products-output/
*/
if(!function_exists('overcome_woocommerce_output_related_products_args')){
	add_filter( 'woocommerce_output_related_products_args', 'overcome_woocommerce_output_related_products_args', 20 );
	function overcome_woocommerce_output_related_products_args($args){
		$args['posts_per_page'] = overcome_loop_shop_columns()*2; // 4 related products
		$args['columns'] = overcome_loop_shop_columns(); // arranged in overcome_loop_shop_columns columns
		return $args;
	}
}
// Add carousel to related
if(!function_exists('overcome_single_product_scripts')){
	add_action('wp_enqueue_scripts', 'overcome_single_product_scripts', 0);
	function overcome_single_product_scripts(){
		if(!is_singular('product')) return;
		wp_enqueue_script('owl-carousel');
		wp_enqueue_script('ef5-owl-carousel');
		wp_enqueue_style('owl-carousel');
		wp_enqueue_style('ef5-owl-carousel');
	}
}