<?php
/**
 * BusinessPro Theme Functions
 *
 * @package BusinessPro
 * @version 2.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup and configuration
 */
function businesspro_setup() {
    // Add theme support for various WordPress features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-background');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'status',
        'audio',
        'chat'
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
    
    // Enable WordPress menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'businesspro'),
        'footer' => __('Footer Menu', 'businesspro'),
        'footer-services' => __('Footer Services Menu', 'businesspro'),
        'mobile' => __('Mobile Menu', 'businesspro'),
    ));
    
    // Add image sizes
    add_image_size('businesspro-hero', 1920, 1080, true);
    add_image_size('businesspro-portfolio', 600, 400, true);
    add_image_size('businesspro-thumbnail', 300, 200, true);
    add_image_size('businesspro-testimonial', 150, 150, true);
    add_image_size('portfolio-thumb', 400, 300, true);
    add_image_size('hero-image', 1920, 1080, true);
    add_image_size('service-icon', 100, 100, true);
    
    // Load text domain for translations
    load_theme_textdomain('businesspro', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'businesspro_setup');

/**
 * Enqueue scripts and styles
 */
function businesspro_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('businesspro-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap', array(), null);
    
    // Tailwind CSS (CDN)
    wp_enqueue_style('tailwind-css', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), '2.2.19');
    
    // Enqueue theme stylesheet
    wp_enqueue_style('businesspro-style', get_stylesheet_uri(), array('tailwind-css'), wp_get_theme()->get('Version'));
    
    // Enqueue Font Awesome for icons
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Enqueue jQuery (WordPress includes it)
    wp_enqueue_script('jquery');
    
    // Enqueue theme JavaScript
    wp_enqueue_script('businesspro-theme', get_template_directory_uri() . '/js/theme.js', array('jquery'), wp_get_theme()->get('Version'), true);
    
    // Enqueue lightbox script
    wp_enqueue_script('businesspro-lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), wp_get_theme()->get('Version'), true);
    
    // Enqueue contact form enhancements
    wp_enqueue_script('businesspro-contact', get_template_directory_uri() . '/js/contact.js', array('jquery'), wp_get_theme()->get('Version'), true);
    
    // Localize script for AJAX
    wp_localize_script('businesspro-theme', 'businesspro_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('businesspro_nonce'),
    ));
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'businesspro_scripts');

/**
 * Register widget areas
 */
function businesspro_widgets_init() {
    register_sidebar(array(
        'name'          => __('Blog Sidebar', 'businesspro'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your blog sidebar.', 'businesspro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 1', 'businesspro'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in the first footer column.', 'businesspro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 2', 'businesspro'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in the second footer column.', 'businesspro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widget Area 3', 'businesspro'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets here to appear in the third footer column.', 'businesspro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Contact FAQ', 'businesspro'),
        'id'            => 'contact-faq',
        'description'   => __('Add FAQ content for the contact page.', 'businesspro'),
        'before_widget' => '<div id="%1$s" class="widget faq-item %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'businesspro_widgets_init');

/**
 * Custom Post Types
 */
function businesspro_custom_post_types() {
    // Portfolio Post Type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'businesspro'),
            'singular_name' => __('Portfolio Item', 'businesspro'),
            'add_new' => __('Add New Portfolio Item', 'businesspro'),
            'add_new_item' => __('Add New Portfolio Item', 'businesspro'),
            'edit_item' => __('Edit Portfolio Item', 'businesspro'),
            'new_item' => __('New Portfolio Item', 'businesspro'),
            'view_item' => __('View Portfolio Item', 'businesspro'),
            'search_items' => __('Search Portfolio', 'businesspro'),
            'not_found' => __('No portfolio items found', 'businesspro'),
            'not_found_in_trash' => __('No portfolio items found in Trash', 'businesspro'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-camera',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'portfolio'),
    ));
    
    // Testimonials Post Type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'businesspro'),
            'singular_name' => __('Testimonial', 'businesspro'),
            'add_new' => __('Add New Testimonial', 'businesspro'),
            'add_new_item' => __('Add New Testimonial', 'businesspro'),
            'edit_item' => __('Edit Testimonial', 'businesspro'),
            'new_item' => __('New Testimonial', 'businesspro'),
            'view_item' => __('View Testimonial', 'businesspro'),
            'search_items' => __('Search Testimonials', 'businesspro'),
            'not_found' => __('No testimonials found', 'businesspro'),
            'not_found_in_trash' => __('No testimonials found in Trash', 'businesspro'),
        ),
        'public' => true,
        'show_ui' => true,
        'has_archive' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'testimonials'),
    ));
}
add_action('init', 'businesspro_custom_post_types');

/**
 * Register Service Post Type
 */
function businesspro_register_service_post_type() {
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'businesspro'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'businesspro'),
        'menu_name'             => __('Services', 'businesspro'),
        'name_admin_bar'        => __('Service', 'businesspro'),
        'archives'              => __('Service Archives', 'businesspro'),
        'attributes'            => __('Service Attributes', 'businesspro'),
        'parent_item_colon'     => __('Parent Service:', 'businesspro'),
        'all_items'             => __('All Services', 'businesspro'),
        'add_new_item'          => __('Add New Service', 'businesspro'),
        'add_new'               => __('Add New', 'businesspro'),
        'new_item'              => __('New Service', 'businesspro'),
        'edit_item'             => __('Edit Service', 'businesspro'),
        'update_item'           => __('Update Service', 'businesspro'),
        'view_item'             => __('View Service', 'businesspro'),
        'view_items'            => __('View Services', 'businesspro'),
        'search_items'          => __('Search Service', 'businesspro'),
        'not_found'             => __('Not found', 'businesspro'),
        'not_found_in_trash'    => __('Not found in Trash', 'businesspro'),
    );
    
    $args = array(
        'label'                 => __('Service', 'businesspro'),
        'description'           => __('Services offered', 'businesspro'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-admin-tools',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('service', $args);
}
add_action('init', 'businesspro_register_service_post_type', 0);

/**
 * Custom Taxonomies
 */
function businesspro_custom_taxonomies() {
    // Portfolio Categories
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => __('Portfolio Categories', 'businesspro'),
            'singular_name' => __('Portfolio Category', 'businesspro'),
            'search_items' => __('Search Portfolio Categories', 'businesspro'),
            'all_items' => __('All Portfolio Categories', 'businesspro'),
            'edit_item' => __('Edit Portfolio Category', 'businesspro'),
            'update_item' => __('Update Portfolio Category', 'businesspro'),
            'add_new_item' => __('Add New Portfolio Category', 'businesspro'),
            'new_item_name' => __('New Portfolio Category Name', 'businesspro'),
            'menu_name' => __('Categories', 'businesspro'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'businesspro_custom_taxonomies');

/**
 * Customizer Settings
 */
function businesspro_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'businesspro'),
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_title', array(
        'default' => __('Professional Services & Solutions', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'businesspro'),
        'section' => 'hero_section',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => __('Delivering exceptional results for your business with quality service and professional expertise', 'businesspro'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'businesspro'),
        'section' => 'hero_section',
        'type' => 'textarea',
    ));
    
    // Colors
    $wp_customize->add_section('theme_colors', array(
        'title' => __('Theme Colors', 'businesspro'),
        'priority' => 40,
    ));
    
    $wp_customize->add_setting('primary_color', array(
        'default' => '#1e40af',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Primary Color', 'businesspro'),
        'section' => 'theme_colors',
    )));
    
    $wp_customize->add_setting('accent_color', array(
        'default' => '#f97316',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('Accent Color', 'businesspro'),
        'section' => 'theme_colors',
    )));
    
    // Social Media
    $wp_customize->add_section('social_media', array(
        'title' => __('Social Media Links', 'businesspro'),
        'priority' => 50,
    ));
    
    $social_networks = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'youtube' => 'YouTube',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
    );
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('social_' . $network, array(
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('social_' . $network, array(
            'label' => $label . ' ' . __('URL', 'businesspro'),
            'section' => 'social_media',
            'type' => 'url',
        ));
    }
    
    // Hero Images Section
    $wp_customize->add_section('hero_images', array(
        'title' => __('Hero Images', 'businesspro'),
        'priority' => 35,
    ));
    
    // Hero Images
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("hero_image_$i", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_image_$i", array(
            'label' => sprintf(__('Hero Image %d', 'businesspro'), $i),
            'section' => 'hero_images',
            'settings' => "hero_image_$i",
        )));
    }
    
    // Default Services Section
    $wp_customize->add_section('default_services', array(
        'title' => __('Default Services', 'businesspro'),
        'description' => __('These services will show when no custom service posts exist.', 'businesspro'),
        'priority' => 60,
    ));
    
    // Default Services
    for ($i = 1; $i <= 3; $i++) {
        $wp_customize->add_setting("service_{$i}_title", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("service_{$i}_title", array(
            'label' => sprintf(__('Service %d Title', 'businesspro'), $i),
            'section' => 'default_services',
            'type' => 'text',
        ));
        
        $wp_customize->add_setting("service_{$i}_desc", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        
        $wp_customize->add_control("service_{$i}_desc", array(
            'label' => sprintf(__('Service %d Description', 'businesspro'), $i),
            'section' => 'default_services',
            'type' => 'textarea',
        ));
    }
    
    // Services Page CTA Section
    $wp_customize->add_section('services_cta', array(
        'title' => __('Services Page CTA', 'businesspro'),
        'priority' => 65,
    ));
    
    $wp_customize->add_setting('services_cta_title', array(
        'default' => __('Ready to Get Started?', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_cta_title', array(
        'label' => __('CTA Title', 'businesspro'),
        'section' => 'services_cta',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('services_cta_text', array(
        'default' => __('Contact us today for a consultation and personalized quote for your project.', 'businesspro'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('services_cta_text', array(
        'label' => __('CTA Text', 'businesspro'),
        'section' => 'services_cta',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('services_cta_button', array(
        'default' => __('Get Started', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_cta_button', array(
        'label' => __('CTA Button Text', 'businesspro'),
        'section' => 'services_cta',
        'type' => 'text',
    ));
    
    // Testimonials Archive Section
    $wp_customize->add_section('testimonials_archive', array(
        'title' => __('Testimonials Archive', 'businesspro'),
        'priority' => 70,
    ));
    
    $wp_customize->add_setting('testimonials_archive_description', array(
        'default' => __('Read what our clients have to say about their experience working with us.', 'businesspro'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('testimonials_archive_description', array(
        'label' => __('Archive Description', 'businesspro'),
        'section' => 'testimonials_archive',
        'type' => 'textarea',
    ));
    
    // Enhanced About Section Customizer Settings
    $wp_customize->add_section('about_section', array(
        'title'    => __('About Section', 'businesspro'),
        'priority' => 35,
    ));
    
    // About Section Content Source
    $wp_customize->add_setting('about_content_source', array(
        'default'           => 'customizer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_content_source', array(
        'label'   => __('Content Source', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'select',
        'choices' => array(
            'customizer' => __('Use Customizer Content', 'businesspro'),
            'page'       => __('Use WordPress Page Content', 'businesspro'),
        ),
    ));
    
    // About Page Selection
    $wp_customize->add_setting('about_page_id', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('about_page_id', array(
        'label'   => __('Select About Page', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'dropdown-pages',
        'active_callback' => function() {
            return get_theme_mod('about_content_source', 'customizer') === 'page';
        },
    ));
    
    // About Section Image
    $wp_customize->add_setting('about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_image', array(
        'label'   => __('About Section Image', 'businesspro'),
        'section' => 'about_section',
    )));
    
    // About Section Title (for customizer mode)
    $wp_customize->add_setting('about_title', array(
        'default'           => __('About Us', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_title', array(
        'label'   => __('About Section Title', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'text',
        'active_callback' => function() {
            return get_theme_mod('about_content_source', 'customizer') === 'customizer';
        },
    ));
    
    // About Text 1
    $wp_customize->add_setting('about_text_1', array(
        'default' => 'We are passionate professionals dedicated to delivering exceptional results for our clients. With quality equipment and skilled team members, we provide high-quality services while maintaining the highest professional standards.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('about_text_1', array(
        'label' => __('About Text - Paragraph 1', 'businesspro'),
        'section' => 'about_section',
        'type' => 'textarea',
    ));
    
    // About Text 2
    $wp_customize->add_setting('about_text_2', array(
        'default' => 'From business solutions to special projects, we bring your vision to life with creative and professional services.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('about_text_2', array(
        'label' => __('About Text - Paragraph 2', 'businesspro'),
        'section' => 'about_section',
        'type' => 'textarea',
    ));
    
    // Certifications List
    for ($i = 1; $i <= 4; $i++) {
        $defaults = array(
            1 => 'Licensed & Certified Professionals',
            2 => 'Professional Equipment & Technology',
            3 => 'Fully Insured & Licensed',
            4 => 'Fast Turnaround Times'
        );
        
        $wp_customize->add_setting("certification_$i", array(
            'default' => $defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("certification_$i", array(
            'label' => sprintf(__('Certification %d', 'businesspro'), $i),
            'section' => 'about_section',
            'type' => 'text',
        ));
    }
    
    // About Section CTA Settings
    $wp_customize->add_setting('about_cta_text', array(
        'default'           => __('Learn More About Us', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_cta_text', array(
        'label'   => __('About CTA Button Text', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('about_cta_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('about_cta_link', array(
        'label'       => __('About CTA Button Link', 'businesspro'),
        'section'     => 'about_section',
        'type'        => 'url',
        'description' => __('Leave empty to use default /about/ page', 'businesspro'),
    ));
    
    // Services CTA Settings  
    $wp_customize->add_setting('services_cta_show', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('services_cta_show', array(
        'label'   => __('Show Services CTA Button', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'checkbox',
    ));
    
    $wp_customize->add_setting('services_cta_text', array(
        'default'           => __('View All Services', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_cta_text', array(
        'label'   => __('Services CTA Button Text', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'text',
        'active_callback' => function() {
            return get_theme_mod('services_cta_show', true);
        },
    ));
    
    $wp_customize->add_setting('services_cta_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('services_cta_link', array(
        'label'       => __('Services CTA Button Link', 'businesspro'),
        'section'     => 'services_section',
        'type'        => 'url',
        'description' => __('Leave empty to use default /services/ page', 'businesspro'),
        'active_callback' => function() {
            return get_theme_mod('services_cta_show', true);
        },
    ));
    
    // Single-page navigation settings
    $wp_customize->add_section('homepage_sections', array(
        'title'    => __('Homepage Sections', 'businesspro'),
        'priority' => 25,
    ));
    
    // Section order
    $wp_customize->add_setting('section_order', array(
        'default'           => 'hero,about,services,portfolio,testimonials,contact',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('section_order', array(
        'label'       => __('Section Order', 'businesspro'),
        'section'     => 'homepage_sections',
        'type'        => 'text',
        'description' => __('Comma-separated list: hero,about,services,portfolio,testimonials,contact', 'businesspro'),
    ));
    
    // Enable/disable sections
    $sections = array(
        'hero' => __('Hero Section', 'businesspro'),
        'about' => __('About Section', 'businesspro'),
        'services' => __('Services Section', 'businesspro'),
        'portfolio' => __('Portfolio Section', 'businesspro'),
        'testimonials' => __('Testimonials Section', 'businesspro'),
        'contact' => __('Contact Section', 'businesspro'),
    );
    
    foreach ($sections as $section_key => $section_label) {
        $wp_customize->add_setting("enable_section_{$section_key}", array(
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));
        
        $wp_customize->add_control("enable_section_{$section_key}", array(
            'label'   => sprintf(__('Enable %s', 'businesspro'), $section_label),
            'section' => 'homepage_sections',
            'type'    => 'checkbox',
        ));
    }
    
    // Single-page navigation enable/disable
    $wp_customize->add_setting('enable_single_page_nav', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('enable_single_page_nav', array(
        'label'       => __('Enable Single-Page Navigation', 'businesspro'),
        'section'     => 'homepage_sections',
        'type'        => 'checkbox',
        'description' => __('Show section navigation on the front page instead of regular menu', 'businesspro'),
    ));
    
    // Book Now Button Section
    $wp_customize->add_section('book_now_button', array(
        'title'       => __('Book Now Button', 'businesspro'),
        'description' => __('Configure the Book Now button in the header', 'businesspro'),
        'priority'    => 45,
    ));
    
    // Enable/disable Book Now button
    $wp_customize->add_setting('book_now_enable', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('book_now_enable', array(
        'label'   => __('Show Book Now Button', 'businesspro'),
        'section' => 'book_now_button',
        'type'    => 'checkbox',
    ));
    
    // Book Now button text
    $wp_customize->add_setting('book_now_text', array(
        'default'           => __('Book Now', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('book_now_text', array(
        'label'           => __('Button Text', 'businesspro'),
        'section'         => 'book_now_button',
        'type'            => 'text',
        'active_callback' => function() {
            return get_theme_mod('book_now_enable', true);
        },
    ));
    
    // Book Now button link
    $wp_customize->add_setting('book_now_link', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('book_now_link', array(
        'label'           => __('Button Link', 'businesspro'),
        'section'         => 'book_now_button',
        'type'            => 'url',
        'description'     => __('Leave empty to use smart contact navigation (recommended). Or enter a custom URL like mailto:your@email.com, tel:+1234567890, or any page URL.', 'businesspro'),
        'active_callback' => function() {
            return get_theme_mod('book_now_enable', true);
        },
    ));
    
    // Book Now button target
    $wp_customize->add_setting('book_now_target', array(
        'default'           => '_self',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('book_now_target', array(
        'label'           => __('Link Target', 'businesspro'),
        'section'         => 'book_now_button',
        'type'            => 'select',
        'choices'         => array(
            '_self'  => __('Same Window', 'businesspro'),
            '_blank' => __('New Window/Tab', 'businesspro'),
        ),
        'active_callback' => function() {
            return get_theme_mod('book_now_enable', true) && get_theme_mod('book_now_link', '');
        },
    ));
    
    // Book Now button CSS classes
    $wp_customize->add_setting('book_now_classes', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('book_now_classes', array(
        'label'           => __('Additional CSS Classes', 'businesspro'),
        'section'         => 'book_now_button',
        'type'            => 'text',
        'description'     => __('Optional: Add custom CSS classes separated by spaces', 'businesspro'),
        'active_callback' => function() {
            return get_theme_mod('book_now_enable', true);
        },
    ));
}
add_action('customize_register', 'businesspro_customize_register');

/**
 * Custom CSS for customizer colors
 */
function businesspro_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#1e40af');
    $accent_color = get_theme_mod('accent_color', '#f97316');
    
    ?>
    <style type="text/css">
        :root {
            --primary-blue: <?php echo $primary_color; ?>;
            --accent-orange: <?php echo $accent_color; ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'businesspro_customizer_css');

/**
 * Meta boxes for custom fields
 */
function businesspro_add_meta_boxes() {
    // Portfolio meta box
    add_meta_box(
        'portfolio_details',
        __('Portfolio Details', 'businesspro'),
        'businesspro_portfolio_meta_box',
        'portfolio',
        'normal',
        'high'
    );
    
    // Testimonial meta box
    add_meta_box(
        'testimonial_details',
        __('Testimonial Details', 'businesspro'),
        'businesspro_testimonial_meta_box',
        'testimonials',
        'normal',
        'high'
    );
    
    // Service meta box
    add_meta_box(
        'service_details',
        __('Service Details', 'businesspro'),
        'businesspro_service_details_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'businesspro_add_meta_boxes');

/**
 * Portfolio meta box callback
 */
function businesspro_portfolio_meta_box($post) {
    wp_nonce_field('businesspro_portfolio_meta_box', 'businesspro_portfolio_meta_box_nonce');
    
    $location = get_post_meta($post->ID, '_portfolio_location', true);
    $date = get_post_meta($post->ID, '_portfolio_date', true);
    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $project_type = get_post_meta($post->ID, '_portfolio_project_type', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="portfolio_location"><?php _e('Location', 'businesspro'); ?></label></th>
            <td><input type="text" id="portfolio_location" name="portfolio_location" value="<?php echo esc_attr($location); ?>" size="50" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_date"><?php _e('Project Date', 'businesspro'); ?></label></th>
            <td><input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo esc_attr($date); ?>" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_client"><?php _e('Client', 'businesspro'); ?></label></th>
            <td><input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo esc_attr($client); ?>" size="50" /></td>
        </tr>
        <tr>
            <th><label for="portfolio_project_type"><?php _e('Project Type', 'businesspro'); ?></label></th>
            <td>
                <select id="portfolio_project_type" name="portfolio_project_type">
                    <option value="photography" <?php selected($project_type, 'photography'); ?>><?php _e('Photography', 'businesspro'); ?></option>
                    <option value="videography" <?php selected($project_type, 'videography'); ?>><?php _e('Videography', 'businesspro'); ?></option>
                    <option value="real_estate" <?php selected($project_type, 'real_estate'); ?>><?php _e('Real Estate', 'businesspro'); ?></option>
                    <option value="event" <?php selected($project_type, 'event'); ?>><?php _e('Event', 'businesspro'); ?></option>
                    <option value="commercial" <?php selected($project_type, 'commercial'); ?>><?php _e('Commercial', 'businesspro'); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Testimonial meta box callback
 */
function businesspro_testimonial_meta_box($post) {
    wp_nonce_field('businesspro_testimonial_meta_box', 'businesspro_testimonial_meta_box_nonce');
    
    $client_name = get_post_meta($post->ID, '_testimonial_client_name', true);
    $client_role = get_post_meta($post->ID, '_testimonial_client_role', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_client_name"><?php _e('Client Name', 'businesspro'); ?></label></th>
            <td><input type="text" id="testimonial_client_name" name="testimonial_client_name" value="<?php echo esc_attr($client_name); ?>" size="50" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_client_role"><?php _e('Client Role/Company', 'businesspro'); ?></label></th>
            <td><input type="text" id="testimonial_client_role" name="testimonial_client_role" value="<?php echo esc_attr($client_role); ?>" size="50" /></td>
        </tr>
        <tr>
            <th><label for="testimonial_rating"><?php _e('Rating (1-5 stars)', 'businesspro'); ?></label></th>
            <td>
                <select id="testimonial_rating" name="testimonial_rating">
                    <option value="1" <?php selected($rating, '1'); ?>>1 Star</option>
                    <option value="2" <?php selected($rating, '2'); ?>>2 Stars</option>
                    <option value="3" <?php selected($rating, '3'); ?>>3 Stars</option>
                    <option value="4" <?php selected($rating, '4'); ?>>4 Stars</option>
                    <option value="5" <?php selected($rating, '5'); ?>>5 Stars</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Service Details Meta Box Callback
 */
function businesspro_service_details_callback($post) {
    wp_nonce_field('businesspro_service_meta_box', 'businesspro_service_meta_box_nonce');
    
    $featured = get_post_meta($post->ID, '_service_featured', true);
    $icon = get_post_meta($post->ID, '_service_icon', true);
    $svg_icon = get_post_meta($post->ID, '_service_svg_icon', true);
    $features = get_post_meta($post->ID, '_service_features', true);
    $cta_text = get_post_meta($post->ID, '_service_cta_text', true);
    $cta_link = get_post_meta($post->ID, '_service_cta_link', true);
    $show_on_homepage = get_post_meta($post->ID, '_service_show_on_homepage', true);
    
    if (!is_array($features)) $features = array();
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_featured"><?php _e('Featured Service', 'businesspro'); ?></label></th>
            <td><input type="checkbox" id="service_featured" name="service_featured" value="yes" <?php checked($featured, 'yes'); ?> /></td>
        </tr>
        <tr>
            <th><label for="service_show_on_homepage"><?php _e('Show on Homepage', 'businesspro'); ?></label></th>
            <td><input type="checkbox" id="service_show_on_homepage" name="service_show_on_homepage" value="yes" <?php checked($show_on_homepage, 'yes'); ?> /></td>
        </tr>
        <tr>
            <th><label for="service_icon"><?php _e('Icon Class (FontAwesome)', 'businesspro'); ?></label></th>
            <td><input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr($icon); ?>" size="50" placeholder="fas fa-cog" /></td>
        </tr>
        <tr>
            <th><label for="service_svg_icon"><?php _e('Custom SVG Icon', 'businesspro'); ?></label></th>
            <td><textarea id="service_svg_icon" name="service_svg_icon" rows="4" cols="50"><?php echo esc_textarea($svg_icon); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="service_features"><?php _e('Features (one per line)', 'businesspro'); ?></label></th>
            <td><textarea id="service_features" name="service_features" rows="6" cols="50"><?php echo esc_textarea(implode("\n", $features)); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="service_cta_text"><?php _e('CTA Button Text', 'businesspro'); ?></label></th>
            <td><input type="text" id="service_cta_text" name="service_cta_text" value="<?php echo esc_attr($cta_text); ?>" size="50" placeholder="Learn More" /></td>
        </tr>
        <tr>
            <th><label for="service_cta_link"><?php _e('CTA Button Link', 'businesspro'); ?></label></th>
            <td><input type="text" id="service_cta_link" name="service_cta_link" value="<?php echo esc_attr($cta_link); ?>" size="50" placeholder="#contact" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Save meta box data
 */
function businesspro_save_meta_boxes($post_id) {
    // Portfolio meta box
    if (isset($_POST['businesspro_portfolio_meta_box_nonce']) && wp_verify_nonce($_POST['businesspro_portfolio_meta_box_nonce'], 'businesspro_portfolio_meta_box')) {
        if (isset($_POST['portfolio_location'])) {
            update_post_meta($post_id, '_portfolio_location', sanitize_text_field($_POST['portfolio_location']));
        }
        if (isset($_POST['portfolio_date'])) {
            update_post_meta($post_id, '_portfolio_date', sanitize_text_field($_POST['portfolio_date']));
        }
        if (isset($_POST['portfolio_client'])) {
            update_post_meta($post_id, '_portfolio_client', sanitize_text_field($_POST['portfolio_client']));
        }
        if (isset($_POST['portfolio_project_type'])) {
            update_post_meta($post_id, '_portfolio_project_type', sanitize_text_field($_POST['portfolio_project_type']));
        }
    }
    
    // Testimonial meta box
    if (isset($_POST['businesspro_testimonial_meta_box_nonce']) && wp_verify_nonce($_POST['businesspro_testimonial_meta_box_nonce'], 'businesspro_testimonial_meta_box')) {
        if (isset($_POST['testimonial_client_name'])) {
            update_post_meta($post_id, '_testimonial_client_name', sanitize_text_field($_POST['testimonial_client_name']));
        }
        if (isset($_POST['testimonial_client_role'])) {
            update_post_meta($post_id, '_testimonial_client_role', sanitize_text_field($_POST['testimonial_client_role']));
        }
        if (isset($_POST['testimonial_rating'])) {
            update_post_meta($post_id, '_testimonial_rating', sanitize_text_field($_POST['testimonial_rating']));
        }
    }
    
    // Service meta box
    if (isset($_POST['businesspro_service_meta_box_nonce']) && wp_verify_nonce($_POST['businesspro_service_meta_box_nonce'], 'businesspro_service_meta_box')) {
        $featured = isset($_POST['service_featured']) ? 'yes' : 'no';
        update_post_meta($post_id, '_service_featured', $featured);
        
        $show_on_homepage = isset($_POST['service_show_on_homepage']) ? 'yes' : 'no';
        update_post_meta($post_id, '_service_show_on_homepage', $show_on_homepage);
        
        if (isset($_POST['service_icon'])) {
            update_post_meta($post_id, '_service_icon', sanitize_text_field($_POST['service_icon']));
        }
        
        if (isset($_POST['service_svg_icon'])) {
            update_post_meta($post_id, '_service_svg_icon', wp_kses_post($_POST['service_svg_icon']));
        }
        
        if (isset($_POST['service_features'])) {
            $features = array_filter(array_map('trim', explode("\n", $_POST['service_features'])));
            update_post_meta($post_id, '_service_features', $features);
        }
        
        if (isset($_POST['service_cta_text'])) {
            update_post_meta($post_id, '_service_cta_text', sanitize_text_field($_POST['service_cta_text']));
        }
        
        if (isset($_POST['service_cta_link'])) {
            update_post_meta($post_id, '_service_cta_link', esc_url_raw($_POST['service_cta_link']));
        }
    }
}
add_action('save_post', 'businesspro_save_meta_boxes');

/**
 * Handle Contact Form Submission
 */
function businesspro_handle_contact_form() {
    // Check if form was submitted
    if (!isset($_POST['businesspro_contact_nonce']) || !wp_verify_nonce($_POST['businesspro_contact_nonce'], 'businesspro_contact_form')) {
        wp_die(__('Security check failed', 'businesspro'));
    }
    
    // Sanitize form data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone'] ?? '');
    $service = sanitize_text_field($_POST['contact_service'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }
    
    // Prepare email content
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission - BusinessPro';
    
    $email_message = "New contact form submission from BusinessPro website:\n\n";
    $email_message .= "Name: " . $name . "\n";
    $email_message .= "Email: " . $email . "\n";
    if (!empty($phone)) {
        $email_message .= "Phone: " . $phone . "\n";
    }
    if (!empty($service)) {
        $email_message .= "Service Type: " . $service . "\n";
    }
    $email_message .= "\nMessage:\n" . $message . "\n\n";
    $email_message .= "---\n";
    $email_message .= "This message was sent from " . get_bloginfo('name') . " (" . home_url() . ")";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email
    $mail_sent = wp_mail($to, $subject, $email_message, $headers);
    
    // Store submission in database (optional)
    $submission_data = array(
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'service' => $service,
        'message' => $message,
        'submitted_at' => current_time('mysql'),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? ''
    );
    
    // You could store this in a custom table or as post meta
    // For now, we'll just send the email
    
    if ($mail_sent) {
        wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_businesspro_contact_form', 'businesspro_handle_contact_form');
add_action('admin_post_nopriv_businesspro_contact_form', 'businesspro_handle_contact_form');

/**
 * Display Contact Form Messages
 */
function businesspro_contact_form_messages() {
    if (isset($_GET['contact'])) {
        if ($_GET['contact'] === 'success') {
            echo '<div class="contact-message success">
                    <p><strong>Thank you!</strong> Your message has been sent successfully. We\'ll get back to you soon.</p>
                  </div>';
        } elseif ($_GET['contact'] === 'error') {
            echo '<div class="contact-message error">
                    <p><strong>Error:</strong> There was a problem sending your message. Please try again.</p>
                  </div>';
        }
    }
}

/**
 * AJAX Portfolio Filter
 */
function businesspro_ajax_portfolio_filter() {
    check_ajax_referer('portfolio_filter_nonce', 'nonce');
    
    $category = sanitize_text_field($_POST['category']);
    $page = intval($_POST['page']);
    $posts_per_page = get_option('posts_per_page', 6);
    
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'post_status' => 'publish'
    );
    
    if ($category && $category !== '*') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field' => 'slug',
                'terms' => $category
            )
        );
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('templates/portfolio-item');
        endwhile;
    endif;
    
    $html = ob_get_clean();
    
    wp_send_json_success(array(
        'html' => $html,
        'max_pages' => $query->max_num_pages,
        'current_page' => $page
    ));
    
    wp_reset_postdata();
}
add_action('wp_ajax_portfolio_filter', 'businesspro_ajax_portfolio_filter');
add_action('wp_ajax_nopriv_portfolio_filter', 'businesspro_ajax_portfolio_filter');

/**
 * Add Contact Form Customizer Settings
 */
function businesspro_contact_customizer($wp_customize) {
    // Contact Section
    $wp_customize->add_section('contact_info', array(
        'title' => __('Contact Information', 'businesspro'),
        'priority' => 35,
    ));
    
    // Contact Phone
    $wp_customize->add_setting('contact_phone', array(
        'default' => '(555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label' => __('Phone Number', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    // Contact Email
    $wp_customize->add_setting('contact_email', array(
        'default' => 'info@businesspro.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label' => __('Email Address', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'email',
    ));
    
    // Contact Address
    $wp_customize->add_setting('contact_address', array(
        'default' => 'Your City, State',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label' => __('Business Address', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    // Business Hours
    $wp_customize->add_setting('business_hours', array(
        'default' => 'Monday - Friday: 9:00 AM - 5:00 PM',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('business_hours', array(
        'label' => __('Business Hours', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'textarea',
    ));
    
    // Business Certifications
    $wp_customize->add_setting('business_certifications', array(
        'default' => 'Licensed & Insured',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('business_certifications', array(
        'label' => __('Business Certifications', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'textarea',
    ));
    
    // About Section
    $wp_customize->add_section('about_section', array(
        'title' => __('About Section', 'businesspro'),
        'priority' => 36,
    ));
    
    // About Section Content Source
    $wp_customize->add_setting('about_content_source', array(
        'default'           => 'customizer',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_content_source', array(
        'label'   => __('Content Source', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'select',
        'choices' => array(
            'customizer' => __('Use Customizer Content', 'businesspro'),
            'page'       => __('Use WordPress Page Content', 'businesspro'),
        ),
    ));
    
    // About Page Selection
    $wp_customize->add_setting('about_page_id', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('about_page_id', array(
        'label'   => __('Select About Page', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'dropdown-pages',
        'active_callback' => function() {
            return get_theme_mod('about_content_source', 'customizer') === 'page';
        },
    ));
    
    // About Section Image
    $wp_customize->add_setting('about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'about_image', array(
        'label'   => __('About Section Image', 'businesspro'),
        'section' => 'about_section',
    )));
    
    // About Section Title (for customizer mode)
    $wp_customize->add_setting('about_title', array(
        'default'           => __('About Us', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_title', array(
        'label'   => __('About Section Title', 'businesspro'),
        'section' => 'about_section',
        'type'    => 'text',
        'active_callback' => function() {
            return get_theme_mod('about_content_source', 'customizer') === 'customizer';
        },
    ));
    
    // About Text 1
    $wp_customize->add_setting('about_text_1', array(
        'default' => 'We are passionate professionals dedicated to delivering exceptional results for our clients. With quality equipment and skilled team members, we provide high-quality services while maintaining the highest professional standards.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('about_text_1', array(
        'label' => __('About Text - Paragraph 1', 'businesspro'),
        'section' => 'about_section',
        'type' => 'textarea',
    ));
    
    // About Text 2
    $wp_customize->add_setting('about_text_2', array(
        'default' => 'From business solutions to special projects, we bring your vision to life with creative and professional services.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('about_text_2', array(
        'label' => __('About Text - Paragraph 2', 'businesspro'),
        'section' => 'about_section',
        'type' => 'textarea',
    ));
    
    // Certifications List
    for ($i = 1; $i <= 4; $i++) {
        $defaults = array(
            1 => 'Licensed & Certified Professionals',
            2 => 'Professional Equipment & Technology',
            3 => 'Fully Insured & Licensed',
            4 => 'Fast Turnaround Times'
        );
        
        $wp_customize->add_setting("certification_$i", array(
            'default' => $defaults[$i],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control("certification_$i", array(
            'label' => sprintf(__('Certification %d', 'businesspro'), $i),
            'section' => 'about_section',
            'type' => 'text',
        ));
    }
    
    // Service Areas Section
    $wp_customize->add_setting('service_areas_text', array(
        'default' => 'We provide services throughout the local area and surrounding regions.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('service_areas_text', array(
        'label' => __('Service Areas Description', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'textarea',
    ));
    
    $wp_customize->add_setting('service_areas_list', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('service_areas_list', array(
        'label' => __('Service Areas (one per line)', 'businesspro'),
        'description' => __('List your service areas, one per line. Leave empty to hide the list.', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'textarea',
    ));
    
    // Additional address fields for schema markup
    $wp_customize->add_setting('address_city', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('address_city', array(
        'label' => __('City', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('address_state', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('address_state', array(
        'label' => __('State/Province', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('address_zip', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('address_zip', array(
        'label' => __('ZIP/Postal Code', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('address_country', array(
        'default' => 'US',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('address_country', array(
        'label' => __('Country', 'businesspro'),
        'section' => 'contact_info',
        'type' => 'text',
    ));
    
    // Enhanced Services Section Management
    $wp_customize->add_section('services_section', array(
        'title'    => __('Services Section', 'businesspro'),
        'priority' => 36,
    ));
    
    // Services Display Mode
    $wp_customize->add_setting('services_display_mode', array(
        'default'           => 'post_type',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_display_mode', array(
        'label'   => __('Services Display Mode', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'select',
        'choices' => array(
            'post_type' => __('Use Service Posts (Recommended)', 'businesspro'),
            'customizer' => __('Use Customizer Content', 'businesspro'),
            'page' => __('Use WordPress Page Content', 'businesspro'),
        ),
    ));
    
    // Services Page Selection
    $wp_customize->add_setting('services_page_id', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('services_page_id', array(
        'label'   => __('Select Services Page', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'dropdown-pages',
        'active_callback' => function() {
            return get_theme_mod('services_display_mode', 'post_type') === 'page';
        },
    ));
    
    // Services Section Title
    $wp_customize->add_setting('services_section_title', array(
        'default'           => __('Our Services', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_section_title', array(
        'label'   => __('Services Section Title', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'text',
    ));
    
    // Services Section Subtitle
    $wp_customize->add_setting('services_section_subtitle', array(
        'default'           => __('Professional services tailored to your specific needs', 'businesspro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('services_section_subtitle', array(
        'label'   => __('Services Section Subtitle', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'text',
    ));
    
    // Services per row
    $wp_customize->add_setting('services_per_row', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('services_per_row', array(
        'label'   => __('Services Per Row', 'businesspro'),
        'section' => 'services_section',
        'type'    => 'select',
        'choices' => array(
            2 => __('2 Services Per Row', 'businesspro'),
            3 => __('3 Services Per Row', 'businesspro'),
            4 => __('4 Services Per Row', 'businesspro'),
        ),
        'active_callback' => function() {
            return get_theme_mod('services_display_mode', 'post_type') === 'post_type';
        },
    ));
    
    // Number of services to display
    $wp_customize->add_setting('services_to_display', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('services_to_display', array(
        'label'       => __('Number of Services to Display', 'businesspro'),
        'section'     => 'services_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
        ),
        'active_callback' => function() {
            return get_theme_mod('services_display_mode', 'post_type') === 'post_type';
        },
    ));
    
    // Contact Form Enhancement
    $wp_customize->add_section('contact_form_section', array(
        'title'    => __('Contact Form', 'businesspro'),
        'priority' => 37,
    ));
    
    // Contact Form Type
    $wp_customize->add_setting('contact_form_type', array(
        'default'           => 'built_in',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_form_type', array(
        'label'   => __('Contact Form Type', 'businesspro'),
        'section' => 'contact_form_section',
        'type'    => 'select',
        'choices' => array(
            'built_in' => __('Built-in Contact Form', 'businesspro'),
            'cf7' => __('Contact Form 7 (if installed)', 'businesspro'),
            'shortcode' => __('Custom Shortcode', 'businesspro'),
        ),
    ));
    
    // Contact Form 7 ID
    $wp_customize->add_setting('cf7_form_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('cf7_form_id', array(
        'label'       => __('Contact Form 7 ID', 'businesspro'),
        'section'     => 'contact_form_section',
        'type'        => 'text',
        'description' => __('Enter the Contact Form 7 ID number', 'businesspro'),
        'active_callback' => function() {
            return get_theme_mod('contact_form_type', 'built_in') === 'cf7';
        },
    ));
    
    // Custom Shortcode
    $wp_customize->add_setting('contact_form_shortcode', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_form_shortcode', array(
        'label'       => __('Contact Form Shortcode', 'businesspro'),
        'section'     => 'contact_form_section',
        'type'        => 'text',
        'description' => __('Enter the complete shortcode for your form', 'businesspro'),
        'active_callback' => function() {
            return get_theme_mod('contact_form_type', 'built_in') === 'shortcode';
        },
    ));
}
add_action('customize_register', 'businesspro_contact_customizer');

/**
 * Add Single-Page Navigation Support
 */
function businesspro_add_single_page_nav_support() {
    // Add sections management to customizer
    global $wp_customize;
    
    if (!isset($wp_customize)) {
        return;
    }
    
    $wp_customize->add_section('homepage_sections', array(
        'title'    => __('Homepage Sections', 'businesspro'),
        'priority' => 25,
    ));
    
    // Section order
    $wp_customize->add_setting('section_order', array(
        'default'           => 'hero,about,services,portfolio,testimonials,contact',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('section_order', array(
        'label'       => __('Section Order', 'businesspro'),
        'section'     => 'homepage_sections',
        'type'        => 'text',
        'description' => __('Comma-separated list: hero,about,services,portfolio,testimonials,contact', 'businesspro'),
    ));
    
    // Enable/disable sections
    $sections = array(
        'hero' => __('Hero Section', 'businesspro'),
        'about' => __('About Section', 'businesspro'),
        'services' => __('Services Section', 'businesspro'),
        'portfolio' => __('Portfolio Section', 'businesspro'),
        'testimonials' => __('Testimonials Section', 'businesspro'),
        'contact' => __('Contact Section', 'businesspro'),
    );
    
    foreach ($sections as $section_key => $section_label) {
        $wp_customize->add_setting("enable_section_{$section_key}", array(
            'default'           => true,
            'sanitize_callback' => 'rest_sanitize_boolean',
        ));
        
        $wp_customize->add_control("enable_section_{$section_key}", array(
            'label'   => sprintf(__('Enable %s', 'businesspro'), $section_label),
            'section' => 'homepage_sections',
            'type'    => 'checkbox',
        ));
    }
    
    // Single-page navigation enable/disable
    $wp_customize->add_setting('enable_single_page_nav', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('enable_single_page_nav', array(
        'label'       => __('Enable Single-Page Navigation', 'businesspro'),
        'section'     => 'homepage_sections',
        'type'        => 'checkbox',
        'description' => __('Show section navigation on the front page instead of regular menu', 'businesspro'),
    ));
}
add_action('customize_register', 'businesspro_add_single_page_nav_support');

/**
 * Get Active Homepage Sections
 */
function businesspro_get_active_sections() {
    $section_order = get_theme_mod('section_order', 'hero,about,services,portfolio,testimonials,contact');
    $sections = explode(',', $section_order);
    $active_sections = array();
    
    foreach ($sections as $section) {
        $section = trim($section);
        if (get_theme_mod("enable_section_{$section}", true)) {
            $active_sections[] = $section;
        }
    }
    
    return $active_sections;
}

/**
 * Generate Section Navigation
 */
function businesspro_render_section_navigation() {
    $active_sections = businesspro_get_active_sections();
    
    if (count($active_sections) <= 1) {
        return '';
    }
    
    $section_labels = array(
        'hero' => __('Home', 'businesspro'),
        'about' => __('About', 'businesspro'),
        'services' => __('Services', 'businesspro'),
        'portfolio' => __('Portfolio', 'businesspro'),
        'testimonials' => __('Testimonials', 'businesspro'),
        'contact' => __('Contact', 'businesspro'),
    );
    
    ob_start();
    ?>
    <nav class="single-page-nav" aria-label="<?php esc_attr_e('Page sections', 'businesspro'); ?>">
        <ul class="section-nav-list">
            <?php foreach ($active_sections as $section) : ?>
                <?php if (isset($section_labels[$section])) : ?>
                <li>
                    <a href="#<?php echo esc_attr($section); ?>" class="section-nav-link" data-section="<?php echo esc_attr($section); ?>">
                        <?php echo esc_html($section_labels[$section]); ?>
                    </a>
                </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
    return ob_get_clean();
}

/**
 * Custom menu walker for enhanced menu styling
 */
class BusinessPro_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Start the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add current menu item class
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'current';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
        $attributes .= ! empty($item->url) ? ' href="'   . esc_attr($item->url) .'"' : '';
        
        $item_output = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * End the element output.
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Add admin notice for menu setup
 */
function businesspro_admin_menu_notice() {
    $screen = get_current_screen();
    
    // Only show on dashboard and menu pages
    if (!in_array($screen->id, array('dashboard', 'nav-menus'))) {
        return;
    }
    
    $primary_menu = has_nav_menu('primary');
    $footer_menu = has_nav_menu('footer');
    
    if (!$primary_menu || !$footer_menu) {
        $missing_menus = array();
        if (!$primary_menu) $missing_menus[] = __('Primary Menu', 'businesspro');
        if (!$footer_menu) $missing_menus[] = __('Footer Menu', 'businesspro');
        
        $message = sprintf(
            __('Your BusinessPro theme is missing some menu assignments: %s. Please <a href="%s">assign menus</a> to these locations for the best experience.', 'businesspro'),
            implode(', ', $missing_menus),
            admin_url('nav-menus.php')
        );
        
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p>' . $message . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'businesspro_admin_menu_notice');

/**
 * Customize menu item classes for better styling
 */
function businesspro_nav_menu_css_class($classes, $item, $args) {
    // Add icon support for menu items (check for ACF or use native WordPress meta)
    $icon = '';
    if (function_exists('get_field')) {
        // Use ACF if available
        $icon = get_field('menu_icon', $item->ID);
    } else {
        // Fallback to native WordPress meta
        $icon = get_post_meta($item->ID, 'menu_icon', true);
    }
    
    if ($icon) {
        $classes[] = 'has-icon';
        $classes[] = 'icon-' . sanitize_html_class($icon);
    }
    
    // Add special class for CTA menu items
    if (in_array('menu-item-cta', $classes)) {
        $classes[] = 'menu-cta';
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'businesspro_nav_menu_css_class', 10, 3);

/**
 * Add menu descriptions support
 */
function businesspro_nav_menu_item_title($title, $item, $args, $depth) {
    if ($item->description && $depth === 0) {
        $title .= '<span class="menu-description">' . esc_html($item->description) . '</span>';
    }
    return $title;
}
add_filter('nav_menu_item_title', 'businesspro_nav_menu_item_title', 10, 4);

/**
 * Get social media links
 */
function businesspro_get_social_links() {
    $social_links = array();
    
    $facebook_url = get_theme_mod('facebook_url', '');
    if (!empty($facebook_url)) {
        $social_links['facebook'] = array(
            'url' => $facebook_url,
            'label' => __('Facebook', 'businesspro'),
            'icon' => 'fab fa-facebook-f'
        );
    }
    
    $instagram_url = get_theme_mod('instagram_url', '');
    if (!empty($instagram_url)) {
        $social_links['instagram'] = array(
            'url' => $instagram_url,
            'label' => __('Instagram', 'businesspro'),
            'icon' => 'fab fa-instagram'
        );
    }
    
    $youtube_url = get_theme_mod('youtube_url', '');
    if (!empty($youtube_url)) {
        $social_links['youtube'] = array(
            'url' => $youtube_url,
            'label' => __('YouTube', 'businesspro'),
            'icon' => 'fab fa-youtube'
        );
    }
    
    return $social_links;
}

/**
 * Add schema markup for SEO
 */
function businesspro_add_schema_markup() {
    if (is_front_page()) {
        ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "<?php bloginfo('name'); ?>",
            "description": "<?php bloginfo('description'); ?>",
            "url": "<?php echo home_url(); ?>",
            "telephone": "",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "",
                "addressLocality": "",
                "addressRegion": "",
                "postalCode": "",
                "addressCountry": ""
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": "",
                "longitude": ""
            },
            "sameAs": [
                <?php
                $social_links = businesspro_get_social_links();
                $urls = array();
                foreach ($social_links as $link) {
                    $urls[] = '"' . $link['url'] . '"';
                }
                echo implode(',', $urls);
                ?>
            ]
        }
        </script>
        <?php
    }
}
add_action('wp_head', 'businesspro_add_schema_markup');

/**
 * Add theme support for Gutenberg
 */
function businesspro_gutenberg_support() {
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'businesspro_gutenberg_support');

/**
 * Add ping to WordPress.org
 */
if (!function_exists('businesspro_pingback_header')) {
    function businesspro_pingback_header() {
        if (is_singular() && pings_open()) {
            printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
        }
    }
    add_action('wp_head', 'businesspro_pingback_header');
}

/**
 * Get About Section Content
 */
function businesspro_get_about_content() {
    $content_source = get_theme_mod('about_content_source', 'customizer');
    
    if ($content_source === 'page') {
        $page_id = get_theme_mod('about_page_id', 0);
        if ($page_id) {
            $page = get_post($page_id);
            if ($page && $page->post_status === 'publish') {
                return array(
                    'title' => $page->post_title,
                    'content' => apply_filters('the_content', $page->post_content),
                    'excerpt' => $page->post_excerpt,
                );
            }
        }
    }
    
    // Fallback to customizer content
    return array(
        'title' => get_theme_mod('about_title', __('About Us', 'businesspro')),
        'content' => get_theme_mod('about_text_1', __('We are passionate professionals dedicated to delivering exceptional results for our clients. With quality equipment and skilled team members, we provide high-quality services while maintaining the highest professional standards.', 'businesspro')) . 
                    '<br><br>' . 
                    get_theme_mod('about_text_2', __('From business solutions to special projects, we bring your vision to life with creative and professional services.', 'businesspro')),
        'excerpt' => '',
    );
}

/**
 * Get Services for Display
 */
function businesspro_get_services_for_display() {
    $display_mode = get_theme_mod('services_display_mode', 'post_type');
    $services = array();
    
    if ($display_mode === 'post_type') {
        $services_query = new WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => get_theme_mod('services_to_display', 6),
            'post_status' => 'publish',
            'meta_key' => '_service_show_on_homepage',
            'meta_value' => 'yes',
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        
        if ($services_query->have_posts()) {
            while ($services_query->have_posts()) {
                $services_query->the_post();
                $services[] = array(
                    'title' => get_the_title(),
                    'content' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 20),
                    'icon' => get_post_meta(get_the_ID(), '_service_icon', true) ?: 'fas fa-briefcase',
                    'link' => get_permalink(),
                    'cta_text' => get_post_meta(get_the_ID(), '_service_cta_text', true) ?: __('Learn More', 'businesspro'),
                );
            }
            wp_reset_postdata();
        }
        
        // If no services found, show default services
        if (empty($services)) {
            $services = businesspro_get_default_services();
        }
    } elseif ($display_mode === 'page') {
        $page_id = get_theme_mod('services_page_id', 0);
        if ($page_id) {
            $page = get_post($page_id);
            if ($page && $page->post_status === 'publish') {
                $services[] = array(
                    'title' => $page->post_title,
                    'content' => apply_filters('the_content', $page->post_content),
                    'icon' => 'fas fa-list',
                    'link' => get_permalink($page_id),
                    'cta_text' => __('View All Services', 'businesspro'),
                );
            }
        }
    } else {
        // Customizer mode - use existing default services
        $services = businesspro_get_default_services();
    }
    
    return $services;
}

/**
 * Get Default Services (fallback)
 */
function businesspro_get_default_services() {
    return array(
        array(
            'title' => get_theme_mod('service_1_title', __('Professional Photography', 'businesspro')),
            'content' => get_theme_mod('service_1_description', __('High-quality photography services for businesses, events, and marketing materials.', 'businesspro')),
            'icon' => get_theme_mod('service_1_icon', 'fas fa-camera'),
            'link' => get_theme_mod('service_1_link', home_url('/services/')),
            'cta_text' => __('Learn More', 'businesspro'),
        ),
        array(
            'title' => get_theme_mod('service_2_title', __('Professional Videography', 'businesspro')),
            'content' => get_theme_mod('service_2_description', __('Professional video services for commercials, documentaries, and promotional content.', 'businesspro')),
            'icon' => get_theme_mod('service_2_icon', 'fas fa-video'),
            'link' => get_theme_mod('service_2_link', home_url('/services/')),
            'cta_text' => __('Learn More', 'businesspro'),
        ),
        array(
            'title' => get_theme_mod('service_3_title', __('Real Estate', 'businesspro')),
            'content' => get_theme_mod('service_3_description', __('Professional services to showcase properties and increase market appeal.', 'businesspro')),
            'icon' => get_theme_mod('service_3_icon', 'fas fa-home'),
            'link' => get_theme_mod('service_3_link', home_url('/services/')),
            'cta_text' => __('Learn More', 'businesspro'),
        ),
    );
}

/**
 * Render Contact Form Based on Settings
 */
function businesspro_render_contact_form() {
    $form_type = get_theme_mod('contact_form_type', 'built_in');
    
    switch ($form_type) {
        case 'cf7':
            $cf7_id = get_theme_mod('cf7_form_id', '');
            if ($cf7_id && function_exists('wpcf7_enqueue_scripts')) {
                return do_shortcode("[contact-form-7 id=\"{$cf7_id}\"]");
            }
            break;
            
        case 'shortcode':
            $shortcode = get_theme_mod('contact_form_shortcode', '');
            if ($shortcode) {
                return do_shortcode($shortcode);
            }
            break;
    }
    
    // Default built-in form
    return businesspro_render_built_in_contact_form();
}

/**
 * Render Built-in Contact Form
 */
function businesspro_render_built_in_contact_form() {
    ob_start();
    ?>
    <form class="businesspro-contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <?php wp_nonce_field('businesspro_contact_form', 'businesspro_contact_nonce'); ?>
        <input type="hidden" name="action" value="businesspro_contact_form">
        
        <div class="form-group">
            <label for="contact-name"><?php esc_html_e('Your Name', 'businesspro'); ?> *</label>
            <input type="text" id="contact-name" name="contact_name" required>
        </div>
        
        <div class="form-group">
            <label for="contact-email"><?php esc_html_e('Email Address', 'businesspro'); ?> *</label>
            <input type="email" id="contact-email" name="contact_email" required>
        </div>
        
        <div class="form-group">
            <label for="contact-phone"><?php esc_html_e('Phone Number', 'businesspro'); ?></label>
            <input type="tel" id="contact-phone" name="contact_phone">
        </div>
        
        <div class="form-group">
            <label for="project-type"><?php esc_html_e('Project Type', 'businesspro'); ?></label>
            <select id="project-type" name="contact_service">
                <option value=""><?php esc_html_e('Select a service', 'businesspro'); ?></option>
                <option value="aerial-photography"><?php esc_html_e('Aerial Photography', 'businesspro'); ?></option>
                <option value="video-production"><?php esc_html_e('Video Production', 'businesspro'); ?></option>
                <option value="real-estate"><?php esc_html_e('Real Estate', 'businesspro'); ?></option>
                <option value="commercial"><?php esc_html_e('Commercial Projects', 'businesspro'); ?></option>
                <option value="events"><?php esc_html_e('Events & Weddings', 'businesspro'); ?></option>
                <option value="other"><?php esc_html_e('Other', 'businesspro'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="contact-message"><?php esc_html_e('Project Details', 'businesspro'); ?></label>
            <textarea id="contact-message" name="contact_message" rows="5" placeholder="<?php esc_attr_e('Tell us about your project...', 'businesspro'); ?>"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary"><?php esc_html_e('Send Message', 'businesspro'); ?></button>
    </form>
    <?php
    return ob_get_clean();
}

/**
 * Add Menu Icon Meta Box (Native WordPress Alternative to ACF)
 */
function businesspro_add_menu_icon_meta_box() {
    add_meta_box(
        'menu-icon-meta-box',
        __('Menu Icon', 'businesspro'),
        'businesspro_menu_icon_meta_box_callback',
        'nav_menu_item',
        'side',
        'default'
    );
}
add_action('add_meta_boxes_nav_menu_item', 'businesspro_add_menu_icon_meta_box');

/**
 * Menu Icon Meta Box Callback
 */
function businesspro_menu_icon_meta_box_callback($post) {
    wp_nonce_field('save_menu_icon_meta', 'menu_icon_meta_nonce');
    $icon = get_post_meta($post->ID, 'menu_icon', true);
    ?>
    <p>
        <label for="menu_icon"><?php esc_html_e('Icon Class (FontAwesome)', 'businesspro'); ?></label><br>
        <input type="text" id="menu_icon" name="menu_icon" value="<?php echo esc_attr($icon); ?>" style="width: 100%;" placeholder="e.g., fas fa-home">
        <small><?php esc_html_e('Enter FontAwesome icon class (optional)', 'businesspro'); ?></small>
    </p>
    <?php
}

/**
 * Save Menu Icon Meta
 */
function businesspro_save_menu_icon_meta($post_id) {
    if (!isset($_POST['menu_icon_meta_nonce']) || !wp_verify_nonce($_POST['menu_icon_meta_nonce'], 'save_menu_icon_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['menu_icon'])) {
        update_post_meta($post_id, 'menu_icon', sanitize_text_field($_POST['menu_icon']));
    }
}
add_action('save_post', 'businesspro_save_menu_icon_meta');

/**
 * Ensure Compatibility with Different WordPress Environments
 */
function businesspro_check_dependencies() {
    // Check if we're in admin and show notices for missing plugins
    if (is_admin() && current_user_can('manage_options')) {
        // Optional: Show admin notice about ACF compatibility
        if (!function_exists('get_field')) {
            add_action('admin_notices', function() {
                echo '<div class="notice notice-info is-dismissible">';
                echo '<p><strong>BusinessPro Theme:</strong> ' . esc_html__('Advanced Custom Fields (ACF) plugin is not active. The theme will work fine without it, but you won\'t have advanced menu icon options.', 'businesspro') . '</p>';
                echo '</div>';
            });
        }
    }
}
add_action('init', 'businesspro_check_dependencies');

/**
 * Include demo content importer
 */
if (file_exists(get_template_directory() . '/inc/demo-content.php')) {
    require_once get_template_directory() . '/inc/demo-content.php';
}

/**
 * Get smart contact link that works on all pages
 * 
 * @param string $fallback_link Optional fallback link
 * @return string Contact link URL
 */
function businesspro_get_contact_link($fallback_link = '') {
    if (is_front_page()) {
        // On homepage, link to contact section
        return '#contact';
    } else {
        // On other pages, link to contact page or back to homepage contact
        $contact_page = get_page_by_path('contact');
        if ($contact_page) {
            return get_permalink($contact_page);
        } elseif (!empty($fallback_link)) {
            return $fallback_link;
        } else {
            return home_url('/#contact');
        }
    }
}

/**
 * Get Book Now button configuration
 * 
 * @return array Button configuration array
 */
function businesspro_get_book_now_config() {
    $config = array(
        'enabled'  => get_theme_mod('book_now_enable', true),
        'text'     => get_theme_mod('book_now_text', __('Book Now', 'businesspro')),
        'link'     => get_theme_mod('book_now_link', ''),
        'target'   => get_theme_mod('book_now_target', '_self'),
        'classes'  => get_theme_mod('book_now_classes', ''),
    );
    
    // If no custom link is set, use smart contact navigation
    if (empty($config['link'])) {
        $config['link'] = businesspro_get_contact_link();
        $config['target'] = '_self'; // Always same window for internal navigation
    }
    
    return $config;
}

/**
 * Theme functions end here
 */
