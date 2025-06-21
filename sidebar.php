<?php
/**
 * The sidebar containing the main widget area
 *
 * @package BusinessPro
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary" aria-label="<?php esc_attr_e('Blog Sidebar', 'businesspro'); ?>">
    <div class="sidebar-content">
        
        <!-- Search Widget -->
        <section class="widget widget_search">
            <h3 class="widget-title"><?php esc_html_e('Search', 'businesspro'); ?></h3>
            <?php get_search_form(); ?>
        </section>
        
        <!-- Recent Posts Widget -->
        <section class="widget widget_recent_entries">
            <h3 class="widget-title"><?php esc_html_e('Recent Posts', 'businesspro'); ?></h3>
            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish'
                ));
                
                foreach ($recent_posts as $post) :
                ?>
                    <li>
                        <a href="<?php echo esc_url(get_permalink($post['ID'])); ?>">
                            <?php echo esc_html($post['post_title']); ?>
                        </a>
                        <span class="post-date">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                            <?php echo esc_html(get_the_date('M j, Y', $post['ID'])); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        
        <!-- Categories Widget -->
        <section class="widget widget_categories">
            <h3 class="widget-title"><?php esc_html_e('Categories', 'businesspro'); ?></h3>
            <ul>
                <?php wp_list_categories(array(
                    'orderby'    => 'name',
                    'show_count' => 1,
                    'title_li'   => '',
                )); ?>
            </ul>
        </section>
        
        <!-- Portfolio Categories Widget -->
        <?php
        $portfolio_terms = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => false,
        ));
        
        if (!empty($portfolio_terms) && !is_wp_error($portfolio_terms)) :
        ?>
            <section class="widget widget_portfolio_categories">
                <h3 class="widget-title"><?php esc_html_e('Portfolio Categories', 'businesspro'); ?></h3>
                <ul>
                    <?php foreach ($portfolio_terms as $term) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>">
                                <?php echo esc_html($term->name); ?>
                                <span class="count">(<?php echo $term->count; ?>)</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
        
        <!-- Tag Cloud Widget -->
        <section class="widget widget_tag_cloud">
            <h3 class="widget-title"><?php esc_html_e('Tags', 'businesspro'); ?></h3>
            <?php wp_tag_cloud(array(
                'smallest' => 0.8,
                'largest' => 1.2,
                'unit' => 'rem',
                'number' => 20,
            )); ?>
        </section>
        
        <!-- Call to Action Widget -->
        <section class="widget widget_cta">
            <div class="cta-widget">
                <h3 class="widget-title"><?php esc_html_e('Need Our Services?', 'businesspro'); ?></h3>
                <p><?php esc_html_e('Ready to work with professionals? Get in touch for a free consultation.', 'businesspro'); ?></p>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-secondary">
                    <?php esc_html_e('Get Free Quote', 'businesspro'); ?>
                </a>
            </div>
        </section>
        
        <!-- Services Quick Links Widget -->
        <section class="widget widget_services">
            <h3 class="widget-title"><?php esc_html_e('Our Services', 'businesspro'); ?></h3>
            <ul class="services-list">
                <li>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>">
                        <i class="fas fa-camera" aria-hidden="true"></i>
                        <?php esc_html_e('Professional Photography', 'businesspro'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>">
                        <i class="fas fa-video" aria-hidden="true"></i>
                        <?php esc_html_e('Professional Videography', 'businesspro'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        <?php esc_html_e('Real Estate', 'businesspro'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        <?php esc_html_e('Event Coverage', 'businesspro'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>">
                        <i class="fas fa-industry" aria-hidden="true"></i>
                        <?php esc_html_e('Commercial Surveying', 'businesspro'); ?>
                    </a>
                </li>
            </ul>
        </section>
        
        <!-- Social Media Widget -->
        <?php
        $social_links = businesspro_get_social_links();
        if (!empty($social_links)) :
        ?>
            <section class="widget widget_social">
                <h3 class="widget-title"><?php esc_html_e('Follow Us', 'businesspro'); ?></h3>
                <div class="social-links">
                    <?php foreach ($social_links as $network => $link) : ?>
                        <a href="<?php echo esc_url($link['url']); ?>" 
                           class="social-link" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="<?php printf(esc_attr__('Follow us on %s', 'businesspro'), $link['label']); ?>">
                            <i class="<?php echo esc_attr($link['icon']); ?>" aria-hidden="true"></i>
                            <span><?php echo esc_html($link['label']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!-- Archives Widget -->
        <section class="widget widget_archive">
            <h3 class="widget-title"><?php esc_html_e('Archives', 'businesspro'); ?></h3>
            <ul>
                <?php wp_get_archives(array(
                    'type' => 'monthly',
                    'limit' => 12,
                    'show_post_count' => true,
                )); ?>
            </ul>
        </section>
        
        <!-- Dynamic Widget Area -->
        <?php dynamic_sidebar('sidebar-1'); ?>
        
    </div><!-- .sidebar-content -->
</aside><!-- #secondary -->
if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    
    <!-- Search Widget -->
    <section class="widget widget_search">
        <h3 class="widget-title"><?php _e('Search', 'businesspro'); ?></h3>
        <?php get_search_form(); ?>
    </section>

    <!-- Recent Posts -->
    <section class="widget widget_recent_entries">
        <h3 class="widget-title"><?php _e('Recent Posts', 'businesspro'); ?></h3>
        <ul>
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));
            
            foreach ($recent_posts as $post) :
            ?>
                <li>
                    <a href="<?php echo get_permalink($post['ID']); ?>" class="recent-post-link">
                        <div class="recent-post-item">
                            <?php if (has_post_thumbnail($post['ID'])) : ?>
                                <div class="recent-post-thumbnail">
                                    <?php echo get_the_post_thumbnail($post['ID'], 'thumbnail', array('class' => 'recent-post-img')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="recent-post-content">
                                <h4 class="recent-post-title"><?php echo esc_html($post['post_title']); ?></h4>
                                <time class="recent-post-date"><?php echo get_the_date('M j, Y', $post['ID']); ?></time>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- Categories -->
    <section class="widget widget_categories">
        <h3 class="widget-title"><?php _e('Categories', 'businesspro'); ?></h3>
        <ul>
            <?php
            wp_list_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'show_count' => 1,
                'title_li' => '',
                'number' => 10,
            ));
            ?>
        </ul>
    </section>

    <!-- Portfolio Categories -->
    <?php
    $portfolio_categories = get_terms(array(
        'taxonomy' => 'portfolio_category',
        'hide_empty' => true,
    ));
    
    if (!empty($portfolio_categories) && !is_wp_error($portfolio_categories)) :
    ?>
        <section class="widget widget_portfolio_categories">
            <h3 class="widget-title"><?php _e('Portfolio Categories', 'businesspro'); ?></h3>
            <ul>
                <?php foreach ($portfolio_categories as $category) : ?>
                    <li>
                        <a href="<?php echo get_term_link($category); ?>" class="portfolio-cat-link">
                            <span class="portfolio-cat-name"><?php echo esc_html($category->name); ?></span>
                            <span class="portfolio-cat-count">(<?php echo $category->count; ?>)</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <!-- Recent Portfolio Items -->
    <?php
    $recent_portfolio = new WP_Query(array(
        'post_type' => 'portfolio',
        'posts_per_page' => 4,
        'post_status' => 'publish',
    ));
    
    if ($recent_portfolio->have_posts()) :
    ?>
        <section class="widget widget_recent_portfolio">
            <h3 class="widget-title"><?php _e('Recent Portfolio', 'businesspro'); ?></h3>
            <div class="recent-portfolio-grid">
                <?php while ($recent_portfolio->have_posts()) : $recent_portfolio->the_post(); ?>
                    <div class="recent-portfolio-item">
                        <a href="<?php the_permalink(); ?>" class="recent-portfolio-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', array('class' => 'recent-portfolio-img')); ?>
                            <?php else : ?>
                                <img src="https://images.unsplash.com/photo-1473968512647-3e447244af8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="<?php the_title(); ?>" class="recent-portfolio-img">
                            <?php endif; ?>
                            <div class="recent-portfolio-overlay">
                                <span class="portfolio-overlay-icon">👁</span>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Tags Cloud -->
    <?php
    $tags = get_tags(array('number' => 20));
    if ($tags) :
    ?>
        <section class="widget widget_tag_cloud">
            <h3 class="widget-title"><?php _e('Popular Tags', 'businesspro'); ?></h3>
            <div class="tagcloud">
                <?php
                foreach ($tags as $tag) {
                    $tag_link = get_tag_link($tag->term_id);
                    echo '<a href="' . esc_url($tag_link) . '" class="tag-cloud-link tag-link-' . $tag->term_id . '" title="' . esc_attr($tag->name) . ' (' . $tag->count . ' items)" style="font-size: ' . (8 + ($tag->count * 2)) . 'pt;">' . esc_html($tag->name) . '</a> ';
                }
                ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Contact CTA -->
    <section class="widget widget_contact_cta">
        <div class="contact-cta-content">
            <h3><?php _e('Ready to Book?', 'businesspro'); ?></h3>
            <p><?php _e('Get professional services for your next project.', 'businesspro'); ?></p>
            <div class="contact-cta-actions">
                <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary btn-small">
                    <?php _e('Get Quote', 'businesspro'); ?>
                </a>
                <a href="tel:+1234567890" class="btn btn-secondary btn-small">
                    <?php _e('Call Now', 'businesspro'); ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Social Media -->
    <section class="widget widget_social_media">
        <h3 class="widget-title"><?php _e('Follow Us', 'businesspro'); ?></h3>
        <div class="social-media-widget">
            <?php get_template_part('templates/social-links'); ?>
        </div>
    </section>

    <?php dynamic_sidebar('sidebar-1'); ?>
    
</aside>

<style>
/* Sidebar Styles */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.widget {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s ease;
}

.widget:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.widget-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--accent-orange);
    position: relative;
}

.widget-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 30px;
    height: 2px;
    background: var(--primary-blue);
}

/* Search Widget */
.widget_search .search-form {
    display: flex;
    gap: 0.5rem;
}

.widget_search .search-field {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}

.widget_search .search-field:focus {
    outline: none;
    border-color: var(--primary-blue);
}

.widget_search .search-submit {
    padding: 0.75rem 1rem;
    background-color: var(--primary-blue);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.widget_search .search-submit:hover {
    background-color: var(--secondary-blue);
}

/* Widget Lists */
.widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.widget li {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.widget li:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.widget a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.3s ease;
}

.widget a:hover {
    color: var(--primary-blue);
}

/* Recent Posts */
.recent-post-link {
    display: block;
    text-decoration: none;
}

.recent-post-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.recent-post-thumbnail {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
}

.recent-post-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recent-post-content {
    flex: 1;
}

.recent-post-title {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.recent-post-date {
    font-size: 0.85rem;
    color: var(--text-light);
}

.recent-post-link:hover .recent-post-title {
    color: var(--primary-blue);
}

/* Categories */
.widget_categories a,
.widget_portfolio_categories a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.portfolio-cat-count,
.widget_categories .count {
    background: var(--light-gray);
    color: var(--text-light);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
}

.widget_categories a:hover .count,
.widget_portfolio_categories a:hover .portfolio-cat-count {
    background: var(--primary-blue);
    color: white;
}

/* Recent Portfolio Grid */
.recent-portfolio-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.recent-portfolio-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    aspect-ratio: 1;
}

.recent-portfolio-link {
    display: block;
    position: relative;
    width: 100%;
    height: 100%;
}

.recent-portfolio-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.recent-portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(30, 58, 138, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.portfolio-overlay-icon {
    font-size: 1.5rem;
    color: white;
}

.recent-portfolio-item:hover .recent-portfolio-overlay {
    opacity: 1;
}

.recent-portfolio-item:hover .recent-portfolio-img {
    transform: scale(1.1);
}

/* Tag Cloud */
.tagcloud {
    line-height: 1.8;
}

.tagcloud a {
    display: inline-block;
    background: var(--light-gray);
    color: var(--text-dark);
    padding: 0.25rem 0.75rem;
    margin: 0.25rem 0.25rem 0.25rem 0;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.85rem !important;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tagcloud a:hover {
    background: var(--primary-blue);
    color: white;
    transform: translateY(-2px);
}

/* Contact CTA Widget */
.widget_contact_cta {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    color: white;
}

.widget_contact_cta .widget-title {
    color: white;
    border-bottom-color: white;
}

.widget_contact_cta .widget-title::after {
    background: var(--accent-orange);
}

.contact-cta-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: white;
}

.contact-cta-content p {
    margin-bottom: 1.5rem;
    opacity: 0.9;
    line-height: 1.5;
}

.contact-cta-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.btn-small {
    padding: 0.6rem 1.2rem;
    font-size: 0.9rem;
    text-align: center;
}

.contact-cta-actions .btn-primary {
    background: var(--accent-orange);
    color: white;
}

.contact-cta-actions .btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.contact-cta-actions .btn-secondary:hover {
    background: white;
    color: var(--primary-blue);
}

/* Social Media Widget */
.social-media-widget {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-media-widget a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--light-gray);
    color: var(--text-dark);
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-media-widget a:hover {
    background: var(--primary-blue);
    color: white;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        margin-top: 3rem;
        gap: 1.5rem;
    }
    
    .widget {
        padding: 1.5rem;
    }
    
    .recent-post-item {
        gap: 0.75rem;
    }
    
    .recent-post-thumbnail {
        width: 50px;
        height: 50px;
    }
    
    .recent-post-title {
        font-size: 0.9rem;
    }
    
    .contact-cta-actions {
        flex-direction: row;
    }
    
    .btn-small {
        flex: 1;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .widget {
        padding: 1rem;
    }
    
    .widget-title {
        font-size: 1.1rem;
    }
    
    .recent-portfolio-grid {
        gap: 0.5rem;
    }
    
    .contact-cta-actions {
        flex-direction: column;
    }
    
    .tagcloud a {
        font-size: 0.8rem !important;
        padding: 0.2rem 0.6rem;
    }
}

/* Widget specific responsive adjustments */
@media (max-width: 320px) {
    .recent-post-item {
        flex-direction: column;
        text-align: center;
    }
    
    .recent-post-thumbnail {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }
}
</style>
