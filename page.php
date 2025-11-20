<?php
/**
 * The template for displaying all pages
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-area-wrapper <?php echo esc_attr( cozyrecipes_get_sidebar_class() ); ?>">
        <main id="primary" class="site-main">

            <?php
            while ( have_posts() ) :
                the_post();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header" style="text-align: center; padding: 3rem 0 2rem;">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header><!-- .entry-header -->

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="entry-image" style="margin-bottom: 3rem; border-radius: 12px; overflow: hidden;">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content" style="background: #fff; padding: 3rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                        <?php
                        the_content();

                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cozyrecipes' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            ?>

        </main><!-- #primary -->

        <?php if ( cozyrecipes_show_sidebar() ) : ?>
            <?php get_sidebar(); ?>
        <?php endif; ?>
    </div><!-- .content-area-wrapper -->
</div><!-- .container -->

<?php
get_footer();
