<?php
/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function overcome_get_theme_opt_name()
{
    return apply_filters('overcome_theme_opt_name', 'ef5_theme_options');
}

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function overcome_get_theme_opt($opt_id, $default = false){
    $opt_name      = overcome_get_theme_opt_name();
    if (empty($opt_name)) {
        return $default;
    }
    global ${$opt_name};

    if (!isset(${$opt_name}) || !isset(${$opt_name}[$opt_id]) || ${$opt_name}[$opt_id] === '' ) {
        return $default;
    }

    if(is_array($default)){
        foreach ($default as $key => $value) {
            ${$opt_name}[$opt_id][$key] = isset(${$opt_name}[$opt_id]) && !empty(${$opt_name}[$opt_id][$key]) ? ${$opt_name}[$opt_id][$key] : $value;
        }
    } else {
        ${$opt_name}[$opt_id] = isset(${$opt_name}[$opt_id]) ? ${$opt_name}[$opt_id] : $default;
    }
    return ${$opt_name}[$opt_id];
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function overcome_get_page_opt_name()
{
    return apply_filters('overcome_page_opt_name', 'ef5_page_options');
}
/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function overcome_get_page_opt($opt_id, $default = false)
{
    $page_opt_name = overcome_get_page_opt_name();
    if (empty($page_opt_name)) {
        return $default;
    }
    global $post;

    // fix id for page is Post page / blog / custom post type archive
    if(function_exists('wc_get_page_id') && is_archive() && is_post_type_archive('product') && is_numeric($id = wc_get_page_id('shop')))
        $real_page = get_post($id);
    else
        $real_page =  get_queried_object();
    if($real_page instanceof WP_Post)
    {
        $id = $real_page->ID;
    }
    // end fix 
    $options = !empty($id) && ('' !== get_post_meta($id, $opt_id, true)) ? get_post_meta($id, $opt_id, true) : $default;
    if(is_array($options)) {
        $default = (array) $default;
        $options = wp_parse_args($options, $default);
        foreach ($options as $key => $value){
            foreach ($default as $key => $value){
                if(empty($options[$key]))
                    $options[$key] = $default[$key];
            }
        }
    }

    return $options;
}

/**
 * Get option based on its id.
 * get option of theme and page
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 * @return mixed
 */
function overcome_get_opts($opt_id, $default = false){
    $theme_opt = overcome_get_theme_opt($opt_id, $default);
    $page_opt  = overcome_get_page_opt($opt_id, $theme_opt);
    if($page_opt !== NULL && $page_opt !== '' && $page_opt !== '-1'){
        if(is_array($page_opt) && is_array($theme_opt)){
            foreach ($page_opt as $key => $value) {
                foreach ($theme_opt as $key => $value) {
                    if(empty($page_opt[$key]) || $page_opt[$key] === 'px') 
                        $page_opt[$key] = $theme_opt[$key];
                } 
            }
        }
        $theme_opt = $page_opt;
    }
    return $theme_opt;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 * @return bool|mixed
 */
function overcome_get_post_format_value($post_format_key, $default = '')
{
    global $post;
    return $value = (!empty($post->ID) && '' !== get_post_meta($post->ID, $post_format_key, true) ) ? get_post_meta($post->ID, $post_format_key, true) : $default;
}