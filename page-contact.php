<?php
/**
 * Template Name: Contact Page
 * 
 * The contact page template for BusinessPro theme
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('contact-page'); ?>>
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if (get_the_content()) : ?>
                        <div class="page-description">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="contact-content">
                    <div class="contact-grid">
                        <!-- Contact Form Section -->
                        <div class="contact-form-section">
                            <h2>Get In Touch</h2>
                            <p>Ready to work with professionals? Let's discuss your project and create something amazing together.</p>
                            
                            <form id="contact-form" class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <?php wp_nonce_field('businesspro_contact_form', 'contact_nonce'); ?>
                                <input type="hidden" name="action" value="businesspro_contact_form">
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact-name">Name *</label>
                                        <input type="text" id="contact-name" name="contact_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-email">Email *</label>
                                        <input type="email" id="contact-email" name="contact_email" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="contact-phone">Phone</label>
                                        <input type="tel" id="contact-phone" name="contact_phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact-service">Service Type</label>
                                        <select id="contact-service" name="contact_service">
                                            <option value="">Select a service</option>
                                            <option value="professional-photography">Professional Photography</option>
                                            <option value="professional-videography">Professional Videography</option>
                                            <option value="real-estate">Real Estate Photography</option>
                                            <option value="commercial">Commercial Projects</option>
                                            <option value="wedding">Wedding Photography</option>
                                            <option value="inspection">Inspection Services</option>
                                            <option value="mapping">Mapping & Surveying</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact-location">Project Location</label>
                                    <input type="text" id="contact-location" name="contact_location" placeholder="Where will the shoot take place?">
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact-date">Preferred Date</label>
                                    <input type="date" id="contact-date" name="contact_date">
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact-budget">Budget Range</label>
                                    <select id="contact-budget" name="contact_budget">
                                        <option value="">Select budget range</option>
                                        <option value="under-500">Under $500</option>
                                        <option value="500-1000">$500 - $1,000</option>
                                        <option value="1000-2500">$1,000 - $2,500</option>
                                        <option value="2500-5000">$2,500 - $5,000</option>
                                        <option value="5000-plus">$5,000+</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="contact-message">Project Details *</label>
                                    <textarea id="contact-message" name="contact_message" rows="6" placeholder="Tell us about your project, specific requirements, and any questions you have..." required></textarea>
                                </div>
                                
                                <div class="form-group checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="contact_consent" required>
                                        <span class="checkmark"></span>
                                        I agree to the <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" target="_blank">privacy policy</a> and consent to being contacted about my inquiry. *
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <span class="btn-text">Send Message</span>
                                    <span class="btn-loading" style="display: none;">Sending...</span>
                                </button>
                            </form>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="contact-info-section">
                            <h2>Contact Information</h2>
                            
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h3>Location</h3>
                                    <p><?php echo get_theme_mod('contact_address', 'Your City, State'); ?></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h3>Phone</h3>
                                    <p><a href="tel:<?php echo esc_attr(str_replace(array(' ', '(', ')', '-'), '', get_theme_mod('contact_phone', '(555) 123-4567'))); ?>"><?php echo get_theme_mod('contact_phone', '(555) 123-4567'); ?></a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h3>Email</h3>
                                    <p><a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', get_option('admin_email'))); ?>"><?php echo get_theme_mod('contact_email', get_option('admin_email')); ?></a></p>
                                </div>
                            </div>
                            
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="12,6 12,12 16,14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="contact-details">
                                    <h3>Business Hours</h3>
                                    <p><?php echo wp_kses_post(get_theme_mod('business_hours', 'Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: By appointment')); ?></p>
                                </div>
                            </div>

                            <!-- Social Media Links -->
                            <div class="contact-social">
                                <h3>Follow Us</h3>
                                <?php get_template_part('templates/social-links'); ?>
                            </div>

                            <!-- Service Areas -->
                            <div class="service-areas">
                                <h3>Service Areas</h3>
                                <p><?php echo wp_kses_post(get_theme_mod('service_areas_text', __('We provide services throughout the local area and surrounding regions.', 'businesspro'))); ?></p>
                                <?php 
                                $service_areas = get_theme_mod('service_areas_list', '');
                                if ($service_areas) : 
                                    $areas = explode("\n", $service_areas);
                                ?>
                                <ul>
                                    <?php foreach ($areas as $area) : 
                                        $area = trim($area);
                                        if (!empty($area)) : ?>
                                        <li><?php echo esc_html($area); ?></li>
                                    <?php endif; endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="contact-faq">
                        <h2>Frequently Asked Questions</h2>
                        <div class="faq-grid">
                            <?php
                            // Check if user has added custom FAQ content via widgets or pages
                            if (is_active_sidebar('contact-faq')) {
                                dynamic_sidebar('contact-faq');
                            } else {
                                // Show instruction to add FAQs instead of hardcoded content
                                if (current_user_can('edit_posts')) {
                                    echo '<div class="faq-placeholder">';
                                    echo '<p>' . __('Add FAQ content by creating a page with your frequently asked questions, or add content to the Contact FAQ widget area.', 'businesspro') . '</p>';
                                    echo '<a href="' . admin_url('post-new.php?post_type=page') . '" class="btn btn-primary">' . __('Create FAQ Page', 'businesspro') . '</a>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
