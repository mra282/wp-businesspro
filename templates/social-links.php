<?php
/**
 * Template part for displaying social media links
 *
 * @package BusinessPro
 */

$social_links = businesspro_get_social_links();

if (!empty($social_links)) :
?>
    <div class="social-links-container">
        <h3 class="social-title"><?php esc_html_e('Follow Us', 'businesspro'); ?></h3>
        <div class="social-links">
            <?php foreach ($social_links as $network => $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" 
                   class="social-link social-link-<?php echo esc_attr($network); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   aria-label="<?php printf(esc_attr__('Follow us on %s (opens in new window)', 'businesspro'), $link['label']); ?>"
                   title="<?php echo esc_attr($link['label']); ?>">
                    <i class="<?php echo esc_attr($link['icon']); ?>" aria-hidden="true"></i>
                    <span class="social-label"><?php echo esc_html($link['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        
        <div class="social-message">
            <p><?php esc_html_e('Stay connected for the latest updates, behind-the-scenes content, and showcase of our professional work!', 'businesspro'); ?></p>
        </div>
    </div>
    
    <style>
        .social-links-container {
            text-align: center;
            padding: 2rem 0;
        }
        
        .social-title {
            margin-bottom: 1.5rem;
            color: var(--dark-blue);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: var(--primary-blue);
            color: var(--white);
            border-radius: 50%;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }
        
        .social-link:hover {
            background-color: var(--accent-orange);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .social-link i {
            font-size: 1.2rem;
        }
        
        .social-label {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--dark-blue);
            color: var(--white);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 10;
        }
        
        .social-label::before {
            content: '';
            position: absolute;
            top: -4px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid var(--dark-blue);
        }
        
        .social-link:hover .social-label {
            opacity: 1;
            visibility: visible;
            bottom: -35px;
        }
        
        /* Specific social network colors */
        .social-link-facebook:hover {
            background-color: #1877F2;
        }
        
        .social-link-instagram:hover {
            background: linear-gradient(45deg, #F56040, #E91E63, #9C27B0);
        }
        
        .social-link-youtube:hover {
            background-color: #FF0000;
        }
        
        .social-link-twitter:hover {
            background-color: #1DA1F2;
        }
        
        .social-link-linkedin:hover {
            background-color: #0A66C2;
        }
        
        .social-message {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .social-message p {
            color: var(--gray);
            font-style: italic;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .social-links {
                gap: 0.5rem;
            }
            
            .social-link {
                width: 45px;
                height: 45px;
            }
            
            .social-link i {
                font-size: 1rem;
            }
            
            .social-label {
                display: none; /* Hide tooltips on mobile */
            }
        }
    </style>
<?php
endif;
?>
$social_networks = array(
    'facebook' => array(
        'url' => get_theme_mod('facebook_url', ''),
        'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'label' => __('Facebook', 'businesspro')
    ),
    'instagram' => array(
        'url' => get_theme_mod('instagram_url', ''),
        'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'label' => __('Instagram', 'businesspro')
    ),
    'youtube' => array(
        'url' => get_theme_mod('youtube_url', ''),
        'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'label' => __('YouTube', 'businesspro')
    ),
    'twitter' => array(
        'url' => get_theme_mod('twitter_url', ''),
        'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        'label' => __('Twitter', 'businesspro')
    )
);
?>

<div class="social-links">
    <?php foreach ($social_links as $network => $data) : ?>
        <?php if (!empty($data['url'])) : ?>
            <a href="<?php echo esc_url($data['url']); ?>" 
               class="social-link social-link-<?php echo esc_attr($network); ?>" 
               target="_blank" 
               rel="noopener noreferrer"
               aria-label="<?php echo esc_attr($data['label']); ?>">
                <?php echo $data['icon']; ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<style>
.social-links {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    color: currentColor;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--accent-orange);
    color: white;
    transform: translateY(-2px);
}

.social-link svg {
    width: 20px;
    height: 20px;
}

/* Specific social network colors on hover */
.social-link-facebook:hover {
    background: #1877f2;
}

.social-link-instagram:hover {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.social-link-youtube:hover {
    background: #ff0000;
}

.social-link-twitter:hover {
    background: #1da1f2;
}

/* Footer social links variant */
.footer-social .social-links {
    justify-content: flex-start;
}

.footer-social .social-link {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Mobile adjustments */
@media (max-width: 480px) {
    .social-links {
        gap: 0.75rem;
    }
    
    .social-link {
        width: 36px;
        height: 36px;
    }
    
    .social-link svg {
        width: 18px;
        height: 18px;
    }
}
</style>
