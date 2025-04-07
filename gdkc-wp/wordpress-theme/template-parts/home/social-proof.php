<?php
/**
 * Template part for displaying the social proof section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Social Proof Section -->
<section class="social-proof-section" id="social-proof">
    <div class="container">
        <h2 class="section-title"><?php echo get_theme_mod('social_proof_title', 'Trusted by Kansas City Families'); ?></h2>
        
        <div class="stats-grid">
            <?php
            // Stats cards
            $stats = [
                [
                    'value' => get_theme_mod('stat_1_value', '500+'),
                    'label' => get_theme_mod('stat_1_label', 'Dogs Transformed'),
                    'class' => 'stat-card-blue'
                ],
                [
                    'value' => get_theme_mod('stat_2_value', '5'),
                    'label' => get_theme_mod('stat_2_label', 'Years Experience'),
                    'class' => 'stat-card-teal'
                ],
                [
                    'value' => get_theme_mod('stat_3_value', '5'),
                    'label' => get_theme_mod('stat_3_label', 'Star Google Rating'),
                    'class' => 'stat-card-purple'
                ]
            ];
            
            foreach ($stats as $stat) :
            ?>
            <div class="stat-card <?php echo esc_attr($stat['class']); ?>">
                <div class="stat-value"><?php echo esc_html($stat['value']); ?></div>
                <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="quote-card">
            <div class="quote-content"><?php echo get_theme_mod('quote_content', '"The best decision we made for our family"'); ?></div>
            <div class="quote-author"><?php echo get_theme_mod('quote_author', 'Sarah K.'); ?></div>
        </div>
    </div>
</section>