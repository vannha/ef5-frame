<?php
/**
 * Post Thumbnail
*/
if(!function_exists('overcome_post_thumbnail')){
    function overcome_post_thumbnail($args=[]){
        $args = wp_parse_args($args,[
            'id'              => null,
            'thumbnail_size'  => is_single() ? 'large' : 'medium',
            'echo'            => true,
            'default_thumb'   => overcome_configs('overcome_default_post_thumbnail'),
            'thumbnail_is_bg' => overcome_configs('overcome_thumbnail_is_bg'),
            'img_class'       => '',
            'show_image'      => true    
        ]);
        extract($args);
        if(!has_post_thumbnail() && !$default_thumb) return;

        $thumbnail_atts = [];
        // class
        $thumbnail_atts_class = ['post-image','ef5-post',$args['img_class']];
        if($thumbnail_is_bg) $thumbnail_atts_class[] = 'thumbnai-is-bg';
        $thumbnail_atts[] = 'class="'.implode(' ', $thumbnail_atts_class).'"';
        // style
        $thumbnail_atts_style = [];
        if($thumbnail_is_bg) $thumbnail_atts_style[] = 'background-image: url('.overcome_get_image_url_by_size(['id'=>$id,'size'=> 'full', 'default_thumb' => $default_thumb]).')';
        if(!empty($thumbnail_atts_style)) $thumbnail_atts[] = 'style="'.implode(';',$thumbnail_atts_style).'"';
        if($echo) {
        ?>
            <div <?php echo implode(' ', $thumbnail_atts);?>>
                <?php overcome_image_by_size(['id' => $id,'size' => $thumbnail_size, 'class' => $args['img_class'], 'show_image' => $show_image]);?>
            </div>
            <?php do_action('overcome_post_thumbnail_content');
        } else {
            return '<div '.implode(' ', $thumbnail_atts).'><img src="'.overcome_get_image_url_by_size(['id'=>$id,'size'=> 'full', 'default_thumb' => $default_thumb]).'" alt="'.get_the_title().'" class="'.$args['img_class'].'" /></div>'.do_action('overcome_post_thumbnail_content');
        }
    }
}

/**
 * Post Gallery 
*/
if(!function_exists('overcome_post_gallery')){
    function overcome_post_gallery($args=[]){
        $owl = [
            'items'              => 1,
            'margin'             => 0,
            'loop'               => false,
            'autoplay'           => true,
            'autoplayTimeout'    => 5000,
            'nav'                => true,
            'navClass'           => ['ef5-owl-nav-button ef5-owl-prev','ef5-owl-nav-button ef5-owl-next'],
            'navText'            => ['<span class="ef5-owl-nav-icon prev" data-title="'.esc_attr__('Previous','overcome').'"></span>', '<span class="ef5-owl-nav-icon next" data-title="'.esc_attr__('Next','overcome').'"></span>'],
            'dots'               => true,
            'dotsData'           => true,
            'dotClass'           => 'ef5-owl-dot',
            'autoHeight'         => true,
            'responsiveClass'    => true,
            'slideBy'            => 'page',
            'animateIn'        => 'fadeIn',
            'animateOut'        => 'fadeOut',
            'dot_thumbnail_size' => '138x97'
        ];
        $args = wp_parse_args($args, array(
            'id'             => null,
            'show_media'     => '1',
            'thumbnail_size' => 'large',
            'show_author'    => is_singular() ? overcome_get_opts('archive_author_on','1') : overcome_get_opts('post_author_on','1'),
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false),
            'light_box'      => overcome_get_post_format_value('post-gallery-lightbox', '1'),
            'source'         => 'post-gallery-images',
            'owl'            => [] 
        ));
        $args['owl'] = wp_parse_args($owl,$args['owl']);
        if('0' === $args['show_media']) return;
        // Get gallery from option
        $gallery_list = explode(',', overcome_get_post_format_value($args['source'], ''));
        // Get first gallery in content 
        $gallery_in_content = get_post_gallery( get_the_ID(), false );
        if($gallery_in_content && empty($gallery_list[0]) && !is_singular()){
            $gallery_list = isset($gallery_in_content['ids']) ? explode(',', $gallery_in_content['ids']) : [];
        }
        $light_box = $args['light_box'];  //overcome_get_post_format_value('post-gallery-lightbox', '1');
        global $post;
        if('1' === $light_box ) 
            $gallery_classes = ['ef5-gallery ef5-gallery-lightbox'];
        else 
            $gallery_classes = ['ef5-gallery-carousel'];
        if( !empty($gallery_list[0]) || has_post_thumbnail() ){
            if(!empty($gallery_list[0])){
                if($light_box === '0'){
                    //global $overcome_owl;
                    $gallery_classes[] = 'ef5-owl owl-carousel owl-theme ef5-nav-vertical';
                    wp_enqueue_script('owl-carousel');
                    wp_enqueue_script('ef5-owl-carousel');
                    wp_enqueue_style( 'owl-carousel');
                    $gal_id = 'gal-'.get_the_ID();
                    $rtl = is_rtl() ? true : false;
                    $icon_prev = is_rtl() ? 'right' : 'left';
                    $icon_next = is_rtl() ? 'left' : 'right';
                    $ef5systems_owl[$gal_id] = array_merge(
                        array(
                            'rtl'                => $rtl
                        ),
                        $args['owl']
                    );
                    wp_localize_script('owl-carousel', 'ef5systems_owl', $ef5systems_owl);
                } else {
                    wp_enqueue_script( 'magnific-popup' );
                    wp_enqueue_style( 'magnific-popup' );
                }
            ?>
                <div class="ef5-gallery-wrap ef5-single-gallery-wrap relative">
                    <div class="ef5-gallery-wrap-inner relative">
                        <div id="gal-<?php echo get_the_ID();?>" class="<?php echo trim(implode(' ', $gallery_classes));?>">
                            <?php 
                            if($light_box === '1'){

                                $d = 0; 
                                foreach ($gallery_list as $img_id): 
                                $d++;
                            ?>
                                <a 
                                    class="light-box" 
                                    href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>" 
                                    title="<?php echo esc_attr(get_post_meta( $img_id, '_wp_attachment_image_alt', true )) ?>" 
                                    data-effect="ef5-zoomIn"><?php if($light_box === '1' && $d === 1) { ?><img 
                                        src="<?php echo esc_url(overcome_get_image_url_by_size([
                                            'id'            => $img_id, 
                                            'size'          => $args['thumbnail_size'],
                                            'default_thumb' => true
                                        ]));?>"
                                        alt="<?php echo esc_attr(get_post_meta( $img_id, '_wp_attachment_image_alt', true )) ?>" /><?php } ?></a>
                            <?php
                                endforeach; 
                            } else {
                                foreach ($gallery_list as $img_id): 
                                $dot_thumb = '<img src="'.overcome_get_image_url_by_size([
                                        'id'            => $img_id, 
                                        'size'          => $args['owl']['dot_thumbnail_size'], 
                                        'default_thumb' => true
                                        ]).'"" alt = "'.get_the_title().'" />';
                                    
                            ?>
                                <div class="ef5-gallery-item" data-dot='<?php echo overcome_html($dot_thumb);?>'>
                                    <img src="<?php echo esc_url(overcome_get_image_url_by_size([
                                        'id'            => $img_id, 
                                        'size'          => $args['thumbnail_size'], 
                                        'default_thumb' => true
                                        ]));?>" alt="<?php echo esc_attr(get_post_meta( $img_id, '_wp_attachment_image_alt', true )) ?>" />
                                </div>
                            <?php
                                endforeach; 
                            }
                            ?>
                        </div>
                        <?php if($light_box === '0') {
                            overcome_loading_animation();
                            echo '<div class="ef5-owl-nav vertical inside"></div>';
                        } ?>
                    </div>
                    <?php if($light_box === '0') {
                        echo '<div class="ef5-owl-dots"></div>';
                    } ?>
                </div>
            <?php 
            } elseif(has_post_thumbnail()) {
                overcome_post_thumbnail($args);
            }
        }
    }
}
/**
 * Post Video
*/
if(!function_exists('overcome_post_video')){
    function overcome_post_video($args=[]){
        global $wp_embed;
        $args = wp_parse_args($args, [
            'video_url'      => 'post-video-url',
            'video_file'     => 'post-video-file',
            'video_html'     => 'post-video-html',
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false)
        ]);
        $video_url = overcome_get_post_format_value($args['video_url'], '');
        $video_file = overcome_get_post_format_value($args['video_file'], []);
            $video_file_id  = isset($video_file['id']) ? $video_file['id'] : '';
        $video_html = overcome_get_post_format_value($args['video_html'], '');

        // Only get video from the content if a playlist isn't present.
        $_video_in_content = apply_filters( 'the_content', get_the_content() );
        if ( false === strpos( $_video_in_content, 'wp-playlist-script' ) ) {
            $video_in_content = get_media_embedded_in_content( $_video_in_content, array( 'video', 'object', 'embed', 'iframe' ) );
        }
        $video = '';
        ob_start();
        if (!empty($video_url)) {
            $video = do_shortcode($wp_embed->autoembed($video_url));
        } elseif (!empty($video_file_id)) {
            /* Get default video poster */
            $poster = !empty(get_the_post_thumbnail_url($video_file_id)) ? get_the_post_thumbnail_url($video_file_id,'full') : get_the_post_thumbnail_url(get_the_ID(),'full');
            //attachment meta data 
            $att_data = wp_get_attachment_metadata($video_file_id);
            $mime_type = explode('/', $att_data['mime_type']);
            /* Build video */            
            $video_atts = array(
                'src'    => esc_url($video_file['url']),
                'poster' => esc_url($poster),
                'width'  => esc_attr($video_file['width']),
                'height' => esc_attr($video_file['height'])
            );
            switch ($mime_type[0]) {
                case 'audio':
                    $video = do_shortcode($wp_embed->autoembed($video_file['url']));
                    break;
                
                default:
                    if(!empty($poster))
                        $video = wp_video_shortcode($video_atts);
                    else 
                        $video = do_shortcode($wp_embed->autoembed($video_file['url']));
                    break;
            }            
        } elseif ('' != $video_html) {
            $_video_html = explode(',', $video_html);
            foreach ($_video_html as $value) {
                $video .= '<div class="video-item">'.do_shortcode($wp_embed->autoembed($value)).'</div>';
            }
        } elseif(! empty( $video_in_content ) && !is_singular()){
            // If not a single post, highlight the video file.
            foreach ( $video_in_content as $video_in_content_html ) {
                $video .= $video_in_content_html;
            }
        } else {
        	$video = overcome_post_thumbnail($args);
        }
        $video .= ob_get_clean();
        // Show video 
        if($args['echo'])
            echo apply_filters('overcome_post_video', $video);
        else 
            return $video;
    }
}

/**
 * Post Audio
*/
if(!function_exists('overcome_post_audio')){
    function overcome_post_audio($args = []){
        $args = wp_parse_args($args, [
            'audio_url'      => 'post-audio-url',
            'audio_file'     => 'post-audio-file',
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false)
        ]);
        global $wp_embed;
        $audio_url = overcome_get_post_format_value($args['audio_url'], '');
        $audio_file = overcome_get_post_format_value($args['audio_file'], ['id'=>'']);
        if(!empty($audio_file['id'])){
            /* Get default video poster */
            $poster = (is_array($audio_file) && !empty(get_the_post_thumbnail_url($audio_file['id']))) ? get_the_post_thumbnail_url($audio_file['id'],'full') : get_the_post_thumbnail_url(get_the_ID(),'full');
            //attachment meta data 
            $att_data = wp_get_attachment_metadata($audio_file['id']);
            $mime_type = explode('/', $att_data['mime_type']);
            /* Build audio */            
            $audio_atts = array(
                'src'    => esc_url($audio_file['url']),
                'poster' => esc_url($poster),
                'width'  => esc_attr($audio_file['width']),
                'height' => esc_attr($audio_file['height'])
            );
        }
        // get audion in content 
        $_audio_in_content = apply_filters( 'the_content', get_the_content() );
        // Only get audio from the content if a playlist isn't present.
        if ( false === strpos( $_audio_in_content, 'wp-playlist-script' ) ) {
            $audio_in_content = get_media_embedded_in_content( $_audio_in_content, array( 'audio' ) );
        }        
        $audio = '';
        ob_start();
        if(!empty($audio_url)){
            $audio =  do_shortcode($wp_embed->autoembed($audio_url));
        } elseif (!empty($audio_file['id'])) {
            switch ($mime_type[0]) {
                case 'audio':
                    $audio = do_shortcode($wp_embed->autoembed($audio_file['url']));
                    break;
                case 'application':
                    $audio = do_shortcode($wp_embed->autoembed($audio_file['url']));
                    break;
                
                default:
                    if(!empty($poster)){
                        $audio = wp_video_shortcode($audio_atts);
                    } else {
                        $audio = do_shortcode($wp_embed->autoembed($audio_file['url']));
                    }
                    break;
            }            
        } elseif(! empty( $audio_in_content ) && !is_singular()){
            // If not a single post, highlight the audio file.
            foreach ( $audio_in_content as $audio_in_content_html ) {
                $audio .= $audio_in_content_html;
            }
        } elseif ( has_post_thumbnail() ){
            $audio = overcome_post_thumbnail($args);
        }
        $audio .= ob_get_clean();
        // Show video 
        if($args['echo'])
            echo apply_filters('overcome_post_audio', $audio);
        else 
            return $audio;
    }
}
/**
 * Post Quote
*/
if(!function_exists('overcome_post_quote')){
    function overcome_post_quote($args = []){
        $args = wp_parse_args($args, [
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false)
        ]);
        $text = overcome_get_post_format_value('post-quote-text', '');
        $cite = overcome_get_post_format_value('post-quote-cite', '');
        $quote = '';
        $quote_attrs = $quote_style = [];
        $quote_css_class = ['quote-wrap'];
        
        // Inline Style
        $bg_img = overcome_get_image_url_by_size([
            'id'   => $args['id'],
            'size' => 'post-thumbnail'
        ]);
        if(!empty($bg_img)) {
            $quote_style[] = 'background-image:url('.$bg_img.')';
            $quote_css_class[] = 'has-bg';
        }
        $quote_attrs[] = 'class="'.trim(implode(' ', $quote_css_class)).'"';
        if(!empty($quote_style)) $quote_attrs[] = 'style="'.trim(implode(';', $quote_style)).'"'; 

        if(!empty($text) || !empty($cite)){
            $quote = '<div '.trim(implode(' ', $quote_attrs)).'><blockquote><div class="quote-text">'.$text.'</div><cite>'.$cite.'</cite></blockquote></div>';
        } else {
            $quote = overcome_post_thumbnail($args);
        }

        if($args['echo'])
            echo apply_filters('overcome_post_quote', $quote);
        else 
            return $quote;
    }
}
/**
 * Post Link
*/
if(!function_exists('overcome_post_link')){
    function overcome_post_link($args = []){
        $args = wp_parse_args($args, [
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false)
        ]);

        $title = overcome_get_post_format_value('post-link-title', esc_html__('View Our Portfolio','overcome'));
        //https://themeforest.net/user/zookastudio/portfolio
        $link = overcome_get_post_format_value('post-link-url', '');
        if(empty($link)) return;
        // Get first link in content 
        $link_in_content =  overcome_get_content_link(['echo' => false]);
        // Link attribute
        $link_attrs = $link_style = [];
        $link_css_class = ['link-wrap'];
        
        // Inline Style
        $bg_img = overcome_get_image_url_by_size([
            'id'            => $args['id'],
            'size'          => 'post-thumbnail', 
            'default_thumb' => true
        ]);
        if(!empty($bg_img)) {
            $link_style[] = 'background-image:url('.$bg_img.')';
            $link_css_class[] = 'has-bg';
        }
        $link_attrs[] = 'class="'.trim(implode(' ', $link_css_class)).'"';
        if(!empty($link_style)) $link_attrs[] = 'style="'.trim(implode(';', $link_style)).'"'; 

        if(!empty($link)) {
            // link
            $link = '<div '.trim(implode(' ', $link_attrs)).'><a href="'.esc_url($link).'" class="ef5-btn ef5-btn-df fill accent" target="_blank"><span>'.esc_html($title).'</span></a></div>';
        } elseif($link_in_content){
            // link 
            $link = '<div '.trim(implode(' ', $link_attrs)).'>' . overcome_get_content_link(['echo' => false]) . '</div>';
        } else {
            $link = overcome_post_thumbnail($args);
        }

        if($args['echo'])
            echo apply_filters('overcome_post_link', $link);
        else 
            return $link;
    }
}

/**
 * Post Image
 * @since 1.0.1
*/
if(!function_exists('overcome_post_image')){
    function overcome_post_image($args = []){
        $args = wp_parse_args($args, [
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false)
        ]);
        $image = $image_in_content = '';
        // Get first link in content 
        $image_in_content =  overcome_get_content_image(['echo' => false]);
        
        if(has_post_thumbnail()){
           $image =  overcome_post_thumbnail($args);
        } elseif(!empty($image_in_content) && !is_single()){
            // images
            $image =  overcome_get_content_image(['echo' => false]);
        }
        if($args['echo'])
            echo apply_filters('overcome_post_image', $image);
        else 
            return $image;
    }
}
/**
 * Post Media
 * @since 1.0.1
*/
if(!function_exists('overcome_post_media')){
    function overcome_post_media($args = []){
        $args = wp_parse_args($args, [
            'id'             => null,
            'thumbnail_size' => is_single() ? 'large' : 'medium',
            'echo'           => true,
            'default_thumb'  => apply_filters('overcome_default_post_thumbnail', false),
            'class'          => '',
            'before'         => '',
            'after'          => '',
            'img_class'      => ''   
        ]);
        do_action('overcome_before_post_media');
        $post_format = !empty(get_post_format()) ? get_post_format() : 'standard';

        $classes = [
            'ef5-featured',
            'ef5-'.$post_format,
        ];
        $classes[] = overcome_is_loop() ? 'loop' : 'single';
        if(!empty($args['class'])) $classes[] = $args['class'];
    ?>
    <div class="<?php echo trim(implode(' ', $classes));?>"><?php
        printf('%s', $args['before']);
        switch (get_post_format()) {
            case 'gallery':
                overcome_post_gallery($args);
                break;
            case 'video':
                overcome_post_video($args);
                break;
            case 'audio':
                overcome_post_audio($args);
                break;
            case 'quote':
                overcome_post_quote($args);
                break;
            case 'link':
                overcome_post_link($args);
                break;
             case 'image':
                overcome_post_image($args);
                break;
            default:
                overcome_post_thumbnail($args);
                break;
        }
        printf('%s', $args['after']);
        do_action('overcome_post_media_content');
    ?></div><?php
        do_action('overcome_after_post_media');
    }
}
if(!function_exists('overcome_loop_media')){
    function overcome_loop_media($args = []){
        $args = wp_parse_args($args, [
            'show_media'     => '1',
            'thumbnail_size' => 'large',
            'show_author'    => '1'
        ]);
        extract($args);
        if('1' !== $show_media) return;
        
        overcome_post_media($args); 
    }
}

/**
 * Post Author's on Media 
 * action hook : overcome_post_thumbnail_content
 * @since 1.0.0
*/
if(!function_exists('overcome_post_author_on_media')){
    function overcome_post_author_on_media($args = []){
        $args = wp_parse_args($args, [
			'echo'        => true,
			'show_author' => is_singular() ? overcome_get_opts('post_author_on','1') : overcome_get_opts('archive_author_on','1')
        ]);
        extract($args);

        if('1' !== $show_author) return;

        ob_start();
            echo '<div class="post-author">'
            .get_avatar(get_the_author_meta('ID'), 30,  '' , get_the_author(), array('class' => 'circle')).'&nbsp;&nbsp;'
            .esc_html__('By','overcome').':&nbsp;'
            .get_the_author_posts_link()
            .'</div>';
        if($args['echo'])
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}

/**
 * Post Category on Media
 * action hook: overcome_post_thumbnail_content
 * @since 1.0.0
 * add_action('overcome_post_thumbnail_content', 'overcome_post_category_on_media', 10);
*/
if(!function_exists('overcome_post_category_on_media')){
    function overcome_post_category_on_media($args =[]){
        $args = wp_parse_args($args, [
            'echo'     => true,
            'show_cat' => is_singular() ? overcome_get_opts('post_categories_on','1') : overcome_get_opts('archive_categories_on','1'),
            'taxonomy' => 'category',
            'before'   => '<span class="icon-pencil icon"></span>',
            'sep'      => ' / ',
            'after'    => ''
        ]);
        extract($args);
        if('1' !== $show_cat) return;

        ob_start();
            echo '<div class="post-category badge-info">'
            .get_the_term_list( get_the_ID(), $taxonomy, $before, $sep, $after )
            .'</div>';
        if($args['echo'])
            echo ob_get_clean();
        else 
            return ob_get_clean();
    }
}

/**
 * Read more on media 
 *
*/
if(!function_exists('overcome_post_readmore_on_media')){
    function overcome_post_readmore_on_media($args=[]){
        $args = wp_parse_args($args, [
            'icon' => 'fa fa-plus',

        ]);
        ob_start();
    ?>
        <a class="overlay gradient-btt" href="<?php the_permalink();?>">
            <span class="icon-readmore <?php echo esc_attr($args['icon']);?>"></span>
        </a>
    <?php
        echo ob_get_clean();
    }
}