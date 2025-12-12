<?php
/**
 * The sidebar containing the main widget area
 *
 * @package CozyRecipes
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="sidebar <?php echo esc_attr( cozyrecipes_get_sidebar_class() ); ?>">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
