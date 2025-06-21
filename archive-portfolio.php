<?php
/**
 * Archive template for drone portfolio
 * 
 * Displays portfolio items with filtering and pagination
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php 
                if (is_post_type_archive('portfolio')) {
                    echo 'Our Portfolio';
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            <div class="archive-description">
                <?php 
                if (is_post_type_archive('portfolio')) {
                    echo '<p>Explore our collection of stunning aerial photography and videography projects. Each image tells a unique story from above.</p>';
                } else {
                    the_archive_description();
                }
                ?>
            </div>
        </header>

        <!-- Portfolio Filter Navigation -->
        <div class="portfolio-filters" role="navigation" aria-label="Portfolio filters">
            <button class="filter-btn active" data-filter="*" aria-pressed="true">
                All Projects
            </button>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'portfolio_category',
                'hide_empty' => true,
            ));
            
            if (!is_wp_error($categories) && !empty($categories)) :
                foreach ($categories as $category) : ?>
                    <button class="filter-btn" data-filter=".<?php echo esc_attr($category->slug); ?>" aria-pressed="false">
                        <?php echo esc_html($category->name); ?>
                    </button>
                <?php endforeach;
            endif; ?>
        </div>

        <!-- Portfolio Grid -->
        <div id="portfolio-grid" class="portfolio-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    // Get portfolio categories for filtering
                    $portfolio_cats = get_the_terms(get_the_ID(), 'portfolio_category');
                    $cat_classes = '';
                    if ($portfolio_cats && !is_wp_error($portfolio_cats)) {
                        $cat_slugs = array();
                        foreach ($portfolio_cats as $cat) {
                            $cat_slugs[] = $cat->slug;
                        }
                        $cat_classes = implode(' ', $cat_slugs);
                    }
                    ?>
                    <article class="portfolio-item <?php echo esc_attr($cat_classes); ?>" data-aos="fade-up">
                        <div class="portfolio-item-inner">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="portfolio-image">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail('portfolio-thumb', array(
                                            'alt' => get_the_title(),
                                            'loading' => 'lazy'
                                        )); ?>
                                        <div class="portfolio-overlay">
                                            <div class="portfolio-overlay-content">
                                                <h3><?php the_title(); ?></h3>
                                                <?php 
                                                $location = get_post_meta(get_the_ID(), '_portfolio_location', true);
                                                if ($location) : ?>
                                                    <p class="portfolio-location">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <?php echo esc_html($location); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <div class="portfolio-actions">
                                                    <a href="<?php the_permalink(); ?>" class="btn-view" aria-label="View project details">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                    <?php if (has_post_thumbnail()) : ?>
                                                        <button class="btn-lightbox" data-src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" aria-label="View in lightbox">
                                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="portfolio-content">
                                <h3 class="portfolio-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="portfolio-meta">
                                    <?php 
                                    $project_date = get_post_meta(get_the_ID(), '_portfolio_date', true);
                                    $client = get_post_meta(get_the_ID(), '_portfolio_client', true);
                                    $project_type = get_post_meta(get_the_ID(), '_portfolio_project_type', true);
                                    ?>
                                    
                                    <?php if ($project_date) : ?>
                                        <span class="portfolio-date">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <?php echo esc_html(date('M Y', strtotime($project_date))); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if ($project_type) : ?>
                                        <span class="portfolio-type">
                                            <?php echo esc_html($project_type); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (has_excerpt()) : ?>
                                    <div class="portfolio-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Portfolio Categories -->
                                <?php if ($portfolio_cats && !is_wp_error($portfolio_cats)) : ?>
                                    <div class="portfolio-categories">
                                        <?php foreach ($portfolio_cats as $cat) : ?>
                                            <span class="portfolio-category"><?php echo esc_html($cat->name); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-portfolio-items">
                    <h2>No Portfolio Items Found</h2>
                    <p>We're currently updating our portfolio. Please check back soon to see our latest work!</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Return Home</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More Button (for AJAX pagination) -->
        <?php if (have_posts()) : ?>
            <div class="portfolio-pagination">
                <?php
                global $wp_query;
                if ($wp_query->max_num_pages > 1) : ?>
                    <button id="load-more-portfolio" class="btn btn-outline" data-page="1" data-max="<?php echo $wp_query->max_num_pages; ?>">
                        <span class="btn-text">Load More Projects</span>
                        <span class="btn-loading" style="display: none;">Loading...</span>
                    </button>
                <?php endif; ?>
                
                <!-- Standard Pagination Fallback -->
                <div class="portfolio-pagination-fallback">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Previous', 'businesspro'),
                        'next_text' => __('Next →', 'businesspro'),
                    ));
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Portfolio Stats -->
        <div class="portfolio-stats">
            <div class="portfolio-stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo wp_count_posts('portfolio')->publish; ?></div>
                    <div class="stat-label">Projects Completed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Flight Hours</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Client Satisfaction</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="portfolio-cta">
            <div class="cta-content">
                <h2>Ready to Start Your Project?</h2>
                <p>Let's create something amazing together. Contact us to discuss your aerial photography needs.</p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(get_page_link(get_page_by_title('Contact')->ID)); ?>" class="btn btn-primary">Get A Quote</a>
                    <a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>" class="btn btn-outline">View Services</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
