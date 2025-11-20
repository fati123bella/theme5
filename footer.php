<?php
/**
 * The template for displaying the footer
 *
 * @package CozyRecipes
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
                <div class="footer-widgets">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .footer-widgets -->
            </div>
        <?php endif; ?>

        <div class="site-info">
            <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
                <p>
                    <?php
                    /* translators: 1: Current year, 2: Site name */
                    printf(
                        esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'cozyrecipes' ),
                        date_i18n( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                    ?>
                    &nbsp;|&nbsp;
                    <?php
                    /* translators: %s: WordPress */
                    printf(
                        esc_html__( 'Powered by %s', 'cozyrecipes' ),
                        '<a href="https://wordpress.org/">WordPress</a>'
                    );
                    ?>
                </p>
            </div>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
