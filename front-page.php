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
// Featured Recipes Section
$show_featured = get_theme_mod( 'cozyrecipes_show_featured', true );

if ( $show_featured ) :
    $featured_title = get_theme_mod( 'cozyrecipes_featured_title', 'Featured Recipes' );
    $featured_subtitle = get_theme_mod( 'cozyrecipes_featured_subtitle', 'Our handpicked favorites just for you' );
    $featured_category = get_theme_mod( 'cozyrecipes_featured_category', '' );
    $featured_count = get_theme_mod( 'cozyrecipes_featured_count', 6 );

    // Query for featured posts
    $featured_args = array(
        'post_type'      => 'post',
        'posts_per_page' => absint( $featured_count ),
        'post_status'    => 'publish',
    );

    // If a category is selected, use it; otherwise try 'featured' tag
    if ( ! empty( $featured_category ) ) {
        $featured_args['cat'] = absint( $featured_category );
    } else {
        $featured_args['tag'] = 'featured';
    }

    $featured_query = new WP_Query( $featured_args );

    if ( $featured_query->have_posts() ) :
        ?>
        <section class="content-section featured-recipes">
            <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
                <div class="section-header">
                    <h2 class="section-title"><?php echo esc_html( $featured_title ); ?></h2>
                    <?php if ( ! empty( $featured_subtitle ) ) : ?>
                        <p class="section-subtitle"><?php echo esc_html( $featured_subtitle ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="featured-with-sidebar">
                    <div class="featured-main">
                        <div class="recipes-grid">
                            <?php
                            // D. Reset card index for LCP optimization (first card in grid)
                            global $cozyrecipes_card_index;
                            $cozyrecipes_card_index = 0;

                            while ( $featured_query->have_posts() ) :
                                $featured_query->the_post();
                                get_template_part( 'template-parts/content', 'card' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div><!-- .recipes-grid -->
                    </div><!-- .featured-main -->

                    <?php
                    // About Author Sidebar
                    $show_author = get_theme_mod( 'cozyrecipes_show_about_author', true );
                    if ( $show_author ) :
                        $author_image = get_theme_mod( 'cozyrecipes_author_image', '' );
                        $author_name = get_theme_mod( 'cozyrecipes_author_name', 'Chef Name' );
                        $author_title = get_theme_mod( 'cozyrecipes_author_title', 'Recipe Creator' );
                        $author_description = get_theme_mod( 'cozyrecipes_author_description', 'Passionate about creating delicious recipes and sharing culinary adventures.' );
                        $author_button_text = get_theme_mod( 'cozyrecipes_author_button_text', 'Read More' );
                        $author_button_link = get_theme_mod( 'cozyrecipes_author_button_link', '#' );
                        ?>
                        <aside class="featured-sidebar about-author-card">
                            <?php if ( ! empty( $author_image ) ) : ?>
                                <div class="author-image">
                                    <img src="<?php echo esc_url( $author_image ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" loading="lazy" decoding="async">
                                </div>
                            <?php endif; ?>

                            <div class="author-info">
                                <?php if ( ! empty( $author_name ) ) : ?>
                                    <h3 class="author-name"><?php echo esc_html( $author_name ); ?></h3>
                                <?php endif; ?>

                                <?php if ( ! empty( $author_title ) ) : ?>
                                    <p class="author-title"><?php echo esc_html( $author_title ); ?></p>
                                <?php endif; ?>

                                <?php if ( ! empty( $author_description ) ) : ?>
                                    <p class="author-description"><?php echo esc_html( $author_description ); ?></p>
                                <?php endif; ?>

                                <?php if ( ! empty( $author_button_text ) && ! empty( $author_button_link ) ) : ?>
                                    <a href="<?php echo esc_url( $author_button_link ); ?>" class="author-button"><?php echo esc_html( $author_button_text ); ?></a>
                                <?php endif; ?>
                            </div>
                        </aside>
                    <?php endif; ?>
                </div><!-- .featured-with-sidebar -->
            </div><!-- .container -->
        </section><!-- .featured-recipes -->
        <?php
    endif;
endif;
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
