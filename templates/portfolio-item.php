<?php
/**
 * Template part for displaying portfolio items
 *
 * @package BusinessPro
 */

<?php
/**
 * Template part for displaying portfolio items
 *
 * @package BusinessPro
 */

$location = get_post_meta(get_the_ID(), '_portfolio_location', true);
$date = get_post_meta(get_the_ID(), '_portfolio_date', true);
$client = get_post_meta(get_the_ID(), '_portfolio_client', true);
$project_type = get_post_meta(get_the_ID(), '_portfolio_project_type', true);
$terms = get_the_terms(get_the_ID(), 'portfolio_category');
$category_class = '';

if ($terms && !is_wp_error($terms)) {
    $category_slugs = array();
    foreach ($terms as $term) {
        $category_slugs[] = $term->slug;
    }
    $category_class = implode(' ', $category_slugs);
}
?>

<div class="portfolio-item" data-category="<?php echo esc_attr($category_class); ?>">
    <div class="portfolio-image">
        <?php if (has_post_thumbnail()) : ?>
            <?php
            the_post_thumbnail('businesspro-portfolio', array(
                'alt' => the_title_attribute(array('echo' => false)),
                'loading' => 'lazy',
            ));
            ?>
        <?php else : ?>
            <img src="https://images.unsplash.com/photo-1473968512647-3e447244af8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                 alt="<?php the_title_attribute(); ?>" 
                 loading="lazy">
        <?php endif; ?>
        
        <div class="portfolio-overlay">
            <div class="portfolio-overlay-content">
                <h4><?php the_title(); ?></h4>
                <?php if ($terms && !is_wp_error($terms)) : ?>
                    <p><?php echo esc_html($terms[0]->name); ?></p>
                <?php endif; ?>
                <div class="portfolio-actions">
                    <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" 
                       class="btn btn-outline" 
                       data-lightbox="portfolio"
                       data-title="<?php the_title_attribute(); ?>"
                       data-description="<?php echo esc_attr(get_the_excerpt()); ?>"
                       data-location="<?php echo esc_attr($location); ?>"
                       data-date="<?php echo esc_attr($date ? date('F j, Y', strtotime($date)) : ''); ?>"
                       aria-label="<?php esc_attr_e('View full image', 'businesspro'); ?>">
                        <i class="fas fa-search-plus" aria-hidden="true"></i>
                        <?php esc_html_e('View', 'businesspro'); ?>
                    </a>
                    <a href="<?php the_permalink(); ?>" 
                       class="btn btn-primary"
                       aria-label="<?php esc_attr_e('View project details', 'businesspro'); ?>">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <?php esc_html_e('Details', 'businesspro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="portfolio-info">
        <h3 class="portfolio-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="portfolio-meta">
            <?php if ($terms && !is_wp_error($terms)) : ?>
                <span class="portfolio-category">
                    <i class="fas fa-tag" aria-hidden="true"></i>
                    <?php echo esc_html($terms[0]->name); ?>
                </span>
            <?php endif; ?>
            
            <?php if ($location) : ?>
                <span class="portfolio-location">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    <?php echo esc_html($location); ?>
                </span>
            <?php endif; ?>
            
            <?php if ($date) : ?>
                <span class="portfolio-date">
                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                    <?php echo esc_html(date('F j, Y', strtotime($date))); ?>
                </span>
            <?php endif; ?>
            
            <?php if ($client) : ?>
                <span class="portfolio-client">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <?php echo esc_html($client); ?>
                </span>
            <?php endif; ?>
        </div>
        
        <?php if (get_the_excerpt()) : ?>
            <div class="portfolio-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
$categories = get_the_terms(get_the_ID(), 'portfolio_category');
$category_slug = '';
if ($categories && !is_wp_error($categories)) {
    $category_slug = $categories[0]->slug;
}
?>

<div class="portfolio-item" data-category="<?php echo esc_attr($category_slug); ?>">
    <div class="portfolio-image">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('portfolio-thumb', array('class' => 'w-full h-64 object-cover', 'loading' => 'lazy')); ?>
        <?php else : ?>
            <img src="https://images.unsplash.com/photo-1473968512647-3e447244af8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="<?php the_title(); ?>" class="w-full h-64 object-cover" loading="lazy">
        <?php endif; ?>
    </div>
    <div class="portfolio-overlay">
        <div class="portfolio-content">
            <h3><?php the_title(); ?></h3>
            <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            <div class="portfolio-meta">
                <?php
                $location = get_post_meta(get_the_ID(), '_portfolio_location', true);
                $date = get_post_meta(get_the_ID(), '_portfolio_date', true);
                
                if ($location) :
                ?>
                    <span class="portfolio-location">📍 <?php echo esc_html($location); ?></span>
                <?php endif; ?>
                
                <?php if ($date) : ?>
                    <span class="portfolio-date">📅 <?php echo esc_html(date('M Y', strtotime($date))); ?></span>
                <?php endif; ?>
            </div>
            <a href="<?php the_permalink(); ?>" class="portfolio-link">
                <?php _e('View Details', 'businesspro'); ?>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</div>
