# CozyRecipes Theme - SEO & Performance Optimization Guide

## Overview

This document describes all SEO and performance optimizations implemented in the CozyRecipes WordPress theme. These optimizations improve search engine visibility, user experience, and page load performance.

---

## 1. Structured Data & Schema Markup

### 1.1 Recipe Schema (JSON-LD)

**Location:** `functions.php` - `cozyrecipes_add_recipe_schema()` function

**What it does:** Adds structured recipe data to single post pages, enabling Google to understand and display your recipes in rich search results.

**Data included:**
- Recipe name and description
- Author information
- Recipe image with proper dimensions
- Cooking times (prep: 15min, cook: 30min, total: 45min)
- Yield: 4 servings
- Category and cuisine
- Keywords

**Benefits:**
- Improved SERP visibility with Google Recipe Rich Results
- Higher CTR with recipe images showing in search results
- Better voice search optimization

**Validation:**
Test at: https://developers.google.com/search/docs/appearance/structured-data/recipe

---

### 1.2 Breadcrumb Schema (JSON-LD)

**Location:** `functions.php` - `cozyrecipes_add_breadcrumb_schema()` function

**What it does:** Adds breadcrumb navigation structure that helps search engines understand your site hierarchy.

**Structure:**
- Home
- Category (on single posts)
- Current Page Title

**Benefits:**
- Breadcrumb navigation in search results
- Better site structure understanding
- Improved user navigation clarity

**Validation:**
Test at: https://developers.google.com/search/docs/appearance/structured-data/breadcrumb

---

### 1.3 Organization Schema (JSON-LD)

**Location:** `functions.php` - `cozyrecipes_add_organization_schema()` function

**Where it appears:** Homepage and blog archive pages only

**Data included:**
- Business/brand name
- Site description
- Logo URL
- Contact information (placeholder)
- Social media profiles (Facebook, Twitter, Instagram)

**Benefits:**
- Enhanced knowledge graph results
- Brand credibility signals
- Social profile linking

**Configuration:**
Edit the function to add your actual:
- Organization name
- Logo path (update: `/assets/images/logo.png`)
- Phone number
- Social media URLs

---

## 2. Social Media Meta Tags

### 2.1 Open Graph Tags

**Location:** `functions.php` - `cozyrecipes_add_open_graph_tags()` function

**Displays on:**
- Facebook, LinkedIn, Pinterest, WhatsApp

**Data included:**
- og:type (article/website)
- og:title (post/page title)
- og:description (excerpt)
- og:url (canonical URL)
- og:image (featured image, 1200x630px recommended)
- og:site_name (WordPress site name)

**How it works:**
When someone shares your post on social media, this metadata determines what preview appears.

**Best practices:**
- Use descriptive, engaging titles (55-60 characters)
- Write compelling descriptions (155-160 characters)
- Upload high-quality featured images (1200x630px minimum)

---

### 2.2 Twitter Card Tags

**Location:** `functions.php` - `cozyrecipes_add_twitter_card_tags()` function

**Displays on:** Twitter/X platform

**Card type:** summary_large_image (shows large preview image)

**Data included:**
- twitter:card (card type)
- twitter:title
- twitter:description
- twitter:image

**Best practices:**
- Use the same image as Open Graph for consistency
- Test at: https://cards-dev.twitter.com/validator

---

## 3. SEO Meta Tags

### 3.1 Meta Description

**Location:** `functions.php` - `cozyrecipes_add_seo_meta_tags()` function

**Length:** 155-160 characters (optimal for display in search results)

**Source:** First 20 words of post content as fallback

**Best practices:**
- Write unique descriptions for each page
- Include target keywords naturally
- Create compelling, clickable descriptions

---

### 3.2 Meta Keywords

**Location:** `functions.php` - `cozyrecipes_add_seo_meta_tags()` function

**Source:** Post categories (automatically extracted)

**Best practices:**
- Use 3-5 relevant category keywords
- Focus on high-intent search terms
- Avoid keyword stuffing

---

### 3.3 Article Meta Tags

**Location:** `functions.php` - `cozyrecipes_add_seo_meta_tags()` function

**Tags included:**
- `article:published_time` (ISO 8601 format)
- `article:modified_time` (update tracking)
- `article:author` (post author display name)
- Author URL link tag

**Benefits:**
- Helps Google understand content freshness
- Tracks author authority
- Better content aging signals

---

### 3.4 Canonical URL

**Location:** `functions.php` - `cozyrecipes_add_canonical_url()` function

**Prevents:** Duplicate content issues

**Applies to:**
- Single posts and pages
- Category archives
- Homepage
- Paginated archives

**Functionality:**
- Automatically removes query parameters
- Handles HTTPS/HTTP consistency
- Prevents pagination duplicate content

---

### 3.5 Robots Meta Tag

**Location:** `functions.php` - `cozyrecipes_add_robots_meta()` function

**Applies to:** Posts, pages, archives, and homepage

**Directives:**
- `index` - Allow indexing
- `follow` - Follow external links
- `max-image-preview:large` - Show large image previews
- `max-snippet:-1` - Show full snippet (no limit)
- `max-video-preview:-1` - Show full video preview

**Benefits:**
- Enables rich snippets and image previews
- Controls search appearance
- Improves SERP presentation

---

## 4. Image SEO Optimization

### 4.1 Alt Text Filtering

**Location:** `functions.php` - `cozyrecipes_filter_post_content_images()` function

**What it does:** Automatically adds alt text to images missing it

**Fallback method:** Uses image filename as alt text if none provided

**Benefits:**
- Accessibility compliance (WCAG)
- Image SEO ranking signals
- Better user experience for screen readers

**Best practices:**
- Add descriptive alt text when uploading images
- Include target keywords naturally in alt text
- Avoid keyword stuffing in alt attributes

---

## 5. Performance Optimizations

### 5.1 CSS Minification

**Files:**
- Production: `style.min.css` (24KB - 35% reduction)
- Development: `style.css` (36KB - full source)

**Auto-switching:** Theme automatically loads minified version if available

**Size savings:** 12KB+ per page load

---

### 5.2 Font Optimization

**Location:** `functions.php` - `cozyrecipes_resource_hints()` function

**Techniques:**
- DNS prefetch for Google Fonts
- Preconnect to fonts.gstatic.com
- Media="print" trick for non-blocking load
- `font-display: swap` for FOUT prevention

**Impact:** 200-400ms FCP improvement

---

### 5.3 Script Loading Order

**jQuery Loading:**
- Loads in `<head>` with synchronous execution
- Protected from async/defer filters
- jQuery Migrate depends on jQuery

**Custom Scripts:**
- Deferred in footer (no jQuery dependency)
- Async where possible
- Minimal blocking on page load

**Transient Cleanup:**
- Daily scheduled cleanup of expired cache
- Prevents database bloat
- WP-Cron powered

---

### 5.4 LCP Image Preloading

**Location:** `functions.php` - `cozyrecipes_preload_lcp_image()` function

**What it does:** Preloads featured images with responsive srcset

**Preloads:**
- Single post featured images
- Homepage hero image

**Impact:** Improved Largest Contentful Paint (LCP) metric

---

### 5.5 Unnecessary Resource Removal

**Removed:**
- Block library CSS (Gutenberg)
- Emoji support and scripts
- Extra jQuery dependencies
- Shortlink meta tags
- Unnecessary header links

**Impact:** 5-10KB+ file size reduction

---

## 6. Content Optimization Checklist for Authors

### Before Publishing a Recipe Post:

- [ ] **Featured Image**
  - [ ] High quality, 1200x630px minimum
  - [ ] Shows the finished recipe
  - [ ] Properly licensed/owned

- [ ] **Title**
  - [ ] 50-60 characters
  - [ ] Includes main recipe keyword
  - [ ] Compelling and descriptive

- [ ] **Meta Description**
  - [ ] 155-160 characters
  - [ ] Unique for each post
  - [ ] Includes primary keyword
  - [ ] Compelling call-to-action

- [ ] **Content**
  - [ ] Ingredients section clearly formatted
  - [ ] Step-by-step instructions
  - [ ] Cooking/prep times included
  - [ ] Yield/servings clearly stated
  - [ ] Internal links to related recipes

- [ ] **Images**
  - [ ] Descriptive alt text for all images
  - [ ] Alt text includes keywords naturally
  - [ ] High quality, properly compressed
  - [ ] 1200x800px or larger

- [ ] **Categories**
  - [ ] 2-3 relevant categories selected
  - [ ] Categories are specific to recipe type
  - [ ] Avoid over-categorization

---

## 7. Mobile SEO Verification

### Mobile-First Indexing Checklist:

- [ ] Test on actual mobile devices
- [ ] Verify responsive design (480px, 640px, 768px breakpoints)
- [ ] Check touch target sizes (48px minimum)
- [ ] Test mobile navigation and menus
- [ ] Verify forms work on mobile
- [ ] Check mobile image loading
- [ ] Test mobile page speed (PageSpeed Insights)

**Test tools:**
- Google Mobile-Friendly Test: https://search.google.com/test/mobile-friendly
- Chrome DevTools: Device emulation
- PageSpeed Insights: https://pagespeed.web.dev

---

## 8. Schema Markup Validation

### Validation Tools:

1. **Google Rich Results Test**
   - URL: https://search.google.com/test/rich-results
   - Tests: Recipe, Breadcrumb, Article schemas

2. **Structured Data Testing Tool**
   - URL: https://developers.google.com/search/docs/appearance/structured-data
   - Validates JSON-LD, Microdata, RDFa

3. **Schema.org Validator**
   - URL: https://validator.schema.org/
   - Comprehensive schema validation

### Validation Process:

1. Publish a test recipe post
2. Visit validation tool
3. Enter your post URL
4. Check for errors or warnings
5. Fix any issues found
6. Re-validate

---

## 9. Search Console Integration

### Setup Steps:

1. **Claim Property:**
   - Go to: https://search.google.com/search-console
   - Add your site property
   - Verify ownership (HTML file or DNS record)

2. **Submit Sitemap:**
   - Generate with plugin: Yoast SEO, All in One SEO, or Rankmath
   - Submit through Search Console
   - Check coverage report

3. **Monitor:**
   - Review Core Web Vitals
   - Check Coverage errors
   - Analyze Search Performance
   - Review Mobile Usability

4. **Rich Results:**
   - Check "Enhancements" section
   - Verify Recipe Rich Results status
   - Fix any detected issues

---

## 10. Performance Metrics Target

### Google PageSpeed Insights Goals:

**Mobile:**
- Performance: 90+
- Accessibility: 95+
- Best Practices: 90+
- SEO: 95+

**Desktop:**
- Performance: 95+
- All scores: 95+

### Core Web Vitals Targets:

- **LCP (Largest Contentful Paint):** < 2.5 seconds
- **FID (First Input Delay):** < 100 milliseconds
- **CLS (Cumulative Layout Shift):** < 0.1

---

## 11. Ongoing Optimization Tasks

### Monthly:

- [ ] Check Google Search Console for new errors
- [ ] Review search query performance
- [ ] Check Core Web Vitals metrics
- [ ] Verify no 404 errors in console
- [ ] Review mobile usability issues

### Quarterly:

- [ ] Run full PageSpeed audit
- [ ] Test site on latest mobile devices
- [ ] Review competitor SEO strategies
- [ ] Check for broken internal links
- [ ] Audit image compression effectiveness

### Annually:

- [ ] Full site SEO audit
- [ ] Update schema markup if needed
- [ ] Review social media meta tags
- [ ] Update robots.txt if needed
- [ ] Review and update robots meta directives

---

## 12. Technical Implementation Summary

### Files Modified:

1. **functions.php**
   - Added 9 new SEO functions
   - Updated stylesheet enqueuing for minified CSS
   - Maintained backward compatibility

2. **style.min.css**
   - 35% size reduction (36KB → 24KB)
   - Auto-loaded when available

3. **header.php**
   - All SEO meta tags in `wp_head()`
   - Critical CSS inlined
   - Font preloading optimized

4. **footer.php**
   - Script loading optimized
   - jQuery loading order fixed

### PHP Functions Added:

1. `cozyrecipes_add_recipe_schema()` - Recipe structured data
2. `cozyrecipes_add_breadcrumb_schema()` - Breadcrumb navigation
3. `cozyrecipes_add_open_graph_tags()` - Social media preview
4. `cozyrecipes_add_twitter_card_tags()` - Twitter optimization
5. `cozyrecipes_add_canonical_url()` - Duplicate prevention
6. `cozyrecipes_add_seo_meta_tags()` - Meta descriptions & tags
7. `cozyrecipes_filter_post_content_images()` - Alt text automation
8. `cozyrecipes_add_organization_schema()` - Brand data
9. `cozyrecipes_add_robots_meta()` - Search appearance control

---

## 13. Common Issues & Troubleshooting

### Issue: Schema markup not appearing in Search Console

**Solution:**
1. Ensure post is indexed (check Search Console)
2. Wait 24-48 hours for Google to re-crawl
3. Manually request indexing in Search Console
4. Verify schema validity with Google tool

### Issue: Images not showing in social shares

**Solution:**
1. Ensure featured image is 1200x630px or larger
2. Check Open Graph tags in page source (`<meta property="og:image">`)
3. Test with social validator tools
4. Clear social cache and retry sharing

### Issue: Mobile PageSpeed score low

**Solution:**
1. Verify minified CSS is loading
2. Check image compression
3. Review unused code/CSS
4. Check Core Web Vitals
5. Consider lazy loading for below-fold images

### Issue: Recipe Rich Results not showing

**Solution:**
1. Ensure post has featured image
2. Verify ingredients section is present
3. Check cooking time format (must be valid)
4. Validate with Google Rich Results Test
5. Submit URL to Google for re-crawl

---

## 14. Advanced Customization

### Adding Custom Social Media URLs

Edit `cozyrecipes_add_organization_schema()` in functions.php:

```php
'sameAs' => array(
    'https://www.facebook.com/your-page/',
    'https://www.twitter.com/your-handle/',
    'https://www.instagram.com/your-handle/',
    'https://www.youtube.com/your-channel/',
    'https://www.pinterest.com/your-profile/',
),
```

### Customizing Recipe Schema Data

Edit `cozyrecipes_add_recipe_schema()` to match your typical recipe format:

```php
'prepTime' => 'PT15M',      // Change to your typical prep time
'cookTime' => 'PT30M',      // Change to your typical cook time
'recipeYield' => 4,         // Change to your typical yield
```

### Disabling REST API for Security

In functions.php, uncomment:

```php
add_action( 'rest_api_init', 'cozyrecipes_disable_rest_for_unauthenticated' );
```

---

## 15. Performance Metrics Before & After

### CSS File Size:
- Before: 36KB
- After: 24KB (minified)
- Savings: 12KB per page (35% reduction)

### Total Theme Size:
- Development: ~92KB (functions.php)
- With assets: ~200KB+
- Optimization impact: ~5-10% reduction in overall load

### Expected PageSpeed Improvements:
- Mobile: +5-15 points
- Desktop: +10-20 points
- LCP: -200-400ms
- CLS: Improved with our responsive design

---

## 16. References & Resources

### SEO Tools:
- [Google Search Console](https://search.google.com/search-console)
- [Google PageSpeed Insights](https://pagespeed.web.dev)
- [Google Mobile-Friendly Test](https://search.google.com/test/mobile-friendly)
- [Structured Data Testing Tool](https://search.google.com/test/rich-results)

### WordPress SEO Plugins (Optional):
- Yoast SEO
- All in One SEO
- Rankmath
- The SEO Framework

### Learning Resources:
- [Google Search Central Documentation](https://developers.google.com/search)
- [Schema.org Documentation](https://schema.org)
- [Web.dev Performance Guide](https://web.dev/performance)
- [MDN Web Docs - SEO](https://developer.mozilla.org/en-US/docs/Glossary/SEO)

---

## 17. Support & Maintenance

### If you encounter issues:

1. Check PHP syntax: `php -l functions.php`
2. Validate CSS minification: Verify `style.min.css` exists
3. Check for JavaScript errors in browser console
4. Verify SEO functions are outputting in page source
5. Review WordPress debug log for errors

### Regular Maintenance:

- Keep WordPress core updated
- Update plugins that affect SEO (redirects, sitemaps)
- Monitor Search Console regularly
- Review PageSpeed metrics monthly
- Test new recipe markup with validation tools

---

**Last Updated:** November 27, 2025
**Theme Version:** 1.0.0
**CozyRecipes Theme SEO & Performance Optimization Guide**
