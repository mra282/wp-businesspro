/**
 * Demo Content Import JavaScript
 * Handles the AJAX import process for BusinessPro demo content
 *
 * @package BusinessPro
 */

jQuery(document).ready(function($) {
    'use strict';

    const importButton = $('#import-demo-btn');
    const importStatus = $('#import-status');
    const importProgress = $('#import-progress');
    const progressBar = $('.progress-fill');
    const progressText = $('#progress-text');

    // Import steps
    const importSteps = [
        { step: 'services', label: 'Importing services...' },
        { step: 'portfolio', label: 'Importing portfolio items...' },
        { step: 'testimonials', label: 'Importing testimonials...' },
        { step: 'customizer', label: 'Configuring theme settings...' }
    ];

    let currentStep = 0;

    // Handle import button click
    importButton.on('click', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to import the AI Developer demo content? This will add new content to your website.')) {
            startImport();
        }
    });

    /**
     * Start the import process
     */
    function startImport() {
        // Disable the import button
        importButton.prop('disabled', true).text(businesspro_demo.importing);
        
        // Show progress bar
        importProgress.show();
        
        // Reset progress
        currentStep = 0;
        updateProgress(0);
        
        // Start importing
        importNextStep();
    }

    /**
     * Import the next step in the process
     */
    function importNextStep() {
        if (currentStep >= importSteps.length) {
            // Import completed
            completeImport();
            return;
        }

        const step = importSteps[currentStep];
        
        // Update progress text
        progressText.text(step.label);
        
        // Make AJAX request
        $.ajax({
            url: businesspro_demo.ajax_url,
            type: 'POST',
            data: {
                action: 'businesspro_import_demo',
                step: step.step,
                nonce: businesspro_demo.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Move to next step
                    currentStep++;
                    updateProgress((currentStep / importSteps.length) * 100);
                    
                    // Small delay for better UX
                    setTimeout(importNextStep, 500);
                } else {
                    handleError(response.data || businesspro_demo.error);
                }
            },
            error: function(xhr, status, error) {
                handleError('AJAX Error: ' + error);
            }
        });
    }

    /**
     * Update progress bar
     */
    function updateProgress(percentage) {
        progressBar.css('width', percentage + '%');
    }

    /**
     * Complete the import process
     */
    function completeImport() {
        // Update progress to 100%
        updateProgress(100);
        progressText.text('Import completed successfully!');
        
        // Show success message
        importStatus.html('<span style="color: #46b450; font-weight: bold;">✓ ' + businesspro_demo.success + '</span>');
        
        // Update button
        importButton.text('Demo Content Imported').removeClass('button-primary').addClass('button-disabled');
        
        // Show success actions
        setTimeout(function() {
            const successActions = $('<div class="demo-success-actions" style="margin-top: 20px; padding: 15px; background: #dff0d8; border: 1px solid #d6e9c6; border-radius: 4px;">' +
                '<h4 style="margin-top: 0; color: #3c763d;">🎉 Demo content imported successfully!</h4>' +
                '<p style="color: #3c763d;">You can now:</p>' +
                '<ul style="color: #3c763d;">' +
                '<li><a href="' + window.location.origin + '" target="_blank">View your website</a> to see the imported content</li>' +
                '<li><a href="' + businesspro_demo.admin_url + 'edit.php?post_type=service">Edit Services</a> to customize your offerings</li>' +
                '<li><a href="' + businesspro_demo.admin_url + 'edit.php?post_type=portfolio">Edit Portfolio</a> to add your projects</li>' +
                '<li><a href="' + businesspro_demo.admin_url + 'edit.php?post_type=testimonials">Edit Testimonials</a> to manage reviews</li>' +
                '<li><a href="' + businesspro_demo.admin_url + 'customize.php">Customize Theme</a> to match your brand</li>' +
                '</ul>' +
                '</div>');
            
            $('.demo-actions').after(successActions);
        }, 1000);
    }

    /**
     * Handle import errors
     */
    function handleError(message) {
        // Show error message
        importStatus.html('<span style="color: #dc3232; font-weight: bold;">✗ Error: ' + message + '</span>');
        
        // Re-enable button
        importButton.prop('disabled', false).text('Retry Import');
        
        // Hide progress
        importProgress.hide();
        
        console.error('Demo import error:', message);
    }
});
