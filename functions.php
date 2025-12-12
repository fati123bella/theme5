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
    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'cozyrecipes' ),
        'footer'  => esc_html__( 'Footer Menu', 'cozyrecipes' ),
    ) );

    // Add image sizes
    add_image_size( 'cozyrecipes-featured', 800, 533, true );
    add_image_size( 'cozyrecipes-card', 600, 400, true );
    add_image_size( 'cozyrecipes-thumbnail', 400, 267, true );
}
add_action( 'after_setup_theme', 'cozyrecipes_setup' );

/**
 * Register Widget Areas
 */
function cozyrecipes_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'cozyrecipes' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'cozyrecipes' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 1', 'cozyrecipes' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Add footer widgets here.', 'cozyrecipes' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 2', 'cozyrecipes' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Add footer widgets here.', 'cozyrecipes' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Column 3', 'cozyrecipes' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Add footer widgets here.', 'cozyrecipes' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'cozyrecipes_widgets_init' );

/**
 * Enqueue Styles and Scripts
 */
function cozyrecipes_scripts() {
    // Google Fonts
    wp_enqueue_style( 'cozyrecipes-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap', array(), null );

    // Main stylesheet
    wp_enqueue_style( 'cozyrecipes-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );

    // JavaScript
    wp_enqueue_script( 'cozyrecipes-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get('Version'), true );
    wp_enqueue_script( 'cozyrecipes-pinterest', get_template_directory_uri() . '/js/pinterest.js', array(), wp_get_theme()->get('Version'), true );

    // Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_scripts' );

/**
 * Pinterest Pin It Button - Add wrapper to images
 */
function cozyrecipes_add_pinterest_to_images( $content ) {
    if ( ! is_singular() && ! is_page() && ! is_single() ) {
        return $content;
    }

    // Only process content with images
    if ( ! has_post_thumbnail() && strpos( $content, '<img' ) === false ) {
        return $content;
    }

    // Get current post data for Pinterest
    global $post;
    $post_title = get_the_title();
    $post_url = get_permalink();

    // Match all img tags
    $content = preg_replace_callback(
        '/<img[^>]+>/',
        function( $matches ) use ( $post_title, $post_url ) {
            $img_tag = $matches[0];

            // Extract src from img tag
            preg_match( '/src=["\']([^"\']+)["\']/', $img_tag, $src_match );
            if ( empty( $src_match[1] ) ) {
                return $img_tag;
            }

            $img_src = esc_url( $src_match[1] );

            // Build Pinterest URL
            $pinterest_url = 'https://pinterest.com/pin/create/button/?url=' . urlencode( $post_url ) .
                           '&media=' . urlencode( $img_src ) .
                           '&description=' . urlencode( $post_title );

            // Wrap image with Pinterest button
            $output = '<div class="pinterest-pin-wrapper">';
            $output .= $img_tag;
            $output .= '<a href="' . esc_url( $pinterest_url ) . '" class="pinterest-pin-button" target="_blank" rel="noopener" data-pin-do="skip" aria-label="Pin this image">';
            $output .= '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>';
            $output .= 'Pin it</a>';
            $output .= '</div>';

            return $output;
        },
        $content
    );

    return $content;
}
add_filter( 'the_content', 'cozyrecipes_add_pinterest_to_images', 10 );

/**
 * Add Pinterest button to featured images
 */
function cozyrecipes_pinterest_featured_image( $html, $post_id, $post_thumbnail_id ) {
    if ( ! is_singular() ) {
        return $html;
    }

    $post_title = get_the_title( $post_id );
    $post_url = get_permalink( $post_id );
    $img_src = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );

    if ( ! $img_src ) {
        return $html;
    }

    $pinterest_url = 'https://pinterest.com/pin/create/button/?url=' . urlencode( $post_url ) .
                   '&media=' . urlencode( $img_src ) .
                   '&description=' . urlencode( $post_title );

    $output = '<div class="pinterest-pin-wrapper">';
    $output .= $html;
    $output .= '<a href="' . esc_url( $pinterest_url ) . '" class="pinterest-pin-button" target="_blank" rel="noopener" data-pin-do="skip" aria-label="Pin this image">';
    $output .= '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>';
    $output .= 'Pin it</a>';
    $output .= '</div>';

    return $output;
}
add_filter( 'post_thumbnail_html', 'cozyrecipes_pinterest_featured_image', 10, 3 );

/**
 * Customizer Settings
 */
function cozyrecipes_customize_register( $wp_customize ) {

    // ===== COLORS SECTION =====
    $wp_customize->add_section( 'cozyrecipes_colors', array(
        'title'    => __( 'Theme Colors', 'cozyrecipes' ),
        'priority' => 30,
    ) );

    // Primary accent color
    $wp_customize->add_setting( 'cozyrecipes_accent_color', array(
        'default'           => '#ff6b6b',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_accent_color', array(
        'label'    => __( 'Accent Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_accent_color',
    ) ) );

    // Header background color
    $wp_customize->add_setting( 'cozyrecipes_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cozyrecipes_header_bg_color', array(
        'label'    => __( 'Header Background Color', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_colors',
        'settings' => 'cozyrecipes_header_bg_color',
    ) ) );

    // ===== HERO SECTION =====
    $wp_customize->add_section( 'cozyrecipes_hero', array(
        'title'    => __( 'Hero Section', 'cozyrecipes' ),
        'priority' => 40,
    ) );

    // Hero background image
    $wp_customize->add_setting( 'cozyrecipes_hero_image', array(
        'default'           => 'https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=1600',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cozyrecipes_hero_image', array(
        'label'    => __( 'Hero Background Image', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'settings' => 'cozyrecipes_hero_image',
    ) ) );

    // Hero tagline
    $wp_customize->add_setting( 'cozyrecipes_hero_tagline', array(
        'default'           => 'Easy, cozy recipes for every day',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_hero_tagline', array(
        'label'    => __( 'Hero Tagline', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero title
    $wp_customize->add_setting( 'cozyrecipes_hero_title', array(
        'default'           => 'Delicious Recipes Made Simple',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_hero_title', array(
        'label'    => __( 'Hero Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero search placeholder
    $wp_customize->add_setting( 'cozyrecipes_hero_search_placeholder', array(
        'default'           => 'Search for recipes…',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_hero_search_placeholder', array(
        'label'    => __( 'Search Placeholder', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero CTA text
    $wp_customize->add_setting( 'cozyrecipes_hero_cta_text', array(
        'default'           => 'Browse All Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_hero_cta_text', array(
        'label'    => __( 'CTA Button Text', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero CTA URL
    $wp_customize->add_setting( 'cozyrecipes_hero_cta_url', array(
        'default'           => '/blog',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'cozyrecipes_hero_cta_url', array(
        'label'    => __( 'CTA Button URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'url',
    ) );

    // ===== FEATURED RECIPES SECTION =====
    $wp_customize->add_section( 'cozyrecipes_featured', array(
        'title'    => __( 'Featured Recipes Section', 'cozyrecipes' ),
        'priority' => 50,
    ) );

    // Show/hide featured section
    $wp_customize->add_setting( 'cozyrecipes_show_featured', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'cozyrecipes_show_featured', array(
        'label'    => __( 'Show Featured Recipes Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_featured',
        'type'     => 'checkbox',
    ) );

    // Featured section title
    $wp_customize->add_setting( 'cozyrecipes_featured_title', array(
        'default'           => 'Featured Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_featured_title', array(
        'label'    => __( 'Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_featured',
        'type'     => 'text',
    ) );

    // Featured section subtitle
    $wp_customize->add_setting( 'cozyrecipes_featured_subtitle', array(
        'default'           => 'Our most popular and delicious recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_featured_subtitle', array(
        'label'    => __( 'Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_featured',
        'type'     => 'text',
    ) );

    // Featured category
    $wp_customize->add_setting( 'cozyrecipes_featured_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'cozyrecipes_featured_category', array(
        'label'    => __( 'Featured Category (leave empty for latest posts)', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_featured',
        'type'     => 'select',
        'choices'  => cozyrecipes_get_category_choices(),
    ) );

    // ===== CATEGORIES SECTION =====
    $wp_customize->add_section( 'cozyrecipes_categories', array(
        'title'    => __( 'Popular Categories Section', 'cozyrecipes' ),
        'priority' => 60,
    ) );

    // Show/hide categories section
    $wp_customize->add_setting( 'cozyrecipes_show_categories', array(
        'default'           => true,
        'sanitize_callback' => 'cozyrecipes_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'cozyrecipes_show_categories', array(
        'label'    => __( 'Show Popular Categories Section', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_categories',
        'type'     => 'checkbox',
    ) );

    // Categories section title
    $wp_customize->add_setting( 'cozyrecipes_categories_title', array(
        'default'           => 'Popular Categories',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_categories_title', array(
        'label'    => __( 'Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_categories',
        'type'     => 'text',
    ) );

    // Categories section subtitle
    $wp_customize->add_setting( 'cozyrecipes_categories_subtitle', array(
        'default'           => 'Browse recipes by your favorite categories',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'cozyrecipes_categories_subtitle', array(
        'label'    => __( 'Section Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_categories',
        'type'     => 'text',
    ) );

    // ===== LAYOUT SECTION =====
    $wp_customize->add_section( 'cozyrecipes_layout', array(
        'title'    => __( 'Layout Options', 'cozyrecipes' ),
        'priority' => 70,
    ) );

    // Sidebar position
    $wp_customize->add_setting( 'cozyrecipes_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'cozyrecipes_sanitize_sidebar_position',
    ) );
    $wp_customize->add_control( 'cozyrecipes_sidebar_position', array(
        'label'    => __( 'Sidebar Position', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_layout',
        'type'     => 'select',
        'choices'  => array(
            'right' => __( 'Right Sidebar', 'cozyrecipes' ),
            'left'  => __( 'Left Sidebar', 'cozyrecipes' ),
            'none'  => __( 'No Sidebar', 'cozyrecipes' ),
        ),
    ) );

    // Container width
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
}
add_action( 'customize_register', 'cozyrecipes_customize_register' );

/**
 * Get category choices for customizer
 */
function cozyrecipes_get_category_choices() {
    $choices = array( '' => __( '-- Select Category --', 'cozyrecipes' ) );
    $categories = get_categories( array( 'hide_empty' => false ) );

    foreach ( $categories as $category ) {
        $choices[ $category->term_id ] = $category->name;
    }

    return $choices;
}

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
    $valid = array( 'right', 'left', 'none' );
    return ( in_array( $input, $valid ) ? $input : 'right' );
}

/**
 * Sanitize container width
 */
function cozyrecipes_sanitize_container_width( $input ) {
    $valid = array( 'normal', 'wide' );
    return ( in_array( $input, $valid ) ? $input : 'normal' );
}

/**
 * Output custom CSS for Customizer settings
 */
function cozyrecipes_customizer_css() {
    $accent_color = get_theme_mod( 'cozyrecipes_accent_color', '#ff6b6b' );
    $header_bg = get_theme_mod( 'cozyrecipes_header_bg_color', '#ffffff' );
    ?>
    <style type="text/css">
        a,
        .main-navigation a:hover,
        .main-navigation .current-menu-item > a,
        .post-card-link,
        .widget ul li a:hover,
        .footer-widget a:hover,
        .footer-bottom a,
        .post-card-title a:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .hero-search-form button,
        .btn,
        .post-card-category,
        .pagination a:hover,
        .pagination .current,
        .search-form button {
            background-color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
        }

        .hero-cta:hover {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .widget-title {
            border-bottom-color: <?php echo esc_attr( $accent_color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'cozyrecipes_customizer_css' );

/**
 * Get sidebar position class
 */
function cozyrecipes_get_sidebar_class() {
    $position = get_theme_mod( 'cozyrecipes_sidebar_position', 'right' );
    return $position === 'left' ? 'left' : '';
}

/**
 * Check if sidebar should be shown
 */
function cozyrecipes_show_sidebar() {
    return get_theme_mod( 'cozyrecipes_sidebar_position', 'right' ) !== 'none';
}

/**
 * Get container class
 */
function cozyrecipes_get_container_class() {
    $width = get_theme_mod( 'cozyrecipes_container_width', 'normal' );
    return 'site-container' . ( $width === 'wide' ? ' wide' : '' );
}

/**
 * Custom excerpt length
 */
function cozyrecipes_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'cozyrecipes_excerpt_length' );

/**
 * Custom excerpt more
 */
function cozyrecipes_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'cozyrecipes_excerpt_more' );

/**
 * Add reading time to posts
 */
function cozyrecipes_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );

    return $reading_time . ' min read';
}

/**
 * Get category icon/emoji
 */
function cozyrecipes_get_category_icon( $category_name ) {
    $icons = array(
        'breakfast' => '🥞',
        'lunch'     => '🥗',
        'dinner'    => '🍽️',
        'dessert'   => '🍰',
        'desserts'  => '🍰',
        'snacks'    => '🍿',
        'drinks'    => '🍹',
        'beverages' => '🍹',
        'salads'    => '🥗',
        'soup'      => '🍲',
        'soups'     => '🍲',
        'pasta'     => '🍝',
        'pizza'     => '🍕',
        'bread'     => '🍞',
        'vegetarian'=> '🥬',
        'vegan'     => '🌱',
        'healthy'   => '💚',
    );

    $category_slug = strtolower( $category_name );

    foreach ( $icons as $key => $icon ) {
        if ( strpos( $category_slug, $key ) !== false ) {
            return $icon;
        }
    }

    return '🍴';
}
