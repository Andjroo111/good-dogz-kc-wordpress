<?php
/**
 * Template Name: Service Detail Page
 * Description: A template for displaying service details with booking options
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main" class="service-detail-page">
    <?php while (have_posts()) : the_post(); ?>
        
        <div class="service-header">
            <div class="container">
                <div class="service-header-content">
                    <h1 class="service-title"><?php the_title(); ?></h1>
                    
                    <?php if (has_excerpt()) : ?>
                        <div class="service-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="service-meta">
                        <?php
                        // Display service meta information if available
                        $service_duration = get_post_meta(get_the_ID(), '_gdkc_service_duration', true);
                        $service_price = get_post_meta(get_the_ID(), '_gdkc_service_price', true);
                        $service_location = get_post_meta(get_the_ID(), '_gdkc_service_location', true);
                        ?>
                        
                        <?php if (!empty($service_duration)) : ?>
                            <div class="service-meta-item service-duration">
                                <i class="fas fa-clock"></i>
                                <span><?php echo esc_html($service_duration); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($service_price)) : ?>
                            <div class="service-meta-item service-price">
                                <i class="fas fa-tag"></i>
                                <span><?php echo esc_html($service_price); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($service_location)) : ?>
                            <div class="service-meta-item service-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo esc_html($service_location); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="service-featured-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="service-content-wrapper">
            <div class="container">
                <div class="service-layout">
                    <div class="service-main-content">
                        <div class="service-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                        // Display service features if available
                        $service_features = get_post_meta(get_the_ID(), '_gdkc_service_features', true);
                        if (!empty($service_features) && is_array($service_features)) :
                        ?>
                            <div class="service-features">
                                <h3>What's Included</h3>
                                <ul class="feature-list">
                                    <?php foreach ($service_features as $feature) : ?>
                                        <li>
                                            <i class="fas fa-check-circle"></i>
                                            <span><?php echo esc_html($feature); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Display service FAQs if available
                        $service_faqs = get_post_meta(get_the_ID(), '_gdkc_service_faqs', true);
                        if (!empty($service_faqs) && is_array($service_faqs)) :
                        ?>
                            <div class="service-faqs">
                                <h3>Frequently Asked Questions</h3>
                                <div class="faq-list">
                                    <?php foreach ($service_faqs as $faq) : ?>
                                        <?php if (!empty($faq['question']) && !empty($faq['answer'])) : ?>
                                            <div class="faq-item">
                                                <h4 class="faq-question"><?php echo esc_html($faq['question']); ?></h4>
                                                <div class="faq-answer">
                                                    <?php echo wp_kses_post($faq['answer']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="service-sidebar">
                        <div class="booking-widget">
                            <h3>Book This Service</h3>
                            
                            <?php
                            // Display booking form or integration
                            $booking_shortcode = get_post_meta(get_the_ID(), '_gdkc_booking_shortcode', true);
                            if (!empty($booking_shortcode)) {
                                echo do_shortcode($booking_shortcode);
                            } else {
                                // Default booking form
                                ?>
                                <div class="default-booking-form">
                                    <p>Ready to transform your dog's behavior? Schedule your session now!</p>
                                    
                                    <form class="booking-form" action="#" method="post">
                                        <div class="form-field">
                                            <label for="booking-name">Your Name</label>
                                            <input type="text" id="booking-name" name="booking-name" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="booking-email">Email Address</label>
                                            <input type="email" id="booking-email" name="booking-email" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="booking-phone">Phone Number</label>
                                            <input type="tel" id="booking-phone" name="booking-phone" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="booking-date">Preferred Date</label>
                                            <input type="date" id="booking-date" name="booking-date" required>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="booking-time">Preferred Time</label>
                                            <select id="booking-time" name="booking-time" required>
                                                <option value="">Select a time</option>
                                                <option value="morning">Morning (9am-12pm)</option>
                                                <option value="afternoon">Afternoon (12pm-4pm)</option>
                                                <option value="evening">Evening (4pm-7pm)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-field">
                                            <label for="booking-message">Additional Information</label>
                                            <textarea id="booking-message" name="booking-message" rows="4"></textarea>
                                        </div>
                                        
                                        <div class="form-submit">
                                            <button type="submit" class="gdkc-button primary">Request Booking</button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        
                        <?php
                        // Display related services if available
                        $related_services = get_post_meta(get_the_ID(), '_gdkc_related_services', true);
                        if (!empty($related_services) && is_array($related_services)) :
                        ?>
                            <div class="related-services">
                                <h3>Related Services</h3>
                                <ul class="related-services-list">
                                    <?php foreach ($related_services as $service_id) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_permalink($service_id)); ?>">
                                                <?php echo esc_html(get_the_title($service_id)); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="service-cta">
                            <h3>Need Help Choosing?</h3>
                            <p>Not sure which service is right for your dog? Contact us for a free consultation.</p>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="gdkc-button outline">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        // Display testimonials related to this service if available
        $service_testimonials = get_post_meta(get_the_ID(), '_gdkc_service_testimonials', true);
        if (!empty($service_testimonials) && is_array($service_testimonials)) :
        ?>
            <div class="service-testimonials">
                <div class="container">
                    <h2>What Our Clients Say</h2>
                    <div class="testimonial-slider">
                        <?php foreach ($service_testimonials as $testimonial_id) : ?>
                            <div class="testimonial-item">
                                <?php
                                $testimonial_content = get_post_field('post_content', $testimonial_id);
                                $testimonial_author = get_post_meta($testimonial_id, '_gdkc_testimonial_author', true);
                                $testimonial_rating = get_post_meta($testimonial_id, '_gdkc_testimonial_rating', true);
                                ?>
                                
                                <div class="testimonial-content">
                                    <?php echo wp_kses_post($testimonial_content); ?>
                                </div>
                                
                                <?php if (!empty($testimonial_rating)) : ?>
                                    <div class="testimonial-rating">
                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                            <i class="fas fa-star<?php echo $i <= $testimonial_rating ? '' : '-o'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($testimonial_author)) : ?>
                                    <div class="testimonial-author">
                                        <span><?php echo esc_html($testimonial_author); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
    <?php endwhile; ?>
</main>

<?php
get_footer();
?>
