<?php
/**
 * OverCome_Main_Menu_Walker
 * OverCome_Side_Main_Menu_Walker
 * OverCome_Mega_Menu_Walker
 *
 * @package EF5 Theme
 *
 */

if ( ! defined( 'ABSPATH' ) )
{
    die();
}

class OverCome_Main_Menu_Walker extends Walker_Nav_Menu{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $header_layout = overcome_get_opts('header_layout');
        switch ($header_layout) {
            case '3':
                $output .= "\n$indent<ul class=\"ef5-submenu ef5-toggle-menu ef5-side-submenu ef5-side-submenu-base\">\n";
                break;
            
            default:
                $output .= "\n$indent<ul class=\"ef5-submenu ef5-dropdown ef5-dropdown-base\">\n";
                break;
        }
        
    }
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        //$classes[] = 'wg-menu-item';
        if(in_array('menu-item-has-children', $classes)) $classes[] = 'has-toggle parent';
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param WP_Post  $item  Menu item data object.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        if(empty($title)) $title = sprintf( __( '#%d (no title)', 'overcome' ), $item->ID );
        /* add expander */
        $item_expander = '';
        $is_parent = in_array('menu-item-has-children', $classes);
        if($is_parent === true) $item_expander =  overcome_widget_expander();

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= $item_expander;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
} 

class OverCome_Side_Main_Menu_Walker extends Walker_Nav_Menu{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"ef5-submenu ef5-toggle-menu ef5-side-submenu ef5-side-submenu-base\">\n";
    }
}

/**
 * Add support Mega Menu
 * @return boolean
*/
if(!function_exists('overcome_enable_megamenu')){
	add_filter('ef5_enable_megamenu', 'overcome_enable_megamenu');
	function overcome_enable_megamenu(){
	    return true;
	}
}
if(!function_exists('overcome_megamenu_locations')){
    add_filter('ef5_locations','overcome_megamenu_locations');
    function overcome_megamenu_locations(){
        return array('ef5-primary');
    }
}

if(!function_exists('ef5_enable_badge')){
    add_filter('ef5_enable_badge', 'ef5_enable_badge');
    function ef5_enable_badge(){
        return false;
    }
}
if(!function_exists('ef5_enable_onepage')){
    add_filter('ef5_enable_onepage', 'ef5_enable_onepage');
    function ef5_enable_onepage(){
        return false;
    }
}

if(!function_exists('ef5_enable_megamenu_icon')){
    add_filter('ef5_enable_megamenu_icon', 'ef5_enable_megamenu_icon');
    function ef5_enable_megamenu_icon(){
        return true;
    }
}