<?php
/**
 * Template part for displaying a success stories gallery section
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Default success stories if not provided
$default_stories = [
    [
        'name' => 'Max',
        'breed' => 'German Shepherd',
        'issue' => 'Aggression',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Our German Shepherd was aggressive toward other dogs. After 4 weeks of training, he can now calmly walk past other dogs without reacting.',
        'owner' => 'David & Sarah',
        'duration' => '4 weeks'
    ],
    [
        'name' => 'Bella',
        'breed' => 'Labrador Retriever',
        'issue' => 'Leash Pulling',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Bella would pull so hard on walks that I stopped taking her out. Now she walks calmly by my side, even with distractions around.',
        'owner' => 'Jennifer',
        'duration' => '3 weeks'
    ],
    [
        'name' => 'Cooper',
        'breed' => 'Border Collie Mix',
        'issue' => 'Anxiety',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Cooper would destroy our house whenever we left. Now he can comfortably stay home alone without stress or destruction.',
        'owner' => 'Michael',
        'duration' => '6 weeks'
    ],
    [
        'name' => 'Luna',
        'breed' => 'Pit Bull',
        'issue' => 'Reactivity',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Luna was so reactive on walks that we couldn\'t take her anywhere. Now she remains calm around other dogs and people.',
        'owner' => 'Jessica & Mark',
        'duration' => '5 weeks'
    ],
    [
        'name' => 'Charlie',
        'breed' => 'Golden Retriever',
        'issue' => 'Basic Obedience',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Charlie knew no commands and would jump on everyone. Now he responds reliably to all basic commands and is a joy to be around.',
        'owner' => 'Samantha',
        'duration' => '3 weeks'
    ],
    [
        'name' => 'Daisy',
        'breed' => 'Beagle',
        'issue' => 'Barking',
        'before_image' => '',
        'after_image' => '',
        'testimonial' => 'Daisy would bark at everything that moved. Our neighbors were getting frustrated. Now she\'s calm and quiet, even when the doorbell rings.',
        'owner' => 'Ryan & Emily',
        'duration' => '4 weeks'
    ]
];

// Allow for custom stories to be passed to this template part
$stories = isset($args['stories']) ? $args['stories'] : $default_stories;
$section_title = isset($args['section_title']) ? $args['section_title'] : get_theme_mod('success_gallery_title', 'Transformation Stories');
$section_subtitle = isset($args['section_subtitle']) ? $args['section_subtitle'] : get_theme_mod('success_gallery_subtitle', 'See how we\'ve helped transform dogs and their families');
$section_id = isset($args['section_id']) ? $args['section_id'] : 'success-stories';

// Create a list of unique issues for filtering
$issues = [];
foreach ($stories as $story) {
    if (!in_array($story['issue'], $issues)) {
        $issues[] = $story['issue'];
    }
}
sort($issues);
?>

<!-- Success Stories Gallery Section -->
<section class="success-gallery-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <?php if ($section_subtitle) : ?>
            <p class="section-subtitle text-center"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>
        
        <!-- Filters -->
        <div class="success-gallery-filters">
            <button class="success-gallery-filter active" data-filter="all">All Stories</button>
            <?php foreach ($issues as $issue) : ?>
            <button class="success-gallery-filter" data-filter="<?php echo esc_attr(strtolower($issue)); ?>"><?php echo esc_html($issue); ?></button>
            <?php endforeach; ?>
        </div>
        
        <!-- Gallery Grid -->
        <div class="success-gallery-grid">
            <?php foreach ($stories as $story) : 
                $issue_class = strtolower($story['issue']);
                
                // Default images if not provided
                $before_image = !empty($story['before_image']) ? $story['before_image'] : get_template_directory_uri() . '/assets/images/placeholder-dog.jpg';
                $after_image = !empty($story['after_image']) ? $story['after_image'] : get_template_directory_uri() . '/assets/images/placeholder-dog-happy.jpg';
            ?>
            <div class="success-gallery-item" data-category="<?php echo esc_attr($issue_class); ?>">
                <div class="success-card">
                    <div class="success-card-front">
                        <span class="success-card-label">Before</span>
                        <img src="<?php echo esc_url($before_image); ?>" alt="<?php echo esc_attr($story['name']); ?> before training" class="success-card-image">
                        <div class="success-card-overlay">
                            <h3 class="success-card-title"><?php echo esc_html($story['name']); ?></h3>
                            <p class="success-card-subtitle"><?php echo esc_html($story['breed']); ?> with <?php echo esc_html($story['issue']); ?> issues</p>
                        </div>
                        <div class="success-card-hint">
                            <i class="fas fa-sync-alt"></i>
                            <span>Flip to see after</span>
                        </div>
                    </div>
                    <div class="success-card-back">
                        <span class="success-card-label">After</span>
                        <img src="<?php echo esc_url($after_image); ?>" alt="<?php echo esc_attr($story['name']); ?> after training" class="success-card-image">
                        <div class="success-card-content">
                            <p class="success-card-text"><?php echo esc_html($story['testimonial']); ?></p>
                            <div class="success-card-meta">
                                <span><i class="fas fa-user"></i><?php echo esc_html($story['owner']); ?></span>
                                <span><i class="fas fa-calendar-alt"></i><?php echo esc_html($story['duration']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="success-gallery-more">
            <a href="<?php echo get_theme_mod('success_gallery_cta_url', '#contact'); ?>" class="gdkc-button primary">
                <?php echo get_theme_mod('success_gallery_cta_text', 'Start Your Dog\'s Transformation'); ?>
            </a>
        </div>
    </div>
    
    <script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Gallery filtering
            const filters = document.querySelectorAll('.success-gallery-filter');
            const items = document.querySelectorAll('.success-gallery-item');
            
            filters.forEach(filter => {
                filter.addEventListener('click', function() {
                    // Update active filter
                    filters.forEach(f => f.classList.remove('active'));
                    this.classList.add('active');
                    
                    const category = this.getAttribute('data-filter');
                    
                    // Show/hide items
                    items.forEach(item => {
                        if (category === 'all' || item.getAttribute('data-category') === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    })();
    </script>
</section>