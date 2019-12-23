<?php
/**
 * Footer Function
*/
if(!function_exists('ef5frame_footer')){
	function ef5frame_footer(){
		$footer_layout = ef5frame_get_opts('footer_layout','');
		if(ef5frame_have_post('ef5_footer') && $footer_layout !== ''){
		$footer_title = sanitize_title(get_the_title(ef5frame_get_id_by_slug($footer_layout, 'ef5_footer')));
	?>
		<footer id="ef5-footer" class="ef5-footer-area ef5-footer-builder <?php echo esc_attr($footer_title);?>">
			<?php ef5frame_content_by_slug($footer_layout, 'ef5_footer'); ?>
		</footer>
	<?php
		} else {
			ef5frame_footer_default();
		}
	}
}

/*
 * Default Footer 
 * 
 * Just show when system plugin not actived
 *
*/
if(!function_exists('ef5frame_footer_default')){
	function ef5frame_footer_default(){
	?>
	<footer id="ef5-footer" class="ef5-footer-area ef5-footer-default">
		<div class="ef5-footer-inner container text-center">
			<?php
		printf( esc_html__('&copy; %s %s by %s. All Rights Reserved.','ef5-frame'), date('Y') , get_bloginfo('name'), '<a href="'.esc_url('https://themeforest.net/user/SpyroPress').'">'.esc_html__('SpyroPress','ef5-frame').'</a>'); ?>
		</div>
	</footer>
	<?php
	}
}
/**
 * Default Footer
 *
 * Default Copyright text
 *
*/
if(!function_exists('ef5frame_default_copyright_text')){
	function ef5frame_default_copyright_text(){
		printf( esc_html__('&copy; %s %s by %s. All Rights Reserved.','ef5-frame'), date('Y') , get_bloginfo('name'), '<a href="'.esc_url('https://themeforest.net/user/SpyroPress').'">'.esc_html__('SpyroPress','ef5-frame').'</a>');
	}
}

/**
 * Back to Top 
*/
function ef5frame_backtotop(){
	$show_btt = ef5frame_get_opts('back_totop_on','0');
	if($show_btt === '0') return;
	?>
		<div class="ef5-backtotop"><div id="ef5-btt-btn" class="ef5-btt-btn"><div id="ef5-btt-container" class="ef5-btt-container"><div id="ef5-btt-border" class="ef5-btt-border"><div id="ef5-btt-circle" class="ef5-btt-circle"><span class="fa fa-long-arrow-up"></span></div></div></div></div></div>
	<?php
}
add_action('wp_footer','ef5frame_backtotop', 99);