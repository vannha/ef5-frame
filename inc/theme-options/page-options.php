<?php
function ef5frame_page_options_register($metabox)
{
    
    if (!$metabox->isset_args('page')) {
        $metabox->set_args('page', array(
            'opt_name'     => ef5frame_get_page_opt_name(),
            'display_name' => esc_html__('Page Settings', 'ef5-frame'),
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }

    $metabox->add_section('page', array(
        'title'  => esc_html__('General', 'ef5-frame'),
        'desc'   => esc_html__('General settings for the page.', 'ef5-frame'),
        'icon'   => 'el-icon-home',
        'fields' => array_merge(
            array(
                array(
                    'id'          => 'primary_color',
                    'type'        => 'color',
                    'title'       => esc_html__('Primary Color', 'ef5-frame'),
                    'transparent' => false,
                ),
                array(
                    'id'          => 'accent_color',
                    'type'        => 'color',
                    'title'       => esc_html__('Accent Color', 'ef5-frame'),
                    'transparent' => false,
                ),
                array(
                    'id'          => 'secondary_color',
                    'type'        => 'color',
                    'title'       => esc_html__('Secondary Color', 'ef5-frame'),
                    'transparent' => false,
                ),
            ),
            ef5frame_page_opts(true),
            ef5frame_general_opts(['default' => true])
        )
    ));
    $metabox->add_section('page', ef5frame_header_top_opts(['default' => true])); 
    $metabox->add_section('page', array(
        'title'  => esc_html__('Header', 'ef5-frame'),
        'desc'   => esc_html__('Header settings for the page.', 'ef5-frame'),
        'icon'   => 'el-icon-website',
        'fields' => array_merge(
            ef5frame_header_opts(['default' => true]),
            ef5frame_header_atts(true)
        )
    ));
    // Logo 
    $metabox->add_section('page', ef5frame_header_page_logo());
    // Ontop Header
    $metabox->add_section('page', ef5frame_ontop_header_opts(['default' => true,'subsection' => false]));

    $metabox->add_section('page', array(
        'title'  => esc_html__('Page Title', 'ef5-frame'),
        'desc'   => esc_html__('Settings for page header area.', 'ef5-frame'),
        'icon'   => 'el-icon-map-marker',
        'fields' => ef5frame_page_title_opts(['default' => true])
    ));

    $metabox->add_section('page', ef5frame_footer_opts(['default' => true]));

    /* Config Post Options */
    if (!$metabox->isset_args('post')) {
        $metabox->set_args('post', array(
            'opt_name'     => ef5frame_get_page_opt_name(),
            'display_name' => esc_html__('Post Settings', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default',
            'panels'   => true
        ));
    }

    $metabox->add_section('post', array(
        'title'  => esc_html__('General', 'ef5-frame'),
        'desc'   => esc_html__('General settings for this post.', 'ef5-frame'),
        'icon'   => 'el-icon-home',
        'fields' => array_merge(
            array(
                array(
                    'id'       => 'post_sidebar_pos',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layouts', 'ef5-frame'),
                    'subtitle' => esc_html__('select a layout for single...', 'ef5-frame'),
                    'options'  => array(
                        '-1'     => esc_html__('Default', 'ef5-frame'),
                        'left'   => esc_html__('Left Widget', 'ef5-frame'),
                        'right'  => esc_html__('Right Widget', 'ef5-frame'),
                        'none'   => esc_html__('No Widget (Full)', 'ef5-frame'),
                        'center' => esc_html__('No Widget (Center)', 'ef5-frame')
                    ),
                    'default'  => '-1'
                )
            )
        )
    ));
    $metabox->add_section('post', array(
        'title'  => esc_html__('Post Title', 'ef5-frame'),
        'desc'   => esc_html__('Settings for page header area.', 'ef5-frame'),
        'icon'   => 'el-icon-map-marker',
        'fields' => ef5frame_page_title_opts(['default' => true])
    ));

    /**
     * Config post format meta options
     *
    */
    if (!$metabox->isset_args('ef5_pf_audio')) {
        $metabox->set_args('ef5_pf_audio', array(
            'opt_name'     => 'post_format_audio',
            'display_name' => esc_html__('Audio', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }

    if (!$metabox->isset_args('ef5_pf_link')) {
        $metabox->set_args('ef5_pf_link', array(
            'opt_name'     => 'post_format_link',
            'display_name' => esc_html__('Link', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }

    if (!$metabox->isset_args('ef5_pf_quote')) {
        $metabox->set_args('ef5_pf_quote', array(
            'opt_name'     => 'post_format_quote',
            'display_name' => esc_html__('Quote', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }

    if (!$metabox->isset_args('ef5_pf_video')) {
        $metabox->set_args('ef5_pf_video', array(
            'opt_name'     => 'post_format_video',
            'display_name' => esc_html__('Video', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }

    if (!$metabox->isset_args('ef5_pf_gallery')) {
        $metabox->set_args('ef5_pf_gallery', array(
            'opt_name'     => 'post_format_gallery',
            'display_name' => esc_html__('Gallery', 'ef5-frame'),
            'class'        => 'fully-expanded'
        ), array(
            'context'  => 'advanced',
            'priority' => 'default'
        ));
    }
    $metabox->add_section('ef5_pf_video', array(
        'title'  => esc_html__('Video', 'ef5-frame'),
        'fields' => array(
            array(
                'id'    => 'post-video-url',
                'type'  => 'text',
                'title' => esc_html__( 'Video URL', 'ef5-frame' ),
                'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'ef5-frame' )
            ),

            array(
                'id'             => 'post-video-file',
                'type'           => 'media',
                'library_filter' => array('mp4','m4v','wmv','avi','mpg','ogv','3gp','3g2','ogg','mine'),
                'title'          => esc_html__( 'Video Upload', 'ef5-frame' ),
                'desc'           => esc_html__( 'Upload or Choose video file', 'ef5-frame' ), 
                'url'            => true                       
            ),

            array(
                'id'        => 'post-video-html',
                'type'      => 'textarea',
                'title'     => esc_html__( 'Embadded video', 'ef5-frame' ),
                'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'ef5-frame' )
            )
        )
    ));

    $metabox->add_section('ef5_pf_gallery', array(
        'title'  => esc_html__('Gallery', 'ef5-frame'),
        'fields' => array(
            array(
                'id'       => 'post-gallery-lightbox',
                'type'     => 'switch',
                'title'    => esc_html__('Lightbox?', 'ef5-frame'),
                'subtitle' => esc_html__('Enable lightbox for gallery images.', 'ef5-frame'),
                'default'  => true
            ),
            array(
                'id'          => 'post-gallery-images',
                'type'        => 'gallery',
                'title'       => esc_html__('Gallery Images ', 'ef5-frame'),
                'subtitle'    => esc_html__('Upload images or add from media library.', 'ef5-frame')
            )
        )
    ));

    $metabox->add_section('ef5_pf_audio', array(
        'title'  => esc_html__('Audio', 'ef5-frame'),
        'fields' => array(
            array(
                'id'       => 'post-audio-url',
                'type'     => 'text',
                'title'    => esc_html__('Audio URL', 'ef5-frame'),
                'description' => esc_html__('Audio file URL in format: mp3, ogg, wav.','ef5-frame'),
                'validate' => 'url',
                'msg'      => 'Url error!'
            ),
            array(
                'id'             => 'post-audio-file',
                'type'           => 'media',
                'library_filter' => array('mp3','m4a','ogg','wav'),
                'title'          => esc_html__( 'Add a audio', 'ef5-frame' ),
                'desc'           => esc_html__( 'Upload or Choose audio file', 'ef5-frame' ),                        
            ),
        )
    ));

    $metabox->add_section('ef5_pf_link', array(
        'title'  => esc_html__('Link', 'ef5-frame'),
        'fields' => array(
            array(
                'id'       => 'post-link-title',
                'type'     => 'text',
                'title'    => esc_html__('Title', 'ef5-frame'),
            ),
            array(
                'id'       => 'post-link-url',
                'type'     => 'text',
                'title'    => esc_html__('URL', 'ef5-frame'),
                'validate' => 'url',
                'msg'      => 'Url error!'
            )
        )
    ));

    $metabox->add_section('ef5_pf_quote', array(
        'title'  => esc_html__('Quote', 'ef5-frame'),
        'fields' => array(
            array(
                'id'       => 'post-quote-text',
                'type'     => 'textarea',
                'title'    => esc_html__('Quote Text', 'ef5-frame')
            ),
            array(
                'id'       => 'post-quote-cite',
                'type'     => 'text',
                'title'    => esc_html__('Cite', 'ef5-frame')
            )
        )
    ));
}
add_action('ef5_post_metabox_register', 'ef5frame_page_options_register');