<?php
/**
 * The template for displaying search results
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-area-wrapper <?php echo esc_attr( cozyrecipes_get_sidebar_class() ); ?>">
        <main id="primary" class="site-main">

            <?php if ( have_posts() ) : ?>

                <header class="archive-header">
                    <h1 class="archive-title">
                        <?php
                        /* translators: %s: Search query */
                        printf( esc_html__( 'Search Results for: %s', 'cozyrecipes' ), '<span>' . get_search_query() . '</span>' );
                        ?>
                    </h1>
                    <div class="archive-description">
                        <?php get_search_form(); ?>
                    </div>
                </header><!-- .archive-header -->

                <div class="recipes-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    ?>
                </div><!-- .recipes-grid -->

                <?php
                the_posts_pagination(
                    array(
                        'mid_size'  => 2,
                        'prev_text' => __( '&larr; Previous', 'cozyrecipes' ),
                        'next_text' => __( 'Next &rarr;', 'cozyrecipes' ),
                        'class'     => 'pagination',
                    )
                );
                ?>

            <?php else : ?>

                <div class="no-results" style="text-align: center; padding: 4rem 2rem;">
                    <h1><?php esc_html_e( 'Nothing Found', 'cozyrecipes' ); ?></h1>
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'cozyrecipes' ); ?></p>
                    <?php get_search_form(); ?>
                </div>

            <?php endif; ?>

        </main><!-- #primary -->

        <?php if ( cozyrecipes_show_sidebar() ) : ?>
            <?php get_sidebar(); ?>
        <?php endif; ?>
    </div><!-- .content-area-wrapper -->
</div><!-- .container -->

<?php
get_footer();
