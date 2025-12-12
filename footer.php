    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="<?php echo esc_attr( cozyrecipes_get_container_class() ); ?>">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="footer-widgets">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="footer-bottom">
                <p>
                    <?php
                    printf(
                        esc_html__( '© %1$s %2$s. All rights reserved.', 'cozyrecipes' ),
                        date( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                    ?>
                    |
                    <?php
                    printf(
                        esc_html__( 'Powered by %s', 'cozyrecipes' ),
                        '<a href="' . esc_url( __( 'https://wordpress.org/', 'cozyrecipes' ) ) . '">WordPress</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
