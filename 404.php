<?php
/**
 * 404 Error Page Template
 * 
 * The template for displaying 404 pages (not found)
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <div class="error-404-page">
            <div class="error-content">
                <div class="error-visual">
                    <!-- Animated Business Icon -->
                    <div class="error-icon">
                        <svg width="120" height="120" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="business-icon">
                            <!-- Drone Body -->
                            <rect x="85" y="85" width="30" height="30" rx="5" fill="var(--primary-color)" stroke="var(--secondary-color)" stroke-width="2"/>
                            
                            <!-- Propellers -->
                            <circle cx="70" cy="70" r="15" fill="none" stroke="var(--accent-color)" stroke-width="2" class="propeller top-left"/>
                            <circle cx="130" cy="70" r="15" fill="none" stroke="var(--accent-color)" stroke-width="2" class="propeller top-right"/>
                            <circle cx="70" cy="130" r="15" fill="none" stroke="var(--accent-color)" stroke-width="2" class="propeller bottom-left"/>
                            <circle cx="130" cy="130" r="15" fill="none" stroke="var(--accent-color)" stroke-width="2" class="propeller bottom-right"/>
                            
                            <!-- Arms -->
                            <line x1="85" y1="85" x2="70" y2="70" stroke="var(--text-dark)" stroke-width="3"/>
                            <line x1="115" y1="85" x2="130" y2="70" stroke="var(--text-dark)" stroke-width="3"/>
                            <line x1="85" y1="115" x2="70" y2="130" stroke="var(--text-dark)" stroke-width="3"/>
                            <line x1="115" y1="115" x2="130" y2="130" stroke="var(--text-dark)" stroke-width="3"/>
                            
                            <!-- Camera -->
                            <circle cx="100" cy="120" r="8" fill="var(--text-dark)"/>
                            <circle cx="100" cy="120" r="5" fill="var(--accent-color)"/>
                        </svg>
                    </div>
                    
                    <div class="error-numbers">
                        <span class="error-4">4</span>
                        <span class="error-0">0</span>
                        <span class="error-4-alt">4</span>
                    </div>
                </div>
                
                <div class="error-text">
                    <h1 class="error-title"><?php esc_html_e('Oops! Page Not Found', 'businesspro'); ?></h1>
                    <p class="error-message"><?php esc_html_e('It looks like the page you\'re looking for has taken an unexpected detour. Let\'s help you get back on track.', 'businesspro'); ?></p>
                </div>
                
                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="9,22 9,12 15,12 15,22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php esc_html_e('Return Home', 'businesspro'); ?>
                    </a>
                    
                    <button onclick="history.back()" class="btn btn-outline">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polyline points="15,18 9,12 15,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php esc_html_e('Go Back', 'businesspro'); ?>
                    </button>
                </div>
            </div>
            
            <!-- Search Section -->
            <div class="error-search">
                <h2><?php esc_html_e('Try Searching Instead', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Maybe we can help you find what you\'re looking for:', 'businesspro'); ?></p>
                
                <form role="search" method="get" class="search-form error-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-wrapper">
                        <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search for content...', 'businesspro'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'businesspro'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Quick Links -->
            <div class="error-quick-links">
                <h2><?php esc_html_e('Quick Links', 'businesspro'); ?></h2>
                <div class="quick-links-grid">
                    <div class="quick-link-item">
                        <div class="quick-link-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="8" y1="21" x2="16" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="12" y1="17" x2="12" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Portfolio', 'businesspro'); ?></h3>
                        <p><?php esc_html_e('Browse our impressive professional portfolio and work', 'businesspro'); ?></p>
                        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="quick-link-btn"><?php esc_html_e('View Portfolio', 'businesspro'); ?></a>
                    </div>
                    
                    <div class="quick-link-item">
                        <div class="quick-link-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Services', 'businesspro'); ?></h3>
                        <p><?php esc_html_e('Learn about our comprehensive professional services', 'businesspro'); ?></p>
                        <a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>" class="quick-link-btn"><?php esc_html_e('Our Services', 'businesspro'); ?></a>
                    </div>
                    
                    <div class="quick-link-item">
                        <div class="quick-link-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Contact', 'businesspro'); ?></h3>
                        <p><?php esc_html_e('Get in touch to discuss your professional project needs', 'businesspro'); ?></p>
                        <a href="<?php echo esc_url(get_page_link(get_page_by_title('Contact')->ID)); ?>" class="quick-link-btn"><?php esc_html_e('Contact Us', 'businesspro'); ?></a>
                    </div>
                    
                    <div class="quick-link-item">
                        <div class="quick-link-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3><?php esc_html_e('Blog', 'businesspro'); ?></h3>
                        <p><?php esc_html_e('Read our latest articles and industry insights', 'businesspro'); ?></p>
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="quick-link-btn"><?php esc_html_e('Read Blog', 'businesspro'); ?></a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Portfolio Items -->
            <div class="error-recent-work">
                <h2><?php esc_html_e('Recent Work', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Check out some of our latest professional projects:', 'businesspro'); ?></p>
                
                <div class="recent-portfolio-grid">
                    <?php
                    $recent_portfolio = new WP_Query(array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                    
                    if ($recent_portfolio->have_posts()) :
                        while ($recent_portfolio->have_posts()) : $recent_portfolio->the_post(); ?>
                            <div class="recent-portfolio-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="portfolio-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium', array(
                                                'alt' => get_the_title(),
                                                'loading' => 'lazy'
                                            )); ?>
                                            <div class="portfolio-overlay">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <h3 class="portfolio-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    else : ?>
                        <p class="no-recent-portfolio"><?php esc_html_e('No recent portfolio items to display.', 'businesspro'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate business icon propellers
    const propellers = document.querySelectorAll('.propeller');
    propellers.forEach(propeller => {
        propeller.style.transformOrigin = 'center';
        propeller.style.animation = 'spin 0.1s linear infinite';
    });
    
    // Add floating animation to business icon
    const businessIcon = document.querySelector('.error-icon');
    if (businessIcon) {
        businessIcon.style.animation = 'float 3s ease-in-out infinite';
    }
});
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.error-404-page {
    text-align: center;
    padding: 4rem 0;
}

.error-visual {
    margin-bottom: 3rem;
}

.error-icon {
    margin-bottom: 2rem;
    display: inline-block;
}

.error-numbers {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    font-size: 4rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 2rem;
}

.error-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.error-message {
    font-size: 1.125rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 4rem;
}

.error-search {
    background: var(--background-light);
    padding: 3rem 2rem;
    border-radius: 12px;
    margin-bottom: 4rem;
}

.error-search h2 {
    margin-bottom: 1rem;
}

.error-search-form {
    max-width: 500px;
    margin: 0 auto;
}

.search-input-wrapper {
    display: flex;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
    background: white;
}

.search-field {
    flex: 1;
    padding: 1rem;
    border: none;
    font-size: 1rem;
}

.search-submit {
    padding: 1rem;
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-submit:hover {
    background: var(--primary-dark);
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.quick-link-item {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.quick-link-item:hover {
    transform: translateY(-5px);
}

.quick-link-icon {
    color: var(--accent-color);
    margin-bottom: 1rem;
}

.quick-link-btn {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.quick-link-btn:hover {
    color: var(--primary-dark);
}

.recent-portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.recent-portfolio-item {
    text-align: center;
}

.portfolio-thumbnail {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: white;
}

.portfolio-thumbnail:hover .portfolio-overlay {
    opacity: 1;
}

@media (max-width: 768px) {
    .error-numbers {
        font-size: 3rem;
    }
    
    .error-title {
        font-size: 2rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .quick-links-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
