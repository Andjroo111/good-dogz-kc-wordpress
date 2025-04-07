<?php
/**
 * Template part for displaying an interactive timeline section
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Default timeline items if not provided
$default_items = [
    [
        'week' => '1',
        'title' => 'Initial Assessment',
        'description' => 'We start with a thorough evaluation of your dog\'s behavior, history, and your specific goals to create a customized training plan.',
        'progress' => '20',
        'image' => '',
        'icon' => 'fas fa-clipboard-check'
    ],
    [
        'week' => '2',
        'title' => 'Foundation Training',
        'description' => 'We establish basic commands and boundaries, focusing on impulse control and building a solid foundation of reliable behaviors.',
        'progress' => '40',
        'image' => '',
        'icon' => 'fas fa-dog'
    ],
    [
        'week' => '3',
        'title' => 'Behavior Modification',
        'description' => 'We directly address problem behaviors using proven techniques that address the root cause, not just the symptoms.',
        'progress' => '60',
        'image' => '',
        'icon' => 'fas fa-exchange-alt'
    ],
    [
        'week' => '4',
        'title' => 'Real-World Practice',
        'description' => 'Training moves to different environments with increasing distractions to ensure behaviors are reliable anywhere.',
        'progress' => '80',
        'image' => '',
        'icon' => 'fas fa-map-marked-alt'
    ],
    [
        'week' => '5',
        'title' => 'Handler Training & Maintenance',
        'description' => 'We focus on teaching you the techniques to maintain your dog\'s new behaviors long-term with ongoing support.',
        'progress' => '100',
        'image' => '',
        'icon' => 'fas fa-user-graduate'
    ]
];

// Allow for custom items to be passed to this template part
$timeline_items = isset($args['timeline_items']) ? $args['timeline_items'] : $default_items;
$section_title = isset($args['section_title']) ? $args['section_title'] : get_theme_mod('timeline_section_title', 'Your Dog\'s Training Journey');
$section_subtitle = isset($args['section_subtitle']) ? $args['section_subtitle'] : get_theme_mod('timeline_section_subtitle', 'What to expect during our training program');
$section_id = isset($args['section_id']) ? $args['section_id'] : 'training-journey';
?>

<!-- Timeline Section -->
<section class="timeline-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <?php if ($section_subtitle) : ?>
            <p class="section-subtitle text-center"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>
        
        <div class="timeline-container">
            <div class="timeline-track"></div>
            
            <div class="timeline-items">
                <?php foreach ($timeline_items as $index => $item) : ?>
                <div class="timeline-item" data-week="<?php echo esc_attr($item['week']); ?>">
                    <div class="timeline-content">
                        <span class="timeline-date">Week <?php echo esc_html($item['week']); ?></span>
                        <h3 class="timeline-title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="timeline-description"><?php echo esc_html($item['description']); ?></p>
                        
                        <?php if (!empty($item['progress'])) : ?>
                        <div class="timeline-progress">
                            <div class="timeline-progress-bar" style="width: <?php echo esc_attr($item['progress']); ?>%;"></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['image'])) : ?>
                        <img src="<?php echo esc_url($item['image']); ?>" alt="Week <?php echo esc_attr($item['week']); ?> - <?php echo esc_attr($item['title']); ?>" class="timeline-image">
                        <?php endif; ?>
                    </div>
                    
                    <div class="timeline-marker" data-week="<?php echo esc_attr($item['week']); ?>">
                        <?php if (!empty($item['icon'])) : ?>
                        <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                        <?php else : ?>
                        <?php echo esc_html($item['week']); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <a href="<?php echo get_theme_mod('timeline_cta_url', '#contact'); ?>" class="gdkc-button primary">
                <?php echo get_theme_mod('timeline_cta_text', 'Start Your Dog\'s Transformation'); ?>
            </a>
        </div>
    </div>
</section>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize timeline interactions
        const timelineMarkers = document.querySelectorAll('.timeline-marker');
        const timelineItems = document.querySelectorAll('.timeline-item');
        
        timelineMarkers.forEach(marker => {
            marker.addEventListener('click', function() {
                const week = this.getAttribute('data-week');
                
                // Remove active class from all markers
                timelineMarkers.forEach(m => m.classList.remove('active'));
                
                // Add active class to clicked marker
                this.classList.add('active');
                
                // Highlight the corresponding item
                timelineItems.forEach(item => {
                    if (item.getAttribute('data-week') === week) {
                        item.querySelector('.timeline-content').classList.add('highlight');
                        setTimeout(() => {
                            item.querySelector('.timeline-content').classList.remove('highlight');
                        }, 1500);
                    }
                });
            });
        });
        
        // Animate progress bars on scroll
        const progressBars = document.querySelectorAll('.timeline-progress-bar');
        
        function animateProgressBars() {
            progressBars.forEach(bar => {
                const barTop = bar.getBoundingClientRect().top;
                const barBottom = bar.getBoundingClientRect().bottom;
                
                if (barTop < window.innerHeight && barBottom > 0) {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 200);
                }
            });
        }
        
        // Initial animation
        setTimeout(animateProgressBars, 500);
        
        // Animate on scroll
        window.addEventListener('scroll', function() {
            requestAnimationFrame(animateProgressBars);
        });
    });
})();
</script>