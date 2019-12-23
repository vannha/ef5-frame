<?php
/*
 * get page ID by Slug
*/
function overcome_get_id_by_slug($slug, $post_type){
    if(empty($slug)) return '';
    $content = get_page_by_path($slug, OBJECT, $post_type);
    if(is_object($content)) 
        return $content->ID;
    else
        return;
}

function overcome_get_link_by_slug($slug, $post_type = 'post'){
    // Initialize the permalink value
    $permalink = null;

    // Build the arguments for WP_Query
    $args = array(
        'name'          => $slug,
        'max_num_posts' => 1
    );

    // If the optional argument is set, add it to the arguments array
    if( '' != $post_type ) {
        $args = array_merge( $args, array( 'post_type' => $post_type ) );
    }

    // Run the query (and reset it)
    $query = new WP_Query( $args );
    if( $query->have_posts() ) {
        $query->the_post();
        $permalink = get_permalink( get_the_ID() );
        wp_reset_postdata();
    }
    return $permalink;
}

/**
 * get content by slug
**/
function overcome_get_content_by_slug($slug, $post_type){
    $content = get_posts(
        array(
            'name'      => $slug,
            'post_type' => $post_type
        )
    );
    if(!empty($content))
        return $content[0]->post_content;
    else 
        return;
}

/**
 * Show content
 * Show content by post ID
**/
if(!function_exists('overcome_content')){
    function overcome_content($id){
        $post_data = get_post($id);
        if ($post_data) {
            $content = $post_data->post_content;
        } else {
            return false;
        }
        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
            echo '<div class="ef5-inline-css" style="display:none;" data-type="vc_shortcodes-custom-css" data-css="'.esc_attr($shortcodes_custom_css).'"></div>';
        }
        echo apply_filters('the_content',  $content);
    }
}

/**
 * Show content by slug
**/
if(!function_exists('overcome_content_by_slug')){
    function overcome_content_by_slug($slug, $post_type){
        $content = overcome_get_content_by_slug($slug, $post_type);
        $id = overcome_get_id_by_slug($slug, $post_type);
        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
            //data-type="vc_shortcodes-custom-css"
            echo '<div class="ef5-inline-css" style="display:none;" data-css="'.esc_attr($shortcodes_custom_css).'"></div>';
        }
        echo apply_filters('the_content',  $content);
    }
}

/**
 * Get content link
 *
 * @return string / bool
 *
*/
function overcome_get_content_link( $args = []){
    $args = wp_parse_args($args, [
        'content' => '',
        'class'   => 'content-link btn btn-pri',
        'target'  => '_blank',
        'prefix'  => esc_html__('Visit','overcome'),
        'echo'    => true
    ]);
    $link = $title = '';
    if ( empty($args['content']) )
        $args['content'] = get_the_content();
    if( preg_match( '/<a\s[^>]*?href=([\'"])(.+?)\1/is', $args['content'], $href ))
        $link = $href[2];
    if(preg_match( '/<a\s[^>]*?title=([\'"])(.+?)\1/is', $args['content'], $_title ))
        $title = $_title[2];
    if(!empty($link)){
        if($args['echo'])
            echo '<a href="'.esc_url_raw($link).'" data-hint="'.esc_attr($args['prefix'].' '.$title).'" class="'.esc_attr($args['class']).'" target="'.esc_attr($args['target']).'"><span>'.esc_html($title).'</span></a>';
        else 
            return '<a href="'.esc_url_raw($link).'" data-hint="'.esc_attr($args['prefix'].' '.$title).'" class="'.esc_attr($args['class']).'" target="'.esc_attr($args['target']).'"><span>'.esc_html($title).'</span></a>';
    }
    return false;
}

/**
 * Get content image
 *
 * @return string / false
 *
*/
function overcome_get_content_image( $args = []){
    $args = wp_parse_args($args, [
        'content' => '',
        'class'   => 'content-image',
        'echo'    => true
    ]);
    $src = $title = $alt = $srcset = $sizes = '';
    if ( empty($args['content']) )
        $args['content'] = get_the_content();
    // src
    if( preg_match( '/<img\s[^>]*?src=([\'"])(.+?)\1/is', $args['content'], $_src )) {
        $src = isset($_src[2]) ? $_src[2] : '';
    }
    // srcset
    if( preg_match( '/<img\s[^>]*?srcset=([\'"])(.+?)\1/is', $args['content'], $_srcset )) { 
        $srcset = isset($_srcset[2]) ? $_srcset[2] : ''; 
    } else {
        $img_id = overcome_get_attachment_id_from_url($src);
        $srcset = wp_get_attachment_image_srcset($img_id, 'large');
    }
    // sizes
    if( preg_match( '/<img\s[^>]*?sizes=([\'"])(.+?)\1/is', $args['content'], $_sizes )) { 
        $sizes = isset($_sizes[2]) ? $_sizes[2] : get_the_title(); 
    } else {
        $img_id = overcome_get_attachment_id_from_url($src);
        $sizes = wp_get_attachment_image_sizes($img_id);
    }
    // title  
    if(preg_match( '/<img\s[^>]*?title=([\'"])(.+?)\1/is', $args['content'], $_title )) {
        $title = isset($_title[2]) ? $_title[2] : '';
    }
    // alt  
    if(preg_match( '/<img\s[^>]*?alt=([\'"])(.+?)\1/is', $args['content'], $_alt )) {
        $alt = isset($_alt[2]) ? $_alt[2] : '';
    }
    if(!empty($src)){
        if($args['echo'])
            echo '<img src="'.esc_url_raw($src).'" srcset="'.$srcset.'" sizes="'.esc_attr($sizes).'" title="'.esc_attr($title).'" alt="'.esc_attr($alt).'" class="'.esc_attr($args['class']).'" />';
        else 
            return '<img src="'.esc_url_raw($src).'" srcset="'.esc_attr($srcset).'" sizes="'.esc_attr($sizes).'" title="'.esc_attr($title).'" alt="'.esc_attr($alt).'" class="'.esc_attr($args['class']).'" />';
    }
    return false;
}


/**
 * Get the Attachment ID for a given image URL.
 *
 * @link   http://wordpress.stackexchange.com/a/7094
 *
 * @param  string $url
 *
 * @return boolean|integer
 */
if ( ! function_exists( 'overcome_get_attachment_id_from_url' ) ) {
    
    function overcome_get_attachment_id_from_url( $url ) {

        $dir = wp_upload_dir();

        // baseurl never has a trailing slash
        if ( false === strpos( $url, $dir['baseurl'] . '/' ) ) {
            // URL points to a place outside of upload directory
            return false;
        }

        $file  = basename( $url );
        $query = array(
            'post_type'  => 'attachment',
            'fields'     => 'ids',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key'     => '_wp_attached_file',
                    'value'   => $file,
                    'compare' => 'LIKE',
                ),
            )
        );

        // query attachments
        $ids = get_posts( $query );
        if ( ! empty( $ids ) ) {
            foreach ( $ids as $id ) {

                // first entry of returned array is the URL
                $attachment_url = wp_get_attachment_image_src( $id, 'full' );
                if ( $url === $attachment_url[0] )
                    return $id;
            }
        }

        $query['meta_query'][0]['key'] = '_wp_attachment_metadata';

        // query attachments again
        $ids = get_posts( $query );

        if ( empty( $ids) )
            return false;

        foreach ( $ids as $id ) {

            $meta = wp_get_attachment_metadata( $id );

            foreach ( $meta['sizes'] as $size => $values ) {
                $attachment_url = wp_get_attachment_image_src( $id, $size );
                if ( $values['file'] === $file && $url === $attachment_url[0] )
                    return $id;
            }
        }

        return false;
    }
}

/**
 * Get First number in a string
 * @param string $string
 * @param position to get $pos
 * @return boolean|integer
 * 
*/
function overcome_extract_numbers($string,$pos=0)
{
    if(preg_match_all('/([\d]+)/', $string, $match)){
        if(isset($match[0][$pos]))
            return $match[0][$pos];
        else 
            return false;
    }
    return false;
}

/**
 * Get post ID by Title 
 * @return ID
*/
function overcome_get_id_by_title($post_title, $post_type = 'page'){
    $page = get_page_by_title( $post_title, OBJECT , $post_type );
    if(isset($page->ID))
        return $page->ID;
    else 
        return 0;
}

/**
 * Output html
*/
if(!function_exists('overcome_html')){
    function overcome_html($html){
        return $html;
    }
}

/**
 * Get custom post type taxonomy: TAXONOMIES
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_get_custom_post_taxonomies')){
    function overcome_get_custom_post_taxonomies($post_type, $key)
    {
        $tax_names = get_object_taxonomies($post_type);
        $result    = '';
        if(is_array($tax_names))
        {
            foreach ($tax_names as $name)
                if(strpos($name , $key) !== false)
                {
                    $result = $name;
                    break;
                }
        }
        return $result;
    }
}
/**
 * Get custom post type taxonomy: CAT
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_get_custom_post_cat_taxonomy')){
    function overcome_get_custom_post_cat_taxonomy()
    {
        $post = get_post();
        $tax_names = get_object_taxonomies($post);
        $result = 'category';
        if(is_array($tax_names))
        {
            foreach ($tax_names as $name)
                if(strpos($name,'cat') !== false)
                {
                    $result = $name;
                    break;
                }
        }
        return $result;
    }
}

/**
 * Get custom post type taxonomy: TAGS
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_get_custom_post_tag_taxonomy')){
    function overcome_get_custom_post_tag_taxonomy()
    {
        $post = get_post();
        $tax_names = get_object_taxonomies($post);
        $result = 'post_tag';
        if(is_array($tax_names))
        {
            foreach ($tax_names as $name)
                if(strpos($name,'tag') !== false)
                {
                    $result = $name;
                    break;
                }
        }
        return $result;
    }
}

/**
 * Get post type taxonomies list
*/
function overcome_get_taxo_slug_as_css_class($args = [])
{
    $args = wp_parse_args($args, ['id' => null, 'taxo' => 'category']);
    $post = get_post( $args['id'] );
    $terms = get_terms([
        'taxonomy' => $args['taxo']
    ]);
    $classes = [];
    if ( is_object_in_taxonomy( $post->post_type, $args['taxo'] ) ) {
        foreach ( (array) get_the_terms( $post->ID, $args['taxo'] ) as $term ) {
            if ( empty( $term->slug ) ) {
                     continue;
            }
            $term_class = sanitize_html_class( $term->slug );
            if ( is_numeric( $term_class ) || ! trim( $term_class, '-' ) ) {
                $term_class = $term->term_id;
            }
            $classes[] =  sanitize_html_class($term_class);
        }
    }
    return implode(' ', $classes);
}

/**
 * Terms List
*/
function overcome_terms($args=[]){
    $args = wp_parse_args($args, [
        'id'    => null,
        'link'  => true,
        'taxo'  => 'category',
        'sep'   => ',',
        'before' => '',
        'after'  => '' 
    ]);
    if(empty($args['id'])) $args = get_the_ID();
    $term_list = get_the_term_list( $args['id'], $args['taxo'], $args['before'], $args['sep'], $args['after']);
    $term_obj_list = get_the_terms( $args['id'], $args['taxo']);
    if ( is_wp_error( $term_list ) ) {
        return false;
    }

    if($args['link'] === true){
       $terms_string = $term_list;
    } else {
        $terms_string = $args['before'].join($args['sep'], wp_list_pluck($term_obj_list, 'name')).$args['after'];
    }

    echo apply_filters('overcome_terms', $terms_string);
}

/**
 * Get term ID by slug
 * @param $post_type
 * @param $taxo_key, example category -> get: cat , post_tag -> get: tag, portfolio-category -> get: cat
 * @param $term_slugs //string of slug,  separare by comma
 * @return array
 *
*/
function overcome_get_term_id_by_slug($post_type, $taxo_key, $term_slugs){
    if(empty($term_slugs)) return;
    $term_slugs = explode(',', $term_slugs);
    $term_ids = [];
    foreach ($term_slugs as $slug) {
        $term = get_term_by('slug', $slug, overcome_get_custom_post_taxonomies( $post_type , $taxo_key));
        if(isset($term->term_id)) $term_ids[] = $term->term_id;
    }
    return $term_ids;
}

/**
 * Get taxonomy query for post query
 *
*/
function overcome_tax_query($post_type, $taxonomies, $taxonomies_exclude ){
    $tax_query = array();    
    if(!empty($taxonomies) || !empty($taxonomies_exclude)) {
        $terms              = get_object_taxonomies( $post_type );
        if(count($terms) > 1){
            $tax_query['relation'] = 'OR'; 
        }
        foreach ($terms as $term) {
            $real_terms_args = [
                'taxonomy' => overcome_get_custom_post_taxonomies( $post_type , $term), 
                'exclude'  => overcome_get_term_id_by_slug($post_type, $term, $taxonomies_exclude)
            ];
            if(!empty($taxonomies))  $real_terms_args['slug'] = explode(',', $taxonomies);
            $_real_terms = get_terms($real_terms_args);
            $real_terms = [];
            foreach ($_real_terms as $_real_term) {
                $real_terms[] = $_real_term->slug;
            }             
            if(!empty($real_terms) && strpos($term, 'cat') !== false ){
                $tax_query[] = array(
                    'taxonomy' => $term,
                    'field'    => 'slug',
                    'terms'    => $real_terms,
                    'relation' => 'IN',
                );
            }
        }
    }
    return $tax_query;
}

/* Convert hexdec color string to rgb(a) string */
 
function overcome_hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}