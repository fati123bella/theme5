<?php
/**
 * The front page template file
 *
 * @package CozyRecipes
 */

get_header();
?>

<?php
// Hero Section - Simplified (Search bar only)
$search_placeholder = get_theme_mod( 'cozyrecipes_search_placeholder', 'Search for recipes...' );
?>

<section class="hero-section hero-section-simple">
    <div class="hero-content">
        <div class="hero-search">
            <form role="search" method="get" class="hero-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Main search form', 'cozyrecipes' ); ?>">
                <label for="hero-search-input" class="screen-reader-text"><?php esc_html_e( 'Search for recipes', 'cozyrecipes' ); ?></label>
                <input type="search"
                       id="hero-search-input"
                       name="s"
                       placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
                       value="<?php echo get_search_query(); ?>"
                       aria-label="<?php esc_attr_e( 'Search recipes', 'cozyrecipes' ); ?>"
                       title="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>"
                       required>
                <button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'cozyrecipes' ); ?>" title="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>"><?php esc_html_e( 'Search', 'cozyrecipes' ); ?></button>
            </form>
        </div>
    </div><!-- .hero-content -->
</section><!-- .hero-section -->

<?php
// Category Slider - Load template part
get_template_part( 'template-parts/category-slider' );
?>

<?php
// Editor's Picks Section with Author Box
get_template_part( 'template-parts/home/editors-picks' );
?>

<?php
// Latest Recipes Section
$latest_title = get_theme_mod( 'cozyrecipes_latest_title', 'Latest Recipes' );
$latest_subtitle = get_theme_mod( 'cozyrecipes_latest_subtitle', 'Fresh and delicious recipes added recently' );
$latest_category = get_theme_mod( 'cozyrecipes_latest_category', '' );
$latest_count = get_theme_mod( 'cozyrecipes_latest_count', 9 );

$latest_args = array(
    'post_type'      => 'post',
    'posts_per_page' => absint( $latest_count ),
    'post_status'    => 'publish',
);

// Filter by category if selected
if ( ! empty( $latest_category ) ) {
    $latest_args['cat'] = absint( $latest_category );
}

$latest_query = new WP_Query( $latest_args );

if ( $latest_query->have_posts() ) :
    ?>
    <section class="content-section latest-recipes">
        <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( $latest_title ); ?></h2>
                <?php if ( ! empty( $latest_subtitle ) ) : ?>
                    <p class="section-subtitle"><?php echo esc_html( $latest_subtitle ); ?></p>
                <?php endif; ?>
            </div>

            <div class="recipes-grid">
                <?php
                // D. Reset/maintain card index (if Featured is disabled, this is the first section)
                global $cozyrecipes_card_index;
                if ( ! get_theme_mod( 'cozyrecipes_show_featured', true ) ) {
                    $cozyrecipes_card_index = 0; // Reset if this is the first visible section
                }

                while ( $latest_query->have_posts() ) :
                    $latest_query->the_post();
                    get_template_part( 'template-parts/content', 'card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div><!-- .recipes-grid -->
        </div><!-- .container -->
    </section><!-- .latest-recipes -->
    <?php
endif;
?>


<?php
get_footer();
