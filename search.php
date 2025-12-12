<?php
/**
 * The template for displaying search results pages
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-wrapper <?php echo cozyrecipes_show_sidebar() ? '' : 'no-sidebar'; ?>">
        <main id="primary" class="main-content">

            <header class="search-header">
                <?php if ( have_posts() ) : ?>
                    <h1 class="archive-title">
                        <?php
                        printf(
                            esc_html__( 'Search Results for: %s', 'cozyrecipes' ),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                <?php else : ?>
                    <h1 class="archive-title"><?php esc_html_e( 'Nothing Found', 'cozyrecipes' ); ?></h1>
                <?php endif; ?>

                <div class="search-form">
                    <?php get_search_form(); ?>
                </div>
            </header>

            <?php if ( have_posts() ) : ?>

                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', 'card' );
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '← Previous', 'cozyrecipes' ),
                    'next_text' => __( 'Next →', 'cozyrecipes' ),
                ) );

            else :
            ?>

                <div class="no-results">
                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'cozyrecipes' ); ?></p>
                </div>

            <?php endif; ?>

        </main>

        <?php
        if ( cozyrecipes_show_sidebar() ) {
            get_sidebar();
        }
        ?>
    </div>
</div>

<?php
get_footer();
