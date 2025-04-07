<?php
/**
 * Template part for displaying a Bento Box grid section
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Default Bento Box items if not provided
$default_items = [
    [
        'title' => 'Transformation Stories',
        'text' => 'See how we\'ve helped transform dogs and their families throughout Kansas City.',
        'link_text' => 'View success stories',
        'link_url' => '#success-stories',
        'image' => '',
        'icon' => 'fas fa-paw',
        'size' => 'large',
        'style' => 'color-bg-primary'
    ],
    [
        'title' => 'Online Behavior Assessment',
        'text' => 'Take our free quiz to get insight into your dog\'s behavior challenges.',
        'link_text' => 'Start assessment',
        'link_url' => '#assessment',
        'image' => '',
        'icon' => 'fas fa-clipboard-check',
        'size' => '',
        'style' => 'color-bg-light'
    ],
    [
        'title' => 'Training Methods',
        'text' => 'Our balanced approach creates lasting changes in your dog\'s behavior.',
        'link_text' => 'Learn our approach',
        'link_url' => '#methods',
        'image' => '',
        'icon' => 'fas fa-graduation-cap',
        'size' => '',
        'style' => ''
    ],
    [
        'title' => 'Dog Training Tips',
        'text' => 'Free resources to help with common behavior challenges.',
        'link_text' => 'Read our blog',
        'link_url' => '/blog',
        'image' => '',
        'icon' => 'fas fa-book',
        'size' => '',
        'style' => ''
    ],
    [
        'title' => 'Training Guarantee',
        'text' => 'We stand behind our training with a 30-day satisfaction guarantee.',
        'link_text' => 'Our promise',
        'link_url' => '#guarantee',
        'image' => '',
        'icon' => 'fas fa-shield-alt',
        'size' => 'wide',
        'style' => 'color-bg-secondary'
    ]
];

// Allow for custom items to be passed to this template part
$bento_items = isset($args['bento_items']) ? $args['bento_items'] : $default_items;
$section_title = isset($args['section_title']) ? $args['section_title'] : get_theme_mod('bento_section_title', 'Explore Our Resources');
$section_subtitle = isset($args['section_subtitle']) ? $args['section_subtitle'] : get_theme_mod('bento_section_subtitle', 'Helpful tools and information for dog owners');
$section_id = isset($args['section_id']) ? $args['section_id'] : 'resources';
?>

<!-- Bento Box Section -->
<section class="bento-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <?php if ($section_subtitle) : ?>
            <p class="section-subtitle text-center"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>
        
        <div class="bento-grid">
            <?php foreach ($bento_items as $item) : 
                $size_class = !empty($item['size']) ? $item['size'] : '';
                $style_class = !empty($item['style']) ? $item['style'] : '';
                $has_image = !empty($item['image']);
                $has_icon = !empty($item['icon']);
                
                // Additional classes
                $item_classes = ['bento-item'];
                if ($size_class) $item_classes[] = $size_class;
                if ($style_class) $item_classes[] = $style_class;
                if ($has_image && empty($style_class)) $item_classes[] = 'hover-zoom';
                
                // Background image style
                $bg_style = '';
                if (!empty($item['bg_image'])) {
                    $item_classes[] = 'image-bg';
                    $bg_style = 'style="background-image: url(' . esc_url($item['bg_image']) . ');"';
                }
            ?>
            <div class="<?php echo esc_attr(implode(' ', $item_classes)); ?>" <?php echo $bg_style; ?>>
                <?php if ($has_image) : ?>
                    <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="bento-item-image">
                <?php endif; ?>
                
                <div class="bento-content">
                    <?php if ($has_icon) : ?>
                        <div class="bento-icon">
                            <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="bento-title"><?php echo esc_html($item['title']); ?></h3>
                    <p class="bento-text"><?php echo esc_html($item['text']); ?></p>
                    
                    <?php if (!empty($item['link_url']) && !empty($item['link_text'])) : ?>
                        <a href="<?php echo esc_url($item['link_url']); ?>" class="bento-link">
                            <?php echo esc_html($item['link_text']); ?>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>