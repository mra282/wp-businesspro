# DroneSnaps WordPress Theme

A modern, responsive WordPress theme designed specifically for drone photography and videography businesses. Features stunning portfolio galleries, testimonials, booking functionality, and comprehensive business features.

## 🚁 Features

### Core Features
- **Responsive Design**: Mobile-first approach with perfect display on all devices
- **Portfolio Gallery**: Showcase aerial photography and videography projects
- **Testimonials System**: Display client reviews and ratings
- **Contact Forms**: Advanced contact form with service-specific fields
- **SEO Optimized**: Schema markup and optimized code structure
- **Accessibility Ready**: WCAG 2.1 AA compliance
- **Performance Optimized**: Lazy loading, optimized images, and fast loading

### Custom Post Types
- **Portfolio Projects** (`drone_portfolio`): Showcase your aerial work
- **Testimonials** (`drone_testimonials`): Client reviews and feedback

### Template Pages
- **Homepage**: Hero section, services, portfolio, testimonials
- **Services Page**: Detailed service offerings
- **Portfolio Archive**: Filterable project gallery
- **Contact Page**: Advanced contact form with business information
- **About Page**: Company information and team
- **Blog**: News and updates

### WordPress Features
- **Custom Logo**: Upload your brand logo
- **Custom Menus**: Primary navigation and footer menus
- **Widget Areas**: Multiple sidebar and footer widget areas
- **Theme Customizer**: Live preview customization options
- **Custom Colors**: Brand color customization
- **Typography**: Google Fonts integration

## 📋 Requirements

- WordPress 6.0 or higher
- PHP 8.0 or higher
- Modern web browser with JavaScript enabled

## 🚀 Installation

### Quick Installation
1. Download the theme files
2. Upload to `/wp-content/themes/dronesnaps/`
3. Activate in WordPress Admin → Appearance → Themes
4. Configure theme settings

### Docker Development Environment
The theme includes a complete Docker setup for development:

```bash
# Clone the repository
git clone [repository-url]
cd dronesnaps-wordpress-theme

# Start the development environment
docker-compose up -d

# Access the site
http://localhost:8080

# WordPress Admin
http://localhost:8080/wp-admin
Username: admin
Password: password
```

## 🛠️ Setup Guide

### Initial Configuration

1. **Theme Activation**
   - Go to Appearance → Themes
   - Activate "DroneSnaps"

2. **Customize Settings**
   - Navigate to Appearance → Customize
   - Configure:
     - Site Identity (logo, colors)
     - Contact Information
     - Social Media Links
     - Homepage Settings

3. **Create Essential Pages**
   - Home (set as homepage)
   - Services
   - Portfolio
   - About
   - Contact
   - Blog

4. **Menu Setup**
   - Go to Appearance → Menus
   - Create "Primary Menu" with main navigation
   - Create "Footer Menu" for footer links

### Content Setup

#### Portfolio Projects
1. Go to Portfolio → Add New
2. Fill in project details:
   - Title and description
   - Featured image
   - Project metadata (location, date, client, type)
   - Additional gallery images
   - Categories/tags

#### Testimonials
1. Go to Testimonials → Add New
2. Add testimonial content:
   - Client testimonial text
   - Client name and role
   - Star rating (1-5)
   - Client photo (optional)
   - Project date

#### Contact Page
1. Create a new page
2. Select "Contact Page" template
3. Customize contact information in Appearance → Customize → Contact Information

## 🎨 Customization

### Theme Customizer Options

#### Site Identity
- **Custom Logo**: Upload your business logo
- **Site Title & Tagline**: Business name and description
- **Site Icon**: Favicon for browser tabs

#### Colors
- **Primary Color**: Main brand color (default: #337ab7)
- **Secondary Color**: Supporting brand color (default: #2c3e50)
- **Accent Color**: Highlight color (default: #ff8c00)

#### Homepage Settings
- **Hero Section**: Background image and text
- **Services Section**: Enable/disable and configure
- **Portfolio Section**: Number of items to display
- **Testimonials**: Enable carousel and set count

#### Contact Information
- **Business Address**: Full address for contact page
- **Phone Number**: Primary contact number
- **Email Address**: Business email
- **Business Hours**: Operating hours

#### Social Media
- **Facebook**: Facebook page URL
- **Instagram**: Instagram profile URL
- **Twitter**: Twitter profile URL
- **LinkedIn**: LinkedIn company page
- **YouTube**: YouTube channel URL

### Custom CSS
Add custom styles in Appearance → Customize → Additional CSS:

```css
/* Example customizations */
:root {
    --primary-color: #your-color;
    --accent-color: #your-accent;
}

.hero-section {
    background-color: #custom-background;
}
```

### Child Theme
For extensive customizations, create a child theme:

```php
// style.css
/*
Template: dronesnaps
*/
@import url("../dronesnaps/style.css");

/* Your custom styles here */
```

## 📄 Page Templates

### Available Templates
- `front-page.php`: Homepage with sections
- `page-services.php`: Services page layout
- `page-contact.php`: Contact form page
- `archive-drone_portfolio.php`: Portfolio archive
- `single-drone_portfolio.php`: Individual portfolio project
- `archive-drone_testimonials.php`: Testimonials archive
- `search.php`: Search results
- `404.php`: Error page

### Creating Custom Pages
1. Use template hierarchy for specific pages
2. Copy and modify existing templates
3. Add custom fields using Advanced Custom Fields (recommended)

## 🔧 Development

### File Structure
```
dronesnaps/
├── style.css                 # Main stylesheet
├── functions.php            # Theme functions
├── index.php               # Main template
├── header.php              # Site header
├── footer.php              # Site footer
├── sidebar.php             # Sidebar template
├── front-page.php          # Homepage
├── page-services.php       # Services page
├── page-contact.php        # Contact page
├── single.php              # Single post
├── archive.php             # Archive pages
├── search.php              # Search results
├── 404.php                 # Error page
├── comments.php            # Comments template
├── js/
│   ├── theme.js           # Main JavaScript
│   ├── lightbox.js        # Gallery lightbox
│   └── contact.js         # Contact form enhancements
├── css/                   # Additional CSS files
├── images/               # Theme images
├── inc/                  # PHP includes
└── templates/            # Template parts
    ├── portfolio-item.php
    ├── testimonial-item.php
    └── social-links.php
```

### Custom Post Types

#### Portfolio Projects
```php
// Custom fields available:
_portfolio_location    // Project location
_portfolio_date       // Project date
_portfolio_client     // Client name
_portfolio_project_type // Type of project
_portfolio_gallery   // Additional images
```

#### Testimonials
```php
// Custom fields available:
_testimonial_client_name    // Client name
_testimonial_client_role    // Client role/title
_testimonial_rating        // Star rating (1-5)
_testimonial_project_date  // Project date
```

### Hooks and Filters
The theme provides several hooks for customization:

```php
// Add custom content to homepage
add_action('dronesnaps_homepage_before_content', 'your_custom_function');

// Modify portfolio query
add_filter('dronesnaps_portfolio_query_args', 'your_filter_function');

// Customize contact form fields
add_filter('dronesnaps_contact_form_fields', 'your_form_fields');
```

## 🎯 SEO Features

### Built-in SEO
- **Schema Markup**: Structured data for business info
- **Meta Tags**: Proper meta descriptions and titles
- **Image Optimization**: Alt tags and responsive images
- **Clean URLs**: SEO-friendly permalink structure
- **Site Speed**: Optimized loading performance

### Recommended Plugins
- **Yoast SEO**: Advanced SEO features
- **Rank Math**: Alternative SEO plugin
- **WP Rocket**: Caching and performance
- **Smush**: Image optimization

## 📱 Responsive Design

### Breakpoints
- **Mobile**: Up to 767px
- **Tablet**: 768px to 1023px
- **Desktop**: 1024px and up
- **Large Desktop**: 1200px and up

### Testing
Test responsive design on:
- Mobile devices (iOS/Android)
- Tablets (iPad, Android tablets)
- Desktop browsers
- Various screen resolutions

## 🔒 Security

### Security Features
- **Nonce Verification**: All forms use WordPress nonces
- **Data Sanitization**: User input is properly sanitized
- **SQL Injection Protection**: Using WordPress database methods
- **XSS Protection**: Output is properly escaped

### Security Plugins
Recommended security plugins:
- **Wordfence**: Comprehensive security
- **Sucuri**: Malware scanning
- **iThemes Security**: Security hardening

## 🚀 Performance

### Optimization Features
- **Lazy Loading**: Images load as needed
- **Minified Assets**: Compressed CSS and JavaScript
- **Optimized Database Queries**: Efficient WordPress queries
- **CDN Ready**: Compatible with content delivery networks

### Performance Testing
Test with:
- Google PageSpeed Insights
- GTmetrix
- Pingdom
- WebPageTest

## 🆘 Troubleshooting

### Common Issues

#### Portfolio Not Displaying
1. Check if custom post type is enabled
2. Verify permalink structure (Settings → Permalinks → Save)
3. Ensure posts are published and have featured images

#### Contact Form Not Working
1. Verify email settings in WordPress
2. Check spam folders for form submissions
3. Test with SMTP plugin if needed

#### Customizer Changes Not Saving
1. Check for plugin conflicts
2. Increase PHP memory limit
3. Verify file permissions

#### Images Not Loading
1. Check file permissions on uploads folder
2. Verify image paths in media library
3. Test with image optimization plugins disabled

### Debug Mode
Enable WordPress debug mode for development:

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## 📞 Support

### Documentation
- WordPress Codex: https://codex.wordpress.org/
- Theme development: https://developer.wordpress.org/themes/

### Community
- WordPress Forums: https://wordpress.org/support/
- Stack Overflow: Tag questions with 'wordpress'

### Updates
The theme follows WordPress coding standards and is regularly updated for:
- WordPress compatibility
- Security patches
- Feature enhancements
- Bug fixes

## 📄 License

This theme is licensed under the GNU General Public License v2 or later.

## 🙏 Credits

### Fonts
- **Roboto**: Google Fonts
- **Montserrat**: Google Fonts

### Icons
- **Font Awesome**: Icon library
- **Custom SVG Icons**: Theme-specific icons

### Images
- Stock photos used for demo purposes only
- Replace with your own photography

### Libraries
- **WordPress**: Core framework
- **jQuery**: JavaScript library (included with WordPress)

---

## 📝 Changelog

### Version 1.0.0
- Initial release
- Complete theme functionality
- Portfolio and testimonials custom post types
- Responsive design
- Contact form integration
- SEO optimization
- Accessibility features

---

**Made with ❤️ for drone photography professionals**
