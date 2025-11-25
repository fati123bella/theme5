<?php
/**
 * CozyRecipes Theme Functions
 *
 * @package CozyRecipes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Theme Setup
 */
function cozyrecipes_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Set post thumbnail size
    set_post_thumbnail_size( 800, 1200, true ); // 2:3 ratio

    // Add additional image sizes for responsive images
    add_image_size( 'cozyrecipes-featured', 1200, 800, true );
    add_image_size( 'cozyrecipes-thumbnail', 600, 900, true );
    add_image_size( 'cozyrecipes-medium', 800, 600, true );
    add_image_size( 'cozyrecipes-small', 400, 300, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'cozyrecipes' ),
        'footer'  => esc_html__( 'Footer Menu', 'cozyrecipes' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add support for custom header
    add_theme_support( 'custom-header', array(
        'width'       => 1920,
        'height'      => 1080,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'f8f8f8',
    ) );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for accessibility improvements
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'align-wide' );

    // Remove unnecessary WordPress features for performance
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'after_setup_theme', 'cozyrecipes_setup' );

/**
 * Custom document title
 */
function cozyrecipes_document_title_parts( $title ) {
    // Homepage
    if ( is_front_page() && is_home() ) {
        $title['title'] = get_bloginfo( 'name' );
        $title['tagline'] = get_bloginfo( 'description' );
    }
    // Homepage (when static page is set)
    elseif ( is_front_page() ) {
        $title['title'] = get_bloginfo( 'name' );
        $title['tagline'] = get_bloginfo( 'description' );
    }
    // Blog page
    elseif ( is_home() ) {
        $title['title'] = single_post_title( '', false );
    }
    // Single post
    elseif ( is_single() ) {
        $title['title'] = single_post_title( '', false );
        $title['site'] = get_bloginfo( 'name' );
    }
    // Category archive
    elseif ( is_category() ) {
        $title['title'] = single_cat_title( '', false ) . ' Recipes';
        $title['site'] = get_bloginfo( 'name' );
    }
    // Search results
    elseif ( is_search() ) {
        $title['title'] = sprintf( 'Search Results for: %s', get_search_query() );
        $title['site'] = get_bloginfo( 'name' );
    }
    // 404 page
    elseif ( is_404() ) {
        $title['title'] = 'Page Not Found';
        $title['site'] = get_bloginfo( 'name' );
    }

    return $title;
}
add_filter( 'document_title_parts', 'cozyrecipes_document_title_parts' );

/**
 * Set content width
 */
function cozyrecipes_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'cozyrecipes_content_width', 1200 );
}
add_action( 'after_setup_theme', 'cozyrecipes_content_width', 0 );

/**
 * Register Widget Areas
 */
function cozyrecipes_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'cozyrecipes' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'cozyrecipes' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'cozyrecipes' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in footer column 1.', 'cozyrecipes' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'cozyrecipes' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add widgets here to appear in footer column 2.', 'cozyrecipes' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'cozyrecipes' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add widgets here to appear in footer column 3.', 'cozyrecipes' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'cozyrecipes_widgets_init' );

/**
 * A. Add critical inline CSS for instant rendering - PREVENTS CLS
 * Expanded to include recipe grid aspect-ratio for above-the-fold content
 */
function cozyrecipes_critical_css() {
    ?>
    <style id="cozyrecipes-critical-css">
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:system-ui,-apple-system,sans-serif;font-size:16px;line-height:1.6;color:#333;background:#f8f8f8}
        a{text-decoration:none;transition:color .3s ease}

        /* Header */
        .site-header{background:#fff;position:sticky;top:0;z-index:1000;box-shadow:0 2px 10px rgba(0,0,0,.05);transition:box-shadow .3s ease}
        .site-header.scrolled{box-shadow:0 2px 15px rgba(0,0,0,.1)}
        .header-container{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.5rem;max-width:1200px;margin:0 auto}
        .site-title{font-size:1.75rem;margin:0;font-weight:700}
        .site-title a{color:#222}

        /* Navigation */
        .main-navigation{display:flex}
        .main-navigation ul{list-style:none;margin:0;padding:0;display:flex;gap:2rem}
        .main-navigation li{position:relative}
        .main-navigation a{color:#333;font-weight:500;font-size:.95rem;padding:.5rem 0;display:block}

        /* Header Actions */
        .header-actions{display:flex;gap:1rem;align-items:center}
        .header-search-toggle,.mobile-menu-toggle{background:none;border:none;font-size:1.25rem;cursor:pointer;padding:.5rem;color:#333;transition:color .3s ease}
        .mobile-menu-toggle{display:none}
        .hamburger{width:24px;height:20px;display:flex;flex-direction:column;justify-content:space-between}
        .hamburger span{display:block;height:2px;width:100%;background:#333;transition:all .3s ease}

        /* A. Hero Section - MIN-HEIGHT prevents CLS (140px on mobile, 180px desktop) */
        .hero-section{position:relative;width:100%;min-height:140px;display:flex;align-items:center;justify-content:center;background:#fff;padding:2rem 0;text-align:center;border-bottom:1px solid #eee}
        .hero-content{max-width:700px;width:100%;padding:0 1.5rem;margin:0 auto}
        .hero-search{margin:0}
        .hero-search-form{display:flex;max-width:600px;margin:0 auto;background:#fff;border:2px solid #e0e0e0;border-radius:50px;overflow:hidden;transition:all .3s ease}
        .hero-search-form:focus-within{border-color:#ff6b6b;box-shadow:0 0 0 3px rgba(255,107,107,.1)}
        .hero-search-form input[type="search"]{flex:1;padding:1rem 1.5rem;border:none;font-size:1rem;outline:none;background:transparent;color:#333}
        .hero-search-form input[type="search"]::placeholder{color:#999}
        .hero-search-form button{background:#ff6b6b;color:#fff;border:none;padding:1rem 2rem;font-size:1rem;font-weight:600;cursor:pointer;transition:all .3s ease;white-space:nowrap}

        /* A. Recipe Grid - ASPECT-RATIO prevents CLS on images (2:3 ratio = 600x900) */
        .recipes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:2rem;margin-top:2rem}
        .recipe-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08);transition:all .3s ease}
        .recipe-card-image{position:relative;aspect-ratio:2/3;width:100%;overflow:hidden;background:#f0f0f0}
        .recipe-card-image img{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover}

        /* D. Section Header spacing */
        .content-section{padding:3rem 0}
        .section-header{text-align:center;margin-bottom:2rem}
        .section-title{font-size:2rem;margin-bottom:0.5rem;font-weight:700}
        .section-subtitle{color:#666;font-size:1.1rem}

        /* Utilities */
        .container{max-width:1200px;margin:0 auto;padding:0 1.5rem}
        .screen-reader-text{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border-width:0}
        img{max-width:100%;height:auto;display:block}

        /* Mobile */
        @media (max-width:768px){
            .hero-section{padding:1.5rem 0;min-height:120px}
            .hero-search-form{max-width:100%}
            .hero-search-form input[type="search"]{padding:.875rem 1.25rem;font-size:.95rem}
            .hero-search-form button{padding:.875rem 1.5rem;font-size:.95rem}
            .main-navigation{display:none}
            .mobile-menu-toggle{display:flex;flex-direction:column;align-items:center;justify-content:center}
            .site-title{font-size:1.5rem}
            .header-container{padding:.875rem 1rem}
            .recipes-grid{grid-template-columns:1fr;gap:1.5rem}
            .content-section{padding:2rem 0}
            .section-title{font-size:1.5rem}
        }
    </style>
    <?php
}
add_action( 'wp_head', 'cozyrecipes_critical_css', 1 );

/**
 * E. Add DNS prefetch and resource hints - SAVES ~100ms per origin
 * F. Direct WOFF2 font preload - FASTER than CSS @font-face
 */
function cozyrecipes_resource_hints() {
    ?>
    <!-- DNS Prefetch saves ~100ms per origin -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Preconnect to font resources (with crossorigin for fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Direct WOFF2 preload for Inter fonts -->
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/inter/v13/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuLyfAZ9hiA.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/inter/v13/UcCO3FwrK3iLTeHuS_fvQtMwCp50KnMw2boKoduKmMEVuI6fAZ9hiA.woff2" crossorigin>

    <!-- Preload Playfair Display bold for headers -->
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/playfairdisplay/v30/nuFvD-vgj4v2LVRMa8vLBxzKSEE4gxX5TGwO9QD9jKdVYAiZSWCkJ8EE.woff2" crossorigin>

    <!-- Defer font CSS with media print trick - Combined request for both fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap"></noscript>
    <?php
}
add_action( 'wp_head', 'cozyrecipes_resource_hints', 2 );

/**
 * D. Preload LCP image with responsive srcset/sizes - CRITICAL for LCP
 * Homepage: First recipe card image (usually Featured section)
 * Single posts: Featured image
 */
function cozyrecipes_preload_lcp_image() {
    // D. Single posts: Featured image is LCP element
    if ( is_singular( 'post' ) && has_post_thumbnail() ) {
        $post_id = get_the_ID();
        $attachment_id = get_post_thumbnail_id( $post_id );

        if ( $attachment_id ) {
            $image_meta = wp_get_attachment_metadata( $attachment_id );
            $full_src = wp_get_attachment_image_src( $attachment_id, 'full' );

            if ( $full_src ) {
                // Generate responsive srcset
                $srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
                $sizes = wp_get_attachment_image_sizes( $attachment_id, 'full' );

                if ( $srcset && $sizes ) {
                    echo '<link rel="preload" as="image" href="' . esc_url( $full_src[0] ) . '" imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="' . esc_attr( $sizes ) . '" fetchpriority="high">' . "\n";
                } else {
                    echo '<link rel="preload" as="image" href="' . esc_url( $full_src[0] ) . '" fetchpriority="high">' . "\n";
                }
            }
        }
    }
    // D. Homepage: First recipe card image is LCP element
    elseif ( is_front_page() || is_home() ) {
        // Query first featured/latest recipe to preload its thumbnail
        $show_featured = get_theme_mod( 'cozyrecipes_show_featured', true );
        $featured_category = get_theme_mod( 'cozyrecipes_featured_category', '' );

        $lcp_args = array(
            'post_type'      => 'post',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'fields'         => 'ids',
        );

        // Use same logic as front-page.php
        if ( $show_featured ) {
            if ( ! empty( $featured_category ) ) {
                $lcp_args['cat'] = absint( $featured_category );
            } else {
                $lcp_args['tag'] = 'featured';
            }
        }

        $lcp_query = new WP_Query( $lcp_args );

        if ( ! empty( $lcp_query->posts ) ) {
            $first_post_id = $lcp_query->posts[0];
            $attachment_id = get_post_thumbnail_id( $first_post_id );

            if ( $attachment_id ) {
                $thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'cozyrecipes-thumbnail' );

                if ( $thumbnail_src ) {
                    // Generate responsive srcset for 2:3 ratio thumbnail (600x900)
                    $srcset = wp_get_attachment_image_srcset( $attachment_id, 'cozyrecipes-thumbnail' );
                    $sizes = '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px';

                    if ( $srcset ) {
                        echo '<link rel="preload" as="image" href="' . esc_url( $thumbnail_src[0] ) . '" imagesrcset="' . esc_attr( $srcset ) . '" imagesizes="' . esc_attr( $sizes ) . '" fetchpriority="high">' . "\n";
                    } else {
                        echo '<link rel="preload" as="image" href="' . esc_url( $thumbnail_src[0] ) . '" fetchpriority="high">' . "\n";
                    }
                }
            }
        }

        wp_reset_postdata();
    }
}
add_action( 'wp_head', 'cozyrecipes_preload_lcp_image', 2 );

/**
 * C & F. Enqueue Scripts and Styles with filemtime() versioning
 * filemtime() = intelligent cache busting (only updates when file changes)
 */
function cozyrecipes_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );

    // F. Use file modification time for intelligent cache busting
    $style_file = get_template_directory() . '/style.css';
    $style_version = file_exists( $style_file ) ? filemtime( $style_file ) : $theme_version;

    $js_file = get_template_directory() . '/js/navigation.js';
    $js_version = file_exists( $js_file ) ? filemtime( $js_file ) : $theme_version;

    // B. Enqueue theme stylesheet (will be deferred via filter below)
    wp_enqueue_style( 'cozyrecipes-style', get_stylesheet_uri(), array(), $style_version, 'all' );

    // C. Enqueue theme JavaScript (will be deferred via filter below)
    wp_enqueue_script( 'cozyrecipes-navigation', get_template_directory_uri() . '/js/navigation.js', array(), $js_version, true );

    // Enqueue comment reply script only when needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_scripts' );

/**
 * Remove unnecessary WordPress default styles and scripts
 */
function cozyrecipes_remove_wp_block_library_css() {
    // Remove block library CSS (Gutenberg styles)
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );

    // Remove classic theme styles
    wp_dequeue_style( 'classic-theme-styles' );

    // Remove global styles
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_remove_wp_block_library_css', 100 );

/**
 * Remove WordPress emoji scripts
 */
function cozyrecipes_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'cozyrecipes_disable_emojis' );

/**
 * Remove WordPress embed script
 */
function cozyrecipes_deregister_scripts() {
    wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'cozyrecipes_deregister_scripts' );

/**
 * Remove unnecessary header meta tags for better performance
 */
function cozyrecipes_remove_head_links() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}
add_action( 'init', 'cozyrecipes_remove_head_links' );

/**
 * Add defer attribute to scripts
 */
function cozyrecipes_defer_scripts( $tag, $handle ) {
    $defer_scripts = array( 'cozyrecipes-navigation' );

    if ( in_array( $handle, $defer_scripts, true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'cozyrecipes_defer_scripts', 10, 2 );

/**
 * Defer non-critical CSS using media print trick with fetchpriority
 */
function cozyrecipes_defer_css( $html, $handle ) {
    if ( 'cozyrecipes-style' === $handle ) {
        // Use media print trick for non-blocking load
        $html = str_replace( "media='all'", "media='print' onload=\"this.media='all'\" fetchpriority='low'", $html );
        // Add noscript fallback
        $html .= '<noscript><link rel="stylesheet" href="' . esc_url( get_stylesheet_uri() ) . '"></noscript>';
    }
    return $html;
}
add_filter( 'style_loader_tag', 'cozyrecipes_defer_css', 10, 2 );

/**
 * Remove query strings from static resources
 */
function cozyrecipes_remove_query_strings( $src ) {
    if ( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'cozyrecipes_remove_query_strings', 10, 1 );
add_filter( 'script_loader_src', 'cozyrecipes_remove_query_strings', 10, 1 );

/**
 * Custom excerpt length
 */
function cozyrecipes_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'cozyrecipes_excerpt_length', 999 );

/**
 * Custom excerpt more
 */
function cozyrecipes_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'cozyrecipes_excerpt_more' );

/**
 * Add a custom class to menu items that have children
 */
function cozyrecipes_add_menu_item_class( $classes, $item, $args ) {
    if ( in_array( 'menu-item-has-children', $classes ) ) {
        $classes[] = 'has-dropdown';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'cozyrecipes_add_menu_item_class', 10, 3 );

/**
 * Get reading time for a post
 */
function cozyrecipes_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );

    return $reading_time . ' min read';
}

/**
 * Get first category of a post
 */
function cozyrecipes_first_category() {
    $categories = get_the_category();
    if ( ! empty( $categories ) ) {
        return $categories[0];
    }
    return false;
}

/**
 * Customizer Settings
 */
function cozyrecipes_customize_register( $wp_customize ) {

    // ========================================
    // COLORS SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_colors', array(
        'title'    => __( 'Theme Colors', 'cozyrecipes' ),
        'priority' => 30,
    ) );

    // Primary Accent Color
    $wp_customize->add_setting( 'cozyrecipes_accent_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_accent_color', array(
        'label'    => __( 'Primary Accent Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_accent_color',
    ) ) );

    // Header Background Color
    $wp_customize->add_setting( 'cozyrecipes_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_header_bg_color', array(
        'label'    => __( 'Header Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_header_bg_color',
    ) ) );

    // Header Text Color
    $wp_customize->add_setting( 'cozyrecipes_header_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_header_text_color', array(
        'label'    => __( 'Header Text Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_header_text_color',
    ) ) );

    // Body Background Color
    $wp_customize->add_setting( 'cozyrecipes_body_bg_color', array(
        'default'           => '#f8f8f8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_body_bg_color', array(
        'label'    => __( 'Body Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_body_bg_color',
    ) ) );

    // Hero Background Color
    $wp_customize->add_setting( 'cozyrecipes_hero_bg_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_hero_bg_color', array(
        'label'       => __( 'Hero Background Color', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_hero_bg_color',
        'description' => __( 'Background color for the hero search section', 'cozyrecipes' ),
    ) ) );

    // Footer Background Color
    $wp_customize->add_setting( 'cozyrecipes_footer_bg_color', array(
        'default'           => '#2a2a2a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_bg_color', array(
        'label'    => __( 'Footer Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_footer_bg_color',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'cozyrecipes_footer_text_color', array(
        'default'           => '#cccccc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_text_color', array(
        'label'    => __( 'Footer Text Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_footer_text_color',
    ) ) );

    // ========================================
    // HERO SECTION (Search Bar Only)
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_hero', array(
        'title'       => __( 'Hero Section', 'cozyrecipes' ),
        'description' => __( 'The hero section displays a search bar for recipes.', 'cozyrecipes' ),
        'priority'    => 40,
    ) );

    // Search Placeholder
    $wp_customize->add_setting( 'cozyrecipes_search_placeholder', array(
        'default'           => 'Search for recipes...',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_search_placeholder', array(
        'label'    => __( 'Search Placeholder Text', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // ========================================
    // HOMEPAGE SECTIONS
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_homepage', array(
        'title'    => __( 'Homepage Sections', 'cozyrecipes' ),
        'priority' => 45,
    ) );

    // Show Featured Recipes
    $wp_customize->add_setting( 'cozyrecipes_show_featured', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_featured', array(
        'label'    => __( 'Show Featured Recipes Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'checkbox',
    ) );

    // Featured Section Title (Editor's Pick)
    $wp_customize->add_setting( 'cozyrecipes_featured_title', array(
        'default'           => 'Editor\'s Pick',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_featured_title', array(
        'label'       => __( 'Featured Section Title', 'cozyrecipes' ),
        'description' => __( 'Shows 1 featured post with author sidebar', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_homepage',
        'type'        => 'text',
    ) );

    // Featured Section Subtitle
    $wp_customize->add_setting( 'cozyrecipes_featured_subtitle', array(
        'default'           => 'Our top recipe recommendation just for you',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_featured_subtitle', array(
        'label'    => __( 'Featured Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Featured Category
    $wp_customize->add_setting( 'cozyrecipes_featured_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_featured_category', array(
        'label'    => __( 'Featured Category (leave empty for "Featured" tag)', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'select',
        'choices'  => cozyrecipes_get_categories_choices(),
    ) );

    // Show Popular Categories
    $wp_customize->add_setting( 'cozyrecipes_show_categories', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_categories', array(
        'label'    => __( 'Show Popular Categories Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'checkbox',
    ) );

    // Categories Section Title
    $wp_customize->add_setting( 'cozyrecipes_categories_title', array(
        'default'           => 'Popular Categories',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_categories_title', array(
        'label'    => __( 'Categories Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Categories Section Subtitle
    $wp_customize->add_setting( 'cozyrecipes_categories_subtitle', array(
        'default'           => 'Browse recipes by your favorite categories',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_categories_subtitle', array(
        'label'    => __( 'Categories Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Latest Recipes Title
    $wp_customize->add_setting( 'cozyrecipes_latest_title', array(
        'default'           => 'Latest Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_latest_title', array(
        'label'    => __( 'Latest Recipes Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Latest Recipes Subtitle
    $wp_customize->add_setting( 'cozyrecipes_latest_subtitle', array(
        'default'           => 'Fresh and delicious recipes added recently',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_latest_subtitle', array(
        'label'    => __( 'Latest Recipes Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Latest Recipes Category
    $wp_customize->add_setting( 'cozyrecipes_latest_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_latest_category', array(
        'label'       => __( 'Latest Recipes Category', 'cozyrecipes' ),
        'description' => __( 'Filter latest recipes by category (leave empty to show all categories)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_homepage',
        'type'        => 'select',
        'choices'     => cozyrecipes_get_categories_choices(),
    ) );

    // Number of Latest Posts
    $wp_customize->add_setting( 'cozyrecipes_latest_count', array(
        'default'           => '9',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_latest_count', array(
        'label'       => __( 'Number of Latest Posts', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_homepage',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3,
            'max'  => 18,
            'step' => 1,
        ),
    ) );

    // Number of Popular Categories
    $wp_customize->add_setting( 'cozyrecipes_categories_count', array(
        'default'           => '8',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_categories_count', array(
        'label'       => __( 'Number of Categories to Display', 'cozyrecipes' ),
        'description' => __( 'How many popular categories to show (sorted by post count)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_homepage',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 4,
            'max'  => 16,
            'step' => 1,
        ),
    ) );

    // ========================================
    // ABOUT AUTHOR SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_about_author', array(
        'title'       => __( 'About Author (Featured Section)', 'cozyrecipes' ),
        'description' => __( 'Customize the About Author sidebar that appears next to Featured Recipes', 'cozyrecipes' ),
        'priority'    => 46,
    ) );

    // Show About Author
    $wp_customize->add_setting( 'cozyrecipes_show_about_author', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_about_author', array(
        'label'    => __( 'Show About Author Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_about_author',
        'type'     => 'checkbox',
    ) );

    // Author Image
    $wp_customize->add_setting( 'cozyrecipes_author_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cozyrecipes_author_image', array(
        'label'       => __( 'Author Image', 'cozyrecipes' ),
        'description' => __( 'Upload an image of the author. Recommended size: 300x300px', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_about_author',
        'settings'    => 'cozyrecipes_author_image',
    ) ) );

    // Author Name
    $wp_customize->add_setting( 'cozyrecipes_author_name', array(
        'default'           => 'Chef Name',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_name', array(
        'label'    => __( 'Author Name', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_about_author',
        'type'     => 'text',
    ) );

    // Author Title
    $wp_customize->add_setting( 'cozyrecipes_author_title', array(
        'default'           => 'Recipe Creator',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_title', array(
        'label'    => __( 'Author Title/Role', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_about_author',
        'type'     => 'text',
    ) );

    // Author Description
    $wp_customize->add_setting( 'cozyrecipes_author_description', array(
        'default'           => 'Passionate about creating delicious recipes and sharing culinary adventures.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_description', array(
        'label'    => __( 'Author Description', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_about_author',
        'type'     => 'textarea',
    ) );

    // Button Text
    $wp_customize->add_setting( 'cozyrecipes_author_button_text', array(
        'default'           => 'Read More',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_button_text', array(
        'label'    => __( 'Button Text', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_about_author',
        'type'     => 'text',
    ) );

    // Button Link
    $wp_customize->add_setting( 'cozyrecipes_author_button_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_button_link', array(
        'label'       => __( 'Button Link URL', 'cozyrecipes' ),
        'description' => __( 'URL for the "Read More" button (e.g., /about/ or author page)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_about_author',
        'type'        => 'url',
    ) );

    // ========================================
    // LAYOUT SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_layout', array(
        'title'    => __( 'Layout Options', 'cozyrecipes' ),
        'priority' => 50,
    ) );

    // Sidebar Position
    $wp_customize->add_setting( 'cozyrecipes_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'cozyrecipes_sanitize_sidebar_position',
    ) );

    $wp_customize->add_control( 'cozyrecipes_sidebar_position', array(
        'label'    => __( 'Sidebar Position', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_layout',
        'type'     => 'select',
        'choices'  => array(
            'none'  => __( 'No Sidebar', 'cozyrecipes' ),
            'right' => __( 'Right Sidebar', 'cozyrecipes' ),
            'left'  => __( 'Left Sidebar', 'cozyrecipes' ),
        ),
    ) );

    // Container Width
    $wp_customize->add_setting( 'cozyrecipes_container_width', array(
        'default'           => 'normal',
        'sanitize_callback' => 'cozyrecipes_sanitize_container_width',
    ) );

    $wp_customize->add_control( 'cozyrecipes_container_width', array(
        'label'    => __( 'Container Width', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_layout',
        'type'     => 'select',
        'choices'  => array(
            'normal' => __( 'Normal (1200px)', 'cozyrecipes' ),
            'wide'   => __( 'Wide (1400px)', 'cozyrecipes' ),
        ),
    ) );

    // ========================================
    // RECIPE CARDS DISPLAY
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_recipe_cards', array(
        'title'       => __( 'Recipe Cards', 'cozyrecipes' ),
        'description' => __( 'Customize the appearance of recipe cards in grids and archives.', 'cozyrecipes' ),
        'priority'    => 52,
    ) );

    // Show Category Badge
    $wp_customize->add_setting( 'cozyrecipes_show_category_badge', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_category_badge', array(
        'label'       => __( 'Show Category Badge on Recipe Cards', 'cozyrecipes' ),
        'description' => __( 'Display the primary category badge on recipe card images.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_cards',
        'type'        => 'checkbox',
    ) );

    // Category Badge Color
    $wp_customize->add_setting( 'cozyrecipes_category_badge_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_category_badge_color', array(
        'label'       => __( 'Category Badge Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the category badge.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_cards',
        'settings'    => 'cozyrecipes_category_badge_color',
    ) ) );

    // ========================================
    // SINGLE POST SETTINGS
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_single_post', array(
        'title'    => __( 'Single Post Settings', 'cozyrecipes' ),
        'priority' => 55,
    ) );

    // Show/Hide Featured Image on Single Posts
    $wp_customize->add_setting( 'cozyrecipes_single_featured_image', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_single_featured_image', array(
        'label'    => __( 'Show Featured Image on Single Posts', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_single_post',
        'type'     => 'checkbox',
    ) );
}
add_action( 'customize_register', 'cozyrecipes_customize_register' );

/**
 * Sanitize checkbox
 */
function cozyrecipes_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize sidebar position
 */
function cozyrecipes_sanitize_sidebar_position( $input ) {
    $valid = array( 'none', 'right', 'left' );
    return ( in_array( $input, $valid ) ) ? $input : 'right';
}

/**
 * Sanitize container width
 */
function cozyrecipes_sanitize_container_width( $input ) {
    $valid = array( 'normal', 'wide' );
    return ( in_array( $input, $valid ) ) ? $input : 'normal';
}

/**
 * Get categories for customizer
 */
function cozyrecipes_get_categories_choices() {
    $choices = array( '' => __( '— Select —', 'cozyrecipes' ) );
    $categories = get_categories( array( 'hide_empty' => false ) );

    foreach ( $categories as $category ) {
        $choices[ $category->term_id ] = $category->name;
    }

    return $choices;
}

/**
 * Output custom CSS from Customizer
 */
function cozyrecipes_customizer_css() {
    $accent_color = get_theme_mod( 'cozyrecipes_accent_color', '#ff6b6b' );
    $header_bg = get_theme_mod( 'cozyrecipes_header_bg_color', '#ffffff' );
    $header_text = get_theme_mod( 'cozyrecipes_header_text_color', '#333333' );
    $body_bg = get_theme_mod( 'cozyrecipes_body_bg_color', '#f8f8f8' );
    $hero_bg = get_theme_mod( 'cozyrecipes_hero_bg_color', '#ff6b6b' );
    $footer_bg = get_theme_mod( 'cozyrecipes_footer_bg_color', '#2a2a2a' );
    $footer_text = get_theme_mod( 'cozyrecipes_footer_text_color', '#cccccc' );
    $category_badge_color = get_theme_mod( 'cozyrecipes_category_badge_color', '#ff6b6b' );

    ?>
    <style type="text/css">
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: <?php echo esc_attr( $body_bg ); ?>;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
        }

        .main-navigation a,
        .site-title a {
            color: <?php echo esc_attr( $header_text ); ?>;
        }

        .hero-section {
            background-color: <?php echo esc_attr( $hero_bg ); ?>;
        }

        .site-footer {
            background-color: <?php echo esc_attr( $footer_bg ); ?>;
            color: <?php echo esc_attr( $footer_text ); ?>;
        }

        a,
        .main-navigation a:hover,
        .recipe-link {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .hero-search-form button,
        .search-form button,
        .pagination a:hover,
        .pagination .current {
            background-color: <?php echo esc_attr( $accent_color ); ?>;
        }

        /* Category Badge Custom Color */
        .recipe-category-badge {
            background-color: <?php echo esc_attr( $category_badge_color ); ?>;
            color: #fff;
        }

        .recipe-card-title a:hover,
        .site-title a:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .footer-widget-area .widget ul li a:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .site-info a:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .header-search-toggle:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .footer-widget-area .widget-title {
            color: #fff;
        }

        .footer-widget-area .widget ul li a {
            color: <?php echo esc_attr( $footer_text ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'cozyrecipes_customizer_css' );

/**
 * Get sidebar class based on position
 */
function cozyrecipes_get_sidebar_class() {
    $position = get_theme_mod( 'cozyrecipes_sidebar_position', 'right' );

    if ( 'none' === $position ) {
        return '';
    }

    return 'has-sidebar sidebar-' . $position;
}

/**
 * Check if sidebar should be shown
 */
function cozyrecipes_show_sidebar() {
    $position = get_theme_mod( 'cozyrecipes_sidebar_position', 'right' );
    return 'none' !== $position;
}

/**
 * Get container class
 */
function cozyrecipes_get_container_class() {
    $width = get_theme_mod( 'cozyrecipes_container_width', 'normal' );
    return 'container' . ( 'wide' === $width ? ' wide' : '' );
}

/**
 * Add lazy loading and fetchpriority to images
 */
function cozyrecipes_optimize_images( $attr, $attachment, $size ) {
    // Don't lazy load featured image on single posts (it's the LCP element)
    if ( is_singular( 'post' ) && get_post_thumbnail_id() === $attachment->ID ) {
        $attr['fetchpriority'] = 'high';
        $attr['loading'] = 'eager';
    } else {
        $attr['loading'] = 'lazy';
    }

    // Add decoding="async" for better performance
    $attr['decoding'] = 'async';

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'cozyrecipes_optimize_images', 10, 3 );

/**
 * Enable automatic width and height attributes on images
 */
add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_true' );

/**
 * Add Open Graph and SEO meta tags
 */
function cozyrecipes_seo_meta_tags() {
    if ( is_singular( 'post' ) ) {
        global $post;
        setup_postdata( $post );

        $title = get_the_title();
        $description = get_the_excerpt();
        $image = has_post_thumbnail() ? get_the_post_thumbnail_url( $post->ID, 'large' ) : '';
        $url = get_permalink();

        ?>
        <!-- Open Graph Meta Tags -->
        <meta property="og:type" content="article">
        <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
        <meta property="og:description" content="<?php echo esc_attr( wp_trim_words( $description, 20 ) ); ?>">
        <meta property="og:url" content="<?php echo esc_url( $url ); ?>">
        <?php if ( $image ) : ?>
        <meta property="og:image" content="<?php echo esc_url( $image ); ?>">
        <?php endif; ?>
        <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr( wp_trim_words( $description, 20 ) ); ?>">
        <?php if ( $image ) : ?>
        <meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
        <?php endif; ?>

        <!-- SEO Meta Tags -->
        <meta name="description" content="<?php echo esc_attr( wp_trim_words( $description, 30 ) ); ?>">
        <?php
        wp_reset_postdata();
    } elseif ( is_front_page() || is_home() ) {
        $title = get_bloginfo( 'name' );
        $description = get_bloginfo( 'description' );
        ?>
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
        <meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
        <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
        <meta name="description" content="<?php echo esc_attr( $description ); ?>">
        <?php
    }
}
add_action( 'wp_head', 'cozyrecipes_seo_meta_tags', 5 );

/**
 * Add Recipe Schema markup for single posts
 */
function cozyrecipes_recipe_schema() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    global $post;
    setup_postdata( $post );

    $title = get_the_title();
    $description = get_the_excerpt();
    $image = has_post_thumbnail() ? get_the_post_thumbnail_url( $post->ID, 'large' ) : '';
    $author = get_the_author();
    $published = get_the_date( 'c' );
    $modified = get_the_modified_date( 'c' );

    $schema = array(
        '@context'      => 'https://schema.org/',
        '@type'         => 'Recipe',
        'name'          => $title,
        'description'   => wp_trim_words( $description, 30 ),
        'author'        => array(
            '@type' => 'Person',
            'name'  => $author,
        ),
        'datePublished' => $published,
        'dateModified'  => $modified,
    );

    if ( $image ) {
        $schema['image'] = $image;
    }

    ?>
    <script type="application/ld+json">
    <?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
    </script>
    <?php

    wp_reset_postdata();
}
add_action( 'wp_head', 'cozyrecipes_recipe_schema', 10 );

/**
 * Improve accessibility of pagination links
 */
function cozyrecipes_pagination_aria( $output ) {
    $output = str_replace( '<a class=', '<a aria-label="Page" class=', $output );
    $output = str_replace( 'class="prev page-numbers"', 'class="prev page-numbers" aria-label="Previous page"', $output );
    $output = str_replace( 'class="next page-numbers"', 'class="next page-numbers" aria-label="Next page"', $output );
    return $output;
}
add_filter( 'navigation_markup_template', 'cozyrecipes_pagination_aria' );

/**
 * Disable unnecessary REST API endpoints for performance
 */
function cozyrecipes_disable_rest_endpoints( $endpoints ) {
    if ( ! is_user_logged_in() ) {
        if ( isset( $endpoints['/wp/v2/users'] ) ) {
            unset( $endpoints['/wp/v2/users'] );
        }
        if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
        }
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'cozyrecipes_disable_rest_endpoints' );

/**
 * Add language attribute to html tag for better accessibility
 */
function cozyrecipes_language_attributes( $output ) {
    if ( ! is_admin() ) {
        $output .= ' lang="' . esc_attr( get_bloginfo( 'language' ) ) . '"';
    }
    return $output;
}
add_filter( 'language_attributes', 'cozyrecipes_language_attributes' );

/* ========================================
   CATEGORY SLIDER - TERM META REGISTRATION
======================================== */

/**
 * Register custom term meta fields for categories
 */
function cozyrecipes_register_category_meta() {
    register_term_meta( 'category', 'category_icon', array(
        'type'              => 'string',
        'description'       => 'Custom icon URL for category',
        'single'            => true,
        'sanitize_callback' => 'esc_url_raw',
        'show_in_rest'      => true,
    ) );

    register_term_meta( 'category', 'category_color', array(
        'type'              => 'string',
        'description'       => 'Custom color for category icon background',
        'single'            => true,
        'sanitize_callback' => 'sanitize_hex_color',
        'show_in_rest'      => true,
    ) );

    register_term_meta( 'category', 'category_custom_count', array(
        'type'              => 'integer',
        'description'       => 'Custom badge number for category (optional)',
        'single'            => true,
        'sanitize_callback' => 'absint',
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'cozyrecipes_register_category_meta' );

/* ========================================
   CATEGORY SLIDER - HELPER FUNCTIONS
======================================== */

/**
 * Get category icon URL with fallback to emoji
 */
function cozyrecipes_get_category_icon( $category_id, $category_slug = '' ) {
    $icon_url = get_term_meta( $category_id, 'category_icon', true );
    
    if ( ! empty( $icon_url ) ) {
        return $icon_url;
    }
    
    // Fallback emoji mapping
    $emoji_map = array(
        'breakfast'  => '🍳',
        'lunch'      => '🥗',
        'dinner'     => '🍽️',
        'dessert'    => '🍰',
        'desserts'   => '🍰',
        'appetizer'  => '🥙',
        'appetizers' => '🥙',
        'salad'      => '🥗',
        'salads'     => '🥗',
        'soup'       => '🍲',
        'soups'      => '🍲',
        'pasta'      => '🍝',
        'pizza'      => '🍕',
        'burger'     => '🍔',
        'burgers'    => '🍔',
        'sandwich'   => '🥪',
        'sandwiches' => '🥪',
        'vegan'      => '🌱',
        'vegetarian' => '🥕',
        'seafood'    => '🐟',
        'chicken'    => '🍗',
        'beef'       => '🥩',
        'pork'       => '🥓',
        'bread'      => '🍞',
        'baking'     => '🥖',
        'cookies'    => '🍪',
        'cake'       => '🎂',
        'cakes'      => '🎂',
        'drinks'     => '🥤',
        'smoothie'   => '🥤',
        'smoothies'  => '🥤',
    );
    
    return isset( $emoji_map[ $category_slug ] ) ? $emoji_map[ $category_slug ] : '🍴';
}

/**
 * Get category color with fallback
 */
function cozyrecipes_get_category_color( $category_id ) {
    $color = get_term_meta( $category_id, 'category_color', true );
    return ! empty( $color ) ? $color : '#ff6b6b';
}

/**
 * Get category badge count (custom or real post count)
 */
function cozyrecipes_get_category_count( $category_id, $real_count = 0 ) {
    $custom_count = get_term_meta( $category_id, 'category_custom_count', true );
    return ! empty( $custom_count ) ? absint( $custom_count ) : absint( $real_count );
}

/**
 * Check if category slider is enabled
 */
function cozyrecipes_is_category_slider_enabled() {
    return get_theme_mod( 'cozyrecipes_enable_category_slider', true );
}

/**
 * Get selected categories for slider
 * Returns array of category IDs
 */
function cozyrecipes_get_selected_categories() {
    $selected = get_theme_mod( 'cozyrecipes_slider_categories', array() );

    // If empty, return all categories
    if ( empty( $selected ) ) {
        $all_categories = get_categories( array( 'hide_empty' => true ) );
        return wp_list_pluck( $all_categories, 'term_id' );
    }

    // Return selected category IDs as integers
    return array_map( 'absint', (array) $selected );
}

/**
 * Sanitize category array for multi-checkbox
 */
function cozyrecipes_sanitize_category_array( $input ) {
    if ( ! is_array( $input ) ) {
        $input = explode( ',', $input );
    }
    return array_map( 'absint', array_filter( $input ) );
}

/* ========================================
   CATEGORY SLIDER - CUSTOMIZER PANEL
======================================== */

/**
 * Custom Customizer Control for Multi-Checkbox
 * Only load if in Customizer context
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class CozyRecipes_Multi_Checkbox_Control extends WP_Customize_Control {
        public $type = 'multi-checkbox';

        public function render_content() {
            if ( empty( $this->choices ) ) {
                return;
            }

            $value = $this->value();
            if ( ! is_array( $value ) ) {
                $value = ! empty( $value ) ? explode( ',', $value ) : array();
            }
            $multi_values = $value;
            $name = '_customize-multi-checkbox-' . $this->id;
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
                <ul style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; margin-top: 5px;">
                    <?php foreach ( $this->choices as $value => $label ) : ?>
                        <li style="margin-bottom: 5px;">
                            <label>
                                <input type="checkbox"
                                       name="<?php echo esc_attr( $name ); ?>"
                                       value="<?php echo esc_attr( $value ); ?>"
                                       class="<?php echo esc_attr( $name ); ?>"
                                       <?php checked( in_array( $value, $multi_values ) ); ?>
                                       style="margin-right: 5px;" />
                                <?php echo esc_html( $label ); ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
            </label>
            <script>
            jQuery(document).ready(function($) {
                var checkboxes = $('.<?php echo esc_js( $name ); ?>');
                var hiddenInput = $('input[data-customize-setting-link="<?php echo esc_js( $this->settings['default']->id ); ?>"]');

                checkboxes.on('change', function() {
                    var values = [];
                    checkboxes.filter(':checked').each(function() {
                        values.push($(this).val());
                    });
                    hiddenInput.val(values.join(',')).trigger('change');
                });
            });
            </script>
            <?php
        }
    }
}

/* ========================================
   CATEGORY SLIDER - CUSTOMIZER PANEL
======================================== */

/**
 * Add Category Slider Customizer Panel and Controls
 */
function cozyrecipes_category_slider_customizer( $wp_customize ) {
    
    // Add Category Slider Panel
    $wp_customize->add_panel( 'cozyrecipes_category_slider', array(
        'title'       => __( 'Category Slider Settings', 'cozyrecipes' ),
        'description' => __( 'Customize category icons, colors, and badge numbers', 'cozyrecipes' ),
        'priority'    => 35,
    ) );
    
    // General Settings Section
    $wp_customize->add_section( 'cozyrecipes_category_slider_general', array(
        'title'       => __( 'General Settings', 'cozyrecipes' ),
        'panel'       => 'cozyrecipes_category_slider',
        'priority'    => 10,
    ) );
    
    // Enable/Disable Category Slider
    $wp_customize->add_setting( 'cozyrecipes_enable_category_slider', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'cozyrecipes_enable_category_slider', array(
        'label'       => __( 'Enable Category Slider', 'cozyrecipes' ),
        'description' => __( 'Show/hide the category slider on homepage', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_category_slider_general',
        'type'        => 'checkbox',
    ) );
    
    // Slider Title
    $wp_customize->add_setting( 'cozyrecipes_category_slider_title', array(
        'default'           => 'Browse by Category',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'cozyrecipes_category_slider_title', array(
        'label'       => __( 'Slider Title', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_category_slider_general',
        'type'        => 'text',
    ) );
    
    // Slider Subtitle
    $wp_customize->add_setting( 'cozyrecipes_category_slider_subtitle', array(
        'default'           => 'Discover delicious recipes organized by category',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'cozyrecipes_category_slider_subtitle', array(
        'label'       => __( 'Slider Subtitle', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_category_slider_general',
        'type'        => 'text',
    ) );
    
    // Number of categories to show
    $wp_customize->add_setting( 'cozyrecipes_category_slider_count', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ) );
    
    $wp_customize->add_control( 'cozyrecipes_category_slider_count', array(
        'label'       => __( 'Number of Categories', 'cozyrecipes' ),
        'description' => __( 'How many categories to display in the slider', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_category_slider_general',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 20,
            'step' => 1,
        ),
    ) );
    
    // Get all categories
    $categories = get_categories( array(
        'orderby'    => 'count',
        'order'      => 'DESC',
        'hide_empty' => true,
    ) );

    // Build category choices for multi-checkbox
    $category_choices = array();
    foreach ( $categories as $category ) {
        $category_choices[ $category->term_id ] = $category->name . ' (' . $category->count . ')';
    }

    // Category Selection Multi-Checkbox
    $wp_customize->add_setting( 'cozyrecipes_slider_categories', array(
        'default'           => array(),
        'sanitize_callback' => 'cozyrecipes_sanitize_category_array',
        'transport'         => 'refresh',
    ) );

    if ( class_exists( 'CozyRecipes_Multi_Checkbox_Control' ) ) {
        $wp_customize->add_control( new CozyRecipes_Multi_Checkbox_Control( $wp_customize, 'cozyrecipes_slider_categories', array(
            'label'       => __( 'Select Categories to Display', 'cozyrecipes' ),
            'description' => __( 'Choose which categories appear in the slider. Leave all unchecked to show all categories.', 'cozyrecipes' ),
            'section'     => 'cozyrecipes_category_slider_general',
            'choices'     => $category_choices,
        ) ) );
    }
    
    // Create a section for each category
    foreach ( $categories as $index => $category ) {
        $section_id = 'cozyrecipes_category_' . $category->term_id;
        
        // Add section for this category
        $wp_customize->add_section( $section_id, array(
            'title'       => sprintf( __( '%s Settings', 'cozyrecipes' ), $category->name ),
            'panel'       => 'cozyrecipes_category_slider',
            'priority'    => 20 + $index,
        ) );
        
        // Category Icon Upload
        $wp_customize->add_setting( $section_id . '_icon', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $section_id . '_icon', array(
            'label'       => __( 'Category Icon', 'cozyrecipes' ),
            'description' => __( 'Upload a custom icon (SVG, PNG, or JPG). Recommended size: 128x128px', 'cozyrecipes' ),
            'section'     => $section_id,
            'settings'    => $section_id . '_icon',
        ) ) );
        
        // Category Color
        $wp_customize->add_setting( $section_id . '_color', array(
            'default'           => '#ff6b6b',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $section_id . '_color', array(
            'label'       => __( 'Icon Background Color', 'cozyrecipes' ),
            'description' => __( 'Choose a color for the icon background', 'cozyrecipes' ),
            'section'     => $section_id,
            'settings'    => $section_id . '_color',
        ) ) );
        
        // Custom Badge Number
        $wp_customize->add_setting( $section_id . '_count', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( $section_id . '_count', array(
            'label'       => __( 'Custom Badge Number', 'cozyrecipes' ),
            'description' => sprintf( __( 'Leave empty to show real post count (%d posts)', 'cozyrecipes' ), $category->count ),
            'section'     => $section_id,
            'type'        => 'number',
            'input_attrs' => array(
                'min'         => 0,
                'placeholder' => $category->count,
            ),
        ) );
    }
}
add_action( 'customize_register', 'cozyrecipes_category_slider_customizer' );

/**
 * Save Customizer values to term meta
 */
function cozyrecipes_save_category_customizer_values() {
    $categories = get_categories( array( 'hide_empty' => true ) );
    
    foreach ( $categories as $category ) {
        $section_id = 'cozyrecipes_category_' . $category->term_id;
        
        // Save icon
        $icon = get_theme_mod( $section_id . '_icon', '' );
        if ( ! empty( $icon ) ) {
            update_term_meta( $category->term_id, 'category_icon', esc_url_raw( $icon ) );
        }
        
        // Save color
        $color = get_theme_mod( $section_id . '_color', '' );
        if ( ! empty( $color ) ) {
            update_term_meta( $category->term_id, 'category_color', sanitize_hex_color( $color ) );
        }
        
        // Save custom count
        $count = get_theme_mod( $section_id . '_count', '' );
        if ( ! empty( $count ) ) {
            update_term_meta( $category->term_id, 'category_custom_count', absint( $count ) );
        } else {
            delete_term_meta( $category->term_id, 'category_custom_count' );
        }
    }
}
add_action( 'customize_save_after', 'cozyrecipes_save_category_customizer_values' );

/* ========================================
   CATEGORY SLIDER - ENQUEUE ASSETS
======================================== */

/**
 * Enqueue category slider assets
 */
function cozyrecipes_enqueue_category_slider() {
    // Only enqueue on pages where slider is shown
    if ( ! is_front_page() && ! is_home() ) {
        return;
    }
    
    // Check if slider is enabled
    if ( ! cozyrecipes_is_category_slider_enabled() ) {
        return;
    }
    
    $theme_version = wp_get_theme()->get( 'Version' );
    
    // Enqueue CSS
    $css_file = get_template_directory() . '/css/category-slider.css';
    $css_version = file_exists( $css_file ) ? filemtime( $css_file ) : $theme_version;
    
    wp_enqueue_style( 
        'cozyrecipes-category-slider', 
        get_template_directory_uri() . '/css/category-slider.css', 
        array(), 
        $css_version, 
        'all' 
    );
    
    // Enqueue JS
    $js_file = get_template_directory() . '/js/category-slider.js';
    $js_version = file_exists( $js_file ) ? filemtime( $js_file ) : $theme_version;
    
    wp_enqueue_script( 
        'cozyrecipes-category-slider', 
        get_template_directory_uri() . '/js/category-slider.js', 
        array(), 
        $js_version, 
        true 
    );
    
    // Pass settings to JS (empty for now, auto-scroll disabled)
    wp_localize_script( 'cozyrecipes-category-slider', 'categorySliderSettings', array() );
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_enqueue_category_slider' );

/**
 * Add defer attribute to category slider script
 */
function cozyrecipes_defer_category_slider_script( $tag, $handle ) {
    if ( 'cozyrecipes-category-slider' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'cozyrecipes_defer_category_slider_script', 10, 2 );

/* ========================================
   EDITOR'S PICKS - ENQUEUE ASSETS
======================================== */

/**
 * Enqueue Editor's Picks styles and scripts
 */
function cozyrecipes_enqueue_editors_picks() {
    // Only load on front page or if template part is used
    if ( ! is_front_page() ) {
        return;
    }

    $css_file = get_template_directory() . '/assets/css/editors-picks.css';
    $js_file = get_template_directory() . '/assets/js/editors-picks.js';

    // Enqueue CSS
    if ( file_exists( $css_file ) ) {
        $css_version = filemtime( $css_file );
        wp_enqueue_style(
            'cozyrecipes-editors-picks',
            get_template_directory_uri() . '/assets/css/editors-picks.css',
            array(),
            $css_version
        );
    }

    // Enqueue JS
    if ( file_exists( $js_file ) ) {
        $js_version = filemtime( $js_file );
        wp_enqueue_script(
            'cozyrecipes-editors-picks',
            get_template_directory_uri() . '/assets/js/editors-picks.js',
            array(),
            $js_version,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_enqueue_editors_picks' );

/**
 * Add defer attribute to editor's picks script
 */
function cozyrecipes_defer_editors_picks_script( $tag, $handle ) {
    if ( 'cozyrecipes-editors-picks' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'cozyrecipes_defer_editors_picks_script', 10, 2 );

/**
 * Performance Optimizations - Reduce load time and improve PageSpeed
 */
function cozyrecipes_performance_optimizations() {
    // Remove querystring from static resources for better caching
    if ( ! is_admin() ) {
        // Remove query strings from CSS and JS (better caching)
        add_filter( 'script_loader_src', function( $src ) {
            return remove_query_arg( 'ver', $src );
        }, 10, 1 );
        add_filter( 'style_loader_src', function( $src ) {
            return remove_query_arg( 'ver', $src );
        }, 10, 1 );
    }

    // Lazy load all images by default
    add_filter( 'wp_img_tag_add_loading_attr', '__return_true' );
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_performance_optimizations', 1 );

/**
 * Add async loading to non-critical scripts
 */
function cozyrecipes_async_scripts( $tag, $handle ) {
    // Don't async navigation and slider - they're important for interactivity
    $critical_scripts = array( 'cozyrecipes-navigation', 'cozyrecipes-category-slider' );

    if ( ! in_array( $handle, $critical_scripts ) ) {
        if ( strpos( $tag, 'src' ) && 'cozyrecipes-editors-picks' !== $handle ) {
            return str_replace( ' src', ' async src', $tag );
        }
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'cozyrecipes_async_scripts', 10, 2 );

/**
 * Cache transients cleanup - Delete old cached queries periodically
 */
function cozyrecipes_cleanup_transients() {
    delete_transient( 'cozyrecipes_editors_picks_*' );
    delete_transient( 'cozyrecipes_categories_*' );
}
add_action( 'wp_scheduled_event', 'cozyrecipes_cleanup_transients' );

/* ========================================
   EDITOR'S PICKS - CUSTOMIZER SETTINGS
======================================== */

/**
 * Add Editor's Picks Customizer Settings
 */
function cozyrecipes_editors_picks_customizer( $wp_customize ) {

    // Add Section
    $wp_customize->add_section( 'cozyrecipes_editors_picks', array(
        'title'       => __( 'Editor\'s Picks Section', 'cozyrecipes' ),
        'description' => __( 'Configure the Editor\'s Picks section and Author Box', 'cozyrecipes' ),
        'priority'    => 47,
    ) );

    // === EDITOR'S PICKS SETTINGS ===

    // Show/Hide Editor's Picks Section
    $wp_customize->add_setting( 'cozyrecipes_show_editors_picks', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_editors_picks', array(
        'label'    => __( 'Show Editor\'s Picks Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'checkbox',
    ) );

    // Section Title
    $wp_customize->add_setting( 'cozyrecipes_editors_picks_title', array(
        'default'           => 'Editor\'s Picks',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_editors_picks_title', array(
        'label'    => __( 'Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'text',
    ) );

    // Section Subtitle
    $wp_customize->add_setting( 'cozyrecipes_editors_picks_subtitle', array(
        'default'           => 'Our favorite recipes selected just for you',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_editors_picks_subtitle', array(
        'label'    => __( 'Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'text',
    ) );

    // Number of Posts
    $wp_customize->add_setting( 'cozyrecipes_editors_picks_count', array(
        'default'           => '4',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_editors_picks_count', array(
        'label'       => __( 'Number of Posts', 'cozyrecipes' ),
        'description' => __( 'How many editor\'s pick posts to display', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2,
            'max'  => 8,
            'step' => 1,
        ),
    ) );

    // Source Type
    $wp_customize->add_setting( 'cozyrecipes_editors_picks_source', array(
        'default'           => 'tag',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_editors_picks_source', array(
        'label'       => __( 'Post Source', 'cozyrecipes' ),
        'description' => __( 'Choose how to select featured posts', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'type'        => 'select',
        'choices'     => array(
            'tag'      => __( 'By Tag (featured)', 'cozyrecipes' ),
            'category' => __( 'By Category', 'cozyrecipes' ),
        ),
    ) );

    // Category Selection
    $wp_customize->add_setting( 'cozyrecipes_editors_picks_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_editors_picks_category', array(
        'label'       => __( 'Featured Category', 'cozyrecipes' ),
        'description' => __( 'Select category if "By Category" is chosen above', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'type'        => 'select',
        'choices'     => cozyrecipes_get_categories_choices(),
    ) );

    // === AUTHOR BOX SETTINGS ===

    // Show/Hide Author Box
    $wp_customize->add_setting( 'cozyrecipes_show_author_box', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_author_box', array(
        'label'    => __( 'Show Author Box', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'checkbox',
    ) );

    // Author Box Title
    $wp_customize->add_setting( 'cozyrecipes_author_box_title', array(
        'default'           => 'Meet the Author',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_box_title', array(
        'label'    => __( 'Author Box Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'text',
    ) );

    // Author Image
    $wp_customize->add_setting( 'cozyrecipes_author_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cozyrecipes_author_image', array(
        'label'       => __( 'Author Photo', 'cozyrecipes' ),
        'description' => __( 'Upload a profile photo. Recommended: 240x240px square', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'settings'    => 'cozyrecipes_author_image',
    ) ) );

    // Author Name
    $wp_customize->add_setting( 'cozyrecipes_author_name', array(
        'default'           => 'Chef Name',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_name', array(
        'label'    => __( 'Author Name', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'text',
    ) );

    // Author Bio
    $wp_customize->add_setting( 'cozyrecipes_author_bio', array(
        'default'           => 'Passionate recipe creator sharing delicious meals and culinary adventures.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_bio', array(
        'label'       => __( 'Author Bio', 'cozyrecipes' ),
        'description' => __( 'Short bio (2-3 lines recommended)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'type'        => 'textarea',
    ) );

    // Author Button Text
    $wp_customize->add_setting( 'cozyrecipes_author_button_text', array(
        'default'           => 'Read More',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_button_text', array(
        'label'    => __( 'Button Text', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'text',
    ) );

    // Author Button URL
    $wp_customize->add_setting( 'cozyrecipes_author_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_button_url', array(
        'label'       => __( 'Button URL', 'cozyrecipes' ),
        'description' => __( 'URL for the Read More button (e.g., /about/)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'type'        => 'url',
    ) );

    // Instagram URL
    $wp_customize->add_setting( 'cozyrecipes_author_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_instagram', array(
        'label'    => __( 'Instagram URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'url',
    ) );

    // Pinterest URL
    $wp_customize->add_setting( 'cozyrecipes_author_pinterest', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_pinterest', array(
        'label'    => __( 'Pinterest URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'url',
    ) );

    // Facebook URL
    $wp_customize->add_setting( 'cozyrecipes_author_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_author_facebook', array(
        'label'    => __( 'Facebook URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_editors_picks',
        'type'     => 'url',
    ) );

    // === COLOR SETTINGS ===

    // Badge Color
    $wp_customize->add_setting( 'cozyrecipes_badge_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_badge_color', array(
        'label'       => __( 'Category Badge Color', 'cozyrecipes' ),
        'description' => __( 'Color for category badges on pick cards', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'settings'    => 'cozyrecipes_badge_color',
    ) ) );

    // Author Button Color
    $wp_customize->add_setting( 'cozyrecipes_author_button_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_author_button_color', array(
        'label'       => __( 'Author Button Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the Read More button', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_editors_picks',
        'settings'    => 'cozyrecipes_author_button_color',
    ) ) );
}
add_action( 'customize_register', 'cozyrecipes_editors_picks_customizer' );
