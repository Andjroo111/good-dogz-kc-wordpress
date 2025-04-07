<?php
/**
 * Template Name: Service Page
 * Description: Custom template for service/program pages for Good Dogz KC
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main">
    
    <!-- Service Hero Section -->
    <section class="service-hero-section">
        <div class="container">
            <div class="service-hero-grid">
                <div class="service-hero-content">
                    <h1 class="service-hero-title"><?php the_title(); ?></h1>
                    
                    <?php if ($subtitle = get_post_meta(get_the_ID(), '_service_subtitle', true)) : ?>
                        <p class="service-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                    
                    <div class="service-hero-description">
                        <?php if (has_excerpt()) : ?>
                            <?php the_excerpt(); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="service-hero-cta">
                        <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_service_cta_url', true) ?: '#contact'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_cta_text', true) ?: 'Book a Consultation'); ?></a>
                        
                        <?php if ($secondary_cta_text = get_post_meta(get_the_ID(), '_service_secondary_cta_text', true)) : ?>
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_service_secondary_cta_url', true) ?: '#details'); ?>" class="gdkc-button outline"><?php echo esc_html($secondary_cta_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="service-hero-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['class' => 'service-featured-image']); ?>
                    <?php else : ?>
                        <div class="image-placeholder">
                            <i class="fas fa-dog"></i>
                            <span>Service Image</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Service Overview Section -->
    <section class="service-overview-section" id="overview">
        <div class="container">
            <div class="service-overview-grid">
                <div class="service-overview-content">
                    <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_overview_title', true) ?: 'Program Overview'); ?></h2>
                    
                    <div class="service-overview-text">
                        <?php 
                        // Check for overview content meta
                        $overview_content = get_post_meta(get_the_ID(), '_service_overview_content', true);
                        if ($overview_content) {
                            echo wp_kses_post($overview_content);
                        } else {
                            // If no meta, use the main content
                            the_content();
                        }
                        ?>
                    </div>
                </div>
                
                <div class="service-overview-details">
                    <div class="service-details-card">
                        <h3 class="service-details-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_details_title', true) ?: 'Program Details'); ?></h3>
                        
                        <ul class="service-details-list">
                            <?php
                            // Program details
                            $details = [
                                'duration' => [
                                    'icon' => 'fas fa-calendar-alt',
                                    'label' => 'Duration',
                                    'value' => get_post_meta(get_the_ID(), '_service_duration', true)
                                ],
                                'sessions' => [
                                    'icon' => 'fas fa-clock',
                                    'label' => 'Sessions',
                                    'value' => get_post_meta(get_the_ID(), '_service_sessions', true)
                                ],
                                'location' => [
                                    'icon' => 'fas fa-map-marker-alt',
                                    'label' => 'Location',
                                    'value' => get_post_meta(get_the_ID(), '_service_location', true)
                                ],
                                'price' => [
                                    'icon' => 'fas fa-tag',
                                    'label' => 'Price',
                                    'value' => get_post_meta(get_the_ID(), '_service_price', true)
                                ],
                                'group_size' => [
                                    'icon' => 'fas fa-users',
                                    'label' => 'Group Size',
                                    'value' => get_post_meta(get_the_ID(), '_service_group_size', true)
                                ]
                            ];
                            
                            foreach ($details as $key => $detail) :
                                if (!empty($detail['value'])) :
                            ?>
                            <li class="service-detail-item">
                                <div class="service-detail-icon">
                                    <i class="<?php echo esc_attr($detail['icon']); ?>"></i>
                                </div>
                                <div class="service-detail-content">
                                    <span class="service-detail-label"><?php echo esc_html($detail['label']); ?></span>
                                    <span class="service-detail-value"><?php echo esc_html($detail['value']); ?></span>
                                </div>
                            </li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                        
                        <div class="service-cta">
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_service_details_cta_url', true) ?: '#contact'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_details_cta_text', true) ?: 'Book Now'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Service Benefits Section -->
    <section class="service-benefits-section" id="benefits">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_benefits_title', true) ?: 'Program Benefits'); ?></h2>
            
            <div class="service-benefits-grid">
                <?php
                // Benefits
                $benefits_count = intval(get_post_meta(get_the_ID(), '_service_benefits_count', true) ?: 6);
                
                for ($i = 1; $i <= $benefits_count; $i++) :
                    $benefit_title = get_post_meta(get_the_ID(), "_service_benefit_{$i}_title", true);
                    $benefit_text = get_post_meta(get_the_ID(), "_service_benefit_{$i}_text", true);
                    $benefit_icon = get_post_meta(get_the_ID(), "_service_benefit_{$i}_icon", true) ?: 'fas fa-check-circle';
                    
                    if ($benefit_title || $benefit_text) :
                ?>
                <div class="service-benefit-card">
                    <div class="service-benefit-icon">
                        <i class="<?php echo esc_attr($benefit_icon); ?>"></i>
                    </div>
                    <div class="service-benefit-content">
                        <?php if ($benefit_title) : ?>
                            <h3 class="service-benefit-title"><?php echo esc_html($benefit_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($benefit_text) : ?>
                            <p class="service-benefit-text"><?php echo esc_html($benefit_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    endif;
                endfor;
                
                // If no benefits are defined, show placeholders
                if (!get_post_meta(get_the_ID(), '_service_benefit_1_title', true) && !get_post_meta(get_the_ID(), '_service_benefit_1_text', true)) :
                    $default_benefits = [
                        [
                            'title' => 'Personalized Approach',
                            'text' => 'Training tailored to your dog\'s specific needs and your family\'s goals',
                            'icon' => 'fas fa-user-check'
                        ],
                        [
                            'title' => 'Lasting Results',
                            'text' => 'Focus on creating permanent behavior changes, not temporary fixes',
                            'icon' => 'fas fa-medal'
                        ],
                        [
                            'title' => 'Science-Based Methods',
                            'text' => 'Using positive reinforcement techniques backed by behavioral science',
                            'icon' => 'fas fa-brain'
                        ],
                        [
                            'title' => 'Family Involvement',
                            'text' => 'We train you as well as your dog for consistent results',
                            'icon' => 'fas fa-users'
                        ],
                        [
                            'title' => 'Ongoing Support',
                            'text' => 'Access to resources and follow-up help after program completion',
                            'icon' => 'fas fa-hands-helping'
                        ],
                        [
                            'title' => 'Satisfaction Guarantee',
                            'text' => '30-day satisfaction guarantee on all our training programs',
                            'icon' => 'fas fa-shield-alt'
                        ]
                    ];
                    
                    foreach ($default_benefits as $benefit) :
                ?>
                <div class="service-benefit-card">
                    <div class="service-benefit-icon">
                        <i class="<?php echo esc_attr($benefit['icon']); ?>"></i>
                    </div>
                    <div class="service-benefit-content">
                        <h3 class="service-benefit-title"><?php echo esc_html($benefit['title']); ?></h3>
                        <p class="service-benefit-text"><?php echo esc_html($benefit['text']); ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- Service Process Section -->
    <section class="service-process-section" id="process">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_process_title', true) ?: 'How It Works'); ?></h2>
            
            <div class="service-process-steps">
                <?php
                // Process steps
                $steps_count = intval(get_post_meta(get_the_ID(), '_service_steps_count', true) ?: 4);
                
                for ($i = 1; $i <= $steps_count; $i++) :
                    $step_title = get_post_meta(get_the_ID(), "_service_step_{$i}_title", true);
                    $step_text = get_post_meta(get_the_ID(), "_service_step_{$i}_text", true);
                    
                    if ($step_title || $step_text) :
                ?>
                <div class="service-process-step">
                    <div class="step-number"><?php echo $i; ?></div>
                    <div class="step-content">
                        <?php if ($step_title) : ?>
                            <h3 class="step-title"><?php echo esc_html($step_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($step_text) : ?>
                            <p class="step-text"><?php echo esc_html($step_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    endif;
                endfor;
                
                // If no steps are defined, show placeholders
                if (!get_post_meta(get_the_ID(), '_service_step_1_title', true) && !get_post_meta(get_the_ID(), '_service_step_1_text', true)) :
                    $default_steps = [
                        [
                            'title' => 'Initial Consultation',
                            'text' => 'We start with a thorough assessment of your dog\'s behavior and your training goals'
                        ],
                        [
                            'title' => 'Customized Plan',
                            'text' => 'We create a personalized training plan tailored to your dog\'s specific needs'
                        ],
                        [
                            'title' => 'Training Sessions',
                            'text' => 'Regular sessions to implement the training plan with clear guidance and support'
                        ],
                        [
                            'title' => 'Follow-up Support',
                            'text' => 'Ongoing assistance to ensure lasting results and address any new challenges'
                        ]
                    ];
                    
                    foreach ($default_steps as $index => $step) :
                ?>
                <div class="service-process-step">
                    <div class="step-number"><?php echo $index + 1; ?></div>
                    <div class="step-content">
                        <h3 class="step-title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="step-text"><?php echo esc_html($step['text']); ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- Service Testimonials Section -->
    <section class="service-testimonials-section" id="testimonials">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_testimonials_title', true) ?: 'Success Stories'); ?></h2>
            
            <div class="service-testimonials-slider">
                <?php
                // Get testimonials for this service
                $service_id = get_the_ID();
                $testimonials_query = new WP_Query([
                    'post_type' => 'testimonial',
                    'posts_per_page' => 3,
                    'meta_query' => [
                        [
                            'key' => '_testimonial_service',
                            'value' => $service_id,
                            'compare' => '='
                        ]
                    ]
                ]);
                
                if ($testimonials_query->have_posts()) :
                    while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                        $client_name = get_post_meta(get_the_ID(), '_testimonial_client_name', true);
                        $dog_name = get_post_meta(get_the_ID(), '_testimonial_dog_name', true);
                        $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                ?>
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <blockquote class="testimonial-card__content">
                            <?php the_content(); ?>
                        </blockquote>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__avatar">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                <?php else : ?>
                                    <div class="image-placeholder" style="width: 48px; height: 48px; min-height: auto; border-radius: 50%; padding: 0;">
                                        <i class="fas fa-user" style="font-size: 1rem; margin: 0;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <cite class="testimonial-card__name"><?php echo esc_html($client_name); ?></cite>
                                <div class="testimonial-card__title">Owner of <?php echo esc_html($dog_name); ?></div>
                                <?php if ($rating) : ?>
                                    <div class="testimonial-card__rating" aria-label="<?php echo esc_attr($rating); ?> out of 5 stars rating">
                                        <?php for ($i = 0; $i < $rating; $i++) : ?>
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback testimonials if none are associated with this service
                    $fallback_testimonials = [
                        [
                            'content' => 'This program exceeded our expectations. Our dog is now so much more confident and well-behaved. The trainers were professional and really understood our specific challenges.',
                            'name' => 'Jennifer M.',
                            'dog' => 'Cooper',
                            'rating' => 5
                        ],
                        [
                            'content' => 'We tried several other trainers before finding Good Dogz KC. The difference in approach and results was night and day. Our dog\'s behavior improved dramatically after just a few sessions.',
                            'name' => 'Robert K.',
                            'dog' => 'Daisy',
                            'rating' => 5
                        ],
                        [
                            'content' => 'The personalized approach made all the difference. They didn\'t just use a cookie-cutter training plan - they really took the time to understand our dog\'s specific needs and our family situation.',
                            'name' => 'Amanda & John T.',
                            'dog' => 'Buddy',
                            'rating' => 5
                        ]
                    ];
                    
                    foreach ($fallback_testimonials as $testimonial) :
                ?>
                <div class="testimonial-slide">
                    <div class="testimonial-card">
                        <blockquote class="testimonial-card__content">
                            <?php echo esc_html($testimonial['content']); ?>
                        </blockquote>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__avatar">
                                <div class="image-placeholder" style="width: 48px; height: 48px; min-height: auto; border-radius: 50%; padding: 0;">
                                    <i class="fas fa-user" style="font-size: 1rem; margin: 0;"></i>
                                </div>
                            </div>
                            <div>
                                <cite class="testimonial-card__name"><?php echo esc_html($testimonial['name']); ?></cite>
                                <div class="testimonial-card__title">Owner of <?php echo esc_html($testimonial['dog']); ?></div>
                                <div class="testimonial-card__rating" aria-label="<?php echo esc_attr($testimonial['rating']); ?> out of 5 stars rating">
                                    <?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                        <i class="fas fa-star" aria-hidden="true"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            
            <div class="service-testimonials-nav">
                <button class="testimonial-prev" aria-label="Previous testimonial">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="testimonial-next" aria-label="Next testimonial">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
    
    <!-- Service FAQ Section -->
    <section class="service-faq-section" id="faq">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_faq_title', true) ?: 'Frequently Asked Questions'); ?></h2>
            
            <div class="service-faq-container">
                <?php
                // FAQ items
                $faq_count = intval(get_post_meta(get_the_ID(), '_service_faq_count', true) ?: 5);
                
                for ($i = 1; $i <= $faq_count; $i++) :
                    $faq_question = get_post_meta(get_the_ID(), "_service_faq_{$i}_question", true);
                    $faq_answer = get_post_meta(get_the_ID(), "_service_faq_{$i}_answer", true);
                    
                    if ($faq_question && $faq_answer) :
                ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $i; ?>">
                        <span><?php echo esc_html($faq_question); ?></span>
                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?php echo $i; ?>">
                        <?php echo wpautop(wp_kses_post($faq_answer)); ?>
                    </div>
                </div>
                <?php
                    endif;
                endfor;
                
                // If no FAQs are defined, show placeholders
                if (!get_post_meta(get_the_ID(), '_service_faq_1_question', true)) :
                    $default_faqs = [
                        [
                            'question' => 'How long does the training program take?',
                            'answer' => 'The duration varies based on your dog\'s specific needs and the program you choose. Typically, our programs range from 4-8 weeks, with consistent practice between sessions being key to success.'
                        ],
                        [
                            'question' => 'What training methods do you use?',
                            'answer' => 'We use positive reinforcement-based methods that focus on rewarding desired behaviors rather than punishing unwanted ones. Our approach is science-based, humane, and designed to build a stronger relationship between you and your dog.'
                        ],
                        [
                            'question' => 'Do you offer a guarantee?',
                            'answer' => 'Yes, we offer a 30-day satisfaction guarantee. If you\'re following the training plan consistently and not seeing improvement, we\'ll provide additional sessions at no extra cost.'
                        ],
                        [
                            'question' => 'How involved will I need to be in the training process?',
                            'answer' => 'Your involvement is crucial for long-term success. We\'ll teach you the skills and techniques needed to maintain your dog\'s training. Consistent practice between sessions is essential for lasting results.'
                        ],
                        [
                            'question' => 'What if my dog has multiple behavior issues?',
                            'answer' => 'Our programs are customized to address multiple issues. During the initial consultation, we\'ll assess all behavior concerns and create a comprehensive plan that prioritizes the most important issues while building a foundation for overall improved behavior.'
                        ]
                    ];
                    
                    foreach ($default_faqs as $index => $faq) :
                ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-default-<?php echo $index; ?>">
                        <span><?php echo esc_html($faq['question']); ?></span>
                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-default-<?php echo $index; ?>">
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            
            <div class="service-faq-cta">
                <p><?php echo esc_html(get_post_meta(get_the_ID(), '_service_faq_cta_text', true) ?: 'Have more questions? We\'re here to help!'); ?></p>
                <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_service_faq_cta_url', true) ?: '#contact'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_faq_cta_button', true) ?: 'Contact Us'); ?></a>
            </div>
        </div>
    </section>
    
    <!-- Service CTA Section -->
    <section class="service-cta-section" id="contact">
        <div class="container">
            <div class="service-cta-card">
                <div class="service-cta-content">
                    <h2 class="service-cta-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_cta_title', true) ?: 'Ready to Transform Your Dog\'s Behavior?'); ?></h2>
                    <p class="service-cta-text"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_cta_text', true) ?: 'Book your free consultation today and take the first step toward a better relationship with your dog.'); ?></p>
                    
                    <div class="service-cta-buttons">
                        <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_service_final_cta_url', true) ?: '/contact'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_final_cta_text', true) ?: 'Book Your Consultation'); ?></a>
                        
                        <?php if ($phone = get_theme_mod('contact_phone')) : ?>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="gdkc-button outline">
                                <i class="fas fa-phone"></i> <?php echo esc_html($phone); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="service-guarantee">
                    <div class="guarantee-badge">
                        <span>100%</span>
                        <span>Satisfaction<br>Guarantee</span>
                    </div>
                    <p class="guarantee-text"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_guarantee_text', true) ?: 'If you don\'t see improvement in your dog\'s behavior, your next session is free.'); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Services Section -->
    <section class="related-services-section">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_service_related_title', true) ?: 'Related Programs'); ?></h2>
            
            <div class="related-services-grid">
                <?php
                // Get related services
                $current_id = get_the_ID();
                $related_services_query = new WP_Query([
                    'post_type' => 'page',
                    'posts_per_page' => 3,
                    'post__not_in' => [$current_id],
                    'meta_query' => [
                        [
                            'key' => '_wp_page_template',
                            'value' => 'page-templates/service-page.php',
                            'compare' => '='
                        ]
                    ]
                ]);
                
                if ($related_services_query->have_posts()) :
                    while ($related_services_query->have_posts()) : $related_services_query->the_post();
                        $subtitle = get_post_meta(get_the_ID(), '_service_subtitle', true);
                ?>
                <div class="related-service-card">
                    <div class="related-service-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <div class="image-placeholder">
                                <i class="fas fa-dog"></i>
                                <span>Service Image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="related-service-content">
                        <h3 class="related-service-title"><?php the_title(); ?></h3>
                        <?php if ($subtitle) : ?>
                            <p class="related-service-subtitle"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="gdkc-button-s">Learn More</a>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback related services if none are found
                    $fallback_services = [
                        [
                            'title' => 'In-Home Training',
                            'subtitle' => 'Personalized training in your environment',
                            'image' => '',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Puppy Training',
                            'subtitle' => 'Start your puppy off right',
                            'image' => '',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Behavior Modification',
                            'subtitle' => 'Solutions for challenging behaviors',
                            'image' => '',
                            'url' => '#'
                        ]
                    ];
                    
                    foreach ($fallback_services as $service) :
                ?>
                <div class="related-service-card">
                    <div class="related-service-image">
                        <div class="image-placeholder">
                            <i class="fas fa-dog"></i>
                            <span>Service Image</span>
                        </div>
                    </div>
                    <div class="related-service-content">
                        <h3 class="related-service-title"><?
