<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <main id="primary" class="site-main">

        <section class="error-404 not-found">
            <h1 class="page-number">404</h1>
            <h2 class="page-title"><?php esc_html_e( 'Oops! Page Not Found', 'cozyrecipes' ); ?></h2>
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try searching for what you need?', 'cozyrecipes' ); ?></p>

            <?php get_search_form(); ?>

            <div style="margin-top: 3rem;">
                <h3><?php esc_html_e( 'Or try these popular pages:', 'cozyrecipes' ); ?></h3>
                <ul style="list-style: none; margin: 2rem 0;">
                    <li style="margin-bottom: 1rem;">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="font-size: 1.1rem;">
                            <?php esc_html_e( '← Go to Homepage', 'cozyrecipes' ); ?>
                        </a>
                    </li>
                    <?php
                    // Get popular categories
                    $categories = get_categories( array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'number'     => 5,
                        'hide_empty' => true,
                    ) );

                    if ( ! empty( $categories ) ) :
                        foreach ( $categories as $category ) :
                            ?>
                            <li style="margin-bottom: 1rem;">
                                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" style="font-size: 1.1rem;">
                                    <?php echo esc_html( $category->name ); ?>
                                </a>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
        </section><!-- .error-404 -->

    </main><!-- #primary -->
</div><!-- .container -->

<?php
get_footer();
