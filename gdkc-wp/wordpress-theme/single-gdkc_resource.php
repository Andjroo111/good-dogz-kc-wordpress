<?php
/**
 * Template for displaying single Resource
 *
 * @package Good_Dogz_KC
 */

get_header();

// Check if this is a redirect resource type
$resource_type = get_field('resource_type');
$resource_url = get_field('resource_url');
$file_download = get_field('file_download');

// If this is an external resource, redirect to the external URL
if ($resource_type === 'external' && $resource_url) {
    wp_redirect($resource_url);
    exit;
}

// If this is a download resource, redirect to the file
if ($resource_type === 'download' && $file_download) {
    wp_redirect($file_download['url']);
    exit;
}

// Get custom fields
$estimated_time = get_field('estimated_time');
$featured_video = get_field('featured_video');
$table_of_contents = get_field('table_of_contents');
$resource_content = get_field('resource_content');
$key_takeaways = get_field('key_takeaways');
$related_resources = get_field('related_resources');
$related_packages = get_field('related_packages');

// Get taxonomy terms
$category_terms = get_the_terms(get_the_ID(), 'gdkc_resource_category');
$level_terms = get_the_terms(get_the_ID(), 'gdkc_resource_level');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gdkc-resource-single'); ?>>
    <div class="gdkc-page-header">
        <div class="container">
            <div class="breadcrumbs">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> &raquo;
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_resource')); ?>">Resources</a> &raquo;
                <?php if ($category_terms && !is_wp_error($category_terms)) : ?>
                    <a href="<?php echo esc_url(get_term_link($category_terms[0])); ?>"><?php echo esc_html($category_terms[0]->name); ?></a> &raquo;
                <?php endif; ?>
                <span><?php the_title(); ?></span>
            </div>
            
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <div class="resource-meta">
                <?php if ($category_terms && !is_wp_error($category_terms)) : ?>
                    <div class="resource-categories">
                        <?php foreach ($category_terms as $term) : ?>
                            <span class="category-tag"><?php echo esc_html($term->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="resource-details">
                    <?php if ($estimated_time) : ?>
                        <span class="time-estimate"><i class="fa fa-clock-o"></i> <?php echo esc_html($estimated_time); ?></span>
                    <?php endif; ?>
                    
                    <?php if ($level_terms && !is_wp_error($level_terms)) : ?>
                        <span class="difficulty-level"><i class="fa fa-signal"></i> <?php echo esc_html($level_terms[0]->name); ?> Level</span>
                    <?php endif; ?>
                    
                    <span class="publish-date"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="gdkc-resource-content">
            <div class="content-main">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($featured_video) : ?>
                    <div class="featured-video">
                        <?php 
                        // Handle different video formats (YouTube, Vimeo, or file)
                        if (strpos($featured_video, 'youtube.com') !== false || strpos($featured_video, 'youtu.be') !== false) {
                            echo wp_oembed_get($featured_video);
                        } elseif (strpos($featured_video, 'vimeo.com') !== false) {
                            echo wp_oembed_get($featured_video);
                        } else {
                            echo do_shortcode('[video src="' . esc_url($featured_video) . '" controls="true"]');
                        }
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($key_takeaways) : ?>
                    <div class="key-takeaways">
                        <h3>Key Takeaways</h3>
                        <div class="takeaways-content">
                            <?php echo wp_kses_post($key_takeaways); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($table_of_contents) : ?>
                    <div class="table-of-contents">
                        <h3>Table of Contents</h3>
                        <?php echo wp_kses_post($table_of_contents); ?>
                    </div>
                <?php endif; ?>
                
                <div class="main-content">
                    <?php 
                    if ($resource_content) {
                        echo wp_kses_post($resource_content);
                    } else {
                        the_content();
                    }
                    ?>
                </div>
                
                <div class="resource-footer">
                    <div class="social-share">
                        <h3>Share This Resource</h3>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="facebook-share">
                                <i class="fa fa-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="twitter-share">
                                <i class="fa fa-twitter"></i> Twitter
                            </a>
                            <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_the_excerpt() . "\n\n" . get_permalink()); ?>" class="email-share">
                                <i class="fa fa-envelope"></i> Email
                            </a>
                            <a href="javascript:window.print();" class="print-share">
                                <i class="fa fa-print"></i> Print
                            </a>
                        </div>
                    </div>
                    
                    <?php if (has_tag()) : ?>
                        <div class="resource-tags">
                            <h3>Tags</h3>
                            <?php the_tags('<div class="tag-list">', '', '</div>'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($related_resources) : ?>
                    <div class="related-resources">
                        <h3>Related Resources</h3>
                        <div class="related-resources-grid">
                            <?php foreach ($related_resources as $resource) : 
                                $r_type = get_field('resource_type', $resource->ID);
                                $r_thumb = get_the_post_thumbnail_url($resource->ID, 'medium');
                            ?>
                                <div class="related-resource-card">
                                    <a href="<?php echo get_permalink($resource->ID); ?>" class="resource-link">
                                        <?php if ($r_thumb) : ?>
                                            <div class="resource-image">
                                                <img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr($resource->post_title); ?>">
                                                <?php if ($r_type) : ?>
                                                    <span class="resource-type <?php echo esc_attr($r_type); ?>">
                                                        <?php echo esc_html(ucfirst($r_type)); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <h4 class="resource-title"><?php echo esc_html($resource->post_title); ?></h4>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="content-sidebar">
                <div class="author-info">
                    <?php 
                    $author_id = get_the_author_meta('ID');
                    $author_name = get_the_author();
                    $author_desc = get_the_author_meta('description');
                    $author_url = get_author_posts_url($author_id);
                    $author_avatar = get_avatar_url($author_id, ['size' => 120]);
                    ?>
                    
                    <h3>About the Author</h3>
                    <div class="author-box">
                        <?php if ($author_avatar) : ?>
                            <div class="author-avatar">
                                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <div class="author-details">
                            <h4 class="author-name"><?php echo esc_html($author_name); ?></h4>
                            <?php if ($author_desc) : ?>
                                <div class="author-bio"><?php echo wp_kses_post($author_desc); ?></div>
                            <?php endif; ?>
                            <a href="<?php echo esc_url($author_url); ?>" class="author-link">View all posts by <?php echo esc_html($author_name); ?></a>
                        </div>
                    </div>
                </div>
                
                <?php if ($related_packages) : ?>
                    <div class="related-packages">
                        <h3>Recommended Training Packages</h3>
                        <?php foreach ($related_packages as $package) :
                            $package_price = get_field('price', $package->ID);
                            $package_duration = get_field('duration', $package->ID);
                            $package_image = get_the_post_thumbnail_url($package->ID, 'thumbnail');
                        ?>
                            <div class="package-card">
                                <?php if ($package_image) : ?>
                                    <div class="package-image">
                                        <img src="<?php echo esc_url($package_image); ?>" alt="<?php echo esc_attr($package->post_title); ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="package-info">
                                    <h4 class="package-title"><?php echo esc_html($package->post_title); ?></h4>
                                    
                                    <div class="package-meta">
                                        <?php if ($package_price) : ?>
                                            <span class="package-price"><?php echo esc_html($package_price); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($package_duration) : ?>
                                            <span class="package-duration"><?php echo esc_html($package_duration); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="<?php echo get_permalink($package->ID); ?>" class="view-package">View Package</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="assessment-cta">
                    <h3>Not Sure Which Training is Right for Your Dog?</h3>
                    <p>Take our comprehensive behavior assessment to receive personalized training recommendations tailored to your dog's unique needs.</p>
                    <a href="<?php echo esc_url(home_url('/dog-behavior-assessment/')); ?>" class="assessment-button">Take the Assessment</a>
                </div>
                
                <div class="newsletter-signup">
                    <h3>Get More Training Tips</h3>
                    <p>Subscribe to our newsletter for regular training tips, resources, and updates.</p>
                    <!-- Newsletter signup form would go here -->
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</article>

<?php get_footer(); ?>