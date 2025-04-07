<?php
/**
 * Template Name: Resource Page
 * Description: A template for displaying training resources and tips
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main" class="resource-page">
    <div class="resource-header">
        <div class="container">
            <h1 class="resource-title"><?php the_title(); ?></h1>
            
            <?php if (has_excerpt()) : ?>
                <div class="resource-description">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
            
            <?php
            // Display resource categories for filtering
            $resource_categories = get_terms(array(
                'taxonomy' => 'gdkc_resource_category',
                'hide_empty' => true,
            ));
            
            if (!empty($resource_categories) && !is_wp_error($resource_categories)) :
            ?>
                <div class="resource-filters">
                    <div class="filter-label">Filter by:</div>
                    <div class="filter-buttons">
                        <button class="filter-button active" data-filter="all">All Resources</button>
                        <?php foreach ($resource_categories as $category) : ?>
                            <button class="filter-button" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="resource-search">
                <form role="search" method="get" class="resource-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" class="search-field" placeholder="Search resources..." value="<?php echo get_search_query(); ?>" name="s" />
                    <input type="hidden" name="post_type" value="gdkc_resource" />
                    <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="resource-content">
        <div class="container">
            <?php
            // Display the page content if available
            while (have_posts()) :
                the_post();
                
                if ('' !== get_the_content()) :
            ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            <?php
                endif;
            endwhile;
            ?>
            
            <div class="resource-grid">
                <?php
                // Query for resources
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $resources_per_page = 12; // Adjust as needed
                
                $resource_args = array(
                    'post_type' => 'gdkc_resource',
                    'posts_per_page' => $resources_per_page,
                    'paged' => $paged,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                
                // Check if we're filtering by category
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $resource_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'gdkc_resource_category',
                            'field' => 'slug',
                            'terms' => sanitize_text_field($_GET['category']),
                        ),
                    );
                }
                
                $resource_query = new WP_Query($resource_args);
                
                if ($resource_query->have_posts()) :
                    while ($resource_query->have_posts()) :
                        $resource_query->the_post();
                        
                        // Get resource categories for filtering
                        $resource_cats = get_the_terms(get_the_ID(), 'gdkc_resource_category');
                        $resource_cat_classes = '';
                        $resource_cat_names = array();
                        
                        if (!empty($resource_cats) && !is_wp_error($resource_cats)) {
                            foreach ($resource_cats as $cat) {
                                $resource_cat_classes .= ' resource-category-' . $cat->slug;
                                $resource_cat_names[] = $cat->name;
                            }
                        }
                        
                        // Get resource type (article, video, pdf, etc.)
                        $resource_type = get_post_meta(get_the_ID(), '_gdkc_resource_type', true);
                        $resource_type_class = !empty($resource_type) ? 'resource-type-' . sanitize_html_class($resource_type) : '';
                        
                        // Get resource difficulty level
                        $resource_difficulty = get_post_meta(get_the_ID(), '_gdkc_resource_difficulty', true);
                        $difficulty_class = !empty($resource_difficulty) ? 'resource-difficulty-' . sanitize_html_class($resource_difficulty) : '';
                ?>
                    <div class="resource-item <?php echo esc_attr($resource_cat_classes . ' ' . $resource_type_class . ' ' . $difficulty_class); ?>">
                        <div class="resource-card">
                            <div class="resource-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="resource-no-image">
                                        <i class="fas fa-<?php echo esc_attr($resource_type === 'video' ? 'play-circle' : ($resource_type === 'pdf' ? 'file-pdf' : 'file-alt')); ?>"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (!empty($resource_type)) : ?>
                                    <div class="resource-type">
                                        <span><?php echo esc_html(ucfirst($resource_type)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="resource-details">
                                <h3 class="resource-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php if (!empty($resource_cat_names)) : ?>
                                    <div class="resource-categories">
                                        <?php echo esc_html(implode(', ', $resource_cat_names)); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="resource-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <div class="resource-meta">
                                    <?php if (!empty($resource_difficulty)) : ?>
                                        <div class="resource-difficulty">
                                            <span class="difficulty-label">Difficulty:</span>
                                            <span class="difficulty-value"><?php echo esc_html(ucfirst($resource_difficulty)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="resource-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo get_the_date(); ?></span>
                                    </div>
                                </div>
                                
                                <div class="resource-action">
                                    <a href="<?php the_permalink(); ?>" class="gdkc-button outline">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endwhile;
                    
                    // Pagination
                    $total_pages = $resource_query->max_num_pages;
                    
                    if ($total_pages > 1) :
                ?>
                    <div class="resource-pagination">
                        <?php
                        $big = 999999999; // need an unlikely integer
                        
                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $total_pages,
                            'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
                            'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
                        ));
                        ?>
                    </div>
                <?php
                    endif;
                    
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-resources">
                        <p>No resources found. Please check back later or try a different search.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="resource-cta">
                <div class="cta-content">
                    <h2>Need Personalized Training Help?</h2>
                    <p>Our expert trainers can provide customized solutions for your dog's specific needs.</p>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="gdkc-button primary">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    // Display featured resources if available
    $featured_resources = get_post_meta(get_the_ID(), '_gdkc_featured_resources', true);
    if (!empty($featured_resources) && is_array($featured_resources)) :
    ?>
        <div class="featured-resources">
            <div class="container">
                <h2>Featured Resources</h2>
                <div class="featured-resources-grid">
                    <?php
                    $featured_query = new WP_Query(array(
                        'post_type' => 'gdkc_resource',
                        'post__in' => $featured_resources,
                        'posts_per_page' => -1,
                        'orderby' => 'post__in',
                    ));
                    
                    if ($featured_query->have_posts()) :
                        while ($featured_query->have_posts()) :
                            $featured_query->the_post();
                            
                            // Get resource type
                            $resource_type = get_post_meta(get_the_ID(), '_gdkc_resource_type', true);
                    ?>
                        <div class="featured-resource-item">
                            <div class="featured-resource-card">
                                <div class="featured-resource-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium_large'); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>" class="resource-no-image">
                                            <i class="fas fa-<?php echo esc_attr($resource_type === 'video' ? 'play-circle' : ($resource_type === 'pdf' ? 'file-pdf' : 'file-alt')); ?>"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($resource_type)) : ?>
                                        <div class="resource-type">
                                            <span><?php echo esc_html(ucfirst($resource_type)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="featured-resource-details">
                                    <h3 class="featured-resource-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="featured-resource-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <div class="featured-resource-action">
                                        <a href="<?php the_permalink(); ?>" class="gdkc-button outline">View Resource</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Resource filtering
        const filterButtons = document.querySelectorAll('.filter-button');
        const resourceItems = document.querySelectorAll('.resource-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter resources
                resourceItems.forEach(item => {
                    if (filter === 'all') {
                        item.style.display = 'block';
                    } else {
                        if (item.classList.contains('resource-category-' + filter)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        });
    });
    </script>
</main>

<?php
get_footer();
?>
