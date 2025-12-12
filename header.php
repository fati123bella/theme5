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
        <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
            <div class="header-inner">
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
                </div>

                <button class="mobile-menu-toggle" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Menu', 'cozyrecipes' ); ?>">
                    ☰
                </button>

                <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'cozyrecipes' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>

                    <div class="header-search">
                        <button class="header-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'cozyrecipes' ); ?>">
                            🔍
                        </button>
                        <div class="header-search-form">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <div class="mobile-menu-backdrop"></div>

    <div id="content" class="site-content">
