<?php
// Google API Key
function overcome_google_api_key(){
    $api = overcome_get_theme_opt('google_api_key','');
    return $api;
}
add_filter('ef5-google-api-key','overcome_google_api_key');
/**
 * Language direction 
*/
function overcome_direction($return = true){
    $overcome_direction = is_rtl() ? 'dir-right' : 'dir-left';
    if($return)
        return $overcome_direction;
    else 
        echo esc_attr($overcome_direction);
}
/**
 * get text-align left / right for RTL language 
*/
function overcome_align($return = true){
    $overcome_align = is_rtl() ? 'right' : 'left';
    if($return)
        return $overcome_align;
    else 
        echo esc_attr($overcome_align);
}
function overcome_align2($return = true){
    $overcome_align = is_rtl() ? 'left' : 'right';
    if($return)
        return $overcome_align;
    else 
        echo esc_attr($overcome_align);
}
// Custom space
function overcome_spacing($mode = '',$dir = '',$space = '', $echo = true){
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
function overcome_optimize_css_class($string){
    $string = preg_replace('!\s+!', ' ', $string);
    return trim($string);
}
/**
 * Page CSS Class
*/
function overcome_page_css_class($class = ''){
    $cls = apply_filters('overcome_page_css_class',[]);
    $classes = array_merge(
        [
            'ef5-page',
            'page-header-'.overcome_get_opts('header_layout', '1'),
            $class
        ], 
        $cls
    );
    if(overcome_get_opts('header_ontop', '0') === '1' || overcome_get_opts('header_sticky', '0') === '1'){
       $classes[] = 'page-header-ontop';
    }
    echo trim(implode(' ', $classes));
}

/*
 * Archive sidebar position 
*/
function overcome_archive_sidebar_position(){
    return apply_filters('overcome_archive_sidebar_position','bottom');
}
/*
 * Page sidebar position 
*/
function overcome_page_sidebar_position(){
    return apply_filters('overcome_page_sidebar_position','bottom');
}
/*
 * Archive content  grid column
*/
function overcome_archive_grid_col(){
    return apply_filters('overcome_archive_grid_col','8');
}
/*
 * Single Post sidebar position 
*/
function overcome_post_sidebar_position(){
    return apply_filters('overcome_post_sidebar_position','bottom');
}
/*
 * Single Portfolio sidebar position 
*/
function overcome_portfolio_sidebar_position(){
    return apply_filters('overcome_portfolio_sidebar_position','bottom');
}
/*
 * Content area css class
*/
function overcome_get_sidebar($check = true){
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
function overcome_sidebar_position(){
    if((is_archive() || is_post_type_archive('post') || is_home() || is_search()) && !is_post_type_archive('product')){
        $sidebar_position = overcome_get_opts('archive_sidebar_pos', overcome_archive_sidebar_position());
    } elseif(is_post_type_archive('portfolio')){
        $sidebar_position = overcome_get_opts('portfolio_archive_sidebar_pos', overcome_archive_sidebar_position());
    } elseif(is_page()){
        if (class_exists('WooCommerce') && (is_checkout() || is_cart())) {
            $sidebar_position = overcome_get_opts('page_sidebar_pos',overcome_shop_sidebar_position());
        } else {
            $sidebar_position = overcome_get_opts('page_sidebar_pos',overcome_page_sidebar_position());
        }
    } elseif (is_singular('post')) {
        $sidebar_position = overcome_get_opts('post_sidebar_pos',overcome_post_sidebar_position());
    } elseif (is_singular('ef5_portfolio')) {
        $sidebar_position = overcome_get_opts('portfolio_sidebar_pos',overcome_portfolio_sidebar_position());
    } elseif (is_singular('ef5_stories')) {
        $sidebar_position = 'ef5_stories_widget';
    } elseif (class_exists('WooCommerce') && is_post_type_archive('product')) {
        $sidebar_position = overcome_get_opts('shop_sidebar_pos',overcome_shop_sidebar_position());
    } elseif (is_singular('product')) {
        $sidebar_position = overcome_get_opts('product_sidebar_pos',overcome_product_sidebar_position());
    } elseif (class_exists('Tribe__Events__Main') && is_post_type_archive('tribe_events') && ( isset($_REQUEST['tribe_event_display']) && $_REQUEST['tribe_event_display'] === 'list') ){
        $sidebar_position = overcome_get_opts('trible_events_sidebar_pos','right');
    } else {
        $sidebar_position = 'none';
    }
    return $sidebar_position;
}

function overcome_content_css_class($class=''){
    $classes = [
        'ef5-content-area',
        $class
    ];
    $sidebar            = overcome_get_sidebar();
    $sidebar_position   = overcome_sidebar_position();
    $content_grid_class = overcome_get_opts('archive_grid_col', overcome_archive_grid_col());
    
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

    echo overcome_optimize_css_class(implode(' ', $classes));
}
/**
 * Show Widget 
*/

function overcome_sidebar(){
    $sidebar            = overcome_get_sidebar(false);
    $sidebar_position   = overcome_sidebar_position();
    if($sidebar_position === 'none' || $sidebar_position === 'center') return;
    if( is_active_sidebar( $sidebar ) ) {
    ?>
        <div id="ef5-sidebar-area" class="<?php overcome_sidebar_css_class(); ?>">
            <div class="sidebar-inner">
                <?php get_sidebar(); ?>
            </div>
        </div>
    <?php }
}

/*
 * Widget area css class
*/
function overcome_sidebar_css_class($class=''){
    $classes = [
        'ef5-sidebar-area',
        $class
    ];
    if(!is_singular() || is_single() || !is_page_template()) $classes[] = 'ef5-blogs';
    $sidebar_position   = overcome_sidebar_position();
    if( $sidebar_position === 'bottom' ){
        $classes[] = 'col-12 has-gtb';
    } else {
        $content_grid_class = (int) overcome_get_opts('archive_grid_col', overcome_archive_grid_col());
        $sidebar_grid_class = 12 - $content_grid_class;
        $classes[] = 'col-lg-'.$sidebar_grid_class; 
    }

    echo overcome_optimize_css_class(implode(' ', $classes));
}