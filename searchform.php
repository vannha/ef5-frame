<?php
/**
 * Search Form
 * 
 * @package EF5 Theme
 * @subpackage EF5Frame
 * @since 1.0.0
 * @author EF5 Team
 *
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div class="searchform-wrap">
        <input type="text" placeholder="<?php esc_attr_e('Search here...', 'ef5-frame'); ?>" name="s" class="search-field" />
        <button type="submit"><?php esc_html_e('Search','ef5-frame'); ?></button>
    </div>
</form>