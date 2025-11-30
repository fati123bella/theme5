<?php
/**
 * Responsive Post Navigation
 * Displays previous and next post links with responsive design
 *
 * @package CozyRecipes
 */

$prev_post = get_previous_post();
$next_post = get_next_post();

if ( ! $prev_post && ! $next_post ) {
	return;
}
?>

<nav class="post-navigation-section" aria-label="<?php esc_attr_e( 'Post navigation', 'cozyrecipes' ); ?>">

	<?php if ( $prev_post ) : ?>
		<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="nav-button nav-prev">
			<div class="nav-content">
				<span class="nav-label">← Previous</span>
				<h3 class="nav-post-title"><?php echo wp_kses_post( $prev_post->post_title ); ?></h3>
			</div>
		</a>
	<?php endif; ?>

	<?php if ( $next_post ) : ?>
		<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="nav-button nav-next">
			<div class="nav-content">
				<span class="nav-label">Next →</span>
				<h3 class="nav-post-title"><?php echo wp_kses_post( $next_post->post_title ); ?></h3>
			</div>
		</a>
	<?php endif; ?>

</nav>
