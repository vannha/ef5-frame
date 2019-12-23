<?php
/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param string $template_name Template name.
 * @param array  $args          Arguments. (default: array).
 * @param string $template_path Template path. (default: '').
 * @param string $default_path  Default path. (default: '').
 */
function overcome_get_template($slug, $name, $args = array()) {
	do_action( "get_template_part_{$slug}", $slug, $name );
	$templates = "{$slug}-{$name}.php";	
	require_once get_template_directory().'/'.$templates;
}

