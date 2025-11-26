<?php
/**
 * Custom Post Navigation with Featured Images
 *
 * Displays previous and next post links with featured images,
 * smooth animations, and premium styling.
 *
 * @package CozyRecipes
 */

// Get previous and next posts
$prev_post = get_previous_post();
$next_post = get_next_post();

// Only show navigation if there are posts to navigate to
if ( ! $prev_post && ! $next_post ) {
	return;
}
?>

<nav class="custom-post-navigation" aria-label="<?php esc_attr_e( 'Posts', 'cozyrecipes' ); ?>">
	<div class="post-nav-wrapper">

		<!-- Previous Post -->
		<?php if ( $prev_post ) : ?>
			<div class="post-nav-item post-nav-prev">
				<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="post-nav-link">

					<!-- Featured Image Thumbnail -->
					<div class="post-nav-thumbnail">
						<?php
						$thumbnail_id = get_post_thumbnail_id( $prev_post->ID );
						if ( $thumbnail_id ) {
							echo wp_get_attachment_image( $thumbnail_id, array( 60, 60 ), false, array(
								'class'  => 'post-nav-image',
								'alt'    => esc_attr( $prev_post->post_title ),
								'decoding' => 'async',
								'loading' => 'lazy'
							) );
						} else {
							echo '<div class="post-nav-placeholder">' . esc_html__( 'No Image', 'cozyrecipes' ) . '</div>';
						}
						?>
					</div>

					<!-- Navigation Content -->
					<div class="post-nav-content">
						<span class="post-nav-label">
							<svg class="post-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="19" y1="12" x2="5" y2="12"></line>
								<polyline points="12 19 5 12 12 5"></polyline>
							</svg>
							<?php esc_html_e( 'Previous Post', 'cozyrecipes' ); ?>
						</span>
						<span class="post-nav-title"><?php echo wp_kses_post( $prev_post->post_title ); ?></span>
					</div>
				</a>
			</div>
		<?php endif; ?>

		<!-- Next Post -->
		<?php if ( $next_post ) : ?>
			<div class="post-nav-item post-nav-next">
				<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="post-nav-link">

					<!-- Navigation Content -->
					<div class="post-nav-content">
						<span class="post-nav-label">
							<?php esc_html_e( 'Next Post', 'cozyrecipes' ); ?>
							<svg class="post-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="5" y1="12" x2="19" y2="12"></line>
								<polyline points="12 5 19 12 12 19"></polyline>
							</svg>
						</span>
						<span class="post-nav-title"><?php echo wp_kses_post( $next_post->post_title ); ?></span>
					</div>

					<!-- Featured Image Thumbnail -->
					<div class="post-nav-thumbnail">
						<?php
						$thumbnail_id = get_post_thumbnail_id( $next_post->ID );
						if ( $thumbnail_id ) {
							echo wp_get_attachment_image( $thumbnail_id, array( 60, 60 ), false, array(
								'class'  => 'post-nav-image',
								'alt'    => esc_attr( $next_post->post_title ),
								'decoding' => 'async',
								'loading' => 'lazy'
							) );
						} else {
							echo '<div class="post-nav-placeholder">' . esc_html__( 'No Image', 'cozyrecipes' ) . '</div>';
						}
						?>
					</div>
				</a>
			</div>
		<?php endif; ?>

	</div>
</nav>
