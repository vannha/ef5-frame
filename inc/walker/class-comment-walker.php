<?php
/**
 * Custom comment walker for this theme
 *
 * @package EF5 Theme
 * @subpackage OverCome
 * @since 1.0.0
 * @author EF5 Team
 *
 */

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class OverCome_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$comment_author_link = get_comment_author_link( $comment );
		$comment_author_url  = get_comment_author_url( $comment );
		$comment_author      = get_comment_author( $comment );
		$avatar              = get_avatar( $comment, $args['avatar_size'], '', $comment_author, ['class'=>'cmt-avatar circle'] );
		?>
		<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="row">
					<?php if ( 0 != $args['avatar_size'] ) { ?>
					<div class="comment-avatar col-12 col-md-auto">
						<div class="row align-items-center">
							<div class="col-auto">
								<?php 
									if ( empty( $comment_author_url ) ) {
										printf('%s', $avatar);
									} else {
										printf( '<a href="%1$s" rel="external nofollow" class="url">%2$s</a>', esc_url($comment_author_url), $avatar );
									} 
								?>
							</div>
							<?php $this->overcome_comment_author_info(['class' => 'col'], $comment , $comment_author ); ?>
						</div>
					</div>
					<?php } ?>
					<div class="comment-info col">
						<?php $this->overcome_comment_author_info([], $comment , $comment_author ); ?>
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<div class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'overcome' ); ?></div>
						<?php endif; ?>
						<div class="comment-content">
							<?php comment_text(); ?>
						</div>
						<div class="comment-metadata">
							<span class="comment-time meta-color"><?php
									/* translators: 1: comment date, 2: comment time */
									$comment_timestamp = sprintf( __( '%1$s at %2$s', 'overcome' ), get_comment_date( '', $comment ), get_comment_time() );
								echo overcome_html($comment_timestamp); 
							?></span>
							<?php
								comment_reply_link(
									array_merge(
										$args,
										array(
											'add_below' => 'div-comment',
											'depth'     => $depth,
											'max_depth' => $args['max_depth'],
											'before'    => '',
											'after'     => '',
										)
									)
								);
								edit_comment_link(esc_html__('Edit','overcome'));
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' == $args['style'] ) ? 'div' : 'li';
	?>
		<<?php echo esc_html($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'overcome' ); ?> 
				<div class="h5"><?php comment_author_link( $comment ); ?></div>
				<?php if(current_user_can( 'edit_comment', $comment->comment_ID )){ ?>
				<div class="comment-links"><?php 
					echo '<span class="edit-edit"><a href="'.esc_url(get_edit_comment_link()).'" class="edit-link"><span class="edit-icon fa fa-edit"></span>&nbsp;&nbsp;'.esc_html__('Edit','overcome').'</a></span>'; 
				?></div>
				<?php } ?>
			</div>
	<?php
		}

	public function overcome_comment_author_info($args = '', $comment , $comment_author ){
		$args = wp_parse_args($args, [
			'class' => ''
		]);
		$classes = ['author-info', $args['class']];
	?>	
		<div class="<?php echo trim(implode(' ', $classes));?>">
			<?php 
				/*
				 * Using the `check` icon instead of `check_circle`, since we can't add a
				 * fill color to the inner check shape when in circle form.
				*/
				$author_badge = '';
				if ( overcome_is_comment_by_post_author( $comment ) ) {
					/* translators: %s: SVG Icon */
					$author_badge = sprintf( '<span class="post-author-badge">%s</span>', '<span class="far fa-user"></span>' );
				}

				printf(
					/* translators: %s: comment author link */
					esc_html__( '%s', 'overcome' ),
					sprintf( '<div class="author-name h5">%1$s %2$s</div>',$author_badge, $comment_author )
				);
			?>
		</div>
	<?php
		}
}