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
 * @structure add_filter('ef5systems_extra_icons','overcome_extras_icons');
 * function overcome_extras_icons(){
	return [
		'fontname' => [
			'title'   => 'Font Name',
			'icon'    => overcome_iconpicker_fontname_icons(), // icons list
			'css'     => OVERCOME_ICON_FONT_DIR . 'fontname/fontname.css',
			'version' => '1.0'
		]
	];
 }
 * NOTE: replace 'overcome', 'Font Name' with your font name
*/
add_filter('ef5systems_extra_icons','overcome_extras_icons');
function overcome_extras_icons(){
	return [
		'overcome' => [
			'title'   => 'Over Come',
			'icon'    => overcome_iconpicker_overcome_icons(), // icons list
			'css'     => OVERCOME_ICON_FONT_DIR.'overcome/overcome.css',
			'version' => '1.0'
		]
	];
}