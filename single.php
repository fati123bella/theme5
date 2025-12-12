<?php
/**
 * The template for displaying single posts
 *
 * @package CozyRecipes
 */

get_header();
?>

<div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
    <div class="content-wrapper <?php echo cozyrecipes_show_sidebar() ? '' : 'no-sidebar'; ?>">
        <main id="primary" class="main-content">

            <?php
            while ( have_posts() ) :
                the_post();
            ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="single-post-header">
                        <?php
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) :
                        ?>
                            <div class="post-category">
                                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
                                    <?php echo esc_html( $categories[0]->name ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <h1 class="single-post-title"><?php the_title(); ?></h1>

                        <div class="single-post-meta">
                            <span class="posted-on">
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="byline">
                                <?php
                                printf(
                                    esc_html__( 'by %s', 'cozyrecipes' ),
                                    '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
                                );
                                ?>
                            </span>
                            <span class="reading-time">
                                <?php echo cozyrecipes_reading_time(); ?>
                            </span>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="single-post-featured-image">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="single-post-content entry-content">
                        <?php
                        the_content();

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cozyrecipes' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                        ?>
                            <div class="post-tags">
                                <?php
                                foreach ( $tags as $tag ) {
                                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-badge">' . esc_html( $tag->name ) . '</a> ';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </footer>
                </article>

                <?php
                // Post navigation
                the_post_navigation( array(
                    'prev_text' => '<span class="nav-label">' . esc_html__( 'Previous Recipe', 'cozyrecipes' ) . '</span><span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-label">' . esc_html__( 'Next Recipe', 'cozyrecipes' ) . '</span><span class="nav-title">%title</span>',
                ) );

                // Related posts
                if ( ! empty( $categories ) ) :
                    $related_args = array(
                        'cat'            => $categories[0]->term_id,
                        'post__not_in'   => array( get_the_ID() ),
                        'posts_per_page' => 3,
                    );

                    $related_query = new WP_Query( $related_args );

                    if ( $related_query->have_posts() ) :
                ?>
                    <div class="related-posts">
                        <h3><?php esc_html_e( 'You May Also Like', 'cozyrecipes' ); ?></h3>
                        <div class="posts-grid">
                            <?php
                            while ( $related_query->have_posts() ) :
                                $related_query->the_post();
                                get_template_part( 'template-parts/content', 'card' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php
                    endif;
                endif;

                // Comments
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile;
            ?>

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
