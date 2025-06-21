<?php
/**
 * Front Page Template
 *
 * @package BusinessPro
 */

get_header();

// Get active sections from customizer
$active_sections = businesspro_get_active_sections();
?>

<main id="primary" class="site-main">
    
    <?php if (in_array('hero', $active_sections)) : ?>
    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-slider">
            <?php
            // Get hero images from customizer or use defaults
            $hero_images = array();
            for ($i = 1; $i <= 5; $i++) {
                $image = get_theme_mod("hero_image_$i", '');
                if ($image) {
                    $hero_images[] = $image;
                }
            }
            
            // If no custom images, use generic placeholder or leave empty for CSS background
            if (empty($hero_images)) {
                $hero_images = array(
                    get_theme_mod('hero_default_bg', '')
                );
            }
            
            foreach ($hero_images as $index => $image_url) :
                if ($image_url) :
                    ?>
                    <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                        <div class="hero-overlay"></div>
                    </div>
                    <?php
                endif;
            endforeach;
            
            // If no images at all, show a gradient background
            if (empty(array_filter($hero_images))) :
                ?>
                <div class="hero-slide active hero-slide-gradient">
                    <div class="hero-overlay"></div>
                </div>
                <?php
            endif;
            ?>
        </div>
        <div class="hero-background"></div>
        <div class="hero-content">
            <h1 class="hero-title">
                <?php echo esc_html(get_theme_mod('hero_title', __('Professional Services & Solutions', 'businesspro'))); ?>
            </h1>
            <p class="hero-subtitle">
                <?php echo esc_html(get_theme_mod('hero_subtitle', __('Delivering exceptional results for your business and professional projects', 'businesspro'))); ?>
            </p>
            <div class="hero-cta">
                <a href="#portfolio" class="btn btn-primary"><?php esc_html_e('View Portfolio', 'businesspro'); ?></a>
                <a href="#contact" class="btn btn-outline"><?php esc_html_e('Get Quote', 'businesspro'); ?></a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (in_array('about', $active_sections)) : ?>
    <!-- About Section -->
    <section class="section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <?php
                    $about_content = businesspro_get_about_content();
                    ?>
                    <h2><?php echo esc_html($about_content['title']); ?></h2>
                    
                    <?php if (get_theme_mod('about_content_source', 'customizer') === 'page') : ?>
                        <div class="about-content">
                            <?php echo wp_kses_post($about_content['content']); ?>
                        </div>
                    <?php else : ?>
                        <p><?php echo wp_kses_post(get_theme_mod('about_text_1', __('We are passionate professionals specializing in delivering exceptional results for our clients. With professional equipment and skilled expertise, we deliver high-quality services while maintaining the highest standards.', 'businesspro'))); ?></p>
                        <p><?php echo wp_kses_post(get_theme_mod('about_text_2', __('From commercial projects to special events, we bring your vision to life with creative and professional solutions.', 'businesspro'))); ?></p>
                        
                        <ul class="about-features">
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo esc_html(get_theme_mod('certification_1', __('Licensed & Certified Professionals', 'businesspro'))); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo esc_html(get_theme_mod('certification_2', __('Professional Equipment & Technology', 'businesspro'))); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo esc_html(get_theme_mod('certification_3', __('Fully Insured & Licensed', 'businesspro'))); ?></li>
                            <li><i class="fas fa-check" aria-hidden="true"></i> <?php echo esc_html(get_theme_mod('certification_4', __('Fast Turnaround Times', 'businesspro'))); ?></li>
                        </ul>
                    <?php endif; ?>
                    
                    <?php
                    $about_cta_text = get_theme_mod('about_cta_text', __('Learn More About Us', 'businesspro'));
                    $about_cta_link = get_theme_mod('about_cta_link', home_url('/about/'));
                    if ($about_cta_text && $about_cta_link) :
                    ?>
                    <a href="<?php echo esc_url($about_cta_link); ?>" class="btn btn-primary"><?php echo esc_html($about_cta_text); ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <?php
                    $about_image = get_theme_mod('about_image', '');
                    if ($about_image) :
                    ?>
                        <img src="<?php echo esc_url($about_image); ?>" 
                             alt="<?php esc_attr_e('About us', 'businesspro'); ?>" 
                             class="about-image">
                    <?php else : ?>
                        <img src="https://placehold.co/400x600" 
                             alt="<?php esc_attr_e('Professional at work', 'businesspro'); ?>" 
                             class="about-image">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (in_array('services', $active_sections)) : ?>
    <!-- Services Section -->
    <section class="section" id="services">
        <div class="container">
            <div class="text-center mb-3">
                <h2><?php echo esc_html(get_theme_mod('services_section_title', __('Our Services', 'businesspro'))); ?></h2>
                <p><?php echo esc_html(get_theme_mod('services_section_subtitle', __('Professional services tailored to your specific needs', 'businesspro'))); ?></p>
            </div>
            
            <?php
            $services = businesspro_get_services_for_display();
            $services_per_row = get_theme_mod('services_per_row', 3);
            $display_mode = get_theme_mod('services_display_mode', 'post_type');
            
            if (!empty($services)) :
                if ($display_mode === 'page') :
                    // Single page content mode
                    ?>
                    <div class="services-page-content">
                        <?php foreach ($services as $service) : ?>
                            <div class="service-page-item">
                                <h3><?php echo esc_html($service['title']); ?></h3>
                                <div class="service-page-content">
                                    <?php echo wp_kses_post($service['content']); ?>
                                </div>
                                <a href="<?php echo esc_url($service['link']); ?>" class="btn btn-primary">
                                    <?php echo esc_html($service['cta_text']); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                else :
                    // Grid mode for post type and customizer
                    ?>
                    <div class="services-grid services-grid-<?php echo esc_attr($services_per_row); ?>">
                        <?php foreach ($services as $service) : ?>
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="<?php echo esc_attr($service['icon']); ?>" aria-hidden="true"></i>
                                </div>
                                <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                                <p><?php echo esc_html($service['content']); ?></p>
                                <a href="<?php echo esc_url($service['link']); ?>" class="btn btn-outline">
                                    <?php echo esc_html($service['cta_text']); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                endif;
            else :
                // No services found - show admin notice or fallback
                ?>
                <div class="no-services-message">
                    <?php if (current_user_can('edit_posts')) : ?>
                        <p><?php esc_html_e('No services configured yet. Please add services or configure them in the customizer.', 'businesspro'); ?></p>
                        <div class="services-admin-actions">
                            <a href="<?php echo admin_url('edit.php?post_type=service'); ?>" class="btn btn-primary">
                                <?php esc_html_e('Add Services', 'businesspro'); ?>
                            </a>
                            <a href="<?php echo admin_url('customize.php?autofocus[section]=services_section'); ?>" class="btn btn-outline">
                                <?php esc_html_e('Configure Services', 'businesspro'); ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <p><?php esc_html_e('Services coming soon.', 'businesspro'); ?></p>
                    <?php endif; ?>
                </div>
                <?php
            endif;
            ?>
            
            <?php
            // Show "View All Services" link if we have more services
            $total_services = wp_count_posts('service')->publish ?? 0;
            $services_displayed = count($services);
            if ($total_services > $services_displayed || get_theme_mod('services_cta_show', true)) :
            ?>
            <div class="text-center mt-3">
                <a href="<?php echo esc_url(get_theme_mod('services_cta_link', home_url('/services/'))); ?>" class="btn btn-primary">
                    <?php echo esc_html(get_theme_mod('services_cta_text', __('View All Services', 'businesspro'))); ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (in_array('portfolio', $active_sections)) : ?>
    <!-- Portfolio Section -->
    <section class="section portfolio-section" id="portfolio">
        <div class="container">
            <div class="text-center mb-3">
                <h2><?php esc_html_e('Our Portfolio', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Explore our impressive collection of professional work and projects', 'businesspro'); ?></p>
            </div>
            
            <div class="portfolio-filters">
                <button class="filter-btn active" data-filter="all"><?php esc_html_e('All', 'businesspro'); ?></button>
                <button class="filter-btn" data-filter="photography"><?php esc_html_e('Photography', 'businesspro'); ?></button>
                <button class="filter-btn" data-filter="videography"><?php esc_html_e('Videography', 'businesspro'); ?></button>
                <button class="filter-btn" data-filter="real_estate"><?php esc_html_e('Real Estate', 'businesspro'); ?></button>
                <button class="filter-btn" data-filter="events"><?php esc_html_e('Events', 'businesspro'); ?></button>
            </div>
            
            <div class="portfolio-grid" id="portfolio-grid">
                <?php
                $portfolio_args = array(
                    'post_type' => 'portfolio',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                );
                
                $portfolio_query = new WP_Query($portfolio_args);
                
                if ($portfolio_query->have_posts()) :
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        get_template_part('templates/portfolio-item');
                    endwhile;
                    wp_reset_postdata();
                else :
                    // No portfolio items to display - encourage admin to add them
                    ?>
                    <div class="no-portfolio-message">
                        <p><?php esc_html_e('No portfolio items available yet. Add your professional projects to showcase your work.', 'businesspro'); ?></p>
                        <?php if (current_user_can('edit_posts')) : ?>
                            <a href="<?php echo admin_url('edit.php?post_type=portfolio'); ?>" class="btn btn-primary">
                                <?php esc_html_e('Add Portfolio Items', 'businesspro'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>
            
            <div class="text-center mt-3">
                <a href="<?php echo esc_url(home_url('/portfolio/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('View Full Portfolio', 'businesspro'); ?>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (in_array('testimonials', $active_sections)) : ?>
    <!-- Testimonials Section -->
    <section class="section testimonials-section" id="testimonials">
        <div class="container">
            <div class="text-center mb-3">
                <h2><?php esc_html_e('What Our Clients Say', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Hear from satisfied customers who chose BusinessPro for their professional service needs', 'businesspro'); ?></p>
            </div>
            
            <div class="testimonials-slider">
                <?php
                $testimonials_args = array(
                    'post_type' => 'testimonials',
                    'posts_per_page' => 5,
                    'post_status' => 'publish',
                );
                
                $testimonials_query = new WP_Query($testimonials_args);
                
                if ($testimonials_query->have_posts()) :
                    $count = 0;
                    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        get_template_part('templates/testimonial-item');
                        $count++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    // No testimonials to display - encourage admin to add them
                    ?>
                    <div class="no-testimonials-message">
                        <p><?php esc_html_e('No testimonials available yet. Add client testimonials in the WordPress admin to showcase your work.', 'businesspro'); ?></p>
                        <?php if (current_user_can('edit_posts')) : ?>
                            <a href="<?php echo admin_url('edit.php?post_type=testimonials'); ?>" class="btn btn-primary">
                                <?php esc_html_e('Add Testimonials', 'businesspro'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php
                endif;
                ?>
                
                <div class="testimonial-nav">
                    <span class="nav-dot active"></span>
                    <span class="nav-dot"></span>
                    <span class="nav-dot"></span>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if (in_array('contact', $active_sections)) : ?>
    <!-- Contact Section -->
    <section class="section" id="contact">
        <div class="container">
            <div class="text-center mb-3">
                <h2><?php esc_html_e('Get Your Free Quote', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Ready to elevate your project? Contact us today for a personalized quote.', 'businesspro'); ?></p>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <div class="contact-form">
                        <?php echo businesspro_render_contact_form(); ?>
                        
                        <?php
                        // Show success/error messages
                        if (isset($_GET['contact'])) {
                            if ($_GET['contact'] === 'success') {
                                echo '<div class="contact-message contact-success">' . esc_html__('Thank you! Your message has been sent successfully.', 'businesspro') . '</div>';
                            } elseif ($_GET['contact'] === 'error') {
                                echo '<div class="contact-message contact-error">' . esc_html__('Sorry, there was an error sending your message. Please try again.', 'businesspro') . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="contact-info">
                        <h3><?php esc_html_e('Contact Information', 'businesspro'); ?></h3>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4><?php esc_html_e('Email Us', 'businesspro'); ?></h4>
                                <p><a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', get_option('admin_email'))); ?>"><?php echo esc_html(get_theme_mod('contact_email', get_option('admin_email'))); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4><?php esc_html_e('Call Us', 'businesspro'); ?></h4>
                                <p><a href="tel:<?php echo esc_attr(str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('contact_phone', '(555) 123-4567'))); ?>"><?php echo esc_html(get_theme_mod('contact_phone', '(555) 123-4567')); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4><?php esc_html_e('Business Hours', 'businesspro'); ?></h4>
                                <p><?php echo wp_kses_post(get_theme_mod('business_hours', __('Monday - Friday: 9:00 AM - 5:00 PM', 'businesspro'))); ?></p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-certificate"></i>
                            <div>
                                <h4><?php esc_html_e('Certifications', 'businesspro'); ?></h4>
                                <p><?php echo wp_kses_post(get_theme_mod('business_certifications', __('Licensed & Insured', 'businesspro'))); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main><!-- #main -->

<?php
get_footer();
?>
