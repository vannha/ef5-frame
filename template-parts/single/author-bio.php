<?php
/**
 * The template for displaying Author info
 *
 */

if ( (bool) get_the_author_meta( 'description' ) ) : ?>
<div class="author-bio">
	<h2 class="author-title">
		<span class="author-heading"><?php echo esc_html( sprintf( __( 'Published by %s', 'ef5-frame' ), get_the_author() ) ); ?></span>
	</h2>
	<p class="author-description">
		<?php the_author_meta( 'description' ); ?>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php _e( 'View more posts', 'ef5-frame' ); ?>
		</a>
	</p>
</div>
<?php endif; ?>
