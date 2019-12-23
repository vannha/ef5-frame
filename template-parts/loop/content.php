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
$classes = ['ef5-list'];
if(is_archive() || is_home() || is_front_page() || is_search()) $classes[] = 'ef5-archive';
?>

<div <?php post_class(trim(implode(' ', $classes))); ?>>
    <?php ef5frame_post_media(['thumbnail_size' => 'large']); ?>
    <div class="ef5-loop-info"><?php
            ef5frame_post_header(['class' => 'loop ef5-loop-header']);
            ef5frame_post_excerpt();
            ef5frame_link_pages();
        ?>
        <div class="ef5-loop-footer row justify-content-between align-items-center empty-none"><?php 
            do_action('ef5frame_loop_footer'); 
            ef5frame_tagged_in(['before' => '<div class="col-auto">','after'=>'</div>']);
            ef5frame_post_share(['class' => 'col-auto']); 
        ?></div>
        <div class="ef5-loop-readmore"><?php ef5frame_post_read_more(); ?></div>
    </div>
</div>