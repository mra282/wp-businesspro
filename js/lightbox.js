/**
 * Lightbox functionality for BusinessPro theme
 * 
 * @package BusinessPro
 * @version 1.0.0
 */

/**
 * BusinessPro Lightbox
 * Simple, accessible lightbox for portfolio images and videos
 * 
 * @package BusinessPro
 */

(function($) {
    'use strict';

    let currentIndex = 0;
    let gallery = [];
    let isOpen = false;

    /**
     * Initialize Lightbox
     */
    $(document).ready(function() {
        createLightboxHTML();
        bindEvents();
        collectGalleryImages();
    });

    /**
     * Create Lightbox HTML Structure
     */
    function createLightboxHTML() {
        const lightboxHTML = `
            <div class="businesspro-lightbox" id="businesspro-lightbox" role="dialog" aria-modal="true" aria-labelledby="lightbox-title" aria-hidden="true">
                <div class="lightbox-overlay"></div>
                <div class="lightbox-container">
                    <div class="lightbox-content">
                        <div class="lightbox-header">
                            <h2 id="lightbox-title" class="lightbox-title"></h2>
                            <button class="lightbox-close" aria-label="Close lightbox">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="lightbox-media">
                            <img class="lightbox-image" src="" alt="" />
                            <video class="lightbox-video" controls style="display: none;">
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <div class="lightbox-info">
                            <p class="lightbox-description"></p>
                            <div class="lightbox-meta">
                                <span class="lightbox-location"></span>
                                <span class="lightbox-date"></span>
                            </div>
                        </div>
                        <div class="lightbox-navigation">
                            <button class="lightbox-prev" aria-label="Previous image">
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            </button>
                            <span class="lightbox-counter">
                                <span class="current">1</span> / <span class="total">1</span>
                            </span>
                            <button class="lightbox-next" aria-label="Next image">
                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="lightbox-loader">
                        <div class="loader-spinner"></div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(lightboxHTML);
        
        // Add CSS for the lightbox
        addLightboxCSS();
    }

    /**
     * Add Lightbox CSS
     */
    function addLightboxCSS() {
        const css = `
            <style>
                .businesspro-lightbox {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    display: none;
                    background: rgba(0, 0, 0, 0.95);
                }
                
                .lightbox-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    cursor: pointer;
                }
                
                .lightbox-container {
                    position: relative;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                
                .lightbox-content {
                    position: relative;
                    max-width: 90vw;
                    max-height: 90vh;
                    background: white;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                    animation: lightboxFadeIn 0.3s ease;
                }
                
                @keyframes lightboxFadeIn {
                    from { opacity: 0; transform: scale(0.8); }
                    to { opacity: 1; transform: scale(1); }
                }
                
                .lightbox-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px 20px;
                    background: var(--primary-blue);
                    color: white;
                }
                
                .lightbox-title {
                    margin: 0;
                    font-size: 1.2rem;
                    font-weight: 600;
                }
                
                .lightbox-close {
                    background: none;
                    border: none;
                    color: white;
                    font-size: 1.5rem;
                    cursor: pointer;
                    padding: 5px;
                    border-radius: 4px;
                    transition: background-color 0.2s;
                }
                
                .lightbox-close:hover {
                    background: rgba(255, 255, 255, 0.1);
                }
                
                .lightbox-media {
                    position: relative;
                    max-height: 60vh;
                    overflow: hidden;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #f8f9fa;
                }
                
                .lightbox-image,
                .lightbox-video {
                    max-width: 100%;
                    max-height: 100%;
                    width: auto;
                    height: auto;
                    object-fit: contain;
                }
                
                .lightbox-info {
                    padding: 20px;
                }
                
                .lightbox-description {
                    margin: 0 0 10px 0;
                    color: var(--dark-gray);
                    line-height: 1.6;
                }
                
                .lightbox-meta {
                    display: flex;
                    gap: 20px;
                    font-size: 0.9rem;
                    color: var(--gray);
                }
                
                .lightbox-navigation {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px 20px;
                    background: var(--light-gray);
                    border-top: 1px solid #e5e7eb;
                }
                
                .lightbox-prev,
                .lightbox-next {
                    background: var(--primary-blue);
                    color: white;
                    border: none;
                    padding: 10px 15px;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.2s;
                    font-size: 1rem;
                }
                
                .lightbox-prev:hover,
                .lightbox-next:hover {
                    background: var(--dark-blue);
                }
                
                .lightbox-prev:disabled,
                .lightbox-next:disabled {
                    background: var(--gray);
                    cursor: not-allowed;
                }
                
                .lightbox-counter {
                    font-weight: 600;
                    color: var(--dark-gray);
                }
                
                .lightbox-loader {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    display: none;
                }
                
                .loader-spinner {
                    width: 40px;
                    height: 40px;
                    border: 4px solid rgba(255, 255, 255, 0.3);
                    border-top: 4px solid white;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                }
                
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                
                /* Mobile Responsiveness */
                @media (max-width: 768px) {
                    .lightbox-content {
                        max-width: 95vw;
                        max-height: 95vh;
                    }
                    
                    .lightbox-header {
                        padding: 10px 15px;
                    }
                    
                    .lightbox-title {
                        font-size: 1rem;
                    }
                    
                    .lightbox-info {
                        padding: 15px;
                    }
                    
                    .lightbox-navigation {
                        padding: 10px 15px;
                    }
                    
                    .lightbox-meta {
                        flex-direction: column;
                        gap: 5px;
                    }
                }
                
                /* Focus styles for accessibility */
                .lightbox-close:focus,
                .lightbox-prev:focus,
                .lightbox-next:focus {
                    outline: 2px solid var(--accent-orange);
                    outline-offset: 2px;
                }
            </style>
        `;
        
        $('head').append(css);
    }

    /**
     * Bind Events
     */
    function bindEvents() {
        // Open lightbox when clicking on gallery items
        $(document).on('click', '[data-lightbox]', function(e) {
            e.preventDefault();
            const index = $(this).data('index') || 0;
            openLightbox(index);
        });
        
        // Close lightbox events
        $('#businesspro-lightbox').on('click', '.lightbox-close, .lightbox-overlay', closeLightbox);
        
        // Navigation events
        $('#businesspro-lightbox').on('click', '.lightbox-prev', showPrevious);
        $('#businesspro-lightbox').on('click', '.lightbox-next', showNext);
        
        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (!isOpen) return;
            
            switch(e.which) {
                case 27: // Escape
                    closeLightbox();
                    break;
                case 37: // Left arrow
                    showPrevious();
                    break;
                case 39: // Right arrow
                    showNext();
                    break;
            }
        });
        
        // Prevent scrolling when lightbox is open
        $('#businesspro-lightbox').on('wheel touchmove', function(e) {
            e.preventDefault();
        });
    }

    /**
     * Collect Gallery Images
     */
    function collectGalleryImages() {
        gallery = [];
        
        // Collect portfolio items
        $('.portfolio-item').each(function(index) {
            const $item = $(this);
            const $link = $item.find('a[href]').first();
            const $img = $item.find('img').first();
            
            if ($link.length && $img.length) {
                const item = {
                    src: $link.attr('href'),
                    title: $item.find('.portfolio-title').text() || $img.attr('alt') || '',
                    description: $item.find('.portfolio-description').text() || '',
                    location: $item.find('.portfolio-location').text() || '',
                    date: $item.find('.portfolio-date').text() || '',
                    type: getMediaType($link.attr('href'))
                };
                
                gallery.push(item);
                
                // Add data attributes for lightbox
                $link.attr({
                    'data-lightbox': 'portfolio',
                    'data-index': index
                });
            }
        });
        
        // Also collect any other lightbox-enabled elements
        $('[data-lightbox]:not([data-index])').each(function(index) {
            const $link = $(this);
            const adjustedIndex = gallery.length + index;
            
            $link.attr('data-index', adjustedIndex);
            
            gallery.push({
                src: $link.attr('href'),
                title: $link.attr('data-title') || $link.find('img').attr('alt') || '',
                description: $link.attr('data-description') || '',
                location: $link.attr('data-location') || '',
                date: $link.attr('data-date') || '',
                type: getMediaType($link.attr('href'))
            });
        });
    }

    /**
     * Get Media Type
     */
    function getMediaType(src) {
        const extension = src.split('.').pop().toLowerCase();
        const videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
        
        return videoExtensions.includes(extension) ? 'video' : 'image';
    }

    /**
     * Open Lightbox
     */
    function openLightbox(index) {
        if (gallery.length === 0) {
            collectGalleryImages();
        }
        
        if (index >= 0 && index < gallery.length) {
            currentIndex = index;
            isOpen = true;
            
            const $lightbox = $('#businesspro-lightbox');
            
            // Prevent body scrolling
            $('body').addClass('lightbox-open').css('overflow', 'hidden');
            
            // Show lightbox
            $lightbox.attr('aria-hidden', 'false').fadeIn(300);
            
            // Load content
            loadMedia(gallery[currentIndex]);
            
            // Update navigation
            updateNavigation();
            
            // Focus management
            setTimeout(function() {
                $lightbox.find('.lightbox-close').focus();
            }, 100);
        }
    }

    /**
     * Close Lightbox
     */
    function closeLightbox() {
        isOpen = false;
        const $lightbox = $('#businesspro-lightbox');
        
        $lightbox.attr('aria-hidden', 'true').fadeOut(300);
        $('body').removeClass('lightbox-open').css('overflow', '');
        
        // Clear media
        $lightbox.find('.lightbox-image').attr('src', '');
        $lightbox.find('.lightbox-video source').attr('src', '');
        $lightbox.find('.lightbox-video')[0].load();
    }

    /**
     * Show Previous Image
     */
    function showPrevious() {
        if (currentIndex > 0) {
            currentIndex--;
            loadMedia(gallery[currentIndex]);
            updateNavigation();
        }
    }

    /**
     * Show Next Image
     */
    function showNext() {
        if (currentIndex < gallery.length - 1) {
            currentIndex++;
            loadMedia(gallery[currentIndex]);
            updateNavigation();
        }
    }

    /**
     * Load Media
     */
    function loadMedia(item) {
        const $lightbox = $('#businesspro-lightbox');
        const $loader = $lightbox.find('.lightbox-loader');
        const $image = $lightbox.find('.lightbox-image');
        const $video = $lightbox.find('.lightbox-video');
        
        // Show loader
        $loader.show();
        $image.hide();
        $video.hide();
        
        // Update info
        $lightbox.find('.lightbox-title').text(item.title);
        $lightbox.find('.lightbox-description').text(item.description);
        $lightbox.find('.lightbox-location').text(item.location);
        $lightbox.find('.lightbox-date').text(item.date);
        
        if (item.type === 'video') {
            // Load video
            $video.find('source').attr('src', item.src);
            $video[0].load();
            
            $video.on('loadeddata', function() {
                $loader.hide();
                $video.show();
            });
            
            $video.on('error', function() {
                $loader.hide();
                showError('Error loading video');
            });
        } else {
            // Load image
            const img = new Image();
            
            img.onload = function() {
                $image.attr({
                    'src': item.src,
                    'alt': item.title
                });
                $loader.hide();
                $image.show();
            };
            
            img.onerror = function() {
                $loader.hide();
                showError('Error loading image');
            };
            
            img.src = item.src;
        }
    }

    /**
     * Update Navigation
     */
    function updateNavigation() {
        const $lightbox = $('#businesspro-lightbox');
        const $prevBtn = $lightbox.find('.lightbox-prev');
        const $nextBtn = $lightbox.find('.lightbox-next');
        const $counter = $lightbox.find('.lightbox-counter');
        
        // Update counter
        $counter.find('.current').text(currentIndex + 1);
        $counter.find('.total').text(gallery.length);
        
        // Update navigation buttons
        $prevBtn.prop('disabled', currentIndex === 0);
        $nextBtn.prop('disabled', currentIndex === gallery.length - 1);
        
        // Hide navigation if only one item
        if (gallery.length <= 1) {
            $lightbox.find('.lightbox-navigation').hide();
        } else {
            $lightbox.find('.lightbox-navigation').show();
        }
    }

    /**
     * Show Error Message
     */
    function showError(message) {
        const $lightbox = $('#businesspro-lightbox');
        $lightbox.find('.lightbox-media').html(
            '<div class="lightbox-error">' +
            '<i class="fas fa-exclamation-triangle"></i>' +
            '<p>' + message + '</p>' +
            '</div>'
        );
    }

    /**
     * Preload Adjacent Images
     */
    function preloadAdjacent() {
        const preloadIndexes = [currentIndex - 1, currentIndex + 1];
        
        preloadIndexes.forEach(function(index) {
            if (index >= 0 && index < gallery.length && gallery[index].type === 'image') {
                const img = new Image();
                img.src = gallery[index].src;
            }
        });
    }

    // Public API
    window.BusinessProLightbox = {
        open: openLightbox,
        close: closeLightbox,
        next: showNext,
        prev: showPrevious,
        refresh: collectGalleryImages
    };

})(jQuery);
(function($) {
    'use strict';

    let lightboxInstance = null;

    class BusinessProLightbox {
        constructor() {
            this.currentIndex = 0;
            this.images = [];
            this.isOpen = false;
            this.init();
        }

        init() {
            this.createLightboxHTML();
            this.bindEvents();
            this.findImages();
        }

        createLightboxHTML() {
            const lightboxHTML = `
                <div id="businesspro-lightbox" class="businesspro-lightbox">
                    <div class="lightbox-overlay"></div>
                    <div class="lightbox-container">
                        <button class="lightbox-close" aria-label="Close lightbox">&times;</button>
                        <button class="lightbox-prev" aria-label="Previous image">‹</button>
                        <button class="lightbox-next" aria-label="Next image">›</button>
                        <div class="lightbox-content">
                            <img class="lightbox-image" src="" alt="">
                            <div class="lightbox-info">
                                <h3 class="lightbox-title"></h3>
                                <p class="lightbox-description"></p>
                                <div class="lightbox-meta"></div>
                            </div>
                        </div>
                        <div class="lightbox-counter">
                            <span class="lightbox-current">1</span> / <span class="lightbox-total">1</span>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(lightboxHTML);
            this.$lightbox = $('#businesspro-lightbox');
            this.$image = this.$lightbox.find('.lightbox-image');
            this.$title = this.$lightbox.find('.lightbox-title');
            this.$description = this.$lightbox.find('.lightbox-description');
            this.$meta = this.$lightbox.find('.lightbox-meta');
            this.$current = this.$lightbox.find('.lightbox-current');
            this.$total = this.$lightbox.find('.lightbox-total');
        }

        findImages() {
            // Portfolio images
            $('.portfolio-item').each((index, item) => {
                const $item = $(item);
                const $img = $item.find('img');
                const $link = $item.find('.portfolio-link');
                
                if ($img.length) {
                    const imageData = {
                        src: $img.attr('src') || $img.attr('data-src'),
                        title: $item.find('h3').text() || $img.attr('alt'),
                        description: $item.find('p').text(),
                        meta: $item.find('.portfolio-meta').html() || '',
                        element: $item
                    };
                    
                    this.images.push(imageData);
                    
                    // Add click handler to image
                    $img.on('click', (e) => {
                        e.preventDefault();
                        this.open(this.images.length - 1);
                    });
                    
                    // Prevent default link behavior if clicking on image
                    $link.on('click', (e) => {
                        if ($(e.target).is('img')) {
                            e.preventDefault();
                        }
                    });
                }
            });

            // Gallery images
            $('.gallery img, .wp-caption img').each((index, img) => {
                const $img = $(img);
                const $caption = $img.closest('.wp-caption').find('.wp-caption-text');
                
                const imageData = {
                    src: $img.attr('src') || $img.attr('data-src'),
                    title: $img.attr('alt') || '',
                    description: $caption.text() || '',
                    meta: '',
                    element: $img
                };
                
                this.images.push(imageData);
                
                $img.on('click', (e) => {
                    e.preventDefault();
                    this.open(this.images.length - 1);
                });
            });

            // Content images with lightbox class
            $('.lightbox-image, .wp-block-image img').each((index, img) => {
                const $img = $(img);
                const $figure = $img.closest('figure');
                const $caption = $figure.find('figcaption');
                
                const imageData = {
                    src: $img.attr('src') || $img.attr('data-src'),
                    title: $img.attr('alt') || '',
                    description: $caption.text() || '',
                    meta: '',
                    element: $img
                };
                
                this.images.push(imageData);
                
                $img.on('click', (e) => {
                    e.preventDefault();
                    this.open(this.images.length - 1);
                });
                
                // Add cursor pointer
                $img.css('cursor', 'pointer');
            });
        }

        bindEvents() {
            // Close lightbox
            this.$lightbox.find('.lightbox-close, .lightbox-overlay').on('click', () => {
                this.close();
            });

            // Navigation
            this.$lightbox.find('.lightbox-prev').on('click', () => {
                this.prev();
            });

            this.$lightbox.find('.lightbox-next').on('click', () => {
                this.next();
            });

            // Keyboard navigation
            $(document).on('keydown', (e) => {
                if (!this.isOpen) return;
                
                switch(e.keyCode) {
                    case 27: // Escape
                        this.close();
                        break;
                    case 37: // Left arrow
                        this.prev();
                        break;
                    case 39: // Right arrow
                        this.next();
                        break;
                }
            });

            // Prevent scrolling when lightbox is open
            this.$lightbox.on('wheel touchmove', (e) => {
                e.preventDefault();
            });
        }

        open(index) {
            this.currentIndex = index;
            this.isOpen = true;
            this.updateContent();
            this.$lightbox.addClass('active');
            $('body').addClass('lightbox-open');
            
            // Preload adjacent images
            this.preloadImages();
        }

        close() {
            this.isOpen = false;
            this.$lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        }

        next() {
            if (this.images.length === 0) return;
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.updateContent();
            this.preloadImages();
        }

        prev() {
            if (this.images.length === 0) return;
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.updateContent();
            this.preloadImages();
        }

        updateContent() {
            const image = this.images[this.currentIndex];
            if (!image) return;

            // Update image
            this.$image.attr('src', image.src).attr('alt', image.title);
            
            // Update info
            this.$title.text(image.title);
            this.$description.text(image.description);
            this.$meta.html(image.meta);
            
            // Update counter
            this.$current.text(this.currentIndex + 1);
            this.$total.text(this.images.length);
            
            // Show/hide navigation
            const showNav = this.images.length > 1;
            this.$lightbox.find('.lightbox-prev, .lightbox-next').toggle(showNav);
            this.$lightbox.find('.lightbox-counter').toggle(showNav);
        }

        preloadImages() {
            // Preload next and previous images
            const preloadIndexes = [
                (this.currentIndex + 1) % this.images.length,
                (this.currentIndex - 1 + this.images.length) % this.images.length
            ];
            
            preloadIndexes.forEach(index => {
                if (this.images[index]) {
                    const img = new Image();
                    img.src = this.images[index].src;
                }
            });
        }
    }

    // Initialize lightbox when document is ready
    $(document).ready(() => {
        lightboxInstance = new BusinessProLightbox();
    });

    // Reinitialize when new content is loaded (for AJAX)
    $(document).on('businesspro:content-loaded', () => {
        if (lightboxInstance) {
            lightboxInstance.findImages();
        }
    });

})(jQuery);

// Add lightbox CSS
const lightboxCSS = `
<style>
/* Lightbox Styles */
.businesspro-lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.businesspro-lightbox.active {
    opacity: 1;
    visibility: visible;
}

.lightbox-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    cursor: pointer;
}

.lightbox-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px 20px;
    box-sizing: border-box;
}

.lightbox-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.businesspro-lightbox.active .lightbox-content {
    transform: scale(1);
}

.lightbox-image {
    max-width: 100%;
    max-height: 70vh;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
}

.lightbox-info {
    padding: 1.5rem;
    background: white;
}

.lightbox-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.lightbox-description {
    color: var(--text-light);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.lightbox-meta {
    font-size: 0.9rem;
    color: var(--text-light);
}

.lightbox-meta span {
    display: inline-block;
    margin-right: 1rem;
    margin-bottom: 0.5rem;
}

/* Navigation */
.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10001;
}

.lightbox-close:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.lightbox-prev,
.lightbox-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10001;
}

.lightbox-prev {
    left: 20px;
}

.lightbox-next {
    right: 20px;
}

.lightbox-prev:hover,
.lightbox-next:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.1);
}

.lightbox-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    z-index: 10001;
}

/* Body lock when lightbox is open */
body.lightbox-open {
    overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
    .lightbox-container {
        padding: 40px 10px 10px;
    }
    
    .lightbox-content {
        max-width: 95vw;
        max-height: 95vh;
    }
    
    .lightbox-image {
        max-height: 60vh;
    }
    
    .lightbox-info {
        padding: 1rem;
    }
    
    .lightbox-title {
        font-size: 1.25rem;
    }
    
    .lightbox-close {
        width: 40px;
        height: 40px;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
    }
    
    .lightbox-prev,
    .lightbox-next {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
    
    .lightbox-prev {
        left: 10px;
    }
    
    .lightbox-next {
        right: 10px;
    }
}

@media (max-width: 480px) {
    .lightbox-container {
        padding: 30px 5px 5px;
    }
    
    .lightbox-prev,
    .lightbox-next {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .lightbox-info {
        padding: 0.75rem;
    }
    
    .lightbox-title {
        font-size: 1.1rem;
    }
    
    .lightbox-description {
        font-size: 0.9rem;
    }
}

/* Loading animation */
.lightbox-image {
    transition: opacity 0.3s ease;
}

.lightbox-image:not([src]) {
    opacity: 0;
}

/* Hover effects for images that open lightbox */
.portfolio-item img,
.gallery img,
.lightbox-image,
.wp-block-image img {
    transition: all 0.3s ease;
}

.portfolio-item img:hover,
.gallery img:hover,
.lightbox-image:hover,
.wp-block-image img:hover {
    cursor: pointer;
}

/* Focus styles for accessibility */
.lightbox-close:focus,
.lightbox-prev:focus,
.lightbox-next:focus {
    outline: 2px solid var(--accent-orange);
    outline-offset: 2px;
}
</style>
`;

// Inject lightbox CSS
document.head.insertAdjacentHTML('beforeend', lightboxCSS);
