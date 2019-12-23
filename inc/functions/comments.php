<?php 
if(!function_exists('overcome_wp_list_comments_args')){
	function overcome_wp_list_comments_args($args=[]){
		$args = wp_parse_args($args, array(
			'walker'      => new OverCome_Walker_Comment(),
			'avatar_size' => overcome_get_avatar_size(),
			'short_ping'  => true,
			'style'       => 'ol'
		));
		return $args;
	}
}


if(!function_exists('overcome_comment')){
	function overcome_comment(){
		$show_cmt = overcome_get_opts('show_comment_form', '1');
		if ( '1' === $show_cmt && (comments_open() || get_comments_number()) )
       	{
            comments_template();
       	}
	}
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function overcome_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function overcome_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		array(
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		)
	);

	$authors = array();
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) array(
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	);

	return $discussion;
}

if ( ! function_exists( 'overcome_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 */
	function overcome_discussion_avatars_list( $comment_authors ) {
		if ( empty( $comment_authors ) ) {
			return;
		}
		echo '<div class="discussion-avatar-list d-flex">';
		foreach ( $comment_authors as $id_or_email ) {
			printf(
				"<div>%s</div>",
				overcome_get_user_avatar_markup( $id_or_email )
			);
		}
		echo '</div>';
	}
endif;

if ( ! function_exists( 'overcome_get_user_avatar_markup' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function overcome_get_user_avatar_markup( $id_or_email = null ) {

		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}

		return sprintf( '<div class="comment-user-avatar comment-author">%s</div>', get_avatar( $id_or_email, overcome_get_avatar_size() ) );
	}
endif;

// Comment Reply link
//add_filter('comment_reply_link','overcome_comment_reply_link', 10, 4);
function overcome_comment_reply_link($link, $args, $comment, $post){
	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
		$link = sprintf( '<a rel="nofollow" class="comment-reply-login" href="%s"><span class="fa fa-reply"></span>&nbsp;&nbsp;%s</a>',
			esc_url( wp_login_url( get_permalink() ) ),
			$args['login_text']
		);
	} else {
		$onclick = sprintf( 'return addComment.moveForm( "%1$s-%2$s", "%2$s", "%3$s", "%4$s" )',
			$args['add_below'], $comment->comment_ID, $args['respond_id'], $post->ID
		);

		$link = sprintf( "<a rel='nofollow' class='comment-reply-link' href='%s' onclick='%s' aria-label='%s'>%s</a>",
			esc_url( add_query_arg( 'replytocom', $comment->comment_ID, get_permalink( $post->ID ) ) ) . "#" . $args['respond_id'],
			$onclick,
			esc_attr( sprintf( $args['reply_to_text'], $comment->comment_author ) ),
			$args['reply_text']
		);
	}
	
	$link =  $args['before'] . $link . $args['after'];
	return $link;
}

/**
 * Move comment field to above comment text
*/
if(!function_exists('overcome_comment_form_fields')){
	add_filter( 'comment_form_fields', 'overcome_comment_form_fields');
    function overcome_comment_form_fields( $fields ) {
        //author, email, url 
        $fields_first = ['rating','open','author','email','url','close'];
        $fields_resort = [];
        foreach ($fields_first as $key) {
            if(array_key_exists($key,$fields))
                $fields_resort[$key] = $fields[$key];
        }
        foreach ($fields as $key => $value) {
            if(in_array($key,$fields_first))
                continue;
            $fields_resort[$key] = $value;
        }
        return $fields_resort;
    }
}

if(!function_exists('overcome_comment_field_to_bottom')){
	/**
	 * add_filter( 'comment_form_fields', 'overcome_comment_field_to_bottom' ); 
	*/
	function overcome_comment_field_to_bottom( $fields ) {
	    $comment_field = $fields['comment'];
	    unset( $fields['comment'] );
	    $fields['comment'] = $comment_field;
	    return $fields;
	}
}

/*
 * Comment Form Output
 * 
*/
if ( ! function_exists( 'overcome_comment_form' ) ) :
	/**
	 * Documentation for function.
	 */
	function overcome_comment_form( $args = [] ) {
		$args = wp_parse_args($args, [
			'order'        => 'asc',
			'class_submit' => 'ef5-btn primary fill',
		]);
		$order = $args['order'];
		if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {
			comment_form(
				array(
					'id_form'		=> 'ef5-respond',
					'title_reply'	=> esc_html__('Write a Comment', 'overcome'),
					'label_submit'  => esc_html__( 'Post Your Comment','overcome' ),
					'class_submit'  => $args['class_submit'],
					'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s"><span>%4$s</span></button>',
					'submit_field'  => '<div class="form-submit">%1$s %2$s</div>',
					'format'		=> 'html5'
				)
			);
		}
	}
endif;

/**
 * Comment form fields
 * Default Fields
 *
 * Name, Email, Url, Phone ...
 * 'url' => '<div class="comment-form-url col-12 col-md-4">' .
		'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'.esc_attr($url_pladeholder).'" />'.
 	'</div>',
*/
if(!function_exists('overcome_comment_form_default_fields')){
	add_filter('comment_form_default_fields', 'overcome_comment_form_default_fields', 10, 2);
	function overcome_comment_form_default_fields($fields){
		$commenter       = wp_get_current_commenter();
		$req             = get_option( 'require_name_email' );
		$html_req        = ( $req ? " required='required'" : '' );
		$html_req_markup = ( $req ? '*' : '' );
		$html5           = true;
		$name_pladeholder  = esc_html__('Name *','overcome');
		$email_pladeholder = esc_html__('Email *','overcome');
		$url_pladeholder   = esc_html__('Website','overcome');
		
		$fields    = [
			'open'	  		=> 	'<div class="row ef5-form-fields">',
			'author'  		=>	'<div class="comment-form-author col-12 col-md-6">'.
							 		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" maxlength="245"' . $html_req . ' placeholder="'.esc_attr($name_pladeholder).'" />'.
							 	'</div>',
			'email'   		=>	'<div class="comment-form-email col-12 col-md-6">' .
								 	'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-describedby="email-notes"' . $html_req . ' placeholder="'.esc_attr($email_pladeholder).'" />'.
								'</div>',
			'close'	  		=>  '</div>',
		];
		return $fields;
	}
}

/**
 * Comment form fields
 *
 * Comment text
 *
*/
if(!function_exists('overcome_comment_form_defaults')){
	add_filter('comment_form_defaults', 'overcome_comment_form_defaults');
	function overcome_comment_form_defaults($fields){
		$msg_placeholder   = esc_html__( 'Your Comment *', 'overcome' );
		$fields['comment_field'] = '<div class="comment-form-comment">'.
									'<textarea id="comment" name="comment" placeholder="'.esc_attr($msg_placeholder).'" required="required"></textarea>'.
								'</div>';
		$fields['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />%4$s</button>';
		return $fields;
	}
}

/***
 * WooCommerce Comment Field
 * 
 * Custom WooCommerce Comment list 
 * 
*/

if(!function_exists('overcome_woocommerce_product_review_list_args')){
	add_filter('woocommerce_product_review_list_args','overcome_woocommerce_product_review_list_args');
	add_filter('woocommerce_review_gravatar_size', 'overcome_get_avatar_size');
	remove_action('woocommerce_review_meta', 'woocommerce_review_display_meta');
	remove_action('woocommerce_review_before_comment_meta','woocommerce_review_display_rating');
	function overcome_woocommerce_product_review_list_args($args){
		$args = array_merge($args, [
			'avatar_size'   => overcome_get_avatar_size(),
			'callback' 		=> 'overcome_woocommerce_comments'
		]);

		return $args;
	}
	function overcome_woocommerce_comments($comment, $args, $depth){
		$verified = wc_review_is_from_verified_owner( $comment->comment_ID );
	?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class('comment'); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body row">
				<div class="comment-avatar col-12 col-md-auto">
					<div class="row align-items-center">
						<div class="col-auto"><?php
							/**
							 * The woocommerce_review_before hook
							 *
							 * @hooked woocommerce_review_display_gravatar - 10
							 */
							do_action( 'woocommerce_review_before', $comment );
							
						?></div>
						<div class="author-info col">
							<div class="author-name h5">
								<?php echo get_comment_author( $comment ); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="comment-info col">
					<div class="d-flex justify-content-between">
						<div class="author-info">
							<div class="author-name h5">
								<?php echo get_comment_author( $comment ); ?>
							</div>
						</div>
						<div class="">
							<?php woocommerce_review_display_rating(); ?>
						</div>
					</div>
					<?php
						/**
						 * The woocommerce_review_meta hook.
						 *
						 * @hooked woocommerce_review_display_meta - 10
						 * @hooked WC_Structured_Data::generate_review_data() - 20
						 */
						do_action( 'woocommerce_review_meta', $comment );
						/**
						 * The woocommerce_review_before_comment_meta hook.
						 *
						 * @hooked woocommerce_review_display_rating - 10
						 */
						do_action( 'woocommerce_review_before_comment_meta', $comment );
					?>
					<div class="comment-content">
						<?php					
						do_action( 'woocommerce_review_before_comment_text', $comment );

						/**
						 * The woocommerce_review_comment_text hook
						 *
						 * @hooked woocommerce_review_display_comment_text - 10
						 */
						do_action( 'woocommerce_review_comment_text', $comment );

						do_action( 'woocommerce_review_after_comment_text', $comment ); ?>
					</div>
					<div class="comment-metadata">
						<?php
						if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
							echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'overcome' ) . ')</em> ';
						}
						?>
						<span class="comment-time meta-color" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></span>
					</div>
				</div>
			</div>
	<?php
	}
}

/***
 * WooCommerce Comment Field
 * 
 * Custom WooCommerce Comment field 
 * 'url'=> '<div class="comment-form-url col-12 col-md-4">' .
		'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'.esc_attr($url_pladeholder).'" />'.
 	'</div>',
*/
if(!function_exists('overcome_woocommerce_product_review_comment_form_args')){
	add_filter('woocommerce_product_review_comment_form_args', 'overcome_woocommerce_product_review_comment_form_args');
	function overcome_woocommerce_product_review_comment_form_args($args){
		$commenter       = wp_get_current_commenter();
		$req             = get_option( 'require_name_email' );
		$html_req        = ( $req ? " required='required'" : '' );
		$html_req_markup = ( $req ? '*' : '' );
		$html5           = true;
		$name_pladeholder  = esc_html__('Name *','overcome');
		$email_pladeholder = esc_html__('Email *','overcome');
		$url_pladeholder   = esc_html__('Website','overcome');
		$msg_placeholder   = esc_html__( 'Your Review *', 'overcome' );

		$args = array_merge($args,[
			'title_reply_before' => '<div class="ef5-heading h3">',
			'title_reply_after'  => '</div>',
			'title_reply'   => have_comments() ? esc_html__( 'Write a Review', 'overcome' ) : esc_html__( 'Be the first to Review', 'overcome' ),
			'label_submit'  => esc_html__( 'Post Your Review', 'overcome' ),
			'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />%4$s</button>',
			'comment_field' => '<div class="comment-form-comment">'.
									'<textarea id="comment" name="comment" placeholder="'.esc_attr($msg_placeholder).'" required="required"></textarea>'.
								'</div>',
		]);

		$args['fields'] = [
			'open'	  		=> 	'<div class="row ef5-form-fields">',
			'author'  		=>	'<div class="comment-form-author col-12 col-md-6">'.
							 		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" maxlength="245"' . $html_req . ' placeholder="'.esc_attr($name_pladeholder).'" />'.
							 	'</div>',
			'email'   		=>	'<div class="comment-form-email col-12 col-md-6">' .
								 	'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-describedby="email-notes"' . $html_req . ' placeholder="'.esc_attr($email_pladeholder).'" />'.
								'</div>',
			
			'close'	  		=>  '</div>',
		];
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
			$args['fields']['rating'] = '<div class="comment-form-rating"><div class="ef5-heading">' . esc_html__( 'Your rating', 'overcome' ) . '</div><select name="rating" id="rating" required>
				<option value="">' . esc_html__( 'Rate&hellip;', 'overcome' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'overcome' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'overcome' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'overcome' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'overcome' ) . '</option>
				<option value="1">' . esc_html__( 'Very poor', 'overcome' ) . '</option>
			</select></div>';
		}

		return $args;
	}
}
/**
 * Remove re-Captcha when user logged in
 * plugin: Google Captcha (reCAPTCHA) by BestWebSoft
 * https://wordpress.org/plugins/google-captcha/
 *
*/
if(function_exists('gglcptch_commentform_display')){
	add_action ('init', 'overcome_remove_default_gglcptch_commentform_display');
	function overcome_remove_default_gglcptch_commentform_display(){
		remove_action( 'comment_form_after_fields', 'gglcptch_commentform_display');
		remove_action( 'comment_form_logged_in_after', 'gglcptch_commentform_display');
	}

	function overcome_gglcptch_commentform_display($submit_button, $args){
		$submit_before =  '<span class="gglcptch-none d-none">'.gglcptch_commentform_display().'</span>';
		return $submit_before . $submit_button;
	}
	add_filter('comment_form_submit_button', 'overcome_gglcptch_commentform_display', 10, 2);
}

/**
 * Commnent Pagination
 *
 * Loadmore button
 *
*/
/* Comment Pagination */
if(!function_exists('overcome_comment_pagination')){
	function overcome_comment_pagination(){
		paginate_comments_links(['echo' => false]);
	}
}

/* Comment loadmore button */
if(!function_exists('overcome_comment_pagination_loadmore')){
	function overcome_comment_pagination_loadmore(){
		$cpage = get_query_var('cpage') ? get_query_var('cpage') : 1;
		if( $cpage > 1 ) {
			wp_enqueue_script('ef5-comment-loadmore');
			echo '<div class="ef5-comment-loadmore transition ef5-btn fill accent ef5-btn-xlg" data-text="'.esc_attr__('Load More Comments','overcome').'" data-text-loading="'.esc_attr__('Loading...','overcome').'" data-text-complete="'.esc_html__('No More Comments','overcome').'">'.esc_html__('Load More Comments','overcome').'</div>
			<'.'script>
			var ajaxurl = \'' . site_url('wp-admin/admin-ajax.php') . '\',
			    parent_post_id = ' . get_the_ID() . ',
		    	    cpage = ' . $cpage . ';
			</'.'script>';
		}
	} 
}
/* Comment Loadmore button */
if(!function_exists('overcome_comments_loadmore_handler')){
	add_action('wp_ajax_cloadmore', 'overcome_comments_loadmore_handler'); // wp_ajax_{action}
	add_action('wp_ajax_nopriv_cloadmore', 'overcome_comments_loadmore_handler'); // wp_ajax_nopriv_{action}
	function overcome_comments_loadmore_handler(){
		// maybe it isn't the best way to declare global $post variable, but it is simple and works perfectly!
		global $post;
		$post = get_post( $_POST['post_id'] );
		setup_postdata( $post );

		$args = overcome_wp_list_comments_args();
		$args['page']    = $_POST['cpage']; // current comment page
		$args['per_page'] = get_option('comments_per_page');
		// actually we must copy the params from wp_list_comments() used in our theme
		wp_list_comments( $args );
		die; // don't forget this thing if you don't want "0" to be displayed
	}
}
