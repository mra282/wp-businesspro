/**
 * BusinessPro Theme JavaScript
 * 
 * @package BusinessPro
 * @version 2.0.0
 */

/**
 * BusinessPro Theme JavaScript
 * 
 * @package BusinessPro
 */

(function($) {
    'use strict';

    /**
     * Initialize all theme functionality
     */
    $(document).ready(function() {
        initMobileMenu();
        initStickyHeader();
        initHeroSlider();
        initSmoothScrolling();
        initPortfolioFilters();
        initTestimonialSlider();
        initLazyLoading();
        initFormValidation();
        initBackToTop();
        initSinglePageNavigation();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const $mobileToggle = $('.mobile-menu-toggle');
        const $mainNavigation = $('.main-navigation');
        
        $mobileToggle.on('click', function() {
            const isExpanded = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isExpanded);
            $mainNavigation.toggleClass('active');
            
            // Change icon
            const $icon = $(this).find('i');
            if ($mainNavigation.hasClass('active')) {
                $icon.removeClass('fa-bars').addClass('fa-times');
            } else {
                $icon.removeClass('fa-times').addClass('fa-bars');
            }
        });
        
        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                $mainNavigation.removeClass('active');
                $mobileToggle.attr('aria-expanded', 'false');
                $mobileToggle.find('i').removeClass('fa-times').addClass('fa-bars');
            }
        });
        
        // Close mobile menu on window resize
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $mainNavigation.removeClass('active');
                $mobileToggle.attr('aria-expanded', 'false');
                $mobileToggle.find('i').removeClass('fa-times').addClass('fa-bars');
            }
        });
    }

    /**
     * Sticky Header on Scroll
     */
    function initStickyHeader() {
        const $header = $('.site-header');
        let lastScrollTop = 0;
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
            
            lastScrollTop = scrollTop;
        });
    }

    /**
     * Hero Section Background Slider
     */
    function initHeroSlider() {
        const $slides = $('.hero-slide');
        let currentSlide = 0;
        
        if ($slides.length > 1) {
            setInterval(function() {
                $slides.eq(currentSlide).removeClass('active');
                currentSlide = (currentSlide + 1) % $slides.length;
                $slides.eq(currentSlide).addClass('active');
            }, 5000);
        }
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    const headerHeight = $('.site-header').outerHeight();
                    
                    $('html, body').animate({
                        scrollTop: target.offset().top - headerHeight - 20
                    }, 800, 'swing');
                    
                    return false;
                }
            }
        });
    }

    /**
     * Portfolio Filters
     */
    function initPortfolioFilters() {
        const $filterButtons = $('.filter-btn');
        const $portfolioGrid = $('#portfolio-grid');
        
        $filterButtons.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            $filterButtons.removeClass('active');
            $(this).addClass('active');
            
            // Show loading state
            $portfolioGrid.addClass('loading');
            
            // If we have AJAX functionality
            if (typeof businesspro_ajax !== 'undefined') {
                $.ajax({
                    url: businesspro_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'filter_portfolio',
                        category: filter,
                        nonce: businesspro_ajax.nonce
                    },
                    success: function(response) {
                        $portfolioGrid.html(response).removeClass('loading');
                        
                        // Reinitialize lazy loading for new content
                        initLazyLoading();
                    },
                    error: function() {
                        $portfolioGrid.removeClass('loading');
                    }
                });
            } else {
                // Fallback: Simple show/hide based on data attributes
                const $items = $('.portfolio-item');
                
                if (filter === 'all') {
                    $items.show();
                } else {
                    $items.hide();
                    $items.filter('[data-category="' + filter + '"]').show();
                }
                
                $portfolioGrid.removeClass('loading');
            }
        });
    }

    /**
     * Testimonial Slider
     */
    function initTestimonialSlider() {
        const $testimonials = $('.testimonial-item');
        const $dots = $('.nav-dot');
        let currentTestimonial = 0;
        
        if ($testimonials.length > 1) {
            // Auto-rotate testimonials
            const rotateTestimonials = setInterval(function() {
                $testimonials.eq(currentTestimonial).removeClass('active');
                $dots.eq(currentTestimonial).removeClass('active');
                
                currentTestimonial = (currentTestimonial + 1) % $testimonials.length;
                
                $testimonials.eq(currentTestimonial).addClass('active');
                $dots.eq(currentTestimonial).addClass('active');
            }, 6000);
            
            // Manual navigation
            $dots.on('click', function() {
                const index = $(this).index();
                
                if (index !== currentTestimonial) {
                    $testimonials.removeClass('active');
                    $dots.removeClass('active');
                    
                    currentTestimonial = index;
                    
                    $testimonials.eq(currentTestimonial).addClass('active');
                    $dots.eq(currentTestimonial).addClass('active');
                }
            });
        }
    }

    /**
     * Lazy Loading for Images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            // Observe lazy loading images, but exclude about section images
            document.querySelectorAll('img[data-src]:not(.about-image)').forEach(function(img) {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for older browsers
            $('img[data-src]:not(.about-image)').each(function() {
                $(this).attr('src', $(this).data('src')).removeClass('lazy').addClass('loaded');
            });
        }
    }

    /**
     * Form Validation
     */
    function initFormValidation() {
        $('.booking-form').on('submit', function(e) {
            let isValid = true;
            const $form = $(this);
            
            // Remove previous error messages
            $form.find('.error-message').remove();
            $form.find('.error').removeClass('error');
            
            // Validate required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (!value) {
                    showFieldError($field, 'This field is required.');
                    isValid = false;
                }
            });
            
            // Validate email
            const $email = $form.find('input[type="email"]');
            if ($email.length && $email.val()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test($email.val())) {
                    showFieldError($email, 'Please enter a valid email address.');
                    isValid = false;
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                $form.find('.error').first().focus();
            }
        });
        
        function showFieldError($field, message) {
            $field.addClass('error');
            $field.after('<span class="error-message">' + message + '</span>');
        }
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        // Create scroll to top button if it doesn't exist
        if (!$('.scroll-to-top').length) {
            $('body').append('<button class="scroll-to-top" aria-label="Scroll to top"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 19V5M5 12L12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>');
        }
        
        const $scrollToTop = $('.scroll-to-top');
        
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $scrollToTop.addClass('visible');
            } else {
                $scrollToTop.removeClass('visible');
            }
        });
        
        $scrollToTop.on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });
    }

    /**
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip to content functionality
        $('.sr-only').on('focus', function() {
            $(this).removeClass('sr-only').addClass('sr-only-focusable');
        }).on('blur', function() {
            $(this).removeClass('sr-only-focusable').addClass('sr-only');
        });
        
        // Keyboard navigation for portfolio items
        $('.portfolio-item').on('keydown', function(e) {
            if (e.which === 13 || e.which === 32) { // Enter or Space
                e.preventDefault();
                $(this).find('a').first().click();
            }
        });
        
        // Focus management for mobile menu
        $('.mobile-menu-toggle').on('click', function() {
            setTimeout(function() {
                if ($('.main-navigation').hasClass('active')) {
                    $('.nav-menu a').first().focus();
                }
            }, 100);
        });
    }

    /**
     * Performance Optimizations
     */
    function optimizePerformance() {
        // Debounce scroll events
        let scrollTimer;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                // Your scroll-dependent code here
            }, 100);
        });
        
        // Debounce resize events
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Your resize-dependent code here
            }, 250);
        });
    }

    /**
     * Single-Page Navigation
     */
    function initSinglePageNavigation() {
        const $sectionLinks = $('.section-nav-link');
        const $sections = $('.section');
        
        if ($sectionLinks.length === 0 || $sections.length === 0) {
            return;
        }
        
        // Handle navigation clicks
        $sectionLinks.on('click', function(e) {
            e.preventDefault();
            const targetSection = $(this).data('section');
            const $targetElement = $('#' + targetSection);
            
            if ($targetElement.length) {
                const headerHeight = $('#masthead').outerHeight() || 80;
                const targetOffset = $targetElement.offset().top - headerHeight;
                
                $('html, body').animate({
                    scrollTop: targetOffset
                }, 800, 'easeInOutQuart');
                
                // Update active state
                $sectionLinks.removeClass('active');
                $(this).addClass('active');
                
                // Close mobile menu if open
                if ($('.main-navigation').hasClass('active')) {
                    $('.mobile-menu-toggle').click();
                }
            }
        });
        
        // Update active navigation on scroll
        $(window).on('scroll', function() {
            const scrollPos = $(window).scrollTop() + (($('#masthead').outerHeight() || 80) + 50);
            
            $sections.each(function() {
                const $section = $(this);
                const sectionTop = $section.offset().top;
                const sectionBottom = sectionTop + $section.outerHeight();
                const sectionId = $section.attr('id');
                
                if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                    $sectionLinks.removeClass('active');
                    $sectionLinks.filter('[data-section="' + sectionId + '"]').addClass('active');
                }
            });
        });
    }

    // Initialize accessibility and performance optimizations
    initAccessibility();
    optimizePerformance();

})(jQuery);

/**
 * Vanilla JS for critical functionality (no jQuery dependency)
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Critical CSS loading fallback
    const loadCSS = function(href) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        document.head.appendChild(link);
    };
    
    // Service Worker registration (if available)
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(function(error) {
            console.log('ServiceWorker registration failed: ', error);
        });
    }
    
    // Critical performance metrics
    if ('PerformanceObserver' in window) {
        const observer = new PerformanceObserver(function(list) {
            list.getEntries().forEach(function(entry) {
                console.log('Performance:', entry.name, entry.startTime);
            });
        });
        
        observer.observe({entryTypes: ['navigation', 'resource']});
    }
});
(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        initTheme();
    });

    // Window load
    $(window).on('load', function() {
        initScrollEffects();
    });

    /**
     * Initialize theme functionality
     */
    function initTheme() {
        initMobileMenu();
        initHeroSlider();
        initPortfolioFilter();
        initSmoothScrolling();
        initScrollToTop();
        initLazyLoading();
        initAnimations();
    }

    /**
     * Mobile Menu
     */
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const mobileMenu = $('#mobile-menu');
        const body = $('body');

        menuToggle.on('click', function() {
            mobileMenu.toggleClass('active');
            body.toggleClass('mobile-menu-open');
            
            // Animate hamburger
            $(this).find('.hamburger').toggleClass('active');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-header').length) {
                mobileMenu.removeClass('active');
                body.removeClass('mobile-menu-open');
                menuToggle.find('.hamburger').removeClass('active');
            }
        });

        // Close menu when clicking on menu links
        mobileMenu.find('a').on('click', function() {
            mobileMenu.removeClass('active');
            body.removeClass('mobile-menu-open');
            menuToggle.find('.hamburger').removeClass('active');
        });
    }

    /**
     * Hero Slider
     */
    function initHeroSlider() {
        const slides = $('.hero-slide');
        const dots = $('.hero-dot');
        const prevBtn = $('.hero-prev');
        const nextBtn = $('.hero-next');
        let currentSlide = 0;
        let slideInterval;

        if (slides.length <= 1) return;

        function showSlide(index) {
            slides.removeClass('active');
            dots.removeClass('active');
            
            slides.eq(index).addClass('active');
            dots.eq(index).addClass('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopSlideshow() {
            clearInterval(slideInterval);
        }

        // Navigation events
        nextBtn.on('click', function() {
            stopSlideshow();
            nextSlide();
            startSlideshow();
        });

        prevBtn.on('click', function() {
            stopSlideshow();
            prevSlide();
            startSlideshow();
        });

        // Dot navigation
        dots.on('click', function() {
            stopSlideshow();
            currentSlide = $(this).data('slide');
            showSlide(currentSlide);
            startSlideshow();
        });

        // Pause on hover
        $('.hero-section').hover(stopSlideshow, startSlideshow);

        // Start slideshow
        startSlideshow();
    }

    /**
     * Portfolio Filter
     */
    function initPortfolioFilter() {
        const filterBtns = $('.filter-btn');
        const portfolioItems = $('.portfolio-item');

        filterBtns.on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            filterBtns.removeClass('active');
            $(this).addClass('active');

            // Filter items
            if (filter === 'all') {
                portfolioItems.removeClass('filtered-out').addClass('filtered-in');
            } else {
                portfolioItems.each(function() {
                    const category = $(this).data('category');
                    if (category === filter) {
                        $(this).removeClass('filtered-out').addClass('filtered-in');
                    } else {
                        $(this).removeClass('filtered-in').addClass('filtered-out');
                    }
                });
            }
        });

        // AJAX Portfolio Filter (if using AJAX)
        if (typeof businesspro_ajax !== 'undefined') {
            filterBtns.on('click', function() {
                const filter = $(this).data('filter');
                const grid = $('#portfolio-grid');

                $.ajax({
                    url: businesspro_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'portfolio_filter',
                        category: filter,
                        nonce: businesspro_ajax.nonce
                    },
                    beforeSend: function() {
                        grid.addClass('loading');
                    },
                    success: function(response) {
                        grid.html(response);
                        grid.removeClass('loading');
                        initLazyLoading(); // Reinit lazy loading for new content
                    },
                    error: function() {
                        console.error('Portfolio filter failed');
                        grid.removeClass('loading');
                    }
                });
            });
        }
    }

    /**
     * Smooth Scrolling
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    const headerHeight = $('.site-header').outerHeight() || 0;
                    
                    $('html, body').animate({
                        scrollTop: target.offset().top - headerHeight - 20
                    }, 800, 'easeInOutQuart');
                    
                    return false;
                }
            }
        });
    }

    /**
     * Scroll Effects
     */
    function initScrollEffects() {
        const header = $('.site-header');
        const scrollToTopBtn = $('.scroll-to-top');

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();

            // Header scroll effect
            if (scrollTop > 100) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }

            // Scroll to top button
            if (scrollTop > 300) {
                scrollToTopBtn.addClass('visible');
            } else {
                scrollToTopBtn.removeClass('visible');
            }
        });
    }

    /**
     * Scroll to Top
     */
    function initScrollToTop() {
        $('.scroll-to-top').on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 800, 'easeInOutQuart');
        });
    }

    /**
     * Lazy Loading
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            // Exclude about section images from lazy loading
            document.querySelectorAll('img[data-src]:not(.about-image)').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Animations
     */
    function initAnimations() {
        // Fade in animation for elements
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        // Observe elements with animation class
        document.querySelectorAll('.service-card, .portfolio-item, .testimonial-item, .post-item').forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Contact Form Enhancement
     */
    function initContactForm() {
        $('.contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.text();
            
            // Basic form validation
            let isValid = true;
            form.find('input[required], textarea[required]').each(function() {
                if (!$(this).val().trim()) {
                    isValid = false;
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });

            if (!isValid) {
                showNotification('Please fill in all required fields.', 'error');
                return;
            }

            // Email validation
            const email = form.find('input[type="email"]').val();
            if (email && !isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }

            // Simulate form submission (replace with actual AJAX call)
            submitBtn.text('Sending...').prop('disabled', true);
            
            setTimeout(() => {
                submitBtn.text(originalText).prop('disabled', false);
                form[0].reset();
                showNotification('Thank you! Your message has been sent.', 'success');
            }, 2000);
        });
    }

    /**
     * Utility Functions
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showNotification(message, type = 'info') {
        const notification = $(`
            <div class="notification notification-${type}">
                <span class="notification-message">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `);

        $('body').append(notification);
        
        setTimeout(() => {
            notification.addClass('show');
        }, 100);

        // Auto hide after 5 seconds
        setTimeout(() => {
            hideNotification(notification);
        }, 5000);

        // Close button
        notification.find('.notification-close').on('click', () => {
            hideNotification(notification);
        });
    }

    function hideNotification(notification) {
        notification.removeClass('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }

    // Initialize contact form if it exists
    if ($('.contact-form').length) {
        initContactForm();
    }

    // Add easing for smooth animations
    $.easing.easeInOutQuart = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
        return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    };

})(jQuery);

// Additional CSS for animations and notifications
const additionalCSS = `
<style>
/* Animation styles */
.service-card,
.portfolio-item,
.testimonial-item,
.post-item {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.service-card.animated,
.portfolio-item.animated,
.testimonial-item.animated,
.post-item.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Mobile menu hamburger animation */
.hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
}

.hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -6px);
}

/* Portfolio loading state */
.portfolio-grid.loading {
    opacity: 0.5;
    pointer-events: none;
}

/* Form error states */
.form-group input.error,
.form-group textarea.error,
.form-group select.error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Notifications */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    z-index: 10000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    max-width: 400px;
}

.notification.show {
    transform: translateX(0);
}

.notification-success {
    border-left: 4px solid #10b981;
}

.notification-error {
    border-left: 4px solid #ef4444;
}

.notification-close {
    position: absolute;
    top: 5px;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
}

.notification-close:hover {
    color: #374151;
}

/* Lazy loading */
img.lazy {
    opacity: 0;
    transition: opacity 0.3s;
}

img.loaded {
    opacity: 1;
}

/* Mobile menu body lock */
body.mobile-menu-open {
    overflow: hidden;
}

@media (max-width: 768px) {
    .notification {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }
}
</style>
`;

// Inject additional CSS
document.head.insertAdjacentHTML('beforeend', additionalCSS);
