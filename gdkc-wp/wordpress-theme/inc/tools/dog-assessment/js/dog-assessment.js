/**
 * Dog Assessment Tool JavaScript
 * Handles form navigation, validation, and conditional field display
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Form elements
        const $form = $('#gdkc-dog-assessment');
        const $sections = $('.form-section');
        const $progressIndicator = $('.progress-indicator');
        const $steps = $('.step');
        const $prevButtons = $('.prev-step');
        const $nextButtons = $('.next-step');
        const totalSections = $sections.length;

        // Initialize
        let currentSection = 1;
        updateProgressBar();

        /**
         * Navigation: Next button click
         */
        $nextButtons.on('click', function() {
            // Validate current section before proceeding
            if (validateSection(currentSection)) {
                // Mark current step as completed
                $steps.filter('[data-step="' + currentSection + '"]').addClass('completed');
                
                // Move to next section
                currentSection++;
                showSection(currentSection);
                updateProgressBar();
                
                // Scroll to top of form
                scrollToTop();
            }
        });

        /**
         * Navigation: Previous button click
         */
        $prevButtons.on('click', function() {
            currentSection--;
            showSection(currentSection);
            updateProgressBar();
            scrollToTop();
        });

        /**
         * Step indicator click for direct navigation
         */
        $steps.on('click', function() {
            const clickedStep = parseInt($(this).data('step'));
            
            // Can only click on completed steps or the next available step
            if (clickedStep < currentSection || clickedStep === currentSection) {
                currentSection = clickedStep;
                showSection(currentSection);
                updateProgressBar();
                scrollToTop();
            }
        });

        /**
         * Form submission
         */
        $form.on('submit', function(e) {
            e.preventDefault();
            
            // Final validation
            if (!validateSection(currentSection)) {
                return false;
            }
            
            // Collect all form data
            const formData = new FormData(this);
            
            // Add action for WordPress
            formData.append('action', 'process_dog_assessment');
            
            // AJAX submission
            $.ajax({
                url: gdkcDogAssessment.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // Show loading state
                    $form.addClass('loading');
                    $form.find('button[type="submit"]').prop('disabled', true).text('Processing...');
                },
                success: function(response) {
                    if (response.success) {
                        // Redirect to results page if provided
                        if (response.data.redirect) {
                            window.location.href = response.data.redirect;
                        } else {
                            // Otherwise show success message
                            $form.html('<div class="submission-success"><h3>Assessment Submitted!</h3>' +
                                '<p>Thank you for completing our dog behavior assessment. We\'ll be in touch soon with personalized recommendations for your dog\'s training needs.</p></div>');
                        }
                    } else {
                        // Show error message
                        alert(response.data.message || 'There was an error processing your assessment. Please try again.');
                        $form.find('button[type="submit"]').prop('disabled', false).text('Submit Assessment');
                    }
                },
                error: function() {
                    // Handle AJAX error
                    alert('There was an error submitting your assessment. Please try again later.');
                    $form.removeClass('loading');
                    $form.find('button[type="submit"]').prop('disabled', false).text('Submit Assessment');
                }
            });
        });

        /**
         * Trigger conditional field display when related fields change
         */
        $('input[type="radio"], input[type="checkbox"], select').on('change', function() {
            handleConditionalFields();
        });

        // Initial check for conditional fields
        handleConditionalFields();

        /**
         * Functions
         */

        // Display the specified section
        function showSection(sectionNumber) {
            $sections.removeClass('active');
            $sections.filter('[data-section="' + sectionNumber + '"]').addClass('active');
            
            // Update step indicators
            $steps.removeClass('active');
            $steps.filter('[data-step="' + sectionNumber + '"]').addClass('active');
        }

        // Update progress bar
        function updateProgressBar() {
            const progressPercentage = ((currentSection - 1) / (totalSections - 1)) * 100;
            $progressIndicator.css('width', progressPercentage + '%');
        }

        // Handle conditional fields display
        function handleConditionalFields() {
            $('.conditional-field').each(function() {
                const $conditionalField = $(this);
                const conditionField = $conditionalField.data('condition');
                const conditionValue = $conditionalField.data('value');
                
                // For radio buttons
                if ($('input[name="' + conditionField + '"][value="' + conditionValue + '"]').is(':checked')) {
                    $conditionalField.slideDown(300);
                } 
                // For checkboxes (multiple values possible)
                else if ($('input[name="' + conditionField + '[]"][value="' + conditionValue + '"]').is(':checked')) {
                    $conditionalField.slideDown(300);
                }
                // For selects
                else if ($('select[name="' + conditionField + '"]').val() === conditionValue) {
                    $conditionalField.slideDown(300);
                }
                else {
                    $conditionalField.slideUp(300);
                }
            });
        }

        // Validate the current section
        function validateSection(sectionNumber) {
            let isValid = true;
            const $currentSection = $sections.filter('[data-section="' + sectionNumber + '"]');
            
            // Remove existing error messages
            $currentSection.find('.error-message').remove();
            
            // Check required fields
            $currentSection.find('[required]').each(function() {
                const $field = $(this);
                
                // Skip validation for hidden fields (in hidden conditional sections)
                if ($field.closest('.conditional-field').length && !$field.closest('.conditional-field').is(':visible')) {
                    return;
                }
                
                let fieldValid = true;
                
                // Different validation based on field type
                if ($field.is('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], textarea')) {
                    if (!$field.val().trim()) {
                        fieldValid = false;
                    }
                } 
                else if ($field.is('select')) {
                    if (!$field.val() || $field.val() === '') {
                        fieldValid = false;
                    }
                }
                else if ($field.is('input[type="radio"]')) {
                    const name = $field.attr('name');
                    if (!$('input[name="' + name + '"]:checked').length) {
                        fieldValid = false;
                    }
                }
                else if ($field.is('input[type="checkbox"]')) {
                    // For checkbox groups, we assume at least one checkbox should be checked
                    const name = $field.attr('name').replace('[]', '');
                    if (!$('input[name="' + name + '[]"]:checked').length) {
                        fieldValid = false;
                    }
                }
                
                // If field is invalid, add error message and update overall validation status
                if (!fieldValid) {
                    isValid = false;
                    
                    // Find the appropriate container for the error message
                    let $container;
                    if ($field.is('input[type="radio"], input[type="checkbox"]')) {
                        $container = $field.closest('.radio-group, .checkbox-group');
                    } else {
                        $container = $field.parent();
                    }
                    
                    // Add error message if it doesn't already exist
                    if (!$container.find('.error-message').length) {
                        $container.append('<div class="error-message">This field is required</div>');
                    }
                    
                    // Highlight the first invalid field
                    if (!$firstInvalidField) {
                        $firstInvalidField = $field;
                    }
                }
            });
            
            // Scroll to first invalid field if validation failed
            if (!isValid && $firstInvalidField) {
                $('html, body').animate({
                    scrollTop: $firstInvalidField.offset().top - 100
                }, 300);
            }
            
            return isValid;
        }

        // Scroll to top of form
        function scrollToTop() {
            $('html, body').animate({
                scrollTop: $form.offset().top - 50
            }, 300);
        }
    });

})(jQuery);