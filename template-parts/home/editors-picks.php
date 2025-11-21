<?php
/**
 * Template Part: Editor's Picks with Author Box
 *
 * A two-column section featuring:
 * - Left: Editor's Picks (featured recipes)
 * - Right: Author Box (profile card)
 *
 * @package CozyRecipes
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if section is enabled
$show_editors_picks = get_theme_mod( 'cozyrecipes_show_editors_picks', true );
if ( ! $show_editors_picks ) {
    return;
}

// Get section settings
$section_title = get_theme_mod( 'cozyrecipes_editors_picks_title', 'Editor\'s Picks' );
$section_subtitle = get_theme_mod( 'cozyrecipes_editors_picks_subtitle', 'Our favorite recipes selected just for you' );
$posts_count = get_theme_mod( 'cozyrecipes_editors_picks_count', 4 );
$source_type = get_theme_mod( 'cozyrecipes_editors_picks_source', 'tag' ); // 'tag' or 'category'
$source_category = get_theme_mod( 'cozyrecipes_editors_picks_category', '' );

// Build query args
$query_args = array(
    'post_type'      => 'post',
    'posts_per_page' => absint( $posts_count ),
    'post_status'    => 'publish',
);

// Determine source
if ( $source_type === 'category' && ! empty( $source_category ) ) {
    $query_args['cat'] = absint( $source_category );
} else {
    $query_args['tag'] = 'featured';
}

$editors_picks_query = new WP_Query( $query_args );

// Get author box settings
$show_author_box = get_theme_mod( 'cozyrecipes_show_author_box', true );
$author_image = get_theme_mod( 'cozyrecipes_author_image', '' );
$author_name = get_theme_mod( 'cozyrecipes_author_name', 'Chef Name' );
$author_bio = get_theme_mod( 'cozyrecipes_author_bio', 'Passionate recipe creator sharing delicious meals and culinary adventures.' );
$author_instagram = get_theme_mod( 'cozyrecipes_author_instagram', '' );
$author_pinterest = get_theme_mod( 'cozyrecipes_author_pinterest', '' );
$author_facebook = get_theme_mod( 'cozyrecipes_author_facebook', '' );

// Get color settings
$badge_color = get_theme_mod( 'cozyrecipes_badge_color', '#ff6b6b' );
$button_color = get_theme_mod( 'cozyrecipes_author_button_color', '#ff6b6b' );
?>

<section class="editors-picks-section">
    <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">

        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php if ( ! empty( $section_subtitle ) ) : ?>
                <p class="section-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Two Column Layout -->
        <div class="editors-picks-layout">

            <!-- Left Column: Editor's Picks -->
            <section class="editors-picks-content">
                <?php if ( $editors_picks_query->have_posts() ) : ?>
                    <div class="editors-picks-grid">
                        <?php while ( $editors_picks_query->have_posts() ) : $editors_picks_query->the_post(); ?>
                            <?php
                            $post_id = get_the_ID();
                            $thumbnail_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
                            $categories = get_the_category();
                            $first_category = ! empty( $categories ) ? $categories[0] : null;
                            $rating = get_post_meta( $post_id, 'recipe_rating', true );
                            $rating = $rating ? floatval( $rating ) : 5.0; // Default to 5 stars
                            ?>

                            <article class="editors-pick-card">
                                <?php if ( $thumbnail_url ) : ?>
                                    <div class="pick-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url( $thumbnail_url ); ?>"
                                                 alt="<?php the_title_attribute(); ?>"
                                                 width="300"
                                                 height="375"
                                                 loading="lazy"
                                                 decoding="async">
                                        </a>
                                        <?php if ( $first_category ) : ?>
                                            <span class="pick-category-badge" style="background-color: <?php echo esc_attr( $badge_color ); ?>;">
                                                <?php echo esc_html( $first_category->name ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="pick-content">
                                    <h3 class="pick-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Star Rating -->
                                    <div class="pick-rating" data-rating="<?php echo esc_attr( $rating ); ?>">
                                        <?php
                                        $full_stars = floor( $rating );
                                        $half_star = ( $rating - $full_stars ) >= 0.5;
                                        $empty_stars = 5 - ceil( $rating );

                                        // Full stars
                                        for ( $i = 0; $i < $full_stars; $i++ ) {
                                            echo '<span class="star star-full">★</span>';
                                        }

                                        // Half star
                                        if ( $half_star ) {
                                            echo '<span class="star star-half">★</span>';
                                        }

                                        // Empty stars
                                        for ( $i = 0; $i < $empty_stars; $i++ ) {
                                            echo '<span class="star star-empty">★</span>';
                                        }
                                        ?>
                                        <span class="rating-value"><?php echo number_format( $rating, 1 ); ?></span>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="pick-link">
                                        View Recipe <span class="arrow">→</span>
                                    </a>
                                </div>
                            </article>

                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    </div><!-- .editors-picks-grid -->
                <?php else : ?>
                    <p class="no-picks-message">
                        <?php esc_html_e( 'No editor\'s picks available yet. Tag some posts with "featured" to display them here.', 'cozyrecipes' ); ?>
                    </p>
                <?php endif; ?>
            </section><!-- .editors-picks-content -->

            <!-- Right Column: Author Box -->
            <?php if ( $show_author_box ) :
                $author_box_title = get_theme_mod( 'cozyrecipes_author_box_title', 'Meet the Author' );
                $author_button_text = get_theme_mod( 'cozyrecipes_author_button_text', 'Read More' );
                $author_button_url = get_theme_mod( 'cozyrecipes_author_button_url', '#' );
            ?>
                <aside class="author-box">
                    <div class="author-box-inner">
                        <?php if ( ! empty( $author_box_title ) ) : ?>
                            <h3 class="author-box-title"><?php echo esc_html( $author_box_title ); ?></h3>
                        <?php endif; ?>

                        <?php if ( ! empty( $author_image ) ) : ?>
                            <div class="author-image">
                                <img src="<?php echo esc_url( $author_image ); ?>"
                                     alt="<?php echo esc_attr( $author_name ); ?>"
                                     width="300"
                                     height="450"
                                     loading="lazy"
                                     decoding="async">
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $author_name ) ) : ?>
                            <h4 class="author-name"><?php echo esc_html( $author_name ); ?></h4>
                        <?php endif; ?>

                        <?php if ( ! empty( $author_bio ) ) : ?>
                            <p class="author-bio"><?php echo esc_html( $author_bio ); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty( $author_button_text ) && ! empty( $author_button_url ) ) : ?>
                            <a href="<?php echo esc_url( $author_button_url ); ?>" class="author-read-more" style="background-color: <?php echo esc_attr( $button_color ); ?>;">
                                <?php echo esc_html( $author_button_text ); ?>
                            </a>
                        <?php endif; ?>

                        <!-- Social Icons -->
                        <?php if ( ! empty( $author_instagram ) || ! empty( $author_pinterest ) || ! empty( $author_facebook ) ) : ?>
                            <div class="author-socials">
                                <?php if ( ! empty( $author_instagram ) ) : ?>
                                    <a href="<?php echo esc_url( $author_instagram ); ?>"
                                       class="social-icon instagram"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="Instagram">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>

                                <?php if ( ! empty( $author_pinterest ) ) : ?>
                                    <a href="<?php echo esc_url( $author_pinterest ); ?>"
                                       class="social-icon pinterest"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="Pinterest">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>

                                <?php if ( ! empty( $author_facebook ) ) : ?>
                                    <a href="<?php echo esc_url( $author_facebook ); ?>"
                                       class="social-icon facebook"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="Facebook">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div><!-- .author-socials -->
                        <?php endif; ?>
                    </div><!-- .author-box-inner -->
                </aside><!-- .author-box -->
            <?php endif; ?>

        </div><!-- .editors-picks-layout -->
    </div><!-- .container -->
</section><!-- .editors-picks-section -->
