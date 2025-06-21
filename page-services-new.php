<?php
/**
 * Template Name: Services Page
 * 
 * @package BusinessPro
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <div class="page-description">
                        <?php if (get_the_content()) : ?>
                            <?php the_content(); ?>
                        <?php else : ?>
                            <p><?php esc_html_e('Explore our professional services designed to meet your specific needs.', 'businesspro'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section services-section">
        <div class="container">
            <div class="services-grid">
                <?php
                // Display services dynamically - check for custom post type first, then fallback to customizer
                $services_query = new WP_Query(array(
                    'post_type' => 'service',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                if ($services_query->have_posts()) :
                    while ($services_query->have_posts()) : $services_query->the_post();
                        $is_featured = get_post_meta(get_the_ID(), '_service_featured', true);
                        $icon = get_post_meta(get_the_ID(), '_service_icon', true) ?: 'fas fa-cog';
                        $features = get_post_meta(get_the_ID(), '_service_features', true);
                        $cta_text = get_post_meta(get_the_ID(), '_service_cta_text', true) ?: __('Learn More', 'businesspro');
                        $cta_link = get_post_meta(get_the_ID(), '_service_cta_link', true) ?: '#contact';
                        ?>
                        <div class="service-card <?php echo $is_featured ? 'featured' : ''; ?>">
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                            </div>
                            <h3 class="service-title"><?php the_title(); ?></h3>
                            <div class="service-description">
                                <?php the_content(); ?>
                            </div>
                            <?php if ($features && is_array($features)) : ?>
                                <ul class="service-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <li><i class="fas fa-check"></i> <?php echo esc_html($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <a href="<?php echo esc_url($cta_link); ?>" class="btn <?php echo $is_featured ? 'btn-primary' : 'btn-outline'; ?>">
                                <?php echo esc_html($cta_text); ?>
                            </a>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback: Show notice for admin to create services
                    if (current_user_can('edit_theme_options')) :
                        ?>
                        <div class="no-content-notice">
                            <div class="notice-content">
                                <h3><?php esc_html_e('No Services Found', 'businesspro'); ?></h3>
                                <p><?php esc_html_e('Create service posts to display your offerings here. You can also add content widgets in the sidebar.', 'businesspro'); ?></p>
                                <div class="notice-actions">
                                    <a href="<?php echo admin_url('post-new.php?post_type=service'); ?>" class="btn btn-primary">
                                        <?php esc_html_e('Add Service', 'businesspro'); ?>
                                    </a>
                                    <a href="<?php echo admin_url('customize.php'); ?>" class="btn btn-outline">
                                        <?php esc_html_e('Customize Theme', 'businesspro'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    else :
                        // Show generic message for visitors when no services exist
                        ?>
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-cog" aria-hidden="true"></i>
                            </div>
                            <h3 class="service-title"><?php esc_html_e('Professional Services', 'businesspro'); ?></h3>
                            <div class="service-description">
                                <p><?php esc_html_e('We offer a comprehensive range of professional services designed to meet your unique needs. Each project is tailored to deliver exceptional results with attention to detail and quality.', 'businesspro'); ?></p>
                            </div>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="btn btn-primary">
                                <?php esc_html_e('Contact Us', 'businesspro'); ?>
                            </a>
                        </div>
                        <?php
                    endif;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Additional Content Area -->
    <?php if (is_active_sidebar('services-content')) : ?>
        <section class="section services-additional-content">
            <div class="container">
                <?php dynamic_sidebar('services-content'); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Contact CTA -->
    <?php 
    $cta_title = get_theme_mod('services_cta_title', __('Ready to Get Started?', 'businesspro'));
    $cta_text = get_theme_mod('services_cta_text', __('Contact us today for a consultation and personalized quote for your project.', 'businesspro'));
    $cta_button_text = get_theme_mod('services_cta_button', __('Get Started', 'businesspro'));
    $contact_page = get_page_by_path('contact');
    $cta_link = $contact_page ? get_permalink($contact_page) : '#contact';
    ?>
    <section class="section cta-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2><?php echo esc_html($cta_title); ?></h2>
                <p><?php echo esc_html($cta_text); ?></p>
                <a href="<?php echo esc_url($cta_link); ?>" class="btn btn-secondary btn-large">
                    <?php echo esc_html($cta_button_text); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>
