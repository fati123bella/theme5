<?php
/**
 * Template part for displaying the category slider
 *
 * @package CozyRecipes
 */

// Check if slider is enabled
if ( ! cozyrecipes_is_category_slider_enabled() ) {
    return;
}

// Get slider settings
$slider_title = get_theme_mod( 'cozyrecipes_category_slider_title', 'Browse by Category' );
$slider_subtitle = get_theme_mod( 'cozyrecipes_category_slider_subtitle', 'Discover delicious recipes organized by category' );
$categories_count = get_theme_mod( 'cozyrecipes_category_slider_count', 8 );
$accent_color = get_theme_mod( 'cozyrecipes_accent_color', '#ff6b6b' );

// Get selected categories
$selected_cat_ids = cozyrecipes_get_selected_categories();

// Get categories - filtered by selection
$categories = get_categories( array(
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => absint( $categories_count ),
    'hide_empty' => true,
    'include'    => $selected_cat_ids,
) );

if ( empty( $categories ) ) {
    return;
}
?>

<section class="category-slider-section" aria-label="<?php echo esc_attr( $slider_title ); ?>">
    <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">

        <?php if ( ! empty( $slider_title ) || ! empty( $slider_subtitle ) ) : ?>
            <div class="section-header">
                <?php if ( ! empty( $slider_title ) ) : ?>
                    <h2 class="section-title"><?php echo esc_html( $slider_title ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $slider_subtitle ) ) : ?>
                    <p class="section-subtitle"><?php echo esc_html( $slider_subtitle ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="category-slider" role="navigation" aria-label="<?php esc_attr_e( 'Category navigation', 'cozyrecipes' ); ?>">
            <div class="category-slider-track">
                <?php foreach ( $categories as $category ) :
                    $category_link = get_category_link( $category->term_id );
                    $category_name = $category->name;
                    $category_slug = $category->slug;

                    // Get custom icon or emoji fallback
                    $icon = cozyrecipes_get_category_icon( $category->term_id, $category_slug );
                    $is_emoji = ( strlen( $icon ) <= 4 && mb_strlen( $icon, 'UTF-8' ) === 1 );

                    // Get custom color
                    $color = cozyrecipes_get_category_color( $category->term_id );

                    // Get badge count (custom or real)
                    $badge_count = cozyrecipes_get_category_count( $category->term_id, $category->count );
                ?>

                <a href="<?php echo esc_url( $category_link ); ?>"
                   class="category-slider-item"
                   aria-label="<?php printf( esc_attr__( 'View %s recipes', 'cozyrecipes' ), $category_name ); ?>">

                    <div class="category-icon"
                         style="background-color: <?php echo esc_attr( $color ); ?>;"
                         role="img"
                         aria-label="<?php echo esc_attr( $category_name ); ?>">
                        <?php if ( $is_emoji ) : ?>
                            <span class="category-emoji"><?php echo $icon; ?></span>
                        <?php else : ?>
                            <img src="<?php echo esc_url( $icon ); ?>"
                                 alt="<?php printf( esc_attr__( '%s category icon', 'cozyrecipes' ), $category_name ); ?>"
                                 width="64"
                                 height="64"
                                 loading="lazy"
                                 decoding="async">
                        <?php endif; ?>
                    </div>

                    <span class="category-name"><?php echo esc_html( $category_name ); ?></span>
                </a>

                <?php endforeach; ?>
            </div><!-- .category-slider-track -->
        </div><!-- .category-slider -->

    </div><!-- .container -->
</section><!-- .category-slider-section -->
