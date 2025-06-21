<?php
/**
 * Template part for displaying testimonial items
 *
 * @package BusinessPro
 */

<?php
/**
 * Template part for displaying testimonial items
 *
 * @package BusinessPro
 */

$client_name = get_post_meta(get_the_ID(), '_testimonial_client_name', true);
$client_role = get_post_meta(get_the_ID(), '_testimonial_client_role', true);
$rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
$is_first = !isset($GLOBALS['testimonial_count']) ? true : false;

if (!isset($GLOBALS['testimonial_count'])) {
    $GLOBALS['testimonial_count'] = 0;
}
$GLOBALS['testimonial_count']++;
?>

<div class="testimonial-item <?php echo $is_first ? 'active' : ''; ?>">
    <div class="testimonial-text">
        "<?php echo wp_kses_post(get_the_content()); ?>"
    </div>
    
    <div class="testimonial-author">
        <?php if (has_post_thumbnail()) : ?>
            <div class="author-avatar">
                <?php
                the_post_thumbnail('businesspro-testimonial', array(
                    'alt' => sprintf(__('Photo of %s', 'businesspro'), $client_name ?: get_the_title()),
                    'loading' => 'lazy',
                    'class' => 'author-avatar-img',
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="author-avatar">
                <div class="avatar-placeholder">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="author-info">
            <h4 class="author-name">
                <?php echo $client_name ? esc_html($client_name) : get_the_title(); ?>
            </h4>
            
            <?php if ($client_role) : ?>
                <p class="author-role"><?php echo esc_html($client_role); ?></p>
            <?php endif; ?>
            
            <?php if ($rating) : ?>
                <div class="rating" aria-label="<?php echo esc_attr(sprintf(__('%s out of 5 stars', 'businesspro'), $rating)); ?>">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <i class="<?php echo $i <= $rating ? 'fas' : 'far'; ?> fa-star" aria-hidden="true"></i>
                    <?php endfor; ?>
                    <span class="sr-only">
                        <?php echo esc_html(sprintf(__('%s out of 5 stars', 'businesspro'), $rating)); ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
$client_name = get_post_meta(get_the_ID(), '_testimonial_client_name', true);
$rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
$company = get_post_meta(get_the_ID(), '_testimonial_company', true);
?>

<div class="testimonial-item">
    <div class="testimonial-rating">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
            <span class="star <?php echo $i <= intval($rating) ? 'filled' : ''; ?>">★</span>
        <?php endfor; ?>
    </div>
    <div class="testimonial-text">
        "<?php the_content(); ?>"
    </div>
    <div class="testimonial-author">
        <strong><?php echo $client_name ? esc_html($client_name) : get_the_title(); ?></strong>
        <?php if ($company) : ?>
            <span class="testimonial-company"><?php echo esc_html($company); ?></span>
        <?php endif; ?>
    </div>
</div>
