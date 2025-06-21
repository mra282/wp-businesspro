<?php
/**
 * Demo Content Importer for BusinessPro Theme
 * Optional demo content for AI/Developer professionals
 *
 * @package BusinessPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Demo Content Importer Class
 */
class BusinessPro_Demo_Content {
    
    /**
     * Initialize the demo content importer
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_businesspro_import_demo', array($this, 'import_demo_content'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Add admin menu for demo content importer
     */
    public function add_admin_menu() {
        add_theme_page(
            __('Demo Content', 'businesspro'),
            __('Import Demo Content', 'businesspro'),
            'manage_options',
            'businesspro-demo-content',
            array($this, 'demo_content_page')
        );
    }
    
    /**
     * Enqueue scripts for demo content page
     */
    public function enqueue_scripts($hook) {
        if ($hook !== 'appearance_page_businesspro-demo-content') {
            return;
        }
        
        wp_enqueue_script('businesspro-demo-import', get_template_directory_uri() . '/js/demo-import.js', array('jquery'), '1.0.0', true);
        wp_localize_script('businesspro-demo-import', 'businesspro_demo', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'admin_url' => admin_url(),
            'nonce' => wp_create_nonce('businesspro_demo_nonce'),
            'importing' => __('Importing...', 'businesspro'),
            'success' => __('Demo content imported successfully!', 'businesspro'),
            'error' => __('Error importing demo content.', 'businesspro')
        ));
    }
    
    /**
     * Demo content admin page
     */
    public function demo_content_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('BusinessPro Demo Content', 'businesspro'); ?></h1>
            
            <div class="card" style="max-width: 800px;">
                <h2><?php esc_html_e('AI Developer Demo Content', 'businesspro'); ?></h2>
                <p><?php esc_html_e('Import professionally crafted demo content tailored for AI developers, Python specialists, and WordPress professionals. This will showcase your technical expertise and help you get started quickly.', 'businesspro'); ?></p>
                
                <div class="demo-preview" style="margin: 20px 0;">
                    <h3><?php esc_html_e('What will be imported:', 'businesspro'); ?></h3>
                    <ul>
                        <li><strong><?php esc_html_e('Services:', 'businesspro'); ?></strong> <?php esc_html_e('AI Development, Python Programming, WordPress Development, JavaScript/React, Machine Learning, API Development', 'businesspro'); ?></li>
                        <li><strong><?php esc_html_e('Portfolio:', 'businesspro'); ?></strong> <?php esc_html_e('Sample AI projects, web applications, and development work', 'businesspro'); ?></li>
                        <li><strong><?php esc_html_e('Testimonials:', 'businesspro'); ?></strong> <?php esc_html_e('Client reviews for technical projects', 'businesspro'); ?></li>
                        <li><strong><?php esc_html_e('About Content:', 'businesspro'); ?></strong> <?php esc_html_e('Professional developer bio and expertise', 'businesspro'); ?></li>
                        <li><strong><?php esc_html_e('Contact Info:', 'businesspro'); ?></strong> <?php esc_html_e('Sample contact details and business hours', 'businesspro'); ?></li>
                    </ul>
                </div>
                
                <div class="notice notice-info">
                    <p><strong><?php esc_html_e('Note:', 'businesspro'); ?></strong> <?php esc_html_e('This is completely optional. You can customize or remove any imported content later. Existing content will not be overwritten.', 'businesspro'); ?></p>
                </div>
                
                <div class="demo-actions" style="margin-top: 20px;">
                    <button id="import-demo-btn" class="button button-primary button-large">
                        <?php esc_html_e('Import AI Developer Demo Content', 'businesspro'); ?>
                    </button>
                    <span id="import-status" style="margin-left: 10px;"></span>
                </div>
                
                <div id="import-progress" style="display: none; margin-top: 20px;">
                    <div class="progress-bar" style="background: #f1f1f1; border-radius: 3px; overflow: hidden;">
                        <div class="progress-fill" style="width: 0%; height: 20px; background: #0073aa; transition: width 0.3s;"></div>
                    </div>
                    <p id="progress-text" style="margin-top: 10px;"><?php esc_html_e('Preparing import...', 'businesspro'); ?></p>
                </div>
            </div>
            
            <div class="card" style="max-width: 800px; margin-top: 20px;">
                <h3><?php esc_html_e('Already imported demo content?', 'businesspro'); ?></h3>
                <p><?php esc_html_e('You can customize all imported content through the WordPress admin:', 'businesspro'); ?></p>
                <ul>
                    <li><a href="<?php echo admin_url('edit.php?post_type=service'); ?>"><?php esc_html_e('Edit Services', 'businesspro'); ?></a></li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=portfolio'); ?>"><?php esc_html_e('Edit Portfolio', 'businesspro'); ?></a></li>
                    <li><a href="<?php echo admin_url('edit.php?post_type=testimonials'); ?>"><?php esc_html_e('Edit Testimonials', 'businesspro'); ?></a></li>
                    <li><a href="<?php echo admin_url('customize.php'); ?>"><?php esc_html_e('Customize Theme Settings', 'businesspro'); ?></a></li>
                </ul>
            </div>
        </div>
        <?php
    }
    
    /**
     * AJAX handler for importing demo content
     */
    public function import_demo_content() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'businesspro_demo_nonce')) {
            wp_die(__('Security check failed', 'businesspro'));
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die(__('Insufficient permissions', 'businesspro'));
        }
        
        $step = sanitize_text_field($_POST['step']);
        $response = array('success' => false);
        
        switch ($step) {
            case 'services':
                $response = $this->import_services();
                break;
            case 'portfolio':
                $response = $this->import_portfolio();
                break;
            case 'testimonials':
                $response = $this->import_testimonials();
                break;
            case 'customizer':
                $response = $this->import_customizer_settings();
                break;
            default:
                $response['message'] = __('Invalid step', 'businesspro');
        }
        
        wp_send_json($response);
    }
    
    /**
     * Import demo services
     */
    private function import_services() {
        $services = array(
            array(
                'title' => 'AI Development & Consulting',
                'content' => 'Specialized AI solutions including machine learning models, natural language processing, computer vision, and intelligent automation systems. From concept to deployment, I help businesses leverage artificial intelligence to solve complex problems and gain competitive advantages.',
                'icon' => 'fas fa-robot',
                'price' => '$150/hour',
                'features' => array('Machine Learning Models', 'Neural Networks', 'AI Strategy Consulting', 'Model Deployment'),
                'cta_text' => 'Discuss AI Project',
                'cta_link' => '#contact'
            ),
            array(
                'title' => 'Python Development',
                'content' => 'Full-stack Python development for web applications, data analysis, automation scripts, and backend systems. Expert in Django, Flask, FastAPI, pandas, NumPy, and modern Python frameworks for scalable, maintainable solutions.',
                'icon' => 'fab fa-python',
                'price' => '$120/hour',
                'features' => array('Django/Flask Apps', 'Data Analysis', 'API Development', 'Automation Scripts'),
                'cta_text' => 'Start Python Project',
                'cta_link' => '#contact'
            ),
            array(
                'title' => 'WordPress Development',
                'content' => 'Custom WordPress themes, plugins, and full-scale website development. Specializing in headless WordPress, custom post types, advanced custom fields, and performance optimization for enterprise-level WordPress solutions.',
                'icon' => 'fab fa-wordpress',
                'price' => '$100/hour',
                'features' => array('Custom Themes', 'Plugin Development', 'WooCommerce', 'Performance Optimization'),
                'cta_text' => 'Build WordPress Site',
                'cta_link' => '#contact'
            ),
            array(
                'title' => 'JavaScript & React Development',
                'content' => 'Modern frontend development with React, Vue.js, and vanilla JavaScript. Creating responsive, interactive web applications with optimal performance, clean code architecture, and seamless user experiences.',
                'icon' => 'fab fa-js-square',
                'price' => '$110/hour',
                'features' => array('React Applications', 'Vue.js Projects', 'JavaScript ES6+', 'Frontend Optimization'),
                'cta_text' => 'Build Web App',
                'cta_link' => '#contact'
            ),
            array(
                'title' => 'Machine Learning Solutions',
                'content' => 'End-to-end machine learning pipelines from data preprocessing to model deployment. Expertise in supervised and unsupervised learning, deep learning, time series analysis, and MLOps for production systems.',
                'icon' => 'fas fa-brain',
                'price' => '$160/hour',
                'features' => array('Predictive Models', 'Deep Learning', 'Data Pipeline', 'MLOps'),
                'cta_text' => 'Explore ML Solutions',
                'cta_link' => '#contact'
            ),
            array(
                'title' => 'API Development & Integration',
                'content' => 'RESTful and GraphQL API development, third-party integrations, and microservices architecture. Building secure, scalable APIs with comprehensive documentation and testing suites.',
                'icon' => 'fas fa-code',
                'price' => '$130/hour',
                'features' => array('REST APIs', 'GraphQL', 'Microservices', 'API Documentation'),
                'cta_text' => 'Design API',
                'cta_link' => '#contact'
            )
        );
        
        $imported = 0;
        foreach ($services as $service_data) {
            $post_id = wp_insert_post(array(
                'post_title' => $service_data['title'],
                'post_content' => $service_data['content'],
                'post_type' => 'service',
                'post_status' => 'publish',
                'meta_input' => array(
                    '_service_icon' => $service_data['icon'],
                    '_service_price' => $service_data['price'],
                    '_service_features' => implode("\n", $service_data['features']),
                    '_service_cta_text' => $service_data['cta_text'],
                    '_service_cta_link' => $service_data['cta_link'],
                    '_service_show_on_homepage' => 'yes'
                )
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                $imported++;
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(__('%d services imported successfully', 'businesspro'), $imported)
        );
    }
    
    /**
     * Import demo portfolio items
     */
    private function import_portfolio() {
        $portfolio_items = array(
            array(
                'title' => 'AI-Powered Customer Support Chatbot',
                'content' => 'Developed an intelligent chatbot using natural language processing and machine learning to handle customer inquiries automatically. The system reduced response time by 90% and handles 80% of customer queries without human intervention.',
                'category' => 'AI Development',
                'technologies' => 'Python, TensorFlow, NLTK, Flask, Docker',
                'client' => 'TechCorp Solutions',
                'date' => '2024-12-01',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1531746790731-6c087fecd65a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ),
            array(
                'title' => 'E-commerce Analytics Dashboard',
                'content' => 'Built a comprehensive analytics dashboard for an e-commerce platform using Python and React. Features real-time sales tracking, customer behavior analysis, and predictive inventory management.',
                'category' => 'Python Development',
                'technologies' => 'Python, Django, React, PostgreSQL, Chart.js',
                'client' => 'RetailMax Inc.',
                'date' => '2024-11-15',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ),
            array(
                'title' => 'Custom WordPress LMS Platform',
                'content' => 'Created a learning management system as a custom WordPress theme with course management, progress tracking, and payment integration. Supports video streaming, quizzes, and certificates.',
                'category' => 'WordPress Development',
                'technologies' => 'WordPress, PHP, MySQL, JavaScript, Stripe API',
                'client' => 'EduLearn Academy',
                'date' => '2024-10-20',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ),
            array(
                'title' => 'React Task Management App',
                'content' => 'Developed a collaborative task management application with real-time updates, team collaboration features, and advanced filtering. Built with React hooks and modern JavaScript patterns.',
                'category' => 'JavaScript Development',
                'technologies' => 'React, Node.js, Socket.io, MongoDB, Material-UI',
                'client' => 'ProductiveTeams',
                'date' => '2024-09-30',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ),
            array(
                'title' => 'Predictive Maintenance ML Model',
                'content' => 'Implemented a machine learning solution to predict equipment failures in manufacturing. Uses sensor data to forecast maintenance needs, reducing downtime by 60% and maintenance costs by 40%.',
                'category' => 'Machine Learning',
                'technologies' => 'Python, Scikit-learn, TensorFlow, Pandas, AWS',
                'client' => 'ManufacturingPro',
                'date' => '2024-08-25',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1518186285589-2f7649de83e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            ),
            array(
                'title' => 'Multi-Platform API Gateway',
                'content' => 'Designed and built a scalable API gateway handling multiple microservices with authentication, rate limiting, and comprehensive logging. Supports both REST and GraphQL endpoints.',
                'category' => 'API Development',
                'technologies' => 'Node.js, Express, GraphQL, Redis, Docker, AWS',
                'client' => 'MicroSoft Solutions',
                'date' => '2024-07-10',
                'project_url' => '#',
                'image_url' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'
            )
        );
        
        $imported = 0;
        foreach ($portfolio_items as $item_data) {
            $post_id = wp_insert_post(array(
                'post_title' => $item_data['title'],
                'post_content' => $item_data['content'],
                'post_type' => 'portfolio',
                'post_status' => 'publish',
                'meta_input' => array(
                    '_portfolio_category' => $item_data['category'],
                    '_portfolio_technologies' => $item_data['technologies'],
                    '_portfolio_client' => $item_data['client'],
                    '_portfolio_date' => $item_data['date'],
                    '_portfolio_url' => $item_data['project_url'],
                    '_portfolio_image_url' => $item_data['image_url']
                )
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                $imported++;
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(__('%d portfolio items imported successfully', 'businesspro'), $imported)
        );
    }
    
    /**
     * Import demo testimonials
     */
    private function import_testimonials() {
        $testimonials = array(
            array(
                'title' => 'Outstanding AI Implementation',
                'content' => 'The AI chatbot solution exceeded our expectations. It transformed our customer support and significantly improved response times. The technical expertise and attention to detail were remarkable.',
                'author' => 'Sarah Chen',
                'company' => 'TechCorp Solutions',
                'role' => 'CTO',
                'rating' => 5,
                'project' => 'AI Chatbot Development'
            ),
            array(
                'title' => 'Exceptional Python Development',
                'content' => 'The analytics dashboard is exactly what we needed. Clean code, excellent performance, and delivered on time. The data insights have already helped us make better business decisions.',
                'author' => 'Michael Rodriguez',
                'company' => 'RetailMax Inc.',
                'role' => 'VP of Technology',
                'rating' => 5,
                'project' => 'E-commerce Analytics'
            ),
            array(
                'title' => 'Professional WordPress Expertise',
                'content' => 'Our custom LMS platform is fantastic. Students love the interface and the functionality is robust. The payment integration and course management features work flawlessly.',
                'author' => 'Dr. Emma Thompson',
                'company' => 'EduLearn Academy',
                'role' => 'Director of Technology',
                'rating' => 5,
                'project' => 'WordPress LMS'
            ),
            array(
                'title' => 'Brilliant React Development',
                'content' => 'The task management app has revolutionized how our teams collaborate. The real-time features are seamless and the user experience is intuitive. Highly recommended!',
                'author' => 'James Wilson',
                'company' => 'ProductiveTeams',
                'role' => 'Product Manager',
                'rating' => 5,
                'project' => 'React Task Manager'
            ),
            array(
                'title' => 'Game-Changing ML Solution',
                'content' => 'The predictive maintenance model has saved us hundreds of thousands in unexpected downtime. The accuracy is impressive and the ROI was immediate.',
                'author' => 'Lisa Park',
                'company' => 'ManufacturingPro',
                'role' => 'Operations Director',
                'rating' => 5,
                'project' => 'Machine Learning Model'
            )
        );
        
        $imported = 0;
        foreach ($testimonials as $testimonial_data) {
            $post_id = wp_insert_post(array(
                'post_title' => $testimonial_data['title'],
                'post_content' => $testimonial_data['content'],
                'post_type' => 'testimonials',
                'post_status' => 'publish',
                'meta_input' => array(
                    '_testimonial_author' => $testimonial_data['author'],
                    '_testimonial_company' => $testimonial_data['company'],
                    '_testimonial_role' => $testimonial_data['role'],
                    '_testimonial_rating' => $testimonial_data['rating'],
                    '_testimonial_project' => $testimonial_data['project']
                )
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                $imported++;
            }
        }
        
        return array(
            'success' => true,
            'message' => sprintf(__('%d testimonials imported successfully', 'businesspro'), $imported)
        );
    }
    
    /**
     * Import customizer settings
     */
    private function import_customizer_settings() {
        $settings = array(
            // Hero Section
            'hero_title' => 'AI Developer & Technical Consultant',
            'hero_subtitle' => 'Transforming businesses through artificial intelligence, machine learning, and cutting-edge development solutions',
            
            // About Section
            'about_title' => 'About Me',
            'about_text_1' => 'I\'m a passionate AI developer and technical consultant specializing in machine learning, Python development, and modern web technologies. With expertise in artificial intelligence, data science, and full-stack development, I help businesses leverage technology to solve complex problems and drive innovation.',
            'about_text_2' => 'From building intelligent chatbots to developing predictive models, I bring cutting-edge AI solutions to life. My technical stack includes Python, TensorFlow, React, WordPress, and cloud platforms, enabling me to deliver comprehensive solutions from concept to deployment.',
            
            // Certifications
            'certification_1' => 'AWS Certified Machine Learning Specialist',
            'certification_2' => 'Google Cloud Professional AI Engineer',
            'certification_3' => 'Microsoft Azure AI Solutions Expert',
            'certification_4' => 'TensorFlow Developer Certificate',
            
            // Services Section
            'services_section_title' => 'Technical Expertise',
            'services_section_subtitle' => 'Comprehensive AI and development services to accelerate your digital transformation',
            
            // Contact Information
            'contact_email' => 'hello@aidev.pro',
            'contact_phone' => '(555) 123-AI-DEV',
            'business_hours' => 'Monday - Friday: 9:00 AM - 6:00 PM PST<br>Weekend consultations available',
            'business_certifications' => 'AWS Certified • Google Cloud Professional • Microsoft Azure Expert',
            
            // Footer
            'footer_company_name' => 'AI Developer Pro',
            'footer_company_description' => 'Specialized AI development and technical consulting services. Transforming businesses through artificial intelligence and modern technology solutions.',
            
            // Colors (optional - keeping theme defaults but can be customized)
            'primary_color' => '#1e40af',
            'accent_color' => '#f97316'
        );
        
        foreach ($settings as $setting => $value) {
            set_theme_mod($setting, $value);
        }
        
        return array(
            'success' => true,
            'message' => __('Theme settings imported successfully', 'businesspro')
        );
    }
}

// Initialize the demo content importer
if (is_admin()) {
    new BusinessPro_Demo_Content();
}
