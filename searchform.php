<?php
/**
 * Custom search form
 *
 * @package CozyRecipes
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Search recipes', 'cozyrecipes' ); ?>">
    <label for="search-field">
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'cozyrecipes' ); ?></span>
        <input type="search"
               id="search-field"
               class="search-field"
               placeholder="<?php echo esc_attr_x( 'Search recipes...', 'placeholder', 'cozyrecipes' ); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               aria-label="<?php esc_attr_e( 'Search recipes', 'cozyrecipes' ); ?>"
               title="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>"
               required />
        <button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Submit search', 'cozyrecipes' ); ?>" title="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>">
            <?php esc_html_e( 'Search', 'cozyrecipes' ); ?>
        </button>
    </label>
</form>
