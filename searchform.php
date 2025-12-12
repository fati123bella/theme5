<?php
/**
 * Custom search form template
 *
 * @package CozyRecipes
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'cozyrecipes' ); ?></span>
        <input type="search"
               class="search-field"
               placeholder="<?php esc_attr_e( 'Search recipes...', 'cozyrecipes' ); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               aria-label="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>" />
    </label>
    <button type="submit" class="search-submit">
        <?php esc_html_e( 'Search', 'cozyrecipes' ); ?>
    </button>
</form>
