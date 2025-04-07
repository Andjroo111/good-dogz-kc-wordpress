<?php
/**
 * Template for displaying single Success Story
 *
 * @package Good_Dogz_KC
 */

get_header();

// Get custom fields
$owner_name = get_field('owner_name');
$dog_name = get_field('dog_name');
$dog_breed = get_field('dog_breed');
$dog_age = get_field('dog_age');
$before_photo = get_field('before_photo');
$after_photo = get_field('after_photo');
$gallery = get_field('gallery');
$training_program = get_field('training_program');
$testimonial = get_field('testimonial');
$challenges = get_field('challenges');
$solutions = get_field('solutions');
$results = get_field('results');
$video = get_field('video_testimonial');

// Get taxonomy terms
$size_terms = get_the_terms(get_the_ID(), 'gdkc_dog_size');
$service_terms = get_the_terms(get_the_ID(), 'gdkc_service_type');

// Get related package if exists
$related_package = get_field('related_package');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gdkc-success-story'); ?>>
    <div class="gdkc-page-header">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <?php if ($dog_name || $dog_breed || $size_terms) : ?>
                <div class="dog-meta">
                    <?php if ($dog_name) : ?>
                        <span class="dog-name"><?php echo esc_html($dog_name); ?></span>
                    <?php endif; ?>
                    
                    <?php if ($dog_breed) : ?>
                        <span class="dog-breed"><?php echo esc_html($dog_breed); ?></span>
                    <?php endif; ?>
                    
                    <?php if ($dog_age) : ?>
                        <span class="dog-age"><?php echo esc_html($dog_age); ?> years old</span>
                    <?php endif; ?>
                    
                    <?php if ($size_terms && !is_wp_error($size_terms)) : ?>
                        <span class="dog-size"><?php echo esc_html($size_terms[0]->name); ?> Dog</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($service_terms && !is_wp_error($service_terms)) : ?>
                <div class="service-types">
                    <?php foreach ($service_terms as $term) : ?>
                        <span class="service-type"><?php echo esc_html($term->name); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="gdkc-success-content">
            <div class="content-main">
                <?php if ($before_photo && $after_photo) : ?>
                    <div class="before-after-comparison">
                        <h3>Training Transformation</h3>
                        <div class="images-container">
                            <div class="before-image">
                                <span class="label">Before</span>
                                <?php echo wp_get_attachment_image($before_photo['ID'], 'large'); ?>
                            </div>
                            <div class="after-image">
                                <span class="label">After</span>
                                <?php echo wp_get_attachment_image($after_photo['ID'], 'large'); ?>
                            </div>
                        </div>
                    </div>
                <?php elseif (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($video) : ?>
                    <div class="video-testimonial">
                        <h3>Video Testimonial</h3>
                        <div class="video-container">
                            <?php 
                            // Handle different video formats (YouTube, Vimeo, or file)
                            if (strpos($video, 'youtube.com') !== false || strpos($video, 'youtu.be') !== false) {
                                echo wp_oembed_get($video);
                            } elseif (strpos($video, 'vimeo.com') !== false) {
                                echo wp_oembed_get($video);
                            } else {
                                echo do_shortcode('[video src="' . esc_url($video) . '" controls="true"]');
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($challenges || $solutions || $results) : ?>
                    <div class="training-journey">
                        <h3>Training Journey</h3>
                        
                        <?php if ($challenges) : ?>
                            <div class="journey-section challenges">
                                <h4>Challenges</h4>
                                <div class="section-content">
                                    <?php echo wp_kses_post($challenges); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($solutions) : ?>
                            <div class="journey-section solutions">
                                <h4>Our Approach</h4>
                                <div class="section-content">
                                    <?php echo wp_kses_post($solutions); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($results) : ?>
                            <div class="journey-section results">
                                <h4>Results</h4>
                                <div class="section-content">
                                    <?php echo wp_kses_post($results); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($testimonial) : ?>
                    <div class="client-testimonial">
                        <h3>Testimonial</h3>
                        <blockquote>
                            <?php echo wp_kses_post($testimonial); ?>
                            <?php if ($owner_name) : ?>
                                <cite>- <?php echo esc_html($owner_name); ?></cite>
                            <?php endif; ?>
                        </blockquote>
                    </div>
                <?php endif; ?>
                
                <?php if ($gallery) : ?>
                    <div class="photo-gallery">
                        <h3>Photo Gallery</h3>
                        <div class="gallery-grid">
                            <?php foreach ($gallery as $image) : ?>
                                <div class="gallery-item">
                                    <a href="<?php echo esc_url($image['url']); ?>" class="lightbox">
                                        <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="story-navigation">
                    <div class="nav-previous"><?php previous_post_link('%link', '&laquo; Previous Success Story'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Next Success Story &raquo;'); ?></div>
                </div>
            </div>
            
            <div class="content-sidebar">
                <?php if ($training_program) : ?>
                    <div class="training-program-box">
                        <h3>Training Program</h3>
                        <div class="program-name"><?php echo esc_html($training_program); ?></div>
                        
                        <?php if ($related_package) : 
                            $package_image = get_the_post_thumbnail_url($related_package->ID, 'medium');
                            $package_price = get_field('price', $related_package->ID);
                            $package_duration = get_field('duration', $related_package->ID);
                        ?>
                            <div class="related-package">
                                <h4>Interested in this program?</h4>
                                <div class="package-preview">
                                    <?php if ($package_image) : ?>
                                        <div class="package-image">
                                            <img src="<?php echo esc_url($package_image); ?>" alt="<?php echo esc_attr($related_package->post_title); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="package-info">
                                        <h5><?php echo esc_html($related_package->post_title); ?></h5>
                                        
                                        <?php if ($package_price) : ?>
                                            <div class="package-price"><?php echo esc_html($package_price); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if ($package_duration) : ?>
                                            <div class="package-duration"><?php echo esc_html($package_duration); ?></div>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo esc_url(get_permalink($related_package->ID)); ?>" class="view-package-link">View Package Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="cta-box">
                    <h3>Transform Your Dog's Behavior</h3>
                    <p>Every dog has unique needs. Take our behavior assessment to receive personalized training recommendations.</p>
                    <a href="<?php echo esc_url(home_url('/dog-behavior-assessment/')); ?>" class="cta-button">Take the Assessment</a>
                </div>
                
                <div class="share-box">
                    <h3>Share This Success Story</h3>
                    <div class="social-share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="facebook-share">
                            <span class="screen-reader-text">Share on Facebook</span>
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="twitter-share">
                            <span class="screen-reader-text">Share on Twitter</span>
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" class="email-share">
                            <span class="screen-reader-text">Share via Email</span>
                            <i class="fa fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="related-success-stories">
        <div class="container">
            <h2>More Success Stories</h2>
            
            <?php
            // Get related success stories (same service type or dog size)
            $related_args = [
                'post_type' => 'gdkc_success',
                'posts_per_page' => 3,
                'post__not_in' => [get_the_ID()],
                'orderby' => 'rand',
            ];
            
            // Add tax query if we have terms
            if ($service_terms && !is_wp_error($service_terms) || $size_terms && !is_wp_error($size_terms)) {
                $related_args['tax_query'] = ['relation' => 'OR'];
                
                if ($service_terms && !is_wp_error($service_terms)) {
                    $service_ids = [];
                    foreach ($service_terms as $term) {
                        $service_ids[] = $term->term_id;
                    }
                    
                    $related_args['tax_query'][] = [
                        'taxonomy' => 'gdkc_service_type',
                        'field' => 'term_id',
                        'terms' => $service_ids,
                    ];
                }
                
                if ($size_terms && !is_wp_error($size_terms)) {
                    $size_ids = [];
                    foreach ($size_terms as $term) {
                        $size_ids[] = $term->term_id;
                    }
                    
                    $related_args['tax_query'][] = [
                        'taxonomy' => 'gdkc_dog_size',
                        'field' => 'term_id',
                        'terms' => $size_ids,
                    ];
                }
            }
            
            $related_query = new WP_Query($related_args);
            
            if ($related_query->have_posts()) : ?>
                <div class="related-stories-grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                        $r_dog_name = get_field('dog_name');
                        $r_dog_breed = get_field('dog_breed');
                        $r_excerpt = get_field('testimonial_excerpt') ?: wp_trim_words(get_field('testimonial'), 15);
                    ?>
                        <div class="related-story-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="card-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-content">
                                <h3 class="related-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php if ($r_dog_name || $r_dog_breed) : ?>
                                    <div class="related-dog-info">
                                        <?php if ($r_dog_name) : ?>
                                            <span class="dog-name"><?php echo esc_html($r_dog_name); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($r_dog_breed) : ?>
                                            <span class="dog-breed"><?php echo esc_html($r_dog_breed); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($r_excerpt) : ?>
                                    <div class="related-excerpt">
                                        <?php echo wp_kses_post($r_excerpt); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more">Read Story</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>No related success stories found.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
            
            <div class="all-stories-link">
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_success')); ?>" class="button">View All Success Stories</a>
            </div>
        </div>
    </div>
</article>

<?php get_footer(); ?>