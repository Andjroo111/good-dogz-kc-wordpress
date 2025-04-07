<?php
/**
 * Template part for displaying the contact section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-content">
                <h2 class="section-title"><?php echo get_theme_mod('contact_title', 'Start Your Dog\'s Transformation Today'); ?></h2>
                <p class="section-subtitle"><?php echo get_theme_mod('contact_subtitle', 'Schedule your free consultation and let\'s discuss how we can help your dog become their best self'); ?></p>
                
                <div class="contact-info">
                    <?php if ($phone = get_theme_mod('contact_phone', '(816) 555-1234')) : ?>
                        <div class="contact-info-item">
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-text">
                                <h3>Call or Text</h3>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($email = get_theme_mod('contact_email', 'hello@gooddogzkc.com')) : ?>
                        <div class="contact-info-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div class="contact-text">
                                <h3>Email Us</h3>
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($address = get_theme_mod('contact_address', 'Kansas City, MO')) : ?>
                        <div class="contact-info-item">
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="contact-text">
                                <h3>Serving</h3>
                                <address><?php echo esc_html($address); ?></address>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="contact-social">
                    <h3><?php echo get_theme_mod('contact_social_title', 'Follow Us'); ?></h3>
                    <div class="social-links">
                        <?php if ($facebook = get_theme_mod('social_facebook')) : ?>
                            <a href="<?php echo esc_url($facebook); ?>" class="social-link facebook" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                                <span class="screen-reader-text">Facebook</span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($instagram = get_theme_mod('social_instagram')) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" class="social-link instagram" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                                <span class="screen-reader-text">Instagram</span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($youtube = get_theme_mod('social_youtube')) : ?>
                            <a href="<?php echo esc_url($youtube); ?>" class="social-link youtube" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                                <span class="screen-reader-text">YouTube</span>
                            </a>
                        <?php endif; ?>
                        
                        <?php if ($tiktok = get_theme_mod('social_tiktok')) : ?>
                            <a href="<?php echo esc_url($tiktok); ?>" class="social-link tiktok" target="_blank" rel="noopener">
                                <i class="fab fa-tiktok"></i>
                                <span class="screen-reader-text">TikTok</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-container">
                <div class="form-card">
                    <h3 class="form-title"><?php echo get_theme_mod('contact_form_title', 'Book Your Free Consultation'); ?></h3>
                    <?php echo do_shortcode('[contact-form-7 id="' . get_theme_mod('contact_form_id', '') . '" title="Contact Form"]'); ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorative shape -->
    <div class="contact-shape"></div>
</section>