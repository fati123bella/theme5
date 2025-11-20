<?php
/**
 * Template part for displaying recipe cards
 *
 * @package CozyRecipes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="recipe-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'cozyrecipes-thumbnail', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
            </a>

            <?php
            // Display category badge if enabled
            $show_category = get_theme_mod( 'cozyrecipes_show_category_badge', true );
            if ( $show_category ) :
                $category = cozyrecipes_first_category();
                if ( $category ) :
                    ?>
                    <span class="recipe-category-badge">
                        <?php echo esc_html( $category->name ); ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </div><!-- .recipe-card-image -->
    <?php endif; ?>

    <div class="recipe-card-content">
        <h3 class="recipe-card-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="recipe-meta">
            <span class="meta-date">
                <?php echo get_the_date(); ?>
            </span>
            <span class="meta-reading-time">
                <?php echo esc_html( cozyrecipes_reading_time() ); ?>
            </span>
        </div><!-- .recipe-meta -->

        <div class="recipe-excerpt">
            <?php the_excerpt(); ?>
        </div><!-- .recipe-excerpt -->

        <a href="<?php the_permalink(); ?>" class="recipe-link">
            <?php esc_html_e( 'View Recipe', 'cozyrecipes' ); ?> →
        </a>
    </div><!-- .recipe-card-content -->
</article><!-- .recipe-card -->
