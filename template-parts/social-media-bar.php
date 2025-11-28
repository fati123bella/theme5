<?php
/**
 * Social Media Top Bar Template
 *
 * @package CozyRecipes
 */

// Check if social bar is enabled
$enable_social_bar = get_theme_mod( 'cozyrecipes_enable_social_bar', true );
if ( ! $enable_social_bar ) {
    return;
}

// Get social media URLs
$facebook_url  = get_theme_mod( 'cozyrecipes_facebook_url' );
$twitter_url   = get_theme_mod( 'cozyrecipes_twitter_url' );
$instagram_url = get_theme_mod( 'cozyrecipes_instagram_url' );
$pinterest_url = get_theme_mod( 'cozyrecipes_pinterest_url' );
$youtube_url   = get_theme_mod( 'cozyrecipes_youtube_url' );
$tiktok_url    = get_theme_mod( 'cozyrecipes_tiktok_url' );

// Get colors
$bg_color   = get_theme_mod( 'cozyrecipes_social_bar_bg_color', '#f8f8f8' );
$icon_color = get_theme_mod( 'cozyrecipes_social_bar_icon_color', '#333333' );

// If no social URLs are set, don't display the bar
if ( ! $facebook_url && ! $twitter_url && ! $instagram_url && ! $pinterest_url && ! $youtube_url && ! $tiktok_url ) {
    return;
}

// Inline styles for colors
$style = 'style="background-color: ' . esc_attr( $bg_color ) . ';"';
?>

<div class="social-media-bar" <?php echo wp_kses_post( $style ); ?>>
    <div class="social-media-container">
        <div class="social-icons">
            <?php if ( $facebook_url ) : ?>
                <a href="<?php echo esc_url( $facebook_url ); ?>" class="social-icon facebook" title="<?php esc_attr_e( 'Follow on Facebook', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073Z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $twitter_url ) : ?>
                <a href="<?php echo esc_url( $twitter_url ); ?>" class="social-icon twitter" title="<?php esc_attr_e( 'Follow on Twitter', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 002.856-3.933 9.978 9.978 0 01-2.836.796 4.904 4.904 0 002.165-2.724c-.951.564-2.005.974-3.127 1.195a4.856 4.856 0 00-8.33 4.428 13.995 13.995 0 01-10.175-5.153c-.39.67-.6 1.466-.6 2.310a4.88 4.88 0 002.16 4.066 4.891 4.891 0 01-2.201-.616c-.053 2.28 1.582 4.415 3.951 4.89a4.935 4.935 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $instagram_url ) : ?>
                <a href="<?php echo esc_url( $instagram_url ); ?>" class="social-icon instagram" title="<?php esc_attr_e( 'Follow on Instagram', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.117.6c-.594.147-1.065.342-1.537.814-.473.472-.667.943-.814 1.537-.266.788-.468 1.658-.527 2.936C.008 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.528 2.936.147.593.341 1.065.814 1.537.472.473.943.667 1.537.814.788.266 1.658.468 2.936.527C8.333 23.992 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.936-.528.593-.147 1.065-.341 1.537-.814.473-.472.667-.943.814-1.537.266-.788.468-1.658.527-2.936.058-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.528-2.936-.147-.594-.341-1.065-.814-1.537-.472-.473-.943-.667-1.537-.814-.788-.266-1.658-.468-2.936-.527C15.667.008 15.26 0 12 0zm0 2.16c3.203 0 3.585.009 4.849.070 1.17.054 1.805.244 2.227.404.562.217.96.477 1.382.896.419.42.679.819.896 1.381.16.422.35 1.057.404 2.227.061 1.264.07 1.646.07 4.849s-.009 3.585-.07 4.849c-.054 1.17-.244 1.805-.404 2.227-.217.562-.477.96-.896 1.382-.42.419-.819.679-1.381.896-.422.16-1.057.35-2.227.404-1.264.061-1.646.07-4.849.07s-3.585-.009-4.849-.07c-1.17-.054-1.805-.244-2.227-.404-.562-.217-.96-.477-1.382-.896-.419-.42-.679-.819-.896-1.381-.16-.422-.35-1.057-.404-2.227-.061-1.264-.07-1.646-.07-4.849s.009-3.585.07-4.849c.054-1.17.244-1.805.404-2.227.217-.562.477-.96.896-1.382.42-.419.819-.679 1.381-.896.422-.16 1.057-.35 2.227-.404 1.264-.061 1.646-.07 4.849-.07z"/>
                        <circle cx="12" cy="12" r="3.561"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $pinterest_url ) : ?>
                <a href="<?php echo esc_url( $pinterest_url ); ?>" class="social-icon pinterest" title="<?php esc_attr_e( 'Follow on Pinterest', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.937-.2-2.378.042-3.41.218-.937 1.407-5.965 1.407-5.965s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.768 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.597 2.166 1.771 2.166 2.13 0 3.765-2.246 3.765-5.494 0-2.872-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.628 0 12-5.373 12-12 0-6.628-5.372-12-12-12z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $youtube_url ) : ?>
                <a href="<?php echo esc_url( $youtube_url ); ?>" class="social-icon youtube" title="<?php esc_attr_e( 'Subscribe on YouTube', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $tiktok_url ) : ?>
                <a href="<?php echo esc_url( $tiktok_url ); ?>" class="social-icon tiktok" title="<?php esc_attr_e( 'Follow on TikTok', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.498 4.537c-1.289-.954-2.14-2.482-2.14-4.137h-3.066v11.534c0 1.201-.98 2.182-2.182 2.182-1.201 0-2.182-.981-2.182-2.182s.981-2.182 2.182-2.182c.229 0 .451.036.661.104V6.614c-.218-.027-.439-.042-.661-.042-2.904 0-5.268 2.364-5.268 5.268 0 2.903 2.364 5.267 5.268 5.267 2.903 0 5.268-2.364 5.268-5.267v-2.66c1.089.813 2.444 1.301 3.918 1.301v-3.067c-1.328 0-2.543-.426-3.548-1.147z"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
