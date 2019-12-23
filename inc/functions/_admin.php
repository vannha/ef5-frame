<?php
/**
 * Get current screen post type
*/
function get_current_post_type(){
    global $pagenow;
    $post_type = null;

    if (!is_admin()) {
        if (is_singular()) {
            $post_type = get_post_type();
        }
    } elseif ('post.php' === $pagenow || 'post-new.php' === $pagenow) {
        if (function_exists('get_current_screen') && $screen = get_current_screen()) {
            $post_type = $screen->post_type;
        } else {
            $post_id = isset($_GET['post']) ? (int)$_GET['post'] : 0;

            if ($post_id) {
                $post_type = get_post_type($post_id);
            } elseif (isset($_GET['post_type'])) {
                $post_type = sanitize_text_field(wp_unslash($_GET['post_type']));
            } else {
                $post_type = 'post';
            }
        }
    }
    return $post_type;
}