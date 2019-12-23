<?php
/**
 * Template part for displaying posts in loop
 *
 * @package EF5 Theme
 * @subpackage EF5Frame
 * @since 1.0.0
 * @author EF5 Team
 *
 */
?>

<div <?php post_class('ef5-single clearfix'); ?>>
    <?php 
        ef5frame_post_header(['class' => 'ef5-single-header']);
        ef5frame_post_media(); 
        ef5frame_post_content(['class' => 'ef5-single-content']);
        ef5frame_link_pages(['class' => 'ef5-single-page-links']);
    ?>
    <div class="ef5-single-footer row justify-content-between align-items-center empty-none"><?php 
        do_action('ef5frame_single_post_footer');
        ef5frame_tagged_in(['class' => 'col-auto']);
        ef5frame_post_share(['class' => 'col-auto']); 
    ?></div>
</div>