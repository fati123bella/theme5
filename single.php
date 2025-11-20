<?php
/**
 * The template for displaying single posts
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="single-recipe-header">
                <?php
                $category = cozyrecipes_first_category();
                if ( $category ) :
                    ?>
                    <div class="recipe-category-badge">
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <h1 class="single-recipe-title"><?php the_title(); ?></h1>

                <div class="single-recipe-meta">
                    <span class="meta-date">
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="meta-author">
                        <?php
                        /* translators: %s: Author name */
                        printf(
                            esc_html__( 'By %s', 'cozyrecipes' ),
                            '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
                        );
                        ?>
                    </span>
                    <span class="meta-reading-time">
                        <?php echo esc_html( cozyrecipes_reading_time() ); ?>
                    </span>
                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <span class="meta-comments">
                            <?php
                            comments_popup_link(
                                esc_html__( 'No Comments', 'cozyrecipes' ),
                                esc_html__( '1 Comment', 'cozyrecipes' ),
                                esc_html__( '% Comments', 'cozyrecipes' )
                            );
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
            </header><!-- .single-recipe-header -->

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-recipe-image">
                    <?php the_post_thumbnail( 'cozyrecipes-featured', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
                </div>
            <?php endif; ?>

            <div class="single-recipe-content">
                <?php
                the_content();

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cozyrecipes' ),
                        'after'  => '</div>',
                    )
                );
                ?>
            </div><!-- .single-recipe-content -->

            <?php
            // Tags
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'cozyrecipes' ) );
            if ( $tags_list ) :
                ?>
                <footer class="entry-footer">
                    <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>" style="max-width: 760px;">
                        <span class="tags-links">
                            <?php
                            /* translators: %s: Tags list */
                            printf(
                                '<strong>' . esc_html__( 'Tags:', 'cozyrecipes' ) . '</strong> %s',
                                $tags_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            );
                            ?>
                        </span>
                    </div>
                </footer><!-- .entry-footer -->
            <?php endif; ?>
        </article><!-- #post-<?php the_ID(); ?> -->

        <?php
        // Post navigation
        the_post_navigation(
            array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous Recipe:', 'cozyrecipes' ) . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next Recipe:', 'cozyrecipes' ) . '</span> <span class="nav-title">%title</span>',
            )
        );

        // Related recipes
        $categories = get_the_category();
        if ( ! empty( $categories ) ) :
            $category_ids = array();
            foreach ( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }

            $related_args = array(
                'category__in'   => $category_ids,
                'post__not_in'   => array( get_the_ID() ),
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            );

            $related_query = new WP_Query( $related_args );

            if ( $related_query->have_posts() ) :
                ?>
                <section class="related-recipes">
                    <div class="section-header">
                        <h2 class="section-title"><?php esc_html_e( 'You May Also Like', 'cozyrecipes' ); ?></h2>
                    </div>

                    <div class="recipes-grid">
                        <?php
                        while ( $related_query->have_posts() ) :
                            $related_query->the_post();
                            get_template_part( 'template-parts/content', 'card' );
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div><!-- .recipes-grid -->
                </section><!-- .related-recipes -->
                <?php
            endif;
        endif;

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile;
    ?>
</div><!-- .container -->

<?php
get_footer();
