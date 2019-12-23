<?php
if ( ! class_exists( 'ReduxFrameworkInstances' ) )
{
    return;
}

class OverCome_CSS_Generator
{
    /**
     * Compiler class instance
     *
     * @access protected
     * @var scssc
     */
    protected $scssc = null;

    /**
     * ReduxFramework class instance
     *
     * @access protected
     * @var ReduxFramework
     */
    protected $redux = null; 
    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';

    /*
     * Theme Color
    */

    /**
     * Constructor
     */
    function __construct()
    {
        $this->opt_name = overcome_get_theme_opt_name();

        if ( empty( $this->opt_name ) )
        {
            return;
        }
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
        /* save option generate css */
        add_action("redux/options/{$this->opt_name}/saved", array($this, 'generate_file'));
    }
    /**
     * init hook - 10
     */
    function init()
    {
        if ( ! class_exists( '\Leafo\ScssPhp\Compiler' ) )
        {
            return;
        }
        $this->redux = ReduxFrameworkInstances::get_instance( $this->opt_name );
        if ( empty( $this->redux ) || ! $this->redux instanceof ReduxFramework )
        {
            return;
        }
        $this->dev_mode = overcome_get_theme_opt('dev_mode', false);

        if ( $this->dev_mode )
        {
            $this->generate_file();
            $this->generate_min_file();
            $this->generate_editor_style();
            // tribe event
            $this->generate_tribe_events_css();
        }
        else
        {
            add_action( "redux/options/{$this->opt_name}/saved", array( $this, 'generate_file' ) );
        }
    }

    /**
     * Generate options and css files
     */
    function generate_file()
    {   
        if(!class_exists('\Leafo\ScssPhp\Compiler')) return;
        // Theme
        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/css/';
        $css_file = $css_dir . 'theme.css';
        // Child Theme
        $child_scss_dir = get_stylesheet_directory() . '/assets/scss/';
        $child_css_dir  = get_stylesheet_directory() . '/assets/css/';
        $child_css_file = $child_css_dir . 'child-theme.css';

        $this->scssc = new \Leafo\ScssPhp\Compiler();
        $this->scssc->setImportPaths( $scss_dir );

        $_options = $scss_dir . 'options.scss';

        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => $this->options_output()
        ) );
            
        /**
         * build source map
         * this used for load scss file when dev_mode is on
         * @source: https://github.com/leafo/scssphp/wiki/Source-Maps
        */
        $this->scssc->setSourceMap(\Leafo\ScssPhp\Compiler::SOURCE_MAP_FILE);
        if(is_child_theme()){
            $this->scssc->setSourceMapOptions(array(
                'sourceMapWriteTo'  => $child_css_file . ".map",
                'sourceMapURL'      => "child-theme.css.map",
                'sourceMapFilename' => $child_css_file,
                'sourceMapBasepath' => $child_scss_dir,
                'sourceRoot'        => $child_scss_dir,
            ));
        } else {
            $this->scssc->setSourceMapOptions(array(
                'sourceMapWriteTo'  => $css_file . ".map",
                'sourceMapURL'      => "theme.css.map",
                'sourceMapFilename' => $css_file,
                'sourceMapBasepath' => $scss_dir,
                'sourceRoot'        => $scss_dir,
            ));
        }
        // end build source map
        
        /* $this->scssc->setFormatter('Leafo\ScssPhp\Formatter\Nested'); */
        $this->scssc->setFormatter('Leafo\ScssPhp\Formatter\Crunched');
        
        $this->redux->filesystem->execute( 'put_contents', $css_file, array(
            'content' => $this->scssc->compile( '@'.'import "theme.scss"' )
        ) );
        if(is_child_theme()){
            $this->redux->filesystem->execute( 'put_contents', $child_css_file, array(
                'content' => $this->scssc->compile( '@'.'import "child-theme.scss"' )
            ) );
        }
    }

    /**
     * Generate options and css files
     */
    function generate_min_file()
    {   
        // Theme
        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/css/';
        $css_file = $css_dir . 'theme.min.css';
        // Child Theme
        $child_scss_dir = get_stylesheet_directory() . '/assets/scss/';
        $child_css_dir  = get_stylesheet_directory() . '/assets/css/';
        $child_css_file = $child_css_dir . 'child-theme.min.css';

        $this->scssc = new \Leafo\ScssPhp\Compiler();
        $this->scssc->setImportPaths( $scss_dir );

        $_options = $scss_dir . 'options.scss';

        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => $this->options_output()
        ) );
        $this->scssc->setFormatter( 'Leafo\ScssPhp\Formatter\Crunched' );
        
        // Theme
        $this->redux->filesystem->execute( 'put_contents', $css_file, array(
            'content' => $this->scssc->compile( '@'.'import "theme.scss"' )
        ) );
        // Child Theme
        if(is_child_theme()){
            $this->redux->filesystem->execute( 'put_contents', $child_css_file, array(
                'content' => $this->scssc->compile( '@'.'import "child-theme.scss"' )
            ) );
        }
    }
    
    /**
     * Generate Editor css files
     */
    function generate_editor_style()
    {   
        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/admin/css/';

        $this->scssc = new \Leafo\ScssPhp\Compiler();
        $this->scssc->setImportPaths( $scss_dir );

        $editor_file = $css_dir . 'editor.css';
        $admin_file = $css_dir . 'admin.css';
        $this->scssc->setFormatter( 'Leafo\ScssPhp\Formatter\Crunched' );
        
        $this->redux->filesystem->execute( 'put_contents', $editor_file, array(
            'content' => $this->scssc->compile( '@'.'import "editor.scss"' )
        ) );
        $this->redux->filesystem->execute( 'put_contents', $admin_file, array(
            'content' => $this->scssc->compile( '@'.'import "admin.scss"' )
        ) );
    }

    /**
     * Tribe Events
     */
    function generate_tribe_events_css()
    {   
        // Theme
        $scss_dir = get_template_directory() . '/assets/scss/tribe-events/';
        $css_dir  = get_template_directory() . '/tribe-events/';
        $css_file = $css_dir . 'tribe-events.css';
        // Child Theme
        $child_scss_dir = get_stylesheet_directory() . '/assets/scss/tribe-events/';
        $child_css_dir  = get_stylesheet_directory() . '/tribe-events/';
        $child_css_file = $child_css_dir . 'tribe-events.css';

        $this->scssc = new \Leafo\ScssPhp\Compiler();
        $this->scssc->setImportPaths( $scss_dir );

        
        $this->scssc->setFormatter( 'Leafo\ScssPhp\Formatter\Crunched' );
        
        // Theme
        $this->redux->filesystem->execute( 'put_contents', $css_file, array(
            'content' => $this->scssc->compile( '@'.'import "tribe-events.scss"' )
        ) );
        // Child Theme
        if(is_child_theme()){
            $this->redux->filesystem->execute( 'put_contents', $child_css_file, array(
                'content' => $this->scssc->compile( '@'.'import "tribe-events.scss"' )
            ) );
        }
    }

    /**
     * Output options to _variables.scss
     *
     * @access protected
     * @return string
     */
    protected function options_output()
    {
        ob_start();
        //Colors
        $primary_color          = 'var(--primary-color)';
        $accent_color           = 'var(--accent-color)';
        $darkent_accent_accent  = 'var(--darkent-accent-color)';
        $lightent_accent_accent = 'var(--lightent-accent-color)';
        $secondary_color        = 'var(--secondary-color)';
        $thirdary_color         = 'var(--thirdary-color)';
        $fourth_color           = 'var(--fourth-color)';
        $fourth_color_07           = 'var(--fourth-color-07)';
        printf('$primary_color:%s;',$primary_color);
        printf('$accent_color:%s;',$accent_color);
        printf('$darkent_accent_accent:%s;',$darkent_accent_accent);
        printf('$lightent_accent_accent:%s;',$lightent_accent_accent);
        printf('$secondary_color:%s;',$secondary_color);
        printf('$thirdary_color:%s;',$thirdary_color);
        printf('$fourth_color:%s;',$fourth_color);
        printf('$fourth_color_07:%s;',$fourth_color_07);
        printf('$invalid_color:%s;',overcome_configs('invalid_color'));
        printf('$color_red:%s;',overcome_configs('color_red'));
        printf('$color_green:%s;',overcome_configs('color_green'));
        printf('$white:%s;',overcome_configs('white'));
        
        // Theme Color 
        printf('$ef5-colors:(%s);',ef5systems_colors_option_for_scss());
        // Theme Font Size 
        printf('$ef5-font-sizes:(%s);',ef5systems_font_sizes_option_for_scss());
        // Theme Font Size 
        printf('$ef5-font-line-height:(%s);',ef5systems_font_line_height_option_for_scss());
        // Theme Spacings
        printf('$ef5-spacings:(%s);',ef5systems_spacing_option_for_scss());
        // Theme Gutters
        printf('$ef5-gutters:(%s);',ef5systems_gutter_option_for_scss());
        // Typography 
        printf( '$BodyBG: %s;', overcome_configs('body_bg'));
        printf( '$BodyFont: %s;', overcome_configs('body_font'));
        printf( '$BodyFontSize: %s;', overcome_configs('body_font_size'));
        printf( '$BodyLineHeight: %s;',overcome_configs('body_line_height'));
        printf( '$BodyFontSizeL: %s;', overcome_configs('body_font_size_large'));
        printf( '$BodyFontSizeM: %s;', overcome_configs('body_font_size_medium'));
        printf( '$BodyFontSizeS: %s;', overcome_configs('body_font_size_small'));
        printf( '$BodyFontSizeXS: %s;', overcome_configs('body_font_size_xsmall'));
        printf( '$BodyFontSizeXXS: %s;', overcome_configs('body_font_size_xxsmall'));
        printf( '$BodyColor: %s;', overcome_configs('body_font_color'));
        printf( '$H1Size: %s;', overcome_configs('h1_size'));
        printf( '$H2Size: %s;', overcome_configs('h2_size'));
        printf( '$H3Size: %s;', overcome_configs('h3_size'));
        printf( '$H4Size: %s;', overcome_configs('h4_size'));
        printf( '$H5Size: %s;', overcome_configs('h5_size'));
        printf( '$H6Size: %s;', overcome_configs('h6_size'));
        printf( '$HeadingFont: %s;', overcome_configs('heading_font'));
        printf( '$HeadingColor: %s;', overcome_configs('heading_color'));
        printf( '$HeadingColorHover: %s;', overcome_configs('heading_color_hover'));
        printf( '$HeadingFontW: %s;', overcome_configs('heading_font_weight'));
        printf( '$MetaFont : %s;', overcome_configs('meta_font'));
        printf( '$MetaColor: %s;', overcome_configs('meta_color'));
        printf( '$MetaColorHover: %s;', overcome_configs('meta_color_hover'));
        // Border
        printf( '$MainBorder: %s;', overcome_configs('main_border'));
        printf( '$MainBorder2: %s;', overcome_configs('main_border2'));
        printf( '$MainBorderColor: %s;', overcome_configs('main_border_color'));
        // Comments
        printf( '$cmt_avatar_size: %s;', overcome_configs('cmt_avatar_size'));
        printf( '$cmt_border: %s;', overcome_configs('cmt_border'));
        /* Main Menu Height */
        printf('$main_menu_height:%s;', 'var(--main-menu-height)');
        
        /* Header side width */
        $header_sidewidth = overcome_get_theme_opt('header_sidewidth',['width' => apply_filters('overcome_header_sidewidth',overcome_configs('header_sidewidth'))]);
        printf('$header_sidewidth: %s;', esc_attr($header_sidewidth['width']));

        /* Default Header Color */
        printf( '$header_regular: %s;', 'var(--header_regular)' );
        printf( '$header_hover: %s;','var(--header_hover)' );
        printf( '$header_active: %s;','var(--header_active)' );

        /* Ontop Header Color */
        printf( '$ontop_regular: %s;', 'var(--ontop_regular)' );
        printf( '$ontop_hover: %s;', 'var(--ontop_hover)' );
        printf( '$ontop_active: %s;', 'var(--ontop_active)' );
        printf( '$header_ontop_top_space: %s;', 'var(--header_ontop_top_space)' );

        /* Sticky Header Color */
        printf( '$sticky_regular: %s;', 'var(--sticky_regular)' );
        printf( '$sticky_hover: %s;', 'var(--sticky_hover)' );
        printf( '$sticky_active: %s;', 'var(--sticky_active)' );

        /* Dropdown && Mobile */
        printf('$dropdown_bg: %s;', 'var(--dropdown_bg)');
        $dropdown_link_colors = overcome_get_theme_opt('dropdown_link_colors', apply_filters('overcome_dropdown_link_colors',['regular' => overcome_configs('dropdown_regular'), 'hover' => overcome_configs('dropdown_hover'), 'active' => overcome_configs('dropdown_active')]) );
        printf( '$dropdown_regular: %s;', 'var(--dropdown_regular)' );
        printf( '$dropdown_hover: %s;', 'var(--dropdown_hover)') ;
        printf( '$dropdown_active: %s;', 'var(--dropdown_active)'  );

        /* Side Header Width */

        /* WooCommerce */
        printf( '$overcome_product_single_image_w: %s;', overcome_configs('overcome_product_single_image_w') );
        printf( '$overcome_product_single_image_h: %s;', overcome_configs('overcome_product_single_image_h') );
        
        printf( '$overcome_product_loop_image_w: %s;', overcome_configs('overcome_product_loop_image_w') );
        printf( '$overcome_product_loop_image_h: %s;', overcome_configs('overcome_product_loop_image_h') );

        printf( '$overcome_product_gallery_thumbnail_w: %s;', overcome_configs('overcome_product_gallery_thumbnail_w') );
        printf( '$overcome_product_gallery_thumbnail_h: %s;', overcome_configs('overcome_product_gallery_thumbnail_h') );

        printf( '$overcome_product_gallery_thumbnail_v_w: %s;', overcome_configs('overcome_product_gallery_thumbnail_v_w') );
        printf( '$overcome_product_gallery_thumbnail_v_h: %s;', overcome_configs('overcome_product_gallery_thumbnail_v_h') );

        printf( '$overcome_product_gallery_thumbnail_h_w: %s;', overcome_configs('overcome_product_gallery_thumbnail_h_w') );
        printf( '$overcome_product_gallery_thumbnail_h_h: %s;', overcome_configs('overcome_product_gallery_thumbnail_h_h') );

        printf( '$overcome_product_gallery_thumbnail_space: %s;', overcome_configs('overcome_product_gallery_thumbnail_space') );


        return ob_get_clean();
    }

    /**
     * Hooked wp_enqueue_scripts - 20
     * Make sure that the handle is enqueued from earlier wp_enqueue_scripts hook.
     */
    function enqueue()
    {
        $css = $this->inline_css();

        if ( $css )
        {
            wp_add_inline_style( 'overcome', $css );
        }
    }

    /**
     * Generate inline css based on theme options
     */
    protected function inline_css()
    {
        ob_start();
        /**
         * Header side menu 
         *
        */
        $header_sidewidth = overcome_get_theme_opt('header_sidewidth', ['width' => ''] );
        $header_sidewidth_page = overcome_get_page_opt('header_sidewidth', ['width' => ''] );
        if($header_sidewidth_page['width'] !== 'px' && $header_sidewidth_page['width'] !== $header_sidewidth['width']){
            $header_sidewidth['width'] = $header_sidewidth_page['width'];
        }
        if('' !== $header_sidewidth['width'] && 'px' !== $header_sidewidth['width']){
            echo '@media (min-width: 1200px){';
                printf(
                    'body.header-3:not(.side-header-ontop){
                        padding-%s: %s !important;
                    }', overcome_align(), esc_attr($header_sidewidth['width'])
                );
                //  Header side menu width
                printf(
                    '.side-header{
                        width: %s !important;
                    }', esc_attr($header_sidewidth['width'])
                );
                //  Fix loading position
                printf(
                    'body.header-3 #ef5-loading{
                        margin-%s: calc(%s / -2) !important;
                    }', overcome_align(), esc_attr($header_sidewidth['width'])
                );
            echo '}';
        }
        /**
         * Site Bordered
        */
        $site_layout = overcome_get_opts('site_layout', '');
        $site_bordered = overcome_get_opts('site_bordered_w',['padding-top'=>'30px','padding-right'=>'30px','padding-bottom'=>'30px','padding-left'=>'30px','units'=>'px']);
        $_site_bordered = $site_bordered['padding-top'].' '.$site_bordered['padding-right'].' '.$site_bordered['padding-bottom'].' '.$site_bordered['padding-left'];
        if($site_layout === 'bordered'){
            echo '@media (min-width: 1200px){';
                printf(
                    '.site-bordered{
                        padding: %s !important;
                    }', esc_attr($_site_bordered)
                );
            echo '}';
        }

        return ob_get_clean();
    }
}

new OverCome_CSS_Generator();