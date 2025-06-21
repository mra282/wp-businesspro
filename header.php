<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
    
    <!-- Schema.org markup for business -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?php bloginfo('name'); ?>",
        "description": "<?php bloginfo('description'); ?>",
        "url": "<?php echo home_url(); ?>",
        "telephone": "<?php echo esc_js(get_theme_mod('contact_phone', '')); ?>",
        "email": "<?php echo esc_js(get_theme_mod('contact_email', get_option('admin_email'))); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo esc_js(get_theme_mod('contact_address', '')); ?>",
            "addressLocality": "<?php echo esc_js(get_theme_mod('address_city', '')); ?>",
            "addressRegion": "<?php echo esc_js(get_theme_mod('address_state', '')); ?>",
            "postalCode": "<?php echo esc_js(get_theme_mod('address_zip', '')); ?>",
            "addressCountry": "<?php echo esc_js(get_theme_mod('address_country', 'US')); ?>"
        },
        "openingHours": "<?php echo esc_js(strip_tags(get_theme_mod('business_hours', ''))); ?>",
        "sameAs": [
            <?php
            $social_links = array();
            $social_networks = array('facebook', 'instagram', 'youtube', 'twitter', 'linkedin');
            foreach ($social_networks as $network) {
                $url = get_theme_mod('social_' . $network, '');
                if (!empty($url)) {
                    $social_links[] = '"' . esc_js($url) . '"';
                }
            }
            echo implode(',', $social_links);
            ?>
        ]
    }
    </script>
    
    <style>
        :root {
            --primary-color: <?php echo get_theme_mod('primary_color', '#1e3a8a'); ?>;
            --accent-color: <?php echo get_theme_mod('accent_color', '#fb923c'); ?>;
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="sr-only" href="#primary"><?php esc_html_e('Skip to content', 'businesspro'); ?></a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Main Navigation', 'businesspro'); ?>">
                    <?php
                    // Show single-page navigation on front page, regular menu elsewhere
                    if (is_front_page() && get_theme_mod('enable_single_page_nav', true)) {
                        echo businesspro_render_section_navigation();
                    } elseif (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'nav-menu',
                            'container'      => false,
                            'depth'          => 2,
                            'walker'         => new BusinessPro_Menu_Walker(),
                        ));
                    } else {
                        echo '<div class="no-menu-notice">' . esc_html__('Please assign a menu to the Primary Menu location.', 'businesspro') . '</div>';
                    }
                    ?>
                </nav><!-- #site-navigation -->
                
                <div class="header-mobile-actions">
                    <a href="#contact" class="btn btn-secondary book-now-btn" aria-label="<?php esc_attr_e('Book Now', 'businesspro'); ?>">
                        <?php esc_html_e('Book Now', 'businesspro'); ?>
                    </a>
                    
                    <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'businesspro'); ?>">
                        <i class="fas fa-bars" aria-hidden="true"></i>
                        <span class="sr-only"><?php esc_html_e('Menu', 'businesspro'); ?></span>
                    </button>
                </div>
            </div><!-- .header-content -->
        </div><!-- .container -->
    </header><!-- #masthead -->
