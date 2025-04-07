<?php
/**
 * Template for displaying Resources archive
 *
 * @package Good_Dogz_KC
 */

get_header();

$title = get_field('resources_title', 'option') ?: 'Training Resources';
$description = get_field('resources_description', 'option') ?: 'Explore our collection of dog training resources, articles, and guides to help you better understand and train your dog.';

// Get all the resource categories for filtering
$categories = get_terms([
    'taxonomy' => 'gdkc_resource_category',
    'hide_empty' => true,
]);

// Get all the resource levels for filtering
$levels = get_terms([
    'taxonomy' => 'gdkc_resource_level',
    'hide_empty' => true,
]);

// Get the current filter values from URL
$current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$current_level = isset($_GET['level']) ? sanitize_text_field($_GET['level']) : '';

// Build the tax query if filters are active
$tax_query = [];

if (!empty($current_category)) {
    $tax_query[] = [
        'taxonomy' => 'gdkc_resource_category',
        'field' => 'slug',
        'terms' => $current_category,
    ];
}

if (!empty($current_level)) {
    $tax_query[] = [
        'taxonomy' => 'gdkc_resource_level',
        'field' => 'slug',
        'terms' => $current_level,
    ];
}

if (count($tax_query) > 1) {
    $tax_query['relation'] = 'AND';
}

// Query for resources
$args = [
    'post_type' => 'gdkc_resource',
    'posts_per_page' => 12,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
];

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

$query = new WP_Query($args);
?>

<div class="gdkc-resources-archive">
    <div class="gdkc-page-header">
        <div class="container">
            <h1 class="page-title"><?php echo esc_html($title); ?></h1>
            <div class="page-description"><?php echo wp_kses_post($description); ?></div>
        </div>
    </div>

    <div class="container">
        <div class="gdkc-filter-bar">
            <div class="filter-title">Filter Resources:</div>
            <form class="gdkc-filters" method="get">
                <div class="filter-group">
                    <label for="category-filter">Category:</label>
                    <select id="category-filter" name="category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo esc_attr($category->slug); ?>" <?php selected($current_category, $category->slug); ?>>
                                <?php echo esc_html($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="level-filter">Experience Level:</label>
                    <select id="level-filter" name="level">
                        <option value="">All Levels</option>
                        <?php foreach ($levels as $level) : ?>
                            <option value="<?php echo esc_attr($level->slug); ?>" <?php selected($current_level, $level->slug); ?>>
                                <?php echo esc_html($level->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="filter-submit">Apply Filters</button>
                <?php if (!empty($current_category) || !empty($current_level)) : ?>
                    <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_resource')); ?>" class="clear-filters">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if ($query->have_posts()) : ?>
            <div class="gdkc-resources-grid">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $resource_type = get_field('resource_type');
                    $resource_url = get_field('resource_url');
                    $file_download = get_field('file_download');
                    $estimated_time = get_field('estimated_time');
                    $difficulty_level = get_field('difficulty_level');
                    
                    // Determine if this is an external resource
                    $is_external = $resource_type === 'external' && $resource_url;
                    $is_download = $resource_type === 'download' && $file_download;
                    
                    // Determine the resource link
                    $resource_link = $is_external ? $resource_url : ($is_download ? $file_download['url'] : get_permalink());
                    $link_target = $is_external ? '_blank' : '_self';
                ?>
                    <div class="resource-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="resource-image">
                                <a href="<?php echo esc_url($resource_link); ?>" target="<?php echo esc_attr($link_target); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                                <?php if ($resource_type) : ?>
                                    <div class="resource-type <?php echo esc_attr($resource_type); ?>">
                                        <?php 
                                        switch ($resource_type) {
                                            case 'article':
                                                echo 'Article';
                                                break;
                                            case 'video':
                                                echo 'Video';
                                                break;
                                            case 'guide':
                                                echo 'Guide';
                                                break;
                                            case 'download':
                                                echo 'Download';
                                                break;
                                            case 'external':
                                                echo 'External Resource';
                                                break;
                                            default:
                                                echo esc_html($resource_type);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="resource-content">
                            <h2 class="resource-title">
                                <a href="<?php echo esc_url($resource_link); ?>" target="<?php echo esc_attr($link_target); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div class="resource-meta">
                                <?php 
                                // Show categories
                                $cat_terms = get_the_terms(get_the_ID(), 'gdkc_resource_category');
                                if ($cat_terms && !is_wp_error($cat_terms)) : 
                                    $first_term = array_shift($cat_terms);
                                ?>
                                    <span class="resource-category"><?php echo esc_html($first_term->name); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($estimated_time) : ?>
                                    <span class="resource-time"><?php echo esc_html($estimated_time); ?></span>
                                <?php endif; ?>
                                
                                <?php 
                                // Show difficulty level
                                $level_terms = get_the_terms(get_the_ID(), 'gdkc_resource_level');
                                if ($level_terms && !is_wp_error($level_terms)) : 
                                ?>
                                    <span class="resource-level"><?php echo esc_html($level_terms[0]->name); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="resource-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="resource-footer">
                                <a href="<?php echo esc_url($resource_link); ?>" class="resource-link" target="<?php echo esc_attr($link_target); ?>">
                                    <?php 
                                    if ($is_external) {
                                        echo 'Visit Resource <i class="fa fa-external-link"></i>';
                                    } elseif ($is_download) {
                                        echo 'Download <i class="fa fa-download"></i>';
                                    } else {
                                        echo 'Read More';
                                    }
                                    ?>
                                </a>
                                
                                <div class="resource-date">
                                    <?php echo get_the_date(); ?>
                                </div>
                            </div>
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
                <p>No resources found matching your criteria. Try adjusting your filters.</p>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        
        <div class="resource-callout">
            <div class="callout-content">
                <h3>Need Personalized Training Help?</h3>
                <p>Every dog is unique. Complete our behavior assessment to receive tailored training recommendations based on your dog's specific needs.</p>
                <a href="<?php echo esc_url(home_url('/dog-behavior-assessment/')); ?>" class="callout-button">Take the Assessment</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>