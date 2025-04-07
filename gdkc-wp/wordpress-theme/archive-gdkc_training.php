<?php
/**
 * The template for displaying Training Programs archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header(); 

// Get current program type if filtering by taxonomy
$current_program_type = get_query_var('program_type');
?>

<main id="site-content">
    <div class="archive-header">
        <div class="container">
            <div class="archive-header-content">
                <h1 class="archive-title">
                    <?php 
                    if ($current_program_type) {
                        $term = get_term_by('slug', $current_program_type, 'program_type');
                        if ($term) {
                            echo esc_html($term->name) . ' Programs';
                        } else {
                            _e('Training Programs', 'gooddogzkc-twentytwentyfour-child');
                        }
                    } else {
                        _e('Training Programs', 'gooddogzkc-twentytwentyfour-child');
                    }
                    ?>
                </h1>
                
                <div class="archive-description">
                    <?php
                    if ($current_program_type) {
                        $term = get_term_by('slug', $current_program_type, 'program_type');
                        if ($term && !empty($term->description)) {
                            echo '<p>' . wp_kses_post($term->description) . '</p>';
                        } else {
                            _e('<p>View our professional dog training programs designed to address various needs and goals.</p>', 'gooddogzkc-twentytwentyfour-child');
                        }
                    } else {
                        _e('<p>View our professional dog training programs designed to address various needs and goals.</p>', 'gooddogzkc-twentytwentyfour-child');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="archive-filters">
        <div class="container">
            <div class="program-type-filter">
                <ul class="program-type-tabs">
                    <li<?php echo empty($current_program_type) ? ' class="active"' : ''; ?>>
                        <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_training')); ?>">All Programs</a>
                    </li>
                    
                    <?php
                    // Get program type terms
                    $program_types = get_terms(array(
                        'taxonomy' => 'program_type',
                        'hide_empty' => true,
                    ));
                    
                    if (!empty($program_types) && !is_wp_error($program_types)) {
                        foreach ($program_types as $program_type) {
                            $active_class = ($current_program_type === $program_type->slug) ? ' class="active"' : '';
                            echo '<li' . $active_class . '><a href="' . esc_url(get_term_link($program_type)) . '">' . esc_html($program_type->name) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="archive-content">
        <div class="container">
            <?php if (have_posts()) : ?>
            
                <div class="programs-grid">
                    <?php
                    // Start the Loop
                    while (have_posts()) :
                        the_post();
                        
                        // Get featured status
                        $featured = get_field('program_featured');
                        $program_overview = get_field('program_overview');
                        $pricing = get_field('program_pricing');
                        
                        // Get the program type
                        $program_types = get_the_terms(get_the_ID(), 'program_type');
                        $program_type_name = '';
                        $program_type_slug = '';
                        
                        if (!empty($program_types) && !is_wp_error($program_types)) {
                            $program_type_name = $program_types[0]->name;
                            $program_type_slug = $program_types[0]->slug;
                        }
                        
                        // Price to display
                        $price_display = '';
                        if (!empty($pricing) && !empty($pricing['pricing_4_session'])) {
                            $price_display = 'From $' . number_format($pricing['pricing_4_session']);
                        }
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('program-card' . ($featured ? ' featured-program' : '')); ?>>
                        <?php if ($featured) : ?>
                            <div class="featured-badge">Featured</div>
                        <?php endif; ?>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="program-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="program-content">
                            <?php if ($program_type_name) : ?>
                                <div class="program-type">
                                    <a href="<?php echo esc_url(get_term_link($program_types[0])); ?>"><?php echo esc_html($program_type_name); ?></a>
                                </div>
                            <?php endif; ?>
                            
                            <h2 class="program-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <?php if ($program_overview) : ?>
                                <div class="program-overview">
                                    <?php echo wp_trim_words($program_overview, 20, '...'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="program-meta">
                                <?php if ($price_display) : ?>
                                    <div class="program-price"><?php echo esc_html($price_display); ?></div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="program-button">Learn More</a>
                            </div>
                        </div>
                    </article>
                    
                    <?php endwhile; ?>
                </div>
                
                <?php
                // Pagination
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'gooddogzkc-twentytwentyfour-child'),
                    'next_text' => __('Next', 'gooddogzkc-twentytwentyfour-child'),
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'gooddogzkc-twentytwentyfour-child') . ' </span>',
                ));
                ?>
                
            <?php else : ?>
                <div class="no-programs-found">
                    <h2><?php _e('No Programs Found', 'gooddogzkc-twentytwentyfour-child'); ?></h2>
                    <p><?php _e('We couldn\'t find any training programs matching your criteria.', 'gooddogzkc-twentytwentyfour-child'); ?></p>
                    
                    <?php if ($current_program_type) : ?>
                        <p><a href="<?php echo esc_url(get_post_type_archive_link('gdkc_training')); ?>" class="button"><?php _e('View All Programs', 'gooddogzkc-twentytwentyfour-child'); ?></a></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
    /* Archive styles */
    .archive-header {
        background-color: #f8f8ff;
        padding: 60px 0 40px;
        margin-bottom: 30px;
        text-align: center;
    }
    
    .archive-title {
        font-size: 2.5rem;
        color: #2c2977;
        margin-bottom: 20px;
    }
    
    .archive-description {
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.15rem;
    }
    
    .archive-filters {
        margin-bottom: 40px;
    }
    
    .program-type-tabs {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-bottom: 1px solid #ddd;
        flex-wrap: wrap;
    }
    
    .program-type-tabs li {
        margin: 0;
        padding: 0;
    }
    
    .program-type-tabs li a {
        display: block;
        padding: 12px 20px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .program-type-tabs li.active a,
    .program-type-tabs li a:hover {
        color: #2c2977;
        border-color: #2c2977;
    }
    
    .programs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .program-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    .featured-program {
        border: 2px solid #a08cff;
    }
    
    .featured-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #a08cff;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        z-index: 1;
    }
    
    .program-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .program-card:hover .program-image img {
        transform: scale(1.05);
    }
    
    .program-content {
        padding: 20px;
        background-color: white;
    }
    
    .program-type {
        margin-bottom: 10px;
    }
    
    .program-type a {
        display: inline-block;
        background-color: #f0f0ff;
        color: #2c2977;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .program-type a:hover {
        background-color: #e0e0ff;
    }
    
    .program-title {
        font-size: 1.4rem;
        margin-bottom: 10px;
        color: #2c2977;
    }
    
    .program-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .program-overview {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    
    .program-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    .program-price {
        font-weight: 600;
        color: #333;
    }
    
    .program-button {
        display: inline-block;
        background-color: #07edbe;
        color: #2c2977;
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .program-button:hover {
        background-color: #06d6ac;
    }
    
    .no-programs-found {
        text-align: center;
        padding: 60px 0;
    }
    
    .no-programs-found h2 {
        margin-bottom: 15px;
        color: #2c2977;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .programs-grid {
            grid-template-columns: 1fr;
        }
        
        .archive-header {
            padding: 40px 0 30px;
        }
        
        .archive-title {
            font-size: 2rem;
        }
    }
</style>

<?php get_footer(); ?>