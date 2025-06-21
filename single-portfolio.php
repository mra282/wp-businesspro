<?php
/**
 * Single portfolio item template
 * 
 * Displays individual portfolio projects
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio'); ?>>
            <!-- Hero Section -->
            <div class="portfolio-hero">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="portfolio-hero-image">
                        <?php the_post_thumbnail('full', array(
                            'alt' => get_the_title(),
                            'class' => 'hero-image'
                        )); ?>
                        <div class="portfolio-hero-overlay">
                            <div class="container">
                                <div class="portfolio-hero-content">
                                    <h1 class="portfolio-title"><?php the_title(); ?></h1>
                                    <?php 
                                    $location = get_post_meta(get_the_ID(), '_portfolio_location', true);
                                    if ($location) : ?>
                                        <p class="portfolio-location">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <?php echo esc_html($location); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="container">
                <div class="portfolio-content-wrapper">
                    <!-- Portfolio Content -->
                    <div class="portfolio-main-content">
                        <!-- Project Details -->
                        <div class="portfolio-details">
                            <div class="portfolio-details-grid">
                                <?php 
                                $project_date = get_post_meta(get_the_ID(), '_portfolio_date', true);
                                $client = get_post_meta(get_the_ID(), '_portfolio_client', true);
                                $project_type = get_post_meta(get_the_ID(), '_portfolio_project_type', true);
                                $location = get_post_meta(get_the_ID(), '_portfolio_location', true);
                                ?>
                                
                                <?php if ($project_date) : ?>
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="detail-content">
                                            <h3>Project Date</h3>
                                            <p><?php echo esc_html(date('F j, Y', strtotime($project_date))); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($client) : ?>
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="detail-content">
                                            <h3>Client</h3>
                                            <p><?php echo esc_html($client); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($project_type) : ?>
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="detail-content">
                                            <h3>Project Type</h3>
                                            <p><?php echo esc_html($project_type); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($location) : ?>
                                    <div class="detail-item">
                                        <div class="detail-icon">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="detail-content">
                                            <h3>Location</h3>
                                            <p><?php echo esc_html($location); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Project Description -->
                        <div class="portfolio-description">
                            <h2>Project Overview</h2>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- Portfolio Gallery -->
                        <?php
                        $gallery_images = get_post_meta(get_the_ID(), '_portfolio_gallery', true);
                        if ($gallery_images) : ?>
                            <div class="portfolio-gallery">
                                <h2>Project Gallery</h2>
                                <div class="gallery-grid">
                                    <?php foreach ($gallery_images as $image_id) : ?>
                                        <div class="gallery-item">
                                            <a href="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>" class="gallery-lightbox" data-lightbox="portfolio-gallery">
                                                <?php echo wp_get_attachment_image($image_id, 'portfolio-thumb', false, array(
                                                    'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                                                    'loading' => 'lazy'
                                                )); ?>
                                                <div class="gallery-overlay">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Project Categories and Tags -->
                        <div class="portfolio-taxonomy">
                            <?php 
                            $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                            if ($categories && !is_wp_error($categories)) : ?>
                                <div class="portfolio-categories">
                                    <h3>Categories</h3>
                                    <div class="taxonomy-terms">
                                        <?php foreach ($categories as $category) : ?>
                                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="taxonomy-term">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Share This Project -->
                        <div class="portfolio-share">
                            <h3>Share This Project</h3>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn facebook" aria-label="Share on Facebook">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" class="share-btn twitter" aria-label="Share on Twitter">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="share-btn linkedin" aria-label="Share on LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <button class="share-btn copy-link" data-url="<?php echo esc_url(get_permalink()); ?>" aria-label="Copy link">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <aside class="portfolio-sidebar">
                        <!-- Contact CTA -->
                        <div class="sidebar-widget contact-cta">
                            <h3>Interested in Similar Work?</h3>
                            <p>Let's discuss how we can create stunning aerial content for your project.</p>
                            <a href="<?php echo esc_url(get_page_link(get_page_by_title('Contact')->ID)); ?>" class="btn btn-primary">Get A Quote</a>
                        </div>

                        <!-- Related Services -->
                        <div class="sidebar-widget related-services">
                            <h3>Our Services</h3>
                            <ul class="services-list">
                                <li><a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>#aerial-photography">Aerial Photography</a></li>
                                <li><a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>#aerial-videography">Aerial Videography</a></li>
                                <li><a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>#real-estate">Real Estate</a></li>
                                <li><a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>#commercial">Commercial Projects</a></li>
                            </ul>
                        </div>

                        <!-- Social Links -->
                        <div class="sidebar-widget social-widget">
                            <h3>Follow Our Work</h3>
                            <?php get_template_part('templates/social-links'); ?>
                        </div>
                    </aside>
                </div>

                <!-- Navigation -->
                <nav class="portfolio-navigation" role="navigation" aria-label="Portfolio navigation">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post(true, '', 'portfolio_category');
                        $next_post = get_next_post(true, '', 'portfolio_category');
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                    <div class="nav-direction">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <polyline points="15,18 9,12 15,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Previous Project
                                    </div>
                                    <h4 class="nav-title"><?php echo esc_html($prev_post->post_title); ?></h4>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="nav-home">
                            <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="btn btn-outline">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="8" y1="21" x2="16" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="17" x2="12" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                All Projects
                            </a>
                        </div>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                    <div class="nav-direction">
                                        Next Project
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <polyline points="9,18 15,12 9,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <h4 class="nav-title"><?php echo esc_html($next_post->post_title); ?></h4>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- Related Projects -->
                <section class="related-projects">
                    <h2>Related Projects</h2>
                    <div class="related-projects-grid">
                        <?php
                        $related_args = array(
                            'post_type' => 'portfolio',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'meta_query' => array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_portfolio_project_type',
                                    'value' => $project_type,
                                    'compare' => '='
                                ),
                                array(
                                    'key' => '_portfolio_location',
                                    'value' => $location,
                                    'compare' => 'LIKE'
                                )
                            )
                        );
                        
                        $related_query = new WP_Query($related_args);
                        
                        if ($related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                                get_template_part('templates/portfolio-item');
                            endwhile;
                            wp_reset_postdata();
                        else :
                            // Fallback to latest projects
                            $fallback_args = array(
                                'post_type' => 'portfolio',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $fallback_query = new WP_Query($fallback_args);
                            
                            if ($fallback_query->have_posts()) :
                                while ($fallback_query->have_posts()) : $fallback_query->the_post();
                                    get_template_part('templates/portfolio-item');
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        endif;
                        ?>
                    </div>
                </section>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
