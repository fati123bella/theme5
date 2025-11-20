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

    // Add additional image sizes
    add_image_size( 'cozyrecipes-featured', 1200, 800, true );
    add_image_size( 'cozyrecipes-thumbnail', 600, 900, true );

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
}
add_action( 'after_setup_theme', 'cozyrecipes_setup' );

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
 * Enqueue Scripts and Styles
 */
function cozyrecipes_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'cozyrecipes-google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap', array(), null );

    // Enqueue theme stylesheet
    wp_enqueue_style( 'cozyrecipes-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    // Enqueue theme JavaScript
    wp_enqueue_script( 'cozyrecipes-navigation', get_template_directory_uri() . '/js/navigation.js', array(), wp_get_theme()->get( 'Version' ), true );

    // Enqueue comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'cozyrecipes_scripts' );

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
    // TYPOGRAPHY SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_typography', array(
        'title'    => __( 'Typography', 'cozyrecipes' ),
        'priority' => 35,
    ) );

    // Body Font
    $wp_customize->add_setting( 'cozyrecipes_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_body_font', array(
        'label'    => __( 'Body Font', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_typography',
        'type'     => 'select',
        'choices'  => array(
            'Inter'     => 'Inter',
            'Roboto'    => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato'      => 'Lato',
        ),
    ) );

    // Heading Font
    $wp_customize->add_setting( 'cozyrecipes_heading_font', array(
        'default'           => 'Playfair Display',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_heading_font', array(
        'label'    => __( 'Heading Font', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_typography',
        'type'     => 'select',
        'choices'  => array(
            'Playfair Display' => 'Playfair Display',
            'Poppins'          => 'Poppins',
            'Merriweather'     => 'Merriweather',
            'Montserrat'       => 'Montserrat',
        ),
    ) );

    // Base Font Size
    $wp_customize->add_setting( 'cozyrecipes_base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_base_font_size', array(
        'label'       => __( 'Base Font Size (px)', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 20,
            'step' => 1,
        ),
    ) );

    // ========================================
    // HERO SECTION
    // ========================================

    $wp_customize->add_section( 'cozyrecipes_hero', array(
        'title'    => __( 'Hero Section', 'cozyrecipes' ),
        'priority' => 40,
    ) );

    // Hero Background Image
    $wp_customize->add_setting( 'cozyrecipes_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cozyrecipes_hero_image', array(
        'label'    => __( 'Hero Background Image', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'settings' => 'cozyrecipes_hero_image',
    ) ) );

    // Hero Tagline
    $wp_customize->add_setting( 'cozyrecipes_hero_tagline', array(
        'default'           => 'Easy, cozy recipes for every day',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_hero_tagline', array(
        'label'    => __( 'Hero Tagline', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero Title
    $wp_customize->add_setting( 'cozyrecipes_hero_title', array(
        'default'           => 'Discover Delicious Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_hero_title', array(
        'label'    => __( 'Hero Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // Hero Subtitle
    $wp_customize->add_setting( 'cozyrecipes_hero_subtitle', array(
        'default'           => 'Find the perfect recipe for any occasion',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_hero_subtitle', array(
        'label'    => __( 'Hero Subtitle', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'textarea',
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

    // CTA Button Text
    $wp_customize->add_setting( 'cozyrecipes_cta_text', array(
        'default'           => 'Browse All Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_cta_text', array(
        'label'    => __( 'CTA Button Text', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'text',
    ) );

    // CTA Button URL
    $wp_customize->add_setting( 'cozyrecipes_cta_url', array(
        'default'           => '/blog/',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'cozyrecipes_cta_url', array(
        'label'    => __( 'CTA Button URL', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_hero',
        'type'     => 'url',
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

    // Featured Section Title
    $wp_customize->add_setting( 'cozyrecipes_featured_title', array(
        'default'           => 'Featured Recipes',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'cozyrecipes_featured_title', array(
        'label'    => __( 'Featured Section Title', 'cozyrecipes' ),
        'section'  => 'cozyrecipes_homepage',
        'type'     => 'text',
    ) );

    // Featured Section Subtitle
    $wp_customize->add_setting( 'cozyrecipes_featured_subtitle', array(
        'default'           => 'Our handpicked favorites just for you',
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

    // Number of Featured Posts
    $wp_customize->add_setting( 'cozyrecipes_featured_count', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'cozyrecipes_featured_count', array(
        'label'       => __( 'Number of Featured Posts', 'cozyrecipes' ),
        'section'     => 'cozyrecipes_homepage',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 3,
            'max'  => 12,
            'step' => 1,
        ),
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
    $footer_bg = get_theme_mod( 'cozyrecipes_footer_bg_color', '#2a2a2a' );
    $footer_text = get_theme_mod( 'cozyrecipes_footer_text_color', '#cccccc' );
    $body_font = get_theme_mod( 'cozyrecipes_body_font', 'Inter' );
    $heading_font = get_theme_mod( 'cozyrecipes_heading_font', 'Playfair Display' );
    $font_size = get_theme_mod( 'cozyrecipes_base_font_size', '16' );

    ?>
    <style type="text/css">
        :root {
            --accent-color: <?php echo esc_attr( $accent_color ); ?>;
            --header-bg: <?php echo esc_attr( $header_bg ); ?>;
            --header-text: <?php echo esc_attr( $header_text ); ?>;
            --body-bg: <?php echo esc_attr( $body_bg ); ?>;
            --footer-bg: <?php echo esc_attr( $footer_bg ); ?>;
            --footer-text: <?php echo esc_attr( $footer_text ); ?>;
        }

        html {
            font-size: <?php echo absint( $font_size ); ?>px;
        }

        body {
            font-family: '<?php echo esc_attr( $body_font ); ?>', sans-serif;
            background-color: <?php echo esc_attr( $body_bg ); ?>;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: '<?php echo esc_attr( $heading_font ); ?>', serif;
        }

        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?>;
        }

        .main-navigation a,
        .site-title a {
            color: <?php echo esc_attr( $header_text ); ?>;
        }

        .site-footer {
            background-color: <?php echo esc_attr( $footer_bg ); ?>;
            color: <?php echo esc_attr( $footer_text ); ?>;
        }

        a,
        .main-navigation a:hover,
        .recipe-link,
        .hero-search-form button,
        .recipe-category-badge {
            color: <?php echo esc_attr( $accent_color ); ?>;
        }

        .hero-search-form button,
        .search-form button,
        .pagination a:hover,
        .pagination .current {
            background-color: <?php echo esc_attr( $accent_color ); ?>;
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
