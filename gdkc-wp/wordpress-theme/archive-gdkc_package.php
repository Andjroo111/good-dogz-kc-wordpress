<?php
/**
 * The template for displaying Service Packages archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header(); 

// Get current package type if filtering by taxonomy
$current_package_type = get_query_var('package_type');
?>

<main id="site-content">
    <div class="archive-header">
        <div class="container">
            <div class="archive-header-content">
                <h1 class="archive-title">
                    <?php 
                    if ($current_package_type) {
                        $term = get_term_by('slug', $current_package_type, 'package_type');
                        if ($term) {
                            echo esc_html($term->name);
                        } else {
                            _e('Service Packages', 'gooddogzkc-twentytwentyfour-child');
                        }
                    } else {
                        _e('Service Packages', 'gooddogzkc-twentytwentyfour-child');
                    }
                    ?>
                </h1>
                
                <div class="archive-description">
                    <?php
                    if ($current_package_type) {
                        $term = get_term_by('slug', $current_package_type, 'package_type');
                        if ($term && !empty($term->description)) {
                            echo '<p>' . wp_kses_post($term->description) . '</p>';
                        } else {
                            _e('<p>Choose from our selection of service packages designed to fit your needs and budget.</p>', 'gooddogzkc-twentytwentyfour-child');
                        }
                    } else {
                        _e('<p>Choose from our selection of service packages designed to fit your needs and budget.</p>', 'gooddogzkc-twentytwentyfour-child');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="archive-filters">
        <div class="container">
            <div class="package-type-filter">
                <ul class="package-type-tabs">
                    <li<?php echo empty($current_package_type) ? ' class="active"' : ''; ?>>
                        <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_package')); ?>">All Packages</a>
                    </li>
                    
                    <?php
                    // Get package type terms
                    $package_types = get_terms(array(
                        'taxonomy' => 'package_type',
                        'hide_empty' => true,
                    ));
                    
                    if (!empty($package_types) && !is_wp_error($package_types)) {
                        foreach ($package_types as $package_type) {
                            $active_class = ($current_package_type === $package_type->slug) ? ' class="active"' : '';
                            echo '<li' . $active_class . '><a href="' . esc_url(get_term_link($package_type)) . '">' . esc_html($package_type->name) . '</a></li>';
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
            
                <div class="packages-grid">
                    <?php
                    // Start the Loop
                    while (have_posts()) :
                        the_post();
                        
                        // Get fields from ACF
                        $regular_price = get_field('package_regular_price');
                        $sale_price = get_field('package_sale_price');
                        $sessions = get_field('package_sessions');
                        $duration = get_field('package_duration');
                        $features = get_field('package_features');
                        $popular = get_field('package_popular');
                        $button_text = get_field('package_button_text') ?: 'Book Now';
                        $button_url = get_field('package_button_url') ?: get_permalink();
                        
                        // Get the package type
                        $package_types = get_the_terms(get_the_ID(), 'package_type');
                        $package_type_name = '';
                        
                        if (!empty($package_types) && !is_wp_error($package_types)) {
                            $package_type_name = $package_types[0]->name;
                        }
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('package-card' . ($popular ? ' popular-package' : '')); ?>>
                        <?php if ($popular) : ?>
                            <div class="popular-badge">Most Popular</div>
                        <?php endif; ?>
                        
                        <div class="package-header">
                            <?php if ($package_type_name) : ?>
                                <div class="package-type">
                                    <?php echo esc_html($package_type_name); ?>
                                </div>
                            <?php endif; ?>
                            
                            <h2 class="package-title"><?php the_title(); ?></h2>
                            
                            <div class="package-pricing">
                                <?php if ($sale_price) : ?>
                                    <div class="package-regular-price">$<?php echo number_format($regular_price); ?></div>
                                    <div class="package-sale-price">$<?php echo number_format($sale_price); ?></div>
                                <?php elseif ($regular_price) : ?>
                                    <div class="package-price">$<?php echo number_format($regular_price); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="package-content">
                            <?php if ($sessions || $duration) : ?>
                                <div class="package-meta">
                                    <?php if ($sessions) : ?>
                                        <div class="sessions">
                                            <span class="value"><?php echo esc_html($sessions); ?></span>
                                            <span class="label">Sessions</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($duration) : ?>
                                        <div class="duration">
                                            <span class="value"><?php echo esc_html($duration); ?></span>
                                            <span class="label">Weeks</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($features && count($features) > 0) : ?>
                                <ul class="package-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <li class="<?php echo $feature['feature_included'] ? 'included' : 'not-included'; ?>">
                                            <?php echo esc_html($feature['feature_text']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            
                            <div class="package-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php echo esc_url($button_url); ?>" class="package-button">
                                <?php echo esc_html($button_text); ?>
                            </a>
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
                <div class="no-packages-found">
                    <h2><?php _e('No Packages Found', 'gooddogzkc-twentytwentyfour-child'); ?></h2>
                    <p><?php _e('We couldn\'t find any service packages matching your criteria.', 'gooddogzkc-twentytwentyfour-child'); ?></p>
                    
                    <?php if ($current_package_type) : ?>
                        <p><a href="<?php echo esc_url(get_post_type_archive_link('gdkc_package')); ?>" class="button"><?php _e('View All Packages', 'gooddogzkc-twentytwentyfour-child'); ?></a></p>
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
    
    .package-type-tabs {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-bottom: 1px solid #ddd;
        flex-wrap: wrap;
    }
    
    .package-type-tabs li {
        margin: 0;
        padding: 0;
    }
    
    .package-type-tabs li a {
        display: block;
        padding: 12px 20px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .package-type-tabs li.active a,
    .package-type-tabs li a:hover {
        color: #2c2977;
        border-color: #2c2977;
    }
    
    .packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .package-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        background-color: white;
    }
    
    .package-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .popular-package {
        border: 2px solid #a08cff;
    }
    
    .popular-badge {
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
    
    .package-header {
        padding: 30px 25px 20px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }
    
    .package-type {
        display: inline-block;
        background-color: #f0f0ff;
        color: #2c2977;
        padding: 3px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        margin-bottom: 10px;
    }
    
    .package-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #2c2977;
    }
    
    .package-pricing {
        margin-bottom: 10px;
    }
    
    .package-price {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
    }
    
    .package-regular-price {
        font-size: 1.3rem;
        color: #999;
        text-decoration: line-through;
    }
    
    .package-sale-price {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
    }
    
    .package-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .package-meta {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .package-meta .value {
        display: block;
        font-size: 1.6rem;
        font-weight: 700;
        color: #2c2977;
    }
    
    .package-meta .label {
        display: block;
        font-size: 0.9rem;
        color: #666;
    }
    
    .package-features {
        list-style: none;
        padding: 0;
        margin: 0 0 25px;
    }
    
    .package-features li {
        padding: 8px 0 8px 28px;
        position: relative;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .package-features li.included:before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #07edbe;
        font-weight: bold;
    }
    
    .package-features li.not-included {
        color: #999;
        text-decoration: line-through;
    }
    
    .package-features li.not-included:before {
        content: '×';
        position: absolute;
        left: 0;
        color: #ff6b6b;
    }
    
    .package-excerpt {
        margin-bottom: 25px;
        color: #666;
        line-height: 1.5;
    }
    
    .package-button {
        display: inline-block;
        background-color: #07edbe;
        color: #2c2977;
        padding: 12px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: background-color 0.3s ease;
        margin-top: auto;
    }
    
    .package-button:hover {
        background-color: #06d6ac;
    }
    
    .no-packages-found {
        text-align: center;
        padding: 60px 0;
    }
    
    .no-packages-found h2 {
        margin-bottom: 15px;
        color: #2c2977;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .packages-grid {
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