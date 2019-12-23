<?php
/**
 * @package EF5 Theme
 * @subpackage OverCome
 * @since 1.0.0
 * @author EF5 Team
*/

if ( ! function_exists( 'overcome_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current post author.
     */
    function overcome_posted_by($args=[]){
        global $post;
        $author_id   = $post->post_author;
        $args = wp_parse_args($args, [
            'class'              => '',
            'hint'               => esc_html__( 'Posted by', 'overcome' ),
            'icon'               => 'fa fa-user',
            'icon_class'         => '',
            'author_avatar'      => false,
            'before_author_name' => '',
            'after_author_name'  => '',
            'show_author'        => '1',
            'echo'               => true   
        ]);
        if($args['show_author'] !== '1') return;
        $classes = ['ef5-posted-by', 'hint--top', $args['class']];
        if($args['author_avatar']) $classes[] = 'd-flex align-items-center';
        if ( ! get_the_author() )
        {
            if ( ! $post instanceof WP_Post )
            {
                return;
            }
            $author_name = get_the_author_meta( 'display_name', $author_id );
            $author_url  = get_author_posts_url( $author_id );
        }
        else
        {
            $author_name = get_the_author();
            $author_url  = get_author_posts_url( get_the_author_meta( 'ID' ) );
        }
        $author_avatar = $args['author_avatar'] ? get_avatar($author_id, 40, '', $author_name, array('class' => 'circle')) : '';
        ob_start();
            printf(
                '<div class="%1$s" data-hint="%2$s">
                    %3$s %4$s %5$s <a class="author-url" href="%6$s">%7$s</a>%8$s
                </div>',
                trim(implode(' ', $classes)),
                esc_html($args['hint']),
                $author_avatar,
                !empty($args['icon']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon']).'">&nbsp;&nbsp;</span>' : '',
                $args['before_author_name'],
                esc_url( $author_url ),
                esc_html( $author_name ),
                $args['after_author_name']
            );  
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
endif;

if ( ! function_exists( 'overcome_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function overcome_posted_on($args=[])
    {
        $args = wp_parse_args($args,[
            'class'       => '',
            'hint'        => esc_html__( 'Published on', 'overcome' ),
            'hint_update' => esc_html__( 'Updated on', 'overcome' ),
            'icon'        => 'fa fa-calendar',
            'icon_class'  => '',
            'icon_update' => '',
            'before_date' => '',
            'after_date'  => '',
            'show_update' => false,
            'show_date'   => '1',
            'echo'        => true,
            'date_format' => get_option('date_format')  
        ]);
        if($args['show_date'] !== '1') return;

        $time_string = '<span class="published" data-time="%1$s">%2$s</span>';
        $posted_time = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            date_i18n($args['date_format'], strtotime(get_the_date()))
        );
        $classes = ['ef5-date', 'ef5-posted-on', 'hint--top', $args['class']];
        if($args['show_update']) $classes[] = 'ef5-updated-on';
        ob_start();
            printf(
                '<div class="%1$s" data-hint="%2$s">
                    %3$s%4$s<a href="%5$s" rel="bookmark">%6$s</a>%7$s
                </div>',
                trim(implode(' ', $classes)),
                esc_html($args['hint']),
                !empty($args['icon']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon']).'">&nbsp;&nbsp;</span>' : '',
                $args['before_date'],
                !is_single() ? esc_url( get_permalink()) : '',
                $posted_time,
                $args['after_date']
            );
            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) && $args['show_update'] )
            {
                $time_string = '<span class="updated" data-datetime="%1$s">%2$s</span>';
                $updated_time = sprintf( $time_string,
                    esc_attr( get_the_modified_date( 'c' ) ),
                    esc_html( get_the_modified_date() )
                );
                printf(
                    '<div class="%1$s" data-hint="%2$s">
                        %3$s%4$s<a href="%5$s" rel="bookmark">%6$s</a>%7$s
                    </div>',
                    trim(implode(' ', $classes)),
                    esc_html($args['hint_update']),
                    !empty($args['icon_update']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon_update']).'">&nbsp;&nbsp;</span>' : '',
                    $args['before_date'],
                    !is_single() ? esc_url( get_permalink()) : '',
                    $updated_time,
                    $args['after_date']
                );
            }
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
endif;


if ( ! function_exists( 'overcome_posted_in' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function overcome_posted_in($args = []){
        $args = wp_parse_args($args, [
            'class'           => '',
            'hint'            => esc_html__( 'Posted in', 'overcome' ),
            'icon'            => 'fa fa-folder',
            'icon_class'      => '',
            'before'          => '',
            'after'           => '',
            'before_category' => '',
            'after_category'  => '',
            'sep'             => ', ',
            'show_cat'        => '1',
            'echo'            => true,
            'post_type'       => 'post'  
        ]);
        if($args['show_cat'] !== '1') return;

        $classes = ['ef5-posted-in', 'hint--top', $args['class']];
        $taxo = overcome_get_post_taxonomies();
        $terms = get_the_term_list( get_the_ID(), $taxo, '', $args['sep'], '' );
        ob_start();
            if ( !empty($terms))
            {
                printf(
                    '%1$s<div class="%2$s" data-hint="%3$s">
                        %4$s %5$s %6$s %7$s
                    </div>%8$s',
                    $args['before'],
                    trim(implode(' ', $classes)),
                    esc_html($args['hint']),
                    !empty($args['icon']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon']).'">&nbsp;&nbsp;</span>' : '',
                    $args['before_category'],
                    $terms,
                    $args['after_category'],
                    $args['after']
                );
            }
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
endif;


if ( ! function_exists( 'overcome_tagged_in' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function overcome_tagged_in($args = []){
        $args = wp_parse_args($args, [
            'class'      => '',
            'hint'       => esc_html__( 'Tagged in', 'overcome' ),
            'icon'       => '',
            'icon_class' => '',
            'before'     => '',
            'after'      => '',
            'before_tag' => '<span class="ef5-heading text-uppercase font-style-500">'.esc_html__('Tags:','overcome').'</span>',
            'after_tag'  => '',
            'sep'        => ', ',
            'show_tag'   => is_single() ? overcome_get_theme_opt( 'post_tags_on', '1' ) : overcome_get_theme_opt( 'archive_tags_on', '1' ),
            'echo'       => true
        ]);
        if('1' !== $args['show_tag']) return;
        $classes = ['ef5-tagged-in hint--top', $args['class']];
        $tags_list = get_the_term_list( get_the_ID(), overcome_get_post_taxonomies('tag'), '', $args['sep'], '' );
        ob_start();
            if ( $tags_list)
            {
                printf(
                    '%1$s<div class="%2$s" data-hint="%3$s">
                        %4$s %5$s %6$s %7$s
                    </div>%8$s',
                    $args['before'],
                    trim(implode(' ', $classes)),
                    esc_html($args['hint']),
                    !empty($args['icon']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon']).'">&nbsp;&nbsp;</span>' : '',
                    $args['before_tag'],
                    $tags_list,
                    $args['after_tag'],
                    $args['after']
                );
            }
        if($args['echo']){
            echo ob_get_clean();
        } else {
            return ob_get_clean();
        }
    }
endif;

/**
 * Prints comments count with link to single post comment form.
 */
if ( ! function_exists( 'overcome_comments_popup_link' ) ) {
    function overcome_comments_popup_link($args = [])
    {
        $args = wp_parse_args($args, [
            'class'     => '',
            'before'    => '',
            'after'     => '',
            'icon'      => 'fa fa-comment-alt',
            'icon_class'=> '',
            'echo'      => true,
            'show_text' => true,
            'show_cmt'  => '1'
        ]);
        if($args['show_cmt'] !== '1') return;

        $classes = trim(implode(' ', ['ef5-comments-link', $args['class']] ));
        $args['icon'] = !empty($args['icon']) ? '<span class="'.trim('meta-icon '.$args['icon_class'].' '.$args['icon']).'">&nbsp;&nbsp;</span>' : '';
        ob_start();
        $number    = (int) get_comments_number( get_the_ID() );
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) )
        {
            echo '<div class="'.esc_attr($classes).'">';
            printf ('%s' , $args['before']);
            if(!$args['show_text']){
                comments_popup_link(
                    sprintf('<span class="hint--top" data-hint="%s">%s %s</span>',esc_html__('Be the first to comment','overcome'), $args['icon'], $number),
                    sprintf('<span class="hint--top" data-hint="%s">%s %s</span>',esc_html__('Post a comment','overcome'), $args['icon'], $number),
                    sprintf('<span class="hint--top" data-hint="%s">%s %s</span>',esc_html__('Post a comment','overcome'), $args['icon'], $number)
                );
            } else {
                comments_popup_link(
                    sprintf('<span class="hint--top" data-hint="%s">%s %s %s</span>',esc_html__('Be the first to comment','overcome'), $args['icon'], $number, esc_html__('Comments','overcome')),
                    sprintf('<span class="hint--top" data-hint="%s">%s %s %s</span>',esc_html__('Post a comment','overcome'), $args['icon'], $number, esc_html__('Comment','overcome')),
                    sprintf('<span class="hint--top" data-hint="%s">%s %s %s</span>',esc_html__('Post a comment','overcome'), $args['icon'], $number, esc_html__('Comments','overcome'))
                );
            }
            printf ('%s' , $args['after']);
            echo '</div>';
        }
        if($args['echo'] === true)
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}

/**
 * Count views
 * Show count of viewed 
*/
function overcome_post_count_view($args=[]){
    $args = wp_parse_args($args, [
        'show_view' => '1',
        'class'     => '',
        'before'    => '',
        'after'     => '',
        'icon'      => '',
        'echo'      => true,
        'show_text' => true
    ]);
    if($args['show_view'] !== '1') return;

    $classes = trim(implode(' ', ['ef5-view', $args['class']] ));
    $args['icon'] = !empty($args['icon']) ? '<span class="meta-icon '.$args['icon'].'">&nbsp;&nbsp;</span>' : '';
    ob_start();
        $view_number    = 100;
        echo '<div class="'.esc_attr($classes).'">';
            printf ('%s' , $args['before']);
                printf(
                    _nx(
                        '%1$s %2$s',
                        '%1$s %3$s',
                        $view_number,
                        'view title',
                        'overcome'
                    ),
                    number_format_i18n( $view_number ),
                    $args['show_text'] ? esc_html__('View','overcome') : '',
                    $args['show_text'] ? esc_html__('Views','overcome') : ''
                );
            printf ('%s' , $args['after']);
        echo '</div>';
    
    if($args['echo'] === true)
        echo ob_get_clean();
    else 
        return ob_get_clean();
}

/**
 * Count Like
 * Show count of viewed 
*/
function overcome_post_count_like($args=[]){
    $args = wp_parse_args($args, [
        'show_like' => '1',
        'class'     => '',
        'before'    => '',
        'after'     => '',
        'icon'      => '',
        'echo'      => true,
        'show_text' => true
    ]);
    if($args['show_like'] !== '1') return;

    $classes = trim(implode(' ', ['ef5-like', $args['class']] ));
    $args['icon'] = !empty($args['icon']) ? '<span class="meta-icon '.$args['icon'].'">&nbsp;&nbsp;</span>' : '';
    ob_start();
        $like_number    = 100;
        echo '<div class="'.esc_attr($classes).'">';
            printf ('%s' , $args['before']);
                printf(
                    _nx(
                        '%1$s %2$s',
                        '%1$s %3$s',
                        $like_number,
                        'view title',
                        'overcome'
                    ),
                    number_format_i18n( $like_number ),
                    $args['show_text'] ? esc_html__('Like','overcome') : '',
                    $args['show_text'] ? esc_html__('Likes','overcome') : ''
                );
            printf ('%s' , $args['after']);
        echo '</div>';
    
    if($args['echo'] === true)
        echo ob_get_clean();
    else 
        return ob_get_clean();
}

/**
 * Prints post edit link when applicable
 */
function overcome_edit_link($args = [])
{
    $args = wp_parse_args($args, [
        'class'     => '',
        'icon'      => 'far fa-edit',
        'title'     => esc_html('Edit', 'overcome'),
        'hint'      => esc_html('Edit', 'overcome'),
        'before'    => '',
        'after'     => '',
        'show_edit' => false,
        'echo'      => true
    ]);
    $classes = ['ef5-edit-link', 'hint--top', $args['class']];
    $args['icon'] = !empty($args['icon']) ? '<span class="'.esc_attr($args['icon']).'">&nbsp;&nbsp;</span>' : '';
    if(!$args['show_edit']) return;

    $before = $args['before'].'<div class="'.trim(implode(' ', $classes)).'" data-hint="'.esc_attr($args['hint']).'">'.$args['icon'];
    $after = '</div>'.$args['after'];
    ob_start();
        edit_post_link($args['title'], $before, $after );
    if($args['echo']){
        echo ob_get_clean();
    } else {
        return ob_get_clean();
    }
}

function overcome_link_pages($args = [])
{
    $args = wp_parse_args($args, [
        'class' => ''
    ]);
    $classes = trim(implode(' ', [$args['class'],'page-links','clearfix']));
    wp_link_pages( array(
        'before'      => sprintf( '<div class="'.$classes.'"><span class="ef5-heading">%s</span>', esc_html__( 'Pages:', 'overcome' ) ),
        'after'       => '</div>',
        'link_before' => '<span class="page-link-number">', 
        'link_after'  => '</span>'
    ) );
}

/**
 * Post Share
*/
if(!function_exists('overcome_post_share')){
    function overcome_post_share($args = array()){
        wp_enqueue_script('sharethis');
        global $post;
        $defaults = array(
            'show_share'  => is_single() ? overcome_get_theme_opt( 'post_share_on', '0' ) : overcome_get_theme_opt( 'archive_share_on', '0' ),
            'class'       => '',
            'row_class'       => '',
            'show_title'  => true,
            'title'       => esc_html__('Share this article','overcome'),
            'social_args' => [],
            'echo'        => true,
            'show_all'    => ''
        );
        $args = wp_parse_args($args, $defaults);
        extract($args);
        if($show_share !== '1') return;
        $social_classes = overcome_optimize_css_class(trim(implode(' ', ['ef5-social', isset($social_args['class']) ? $social_args['class'] : '', isset($social_args['size']) ? 'size-'.$social_args['size'] : ''] )));
        $classes   = array('ef5-shares');
        $classes[] = $class;
        $classes[] = overcome_is_loop() ? 'loop': 'single';        
        
        $row_class = overcome_optimize_css_class(trim(implode(' ', ['row align-items-center', $args['row_class']])));

        $url   = get_the_permalink();
        $image = get_the_post_thumbnail_url($post->ID);
        $title = get_the_title();

        if(is_singular()){
            $show_fb    = overcome_get_theme_opt( 'post_share_fb', '1' );
            $show_tw    = overcome_get_theme_opt( 'post_share_tw', '1' );
            $show_gplus = overcome_get_theme_opt( 'post_share_gplus', '1' );
            $show_pin   = overcome_get_theme_opt( 'post_share_pin', '1' );
            $show_all   = overcome_get_theme_opt( 'post_share_all', '1' );
        } else {
            $show_fb    = overcome_get_theme_opt( 'archive_share_fb', '1' );
            $show_tw    = overcome_get_theme_opt( 'archive_share_tw', '1' );
            $show_gplus = overcome_get_theme_opt( 'archive_share_gplus', '1' );
            $show_pin   = overcome_get_theme_opt( 'archive_share_pin', '1' );
            $show_all   = $args['show_all'] != '' ? $args['show_all'] : overcome_get_theme_opt( 'archive_share_all', '1' );
        }
        ob_start();
        if($show_fb == '1' || $show_tw == '1' || $show_gplus == '1' || $show_pin == '1' || $show_all == '1') {
        ?>
        <div class="<?php echo overcome_optimize_css_class(trim(implode(' ', $classes))); ?>">
            <?php if($show_title): ?>
                <div class="<?php echo esc_attr($row_class);?>">
                    <div class="col-auto share-title">
                        <?php echo esc_html($args['title']); ?>
                    </div>
                    <div class="col-auto">
            <?php endif; ?>
                    <div class="<?php echo esc_attr($social_classes);?>">
                        <?php if($show_fb == '1'): ?>
                        <a data-hint="<?php esc_attr_e('Share this post to Facebook','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="facebook" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce facebook st-custom-button"><span class="fab fa-facebook-f"></span></a>
                        <?php endif;
                        if($show_tw == '1'): ?>
                        <a data-hint="<?php esc_attr_e('Share this post to Twitter','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="twitter" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce twitter st-custom-button"><span class="fab fa-twitter"></span></a>
                        <?php endif;
                        if($show_gplus == '1'): ?>
                        <a data-hint="<?php esc_attr_e('Share this post to Google Plus','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="googleplus" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce googleplus st-custom-button"><span class="fab fa-google-plus"></span></a>
                        <?php endif;
                        if($show_pin == '1'): ?>
                        <a data-hint="<?php esc_attr_e('Share this post to Pinterest','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="pinterest" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce pinterest st-custom-button"><span class="fab fa-pinterest"></span></a>
                        <?php endif;
                        if($show_all == '1'): ?>
                        <a data-hint="<?php esc_attr_e('Share this post to','overcome'); ?>" data-toggle="tooltip" href="javascript:void(0);" data-network="sharethis" data-url="<?php echo esc_url($url);?>" data-short-url="<?php echo esc_url($url);?>" data-title="<?php echo esc_attr($title);?>" data-image="<?php echo esc_url($image); ?>" data-description="<?php echo get_the_excerpt(); ?>" data-username="" data-message="<?php echo bloginfo(); ?>" class="hint--top hint--bounce sharethis st-custom-button"><span class="fa fa-share-alt"></span></a>
                        <?php endif; ?>
                    </div>
            <?php if($show_title): ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
        }
        if($echo)
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}

/**
 * Post Read more Button 
*/
if ( ! function_exists( 'overcome_post_read_more' ) ) {
    /**
     * Prints post read more link
     */
    function overcome_post_read_more($args = [])
    {
        $args = wp_parse_args($args,[
            'class'          => '',
            'icon_left'      => '',
            'icon_right'     => '',
            'title'          => esc_html__('Read More','overcome'),
            'readmore_class' => 'ef5-btn accent fill transition ef5-scroll',
            'show_readmore'  => overcome_get_theme_opt( 'archive_readmore', '1' ),
            'before'         => '',
            'after'          => '',
            'echo'           => true
        ]);
        if('1' != $args['show_readmore']) return;
        $classes = ['ef5-readmore', $args['class'], $args['readmore_class']];
        ob_start();
            printf(
                '%1$s<a href="%2$s" title="%3$s" class="%4$s">%5$s %6$s %7$s</a>%8$s',
                $args['before'],
                esc_url( get_the_permalink() ),
                esc_attr( get_the_title() ),
                trim(implode(' ', $classes)),
                !empty($args['icon_left']) ? '<span class="'.esc_attr($args['icon_left']).'"></span>&nbsp;&nbsp;' : '',
                '<span>'.$args['title'].'</span>',
                !empty($args['icon_right']) ? '&nbsp;&nbsp;<span class="'.esc_attr($args['icon_right']).'"></span>' : '',
                $args['after']
            );
        if($args['echo'])
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}
/**
 * Post Read more Circle 
 * Prints post read more link
*/
if ( ! function_exists( 'overcome_post_read_more_circle' ) ) {
    function overcome_post_read_more_circle($args = [])
    {
        $args = wp_parse_args($args,[
            'class'          => '',
            'bgcolor'        => 'bg-accent',
            'size'           => '60',
            'shape'          => 'circle',
            'icon'           => 'flaticon-add',
            'title'          => esc_html__('Read More','overcome'),
            'readmore_class' => '',
            'show_readmore'  => '1',
            'before'         => '',
            'after'          => '',
            'echo'           => true
        ]);
        if('1' != $args['show_readmore']) return;
        $classes = ['ef5-icon', $args['bgcolor'], 'size-'.$args['size'], $args['shape'], 'ef5-shadow-hover', 'hint--top', $args['class'], $args['readmore_class']];
        ob_start();
            printf(
                '%1$s<a href="%2$s" title="%3$s" class="%4$s" data-hint="%5$s">%6$s %7$s</a>%8$s',
                $args['before'],
                esc_url( get_the_permalink() ),
                esc_attr( get_the_title() ),
                trim(implode(' ', $classes)),
                esc_attr($args['title']),
                !empty($args['icon']) ? '<span class="'.esc_attr($args['icon']).'"></span>' : '<span class="ef5-i-plus center-align transition"></span>',
                '',
                $args['before']
            );
        if($args['echo'])
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}