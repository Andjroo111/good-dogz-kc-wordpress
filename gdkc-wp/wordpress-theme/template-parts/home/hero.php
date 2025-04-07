<?php
/**
 * Template part for displaying the hero section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Get component settings if available
$settings = [];
if (is_page()) {
    $settings = get_post_meta(get_the_ID(), '_gdkc_hero_settings', true);
    if (!is_array($settings)) {
        $settings = [];
    }
}

// Get settings with fallbacks from customizer or defaults
$title = !empty($settings['title']) ? $settings['title'] : get_theme_mod('hero_title', 'Transform Your Dog\'s Behavior');
$subtitle = !empty($settings['subtitle']) ? $settings['subtitle'] : get_theme_mod('hero_subtitle', 'Your local family transforming dogs together in Kansas City');
$content = !empty($settings['content']) ? $settings['content'] : '';
$button_text = !empty($settings['button_text']) ? $settings['button_text'] : get_theme_mod('hero_primary_button_text', 'Schedule Free Consultation');
$button_url = !empty($settings['button_url']) ? $settings['button_url'] : get_theme_mod('hero_primary_button_url', '#contact');
$secondary_button_text = get_theme_mod('hero_secondary_button_text', 'View Programs');
$secondary_button_url = get_theme_mod('hero_secondary_button_url', '#training-solutions');

// Background settings
$background_type = !empty($settings['background_type']) ? $settings['background_type'] : 'color';
$background_color = !empty($settings['background_color']) ? $settings['background_color'] : '';
$background_image = !empty($settings['background_image']) ? $settings['background_image'] : '';
$background_video = !empty($settings['background_video']) ? $settings['background_video'] : get_theme_mod('hero_video_url', '');

// Lava animation settings
$use_lava_animation = !empty($settings['use_lava_animation']) ? $settings['use_lava_animation'] : true;
$lava_color_outer = !empty($settings['lava_color_outer']) ? $settings['lava_color_outer'] : '#a08cff';
$lava_color_mid = !empty($settings['lava_color_mid']) ? $settings['lava_color_mid'] : '#6a3ad6';
$lava_color_inner = !empty($settings['lava_color_inner']) ? $settings['lava_color_inner'] : '#4b0082';
$lava_bg = !empty($settings['lava_bg']) ? $settings['lava_bg'] : '#0a0a2a';

// Build inline style for background
$style = '';
if ($background_type === 'color' && !empty($background_color)) {
    $style = 'background-color: ' . esc_attr($background_color) . ';';
} elseif ($background_type === 'image' && !empty($background_image)) {
    $image_url = wp_get_attachment_image_url($background_image, 'full');
    if ($image_url) {
        $style = 'background-image: url(' . esc_url($image_url) . ');';
    }
}
?>

<!-- Hero Section -->
<section class="hero-section <?php echo $use_lava_animation ? 'gdkc-lava-container' : ''; ?>" 
         id="hero" 
         data-section-type="hero" 
         <?php if (!empty($style)) echo 'style="' . $style . '"'; ?>
         <?php if ($use_lava_animation) : ?>
         data-gdkc-lava-color-outer="<?php echo esc_attr($lava_color_outer); ?>"
         data-gdkc-lava-color-mid="<?php echo esc_attr($lava_color_mid); ?>"
         data-gdkc-lava-color-inner="<?php echo esc_attr($lava_color_inner); ?>"
         data-gdkc-lava-bg="<?php echo esc_attr($lava_bg); ?>"
         <?php endif; ?>>
    
    <div class="container hero-content">
        <div class="hero-grid">
            <div class="hero-text">
                <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
                <p class="hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                
                <?php if (!empty($content)) : ?>
                <div class="hero-description">
                    <?php echo wp_kses_post($content); ?>
                </div>
                <?php endif; ?>
                
                <div class="hero-cta">
                    <a href="<?php echo esc_url($button_url); ?>" class="gdkc-button primary"><?php echo esc_html($button_text); ?></a>
                    <a href="<?php echo esc_url($secondary_button_url); ?>" class="gdkc-button outline"><?php echo esc_html($secondary_button_text); ?></a>
                </div>
            </div>
            
            <div class="hero-visual">
                <?php if ($background_type === 'video' && !empty($background_video)) : ?>
                    <div class="video-container">
                        <video autoplay muted loop playsinline>
                            <source src="<?php echo esc_url($background_video); ?>" type="video/mp4">
                        </video>
                    </div>
                <?php else : ?>
                    <div class="video-placeholder hover-lift">
                        <i class="fas fa-play-circle pulse-animation"></i>
                        <span><?php echo get_theme_mod('hero_video_placeholder_text', 'Training Transformation Video'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="hero-scrolldown">
            <a href="#social-proof" class="scrolldown-link">
                <span><?php echo get_theme_mod('hero_scroll_text', 'Scroll to learn more'); ?></span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </div>
    
    <!-- Decorative shapes -->
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
</section>
