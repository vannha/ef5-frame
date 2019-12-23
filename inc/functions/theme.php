<?php
// Google API Key
function ef5frame_google_api_key(){
    $api = ef5frame_get_theme_opt('google_api_key','');
    return $api;
}
add_filter('ef5-google-api-key','ef5frame_google_api_key');
/**
 * Language direction 
*/
function ef5frame_direction($return = true){
    $ef5frame_direction = is_rtl() ? 'dir-right' : 'dir-left';
    if($return)
        return $ef5frame_direction;
    else 
        echo esc_attr($ef5frame_direction);
}
/**
 * get text-align left / right for RTL language 
*/
function ef5frame_align($return = true){
    $ef5frame_align = is_rtl() ? 'right' : 'left';
    if($return)
        return $ef5frame_align;
    else 
        echo esc_attr($ef5frame_align);
}
function ef5frame_align2($return = true){
    $ef5frame_align = is_rtl() ? 'left' : 'right';
    if($return)
        return $ef5frame_align;
    else 
        echo esc_attr($ef5frame_align);
}
// Custom space
function ef5frame_spacing($mode = '',$dir = '',$space = '', $echo = true){
    if(empty($mode) || empty($space) || empty($dir)) return;
    if(is_rtl() && $dir = 'r'){
        $_dir = 'l';
    } elseif (is_rtl() && $dir = 'l') {
        $_dir = 'r';
    } else {
        $_dir = $dir;
    }
    if($echo) {
        echo esc_attr($mode.$_dir.'-'.$space);
    } else {
        return esc_attr($mode.$_dir.'-'.$space);
    }
}
// Optimize CSS class
function ef5frame_optimize_css_class($string){
    $string = preg_replace('!\s+!', ' ', $string);
    return trim($string);
}
/**
 * Page CSS Class
*/
function ef5frame_page_css_class($class = ''){
    $cls = apply_filters('ef5frame_page_css_class',[]);
    $classes = array_merge(
        [
            'ef5-page',
            'page-header-'.ef5frame_get_opts('header_layout', '1'),
            $class
        ], 
        $cls
    );
    if(ef5frame_get_opts('header_ontop', '0') === '1' || ef5frame_get_opts('header_sticky', '0') === '1'){
       $classes[] = 'page-header-ontop';
    }
    echo trim(implode(' ', $classes));
}

/*
 * Archive sidebar position 
*/
function ef5frame_archive_sidebar_position(){
    return apply_filters('ef5frame_archive_sidebar_position','bottom');
}
/*
 * Page sidebar position 
*/
function ef5frame_page_sidebar_position(){
    return apply_filters('ef5frame_page_sidebar_position','bottom');
}
/*
 * Archive content  grid column
*/
function ef5frame_archive_grid_col(){
    return apply_filters('ef5frame_archive_grid_col','8');
}
/*
 * Single Post sidebar position 
*/
function ef5frame_post_sidebar_position(){
    return apply_filters('ef5frame_post_sidebar_position','bottom');
}
/*
 * Single Portfolio sidebar position 
*/
function ef5frame_portfolio_sidebar_position(){
    return apply_filters('ef5frame_portfolio_sidebar_position','bottom');
}
/*
 * Content area css class
*/
function ef5frame_get_sidebar($check = true){
    $sidebar = 'none';
    if(is_post_type_archive('post') || is_singular('post') || is_home()){
        $sidebar = 'sidebar-main';
    } elseif (is_post_type_archive('portfolio') || is_singular('ef5_portfolio')) {
        $sidebar = 'sidebar-portfolio';
    } elseif (is_singular('ef5_stories')) {
        $sidebar = 'ef5_stories_widget';
    } elseif (is_page()) {
        if (class_exists('WooCommerce') && (is_checkout() || is_cart())) {
            $sidebar = 'sidebar-shop';
        } else {
            $sidebar = 'sidebar-page';
        }
    } elseif (class_exists('WooCommerce') && (is_woocommerce() || is_post_type_archive('product') || is_singular('product') ) ) {
        $sidebar = 'sidebar-shop';
    } elseif(class_exists('Tribe__Events__Main') && ( isset($_REQUEST['tribe_event_display']) && $_REQUEST['tribe_event_display'] === 'list') ){
        $sidebar = 'sidebar-tribe-event';
    }  elseif(class_exists('Tribe__Events__Main') && ( isset($_REQUEST['tribe_event_display']) && $_REQUEST['tribe_event_display'] !== 'list') ){
        $sidebar = 'none';
    } elseif (is_archive() || is_search()){
        $sidebar = 'sidebar-main';
    }
    if($check)
        return is_active_sidebar($sidebar);
    else 
        return $sidebar;
}
function ef5frame_sidebar_position(){
    if((is_archive() || is_post_type_archive('post') || is_home() || is_search()) && !is_post_type_archive('product')){
        $sidebar_position = ef5frame_get_opts('archive_sidebar_pos', ef5frame_archive_sidebar_position());
    } elseif(is_post_type_archive('portfolio')){
        $sidebar_position = ef5frame_get_opts('portfolio_archive_sidebar_pos', ef5frame_archive_sidebar_position());
    } elseif(is_page()){
        if (class_exists('WooCommerce') && (is_checkout() || is_cart())) {
            $sidebar_position = ef5frame_get_opts('page_sidebar_pos',ef5frame_shop_sidebar_position());
        } else {
            $sidebar_position = ef5frame_get_opts('page_sidebar_pos',ef5frame_page_sidebar_position());
        }
    } elseif (is_singular('post')) {
        $sidebar_position = ef5frame_get_opts('post_sidebar_pos',ef5frame_post_sidebar_position());
    } elseif (is_singular('ef5_portfolio')) {
        $sidebar_position = ef5frame_get_opts('portfolio_sidebar_pos',ef5frame_portfolio_sidebar_position());
    } elseif (is_singular('ef5_stories')) {
        $sidebar_position = 'ef5_stories_widget';
    } elseif (class_exists('WooCommerce') && is_post_type_archive('product')) {
        $sidebar_position = ef5frame_get_opts('shop_sidebar_pos',ef5frame_shop_sidebar_position());
    } elseif (is_singular('product')) {
        $sidebar_position = ef5frame_get_opts('product_sidebar_pos',ef5frame_product_sidebar_position());
    } elseif (class_exists('Tribe__Events__Main') && is_post_type_archive('tribe_events') && ( isset($_REQUEST['tribe_event_display']) && $_REQUEST['tribe_event_display'] === 'list') ){
        $sidebar_position = ef5frame_get_opts('trible_events_sidebar_pos','right');
    } else {
        $sidebar_position = 'none';
    }
    return $sidebar_position;
}

function ef5frame_content_css_class($class=''){
    $classes = [
        'ef5-content-area',
        $class
    ];
    $sidebar            = ef5frame_get_sidebar();
    $sidebar_position   = ef5frame_sidebar_position();
    $content_grid_class = ef5frame_get_opts('archive_grid_col', ef5frame_archive_grid_col());
    
    if( $sidebar_position === 'bottom' ){
        $classes[] = 'col-12 has-gtb';
    } else {
        if($sidebar && ('none' !== $sidebar_position || 'center' == $sidebar_position)){
            $classes[] = 'col-lg-'.$content_grid_class;
            if($sidebar_position == 'left') $classes[] = 'order-lg-1';
            if($sidebar_position == 'center') $classes[] = 'offset-lg-2';
        } else {
            $classes[] = 'col-12';
        }
    }

    echo ef5frame_optimize_css_class(implode(' ', $classes));
}
/**
 * Show Widget 
*/

function ef5frame_sidebar(){
    $sidebar            = ef5frame_get_sidebar(false);
    $sidebar_position   = ef5frame_sidebar_position();
    if($sidebar_position === 'none' || $sidebar_position === 'center') return;
    if( is_active_sidebar( $sidebar ) ) {
    ?>
        <div id="ef5-sidebar-area" class="<?php ef5frame_sidebar_css_class(); ?>">
            <div class="sidebar-inner">
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php }
}

/*
 * Widget area css class
*/
function ef5frame_sidebar_css_class($class=''){
    $classes = [
        'ef5-sidebar-area',
        $class
    ];
    if(!is_singular() || is_single() || !is_page_template()) $classes[] = 'ef5-blogs';
    $sidebar_position   = ef5frame_sidebar_position();
    if( $sidebar_position === 'bottom' ){
        $classes[] = 'col-12 has-gtb';
    } else {
        $content_grid_class = (int) ef5frame_get_opts('archive_grid_col', ef5frame_archive_grid_col());
        $sidebar_grid_class = 12 - $content_grid_class;
        $classes[] = 'col-lg-'.$sidebar_grid_class; 
    }

    echo ef5frame_optimize_css_class(implode(' ', $classes));
}