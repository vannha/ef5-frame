<?php
/**
 * Header Top
 * Need add custom post type: header_top
 *
*/
if(!function_exists('overcome_header_top')){
    function overcome_header_top($class = ''){
        $header_top = overcome_get_opts('header_top', '');
        $header_top_title = sanitize_title(get_the_title(overcome_get_id_by_slug($header_top, 'ef5_header_top')));
        $classes = array('ef5-header-top', $header_top_title);
        $classes[] = $class;
        if(empty($header_top) || 'none' === $header_top) return;
    ?>
        <div id="ef5-header-top" class="<?php echo trim(implode(' ',$classes));?>">
        	<?php overcome_content_by_slug($header_top,'ef5_header_top'); ?>
        </div>
    <?php
    }
}