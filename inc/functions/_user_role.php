<?php
/**
 * Add new user role
*/
if(!function_exists('overcome_add_new_user_role')){
	add_action('after_setup_theme','overcome_add_new_user_role');
	function overcome_add_new_user_role(){
		add_role(
		    'overcome_support_manager',
		    esc_html__( 'OverCome Support Manager','overcome'),
		    array(
		        'read'         => true,  // true allows this capability
		        'edit_posts'   => false,
		    )
		);
	}
}

/**
 * Get list of user by user role
 * @param $user_role
*/
function overcome_list_user_by_role($args = []){
	$args = wp_parse_args($args, [
	    'role'    => 'subcrible',
	    'orderby' => 'user_nicename',
	    'order'   => 'ASC'
	]);
	$users = get_users( $args );

	echo '<ul>';
		foreach ( $users as $user ) {
		    echo '<li>' . esc_html( $user->display_name ) .'['.$user->user_email.']</li>';
		}
	echo '</ul>';
}

