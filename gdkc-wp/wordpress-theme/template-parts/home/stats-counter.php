<?php
/**
 * Template part for displaying an animated statistics counter section
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Default stats if not provided
$default_stats = [
    [
        'number' => '500',
        'label' => 'Dogs Transformed',
        'icon' => 'fas fa-dog',
        'has_plus' => true
    ],
    [
        'number' => '5',
        'label' => 'Years Experience',
        'icon' => 'fas fa-calendar-alt',
        'has_plus' => true
    ],
    [
        'number' => '98',
        'label' => 'Success Rate',
        'icon' => 'fas fa-check-circle',
        'has_plus' => false,
        'suffix' => '%'
    ],
    [
        'number' => '30',
        'label' => 'Day Guarantee',
        'icon' => 'fas fa-shield-alt',
        'has_plus' => false
    ]
];

// Allow for custom stats to be passed to this template part
$stats = isset($args['stats']) ? $args['stats'] : $default_stats;
$section_title = isset($args['section_title']) ? $args['section_title'] : get_theme_mod('stats_counter_title', 'Our Impact');
$section_id = isset($args['section_id']) ? $args['section_id'] : 'stats';
$section_bg_color = isset($args['bg_color']) ? $args['bg_color'] : get_theme_mod('stats_counter_bg_color', '');
?>

<!-- Animated Statistics Counter Section -->
<section class="stats-counter-section" id="<?php echo esc_attr($section_id); ?>" <?php echo $section_bg_color ? 'style="background-color: ' . esc_attr($section_bg_color) . ';"' : ''; ?>>
    <div class="container">
        <?php if ($section_title) : ?>
        <h2 class="section-title light text-center"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>
        
        <div class="stats-counter-grid">
            <?php foreach ($stats as $stat) : 
                $has_plus = isset($stat['has_plus']) && $stat['has_plus'];
                $suffix = isset($stat['suffix']) ? $stat['suffix'] : '';
            ?>
            <div class="stats-counter-item">
                <?php if (!empty($stat['icon'])) : ?>
                <div class="stats-counter-icon">
                    <i class="<?php echo esc_attr($stat['icon']); ?>"></i>
                </div>
                <?php endif; ?>
                
                <div class="stats-counter-number <?php echo $has_plus ? 'has-plus' : ''; ?>" data-count="<?php echo esc_attr($stat['number']); ?>">
                    0<?php echo esc_html($suffix); ?>
                </div>
                
                <div class="stats-counter-label">
                    <?php echo esc_html($stat['label']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="stats-counter-bg"></div>
    
    <script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.stats-counter-number');
            let hasAnimated = false;
            
            function animateCounters() {
                if (hasAnimated) return;
                
                const counterSection = document.querySelector('.stats-counter-section');
                const sectionTop = counterSection.getBoundingClientRect().top;
                
                if (sectionTop < window.innerHeight - 100) {
                    hasAnimated = true;
                    
                    counters.forEach(counter => {
                        counter.closest('.stats-counter-item').classList.add('animate');
                        
                        const target = parseInt(counter.getAttribute('data-count'));
                        const suffix = counter.innerHTML.replace(/[0-9]/g, '');
                        let count = 0;
                        const duration = 2000; // ms
                        const interval = Math.ceil(duration / target);
                        
                        const timer = setInterval(() => {
                            count += 1;
                            counter.textContent = count + suffix;
                            
                            if (count >= target) {
                                clearInterval(timer);
                            }
                        }, interval);
                    });
                }
            }
            
            // Initial check
            animateCounters();
            
            // Check on scroll
            window.addEventListener('scroll', animateCounters);
        });
    })();
    </script>
</section>