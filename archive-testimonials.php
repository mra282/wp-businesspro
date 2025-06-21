<?php
/**
 * Archive template for testimonials
 * 
 * Displays testimonials archive page
 *
 * @package BusinessPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title"><?php esc_html_e('Client Testimonials', 'businesspro'); ?></h1>
            <div class="archive-description">
                <p><?php echo esc_html(get_theme_mod('testimonials_archive_description', __('Read what our clients have to say about their experience working with us.', 'businesspro'))); ?></p>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <div class="testimonials-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('testimonial-card'); ?>>
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <svg class="quote-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            
                            <div class="testimonial-text">
                                <?php the_content(); ?>
                            </div>
                            
                            <div class="testimonial-meta">
                                <?php 
                                $client_name = get_post_meta(get_the_ID(), '_testimonial_client_name', true);
                                $client_role = get_post_meta(get_the_ID(), '_testimonial_client_role', true);
                                $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                                $project_date = get_post_meta(get_the_ID(), '_testimonial_project_date', true);
                                ?>
                                
                                <div class="testimonial-author">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="author-avatar">
                                            <?php the_post_thumbnail('thumbnail', array(
                                                'alt' => $client_name,
                                                'class' => 'avatar'
                                            )); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="author-info">
                                        <?php if ($client_name) : ?>
                                            <h3 class="author-name"><?php echo esc_html($client_name); ?></h3>
                                        <?php endif; ?>
                                        
                                        <?php if ($client_role) : ?>
                                            <p class="author-role"><?php echo esc_html($client_role); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if ($project_date) : ?>
                                            <p class="project-date">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <?php echo esc_html(date('F Y', strtotime($project_date))); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if ($rating && $rating > 0) : ?>
                                    <div class="testimonial-rating">
                                        <div class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <svg class="star <?php echo ($i <= $rating) ? 'filled' : 'empty'; ?>" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="rating-text"><?php echo esc_html($rating); ?>/5 stars</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="testimonials-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __('← Previous', 'businesspro'),
                    'next_text' => __('Next →', 'businesspro'),
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="no-testimonials">
                <h2>No Testimonials Found</h2>
                <p>We're currently collecting testimonials from our satisfied clients. Check back soon!</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Return Home</a>
            </div>
        <?php endif; ?>

        <!-- Testimonials Stats -->
        <div class="testimonials-stats">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo wp_count_posts('testimonials')->publish; ?></div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9</div>
                    <div class="stat-label">Average Rating</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Projects Completed</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="testimonials-cta">
            <div class="cta-content">
                <h2>Ready to Join Our Happy Clients?</h2>
                <p>Experience the same exceptional service that our clients rave about. Let's create stunning aerial content for your project.</p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(get_page_link(get_page_by_title('Contact')->ID)); ?>" class="btn btn-primary">Get Started</a>
                    <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="btn btn-outline">View Our Work</a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Testimonials Archive Specific Styles */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.testimonial-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.testimonial-quote {
    text-align: center;
    margin-bottom: 1.5rem;
}

.quote-icon {
    color: var(--accent-color);
    opacity: 0.3;
}

.testimonial-text {
    font-size: 1.1rem;
    line-height: 1.7;
    color: var(--text-dark);
    margin-bottom: 2rem;
    font-style: italic;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.author-avatar {
    flex-shrink: 0;
}

.avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.author-name {
    color: var(--primary-color);
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.author-role {
    color: var(--text-muted);
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.project-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--text-muted);
    font-size: 0.8rem;
}

.testimonial-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stars {
    display: flex;
    gap: 0.1rem;
}

.star {
    color: var(--border-color);
    fill: var(--border-color);
}

.star.filled {
    color: var(--accent-color);
    fill: var(--accent-color);
}

.rating-text {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.testimonials-stats {
    background: var(--primary-color);
    color: white;
    padding: 3rem 0;
    margin: 4rem 0;
    border-radius: 12px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--accent-color);
}

.stat-label {
    font-size: 1rem;
    opacity: 0.9;
}

.testimonials-cta {
    background: var(--background-light);
    padding: 4rem 2rem;
    border-radius: 12px;
    text-align: center;
}

.cta-content h2 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 2rem;
}

.cta-content p {
    color: var(--text-muted);
    margin-bottom: 2rem;
    font-size: 1.125rem;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.no-testimonials {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--background-light);
    border-radius: 12px;
}

.no-testimonials h2 {
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.no-testimonials p {
    color: var(--text-muted);
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .testimonial-author {
        flex-direction: column;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
