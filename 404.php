<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-wrapper no-sidebar">
        <main id="primary" class="main-content">

            <section class="error-404">
                <h1><?php esc_html_e( '404', 'cozyrecipes' ); ?></h1>
                <h2><?php esc_html_e( 'Oops! Page Not Found', 'cozyrecipes' ); ?></h2>
                <p><?php esc_html_e( 'It looks like the recipe you were looking for doesn\'t exist. Let\'s find you something delicious!', 'cozyrecipes' ); ?></p>

                <div class="search-form">
                    <?php get_search_form(); ?>
                </div>

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">
                    <?php esc_html_e( 'Back to Home', 'cozyrecipes' ); ?>
                </a>

                <!-- Popular Categories -->
                <?php
                $categories = get_categories( array(
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'number'     => 4,
                    'hide_empty' => true,
                ) );

                if ( ! empty( $categories ) ) :
                ?>
                    <div style="margin-top: 60px;">
                        <h3 style="text-align: center; margin-bottom: 30px;"><?php esc_html_e( 'Browse by Category', 'cozyrecipes' ); ?></h3>
                        <div class="categories-grid">
                            <?php foreach ( $categories as $category ) : ?>
                                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-card">
                                    <div class="category-icon"><?php echo esc_html( cozyrecipes_get_category_icon( $category->name ) ); ?></div>
                                    <h4 class="category-name"><?php echo esc_html( $category->name ); ?></h4>
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
                    </div>
                <?php endif; ?>
            </section>

        </main>
    </div>
</div>

<?php
get_footer();
