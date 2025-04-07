<?php
/**
 * Template for displaying Success Stories archive
 *
 * @package Good_Dogz_KC
 */

get_header();

$title = get_field('success_stories_title', 'option') ?: 'Success Stories';
$description = get_field('success_stories_description', 'option') ?: 'Read about the transformative journeys our clients and their dogs have experienced through our training programs.';

// Get all the dog sizes for filtering
$sizes = get_terms([
    'taxonomy' => 'gdkc_dog_size',
    'hide_empty' => true,
]);

// Get all the service types for filtering
$service_types = get_terms([
    'taxonomy' => 'gdkc_service_type',
    'hide_empty' => true,
]);

// Get the current filter values from URL
$current_size = isset($_GET['dog_size']) ? sanitize_text_field($_GET['dog_size']) : '';
$current_service = isset($_GET['service_type']) ? sanitize_text_field($_GET['service_type']) : '';

// Build the tax query if filters are active
$tax_query = [];

if (!empty($current_size)) {
    $tax_query[] = [
        'taxonomy' => 'gdkc_dog_size',
        'field' => 'slug',
        'terms' => $current_size,
    ];
}

if (!empty($current_service)) {
    $tax_query[] = [
        'taxonomy' => 'gdkc_service_type',
        'field' => 'slug',
        'terms' => $current_service,
    ];
}

if (count($tax_query) > 1) {
    $tax_query['relation'] = 'AND';
}

// Query for success stories
$args = [
    'post_type' => 'gdkc_success',
    'posts_per_page' => 12,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
];

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

$query = new WP_Query($args);
?>

<div class="gdkc-success-stories-archive">
    <div class="gdkc-page-header">
        <div class="container">
            <h1 class="page-title"><?php echo esc_html($title); ?></h1>
            <div class="page-description"><?php echo wp_kses_post($description); ?></div>
        </div>
    </div>

    <div class="container">
        <div class="gdkc-filter-bar">
            <div class="filter-title">Filter Success Stories:</div>
            <form class="gdkc-filters" method="get">
                <div class="filter-group">
                    <label for="dog-size-filter">Dog Size:</label>
                    <select id="dog-size-filter" name="dog_size">
                        <option value="">All Sizes</option>
                        <?php foreach ($sizes as $size) : ?>
                            <option value="<?php echo esc_attr($size->slug); ?>" <?php selected($current_size, $size->slug); ?>>
                                <?php echo esc_html($size->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="service-type-filter">Training Type:</label>
                    <select id="service-type-filter" name="service_type">
                        <option value="">All Training Types</option>
                        <?php foreach ($service_types as $service) : ?>
                            <option value="<?php echo esc_attr($service->slug); ?>" <?php selected($current_service, $service->slug); ?>>
                                <?php echo esc_html($service->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="filter-submit">Apply Filters</button>
                <?php if (!empty($current_size) || !empty($current_service)) : ?>
                    <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_success')); ?>" class="clear-filters">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if ($query->have_posts()) : ?>
            <div class="gdkc-success-grid">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $owner_name = get_field('owner_name');
                    $dog_name = get_field('dog_name');
                    $dog_breed = get_field('dog_breed');
                    $before_photo = get_field('before_photo');
                    $after_photo = get_field('after_photo');
                    $training_program = get_field('training_program');
                    $testimonial_excerpt = get_field('testimonial_excerpt') ?: wp_trim_words(get_field('testimonial'), 30);
                ?>
                    <div class="success-story-card">
                        <div class="images-container">
                            <?php if ($before_photo && $after_photo) : ?>
                                <div class="before-after-images">
                                    <div class="before-image">
                                        <span class="label">Before</span>
                                        <?php echo wp_get_attachment_image($before_photo['ID'], 'medium'); ?>
                                    </div>
                                    <div class="after-image">
                                        <span class="label">After</span>
                                        <?php echo wp_get_attachment_image($after_photo['ID'], 'medium'); ?>
                                    </div>
                                </div>
                            <?php elseif (has_post_thumbnail()) : ?>
                                <div class="featured-image">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-content">
                            <h2 class="story-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="dog-info">
                                <?php if ($dog_name) : ?>
                                    <span class="dog-name"><?php echo esc_html($dog_name); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($dog_breed) : ?>
                                    <span class="dog-breed"><?php echo esc_html($dog_breed); ?></span>
                                <?php endif; ?>
                                
                                <?php 
                                // Show dog size
                                $size_terms = get_the_terms(get_the_ID(), 'gdkc_dog_size');
                                if ($size_terms && !is_wp_error($size_terms)) : 
                                ?>
                                    <span class="dog-size"><?php echo esc_html($size_terms[0]->name); ?> Dog</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($training_program) : ?>
                                <div class="training-program">
                                    <strong>Program:</strong> <?php echo esc_html($training_program); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($testimonial_excerpt) : ?>
                                <div class="testimonial-excerpt">
                                    <?php echo wp_kses_post($testimonial_excerpt); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($owner_name) : ?>
                                <div class="owner-info">
                                    <span class="owner-name">- <?php echo esc_html($owner_name); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more-link">Read Full Story</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="gdkc-pagination">
                <?php
                echo paginate_links(array(
                    'total' => $query->max_num_pages,
                    'prev_text' => '&laquo; Previous',
                    'next_text' => 'Next &raquo;',
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="no-results">
                <p>No success stories found matching your criteria. Try adjusting your filters.</p>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>