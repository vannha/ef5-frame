<?php
/**
 * The template for displaying single post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
                <div class="ef5-blogs">
                <?php
                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/single/content', get_post_format() );
                        // Post Navigation
                        ef5frame_post_navigation();
                        // About Author
                        ef5frame_post_author();
                        // Related
                        ef5frame_post_related();
                        // Comment
                        ef5frame_comment();
                    endwhile; // End of the loop.
                ?>
                </div>
            </div>
            <?php ef5frame_sidebar(); ?>
        </div>
    </div>
<?php
get_footer();