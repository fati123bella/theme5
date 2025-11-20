# CozyRecipes Theme

A simple, elegant, and fully responsive WordPress recipe blog theme with a clean design similar to popular food blogs.

## Features

- **Hero Section** with search bar and customizable background image
- **Featured Recipes Grid** showing handpicked posts
- **Latest Recipes Section** displaying recent posts
- **Popular Categories Section** with category cards
- **Fully Responsive Design** - Mobile-first approach with perfect mobile navigation
- **Multi-level Navigation** with dropdown submenus
- **Extensive Customizer Options** for colors, typography, and content
- **Widget Areas** - Sidebar and 3 footer columns
- **Custom Post Templates** optimized for recipes
- **Related Recipes** on single post pages
- **Search Functionality** with custom search forms
- **Accessibility Features** with ARIA attributes and keyboard navigation

## Installation

1. Download the theme files
2. Zip all files into a file named `cozyrecipes-theme.zip`
3. Go to WordPress Admin → Appearance → Themes
4. Click "Add New" → "Upload Theme"
5. Choose the zip file and click "Install Now"
6. Click "Activate" once installation is complete

## Setup & Configuration

### Initial Setup

1. **Set a Static Front Page:**
   - Go to Settings → Reading
   - Select "A static page" under "Your homepage displays"
   - Choose or create a page for your homepage
   - WordPress will automatically use `front-page.php` for the homepage

2. **Create Navigation Menu:**
   - Go to Appearance → Menus
   - Create a new menu
   - Add your pages and categories
   - Check "Primary Menu" under Menu Settings
   - Save Menu

3. **Upload Logo:**
   - Go to Appearance → Customize → Site Identity
   - Click "Select Logo" and upload your logo image

### Customizer Options

Go to **Appearance → Customize** to access all theme options:

#### Theme Colors
- Primary Accent Color (buttons, links, highlights)
- Header Background and Text Colors
- Body Background Color
- Footer Background and Text Colors

#### Typography
- Body Font (Inter, Roboto, Open Sans, Lato)
- Heading Font (Playfair Display, Poppins, Merriweather, Montserrat)
- Base Font Size (14-20px)

#### Hero Section
- Hero Background Image
- Hero Tagline (small text above title)
- Hero Title (main heading)
- Hero Subtitle (description)
- Search Placeholder Text
- CTA Button Text and URL

#### Homepage Sections
- Toggle Featured Recipes Section on/off
- Featured Section Title and Subtitle
- Choose Featured Category (or use "Featured" tag)
- Number of Featured Posts (3-12)
- Toggle Popular Categories Section on/off
- Categories Section Title and Subtitle
- Latest Recipes Section Title and Subtitle

#### Layout Options
- Sidebar Position (None / Right / Left)
- Container Width (Normal 1200px / Wide 1400px)

### Setting Up Featured Recipes

You can display featured recipes in two ways:

**Option 1: Using a Category (Recommended)**
1. Create a category called "Featured" (or any name)
2. Assign posts to this category
3. Go to Customize → Homepage Sections
4. Select the category from "Featured Category" dropdown

**Option 2: Using a Tag**
1. Leave "Featured Category" empty in Customizer
2. Add a tag called "featured" to posts you want to feature
3. Theme will automatically show posts with this tag

### Widget Areas

The theme includes 4 widget areas:

1. **Sidebar** - Appears on blog pages (if sidebar is enabled)
2. **Footer Column 1** - Left footer column
3. **Footer Column 2** - Center footer column
4. **Footer Column 3** - Right footer column

Go to **Appearance → Widgets** to add widgets to these areas.

### Recommended Plugins

While the theme works great on its own, these plugins enhance functionality:

- **WP Recipe Maker** - For beautiful recipe cards with ingredients and instructions
- **Yoast SEO** - For better search engine optimization
- **Akismet** - For spam protection
- **Contact Form 7** - For contact forms

## Mobile Navigation

The theme includes a fully functional mobile menu:

- **Hamburger Menu** - Appears on screens smaller than 768px
- **Slide-in Panel** - Menu slides in from the right
- **Submenu Toggles** - Tap to expand/collapse submenus
- **Backdrop Click** - Click outside to close menu
- **ESC Key** - Press ESC to close menu
- **No Body Scroll** - Page doesn't scroll when menu is open

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Theme Structure

```
cozyrecipes-theme/
├── style.css                  # Main stylesheet with theme header
├── functions.php              # Theme functions and setup
├── header.php                 # Site header
├── footer.php                 # Site footer
├── index.php                  # Main blog template
├── front-page.php             # Homepage template
├── single.php                 # Single post template
├── page.php                   # Page template
├── archive.php                # Archive template
├── category.php               # Category template
├── search.php                 # Search results template
├── 404.php                    # 404 error page
├── sidebar.php                # Sidebar template
├── searchform.php             # Custom search form
├── comments.php               # Comments template
├── js/
│   └── navigation.js          # Navigation JavaScript
└── template-parts/
    └── content-card.php       # Recipe card component
```

## Customization Tips

### Changing Default Colors via Code

Edit `functions.php` and modify the default values in the Customizer settings. For example:

```php
$wp_customize->add_setting( 'cozyrecipes_accent_color', array(
    'default'           => '#your-color-here',
    ...
) );
```

### Adding Custom Fonts

1. Enqueue your fonts in `functions.php`:
```php
wp_enqueue_style( 'your-custom-font', 'font-url-here', array(), null );
```

2. Update the font family in `style.css`

### Adding More Category Icons

Edit `front-page.php` around line 160 and add your category slug and emoji:

```php
$category_icons = array(
    'your-category-slug' => '🎯',
    ...
);
```

## Support

For issues, questions, or feature requests, please check the WordPress support forums or contact the theme developer.

## Credits

- **Google Fonts** - Playfair Display and Inter
- **Unsplash** - Default hero image placeholder
- Built with ❤️ for food bloggers

## Changelog

### Version 1.0.0
- Initial release
- Hero section with search
- Featured recipes grid
- Popular categories section
- Fully responsive design
- Mobile navigation
- Extensive Customizer options

## License

This theme is licensed under the GPL v2 or later.
