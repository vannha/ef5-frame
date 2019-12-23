<?php
/**
 * Template part for displaying posts in loop
 *
 * @package EF5 Theme
 * @subpackage EF5Frame
 */
?>

<div <?php post_class('related-item'); ?>>
    <?php 
        ef5frame_post_media();
        ef5frame_post_header(['heading_tag' => 'h3'])
    ?>
</div>