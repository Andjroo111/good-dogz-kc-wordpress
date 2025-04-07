<?php
/**
 * Template Name: Landing Page
 * Description: Custom template for marketing landing pages for Good Dogz KC
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header('landing'); // Use a simplified header for landing pages
?>

<main id="main-content" role="main">
    
    <!-- Landing Hero Section -->
    <section class="landing-hero-section">
        <div class="container">
            <div class="landing-hero-grid">
                <div class="landing-hero-content">
                    <h1 class="landing-hero-title"><?php echo get_post_meta(get_the_ID(), '_landing_hero_title', true) ?: get_the_title(); ?></h1>
                    
                    <?php if ($subtitle = get_post_meta(get_the_ID(), '_landing_hero_subtitle', true)) : ?>
                        <p class="landing-hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($hero_text = get_post_meta(get_the_ID(), '_landing_hero_text', true)) : ?>
                        <div class="landing-hero-text">
                            <?php echo wpautop(wp_kses_post($hero_text)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="landing-hero-cta">
                        <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_landing_primary_cta_url', true) ?: '#contact-form'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_primary_cta_text', true) ?: 'Get Started Now'); ?></a>
                        
                        <?php if ($secondary_cta_text = get_post_meta(get_the_ID(), '_landing_secondary_cta_text', true)) : ?>
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_landing_secondary_cta_url', true) ?: '#learn-more'); ?>" class="gdkc-button outline"><?php echo esc_html($secondary_cta_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="landing-hero-media">
                    <?php 
                    $media_type = get_post_meta(get_the_ID(), '_landing_hero_media_type', true) ?: 'image';
                    
                    if ($media_type === 'video' && $video_url = get_post_meta(get_the_ID(), '_landing_hero_video', true)) : 
                    ?>
                        <div class="landing-hero-video">
                            <?php echo wp_oembed_get($video_url); ?>
                        </div>
                    <?php elseif ($media_type === 'image' && has_post_thumbnail()) : ?>
                        <div class="landing-hero-image">
                            <?php the_post_thumbnail('large', ['class' => 'landing-featured-image']); ?>
                        </div>
                    <?php else : ?>
                        <div class="landing-hero-image">
                            <div class="image-placeholder">
                                <i class="fas fa-dog"></i>
                                <span>Hero Image</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Social Proof Bar -->
            <div class="social-proof-bar">
                <?php if ($social_proof_text = get_post_meta(get_the_ID(), '_landing_social_proof_text', true)) : ?>
                    <div class="social-proof-text"><?php echo esc_html($social_proof_text); ?></div>
                <?php else : ?>
                    <div class="social-proof-text">Trusted by 500+ Kansas City dog owners</div>
                <?php endif; ?>
                
                <div class="social-proof-logos">
                    <?php
                    // Social proof logos
                    $logos_count = intval(get_post_meta(get_the_ID(), '_landing_logos_count', true) ?: 0);
                    
                    if ($logos_count > 0) :
                        for ($i = 1; $i <= $logos_count; $i++) :
                            $logo_url = get_post_meta(get_the_ID(), "_landing_logo_{$i}_url", true);
                            $logo_alt = get_post_meta(get_the_ID(), "_landing_logo_{$i}_alt", true) ?: 'Partner logo';
                            
                            if ($logo_url) :
                    ?>
                    <div class="social-proof-logo">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
                    </div>
                    <?php
                            endif;
                        endfor;
                    else :
                        // Default logos
                        $default_logos = [
                            ['text' => '⭐⭐⭐⭐⭐', 'alt' => '5-star rating'],
                            ['text' => 'Google', 'alt' => 'Google reviews'],
                            ['text' => 'Yelp', 'alt' => 'Yelp reviews'],
                            ['text' => 'Facebook', 'alt' => 'Facebook reviews']
                        ];
                        
                        foreach ($default_logos as $logo) :
                    ?>
                    <div class="social-proof-logo">
                        <span><?php echo esc_html($logo['text']); ?></span>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Problem Section -->
    <section class="landing-problem-section" id="problem">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_problem_title', true) ?: 'The Problem'); ?></h2>
            
            <?php if ($problem_subtitle = get_post_meta(get_the_ID(), '_landing_problem_subtitle', true)) : ?>
                <p class="section-subtitle"><?php echo esc_html($problem_subtitle); ?></p>
            <?php endif; ?>
            
            <div class="landing-problem-grid">
                <?php
                // Problem points
                $problems_count = intval(get_post_meta(get_the_ID(), '_landing_problems_count', true) ?: 3);
                
                for ($i = 1; $i <= $problems_count; $i++) :
                    $problem_title = get_post_meta(get_the_ID(), "_landing_problem_{$i}_title", true);
                    $problem_text = get_post_meta(get_the_ID(), "_landing_problem_{$i}_text", true);
                    $problem_icon = get_post_meta(get_the_ID(), "_landing_problem_{$i}_icon", true) ?: 'fas fa-exclamation-circle';
                    
                    if ($problem_title || $problem_text) :
                ?>
                <div class="landing-problem-card">
                    <div class="problem-icon">
                        <i class="<?php echo esc_attr($problem_icon); ?>"></i>
                    </div>
                    <div class="problem-content">
                        <?php if ($problem_title) : ?>
                            <h3 class="problem-title"><?php echo esc_html($problem_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($problem_text) : ?>
                            <p class="problem-text"><?php echo esc_html($problem_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    endif;
                endfor;
                
                // If no problems are defined, show placeholders
                if (!get_post_meta(get_the_ID(), '_landing_problem_1_title', true)) :
                    $default_problems = [
                        [
                            'title' => 'Frustrating Behavior Issues',
                            'text' => 'Your dog\'s behavior is causing stress and frustration in your home, making daily life difficult.',
                            'icon' => 'fas fa-exclamation-circle'
                        ],
                        [
                            'title' => 'Failed Previous Attempts',
                            'text' => 'You\'ve tried various training methods and tips from the internet, but nothing seems to work consistently.',
                            'icon' => 'fas fa-times-circle'
                        ],
                        [
                            'title' => 'Strained Relationship',
                            'text' => 'The ongoing behavior problems are affecting your relationship with your dog and causing household tension.',
                            'icon' => 'fas fa-heart-broken'
                        ]
                    ];
                    
                    foreach ($default_problems as $problem) :
                ?>
                <div class="landing-problem-card">
                    <div class="problem-icon">
                        <i class="<?php echo esc_attr($problem['icon']); ?>"></i>
                    </div>
                    <div class="problem-content">
                        <h3 class="problem-title"><?php echo esc_html($problem['title']); ?></h3>
                        <p class="problem-text"><?php echo esc_html($problem['text']); ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            
            <?php if ($problem_cta_text = get_post_meta(get_the_ID(), '_landing_problem_cta_text', true)) : ?>
                <div class="landing-problem-cta">
                    <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_landing_problem_cta_url', true) ?: '#solution'); ?>" class="gdkc-button primary"><?php echo esc_html($problem_cta_text); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Solution Section -->
    <section class="landing-solution-section" id="solution">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_solution_title', true) ?: 'Our Solution'); ?></h2>
            
            <?php if ($solution_subtitle = get_post_meta(get_the_ID(), '_landing_solution_subtitle', true)) : ?>
                <p class="section-subtitle"><?php echo esc_html($solution_subtitle); ?></p>
            <?php endif; ?>
            
            <div class="landing-solution-content">
                <div class="landing-solution-text">
                    <?php 
                    $solution_content = get_post_meta(get_the_ID(), '_landing_solution_content', true);
                    if ($solution_content) {
                        echo wpautop(wp_kses_post($solution_content));
                    } else {
                        // If no meta, use the main content
                        the_content();
                    }
                    ?>
                </div>
                
                <div class="landing-solution-media">
                    <?php 
                    $solution_media_type = get_post_meta(get_the_ID(), '_landing_solution_media_type', true) ?: 'image';
                    
                    if ($solution_media_type === 'video' && $solution_video_url = get_post_meta(get_the_ID(), '_landing_solution_video', true)) : 
                    ?>
                        <div class="landing-solution-video">
                            <?php echo wp_oembed_get($solution_video_url); ?>
                        </div>
                    <?php elseif ($solution_media_type === 'image' && $solution_image = get_post_meta(get_the_ID(), '_landing_solution_image', true)) : ?>
                        <div class="landing-solution-image">
                            <img src="<?php echo esc_url($solution_image); ?>" alt="Our solution">
                        </div>
                    <?php else : ?>
                        <div class="landing-solution-image">
                            <div class="image-placeholder">
                                <i class="fas fa-lightbulb"></i>
                                <span>Solution Image</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Solution Benefits -->
            <div class="landing-benefits-grid">
                <?php
                // Solution benefits
                $benefits_count = intval(get_post_meta(get_the_ID(), '_landing_benefits_count', true) ?: 4);
                
                for ($i = 1; $i <= $benefits_count; $i++) :
                    $benefit_title = get_post_meta(get_the_ID(), "_landing_benefit_{$i}_title", true);
                    $benefit_text = get_post_meta(get_the_ID(), "_landing_benefit_{$i}_text", true);
                    $benefit_icon = get_post_meta(get_the_ID(), "_landing_benefit_{$i}_icon", true) ?: 'fas fa-check-circle';
                    
                    if ($benefit_title || $benefit_text) :
                ?>
                <div class="landing-benefit-card">
                    <div class="benefit-icon">
                        <i class="<?php echo esc_attr($benefit_icon); ?>"></i>
                    </div>
                    <div class="benefit-content">
                        <?php if ($benefit_title) : ?>
                            <h3 class="benefit-title"><?php echo esc_html($benefit_title); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ($benefit_text) : ?>
                            <p class="benefit-text"><?php echo esc_html($benefit_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                    endif;
                endfor;
                
                // If no benefits are defined, show placeholders
                if (!get_post_meta(get_the_ID(), '_landing_benefit_1_title', true)) :
                    $default_benefits = [
                        [
                            'title' => 'Personalized Approach',
                            'text' => 'Custom training plan tailored to your dog\'s specific needs and your family\'s goals.',
                            'icon' => 'fas fa-user-check'
                        ],
                        [
                            'title' => 'Science-Based Methods',
                            'text' => 'Positive reinforcement techniques backed by behavioral science for lasting results.',
                            'icon' => 'fas fa-brain'
                        ],
                        [
                            'title' => 'Expert Guidance',
                            'text' => 'Professional trainers with years of experience solving complex behavior issues.',
                            'icon' => 'fas fa-graduation-cap'
                        ],
                        [
                            'title' => 'Ongoing Support',
                            'text' => 'Continued assistance to ensure long-term success and address any new challenges.',
                            'icon' => 'fas fa-hands-helping'
                        ]
                    ];
                    
                    foreach ($default_benefits as $benefit) :
                ?>
                <div class="landing-benefit-card">
                    <div class="benefit-icon">
                        <i class="<?php echo esc_attr($benefit['icon']); ?>"></i>
                    </div>
                    <div class="benefit-content">
                        <h3 class="benefit-title"><?php echo esc_html($benefit['title']); ?></h3>
                        <p class="benefit-text"><?php echo esc_html($benefit['text']); ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            
            <?php if ($solution_cta_text = get_post_meta(get_the_ID(), '_landing_solution_cta_text', true)) : ?>
                <div class="landing-solution-cta">
                    <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_landing_solution_cta_url', true) ?: '#offer'); ?>" class="gdkc-button primary"><?php echo esc_html($solution_cta_text); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="landing-testimonials-section" id="testimonials">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_testimonials_title', true) ?: 'Success Stories'); ?></h2>
            
            <?php if ($testimonials_subtitle = get_post_meta(get_the_ID(), '_landing_testimonials_subtitle', true)) : ?>
                <p class="section-subtitle"><?php echo esc_html($testimonials_subtitle); ?></p>
            <?php endif; ?>
            
            <div class="landing-testimonials-slider">
                <?php
                // Get testimonials
                $testimonials_query = new WP_Query([
                    'post_type' => 'testimonial',
                    'posts_per_page' => 3
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
                    // Fallback testimonials if none are found
                    $fallback_testimonials = [
                        [
                            'content' => 'We were at our wit\'s end with our dog\'s behavior issues. After working with Good Dogz KC, the transformation has been incredible. Our dog is now calm, well-behaved, and a joy to be around!',
                            'name' => 'Sarah & Mike T.',
                            'dog' => 'Bailey',
                            'rating' => 5
                        ],
                        [
                            'content' => 'I was skeptical at first, but the results speak for themselves. Our dog\'s anxiety is so much better, and we finally have the tools to help him when he gets stressed. Worth every penny!',
                            'name' => 'James K.',
                            'dog' => 'Max',
                            'rating' => 5
                        ],
                        [
                            'content' => 'The personalized approach made all the difference. Other trainers gave us generic advice that didn\'t work for our situation. Good Dogz KC took the time to understand our specific challenges and created a plan that actually worked.',
                            'name' => 'Jennifer L.',
                            'dog' => 'Daisy',
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
            
            <div class="landing-testimonials-nav">
                <button class="testimonial-prev" aria-label="Previous testimonial">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="testimonial-next" aria-label="Next testimonial">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
    
    <!-- Offer Section -->
    <section class="landing-offer-section" id="offer">
        <div class="container">
            <div class="landing-offer-card">
                <div class="offer-header">
                    <h2 class="offer-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_offer_title', true) ?: 'Special Offer'); ?></h2>
                    
                    <?php if ($offer_subtitle = get_post_meta(get_the_ID(), '_landing_offer_subtitle', true)) : ?>
                        <p class="offer-subtitle"><?php echo esc_html($offer_subtitle); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="offer-content">
                    <div class="offer-details">
                        <?php if ($offer_content = get_post_meta(get_the_ID(), '_landing_offer_content', true)) : ?>
                            <div class="offer-description">
                                <?php echo wpautop(wp_kses_post($offer_content)); ?>
                            </div>
                        <?php else : ?>
                            <div class="offer-description">
                                <p>For a limited time, we're offering a special discount on our most popular training program. Get expert training, personalized guidance, and ongoing support to transform your dog's behavior.</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="offer-features">
                            <?php
                            // Offer features
                            $features_count = intval(get_post_meta(get_the_ID(), '_landing_features_count', true) ?: 0);
                            
                            if ($features_count > 0) :
                                echo '<ul class="offer-features-list">';
                                
                                for ($i = 1; $i <= $features_count; $i++) :
                                    $feature_text = get_post_meta(get_the_ID(), "_landing_feature_{$i}", true);
                                    
                                    if ($feature_text) :
                                        echo '<li><i class="fas fa-check"></i> ' . esc_html($feature_text) . '</li>';
                                    endif;
                                endfor;
                                
                                echo '</ul>';
                            else :
                                // Default features
                                $default_features = [
                                    'Comprehensive behavior assessment',
                                    'Customized training plan',
                                    'One-on-one training sessions',
                                    'Ongoing email support',
                                    '30-day satisfaction guarantee'
                                ];
                                
                                echo '<ul class="offer-features-list">';
                                foreach ($default_features as $feature) :
                                    echo '<li><i class="fas fa-check"></i> ' . esc_html($feature) . '</li>';
                                endforeach;
                                echo '</ul>';
                            endif;
                            ?>
                        </div>
                        
                        <div class="offer-pricing">
                            <?php if ($regular_price = get_post_meta(get_the_ID(), '_landing_regular_price', true)) : ?>
                                <div class="regular-price">Regular Price: <span><?php echo esc_html($regular_price); ?></span></div>
                            <?php else : ?>
                                <div class="regular-price">Regular Price: <span>$499</span></div>
                            <?php endif; ?>
                            
                            <?php if ($offer_price = get_post_meta(get_the_ID(), '_landing_offer_price', true)) : ?>
                                <div class="offer-price">Special Offer: <span><?php echo esc_html($offer_price); ?></span></div>
                            <?php else : ?>
                                <div class="offer-price">Special Offer: <span>$399</span></div>
                            <?php endif; ?>
                            
                            <?php if ($savings = get_post_meta(get_the_ID(), '_landing_savings', true)) : ?>
                                <div class="savings">You Save: <span><?php echo esc_html($savings); ?></span></div>
                            <?php else : ?>
                                <div class="savings">You Save: <span>$100</span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="offer-guarantee">
                        <div class="guarantee-badge">
                            <span>100%</span>
                            <span>Satisfaction<br>Guarantee</span>
                        </div>
                        <p class="guarantee-text"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_guarantee_text', true) ?: 'If you don\'t see improvement in your dog\'s behavior, your next session is free.'); ?></p>
                    </div>
                </div>
                
                <div class="offer-cta">
                    <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_landing_offer_cta_url', true) ?: '#contact-form'); ?>" class="gdkc-button primary"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_offer_cta_text', true) ?: 'Claim This Offer Now'); ?></a>
                    
                    <?php if ($offer_expiry = get_post_meta(get_the_ID(), '_landing_offer_expiry', true)) : ?>
                        <p class="offer-expiry">Offer expires: <?php echo esc_html($offer_expiry); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="landing-faq-section" id="faq">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_post_meta(get_the_ID(), '_landing_faq_title', true) ?: 'Frequently Asked Questions'); ?></h2>
            
            <div class="landing-faq-container">
                <?php
                // FAQ items
                $faq_count = intval(get_post_meta(get_the_ID(), '_landing_faq_count', true) ?: 0);
                
                if ($faq_count > 0) :
                    for ($i = 1; $i <= $faq_count; $i++) :
                        $faq_question = get_post_meta(get_the_ID(), "_landing_faq_{$i}_question", true);
                        $faq_answer = get_post_meta(get_the_ID(), "_landing_faq_{$i}_answer", true);
                        
                        if ($faq_question && $faq_answer) :
                ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false" aria-controls="landing-faq-answer-<?php echo $i; ?>">
                        <span><?php echo esc_html($faq_question); ?></span>
                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="landing-faq-answer-<?php echo $i; ?>">
                        <?php echo wpautop(wp_kses_post($faq_answer)); ?>
                    </div>
                </div>
                <?php
                        endif;
                    endfor;
                else :
                    // Default FAQs
                    $default_faqs = [
                        [
                            'question' => 'How long will it take to see results?',
                            'answer' => 'Many clients see initial improvements within the first 1-2 weeks of consistent training. However, lasting behavior change typically takes 4-8 weeks of dedicated practice, depending on the issue\'s severity and your consistency with the training plan.'
                        ],
                        [
                            'question' => 'What training methods do you use?',
                            'answer' => 'We use science-based, force-free training methods that focus on positive reinforcement and clear communication. Our approach emphasizes rewarding desired behaviors while teaching alternative behaviors to replace unwanted ones.'
                        ],
                        [
                            'question' => 'Will this
