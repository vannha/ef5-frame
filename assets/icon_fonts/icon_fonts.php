<?php
define('OVERCOME_ICON_FONT_DIR' , get_template_directory_uri() . '/assets/icon_fonts/');
/**
 * EF5 Systems supported some icon font
 * like: Elegant, ET Line, Flaticon, Linear, Pe7 Stroke, Simple Line
 * use filter: ef5systems_default_extra_icons
 * example: 
 	add_filter('ef5systems_default_extra_icons','custom_ef5systems_default_extra_icons');
	function custom_ef5systems_default_extra_icons(){
		return ['flaticon','linear'];
	}
*/

/**
 * Add filter to support your icon font in Mega Menu and VC 
 * user filter: ef5systems_extra_icons
 * @structure add_filter('ef5systems_extra_icons','ef5frame_extras_icons');
 * function ef5frame_extras_icons(){
	return [
		'fontname' => [
			'title'   => 'Font Name',
			'icon'    => ef5frame_iconpicker_fontname_icons(), // icons list
			'css'     => OVERCOME_ICON_FONT_DIR . 'fontname/fontname.css',
			'version' => '1.0'
		]
	];
 }
 * NOTE: replace 'ef5-frame', 'Font Name' with your font name
*/
add_filter('ef5systems_extra_icons','ef5frame_extras_icons');
function ef5frame_extras_icons(){
	return [
		'ef5-frame' => [
			'title'   => 'Over Come',
			'icon'    => ef5frame_iconpicker_ef5frame_icons(), // icons list
			'css'     => OVERCOME_ICON_FONT_DIR.'overcome/overcome.css',
			'version' => '1.0'
		]
	];
}