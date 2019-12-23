<?php
/**
 * Loop Page 
*/
function overcome_is_loop(){
    if(is_home() || is_archive() || is_author() || is_category() || is_post_type_archive() || is_tag() || is_tax() || is_search())
        return true;
    else 
        return false;
}

/**
 * Get custom post type taxonomies
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_get_post_taxonomies')){
    function overcome_get_post_taxonomies($taxo = 'cat') {
		$post      = get_post();
		$tax_names = get_object_taxonomies($post);
		$result    = false;
        if(is_array($tax_names))
        {
            foreach ($tax_names as $name)
                if(strpos($name, $taxo) !== false)
                {
                    $result = $name;
                    break;
                }
        }
        return $result;
    }
}