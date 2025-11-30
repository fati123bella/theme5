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

                <?php
                // Get meta display settings
                $show_date = get_theme_mod( 'cozyrecipes_show_post_date', true );
                $show_author = get_theme_mod( 'cozyrecipes_show_post_author', true );
                $show_reading_time = get_theme_mod( 'cozyrecipes_show_reading_time', true );
                $show_comments = get_theme_mod( 'cozyrecipes_show_comment_count', true );

                // Check if any meta is enabled
                if ( $show_date || $show_author || $show_reading_time || $show_comments ) :
                ?>
                <div class="single-recipe-meta">
                    <?php if ( $show_date ) : ?>
                    <span class="meta-date">
                        <?php echo get_the_date(); ?>
                    </span>
                    <?php endif; ?>
                    <?php if ( $show_author ) : ?>
                    <span class="meta-author">
                        <?php
                        /* translators: %s: Author name */
                        printf(
                            esc_html__( 'By %s', 'cozyrecipes' ),
                            '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
                        );
                        ?>
                    </span>
                    <?php endif; ?>
                    <?php if ( $show_reading_time ) : ?>
                    <span class="meta-reading-time">
                        <?php echo esc_html( cozyrecipes_reading_time() ); ?>
                    </span>
                    <?php endif; ?>
                    <?php if ( $show_comments && ( comments_open() || get_comments_number() ) ) : ?>
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
                <?php endif; ?>
            </header><!-- .single-recipe-header -->

            <?php
            $show_featured_image = get_theme_mod( 'cozyrecipes_single_featured_image', true );
            if ( $show_featured_image && has_post_thumbnail() ) :
                ?>
                <div class="single-recipe-image">
                    <?php the_post_thumbnail( 'cozyrecipes-featured', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
                </div>
            <?php endif; ?>

            <?php
            // Jump to Recipe button
            $content = get_post_field( 'post_content', get_the_ID() );
            $recipe_data = mytheme_auto_detect_recipe_data( apply_filters( 'the_content', $content ) );
            $has_recipe = ! empty( $recipe_data['ingredients'] ) || ! empty( $recipe_data['instructions'] );

            if ( $has_recipe && get_theme_mod( 'cozyrecipes_enable_recipe_card', true ) ) :
            ?>
            <div class="jump-to-recipe-container">
                <a href="#recipe-print-card" class="jump-to-recipe-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <polyline points="19 12 12 19 5 12"></polyline>
                    </svg>
                    <span><?php esc_html_e( 'Jump to Recipe', 'cozyrecipes' ); ?></span>
                </a>
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
            // Render recipe print card from post content (below content)
            echo mytheme_render_recipe_print_card();
            ?>

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
        // Custom post navigation with featured images
        get_template_part( 'template-parts/custom-post-navigation' );

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
