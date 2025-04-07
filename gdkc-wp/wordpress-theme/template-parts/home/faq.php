<?php
/**
 * Template part for displaying the FAQ section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <h2 class="section-title"><?php echo get_theme_mod('faq_title', 'Frequently Asked Questions'); ?></h2>
        <p class="section-subtitle text-center"><?php echo get_theme_mod('faq_subtitle', 'Find answers to common questions about our training programs'); ?></p>
        
        <!-- Mobile-optimized FAQ categories -->
        <div class="faq-categories">
            <button class="faq-category active" data-category="all">All Questions</button>
            <button class="faq-category" data-category="training">Training Process</button>
            <button class="faq-category" data-category="cost">Pricing & Packages</button>
            <button class="faq-category" data-category="behavior">Behavior Issues</button>
            <button class="faq-category" data-category="logistics">Logistics</button>
        </div>
        
        <!-- Jump Links for Quick Access -->
        <div class="faq-jump-links">
            <a href="#faq-training-time" class="faq-jump-link">Training Timeline</a>
            <a href="#faq-methods" class="faq-jump-link">Training Methods</a>
            <a href="#faq-cost" class="faq-jump-link">Pricing</a>
            <a href="#faq-age" class="faq-jump-link">Dog's Age</a>
            <a href="#faq-guarantee" class="faq-jump-link">Guarantees</a>
        </div>
        
        <div class="faq-container">
            <?php
            // Query for FAQ posts
            $faq_query = new WP_Query([
                'post_type' => 'faq',
                'posts_per_page' => -1
            ]);
            
            if ($faq_query->have_posts()) :
                $faq_count = 0;
                while ($faq_query->have_posts()) : $faq_query->the_post();
                    $faq_category = get_post_meta(get_the_ID(), '_faq_category', true);
                    $faq_id = get_post_meta(get_the_ID(), '_faq_id', true) ?: 'faq-' . $faq_count;
                    $faq_count++;
            ?>
                <div class="faq-item" id="<?php echo esc_attr($faq_id); ?>" data-category="<?php echo esc_attr($faq_category); ?>">
                    <div class="faq-question">
                        <h3><?php the_title(); ?></h3>
                        <button class="faq-toggle" aria-expanded="false">
                            <span class="screen-reader-text">Toggle answer</span>
                            <i class="fas fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="faq-answer" hidden>
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback FAQs if no custom post type entries
                $fallback_faqs = [
                    [
                        'question' => 'How long does training typically take?',
                        'answer' => 'Most dogs show significant improvement within 2-4 weeks of consistent training. However, the exact timeline depends on your dog\'s individual needs, the severity of the issues, and your consistency with the training plan. Our training programs are designed to create lasting changes, not just quick fixes.',
                        'category' => 'training',
                        'id' => 'faq-training-time'
                    ],
                    [
                        'question' => 'What training methods do you use?',
                        'answer' => 'We use balanced training methods that combine positive reinforcement with clear boundaries. We focus on rewarding good behavior while also teaching dogs that their choices have consequences. Our approach is gentle but firm, and we never use harsh or abusive techniques. We customize our approach based on your dog\'s temperament and the specific issues you\'re experiencing.',
                        'category' => 'training',
                        'id' => 'faq-methods'
                    ],
                    [
                        'question' => 'How much does dog training cost?',
                        'answer' => 'Our training programs start at $85 for virtual sessions, $150 for in-home sessions, and $1,200 for comprehensive board & train programs. The exact cost depends on your dog\'s needs and the program you choose. We offer flexible payment plans and a satisfaction guarantee with all our programs. Contact us for a personalized quote based on your situation.',
                        'category' => 'cost',
                        'id' => 'faq-cost'
                    ],
                    [
                        'question' => 'Is my dog too old/young for training?',
                        'answer' => 'No dog is too old for training! While puppies (8+ weeks) are often easier to train because they haven\'t developed ingrained habits, we regularly work with senior dogs with great success. The training approach may differ based on your dog\'s age, but positive change is possible at any stage of life. It\'s never too late to improve your dog\'s behavior and quality of life.',
                        'category' => 'behavior',
                        'id' => 'faq-age'
                    ],
                    [
                        'question' => 'Do you offer any guarantees?',
                        'answer' => 'Yes! We offer a 30-day satisfaction guarantee on all our training programs. If you\'re following the training plan and not seeing improvement, we\'ll provide additional sessions at no extra cost. We\'re committed to your success and will work with you until you see positive changes in your dog\'s behavior. Our goal is a transformed relationship with your dog, not just temporary fixes.',
                        'category' => 'logistics',
                        'id' => 'faq-guarantee'
                    ]
                ];
                
                foreach ($fallback_faqs as $faq) :
            ?>
                <div class="faq-item" id="<?php echo esc_attr($faq['id']); ?>" data-category="<?php echo esc_attr($faq['category']); ?>">
                    <div class="faq-question">
                        <h3><?php echo esc_html($faq['question']); ?></h3>
                        <button class="faq-toggle" aria-expanded="false">
                            <span class="screen-reader-text">Toggle answer</span>
                            <i class="fas fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="faq-answer" hidden>
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </div>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        
        <div class="faq-cta text-center">
            <p><?php echo get_theme_mod('faq_cta_text', 'Have a question that\'s not answered here?'); ?></p>
            <a href="<?php echo get_theme_mod('faq_cta_button_url', '#contact'); ?>" class="gdkc-button secondary"><?php echo get_theme_mod('faq_cta_button_text', 'Contact Us'); ?></a>
        </div>
    </div>
</section>