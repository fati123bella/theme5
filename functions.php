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
        'top-bar' => esc_html__( 'Top Bar Menu', 'cozyrecipes' ),
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

    <!-- Optimized font loading with media print trick for non-blocking CSS -->
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
 * FIXED: Proper jQuery loading order
 */
function cozyrecipes_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );

    // F. Use file modification time for intelligent cache busting
    $style_file = get_template_directory() . '/style.css';
    $style_version = file_exists( $style_file ) ? filemtime( $style_file ) : $theme_version;

    $js_file = get_template_directory() . '/js/navigation.js';
    $js_version = file_exists( $js_file ) ? filemtime( $js_file ) : $theme_version;

    // CRITICAL: Enqueue jQuery (loads in HEAD by default via WordPress)
    wp_enqueue_script( 'jquery' );

    // CRITICAL: Enqueue jQuery Migrate AFTER jQuery (also in HEAD)
    // Must load in HEAD, right after jQuery, before any jQuery-dependent scripts
    wp_enqueue_script(
        'jquery-migrate',
        includes_url( '/js/jquery/jquery-migrate.min.js' ),
        array( 'jquery' ),  // Depends on jQuery
        null,
        false  // FALSE = load in <head>, TRUE = load in footer
    );

    // B. Enqueue theme stylesheet (minified in production, full in development)
    $stylesheet_file = file_exists( get_template_directory() . '/style.min.css' ) ? '/style.min.css' : '/style.css';
    wp_enqueue_style( 'cozyrecipes-style', get_template_directory_uri() . $stylesheet_file, array(), $style_version, 'all' );

    // C. Enqueue theme JavaScript in footer (depends on jQuery)
    wp_enqueue_script( 'cozyrecipes-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), $js_version, true );

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
        'title'       => __( 'Theme Colors', 'cozyrecipes' ),
        'description' => __( 'Customize all colors throughout your theme', 'cozyrecipes' ),
        'priority'    => 30,
    ) );

    // Primary Accent Color
    $wp_customize->add_setting( 'cozyrecipes_accent_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_accent_color', array(
        'label'       => __( 'Primary Accent Color', 'cozyrecipes' ),
        'description' => __( 'Main theme accent color used for buttons, links, and highlights', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_accent_color',
    ) ) );

    // Secondary Accent Color
    $wp_customize->add_setting( 'cozyrecipes_accent_color_hover', array(
        'default'           => '#ff5252',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_accent_color_hover', array(
        'label'       => __( 'Accent Hover Color', 'cozyrecipes' ),
        'description' => __( 'Color for hover states on buttons and links', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_accent_color_hover',
    ) ) );

    // Body Background Color
    $wp_customize->add_setting( 'cozyrecipes_body_bg_color', array(
        'default'           => '#f8f8f8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_body_bg_color', array(
        'label'       => __( 'Body Background Color', 'cozyrecipes' ),
        'description' => __( 'Main background color for the website', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_body_bg_color',
    ) ) );

    // Body Text Color
    $wp_customize->add_setting( 'cozyrecipes_body_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_body_text_color', array(
        'label'       => __( 'Body Text Color', 'cozyrecipes' ),
        'description' => __( 'Main text color throughout the site', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_body_text_color',
    ) ) );

    // Heading Color
    $wp_customize->add_setting( 'cozyrecipes_heading_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_heading_color', array(
        'label'       => __( 'Headings Color', 'cozyrecipes' ),
        'description' => __( 'Color for all headings (H1, H2, H3, etc.)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_heading_color',
    ) ) );

    // Top Bar Background Color
    $wp_customize->add_setting( 'cozyrecipes_topbar_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_topbar_bg_color', array(
        'label'       => __( 'Top Bar Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the top bar with menu and social icons', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_topbar_bg_color',
    ) ) );

    // Top Bar Text Color
    $wp_customize->add_setting( 'cozyrecipes_topbar_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_topbar_text_color', array(
        'label'       => __( 'Top Bar Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for top bar menu items', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_topbar_text_color',
    ) ) );

    // Top Bar Border Color
    $wp_customize->add_setting( 'cozyrecipes_topbar_border_color', array(
        'default'           => '#f0f0f0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_topbar_border_color', array(
        'label'       => __( 'Top Bar Border Color', 'cozyrecipes' ),
        'description' => __( 'Border color for the top bar', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_topbar_border_color',
    ) ) );

    // Header Background Color
    $wp_customize->add_setting( 'cozyrecipes_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_header_bg_color', array(
        'label'       => __( 'Header Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the main header/navigation area', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_header_bg_color',
    ) ) );

    // Header Text Color
    $wp_customize->add_setting( 'cozyrecipes_header_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_header_text_color', array(
        'label'       => __( 'Header Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for header and navigation menu', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_header_text_color',
    ) ) );

    // Navigation Hover Color
    $wp_customize->add_setting( 'cozyrecipes_nav_hover_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_nav_hover_color', array(
        'label'       => __( 'Navigation Hover Color', 'cozyrecipes' ),
        'description' => __( 'Color when hovering over navigation menu items', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_nav_hover_color',
    ) ) );

    // Hero/Search Section Background Color
    $wp_customize->add_setting( 'cozyrecipes_hero_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_hero_bg_color', array(
        'label'       => __( 'Hero Section Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the hero/search section', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_hero_bg_color',
    ) ) );

    // Search Button Background Color
    $wp_customize->add_setting( 'cozyrecipes_search_button_bg_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_search_button_bg_color', array(
        'label'       => __( 'Search Button Color', 'cozyrecipes' ),
        'description' => __( 'Background color for search buttons', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_search_button_bg_color',
    ) ) );

    // Search Button Text Color
    $wp_customize->add_setting( 'cozyrecipes_search_button_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_search_button_text_color', array(
        'label'       => __( 'Search Button Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for search buttons', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_search_button_text_color',
    ) ) );

    // Card Background Color
    $wp_customize->add_setting( 'cozyrecipes_card_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_card_bg_color', array(
        'label'       => __( 'Card Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for recipe cards and widgets', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_card_bg_color',
    ) ) );

    // Category Badge Color
    $wp_customize->add_setting( 'cozyrecipes_category_badge_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_category_badge_color', array(
        'label'       => __( 'Category Badge Color', 'cozyrecipes' ),
        'description' => __( 'Background color for category badges on recipe cards', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_category_badge_color',
    ) ) );

    // Category Badge Text Color
    $wp_customize->add_setting( 'cozyrecipes_category_badge_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_category_badge_text_color', array(
        'label'       => __( 'Category Badge Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for category badges', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_category_badge_text_color',
    ) ) );

    // Button Background Color
    $wp_customize->add_setting( 'cozyrecipes_button_bg_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_button_bg_color', array(
        'label'       => __( 'Button Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for buttons throughout the site', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_button_bg_color',
    ) ) );

    // Button Text Color
    $wp_customize->add_setting( 'cozyrecipes_button_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_button_text_color', array(
        'label'       => __( 'Button Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for buttons', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_button_text_color',
    ) ) );

    // Link Color
    $wp_customize->add_setting( 'cozyrecipes_link_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_link_color', array(
        'label'       => __( 'Link Color', 'cozyrecipes' ),
        'description' => __( 'Color for links throughout the site', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_link_color',
    ) ) );

    // Link Hover Color
    $wp_customize->add_setting( 'cozyrecipes_link_hover_color', array(
        'default'           => '#ff5252',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_link_hover_color', array(
        'label'       => __( 'Link Hover Color', 'cozyrecipes' ),
        'description' => __( 'Color when hovering over links', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_link_hover_color',
    ) ) );

    // Meta Text Color
    $wp_customize->add_setting( 'cozyrecipes_meta_text_color', array(
        'default'           => '#888888',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_meta_text_color', array(
        'label'       => __( 'Meta Text Color', 'cozyrecipes' ),
        'description' => __( 'Color for post meta information (date, author, etc.)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_meta_text_color',
    ) ) );

    // Border Color
    $wp_customize->add_setting( 'cozyrecipes_border_color', array(
        'default'           => '#eee',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_border_color', array(
        'label'       => __( 'Border Color', 'cozyrecipes' ),
        'description' => __( 'Color for borders and dividers throughout the site', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_border_color',
    ) ) );

    // Footer Background Color
    $wp_customize->add_setting( 'cozyrecipes_footer_bg_color', array(
        'default'           => '#2a2a2a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_bg_color', array(
        'label'       => __( 'Footer Background Color', 'cozyrecipes' ),
        'description' => __( 'Background color for the footer area', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_footer_bg_color',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'cozyrecipes_footer_text_color', array(
        'default'           => '#cccccc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_text_color', array(
        'label'       => __( 'Footer Text Color', 'cozyrecipes' ),
        'description' => __( 'Text color for footer content', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_footer_text_color',
    ) ) );

    // Footer Link Color
    $wp_customize->add_setting( 'cozyrecipes_footer_link_color', array(
        'default'           => '#cccccc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_link_color', array(
        'label'       => __( 'Footer Link Color', 'cozyrecipes' ),
        'description' => __( 'Color for links in the footer', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_footer_link_color',
    ) ) );

    // Footer Link Hover Color
    $wp_customize->add_setting( 'cozyrecipes_footer_link_hover_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_footer_link_hover_color', array(
        'label'       => __( 'Footer Link Hover Color', 'cozyrecipes' ),
        'description' => __( 'Color when hovering over footer links', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_colors',
        'settings'    => 'cozyrecipes_footer_link_hover_color',
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

    // Disable Footer
    $wp_customize->add_setting( 'cozyrecipes_disable_footer', array(
        'default'           => false,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_disable_footer', array(
        'label'       => __( 'Disable Footer', 'cozyrecipes' ),
        'description' => __( 'Check to completely hide the footer section.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_layout',
        'type'        => 'checkbox',
    ) );

    // Disable Sticky Header
    $wp_customize->add_setting( 'cozyrecipes_disable_sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_disable_sticky_header', array(
        'label'       => __( 'Disable Sticky Header', 'cozyrecipes' ),
        'description' => __( 'Check to disable the sticky/fixed header on scroll.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_layout',
        'type'        => 'checkbox',
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

    // Show Post Date
    $wp_customize->add_setting( 'cozyrecipes_show_post_date', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_post_date', array(
        'label'       => __( 'Show Post Date', 'cozyrecipes' ),
        'description' => __( 'Display the post date on recipe cards and single posts.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_single_post',
        'type'        => 'checkbox',
    ) );

    // Show Post Author
    $wp_customize->add_setting( 'cozyrecipes_show_post_author', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_post_author', array(
        'label'       => __( 'Show Post Author', 'cozyrecipes' ),
        'description' => __( 'Display the author name on single posts.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_single_post',
        'type'        => 'checkbox',
    ) );

    // Show Reading Time
    $wp_customize->add_setting( 'cozyrecipes_show_reading_time', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_reading_time', array(
        'label'       => __( 'Show Reading Time', 'cozyrecipes' ),
        'description' => __( 'Display the estimated reading time on recipe cards and single posts.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_single_post',
        'type'        => 'checkbox',
    ) );

    // Show Comment Count
    $wp_customize->add_setting( 'cozyrecipes_show_comment_count', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_show_comment_count', array(
        'label'       => __( 'Show Comment Count', 'cozyrecipes' ),
        'description' => __( 'Display the comment count on single posts.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_single_post',
        'type'        => 'checkbox',
    ) );

    // ========================================
    // RECIPE CARD SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_recipe_card', array(
        'title'       => __( 'Recipe Card Options', 'cozyrecipes' ),
        'description' => __( 'Customize the recipe card display and which fields to show.', 'cozyrecipes' ),
        'priority'    => 55,
    ) );

    // Enable Recipe Card
    $wp_customize->add_setting( 'cozyrecipes_enable_recipe_card', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_enable_recipe_card', array(
        'label'       => __( 'Enable Recipe Card', 'cozyrecipes' ),
        'description' => __( 'Display recipe card with structured information.', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Recipe Title
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_title', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_title', array(
        'label'       => __( 'Show Recipe Title', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Recipe Description
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_description', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_description', array(
        'label'       => __( 'Show Recipe Description', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Prep Time
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_prep_time', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_prep_time', array(
        'label'       => __( 'Show Prep Time', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Cook Time
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_cook_time', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_cook_time', array(
        'label'       => __( 'Show Cook Time', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Total Time
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_total_time', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_total_time', array(
        'label'       => __( 'Show Total Time', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Servings
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_servings', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_servings', array(
        'label'       => __( 'Show Servings', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Ingredients
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_ingredients', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_ingredients', array(
        'label'       => __( 'Show Ingredients', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Instructions
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_instructions', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_instructions', array(
        'label'       => __( 'Show Instructions', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Notes
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_notes', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_notes', array(
        'label'       => __( 'Show Notes', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Nutrition
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_nutrition', array(
        'default'           => false,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_nutrition', array(
        'label'       => __( 'Show Nutrition Info', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Subtitle
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_subtitle', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_subtitle', array(
        'label'       => __( 'Show Recipe Subtitle', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Course
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_course', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_course', array(
        'label'       => __( 'Show Course', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Calories
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_calories', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_calories', array(
        'label'       => __( 'Show Calories', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // Show Featured Image
    $wp_customize->add_setting( 'cozyrecipes_recipe_card_show_image', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_recipe_card_show_image', array(
        'label'       => __( 'Show Featured Image', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_recipe_card',
        'type'        => 'checkbox',
    ) );

    // ========================================
    // SOCIAL MEDIA TOP BAR SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_social_media', array(
        'title'    => __( 'Social Media Top Bar', 'cozyrecipes' ),
        'priority' => 60,
    ) );

    // Enable Social Media Top Bar
    $wp_customize->add_setting( 'cozyrecipes_enable_social_bar', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_enable_social_bar', array(
        'label'    => __( 'Enable Social Media Top Bar', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'checkbox',
    ) );

    // Facebook URL
    $wp_customize->add_setting( 'cozyrecipes_facebook_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_facebook_url', array(
        'label'    => __( 'Facebook URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // Twitter URL
    $wp_customize->add_setting( 'cozyrecipes_twitter_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_twitter_url', array(
        'label'    => __( 'Twitter/X URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // Instagram URL
    $wp_customize->add_setting( 'cozyrecipes_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_instagram_url', array(
        'label'    => __( 'Instagram URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // Pinterest URL
    $wp_customize->add_setting( 'cozyrecipes_pinterest_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_pinterest_url', array(
        'label'    => __( 'Pinterest URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // YouTube URL
    $wp_customize->add_setting( 'cozyrecipes_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_youtube_url', array(
        'label'    => __( 'YouTube URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // TikTok URL
    $wp_customize->add_setting( 'cozyrecipes_tiktok_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( 'cozyrecipes_tiktok_url', array(
        'label'    => __( 'TikTok URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'type'     => 'url',
    ) );

    // Social Bar Background Color
    $wp_customize->add_setting( 'cozyrecipes_social_bar_bg_color', array(
        'default'           => '#f8f8f8',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_social_bar_bg_color', array(
        'label'    => __( 'Social Bar Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'settings' => 'cozyrecipes_social_bar_bg_color',
    ) ) );

    // Social Bar Icon Color
    $wp_customize->add_setting( 'cozyrecipes_social_bar_icon_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_social_bar_icon_color', array(
        'label'    => __( 'Social Bar Icon Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_social_media',
        'settings' => 'cozyrecipes_social_bar_icon_color',
    ) ) );

    // ========================================
    // TOP BAR MENU SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_top_bar_menu', array(
        'title'    => __( 'Top Bar Menu', 'cozyrecipes' ),
        'priority' => 65,
    ) );

    // Enable Top Bar Menu
    $wp_customize->add_setting( 'cozyrecipes_enable_top_bar_menu', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'cozyrecipes_enable_top_bar_menu', array(
        'label'    => __( 'Enable Top Bar Menu', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_top_bar_menu',
        'type'     => 'checkbox',
    ) );

    // Top Bar Text Color
    $wp_customize->add_setting( 'cozyrecipes_top_bar_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_top_bar_text_color', array(
        'label'    => __( 'Top Bar Text Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_top_bar_menu',
        'settings' => 'cozyrecipes_top_bar_text_color',
    ) ) );

    // Top Bar Background Color
    $wp_customize->add_setting( 'cozyrecipes_top_bar_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_top_bar_bg_color', array(
        'label'    => __( 'Top Bar Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_top_bar_menu',
        'settings' => 'cozyrecipes_top_bar_bg_color',
    ) ) );

    // ========================================
    // IMPORT / EXPORT SETTINGS
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_import_export', array(
        'title'       => __( 'Import / Export Settings', 'cozyrecipes' ),
        'description' => __( 'Export your theme settings to a JSON file or import settings from a previously exported file. This is useful for backing up your configuration or transferring settings between sites.', 'cozyrecipes' ),
        'priority'    => 999,
    ) );

    // Export Settings
    $wp_customize->add_setting( 'cozyrecipes_export_settings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'cozyrecipes_export_settings', array(
        'type'        => 'button',
        'section'     => 'cozyrecipes_import_export',
        'label'       => __( 'Export Settings', 'cozyrecipes' ),
        'description' => __( 'Click the button below to download your current theme settings as a JSON file.', 'cozyrecipes' ),
        'input_attrs' => array(
            'value' => __( 'Download Export File', 'cozyrecipes' ),
            'class' => 'button button-primary cozyrecipes-export-btn',
        ),
    ) );

    // Import Settings
    $wp_customize->add_setting( 'cozyrecipes_import_settings', array(
        'default'           => '',
        'sanitize_callback' => 'cozyrecipes_sanitize_import',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'cozyrecipes_import_settings', array(
        'type'        => 'textarea',
        'section'     => 'cozyrecipes_import_export',
        'label'       => __( 'Import Settings', 'cozyrecipes' ),
        'description' => __( 'Paste the exported JSON data here and click "Import Settings" to restore your theme configuration.', 'cozyrecipes' ),
        'input_attrs' => array(
            'placeholder' => __( 'Paste exported JSON data here...', 'cozyrecipes' ),
            'rows'        => 8,
            'class'       => 'cozyrecipes-import-textarea',
        ),
    ) );

    // Import Button (separate setting for the button)
    $wp_customize->add_setting( 'cozyrecipes_import_button', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'cozyrecipes_import_button', array(
        'type'        => 'button',
        'section'     => 'cozyrecipes_import_export',
        'input_attrs' => array(
            'value' => __( 'Import Settings', 'cozyrecipes' ),
            'class' => 'button button-secondary cozyrecipes-import-btn',
        ),
    ) );
}
add_action( 'customize_register', 'cozyrecipes_customize_register' );

/**
 * Sanitize import data
 */
function cozyrecipes_sanitize_import( $input ) {
    return wp_kses_post( $input );
}

/**
 * Get all theme customizer settings for export
 */
function cozyrecipes_get_theme_settings() {
    $settings = array();
    $mods     = get_theme_mods();

    if ( ! empty( $mods ) ) {
        foreach ( $mods as $key => $value ) {
            // Skip settings that shouldn't be exported
            if ( strpos( $key, 'cozyrecipes_' ) === 0 && $key !== 'cozyrecipes_import_settings' && $key !== 'cozyrecipes_export_settings' ) {
                $settings[ $key ] = $value;
            }
        }
    }

    return $settings;
}

/**
 * AJAX handler for exporting settings
 */
function cozyrecipes_ajax_export_settings() {
    // Security check
    check_ajax_referer( 'cozyrecipes-customizer-export', 'nonce' );

    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_send_json_error( array( 'message' => __( 'You do not have permission to export settings.', 'cozyrecipes' ) ) );
    }

    $settings = cozyrecipes_get_theme_settings();
    $export   = array(
        'theme'    => get_template(),
        'version'  => wp_get_theme()->get( 'Version' ),
        'date'     => current_time( 'Y-m-d H:i:s' ),
        'settings' => $settings,
    );

    wp_send_json_success( $export );
}
add_action( 'wp_ajax_cozyrecipes_export_settings', 'cozyrecipes_ajax_export_settings' );

/**
 * AJAX handler for importing settings
 */
function cozyrecipes_ajax_import_settings() {
    // Security check
    check_ajax_referer( 'cozyrecipes-customizer-import', 'nonce' );

    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_send_json_error( array( 'message' => __( 'You do not have permission to import settings.', 'cozyrecipes' ) ) );
    }

    $import_data = isset( $_POST['import_data'] ) ? wp_unslash( $_POST['import_data'] ) : '';

    if ( empty( $import_data ) ) {
        wp_send_json_error( array( 'message' => __( 'No import data provided.', 'cozyrecipes' ) ) );
    }

    // Decode JSON
    $data = json_decode( $import_data, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        wp_send_json_error( array( 'message' => __( 'Invalid JSON data. Please check your import file.', 'cozyrecipes' ) ) );
    }

    // Validate import data structure
    if ( ! isset( $data['theme'] ) || ! isset( $data['settings'] ) ) {
        wp_send_json_error( array( 'message' => __( 'Invalid import file format.', 'cozyrecipes' ) ) );
    }

    // Import settings
    $imported = 0;
    foreach ( $data['settings'] as $key => $value ) {
        if ( strpos( $key, 'cozyrecipes_' ) === 0 ) {
            set_theme_mod( $key, $value );
            $imported++;
        }
    }

    wp_send_json_success( array(
        'message'  => sprintf( __( 'Successfully imported %d settings. Please refresh the page to see changes.', 'cozyrecipes' ), $imported ),
        'imported' => $imported,
    ) );
}
add_action( 'wp_ajax_cozyrecipes_import_settings', 'cozyrecipes_ajax_import_settings' );

/**
 * Enqueue customizer import/export scripts
 */
function cozyrecipes_customizer_scripts() {
    wp_enqueue_script(
        'cozyrecipes-customizer-import-export',
        get_template_directory_uri() . '/js/customizer-import-export.js',
        array( 'jquery', 'customize-controls' ),
        '1.0.0',
        true
    );

    wp_localize_script(
        'cozyrecipes-customizer-import-export',
        'cozyrecipesCustomizer',
        array(
            'exportNonce' => wp_create_nonce( 'cozyrecipes-customizer-export' ),
            'importNonce' => wp_create_nonce( 'cozyrecipes-customizer-import' ),
            'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
            'strings'     => array(
                'exporting'      => __( 'Exporting...', 'cozyrecipes' ),
                'importing'      => __( 'Importing...', 'cozyrecipes' ),
                'exportError'    => __( 'Export failed. Please try again.', 'cozyrecipes' ),
                'importError'    => __( 'Import failed. Please check your data and try again.', 'cozyrecipes' ),
                'importEmpty'    => __( 'Please paste the import data before clicking Import.', 'cozyrecipes' ),
                'importSuccess'  => __( 'Settings imported successfully! Refreshing...', 'cozyrecipes' ),
                'confirmImport'  => __( 'This will overwrite your current settings. Are you sure you want to continue?', 'cozyrecipes' ),
            ),
        )
    );
}
add_action( 'customize_controls_enqueue_scripts', 'cozyrecipes_customizer_scripts' );

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
    // Get all color theme mods
    $accent_color = get_theme_mod( 'cozyrecipes_accent_color', '#ff6b6b' );
    $accent_hover = get_theme_mod( 'cozyrecipes_accent_color_hover', '#ff5252' );
    $body_bg = get_theme_mod( 'cozyrecipes_body_bg_color', '#f8f8f8' );
    $body_text = get_theme_mod( 'cozyrecipes_body_text_color', '#333333' );
    $heading_color = get_theme_mod( 'cozyrecipes_heading_color', '#222222' );

    $topbar_bg = get_theme_mod( 'cozyrecipes_topbar_bg_color', '#ffffff' );
    $topbar_text = get_theme_mod( 'cozyrecipes_topbar_text_color', '#333333' );
    $topbar_border = get_theme_mod( 'cozyrecipes_topbar_border_color', '#f0f0f0' );

    $header_bg = get_theme_mod( 'cozyrecipes_header_bg_color', '#ffffff' );
    $header_text = get_theme_mod( 'cozyrecipes_header_text_color', '#333333' );
    $nav_hover = get_theme_mod( 'cozyrecipes_nav_hover_color', '#ff6b6b' );

    $hero_bg = get_theme_mod( 'cozyrecipes_hero_bg_color', '#ffffff' );
    $search_btn_bg = get_theme_mod( 'cozyrecipes_search_button_bg_color', '#ff6b6b' );
    $search_btn_text = get_theme_mod( 'cozyrecipes_search_button_text_color', '#ffffff' );

    $card_bg = get_theme_mod( 'cozyrecipes_card_bg_color', '#ffffff' );
    $category_badge = get_theme_mod( 'cozyrecipes_category_badge_color', '#ff6b6b' );
    $category_badge_text = get_theme_mod( 'cozyrecipes_category_badge_text_color', '#ffffff' );

    $button_bg = get_theme_mod( 'cozyrecipes_button_bg_color', '#ff6b6b' );
    $button_text = get_theme_mod( 'cozyrecipes_button_text_color', '#ffffff' );

    $link_color = get_theme_mod( 'cozyrecipes_link_color', '#ff6b6b' );
    $link_hover = get_theme_mod( 'cozyrecipes_link_hover_color', '#ff5252' );

    $meta_text = get_theme_mod( 'cozyrecipes_meta_text_color', '#888888' );
    $border_color = get_theme_mod( 'cozyrecipes_border_color', '#eee' );

    $footer_bg = get_theme_mod( 'cozyrecipes_footer_bg_color', '#2a2a2a' );
    $footer_text = get_theme_mod( 'cozyrecipes_footer_text_color', '#cccccc' );
    $footer_link = get_theme_mod( 'cozyrecipes_footer_link_color', '#cccccc' );
    $footer_link_hover = get_theme_mod( 'cozyrecipes_footer_link_hover_color', '#ff6b6b' );

    // Layout options
    $disable_sticky = get_theme_mod( 'cozyrecipes_disable_sticky_header', false );
    $disable_footer = get_theme_mod( 'cozyrecipes_disable_footer', false );

    ?>
    <style type="text/css">
        <?php if ( $disable_sticky ) : ?>
        /* Disable Sticky Header */
        .site-header {
            position: relative !important;
        }
        <?php endif; ?>

        <?php if ( $disable_footer ) : ?>
        /* Hide Footer */
        .site-footer {
            display: none !important;
        }
        <?php endif; ?>
        /* Body & Text Colors */
        body {
            background-color: <?php echo esc_attr( $body_bg ); ?>;
            color: <?php echo esc_attr( $body_text ); ?>;
        }

        /* Headings */
        h1, h2, h3, h4, h5, h6 {
            color: <?php echo esc_attr( $heading_color ); ?>;
        }

        /* Top Bar */
        .top-bar {
            background-color: <?php echo esc_attr( $topbar_bg ); ?>;
            border-bottom-color: <?php echo esc_attr( $topbar_border ); ?>;
        }

        .top-bar-menu a {
            color: <?php echo esc_attr( $topbar_text ); ?>;
        }

        .top-bar-menu a:hover {
            border-bottom-color: <?php echo esc_attr( $accent_color ); ?>;
        }

        /* Header & Navigation */
        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
        }

        .main-navigation a,
        .site-title a {
            color: <?php echo esc_attr( $header_text ); ?>;
        }

        .main-navigation a:hover,
        .site-title a:hover {
            color: <?php echo esc_attr( $nav_hover ); ?>;
        }

        /* Hero Section */
        .hero-section {
            background-color: <?php echo esc_attr( $hero_bg ); ?>;
        }

        /* Search Buttons */
        .hero-search-form button,
        .search-form button {
            background-color: <?php echo esc_attr( $search_btn_bg ); ?>;
            color: <?php echo esc_attr( $search_btn_text ); ?>;
        }

        .hero-search-form button:hover,
        .search-form button:hover {
            background-color: <?php echo esc_attr( $accent_hover ); ?>;
        }

        /* Cards & Widgets */
        .recipe-card,
        .widget,
        .editors-pick-card,
        .category-card,
        .about-author-card {
            background-color: <?php echo esc_attr( $card_bg ); ?>;
        }

        /* Category Badges */
        .recipe-category-badge,
        .editors-pick-badge {
            background-color: <?php echo esc_attr( $category_badge ); ?> !important;
            color: <?php echo esc_attr( $category_badge_text ); ?> !important;
        }

        /* Buttons */
        .recipe-link,
        .editors-pick-button,
        .author-button,
        .pagination a:hover,
        .pagination .current,
        .submit-comment {
            background-color: <?php echo esc_attr( $button_bg ); ?> !important;
            color: <?php echo esc_attr( $button_text ); ?> !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .recipe-link:hover,
        .editors-pick-button:hover,
        .author-button:hover,
        .submit-comment:hover {
            background-color: <?php echo esc_attr( $accent_hover ); ?> !important;
            color: <?php echo esc_attr( $button_text ); ?> !important;
        }

        /* Links */
        a {
            color: <?php echo esc_attr( $link_color ); ?>;
        }

        a:hover,
        .recipe-card-title a:hover {
            color: <?php echo esc_attr( $link_hover ); ?>;
        }

        /* Meta Text */
        .recipe-meta,
        .single-recipe-meta,
        .editors-pick-meta,
        .meta-date,
        .meta-author,
        .meta-reading-time,
        .meta-comments {
            color: <?php echo esc_attr( $meta_text ); ?>;
        }

        /* Borders */
        .widget-title,
        .widget ul li,
        .comment,
        .top-bar {
            border-color: <?php echo esc_attr( $border_color ); ?>;
        }

        /* Footer */
        .site-footer {
            background-color: <?php echo esc_attr( $footer_bg ); ?>;
            color: <?php echo esc_attr( $footer_text ); ?>;
        }

        .footer-widget-area .widget-title {
            color: <?php echo esc_attr( $footer_text ); ?>;
        }

        .footer-widget-area .widget ul li a,
        .site-info,
        .site-info a {
            color: <?php echo esc_attr( $footer_link ); ?>;
        }

        .footer-widget-area .widget ul li a:hover,
        .site-info a:hover {
            color: <?php echo esc_attr( $footer_link_hover ); ?>;
        }

        /* Post Navigation */
        .nav-arrow,
        .nav-label {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .post-navigation a:hover .nav-title,
        .nav-button:hover .nav-post-title {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .nav-button:hover {
            border-color: <?php echo esc_attr( $accent_color ); ?>;
        }

        /* Social Icons */
        .social-icon-link {
            color: <?php echo esc_attr( $topbar_text ); ?>;
        }

        /* Comment Form */
        .comment-form input[type="text"]:focus,
        .comment-form textarea:focus {
            border-color: <?php echo esc_attr( $accent_color ); ?>;
        }

        /* Header Search Toggle */
        .header-search-toggle:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
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
        array(),  // FIXED: No jQuery dependency (script uses pure vanilla JS)
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
            array(),  // FIXED: No jQuery dependency (script uses Intersection Observer API)
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
 * CRITICAL: Never defer/async jQuery or jQuery Migrate
 */
function cozyrecipes_async_scripts( $tag, $handle ) {
    // MUST NOT DEFER: jQuery core and jQuery Migrate
    // These must load synchronously before any dependent scripts
    if ( in_array( $handle, array( 'jquery', 'jquery-migrate', 'jquery-core' ) ) ) {
        return $tag;  // Leave unchanged - load in HEAD synchronously
    }

    // Don't async critical theme scripts
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
 * FIXED: Properly schedule cleanup with WP-Cron
 */
function cozyrecipes_cleanup_transients() {
    global $wpdb;

    // Delete transients older than their TTL
    // This prevents database bloat from expired transients
    $wpdb->query(
        "DELETE FROM {$wpdb->options}
         WHERE option_name LIKE '_transient_timeout_cozyrecipes_%'
         AND option_value < " . time()
    );

    // Also clean up the actual transient values
    $wpdb->query(
        "DELETE FROM {$wpdb->options}
         WHERE option_name LIKE '_transient_cozyrecipes_%'
         AND option_name NOT LIKE '_transient_timeout%'"
    );
}

// Schedule the cleanup event if not already scheduled
if ( ! wp_next_scheduled( 'cozyrecipes_daily_cleanup' ) ) {
    wp_schedule_event( time(), 'daily', 'cozyrecipes_daily_cleanup' );
}

add_action( 'cozyrecipes_daily_cleanup', 'cozyrecipes_cleanup_transients' );

// Cleanup on theme deactivation
register_deactivation_hook( __FILE__, function() {
    wp_clear_scheduled_hook( 'cozyrecipes_daily_cleanup' );
} );

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

/* ========================================
   RECIPE CARD MODULE
======================================== */

/**
 * Recipe Card Shortcode
 *
 * Usage: [recipe title="Chocolate Cake" prep_time="15 mins" cook_time="30 mins" servings="8"
 *         description="A delicious chocolate cake"
 *         ingredients="2 cups flour|1 cup sugar|3 eggs|1 cup milk"
 *         instructions="Mix ingredients|Bake at 350F|Cool and serve"
 *         notes="Best served warm"
 *         nutrition="Calories: 250|Fat: 10g|Carbs: 35g"]
 */
function cozyrecipes_recipe_card_shortcode( $atts ) {
    // Check if recipe card is enabled
    if ( ! get_theme_mod( 'cozyrecipes_enable_recipe_card', true ) ) {
        return '';
    }

    // Parse shortcode attributes
    $atts = shortcode_atts( array(
        'title'        => '',
        'description'  => '',
        'prep_time'    => '',
        'cook_time'    => '',
        'total_time'   => '',
        'servings'     => '',
        'ingredients'  => '',
        'instructions' => '',
        'notes'        => '',
        'nutrition'    => '',
    ), $atts, 'recipe' );

    // Get customizer settings
    $show_title        = get_theme_mod( 'cozyrecipes_recipe_card_show_title', true );
    $show_description  = get_theme_mod( 'cozyrecipes_recipe_card_show_description', true );
    $show_prep_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_prep_time', true );
    $show_cook_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_cook_time', true );
    $show_total_time   = get_theme_mod( 'cozyrecipes_recipe_card_show_total_time', true );
    $show_servings     = get_theme_mod( 'cozyrecipes_recipe_card_show_servings', true );
    $show_ingredients  = get_theme_mod( 'cozyrecipes_recipe_card_show_ingredients', true );
    $show_instructions = get_theme_mod( 'cozyrecipes_recipe_card_show_instructions', true );
    $show_notes        = get_theme_mod( 'cozyrecipes_recipe_card_show_notes', true );
    $show_nutrition    = get_theme_mod( 'cozyrecipes_recipe_card_show_nutrition', false );

    // Start output buffering
    ob_start();
    ?>

    <div class="recipe-card-container">
        <?php if ( $show_title && ! empty( $atts['title'] ) ) : ?>
        <h2 class="recipe-card-title"><?php echo esc_html( $atts['title'] ); ?></h2>
        <?php endif; ?>

        <?php if ( $show_description && ! empty( $atts['description'] ) ) : ?>
        <p class="recipe-card-description"><?php echo esc_html( $atts['description'] ); ?></p>
        <?php endif; ?>

        <?php
        // Check if any time/servings fields are enabled and have data
        $has_meta = ( $show_prep_time && ! empty( $atts['prep_time'] ) ) ||
                    ( $show_cook_time && ! empty( $atts['cook_time'] ) ) ||
                    ( $show_total_time && ! empty( $atts['total_time'] ) ) ||
                    ( $show_servings && ! empty( $atts['servings'] ) );

        if ( $has_meta ) :
        ?>
        <div class="recipe-card-meta">
            <?php if ( $show_prep_time && ! empty( $atts['prep_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Prep:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $atts['prep_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_cook_time && ! empty( $atts['cook_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6.13 1L6 16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V1"></path>
                    <path d="M3 5h18"></path>
                    <path d="M13 5v6"></path>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Cook:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $atts['cook_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_total_time && ! empty( $atts['total_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Total:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $atts['total_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_servings && ! empty( $atts['servings'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Servings:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $atts['servings'] ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ( $show_ingredients && ! empty( $atts['ingredients'] ) ) : ?>
        <div class="recipe-card-section">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Ingredients', 'cozyrecipes' ); ?></h3>
            <ul class="recipe-card-ingredients">
                <?php
                $ingredients = explode( '|', $atts['ingredients'] );
                foreach ( $ingredients as $ingredient ) {
                    if ( ! empty( trim( $ingredient ) ) ) {
                        echo '<li>' . esc_html( trim( $ingredient ) ) . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ( $show_instructions && ! empty( $atts['instructions'] ) ) : ?>
        <div class="recipe-card-section">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Instructions', 'cozyrecipes' ); ?></h3>
            <ol class="recipe-card-instructions">
                <?php
                $instructions = explode( '|', $atts['instructions'] );
                foreach ( $instructions as $instruction ) {
                    if ( ! empty( trim( $instruction ) ) ) {
                        echo '<li>' . esc_html( trim( $instruction ) ) . '</li>';
                    }
                }
                ?>
            </ol>
        </div>
        <?php endif; ?>

        <?php if ( $show_notes && ! empty( $atts['notes'] ) ) : ?>
        <div class="recipe-card-section recipe-card-notes">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Notes', 'cozyrecipes' ); ?></h3>
            <p><?php echo esc_html( $atts['notes'] ); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( $show_nutrition && ! empty( $atts['nutrition'] ) ) : ?>
        <div class="recipe-card-section recipe-card-nutrition">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Nutrition Information', 'cozyrecipes' ); ?></h3>
            <ul class="recipe-card-nutrition-list">
                <?php
                $nutrition_items = explode( '|', $atts['nutrition'] );
                foreach ( $nutrition_items as $nutrition ) {
                    if ( ! empty( trim( $nutrition ) ) ) {
                        echo '<li>' . esc_html( trim( $nutrition ) ) . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'recipe', 'cozyrecipes_recipe_card_shortcode' );

/**
 * Auto-detect and extract recipe data from post content
 */
function cozyrecipes_extract_recipe_data( $content ) {
    $recipe_data = array(
        'title'        => '',
        'description'  => '',
        'prep_time'    => '',
        'cook_time'    => '',
        'total_time'   => '',
        'servings'     => '',
        'ingredients'  => array(),
        'instructions' => array(),
        'notes'        => '',
        'nutrition'    => array(),
    );

    // Parse HTML content
    $dom = new DOMDocument();
    @$dom->loadHTML( '<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
    $xpath = new DOMXPath( $dom );

    // Extract recipe title (look for h2 or h3 with "recipe" in text)
    $title_nodes = $xpath->query( "//h2 | //h3" );
    foreach ( $title_nodes as $node ) {
        $text = strtolower( $node->textContent );
        if ( strpos( $text, 'recipe' ) !== false && empty( $recipe_data['title'] ) ) {
            $recipe_data['title'] = trim( $node->textContent );
            break;
        }
    }

    // Extract prep time, cook time, servings from text
    if ( preg_match( '/prep(?:\s+time)?:?\s*(\d+\s*(?:min|mins|minutes|hour|hours|hr|hrs))/i', $content, $matches ) ) {
        $recipe_data['prep_time'] = $matches[1];
    }
    if ( preg_match( '/cook(?:\s+time)?:?\s*(\d+\s*(?:min|mins|minutes|hour|hours|hr|hrs))/i', $content, $matches ) ) {
        $recipe_data['cook_time'] = $matches[1];
    }
    if ( preg_match( '/total(?:\s+time)?:?\s*(\d+\s*(?:min|mins|minutes|hour|hours|hr|hrs))/i', $content, $matches ) ) {
        $recipe_data['total_time'] = $matches[1];
    }
    if ( preg_match( '/(?:servings?|yields?|serves):?\s*(\d+(?:\s+(?:servings?|people|portions?))?)/i', $content, $matches ) ) {
        $recipe_data['servings'] = $matches[1];
    }

    // Extract ingredients - look for heading with "ingredient" followed by a list
    $headings = $xpath->query( "//h2 | //h3 | //h4" );
    foreach ( $headings as $heading ) {
        $heading_text = strtolower( trim( $heading->textContent ) );

        // Check for ingredients
        if ( strpos( $heading_text, 'ingredient' ) !== false ) {
            $next = $heading->nextSibling;
            while ( $next ) {
                if ( $next->nodeName === 'ul' || $next->nodeName === 'ol' ) {
                    $list_items = $xpath->query( ".//li", $next );
                    foreach ( $list_items as $item ) {
                        $ingredient = trim( $item->textContent );
                        if ( ! empty( $ingredient ) ) {
                            $recipe_data['ingredients'][] = $ingredient;
                        }
                    }
                    break;
                } elseif ( $next->nodeName === 'h2' || $next->nodeName === 'h3' || $next->nodeName === 'h4' ) {
                    break;
                }
                $next = $next->nextSibling;
            }
        }

        // Check for instructions
        if ( strpos( $heading_text, 'instruction' ) !== false || strpos( $heading_text, 'direction' ) !== false || strpos( $heading_text, 'method' ) !== false ) {
            $next = $heading->nextSibling;
            while ( $next ) {
                if ( $next->nodeName === 'ol' || $next->nodeName === 'ul' ) {
                    $list_items = $xpath->query( ".//li", $next );
                    foreach ( $list_items as $item ) {
                        $instruction = trim( $item->textContent );
                        if ( ! empty( $instruction ) ) {
                            $recipe_data['instructions'][] = $instruction;
                        }
                    }
                    break;
                } elseif ( $next->nodeName === 'h2' || $next->nodeName === 'h3' || $next->nodeName === 'h4' ) {
                    break;
                }
                $next = $next->nextSibling;
            }
        }

        // Check for notes
        if ( strpos( $heading_text, 'note' ) !== false || strpos( $heading_text, 'tip' ) !== false ) {
            $next = $heading->nextSibling;
            while ( $next ) {
                if ( $next->nodeName === 'p' ) {
                    $recipe_data['notes'] .= trim( $next->textContent ) . ' ';
                } elseif ( $next->nodeName === 'h2' || $next->nodeName === 'h3' || $next->nodeName === 'h4' ) {
                    break;
                }
                $next = $next->nextSibling;
            }
            $recipe_data['notes'] = trim( $recipe_data['notes'] );
        }

        // Check for nutrition
        if ( strpos( $heading_text, 'nutrition' ) !== false ) {
            $next = $heading->nextSibling;
            while ( $next ) {
                if ( $next->nodeName === 'ul' || $next->nodeName === 'ol' ) {
                    $list_items = $xpath->query( ".//li", $next );
                    foreach ( $list_items as $item ) {
                        $nutrition = trim( $item->textContent );
                        if ( ! empty( $nutrition ) ) {
                            $recipe_data['nutrition'][] = $nutrition;
                        }
                    }
                    break;
                } elseif ( $next->nodeName === 'p' ) {
                    $recipe_data['nutrition'][] = trim( $next->textContent );
                } elseif ( $next->nodeName === 'h2' || $next->nodeName === 'h3' || $next->nodeName === 'h4' ) {
                    break;
                }
                $next = $next->nextSibling;
            }
        }
    }

    return $recipe_data;
}

/**
 * Render auto-detected recipe card
 */
function cozyrecipes_render_auto_recipe_card() {
    // Check if recipe card is enabled
    if ( ! get_theme_mod( 'cozyrecipes_enable_recipe_card', true ) ) {
        return '';
    }

    if ( ! is_singular( 'post' ) ) {
        return '';
    }

    // Get post content
    global $post;
    $content = apply_filters( 'the_content', get_post_field( 'post_content', $post->ID ) );

    // Extract recipe data
    $recipe_data = cozyrecipes_extract_recipe_data( $content );

    // Check if we found any recipe data
    $has_recipe_data = ! empty( $recipe_data['ingredients'] ) || ! empty( $recipe_data['instructions'] );

    if ( ! $has_recipe_data ) {
        return '';
    }

    // Get customizer settings
    $show_title        = get_theme_mod( 'cozyrecipes_recipe_card_show_title', true );
    $show_description  = get_theme_mod( 'cozyrecipes_recipe_card_show_description', true );
    $show_prep_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_prep_time', true );
    $show_cook_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_cook_time', true );
    $show_total_time   = get_theme_mod( 'cozyrecipes_recipe_card_show_total_time', true );
    $show_servings     = get_theme_mod( 'cozyrecipes_recipe_card_show_servings', true );
    $show_ingredients  = get_theme_mod( 'cozyrecipes_recipe_card_show_ingredients', true );
    $show_instructions = get_theme_mod( 'cozyrecipes_recipe_card_show_instructions', true );
    $show_notes        = get_theme_mod( 'cozyrecipes_recipe_card_show_notes', true );
    $show_nutrition    = get_theme_mod( 'cozyrecipes_recipe_card_show_nutrition', false );

    // Start output buffering
    ob_start();
    ?>

    <div id="recipe-card" class="recipe-card-container auto-recipe-card">
        <div class="recipe-card-header">
            <?php if ( $show_title && ! empty( $recipe_data['title'] ) ) : ?>
            <h2 class="recipe-card-title"><?php echo esc_html( $recipe_data['title'] ); ?></h2>
            <?php elseif ( $show_title ) : ?>
            <h2 class="recipe-card-title"><?php the_title(); ?></h2>
            <?php endif; ?>

            <button class="print-recipe-btn" onclick="window.print();" aria-label="<?php esc_attr_e( 'Print Recipe', 'cozyrecipes' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span><?php esc_html_e( 'Print Recipe', 'cozyrecipes' ); ?></span>
            </button>
        </div>

        <?php if ( $show_description && has_excerpt() ) : ?>
        <p class="recipe-card-description"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>

        <?php
        // Check if any time/servings fields are enabled and have data
        $has_meta = ( $show_prep_time && ! empty( $recipe_data['prep_time'] ) ) ||
                    ( $show_cook_time && ! empty( $recipe_data['cook_time'] ) ) ||
                    ( $show_total_time && ! empty( $recipe_data['total_time'] ) ) ||
                    ( $show_servings && ! empty( $recipe_data['servings'] ) );

        if ( $has_meta ) :
        ?>
        <div class="recipe-card-meta">
            <?php if ( $show_prep_time && ! empty( $recipe_data['prep_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Prep:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $recipe_data['prep_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_cook_time && ! empty( $recipe_data['cook_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6.13 1L6 16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V1"></path>
                    <path d="M3 5h18"></path>
                    <path d="M13 5v6"></path>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Cook:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $recipe_data['cook_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_total_time && ! empty( $recipe_data['total_time'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Total:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $recipe_data['total_time'] ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( $show_servings && ! empty( $recipe_data['servings'] ) ) : ?>
            <div class="recipe-card-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="meta-label"><?php esc_html_e( 'Servings:', 'cozyrecipes' ); ?></span>
                <span class="meta-value"><?php echo esc_html( $recipe_data['servings'] ); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ( $show_ingredients && ! empty( $recipe_data['ingredients'] ) ) : ?>
        <div class="recipe-card-section">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Ingredients', 'cozyrecipes' ); ?></h3>
            <ul class="recipe-card-ingredients">
                <?php foreach ( $recipe_data['ingredients'] as $ingredient ) : ?>
                    <li><?php echo esc_html( $ingredient ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ( $show_instructions && ! empty( $recipe_data['instructions'] ) ) : ?>
        <div class="recipe-card-section">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Instructions', 'cozyrecipes' ); ?></h3>
            <ol class="recipe-card-instructions">
                <?php foreach ( $recipe_data['instructions'] as $instruction ) : ?>
                    <li><?php echo esc_html( $instruction ); ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif; ?>

        <?php if ( $show_notes && ! empty( $recipe_data['notes'] ) ) : ?>
        <div class="recipe-card-section recipe-card-notes">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Notes', 'cozyrecipes' ); ?></h3>
            <p><?php echo esc_html( $recipe_data['notes'] ); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( $show_nutrition && ! empty( $recipe_data['nutrition'] ) ) : ?>
        <div class="recipe-card-section recipe-card-nutrition">
            <h3 class="recipe-card-section-title"><?php esc_html_e( 'Nutrition Information', 'cozyrecipes' ); ?></h3>
            <ul class="recipe-card-nutrition-list">
                <?php foreach ( $recipe_data['nutrition'] as $nutrition ) : ?>
                    <li><?php echo esc_html( $nutrition ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <?php
    return ob_get_clean();
}

/* ========================================
   SEO OPTIMIZATION MODULE
======================================== */

/**
 * Add JSON-LD Structured Data for Recipes on Single Posts
 */
function cozyrecipes_add_recipe_schema() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    global $post;
    $post_id = get_the_ID();
    
    // Get featured image
    $image_id = get_post_thumbnail_id( $post_id );
    $image_url = wp_get_attachment_image_src( $image_id, 'full' );
    $image_url = $image_url ? $image_url[0] : '';

    // Build Recipe Schema
    $schema = array(
        '@context' => 'https://schema.org/',
        '@type' => 'Recipe',
        'name' => get_the_title(),
        'description' => wp_trim_words( get_the_excerpt(), 20 ),
        'author' => array(
            '@type' => 'Person',
            'name' => get_the_author_meta( 'display_name', $post->post_author ),
        ),
        'image' => $image_url ? array(
            '@type' => 'ImageObject',
            'url' => $image_url,
            'width' => 1200,
            'height' => 800,
        ) : null,
        'datePublished' => mysql2date( 'c', $post->post_date ),
        'dateModified' => mysql2date( 'c', $post->post_modified ),
        'prepTime' => 'PT15M',
        'cookTime' => 'PT30M',
        'totalTime' => 'PT45M',
        'recipeYield' => '4 servings',
        'recipeCategory' => 'Breakfast, Lunch, Dinner',
        'recipeCuisine' => 'American',
        'keywords' => implode( ', ', array_map( function( $term ) { return $term->name; }, wp_get_post_terms( $post_id, 'category' ) ) ),
        'url' => get_permalink(),
    );

    // Remove null image if no featured image
    if ( ! $image_url ) {
        unset( $schema['image'] );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'cozyrecipes_add_recipe_schema', 15 );

/**
 * Add Breadcrumb Schema JSON-LD
 */
function cozyrecipes_add_breadcrumb_schema() {
    // Only on archives and single posts
    if ( ! is_singular() && ! is_archive() && ! is_home() ) {
        return;
    }

    $breadcrumbs = array(
        array(
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => home_url(),
        ),
    );

    if ( is_singular() ) {
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $breadcrumbs[] = array(
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $categories[0]->name,
                'item' => get_category_link( $categories[0]->term_id ),
            );
        }

        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => count( $breadcrumbs ) + 1,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif ( is_category() ) {
        $breadcrumbs[] = array(
            '@type' => 'ListItem',
            'position' => 2,
            'name' => single_cat_title( '', false ),
            'item' => get_category_link( get_query_var( 'cat' ) ),
        );
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs,
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'cozyrecipes_add_breadcrumb_schema', 15 );

/**
 * Add Open Graph Meta Tags for Social Sharing
 */
function cozyrecipes_add_open_graph_tags() {
    $title = wp_get_document_title();
    $description = wp_trim_words( get_the_excerpt(), 20 );
    $url = get_the_permalink();
    $image = '';

    if ( is_singular() ) {
        $image_id = get_post_thumbnail_id();
        if ( $image_id ) {
            $image_array = wp_get_attachment_image_src( $image_id, 'large' );
            $image = $image_array[0];
        }
    }

    // Fallback image if no featured image
    if ( ! $image ) {
        $image = get_template_directory_uri() . '/assets/images/default-og-image.jpg';
    }

    echo '<meta property="og:type" content="' . ( is_singular( 'post' ) ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'cozyrecipes_add_open_graph_tags', 10 );

/**
 * Add Twitter Card Meta Tags
 */
function cozyrecipes_add_twitter_card_tags() {
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( wp_trim_words( get_the_excerpt(), 20 ) ) . '">' . "\n";

    if ( is_singular() && has_post_thumbnail() ) {
        $image_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
        echo '<meta name="twitter:image" content="' . esc_url( $image_array[0] ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'cozyrecipes_add_twitter_card_tags', 10 );

/**
 * Add Canonical URL
 */
function cozyrecipes_add_canonical_url() {
    if ( ! is_singular() && ! is_archive() ) {
        return;
    }

    $url = '';
    if ( is_singular() ) {
        $url = get_permalink();
    } elseif ( is_home() ) {
        $url = home_url();
    } elseif ( is_category() ) {
        $url = get_category_link( get_query_var( 'cat' ) );
    } elseif ( is_tag() ) {
        $url = get_tag_link( get_query_var( 'tag_id' ) );
    }

    if ( $url ) {
        echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'cozyrecipes_add_canonical_url', 10 );

/**
 * Add SEO Meta Tags
 */
function cozyrecipes_add_seo_meta_tags() {
    if ( is_singular( 'post' ) ) {
        // Meta description
        $description = wp_trim_words( get_the_excerpt(), 20 );
        echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";

        // Keywords from categories
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            $keywords = implode( ', ', array_map( function( $cat ) { return $cat->name; }, $categories ) );
            echo '<meta name="keywords" content="' . esc_attr( $keywords ) . '">' . "\n";
        }

        // Article specific meta
        echo '<meta property="article:published_time" content="' . esc_attr( mysql2date( 'c', get_the_time( 'Y-m-d H:i:s' ) ) ) . '">' . "\n";
        echo '<meta property="article:modified_time" content="' . esc_attr( mysql2date( 'c', get_the_modified_time( 'Y-m-d H:i:s' ) ) ) . '">' . "\n";
        echo '<meta property="article:author" content="' . esc_attr( get_the_author_meta( 'display_name' ) ) . '">' . "\n";

        // Author URL
        $author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
        echo '<link rel="author" href="' . esc_url( $author_url ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'cozyrecipes_add_seo_meta_tags', 10 );

/**
 * Optimize Image Alt Text - Ensure all images have proper alt attributes
 */
function cozyrecipes_filter_post_content_images( $content ) {
    // Add alt text to images missing it
    $content = preg_replace_callback(
        '/<img[^>]*src=["\']([^"\']*)["\'][^>]*>/i',
        function( $matches ) {
            $img_tag = $matches[0];
            
            // Check if alt already exists
            if ( strpos( $img_tag, 'alt=' ) !== false ) {
                return $img_tag;
            }

            // Extract filename as fallback alt text
            $filename = basename( $matches[1] );
            $alt_text = sanitize_text_field( str_replace( array( '-', '_' ), ' ', pathinfo( $filename, PATHINFO_FILENAME ) ) );

            // Insert alt attribute
            return str_replace( '<img', '<img alt="' . esc_attr( $alt_text ) . '"', $img_tag );
        },
        $content
    );

    return $content;
}
add_filter( 'the_content', 'cozyrecipes_filter_post_content_images', 10 );

/**
 * Add Schema.org Organization Information
 */
function cozyrecipes_add_organization_schema() {
    if ( ! is_front_page() && ! is_home() ) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo( 'name' ),
        'description' => get_bloginfo( 'description' ),
        'url' => home_url(),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'contact' => array(
            '@type' => 'ContactPoint',
            'telephone' => '', // Add your phone if available
            'contactType' => 'Customer Service',
        ),
        'sameAs' => array(
            // Add your social media URLs
            'https://www.facebook.com/',
            'https://www.twitter.com/',
            'https://www.instagram.com/',
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'cozyrecipes_add_organization_schema', 15 );

/**
 * Remove Unnecessary Meta Tags for Lighter HTML
 */
function cozyrecipes_remove_unnecessary_meta_tags() {
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
}
add_action( 'init', 'cozyrecipes_remove_unnecessary_meta_tags' );

/**
 * Disable REST API for unauthenticated users (optional security)
 */
function cozyrecipes_disable_rest_for_unauthenticated() {
    if ( ! is_user_logged_in() ) {
        add_filter( 'rest_authentication_errors', function( $result ) {
            if ( ! empty( $result ) ) {
                return $result;
            }
            return new WP_Error( 'rest_disabled', 'REST API is disabled for unauthenticated requests', array( 'status' => 403 ) );
        });
    }
}
// add_action( 'rest_api_init', 'cozyrecipes_disable_rest_for_unauthenticated' ); // Uncomment if needed

/**
 * Add robots.txt optimization hints in header
 */
function cozyrecipes_add_robots_meta() {
    if ( is_front_page() || is_archive() || is_singular() ) {
        echo '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">' . "\n";
    }
}
add_action( 'wp_head', 'cozyrecipes_add_robots_meta', 10 );

/* ========================================
   END SEO OPTIMIZATION MODULE
======================================== */

/* ========================================
   RECIPE PRINT CARD MODULE (mytheme_)
   Clean, minimal, printer-friendly recipe cards
======================================== */

/**
 * Register custom recipe meta fields
 */
function mytheme_register_recipe_meta() {
	$meta_fields = array(
		'recipe_title',
		'recipe_subtitle',
		'recipe_image_url',
		'recipe_ingredients',
		'recipe_instructions',
		'recipe_prep_time',
		'recipe_cook_time',
		'recipe_total_time',
		'recipe_servings',
		'recipe_calories',
		'recipe_course',
		'recipe_notes',
	);

	foreach ( $meta_fields as $field ) {
		register_post_meta(
			'post',
			$field,
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			)
		);
	}
}
add_action( 'init', 'mytheme_register_recipe_meta' );

/**
 * Auto-detect recipe data from post content - OPTIMIZED
 *
 * @param string $content The post content HTML.
 * @return array Recipe data array.
 */
function mytheme_auto_detect_recipe_data( $content ) {
	$recipe_data = array(
		'ingredients'  => array(),
		'instructions' => array(),
		'prep_time'    => '',
		'cook_time'    => '',
		'total_time'   => '',
		'servings'     => '',
		'calories'     => '',
		'course'       => '',
		'notes'        => '',
	);

	if ( empty( $content ) ) {
		return $recipe_data;
	}

	// Strip HTML tags for text extraction
	$plain_text = strip_tags( $content );

	// Extract times, servings, calories, course (simple one-pass regex)
	if ( preg_match( '/prep(?:aration)?\s*(?:time)?[:\s]*(\d+(?:-\d+)?)\s*(min|hour|hr)/i', $plain_text, $m ) ) {
		$recipe_data['prep_time'] = $m[1] . ' ' . $m[2];
	}

	if ( preg_match( '/cook(?:ing)?\s*(?:time)?[:\s]*(\d+(?:-\d+)?)\s*(min|hour|hr)/i', $plain_text, $m ) ) {
		$recipe_data['cook_time'] = $m[1] . ' ' . $m[2];
	}

	if ( preg_match( '/total\s*(?:time)?[:\s]*(\d+(?:-\d+)?)\s*(min|hour|hr)/i', $plain_text, $m ) ) {
		$recipe_data['total_time'] = $m[1] . ' ' . $m[2];
	}

	if ( preg_match( '/(?:servings?|serves?|yields?|makes?)[:\s]*(\d+(?:-\d+)?)/i', $plain_text, $m ) ) {
		$recipe_data['servings'] = $m[1];
	}

	if ( preg_match( '/(?:calories?|kcal)[:\s]*(\d+)/i', $plain_text, $m ) ) {
		$recipe_data['calories'] = $m[1] . ' kcal';
	}

	if ( preg_match( '/(?:course|meal\s+type)[:\s]*(breakfast|lunch|dinner|dessert|snack|appetizer|main)/i', $plain_text, $m ) ) {
		$recipe_data['course'] = ucwords( $m[1] );
	}

	// Parse HTML for structured content (ingredients, instructions, notes)
	$dom = new DOMDocument();
	@$dom->loadHTML( '<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
	$xpath = new DOMXPath( $dom );

	// Get all headings
	$headings = $xpath->query( '//h2 | //h3 | //h4 | //strong' );

	foreach ( $headings as $heading ) {
		$text = strtolower( trim( $heading->textContent ) );
		$next = $heading->nextSibling;

		// Ingredients
		if ( preg_match( '/ingredient/i', $text ) && empty( $recipe_data['ingredients'] ) ) {
			$count = 0;
			while ( $next && $count < 30 ) {
				if ( $next->nodeName === 'ul' || $next->nodeName === 'ol' ) {
					$items = $xpath->query( './/li', $next );
					foreach ( $items as $item ) {
						$val = trim( $item->textContent );
						if ( strlen( $val ) > 2 ) {
							$recipe_data['ingredients'][] = $val;
						}
					}
				} elseif ( in_array( $next->nodeName, array( 'h1', 'h2', 'h3', 'h4', 'h5' ) ) ) {
					break;
				}
				$next = $next->nextSibling;
				$count++;
			}
		}

		// Instructions
		if ( preg_match( '/instruction|direction|step|method/i', $text ) && empty( $recipe_data['instructions'] ) ) {
			$count = 0;
			while ( $next && $count < 30 ) {
				if ( $next->nodeName === 'ol' || $next->nodeName === 'ul' ) {
					$items = $xpath->query( './/li', $next );
					foreach ( $items as $item ) {
						$val = trim( $item->textContent );
						if ( strlen( $val ) > 5 ) {
							$recipe_data['instructions'][] = $val;
						}
					}
				} elseif ( in_array( $next->nodeName, array( 'h1', 'h2', 'h3', 'h4', 'h5' ) ) ) {
					break;
				}
				$next = $next->nextSibling;
				$count++;
			}
		}

		// Notes
		if ( preg_match( '/note|tip/i', $text ) && empty( $recipe_data['notes'] ) ) {
			$count = 0;
			while ( $next && $count < 10 ) {
				if ( $next->nodeName === 'p' ) {
					$recipe_data['notes'] .= trim( $next->textContent ) . ' ';
				} elseif ( in_array( $next->nodeName, array( 'h1', 'h2', 'h3', 'h4', 'h5' ) ) ) {
					break;
				}
				$next = $next->nextSibling;
				$count++;
			}
			$recipe_data['notes'] = trim( $recipe_data['notes'] );
		}
	}

	return $recipe_data;
}

/**
 * Get recipe data - custom meta fields first, fallback to auto-detect
 *
 * @param int $post_id Post ID.
 * @return array Complete recipe data.
 */
function mytheme_get_recipe_data( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// Get custom meta fields
	$meta_title = get_post_meta( $post_id, 'recipe_title', true );
	$meta_image = get_post_meta( $post_id, 'recipe_image_url', true );

	$data = array(
		'title'        => ! empty( $meta_title ) ? $meta_title : get_the_title( $post_id ),
		'subtitle'     => get_post_meta( $post_id, 'recipe_subtitle', true ),
		'image_url'    => ! empty( $meta_image ) ? $meta_image : get_the_post_thumbnail_url( $post_id, 'full' ),
		'ingredients'  => get_post_meta( $post_id, 'recipe_ingredients', true ),
		'instructions' => get_post_meta( $post_id, 'recipe_instructions', true ),
		'prep_time'    => get_post_meta( $post_id, 'recipe_prep_time', true ),
		'cook_time'    => get_post_meta( $post_id, 'recipe_cook_time', true ),
		'total_time'   => get_post_meta( $post_id, 'recipe_total_time', true ),
		'servings'     => get_post_meta( $post_id, 'recipe_servings', true ),
		'calories'     => get_post_meta( $post_id, 'recipe_calories', true ),
		'course'       => get_post_meta( $post_id, 'recipe_course', true ),
		'notes'        => get_post_meta( $post_id, 'recipe_notes', true ),
		'nutrition'    => array(),
	);

	// Convert meta ingredients/instructions/nutrition from text to array if needed
	if ( ! empty( $data['ingredients'] ) && is_string( $data['ingredients'] ) ) {
		$data['ingredients'] = array_filter( array_map( 'trim', explode( "\n", $data['ingredients'] ) ) );
	}
	if ( ! empty( $data['instructions'] ) && is_string( $data['instructions'] ) ) {
		$data['instructions'] = array_filter( array_map( 'trim', explode( "\n", $data['instructions'] ) ) );
	}

	// Fallback to auto-detection if critical fields are empty
	$need_auto_detect = empty( $data['ingredients'] ) || empty( $data['instructions'] );

	if ( $need_auto_detect ) {
		$content   = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
		$auto_data = mytheme_auto_detect_recipe_data( $content );

		// Merge auto-detected data (only if custom field is empty)
		if ( empty( $data['ingredients'] ) && ! empty( $auto_data['ingredients'] ) ) {
			$data['ingredients'] = $auto_data['ingredients'];
		}
		if ( empty( $data['instructions'] ) && ! empty( $auto_data['instructions'] ) ) {
			$data['instructions'] = $auto_data['instructions'];
		}
		if ( empty( $data['prep_time'] ) && ! empty( $auto_data['prep_time'] ) ) {
			$data['prep_time'] = $auto_data['prep_time'];
		}
		if ( empty( $data['cook_time'] ) && ! empty( $auto_data['cook_time'] ) ) {
			$data['cook_time'] = $auto_data['cook_time'];
		}
		if ( empty( $data['total_time'] ) && ! empty( $auto_data['total_time'] ) ) {
			$data['total_time'] = $auto_data['total_time'];
		}
		if ( empty( $data['servings'] ) && ! empty( $auto_data['servings'] ) ) {
			$data['servings'] = $auto_data['servings'];
		}
		if ( empty( $data['calories'] ) && ! empty( $auto_data['calories'] ) ) {
			$data['calories'] = $auto_data['calories'];
		}
		if ( empty( $data['course'] ) && ! empty( $auto_data['course'] ) ) {
			$data['course'] = $auto_data['course'];
		}
		if ( empty( $data['notes'] ) && ! empty( $auto_data['notes'] ) ) {
			$data['notes'] = $auto_data['notes'];
		}
		if ( empty( $data['nutrition'] ) && ! empty( $auto_data['nutrition'] ) ) {
			$data['nutrition'] = $auto_data['nutrition'];
		}
	}

	return $data;
}

/**
 * Render the recipe print card
 *
 * @param int $post_id Post ID.
 * @return string HTML output.
 */
function mytheme_render_recipe_print_card( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	// Get recipe data
	$recipe = mytheme_get_recipe_data( $post_id );

	// Check if we have recipe data
	$has_recipe = ! empty( $recipe['ingredients'] ) || ! empty( $recipe['instructions'] );

	if ( ! $has_recipe ) {
		return '';
	}

	// Get customizer settings
	$show_subtitle     = get_theme_mod( 'cozyrecipes_recipe_card_show_subtitle', true );
	$show_image        = get_theme_mod( 'cozyrecipes_recipe_card_show_image', true );
	$show_course       = get_theme_mod( 'cozyrecipes_recipe_card_show_course', true );
	$show_prep_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_prep_time', true );
	$show_cook_time    = get_theme_mod( 'cozyrecipes_recipe_card_show_cook_time', true );
	$show_total_time   = get_theme_mod( 'cozyrecipes_recipe_card_show_total_time', true );
	$show_servings     = get_theme_mod( 'cozyrecipes_recipe_card_show_servings', true );
	$show_calories     = get_theme_mod( 'cozyrecipes_recipe_card_show_calories', true );
	$show_ingredients  = get_theme_mod( 'cozyrecipes_recipe_card_show_ingredients', true );
	$show_instructions = get_theme_mod( 'cozyrecipes_recipe_card_show_instructions', true );
	$show_notes        = get_theme_mod( 'cozyrecipes_recipe_card_show_notes', true );
	$show_nutrition    = get_theme_mod( 'cozyrecipes_recipe_card_show_nutrition', false );

	// Get recipe image (already includes fallback to featured image)
	$recipe_image_url = $recipe['image_url'];

	// Get Pinterest share URL
	$post_url      = get_permalink( $post_id );
	$pinterest_url = 'https://pinterest.com/pin/create/button/?url=' . urlencode( $post_url ) . '&media=' . urlencode( $recipe_image_url ) . '&description=' . urlencode( $recipe['title'] );

	// Start output buffering
	ob_start();
	?>

	<section id="recipe-print-card" class="recipe-print-card">
		<div class="recipe-print-card-header">
			<div>
				<h2 class="recipe-print-card-title"><?php echo esc_html( $recipe['title'] ); ?></h2>
				<?php if ( $show_subtitle && ! empty( $recipe['subtitle'] ) ) : ?>
					<p class="recipe-print-card-subtitle"><?php echo esc_html( $recipe['subtitle'] ); ?></p>
				<?php endif; ?>
			</div>
			<div class="recipe-print-card-actions">
				<?php if ( $recipe_image_url ) : ?>
				<a href="<?php echo esc_url( $pinterest_url ); ?>" class="recipe-pin-btn" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Pin on Pinterest', 'cozyrecipes' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 2C6.477 2 2 6.477 2 12c0 4.237 2.636 7.855 6.356 9.312-.088-.791-.167-2.005.035-2.868.182-.78 1.172-4.97 1.172-4.97s-.299-.6-.299-1.486c0-1.39.806-2.428 1.81-2.428.852 0 1.264.64 1.264 1.408 0 .858-.545 2.14-.828 3.33-.236.995.5 1.807 1.48 1.807 1.778 0 3.144-1.874 3.144-4.58 0-2.393-1.72-4.068-4.177-4.068-2.845 0-4.515 2.135-4.515 4.34 0 .859.331 1.781.745 2.281a.3.3 0 01.069.288l-.278 1.133c-.044.183-.145.223-.335.134-1.249-.581-2.03-2.407-2.03-3.874 0-3.154 2.292-6.052 6.608-6.052 3.469 0 6.165 2.473 6.165 5.776 0 3.447-2.173 6.22-5.19 6.22-1.013 0-1.965-.525-2.291-1.148l-.623 2.378c-.226.869-.835 1.958-1.244 2.621.937.29 1.931.446 2.962.446 5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
					</svg>
					<span><?php esc_html_e( 'Pin', 'cozyrecipes' ); ?></span>
				</a>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $show_image && $recipe_image_url ) : ?>
		<div class="recipe-print-card-image">
			<img src="<?php echo esc_url( $recipe_image_url ); ?>" alt="<?php echo esc_attr( $recipe['title'] ); ?>" />
		</div>
		<?php endif; ?>

		<?php
		// Check if any meta fields have data AND are enabled
		$has_meta = ( $show_course && ! empty( $recipe['course'] ) ) ||
		            ( $show_prep_time && ! empty( $recipe['prep_time'] ) ) ||
		            ( $show_cook_time && ! empty( $recipe['cook_time'] ) ) ||
		            ( $show_total_time && ! empty( $recipe['total_time'] ) ) ||
		            ( $show_servings && ! empty( $recipe['servings'] ) ) ||
		            ( $show_calories && ! empty( $recipe['calories'] ) );

		if ( $has_meta ) :
		?>
		<div class="recipe-print-card-meta">
			<?php if ( $show_course && ! empty( $recipe['course'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Course', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['course'] ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $show_prep_time && ! empty( $recipe['prep_time'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Prep Time', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['prep_time'] ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $show_cook_time && ! empty( $recipe['cook_time'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Cook Time', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['cook_time'] ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $show_total_time && ! empty( $recipe['total_time'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Total Time', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['total_time'] ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $show_servings && ! empty( $recipe['servings'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Servings', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['servings'] ); ?></div>
			</div>
			<?php endif; ?>

			<?php if ( $show_calories && ! empty( $recipe['calories'] ) ) : ?>
			<div class="recipe-meta-item">
				<div class="recipe-meta-label"><?php esc_html_e( 'Calories', 'cozyrecipes' ); ?></div>
				<div class="recipe-meta-value"><?php echo esc_html( $recipe['calories'] ); ?></div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="recipe-print-card-content">
			<?php if ( $show_ingredients && ! empty( $recipe['ingredients'] ) ) : ?>
			<div class="recipe-section">
				<h3 class="recipe-section-title"><?php esc_html_e( 'Ingredients', 'cozyrecipes' ); ?></h3>
				<ul class="recipe-ingredients-list">
					<?php foreach ( $recipe['ingredients'] as $ingredient ) : ?>
						<li><?php echo esc_html( $ingredient ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( $show_instructions && ! empty( $recipe['instructions'] ) ) : ?>
			<div class="recipe-section">
				<h3 class="recipe-section-title"><?php esc_html_e( 'Instructions', 'cozyrecipes' ); ?></h3>
				<ol class="recipe-instructions-list">
					<?php foreach ( $recipe['instructions'] as $instruction ) : ?>
						<li><?php echo esc_html( $instruction ); ?></li>
					<?php endforeach; ?>
				</ol>
			</div>
			<?php endif; ?>

			<?php if ( $show_nutrition && ! empty( $recipe['nutrition'] ) ) : ?>
			<div class="recipe-section">
				<h3 class="recipe-section-title"><?php esc_html_e( 'Nutrition', 'cozyrecipes' ); ?></h3>
				<ul class="recipe-ingredients-list">
					<?php foreach ( $recipe['nutrition'] as $nutrition_item ) : ?>
						<li><?php echo esc_html( $nutrition_item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if ( $show_notes && ! empty( $recipe['notes'] ) ) : ?>
			<div class="recipe-notes">
				<h4 class="recipe-notes-title"><?php esc_html_e( 'Notes', 'cozyrecipes' ); ?></h4>
				<p class="recipe-notes-content"><?php echo esc_html( $recipe['notes'] ); ?></p>
			</div>
			<?php endif; ?>
		</div>
	</section>

	<?php
	return ob_get_clean();
}

/**
 * Recipe print card shortcode
 *
 * Usage: [recipe_print_card]
 */
function mytheme_recipe_print_card_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => get_the_ID(),
		),
		$atts,
		'recipe_print_card'
	);

	return mytheme_render_recipe_print_card( intval( $atts['id'] ) );
}
add_shortcode( 'recipe_print_card', 'mytheme_recipe_print_card_shortcode' );

/**
 * Enqueue recipe print card assets
 */
function mytheme_enqueue_recipe_assets() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	// Enqueue CSS
	wp_enqueue_style(
		'mytheme-recipe-print',
		get_template_directory_uri() . '/css/recipe-print.css',
		array(),
		'1.0.0'
	);

	// Inline smooth scroll script (lightweight, no separate JS file needed)
	wp_add_inline_script(
		'mytheme-recipe-print',
		"
		document.addEventListener('DOMContentLoaded', function() {
			const jumpBtn = document.querySelector('.jump-to-recipe-btn');
			if (jumpBtn) {
				jumpBtn.addEventListener('click', function(e) {
					e.preventDefault();
					const target = document.getElementById('recipe-card');
					if (target) {
						const headerOffset = 100;
						const elementPosition = target.getBoundingClientRect().top;
						const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
						window.scrollTo({
							top: offsetPosition,
							behavior: 'smooth'
						});
					}
				});
			}
		});
		"
	);
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_recipe_assets' );

/**
 * Render Jump to Recipe button
 * Call this function in your template where you want the button to appear
 *
 * @param int $post_id Post ID.
 * @return string HTML output.
 */
function mytheme_render_jump_to_recipe_button( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	// Check if post has recipe content
	$content     = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
	$recipe_data = mytheme_auto_detect_recipe_data( $content );

	// Check for custom meta or auto-detected content
	$has_ingredients  = ! empty( get_post_meta( $post_id, 'recipe_ingredients', true ) ) || ! empty( $recipe_data['ingredients'] );
	$has_instructions = ! empty( get_post_meta( $post_id, 'recipe_instructions', true ) ) || ! empty( $recipe_data['instructions'] );

	if ( ! $has_ingredients && ! $has_instructions ) {
		return '';
	}

	ob_start();
	?>
	<div class="jump-to-recipe-wrapper">
		<a href="#recipe-card" class="jump-to-recipe-btn">
			<?php esc_html_e( 'Jump to Recipe', 'cozyrecipes' ); ?>
		</a>
	</div>
	<?php
	return ob_get_clean();
}

/* ========================================
   END RECIPE PRINT CARD MODULE
======================================== */
