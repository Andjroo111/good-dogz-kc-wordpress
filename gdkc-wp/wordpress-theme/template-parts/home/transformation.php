<?php
/**
 * Template part for displaying the transformation showcase section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Transformation Showcase Section -->
<section class="transformation-showcase" id="transformation">
    <div class="container">
        <h2 class="section-title"><?php echo get_theme_mod('transformation_title', 'Dog of the Month: Bailey\'s Transformation'); ?></h2>
        
        <div class="transformation-card">
            <div class="transformation-slider">
                <div class="before-image">
                    <?php if ($before_image = get_theme_mod('transformation_before_image')) : ?>
                        <img src="<?php echo esc_url($before_image); ?>" alt="Before training">
                    <?php else : ?>
                        <div class="image-placeholder" data-image-type="dog-before">
                            <i class="fas fa-dog"></i>
                            <span>Before Image</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="after-image">
                    <?php if ($after_image = get_theme_mod('transformation_after_image')) : ?>
                        <img src="<?php echo esc_url($after_image); ?>" alt="After training">
                    <?php else : ?>
                        <div class="image-placeholder" data-image-type="dog-after">
                            <i class="fas fa-dog"></i>
                            <span>After Image</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="slider-handle"></div>
            </div>
            
            <div class="transformation-content">
                <div class="transformation-grid">
                    <div class="transformation-item">
                        <div class="badge badge-blue"><?php echo get_theme_mod('transformation_challenge_label', 'Challenge'); ?></div>
                        <h3><?php echo get_theme_mod('transformation_challenge_title', 'Severe leash reactivity'); ?></h3>
                        <p><?php echo get_theme_mod('transformation_challenge_text', 'Couldn\'t walk near other dogs without lunging and barking'); ?></p>
                    </div>
                    <div class="transformation-item">
                        <div class="badge badge-teal"><?php echo get_theme_mod('transformation_process_label', 'Process'); ?></div>
                        <h3><?php echo get_theme_mod('transformation_process_title', '6-week training program'); ?></h3>
                        <p><?php echo get_theme_mod('transformation_process_text', 'Systematic desensitization and counter-conditioning'); ?></p>
                        <div class="progress-bar">
                            <div class="progress-bar-indicator" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="transformation-item">
                        <div class="badge badge-purple"><?php echo get_theme_mod('transformation_result_label', 'Result'); ?></div>
                        <h3><?php echo get_theme_mod('transformation_result_title', 'Calm and controlled walks'); ?></h3>
                        <p><?php echo get_theme_mod('transformation_result_text', 'Now walks calmly past other dogs, even in close proximity'); ?></p>
                    </div>
                </div>
                
                <div class="quote-card highlight">
                    <div class="quote-content"><?php echo get_theme_mod('transformation_quote', '"We can finally enjoy walks as a family again. Life-changing!"'); ?></div>
                    <div class="quote-author"><?php echo get_theme_mod('transformation_quote_author', 'Bailey\'s Family'); ?></div>
                </div>
            </div>
        </div>
        
        <div class="cta-container">
            <a href="<?php echo get_theme_mod('transformation_cta1_url', '#success-stories'); ?>" class="gdkc-button secondary"><?php echo get_theme_mod('transformation_cta1_text', 'View More Success Stories'); ?></a>
            <a href="<?php echo get_theme_mod('transformation_cta2_url', '#contact'); ?>" class="gdkc-button primary"><?php echo get_theme_mod('transformation_cta2_text', 'Start Your Dog\'s Transformation'); ?></a>
        </div>
    </div>
</section>