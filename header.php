<?php
/**
 * The header for our theme
 *
 * @package CozyRecipes
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'cozyrecipes' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </h1>
                    <?php
                }
                ?>
                <p class="site-description screen-reader-text"><?php bloginfo( 'description' ); ?></p>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'cozyrecipes' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    )
                );
                ?>

                <div class="header-search">
                    <button class="header-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>" aria-expanded="false">
                        <span>🔍</span>
                    </button>
                    <div class="header-search-form">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </nav><!-- #site-navigation -->

            <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Menu', 'cozyrecipes' ); ?>" aria-expanded="false">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div><!-- .header-container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
