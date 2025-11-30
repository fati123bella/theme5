<?php
/**
 * Template part for displaying recipe cards
 *
 * @package CozyRecipes
 */

// D. Track if this is the first card for LCP optimization
global $cozyrecipes_card_index;
if ( ! isset( $cozyrecipes_card_index ) ) {
    $cozyrecipes_card_index = 0;
}
$is_first_card = ( 0 === $cozyrecipes_card_index );
$cozyrecipes_card_index++;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'recipe-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="recipe-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php
                // D. First card gets priority for LCP optimization
                $thumbnail_attrs = array(
                    'alt' => the_title_attribute( array( 'echo' => false ) ),
                );

                // First card: LCP element gets high priority and eager loading
                if ( $is_first_card && ( is_front_page() || is_home() ) ) {
                    $thumbnail_attrs['loading'] = 'eager';
                    $thumbnail_attrs['fetchpriority'] = 'high';
                    $thumbnail_attrs['decoding'] = 'async';
                }

                the_post_thumbnail( 'cozyrecipes-thumbnail', $thumbnail_attrs );
                ?>
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

        <?php
        // Check if any meta is enabled
        $show_date = get_theme_mod( 'cozyrecipes_show_post_date', true );
        $show_reading_time = get_theme_mod( 'cozyrecipes_show_reading_time', true );

        if ( $show_date || $show_reading_time ) :
        ?>
        <div class="recipe-meta">
            <?php if ( $show_date ) : ?>
            <span class="meta-date">
                <?php echo get_the_date(); ?>
            </span>
            <?php endif; ?>
            <?php if ( $show_reading_time ) : ?>
            <span class="meta-reading-time">
                <?php echo esc_html( cozyrecipes_reading_time() ); ?>
            </span>
            <?php endif; ?>
        </div><!-- .recipe-meta -->
        <?php endif; ?>

        <div class="recipe-excerpt">
            <?php the_excerpt(); ?>
        </div><!-- .recipe-excerpt -->

        <a href="<?php the_permalink(); ?>" class="recipe-link">
            <?php esc_html_e( 'View Recipe', 'cozyrecipes' ); ?> →
        </a>
    </div><!-- .recipe-card-content -->
</article><!-- .recipe-card -->
