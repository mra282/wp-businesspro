<?php
/**
 * Search Results Template
 * 
 * Displays search results for the BusinessPro theme
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="search-header">
            <h1 class="search-title">
                <?php if (have_posts()) : ?>
                    <?php printf(esc_html__('Search Results for: %s', 'businesspro'), '<span class="search-term">' . get_search_query() . '</span>'); ?>
                <?php else : ?>
                    <?php esc_html_e('No Results Found', 'businesspro'); ?>
                <?php endif; ?>
            </h1>
            
            <div class="search-form-wrapper">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label class="screen-reader-text" for="search-field"><?php esc_html_e('Search for:', 'businesspro'); ?></label>
                    <input type="search" id="search-field" class="search-field" placeholder="<?php esc_attr_e('Search...', 'businesspro'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'businesspro'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
            
            <?php if (have_posts()) : ?>
                <div class="search-results-count">
                    <?php
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    printf(
                        esc_html(_n('Found %d result', 'Found %d results', $total_results, 'businesspro')),
                        $total_results
                    );
                    ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="search-content">
            <?php if (have_posts()) : ?>
                <!-- Search Filter Options -->
                <div class="search-filters">
                    <h3><?php esc_html_e('Filter Results', 'businesspro'); ?></h3>
                    <div class="filter-options">
                        <button class="filter-btn active" data-filter="all"><?php esc_html_e('All Results', 'businesspro'); ?></button>
                        <button class="filter-btn" data-filter="post"><?php esc_html_e('Blog Posts', 'businesspro'); ?></button>
                        <button class="filter-btn" data-filter="page"><?php esc_html_e('Pages', 'businesspro'); ?></button>
                        <button class="filter-btn" data-filter="portfolio"><?php esc_html_e('Portfolio', 'businesspro'); ?></button>
                    </div>
                </div>

                <!-- Search Results -->
                <div class="search-results">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?> data-post-type="<?php echo get_post_type(); ?>">
                            <div class="search-result-content">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="search-result-image">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('medium', array(
                                                'alt' => get_the_title(),
                                                'loading' => 'lazy'
                                            )); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="search-result-details">
                                    <div class="search-result-meta">
                                        <span class="post-type-badge <?php echo get_post_type(); ?>">
                                            <?php
                                            $post_type = get_post_type();
                                            switch ($post_type) {
                                                case 'portfolio':
                                                    echo 'Portfolio';
                                                    break;
                                                case 'page':
                                                    echo 'Page';
                                                    break;
                                                case 'post':
                                                default:
                                                    echo 'Blog Post';
                                                    break;
                                            }
                                            ?>
                                        </span>
                                        <span class="search-result-date">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <?php echo get_the_date(); ?>
                                        </span>
                                    </div>
                                    
                                    <h2 class="search-result-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="search-result-excerpt">
                                        <?php
                                        $search_term = get_search_query();
                                        $excerpt = get_the_excerpt();
                                        
                                        // Highlight search terms in excerpt
                                        if ($search_term && $excerpt) {
                                            $highlighted_excerpt = preg_replace(
                                                '/(' . preg_quote($search_term, '/') . ')/i',
                                                '<mark>$1</mark>',
                                                $excerpt
                                            );
                                            echo $highlighted_excerpt;
                                        } else {
                                            echo $excerpt;
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php if (get_post_type() === 'portfolio') : ?>
                                        <div class="portfolio-meta">
                                            <?php 
                                            $location = get_post_meta(get_the_ID(), '_portfolio_location', true);
                                            $project_type = get_post_meta(get_the_ID(), '_portfolio_project_type', true);
                                            ?>
                                            <?php if ($location) : ?>
                                                <span class="portfolio-location">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <?php echo esc_html($location); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($project_type) : ?>
                                                <span class="portfolio-type"><?php echo esc_html($project_type); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="search-result-actions">
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php 
                                            switch (get_post_type()) {
                                                case 'portfolio':
                                                    esc_html_e('View Project', 'businesspro');
                                                    break;
                                                case 'page':
                                                    esc_html_e('Read More', 'businesspro');
                                                    break;
                                                default:
                                                    esc_html_e('Read Article', 'businesspro');
                                                    break;
                                            }
                                            ?>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <polyline points="9,18 15,12 9,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="search-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('← Previous', 'businesspro'),
                        'next_text' => __('Next →', 'businesspro'),
                    ));
                    ?>
                </div>

            <?php else : ?>
                <!-- No Results Found -->
                <div class="no-search-results">
                    <div class="no-results-content">
                        <div class="no-results-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="11" y1="8" x2="11" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="8" y1="11" x2="14" y2="11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2><?php esc_html_e('No results found', 'businesspro'); ?></h2>
                        <p><?php printf(esc_html__('Sorry, we couldn\'t find any results for "%s". Try searching with different keywords or browse our content below.', 'businesspro'), get_search_query()); ?></p>
                        
                        <!-- Search Suggestions -->
                        <div class="search-suggestions">
                            <h3><?php esc_html_e('Search Suggestions:', 'businesspro'); ?></h3>
                            <ul>
                                <li><?php esc_html_e('Check your spelling', 'businesspro'); ?></li>
                                <li><?php esc_html_e('Try different keywords', 'businesspro'); ?></li>
                                <li><?php esc_html_e('Use more general terms', 'businesspro'); ?></li>
                                <li><?php esc_html_e('Browse our portfolio or services', 'businesspro'); ?></li>
                            </ul>
                        </div>

                        <!-- Popular Search Terms -->
                        <div class="popular-searches">
                            <h3><?php esc_html_e('Popular Searches:', 'businesspro'); ?></h3>
                            <div class="search-tags">
                                <a href="<?php echo esc_url(home_url('/?s=professional+photography')); ?>" class="search-tag">Professional Photography</a>
                                <a href="<?php echo esc_url(home_url('/?s=professional+videography')); ?>" class="search-tag">Professional Videography</a>
                                <a href="<?php echo esc_url(home_url('/?s=real+estate')); ?>" class="search-tag">Real Estate</a>
                                <a href="<?php echo esc_url(home_url('/?s=commercial')); ?>" class="search-tag">Commercial</a>
                                <a href="<?php echo esc_url(home_url('/?s=wedding')); ?>" class="search-tag">Wedding</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Browse Content Section -->
        <section class="browse-content">
            <h2><?php esc_html_e('Browse Our Content', 'businesspro'); ?></h2>
            <div class="browse-grid">
                <div class="browse-item">
                    <div class="browse-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="8" y1="21" x2="16" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="12" y1="17" x2="12" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Portfolio', 'businesspro'); ?></h3>
                    <p><?php esc_html_e('View our impressive professional portfolio and projects', 'businesspro'); ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="btn btn-outline"><?php esc_html_e('View Portfolio', 'businesspro'); ?></a>
                </div>
                
                <div class="browse-item">
                    <div class="browse-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Services', 'businesspro'); ?></h3>
                    <p><?php esc_html_e('Learn about our comprehensive professional services', 'businesspro'); ?></p>
                    <a href="<?php echo esc_url(get_page_link(get_page_by_title('Services')->ID)); ?>" class="btn btn-outline"><?php esc_html_e('Our Services', 'businesspro'); ?></a>
                </div>
                
                <div class="browse-item">
                    <div class="browse-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3><?php esc_html_e('Blog', 'businesspro'); ?></h3>
                    <p><?php esc_html_e('Read our latest articles about professional services and industry insights', 'businesspro'); ?></p>
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-outline"><?php esc_html_e('Read Blog', 'businesspro'); ?></a>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
