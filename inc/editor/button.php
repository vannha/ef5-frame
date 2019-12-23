<?php 
add_action('init', 'ef5_editor_button');
function ef5_editor_button() { 
    /* check user permissions */
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }
    /* check if WYSIWYG is enabled */
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "ef5_add_editor_plugin");
        add_filter('mce_buttons', 'ef5_register_editor_button');
    }
}
function ef5_add_editor_plugin($plugin_array) {
    $plugin_array['ef5_highlight'] = get_template_directory_uri().'/inc/editor/button.js';
    $plugin_array['ef5_list'] = get_template_directory_uri().'/inc/editor/button.js';
    $plugin_array['ef5_quote'] = get_template_directory_uri().'/inc/editor/button.js';
    return $plugin_array;
}
function ef5_register_editor_button($buttons) {
    array_push($buttons, 'ef5_highlight', 'ef5_list', 'ef5_quote');
    return $buttons;
}
?>