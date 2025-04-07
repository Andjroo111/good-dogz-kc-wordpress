<?php
/**
 * Template part for displaying the lead magnet section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Lead Magnet Section -->
<section class="lead-magnet-section" id="lead-magnet">
    <div class="container">
        <div class="lead-magnet-card">
            <div class="lead-magnet-content">
                <h2 class="section-title light"><?php echo get_theme_mod('lead_magnet_title', 'Free 15-Point Behavior Assessment Guide'); ?></h2>
                <p class="lead-text"><?php echo get_theme_mod('lead_magnet_text', 'Get our expert 15-point checklist to identify exactly what\'s causing your dog\'s behavior issues'); ?></p>
                
                <div class="benefit-container">
                    <?php
                    // Benefits
                    $benefits = [
                        [
                            'icon' => 'fas fa-search',
                            'text' => get_theme_mod('lead_magnet_benefit1', 'Identify root causes of problem behaviors')
                        ],
                        [
                            'icon' => 'fas fa-check-circle',
                            'text' => get_theme_mod('lead_magnet_benefit2', 'Get actionable first steps you can take today')
                        ],
                        [
                            'icon' => 'fas fa-clipboard-list',
                            'text' => get_theme_mod('lead_magnet_benefit3', 'Understand if professional training is needed')
                        ]
                    ];
                    
                    foreach ($benefits as $benefit) :
                    ?>
                    <div class="benefit-item">
                        <div class="benefit-icon"><i class="<?php echo esc_attr($benefit['icon']); ?>"></i></div>
                        <div class="benefit-text"><?php echo esc_html($benefit['text']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <?php echo do_shortcode('[contact-form-7 id="' . get_theme_mod('lead_magnet_form_id', '') . '" title="Lead Magnet Form"]'); ?>
            </div>
            
            <div class="lead-magnet-image">
                <?php if ($lead_image = get_theme_mod('lead_magnet_image')) : ?>
                    <img src="<?php echo esc_url($lead_image); ?>" alt="Behavior Assessment Guide">
                <?php else : ?>
                    <div class="image-placeholder" data-image-type="guide">
                        <i class="fas fa-file-alt"></i>
                        <span>Behavior Assessment Guide Preview</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Decorative shape -->
            <div class="lead-magnet-shape"></div>
        </div>
    </div>
</section>