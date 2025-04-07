/**
 * Good Dogz KC - Homepage Sections JavaScript
 * Handles interactive functionality for homepage sections
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        // Initialize transformation slider
        initTransformationSlider();
        
        // Initialize issue tabs
        initIssueTabs();
        
        // Initialize FAQ accordions
        initFaqAccordions();
    });
    
    /**
     * Initialize the before/after transformation slider
     */
    function initTransformationSlider() {
        const sliders = document.querySelectorAll('.transformation-slider');
        
        sliders.forEach(slider => {
            const handle = slider.querySelector('.slider-handle');
            const beforeImage = slider.querySelector('.before-image');
            
            if (!handle || !beforeImage) return;
            
            let isDragging = false;
            
            // Mouse events
            handle.addEventListener('mousedown', () => {
                isDragging = true;
            });
            
            document.addEventListener('mouseup', () => {
                isDragging = false;
            });
            
            slider.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                updateSliderPosition(e.clientX, slider, beforeImage);
            });
            
            // Touch events for mobile
            handle.addEventListener('touchstart', () => {
                isDragging = true;
            });
            
            document.addEventListener('touchend', () => {
                isDragging = false;
            });
            
            slider.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                updateSliderPosition(e.touches[0].clientX, slider, beforeImage);
            });
            
            // Initial click position
            slider.addEventListener('click', (e) => {
                updateSliderPosition(e.clientX, slider, beforeImage);
            });
        });
    }
    
    /**
     * Update the slider position
     */
    function updateSliderPosition(clientX, slider, beforeImage) {
        const rect = slider.getBoundingClientRect();
        const position = clientX - rect.left;
        const percentage = (position / rect.width) * 100;
        
        if (percentage < 0) return;
        if (percentage > 100) return;
        
        beforeImage.style.width = `${percentage}%`;
        slider.querySelector('.slider-handle').style.left = `${percentage}%`;
    }
    
    /**
     * Initialize the issue tabs in problem-solution section
     */
    function initIssueTabs() {
        $('.issue-button').on('click', function() {
            const issue = $(this).data('issue');
            
            // Update active button
            $('.issue-button').removeClass('active');
            $(this).addClass('active');
            
            // Show the correct content
            $('.issue-content').removeClass('active');
            $(`#${issue}-content`).addClass('active');
        });
    }
    
    /**
     * Initialize FAQ accordions
     */
    function initFaqAccordions() {
        // FAQ toggle buttons
        $('.faq-toggle').on('click', function() {
            const $button = $(this);
            const $answer = $button.closest('.faq-item').find('.faq-answer');
            const isExpanded = $button.attr('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            $button.attr('aria-expanded', !isExpanded);
            
            // Toggle icon
            if (isExpanded) {
                $button.find('i').removeClass('fa-minus').addClass('fa-plus');
            } else {
                $button.find('i').removeClass('fa-plus').addClass('fa-minus');
            }
            
            // Toggle answer visibility
            $answer.prop('hidden', isExpanded);
        });
        
        // FAQ category filters
        $('.faq-category').on('click', function() {
            const category = $(this).data('category');
            
            // Update active button
            $('.faq-category').removeClass('active');
            $(this).addClass('active');
            
            // Show/hide FAQ items
            if (category === 'all') {
                $('.faq-item').show();
            } else {
                $('.faq-item').hide();
                $(`.faq-item[data-category="${category}"]`).show();
            }
        });
    }
    
})(jQuery);