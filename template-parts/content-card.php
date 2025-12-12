<?php
/**
 * Template part for displaying post cards
 *
 * @package CozyRecipes
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'cozyrecipes-card' ); ?>
            </a>

            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) :
            ?>
                <span class="post-card-category"><?php echo esc_html( $categories[0]->name ); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="post-card-content">
        <h3 class="post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="post-card-meta">
            <span class="post-date">
                <?php echo get_the_date(); ?>
            </span>
            <span class="post-reading-time">
                <?php echo cozyrecipes_reading_time(); ?>
            </span>
        </div>

        <div class="post-card-excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="post-card-link">
            <?php esc_html_e( 'View Recipe', 'cozyrecipes' ); ?> →
        </a>
    </div>
</article>
