/**
 * Contact Form Enhancements
 * Additional JavaScript for contact and portfolio functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Contact Form Handler
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        handleContactForm(contactForm);
    }
    
    // Portfolio Filter Enhancement
    const portfolioFilters = document.querySelectorAll('.filter-btn');
    if (portfolioFilters.length > 0) {
        enhancePortfolioFilters();
    }
    
    // Search Results Filter
    const searchFilters = document.querySelectorAll('.search-filters .filter-btn');
    if (searchFilters.length > 0) {
        handleSearchFilters();
    }
    
    // Copy Link Functionality
    const copyButtons = document.querySelectorAll('.copy-link');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            copyToClipboard(this.dataset.url);
        });
    });
    
    // Load More Portfolio
    const loadMoreBtn = document.getElementById('load-more-portfolio');
    if (loadMoreBtn) {
        handleLoadMorePortfolio(loadMoreBtn);
    }
    
    // FAQ Accordion (if you want to add this feature)
    const faqItems = document.querySelectorAll('.faq-item');
    if (faqItems.length > 0) {
        makeFaqAccordion(faqItems);
    }
    
    // Form Validation Enhancements
    enhanceFormValidation();
    
    // Smooth Scrolling for Anchor Links
    enhanceSmoothScrolling();
    
    // Portfolio Image Lazy Loading
    enhanceImageLazyLoading();
});

/**
 * Contact Form Handler
 */
function handleContactForm(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            submitBtn.disabled = true;
        }
        
        // Form validation
        if (!validateContactForm(form)) {
            e.preventDefault();
            // Reset button state
            if (btnText && btnLoading) {
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            }
            return false;
        }
        
        // Add small delay for UX
        setTimeout(() => {
            // Form will submit naturally
        }, 500);
    });
    
    // Auto-save form data to localStorage
    const formInputs = form.querySelectorAll('input, textarea, select');
    formInputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`contact_form_${input.name}`);
        if (savedValue && input.type !== 'checkbox') {
            input.value = savedValue;
        }
        
        // Save data on change
        input.addEventListener('change', function() {
            if (this.type === 'checkbox') {
                localStorage.setItem(`contact_form_${this.name}`, this.checked);
            } else {
                localStorage.setItem(`contact_form_${this.name}`, this.value);
            }
        });
    });
    
    // Clear saved data on successful submission
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('contact') === 'success') {
        formInputs.forEach(input => {
            localStorage.removeItem(`contact_form_${input.name}`);
        });
    }
}

/**
 * Contact Form Validation
 */
function validateContactForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    // Email validation
    const emailField = form.querySelector('input[type="email"]');
    if (emailField && emailField.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value)) {
            showFieldError(emailField, 'Please enter a valid email address');
            isValid = false;
        }
    }
    
    // Phone validation (if provided)
    const phoneField = form.querySelector('input[type="tel"]');
    if (phoneField && phoneField.value) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        if (!phoneRegex.test(phoneField.value.replace(/[\s\-\(\)]/g, ''))) {
            showFieldError(phoneField, 'Please enter a valid phone number');
            isValid = false;
        }
    }
    
    return isValid;
}

/**
 * Show field error
 */
function showFieldError(field, message) {
    clearFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';
    
    field.style.borderColor = '#dc3545';
    field.parentNode.appendChild(errorDiv);
}

/**
 * Clear field error
 */
function clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    field.style.borderColor = '';
}

/**
 * Enhanced Portfolio Filters
 */
function enhancePortfolioFilters() {
    const filterBtns = document.querySelectorAll('.portfolio-filters .filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-pressed', 'false');
            });
            this.classList.add('active');
            this.setAttribute('aria-pressed', 'true');
            
            const filter = this.dataset.filter;
            
            // Filter items with animation
            portfolioItems.forEach(item => {
                if (filter === '*' || item.classList.contains(filter.replace('.', ''))) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

/**
 * Search Results Filter
 */
function handleSearchFilters() {
    const filterBtns = document.querySelectorAll('.search-filters .filter-btn');
    const searchItems = document.querySelectorAll('.search-result-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            searchItems.forEach(item => {
                if (filter === 'all' || item.dataset.postType === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Copy to Clipboard
 */
function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            showCopyNotification('Link copied to clipboard!');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopyNotification('Link copied to clipboard!');
        } catch (err) {
            showCopyNotification('Failed to copy link');
        }
        
        document.body.removeChild(textArea);
    }
}

/**
 * Show copy notification
 */
function showCopyNotification(message) {
    const notification = document.createElement('div');
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        z-index: 9999;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        notification.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 2000);
}

/**
 * Load More Portfolio Handler
 */
function handleLoadMorePortfolio(btn) {
    btn.addEventListener('click', function() {
        const btnText = this.querySelector('.btn-text');
        const btnLoading = this.querySelector('.btn-loading');
        const currentPage = parseInt(this.dataset.page);
        const maxPages = parseInt(this.dataset.max);
        
        if (currentPage >= maxPages) {
            this.style.display = 'none';
            return;
        }
        
        // Show loading state
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        this.disabled = true;
        
        // AJAX request would go here
        // For now, just simulate loading
        setTimeout(() => {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            this.disabled = false;
            this.dataset.page = currentPage + 1;
            
            if (currentPage + 1 >= maxPages) {
                this.style.display = 'none';
                document.querySelector('.portfolio-pagination-fallback').classList.add('show');
            }
        }, 1000);
    });
}

/**
 * Make FAQ Accordion (optional enhancement)
 */
function makeFaqAccordion(items) {
    items.forEach(item => {
        const question = item.querySelector('h3');
        const answer = item.querySelector('p');
        
        if (question && answer) {
            question.style.cursor = 'pointer';
            question.style.userSelect = 'none';
            
            // Initially hide answers (optional)
            // answer.style.display = 'none';
            
            question.addEventListener('click', function() {
                const isOpen = answer.style.display !== 'none';
                
                if (isOpen) {
                    answer.style.display = 'none';
                    this.style.color = '';
                } else {
                    answer.style.display = 'block';
                    this.style.color = 'var(--accent-color)';
                }
            });
        }
    });
}

/**
 * Enhanced Form Validation
 */
function enhanceFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Real-time validation
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.style.borderColor = '#dc3545';
                } else if (this.type === 'email' && this.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(this.value)) {
                        this.style.borderColor = '#dc3545';
                    } else {
                        this.style.borderColor = '#28a745';
                    }
                } else if (this.value.trim()) {
                    this.style.borderColor = '#28a745';
                } else {
                    this.style.borderColor = '';
                }
            });
            
            // Clear error state on focus
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary-color)';
            });
        });
    });
}

/**
 * Enhanced Smooth Scrolling
 */
function enhanceSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL without jumping
                if (history.pushState) {
                    history.pushState(null, null, href);
                }
            }
        });
    });
}

/**
 * Enhanced Image Lazy Loading
 */
function enhanceImageLazyLoading() {
    // Exclude about section images from lazy loading animations
    const images = document.querySelectorAll('img[loading="lazy"]:not(.about-image)');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    // Skip fade effect for about images
                    if (!img.classList.contains('about-image')) {
                        img.style.opacity = '0';
                        img.style.transition = 'opacity 0.3s ease';
                        
                        img.addEventListener('load', function() {
                            this.style.opacity = '1';
                        });
                    }
                    
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
}

/**
 * Contact Form Auto-fill from URL parameters (for marketing campaigns)
 */
function handleAutoFillFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const form = document.getElementById('contact-form');
    
    if (form) {
        // Auto-fill service type from URL
        const service = urlParams.get('service');
        if (service) {
            const serviceSelect = form.querySelector('#contact-service');
            if (serviceSelect) {
                serviceSelect.value = service;
            }
        }
        
        // Auto-fill campaign source
        const source = urlParams.get('utm_source');
        if (source) {
            // You could add a hidden field to track this
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = 'campaign_source';
            hiddenField.value = source;
            form.appendChild(hiddenField);
        }
    }
}

// Initialize auto-fill
handleAutoFillFromURL();
