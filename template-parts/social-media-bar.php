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
                        <path d="M9.101 21.76v-7.27h-2.44V11h2.44V8.852c0-2.416 1.475-3.732 3.637-3.732 1.034 0 1.924.078 2.182.112v2.53h-1.496c-1.176 0-1.403.557-1.403 1.373v1.8h2.805l-.365 2.49h-2.44v7.27H9.101Z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $twitter_url ) : ?>
                <a href="<?php echo esc_url( $twitter_url ); ?>" class="social-icon twitter" title="<?php esc_attr_e( 'Follow on Twitter', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.014-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $instagram_url ) : ?>
                <a href="<?php echo esc_url( $instagram_url ); ?>" class="social-icon instagram" title="<?php esc_attr_e( 'Follow on Instagram', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.117.6c-.594.147-1.065.342-1.537.814-.472.472-.666.943-.814 1.537-.266.788-.468 1.658-.527 2.936C.008 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.528 2.936.147.593.341 1.065.814 1.537.472.473.943.667 1.537.814.788.266 1.658.468 2.936.527C8.333 23.992 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.936-.528.593-.147 1.065-.341 1.537-.814.473-.472.667-.943.814-1.537.266-.788.468-1.658.527-2.936.058-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.528-2.936-.147-.594-.341-1.065-.814-1.537-.472-.473-.943-.667-1.537-.814-.788-.266-1.658-.468-2.936-.527C15.667.008 15.26 0 12 0zm0 2.16c3.203 0 3.585.009 4.849.07 1.17.054 1.805.244 2.227.404.562.217.96.477 1.382.896.419.42.679.819.896 1.381.16.422.35 1.057.404 2.227.061 1.264.07 1.646.07 4.849s-.009 3.585-.07 4.849c-.054 1.17-.244 1.805-.404 2.227-.217.562-.477.96-.896 1.382-.42.419-.819.679-1.381.896-.422.16-1.057.35-2.227.404-1.264.061-1.646.07-4.849.07s-3.585-.009-4.849-.07c-1.17-.054-1.805-.244-2.227-.404-.562-.217-.96-.477-1.382-.896-.419-.42-.679-.819-.896-1.381-.16-.422-.35-1.057-.404-2.227-.061-1.264-.07-1.646-.07-4.849s.009-3.585.07-4.849c.054-1.17.244-1.805.404-2.227.217-.562.477-.96.896-1.382.42-.419.819-.679 1.381-.896.422-.16 1.057-.35 2.227-.404 1.264-.061 1.646-.07 4.849-.07zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.322a1.44 1.44 0 11-2.881 0 1.44 1.44 0 012.881 0z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $pinterest_url ) : ?>
                <a href="<?php echo esc_url( $pinterest_url ); ?>" class="social-icon pinterest" title="<?php esc_attr_e( 'Follow on Pinterest', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.315 2c6.452 0 11.605 5.153 11.605 11.605 0 5.08-3.27 9.44-7.823 11.003.555-.916.968-1.955 1.12-3.06.105-.882-.122-1.844-.404-2.884.513.142 1.025.32 1.53.542 2.947-1.817 4.915-5.088 4.915-8.661 0-5.597-4.55-10.146-10.148-10.146-5.597 0-10.148 4.55-10.148 10.148 0 3.573 1.968 6.844 4.915 8.661.505-.222 1.017-.4 1.53-.542-.282 1.04-.51 2.003-.404 2.885.152 1.104.564 2.144 1.12 3.06-4.553-1.562-7.823-5.923-7.823-11.003C.71 7.153 5.863 2 12.315 2z"/>
                    </svg>
                </a>
            <?php endif; ?>

            <?php if ( $youtube_url ) : ?>
                <a href="<?php echo esc_url( $youtube_url ); ?>" class="social-icon youtube" title="<?php esc_attr_e( 'Subscribe on YouTube', 'cozyrecipes' ); ?>" target="_blank" rel="noopener noreferrer" style="color: <?php echo esc_attr( $icon_color ); ?>;">
                    <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
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
