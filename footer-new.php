<?php
/**
 * The template for displaying the footer
 *
 * @package BusinessPro
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php bloginfo('name'); ?></h3>
                    <p><?php bloginfo('description'); ?></p>
                    
                    <?php
                    // Get social links from customizer
                    $social_networks = array(
                        'facebook' => array(
                            'url' => get_theme_mod('social_facebook', ''),
                            'icon' => 'fab fa-facebook-f',
                            'label' => __('Facebook', 'businesspro')
                        ),
                        'instagram' => array(
                            'url' => get_theme_mod('social_instagram', ''),
                            'icon' => 'fab fa-instagram',
                            'label' => __('Instagram', 'businesspro')
                        ),
                        'youtube' => array(
                            'url' => get_theme_mod('social_youtube', ''),
                            'icon' => 'fab fa-youtube',
                            'label' => __('YouTube', 'businesspro')
                        ),
                        'twitter' => array(
                            'url' => get_theme_mod('social_twitter', ''),
                            'icon' => 'fab fa-twitter',
                            'label' => __('Twitter', 'businesspro')
                        ),
                        'linkedin' => array(
                            'url' => get_theme_mod('social_linkedin', ''),
                            'icon' => 'fab fa-linkedin-in',
                            'label' => __('LinkedIn', 'businesspro')
                        )
                    );
                    
                    // Filter out empty social links
                    $active_social_links = array_filter($social_networks, function($social) {
                        return !empty($social['url']);
                    });
                    
                    if (!empty($active_social_links)) :
                    ?>
                    <div class="footer-social">
                        <h4><?php esc_html_e('Follow Us', 'businesspro'); ?></h4>
                        <div class="social-links">
                            <?php foreach ($active_social_links as $network => $link) : ?>
                                <a href="<?php echo esc_url($link['url']); ?>" 
                                   class="social-link social-link-<?php echo esc_attr($network); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   aria-label="<?php printf(esc_attr__('Follow us on %s', 'businesspro'), $link['label']); ?>">
                                    <i class="<?php echo esc_attr($link['icon']); ?>" aria-hidden="true"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Quick Links', 'businesspro'); ?></h3>
                    <?php
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                    } else {
                        // Show default links if no menu is assigned
                        ?>
                        <ul class="footer-menu">
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><?php esc_html_e('About', 'businesspro'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'businesspro'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/portfolio/')); ?>"><?php esc_html_e('Portfolio', 'businesspro'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'businesspro'); ?></a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Services', 'businesspro'); ?></h3>
                    <?php
                    if (has_nav_menu('footer-services')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer-services',
                            'menu_class'     => 'footer-services-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                    } else {
                        // Show services from custom post type or default services
                        $services_query = new WP_Query(array(
                            'post_type' => 'service',
                            'posts_per_page' => 5,
                            'post_status' => 'publish',
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        ));
                        
                        if ($services_query->have_posts()) :
                            ?>
                            <ul class="footer-services-menu">
                                <?php while ($services_query->have_posts()) : $services_query->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            </ul>
                            <?php
                            wp_reset_postdata();
                        else :
                            // Default services
                            ?>
                            <ul class="footer-services-menu">
                                <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php echo esc_html(get_theme_mod('service_1_title', __('Professional Services', 'businesspro'))); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php echo esc_html(get_theme_mod('service_2_title', __('Creative Solutions', 'businesspro'))); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/services/')); ?>"><?php echo esc_html(get_theme_mod('service_3_title', __('Expert Consultation', 'businesspro'))); ?></a></li>
                            </ul>
                            <?php
                        endif;
                    }
                    ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Contact Info', 'businesspro'); ?></h3>
                    <?php if (get_theme_mod('contact_email', get_option('admin_email'))) : ?>
                    <p>
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', get_option('admin_email'))); ?>">
                            <?php echo esc_html(get_theme_mod('contact_email', get_option('admin_email'))); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('contact_phone')) : ?>
                    <p>
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <a href="tel:<?php echo esc_attr(str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('contact_phone'))); ?>">
                            <?php echo esc_html(get_theme_mod('contact_phone')); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('contact_address')) : ?>
                    <p>
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <?php echo esc_html(get_theme_mod('contact_address')); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if (get_theme_mod('business_hours')) : ?>
                    <p>
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        <?php echo wp_kses_post(get_theme_mod('business_hours')); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div><!-- .footer-content -->
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'businesspro'); ?></p>
                    </div>
                    <div class="footer-links">
                        <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'businesspro'); ?></a>
                        <a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>"><?php esc_html_e('Terms of Service', 'businesspro'); ?></a>
                    </div>
                </div>
            </div><!-- .footer-bottom -->
        </div><!-- .container -->

        <!-- Scroll to top button -->
        <button id="scroll-to-top" class="scroll-to-top" aria-label="<?php esc_attr_e('Scroll to top', 'businesspro'); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 19V5M5 12L12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
