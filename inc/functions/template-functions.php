<?php

/**
 * Post Header
 *
 * Showing post header in loop / single
 *
**/
if(!function_exists('overcome_post_header')){
	function overcome_post_header($args=[]){
		$args = wp_parse_args($args, [
            'heading_tag' => 'h3',
            'class'       => '',
		]);
        $classes = ['ef5-post-header',$args['class']];
        $title_classes = ['ef5-heading',$args['heading_tag']];
        $stick_icon = ( is_sticky() && is_home() && ! is_paged()) ? '<span class="sticky-post"><span class="sticky-post-inner">Featured</span></span>' : '';
        $link_open = is_singular() ? '' : '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
        $link_close = is_singular() ? '' : '</a>';

	?>
		<div class="<?php echo trim(implode(' ', $classes));?>">
            <div class="ef5-before-title empty-none"><?php do_action('overcome_before_loop_title'); ?></div>
	        <?php the_title( '<div class="'.trim(implode(' ', $title_classes)).'">'.$link_open.$stick_icon, $link_close.'</div>'); ?>
            <div class="ef5-after-title empty-none"><?php do_action('overcome_after_loop_title'); ?></div>
	    </div>
	<?php
	}
}

if(!function_exists('overcome_post_title')){
    function overcome_post_title($args=[]){
        $args = wp_parse_args($args, [
            'heading_tag' => 'h4',
            'class'       => '',
            'echo'        => true  
        ]);
        $title_classes = ['ef5-heading',$args['heading_tag'], $args['class']];
        $stick_icon = ( is_sticky() && is_home() && ! is_paged()) ? '<span class="fa fa-thumb-tack"></span>&nbsp;&nbsp;' : '';
        $link_open = is_singular() ? '' : '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
        $link_close = is_singular() ? '' : '</a>';
        if($args['echo']){
            the_title( '<div class="'.trim(implode(' ', $title_classes)).'">'.$link_open.$stick_icon, $link_close.'</div>' ); 
        } else {
            return '<div class="'.trim(implode(' ', $title_classes)).'">'.$link_open.$stick_icon .get_the_title().$link_close.'</div>'; 
        }
    }
}

/**
 * Post Meta
 * Prints HTML with meta information for the current post.
*/
if ( ! function_exists( 'overcome_post_meta' ) ) {
    add_action('overcome_before_loop_title','overcome_post_meta');
    function overcome_post_meta($args = [])
    {
        if ( is_singular() ) {
            $author_on   = !empty($args['show_author']) ? $args['show_author'] : overcome_get_theme_opt( 'post_author_on', '1' );
            $date_on     = !empty($args['show_date']) ? $args['show_date'] : overcome_get_theme_opt( 'post_date_on', '1' );
            $cats_on     = !empty($args['show_cat']) ? $args['show_cat'] : overcome_get_theme_opt( 'post_categories_on', '0' );
            $comments_on = !empty($args['show_cmt']) ? $args['show_cmt'] : overcome_get_theme_opt( 'post_comments_on', '1' );
            $show_view = !empty($args['show_view']) ? $args['show_view'] : overcome_get_theme_opt( 'post_view_on', '0' );
            $show_like = !empty($args['show_like']) ? $args['show_like'] : overcome_get_theme_opt( 'post_like_on', '0' );
        }  else {
            $author_on   = !empty($args['show_author']) ? $args['show_author'] : overcome_get_theme_opt( 'archive_author_on', '1' );
            $date_on     = !empty($args['show_date']) ? $args['show_date'] : overcome_get_theme_opt( 'archive_date_on', '1' );
            $cats_on     = !empty($args['show_cat']) ? $args['show_cat'] : overcome_get_theme_opt( 'archive_categories_on', '0' );
            $comments_on = !empty($args['show_cmt']) ? $args['show_cmt'] : overcome_get_theme_opt( 'archive_comments_on', '1' );
            $show_view = !empty($args['show_view']) ? $args['show_view'] : overcome_get_theme_opt( 'archive_view_on', '0' );
            $show_like = !empty($args['show_like']) ? $args['show_like'] : overcome_get_theme_opt( 'archive_like_on', '0' );
        }

        $args = wp_parse_args($args, [
            'class'           => '',
            'show_author'     => $author_on,
            'show_date'       => $date_on,
            'show_cat'        => $cats_on,
            'show_cmt'        => $comments_on,
            'show_view'       => $show_view,
            'show_like'       => $show_like,
            'show_edit'       => false,
            'stretch_content' => false,
            'sep'             => '',
        ]);
        $metas = [];
        if($args['show_date']) 
            $metas[] = overcome_posted_on(['show_date' => $args['show_date'], 'echo' => false]);
        if($args['show_author']) 
            $metas[] = overcome_posted_by(['show_author' => $args['show_author'], 'echo' => false, 'author_avatar' => false]);
        if($args['show_cmt'] && comments_open()) 
            $metas[] = overcome_comments_popup_link(['show_cmt' => $args['show_cmt'], 'echo' => false]);
        if($args['show_cat']) 
            $metas[] = overcome_posted_in(['show_cat' => $args['show_cat'], 'echo' => false]);
        if($args['show_view']) 
            $metas[] = overcome_post_count_view(['show_view' => $args['show_view'], 'echo' => false]);
        if($args['show_like']) 
            $metas[] = overcome_post_count_like(['show_like' => $args['show_like'], 'echo' => false]);
        if($args['show_edit']) 
            $metas[] = overcome_edit_link(['show_edit' => $args['show_edit'], 'echo' => false]);

        $output = implode($args['sep'], $metas);
        $css_classes = ['ef5-meta', $args['class'], 'd-flex', 'align-items-center'];
        if($args['stretch_content']) $css_classes[] = 'justify-content-between';
        $classes = trim(implode(' ',$css_classes ));
        if ( $output )
        {
            printf( '<div class="%s">%s</div>', $classes ,$output);
        }
    }
}

/**
 * Post Excerpt
*/
if(!function_exists('overcome_post_excerpt')){
	function overcome_post_excerpt($args =[]){
		$args = wp_parse_args($args,[
            'show_excerpt' => '1',
            'class'        => '',
            'length'       => apply_filters('overcome_excerpt_length', 37),
            'more'         => '&hellip;',
            'echo'         => true 
		]);
        if($args['show_excerpt'] !== '1') return;
        $classes   = ['ef5-excerpt', $args['class']];
        $content      = get_the_excerpt();
        $excerpt_more = apply_filters('overcome_excerpt_more', $args['more']);
        $excerpt      = wp_trim_words($content, $args['length'], $excerpt_more);
        if($args['echo']){
	?>
	<div class="<?php echo trim(implode(' ', $classes));?>">
		<?php printf('%s', $excerpt); ?>
	</div>
	<?php
        } else {
            return '<div class="'.trim(implode(' ', $classes)).'">'. $excerpt .'</div>';
        }
	}
}

/**
 * Post Content
*/
if(!function_exists('overcome_post_content')){
    function overcome_post_content($args = []){
        $args = wp_parse_args($args, [
            'class' => ''
        ]);
        $classes = [
            'ef5-content',
            'ef5-content-'.get_post_type(),
        ];
        if(is_singular()) $classes[] = 'ef5-single-content';
        $classes[] = 'clearfix';
    ?>
        <div class="<?php echo trim(implode(' ', $classes));?>">
            <?php the_content(); ?>
        </div>
    <?php
    }
}

/**
 * Loop Pagination 
*/
if(!function_exists('overcome_loop_pagination')){
    function overcome_loop_pagination($args=[]){
        $args = wp_parse_args($args, [
            'show_pagination' => '1',
            'style'           => overcome_get_theme_opt('archive_nav_type', apply_filters('overcome_loop_pagination', '3')),
            'class'           => ''
        ]);
        if($args['show_pagination'] !== '1'){
            wp_reset_query();
            return;
        }
        $paginate_links = ['nav-links','layout-'.$args['style'],$args['class']];
        printf('%s','<div class="ef5-loop-pagination layout-type-'.esc_attr($args['style']).'">');
        switch ($args['style']) {
            case '5':
                previous_posts_link(
                    apply_filters('overcome_loop_pagination_prev_text', esc_html__('Previous', 'overcome'))
                );
                next_posts_link(
                    apply_filters('overcome_loop_pagination_next_text', esc_html__('Next', 'overcome'))
                );
                break;
            case '4':
                posts_nav_link(
                    apply_filters('overcome_loop_pagination_sep_text', '<span class="d-none"></span>'),
                    apply_filters('overcome_loop_pagination_prev_text', esc_html__('Previous', 'overcome')),
                    apply_filters('overcome_loop_pagination_next_text', esc_html__('Next', 'overcome'))
                );
                break;
            case '3':
                echo '<div class="'.trim(implode(' ', $paginate_links)).'">';
                    echo paginate_links([
                        'prev_text' => '<span class="prev hint--top" data-hint="'.apply_filters('overcome_loop_pagination_prev_text', esc_html__('Previous', 'overcome')).'"><span class="flaticon-arrow-pointing-to-left"></span></span>',
                        'next_text' => '<span class="next hint--top" data-hint="'.apply_filters('overcome_loop_pagination_next_text', esc_html__('Next', 'overcome')).'"><span class="flaticon-arrow-pointing-to-right"></span></span>'
                    ]); 
                echo '</div>';
                break;
            case '2':
                overcome_the_posts_pagination([
                    'prev_text' => '<span class="prev hint--top" data-hint="'.apply_filters('overcome_loop_pagination_prev_text', esc_html__('Previous', 'overcome')).'"><span>'.apply_filters('overcome_loop_pagination_prev_text', esc_html__('Previous', 'overcome')).'</span></span>',
                    'next_text' => '<span class="next hint--top" data-hint="'.apply_filters('overcome_loop_pagination_next_text', esc_html__('Next', 'overcome')).'"><span>'.apply_filters('overcome_loop_pagination_next_text', esc_html__('Next', 'overcome')).'</span></span>',
                    'class' => $args['class']
                ]);
                break;
            default:
                the_posts_navigation();
                break;
        }
        printf('%s','</div>');
        wp_reset_query();
    }
}

function overcome_get_the_posts_pagination( $args = array() ) {
    $navigation = '';
 
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
        // Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
        if ( ! empty( $args['screen_reader_text'] ) && empty( $args['aria_label'] ) ) {
            $args['aria_label'] = $args['screen_reader_text'];
        }
 
        $args = wp_parse_args(
            $args,
            array(
                'mid_size'           => 1,
                'prev_text'          => _x( 'Previous', 'previous set of posts' ,'overcome' ),
                'next_text'          => _x( 'Next', 'next set of posts' ,'overcome' ),
                'screen_reader_text' => esc_html__( 'Posts navigation' ,'overcome' ),
                'aria_label'         => esc_html__( 'Posts' ,'overcome' ),
                'class'              => ''
            )
        );
 
        // Make sure we get a string back. Plain is the next best thing.
        if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
            $args['type'] = 'plain';
        }
 
        // Set up paginated links.
        $links = paginate_links( $args );
 
        if ( $links ) {
            $navigation = _navigation_markup( $links, $args['class'], $args['screen_reader_text'], $args['aria_label'] );
        }
    }
 
    return $navigation;
}
function overcome_the_posts_pagination( $args = array() ) {
    echo overcome_get_the_posts_pagination($args);
}

add_filter('navigation_markup_template', 'overcome_navigation_markup_template', 10, 2);
function overcome_navigation_markup_template($template, $class){
    $template = '
        <nav class="navigation">
            <div class="nav-links %1$s">%3$s</div>
        </nav>
    ';
    return $template;
}

/**
 * Single post Author
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_post_author')){
    function overcome_post_author($args = array()){
        $args = wp_parse_args($args, array('layout' => '1'));
        extract( $args );
        $show_author = overcome_get_opts('post_author_info', '0');
        if('0' === $show_author || empty(get_the_author_meta('description'))) return;
        $user_info = get_userdata(get_the_author_meta('ID'));
    ?>
    <div class="author-box text-center text-md-<?php echo overcome_align();?>">
        <div class="row">
            <div class="author-avatar col-12 col-md-2 col-lg-auto"><?php 
                    echo get_avatar(get_the_author_meta('ID'));
            ?></div>
            <div class="author-info col">
                <div class="author-name text-capitalize">
                    <div class="h4"><?php the_author(); ?></div>
                    <small class="author-roles d-block"><?php echo implode(' / ', $user_info->roles); ?></small>
                </div>
                <div class="author-bio"><?php the_author_meta('description'); ?></div>
                <?php overcome_user_social(['class' => 'align-self-end w-100']); ?>
            </div>
        </div>
    </div>
    <?php
    }
}

/**
 * Display single post related
 * 
 * @since 1.0.0
 */
/**
 * Get custom post type taxonomy TAGS
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
            foreach ($tax_names as $name){
                if(strpos($name,apply_filters('overcome_post_related_by', 'cat')) !== false) {
                    $result = $name;
                }
            }
        }
        return $result;
    }
}
if(!function_exists('overcome_post_related')){
    function overcome_post_related( $args = array ()){
        global $post;
        /**
         * Parse incoming $args into an array and merge it with $defaults
         */ 
        $args = wp_parse_args($args, array(
            'title'          => esc_html__('Related Posts','overcome'), 
            'posts_per_page' => '2', 
            'columns'        => '2', 
            'carousel'       => apply_filters('overcome_post_related_carousel', false)
        ));
        extract($args);

        $show_related = overcome_get_theme_opt('post_related_on', '0');
        
        if('0' === $show_related) return;

        if($carousel) {
            $col = '';
        } else {
            $col = 'col-md-'.round(12 / $columns);
        }

        //for use in the loop, list 2 posts related to first tag on current post
        $tag_tax_name = overcome_get_custom_post_tag_taxonomy();
        $post = get_post();
        $tags = get_the_terms($post->ID,$tag_tax_name);
        $rtl = is_rtl() ? true : false;
        if ($tags && $show_related) {
            $_tag = array();
            foreach ($tags as $tag) {
                $_tag[] = $tag->slug;
            }        
            $args=array(
                'post_type' => get_post_type(),
                'tax_query' => array(
                    array(
                        'taxonomy' => $tag_tax_name,
                        'field'    => 'slug',
                        'terms'    => $_tag,
                    ),
                ),
                'post__not_in'          => array($post->ID),
                'posts_per_page'        => $posts_per_page,
                'ignore_sticky_posts'   => 1
            );
            $related_query = new WP_Query($args);
            if( $related_query->have_posts() ) {
                echo '<div class="ef5-related">';
                echo '<div class="related-title h2"><span>'.esc_html($title).'</span></div>';
                echo '<div class="ef5-grid row" id="ef5-single-post-related">';
                while ($related_query->have_posts()) : $related_query->the_post(); 
                    echo '<div class="ef5-grid-item '.esc_attr($col).'">';
                        get_template_part( 'template-parts/loop/content-related', get_post_format() );
                    echo '</div>';
                endwhile;
                echo '</div></div>';
            }
            wp_reset_postdata();
        }
    }
}
/**
 * Single Post Pagination 
*/
if(!function_exists('overcome_post_navigation')){
    function overcome_post_navigation($args = []){
        $args = wp_parse_args($args, [
            'layout' => '1'
        ]);
        $navigation = get_the_post_navigation();
        $previous = get_previous_post_link(
            '<div class="nav-previous">%link</div>',
            '<div class="meta-nav">'.esc_html__('Previous Post','overcome').'</div><div class="post-title h4">%title</div>'
        );
     
        $next = get_next_post_link(
            '<div class="nav-next">%link</div>',
            '<div class="meta-nav">'.esc_html__('Next Post','overcome').'</div><div class="post-title h4">%title</div>'
        );
        $nav_links = ['nav-links'];
        if(empty($previous)) $nav_links[] = 'justify-content-end';
        if ( is_singular( 'attachment' ) ) {
            // Parent post navigation.
            the_post_navigation(
                array(
                    'prev_text' => _x( '<span class="meta-nav">Published in</span><br/><span class="post-title">%title</span>', 'Parent post link', 'overcome' ),
                )
            );
        } elseif ( is_singular( 'post' ) ) {
            // Previous/next post navigation.
            switch ($args['layout']) {
                default:
            ?>
                <nav class="navigation post-navigation">
                    <div class="<?php echo implode(' ', $nav_links);?>">
                        <?php echo overcome_html($previous.$next) ?>
                    </div>
                </nav>
            <?php
                break;
            }
        } elseif (is_singular('ef5_portfolio')){
            overcome_portfolio_navigation($args);
        }
    }
}

/**
 * Single portfolio navigation 
 *
 * @since 1.0.0
*/
if(!function_exists('overcome_portfolio_navigation')){
    function overcome_portfolio_navigation($args = array()){
        $args = wp_parse_args($args, array('layout' => '1'));
        extract( $args );
        $prevthumbnail = $nextthumbnail = '';
        $prevPost = get_previous_post();
        $nextPost = get_next_post();
        if(!$prevPost && !$nextPost) return;

        $portfolio_archive_page = overcome_get_opts('portfolio_page','-1');

        if($portfolio_archive_page === '-1')
            $portfolio_archive_link = get_post_type_archive_link( 'ef5_portfolio' );
        else 
            $portfolio_archive_link = overcome_get_link_by_slug($portfolio_archive_page, 'page');

        switch ($layout) {
            case '2':
                if($prevPost) { ?>
                    <a href="<?php the_permalink($prevPost->ID);?>" class="hint--top" data-hint="<?php echo get_the_title($prevPost->ID); ?>"><span class="flaticon-left-arrow-1"></span></a>            
                <?php } ?>
                <a href="<?php echo esc_url($portfolio_archive_link); ?>" class="archive-link hint--top" data-hint="<?php esc_html_e('View All Projects','overcome');?>"><span class="flaticon-menu"></span></a>
                <?php if($nextPost) { ?>
                    <a href="<?php the_permalink($nextPost->ID);?>" class="hint--top" data-hint="<?php echo get_the_title($nextPost->ID); ?>">
                    <span class="flaticon-right-arrow-1"></span></a>   
                <?php }
            break;
            default:
        ?>
        <nav class="post-navigation portfolio-navigation">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-2 order-md-2 text-center">
                    <a href="<?php echo esc_url($portfolio_archive_link); ?>" class="archive-link"><span class="fa fa-th-large"></span></a>
                </div>
                <div class="nav-box previous col-sm-auto col-md-5 order-md-1 text-<?php echo overcome_align();?>">
                    <?php if($prevPost) { ?>
                        <a class="nav-link" href="<?php the_permalink($prevPost->ID);?>">
                            <div class="meta-nav"><?php esc_html_e('Previous Post','overcome'); ?></div>
                            <div class="post-title h6"><?php echo get_the_title($prevPost->ID); ?></div>
                        </a>            
                    <?php } ?>
                </div>
                <div class="nav-box next col-sm-auto col-md-5 order-md-3 text-<?php echo overcome_align2();?>">
                    <?php if($nextPost) { ?>
                        <a class="nav-link" href="<?php the_permalink($nextPost->ID);?>">
                            <div class="meta-nav"><?php esc_html_e('Next Post','overcome'); ?></div>
                            <div class="post-title h6"><?php echo get_the_title($nextPost->ID); ?></div>
                        </a>   
                    <?php } ?>
                </div>
            </div>
        </nav>
        <?php
            break;
        }
    }
}