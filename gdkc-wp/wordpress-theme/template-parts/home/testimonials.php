<?php
/**
 * Template part for displaying the testimonials section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Get component settings if available
$settings = [];
if (is_page()) {
    $settings = get_post_meta(get_the_ID(), '_gdkc_testimonials_settings', true);
    if (!is_array($settings)) {
        $settings = [];
    }
}

// Get settings with fallbacks from customizer or defaults
$title = !empty($settings['title']) ? $settings['title'] : get_theme_mod('testimonials_title', 'What Our Clients Say');
$subtitle = !empty($settings['subtitle']) ? $settings['subtitle'] : '';
$layout = !empty($settings['layout']) ? $settings['layout'] : 'grid';
$per_page = !empty($settings['per_page']) ? intval($settings['per_page']) : 3;
$show_rating = isset($settings['show_rating']) ? (bool) $settings['show_rating'] : true;
$show_image = isset($settings['show_image']) ? (bool) $settings['show_image'] : true;
$specific_ids = !empty($settings['ids']) ? array_map('trim', explode(',', $settings['ids'])) : [];
$category = !empty($settings['category']) ? $settings['category'] : '';

// Background settings
$background = !empty($settings['background']) ? $settings['background'] : '';
$style = !empty($background) ? 'background-color: ' . esc_attr($background) . ';' : '';

// Query args
$query_args = [
    'post_type' => 'testimonial',
    'posts_per_page' => $per_page
];

// Add specific IDs if set
if (!empty($specific_ids)) {
    $query_args['post__in'] = $specific_ids;
    $query_args['orderby'] = 'post__in';
}

// Add category if set
if (!empty($category)) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'testimonial_category',
            'field' => 'slug',
            'terms' => $category,
        ]
    ];
}
?>

<!-- Testimonials Section -->
<section class="testimonials-section" id="testimonials" data-section-type="testimonials" <?php if (!empty($style)) echo 'style="' . $style . '"'; ?>>
    <div class="container">
        <h2 class="section-title" id="testimonials-heading"><?php echo esc_html($title); ?></h2>
        
        <?php if (!empty($subtitle)) : ?>
        <p class="section-subtitle"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>
        
        <div class="testimonials-<?php echo esc_attr($layout); ?>" role="list">
            <?php
            // Query for testimonials
            $testimonials_query = new WP_Query($query_args);
            
            if ($testimonials_query->have_posts()) :
                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                    $client_name = get_post_meta(get_the_ID(), '_testimonial_client_name', true);
                    $dog_name = get_post_meta(get_the_ID(), '_testimonial_dog_name', true);
                    $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
            ?>
            <div class="testimonial-card" role="listitem">
                <blockquote class="testimonial-card__content">
                    <?php the_content(); ?>
                </blockquote>
                <div class="testimonial-card__author">
                    <?php if ($show_image) : ?>
                        <div class="testimonial-card__avatar" aria-hidden="true">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail'); ?>
                            <?php else : ?>
                                <div class="image-placeholder" style="width: 48px; height: 48px; min-height: auto; border-radius: 50%; padding: 0;">
                                    <i class="fas fa-user" style="font-size: 1rem; margin: 0;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <cite class="testimonial-card__name"><?php echo esc_html($client_name); ?></cite>
                        <div class="testimonial-card__title">Owner of <?php echo esc_html($dog_name); ?></div>
                        <?php if ($show_rating && $rating) : ?>
                            <div class="testimonial-card__rating" aria-label="<?php echo esc_attr($rating); ?> out of 5 stars rating">
                                <?php for ($i = 0; $i < $rating; $i++) : ?>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback testimonials if no custom post type entries
                $fallback_testimonials = [
                    [
                        'content' => '"We were at our wit\'s end with our rescue dog\'s leash reactivity. After just 4 weeks of training with Good Dogz KC, we can now walk past other dogs without drama. Their methods are effective and compassionate."',
                        'name' => 'Michael T.',
                        'dog' => 'Bella',
                        'rating' => 5
                    ],
                    [
                        'content' => '"Our puppy was completely unmanageable - jumping on everyone, chewing everything, and never listening. Good Dogz KC not only trained our dog but taught us the skills we needed to maintain her training. Life-changing!"',
                        'name' => 'Jessica R.',
                        'dog' => 'Max',
                        'rating' => 5
                    ],
                    [
                        'content' => '"My dog had severe anxiety and would destroy our house whenever we left. Good Dogz KC\'s separation anxiety program was methodical and effective. Now she calmly settles when we leave. Their follow-up support is amazing too!"',
                        'name' => 'David & Sarah K.',
                        'dog' => 'Luna',
                        'rating' => 5
                    ]
                ];
                
                // Limit the number of fallbacks to display
                $fallback_testimonials = array_slice($fallback_testimonials, 0, $per_page);
                
                foreach ($fallback_testimonials as $testimonial) :
            ?>
            <div class="testimonial-card" role="listitem">
                <blockquote class="testimonial-card__content">
                    <?php echo esc_html($testimonial['content']); ?>
                </blockquote>
                <div class="testimonial-card__author">
                    <?php if ($show_image) : ?>
                        <div class="testimonial-card__avatar" aria-hidden="true">
                            <div class="image-placeholder" style="width: 48px; height: 48px; min-height: auto; border-radius: 50%; padding: 0;">
                                <i class="fas fa-user" style="font-size: 1rem; margin: 0;"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <cite class="testimonial-card__name"><?php echo esc_html($testimonial['name']); ?></cite>
                        <div class="testimonial-card__title">Owner of <?php echo esc_html($testimonial['dog']); ?></div>
                        <?php if ($show_rating) : ?>
                            <div class="testimonial-card__rating" aria-label="<?php echo esc_attr($testimonial['rating']); ?> out of 5 stars rating">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++) : ?>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        
        <?php
        // Only show video testimonial section if not configured to hide in settings
        $show_video = !isset($settings['show_video']) || $settings['show_video'];
        if ($show_video) :
            $video_title = !empty($settings['video_title']) ? $settings['video_title'] : get_theme_mod('video_testimonial_title', 'Watch Our Client Success Stories');
            $video_url = !empty($settings['video_url']) ? $settings['video_url'] : get_theme_mod('video_testimonial_url');
            $cta_text = !empty($settings['cta_text']) ? $settings['cta_text'] : get_theme_mod('video_testimonial_cta_text', 'Book Your Free Consultation');
            $cta_url = !empty($settings['cta_url']) ? $settings['cta_url'] : get_theme_mod('video_testimonial_cta_url', '#contact');
        ?>
        <div class="video-testimonial">
            <h3 class="video-testimonial__title"><?php echo esc_html($video_title); ?></h3>
            <?php if ($video_url) : ?>
                <div class="video-container">
                    <?php echo wp_oembed_get($video_url); ?>
                </div>
            <?php else : ?>
                <div class="video-placeholder hover-lift">
                    <i class="fas fa-play-circle"></i>
                    <span>Client Testimonial Video</span>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="gdkc-button primary gdkc-mt-lg"><?php echo esc_html($cta_text); ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>