<?php
/* get custom user profile */
function overcome_user_social($args = []){
    if(!class_exists('EF5Systems')) return;
    $args = wp_parse_args($args, [
        'author_id' => null,
        'email'     => '',
        'echo'      => true, 
        'class'     => ''
    ]);
    if(!empty($args['email'])) {
        $user = get_user_by( 'email', $args['email']);
        $args['author_id'] = $user->ID;
    }
    extract($args);
    global $post;
    if(empty($author_id)) $author_id = $post->post_author;

    $classes = ['ef5-social', $class];

    $extend_social = ef5_user_info($author_id, 'extend_social');
    ob_start();
        echo '<div class="'.overcome_optimize_css_class(implode(' ', $classes)).'">';
        foreach ($extend_social as $social) {
            if(!empty($social)){
                if(!empty($social['font'])) wp_enqueue_style('font-'.$social['font']);
                echo '<a target="_blank" href="' . esc_url( $social['url'] ) . '"><span class="'.esc_attr($social['icon']).'"></span></a>';
            }
        }
        echo '</div>';
    if($echo)
       echo ob_get_clean();
    else 
        return ob_get_clean();
}