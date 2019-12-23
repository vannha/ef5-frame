<?php
/**
 * Add new option avatar to admin
 * add_action('switch_theme', 'ef5frame_update_avatar');
 *
*/
function ef5frame_update_avatar(){
	$ef5_avatar = get_template_directory_uri() . '/assets/images/avatar.png';
	if (get_option($ef5_avatar, '') != $ef5_avatar)
		update_option( 'avatar_default' , $ef5_avatar );
}
 
/** 
 * add a new default avatar to the list in WordPress admin
 * add_filter( 'avatar_defaults', 'ef5frame_default_avatar' );
 */
function ef5frame_default_avatar( $avatar_defaults ) {
	$ef5_avatar = get_template_directory_uri() . '/assets/images/avatar.png';
	$avatar_defaults[$ef5_avatar] = esc_html__('EF5Frame Avatar','ef5-frame');
	return $avatar_defaults;
}

/**
 * Returns the size for avatars used in the theme.
 * add_filter('woocommerce_review_gravatar_size', 'ef5frame_get_avatar_size');
 *
 */
if(!function_exists('ef5frame_get_avatar_size')){
	function ef5frame_get_avatar_size() {
		return ef5frame_configs('cmt_avatar_size');
	}
}

/**
 * An example to use filter get_avatar
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/get_avatar
 * add_filter( 'get_avatar' , 'ef5frame_custom_avatar' , 1 , 6 );
 * 
*/
if(!function_exists('ef5frame_custom_avatar')){
	function ef5frame_custom_avatar($avatar, $id_or_email, $size, $default, $alt, $args) {
	    if ( is_object( $id_or_email )) {
			$alt = $id_or_email->comment_author;
		} elseif ( is_numeric( $id_or_email ) ) {
	        $id = (int) $id_or_email;
	        $user = get_user_by( 'id' , $id );
	        $alt = $user->user_nicename;
    	} else {
    		$user = get_user_by( 'email', $id_or_email );
    		if(!$user){
    			$alt = $id_or_email;
    		}else{
	        	$alt = $user->data->user_nicename;
    		}
    	}
		$url = $args['url'];
		$url2x = get_avatar_url( $id_or_email, array_merge( $args, array( 'size' => $args['size'] * 2 ) ) );
		$classes = trim(implode(' ', ['ef5-avatar', 'ef5-avatar-'.$size, $args['class']]));
		
		$avatar = "<img alt='{$alt}' src='{$url}' srcset='{$url2x}' class='{$classes}' height='{$size}' width='{$size}' {$args['extra_attr']} />";
	    return $avatar;
	}
}