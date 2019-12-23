<?php
/**
 * Check post type have post or not 
*/
if(!function_exists('ef5frame_have_post')){
	function ef5frame_have_post($post_type){
		if(!post_type_exists($post_type))
			return false;
		$count_posts = wp_count_posts($post_type);
		$published_posts = $count_posts->publish;

		if($published_posts > 0)
			return true;
		else 
			return false;
	}
}