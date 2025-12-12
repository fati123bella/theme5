<?php
/**
 * The front page template file
 *
 * @package CozyRecipes
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('<?php echo esc_url( get_theme_mod( 'cozyrecipes_hero_image', 'https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=1600' ) ); ?>');">
    <div class="hero-content">
        <?php if ( get_theme_mod( 'cozyrecipes_hero_tagline' ) ) : ?>
            <p class="hero-tagline"><?php echo esc_html( get_theme_mod( 'cozyrecipes_hero_tagline', 'Easy, cozy recipes for every day' ) ); ?></p>
        <?php endif; ?>

        <h1 class="hero-title"><?php echo esc_html( get_theme_mod( 'cozyrecipes_hero_title', 'Delicious Recipes Made Simple' ) ); ?></h1>

        <div class="hero-search">
            <form role="search" method="get" class="hero-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search"
                       name="s"
                       placeholder="<?php echo esc_attr( get_theme_mod( 'cozyrecipes_hero_search_placeholder', 'Search for recipes…' ) ); ?>"
                       value="<?php echo get_search_query(); ?>"
                       aria-label="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>">
                <button type="submit"><?php esc_html_e( 'Search', 'cozyrecipes' ); ?></button>
            </form>
        </div>

        <?php
        $cta_text = get_theme_mod( 'cozyrecipes_hero_cta_text', 'Browse All Recipes' );
        $cta_url = get_theme_mod( 'cozyrecipes_hero_cta_url', '/blog' );
        if ( $cta_text ) :
        ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" class="hero-cta"><?php echo esc_html( $cta_text ); ?></a>
        <?php endif; ?>
    </div>
</section>

<!-- Featured Recipes Section -->
<?php if ( get_theme_mod( 'cozyrecipes_show_featured', true ) ) : ?>
    <section class="section">
        <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'cozyrecipes_featured_title', 'Featured Recipes' ) ); ?></h2>
                <?php if ( get_theme_mod( 'cozyrecipes_featured_subtitle' ) ) : ?>
                    <p class="section-subtitle"><?php echo esc_html( get_theme_mod( 'cozyrecipes_featured_subtitle', 'Our most popular and delicious recipes' ) ); ?></p>
                <?php endif; ?>
            </div>

            <?php
            $featured_category = get_theme_mod( 'cozyrecipes_featured_category', '' );
            $featured_args = array(
                'posts_per_page' => 6,
                'post_status'    => 'publish',
            );

            if ( ! empty( $featured_category ) ) {
                $featured_args['cat'] = absint( $featured_category );
            }

            $featured_query = new WP_Query( $featured_args );

            if ( $featured_query->have_posts() ) :
            ?>
                <div class="posts-grid grid-2">
                    <?php
                    while ( $featured_query->have_posts() ) :
                        $featured_query->the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<!-- Main Latest Recipes Section -->
<section class="section">
    <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
        <div class="section-header">
            <h2 class="section-title"><?php esc_html_e( 'Latest Recipes', 'cozyrecipes' ); ?></h2>
            <p class="section-subtitle"><?php esc_html_e( 'Fresh and delicious recipes added recently', 'cozyrecipes' ); ?></p>
        </div>

        <?php
        $latest_args = array(
            'posts_per_page' => 9,
            'post_status'    => 'publish',
        );

        $latest_query = new WP_Query( $latest_args );

        if ( $latest_query->have_posts() ) :
        ?>
            <div class="posts-grid">
                <?php
                while ( $latest_query->have_posts() ) :
                    $latest_query->the_post();
                    get_template_part( 'template-parts/content', 'card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '← Previous', 'cozyrecipes' ),
                'next_text' => __( 'Next →', 'cozyrecipes' ),
            ) );
            ?>
        <?php endif; ?>
    </div>
</section>

<!-- Popular Categories Section -->
<?php if ( get_theme_mod( 'cozyrecipes_show_categories', true ) ) : ?>
    <section class="section">
        <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'cozyrecipes_categories_title', 'Popular Categories' ) ); ?></h2>
                <?php if ( get_theme_mod( 'cozyrecipes_categories_subtitle' ) ) : ?>
                    <p class="section-subtitle"><?php echo esc_html( get_theme_mod( 'cozyrecipes_categories_subtitle', 'Browse recipes by your favorite categories' ) ); ?></p>
                <?php endif; ?>
            </div>

            <?php
            $categories = get_categories( array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 8,
                'hide_empty' => true,
            ) );

            if ( ! empty( $categories ) ) :
            ?>
                <div class="categories-grid">
                    <?php foreach ( $categories as $category ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-card">
                            <div class="category-icon"><?php echo esc_html( cozyrecipes_get_category_icon( $category->name ) ); ?></div>
                            <h3 class="category-name"><?php echo esc_html( $category->name ); ?></h3>
                            <p class="category-count">
                                <?php
                                printf(
                                    _n( '%s recipe', '%s recipes', $category->count, 'cozyrecipes' ),
                                    number_format_i18n( $category->count )
                                );
                                ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php
get_footer();
