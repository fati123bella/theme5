<?php
/**
 * The front page template file
 *
 * @package CozyRecipes
 */

get_header();
?>

<?php
// Hero Section
$hero_image = get_theme_mod( 'cozyrecipes_hero_image', '' );
if ( empty( $hero_image ) ) {
    $hero_image = 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1920&h=1080&fit=crop';
}
$hero_tagline = get_theme_mod( 'cozyrecipes_hero_tagline', 'Easy, cozy recipes for every day' );
$hero_title = get_theme_mod( 'cozyrecipes_hero_title', 'Discover Delicious Recipes' );
$hero_subtitle = get_theme_mod( 'cozyrecipes_hero_subtitle', 'Find the perfect recipe for any occasion' );
$search_placeholder = get_theme_mod( 'cozyrecipes_search_placeholder', 'Search for recipes...' );
$cta_text = get_theme_mod( 'cozyrecipes_cta_text', 'Browse All Recipes' );
$cta_url = get_theme_mod( 'cozyrecipes_cta_url', '/blog/' );
?>

<section class="hero-section" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');">
    <div class="hero-content">
        <?php if ( ! empty( $hero_tagline ) ) : ?>
            <p class="hero-tagline"><?php echo esc_html( $hero_tagline ); ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $hero_title ) ) : ?>
            <h1 class="hero-title"><?php echo esc_html( $hero_title ); ?></h1>
        <?php endif; ?>

        <?php if ( ! empty( $hero_subtitle ) ) : ?>
            <p class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
        <?php endif; ?>

        <div class="hero-search">
            <form role="search" method="get" class="hero-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search"
                       name="s"
                       placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
                       value="<?php echo get_search_query(); ?>"
                       required>
                <button type="submit"><?php esc_html_e( 'Search', 'cozyrecipes' ); ?></button>
            </form>
        </div>

        <?php if ( ! empty( $cta_text ) && ! empty( $cta_url ) ) : ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" class="hero-cta">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        <?php endif; ?>
    </div><!-- .hero-content -->
</section><!-- .hero-section -->

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

                <div class="recipes-grid">
                    <?php
                    while ( $featured_query->have_posts() ) :
                        $featured_query->the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div><!-- .recipes-grid -->
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

$latest_args = array(
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'post_status'    => 'publish',
);

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
// Popular Categories Section
$show_categories = get_theme_mod( 'cozyrecipes_show_categories', true );

if ( $show_categories ) :
    $categories_title = get_theme_mod( 'cozyrecipes_categories_title', 'Popular Categories' );
    $categories_subtitle = get_theme_mod( 'cozyrecipes_categories_subtitle', 'Browse recipes by your favorite categories' );

    // Get all categories with posts
    $categories = get_categories( array(
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 8,
        'hide_empty' => true,
    ) );

    if ( ! empty( $categories ) ) :
        ?>
        <section class="content-section popular-categories">
            <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
                <div class="section-header">
                    <h2 class="section-title"><?php echo esc_html( $categories_title ); ?></h2>
                    <?php if ( ! empty( $categories_subtitle ) ) : ?>
                        <p class="section-subtitle"><?php echo esc_html( $categories_subtitle ); ?></p>
                    <?php endif; ?>
                </div>

                <div class="categories-grid">
                    <?php
                    // Category icons mapping
                    $category_icons = array(
                        'breakfast' => '🍳',
                        'lunch'     => '🥗',
                        'dinner'    => '🍽️',
                        'dessert'   => '🍰',
                        'desserts'  => '🍰',
                        'appetizer' => '🥙',
                        'appetizers'=> '🥙',
                        'salad'     => '🥗',
                        'salads'    => '🥗',
                        'soup'      => '🍲',
                        'soups'     => '🍲',
                        'pasta'     => '🍝',
                        'pizza'     => '🍕',
                        'burger'    => '🍔',
                        'burgers'   => '🍔',
                        'sandwich'  => '🥪',
                        'sandwiches'=> '🥪',
                        'vegan'     => '🌱',
                        'vegetarian'=> '🥕',
                        'seafood'   => '🐟',
                        'chicken'   => '🍗',
                        'beef'      => '🥩',
                        'pork'      => '🥓',
                        'bread'     => '🍞',
                        'baking'    => '🥖',
                        'cookies'   => '🍪',
                        'cake'      => '🎂',
                        'cakes'     => '🎂',
                        'drinks'    => '🥤',
                        'smoothie'  => '🥤',
                        'smoothies' => '🥤',
                    );

                    foreach ( $categories as $category ) :
                        $cat_slug = $category->slug;
                        $icon = isset( $category_icons[ $cat_slug ] ) ? $category_icons[ $cat_slug ] : '🍴';
                        ?>
                        <div class="category-card">
                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                                <span class="category-icon"><?php echo $icon; ?></span>
                                <h3 class="category-name"><?php echo esc_html( $category->name ); ?></h3>
                                <p class="category-count">
                                    <?php
                                    /* translators: %s: number of recipes */
                                    printf(
                                        esc_html( _n( '%s recipe', '%s recipes', $category->count, 'cozyrecipes' ) ),
                                        number_format_i18n( $category->count )
                                    );
                                    ?>
                                </p>
                            </a>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div><!-- .categories-grid -->
            </div><!-- .container -->
        </section><!-- .popular-categories -->
        <?php
    endif;
endif;
?>

<?php
get_footer();
