<?php
/**
 * Template part for displaying posts in loop
 *
 * @package EF5 Theme
 * @subpackage OverCome
 */
?>

<div <?php post_class('related-item'); ?>>
    <?php 
        overcome_post_media();
        overcome_post_header(['heading_tag' => 'h3'])
    ?>
</div>