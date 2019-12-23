<?php
/**
 * The main template file
 *
 * @package EF5 Theme
 * @subpackage EF5Frame
 * @since 1.0.0
 * @author EF5 Team
 *
 */
get_header();
?>
    <div class="container">
        <div class="row">
            <div id="ef5-content-area" class="<?php ef5frame_content_css_class();?>">
                <div id="ef5-posts" class="ef5-posts ef5-blogs">
                    <?php
                    if ( have_posts() )
                    {
                        while ( have_posts() )
                        {
                            the_post();
                            get_template_part( 'template-parts/loop/content', get_post_format() );
                        }
                        ef5frame_loop_pagination(['class' => 'justify-content-center']);
                    }
                    else
                    {
                        get_template_part( 'template-parts/content', 'none' );
                    }
                    ?>
                </div>
            </div>
            <?php ef5frame_sidebar(); ?>
        </div>
    </div>
<?php
get_footer();