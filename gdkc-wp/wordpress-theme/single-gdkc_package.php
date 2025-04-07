<?php
/**
 * The template for displaying single Service Package
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();

// Custom field data
$regular_price = get_field('package_regular_price');
$sale_price = get_field('package_sale_price');
$sessions = get_field('package_sessions');
$duration = get_field('package_duration');
$features = get_field('package_features');
$popular = get_field('package_popular');
$additional_info = get_field('package_additional_info');
$button_text = get_field('package_button_text') ?: 'Book Now';
$button_url = get_field('package_button_url') ?: '#contact-form';

// Package type
$package_types = get_the_terms(get_the_ID(), 'package_type');
$package_type_name = '';
if (!empty($package_types) && !is_wp_error($package_types)) {
    $package_type_name = $package_types[0]->name;
}

// Included services
$included_services = get_the_terms(get_the_ID(), 'included_service');
$services_list = array();
if (!empty($included_services) && !is_wp_error($included_services)) {
    foreach ($included_services as $service) {
        $services_list[] = $service->name;
    }
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-service-package'); ?>>

    <header class="package-header">
        <div class="container">
            <div class="package-header-content">
                <?php if ($package_type_name) : ?>
                    <div class="package-type">
                        <?php echo esc_html($package_type_name); ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="package-title"><?php the_title(); ?></h1>
                
                <div class="package-pricing">
                    <?php if ($sale_price) : ?>
                        <div class="package-regular-price">$<?php echo number_format($regular_price); ?></div>
                        <div class="package-sale-price">$<?php echo number_format($sale_price); ?></div>
                    <?php elseif ($regular_price) : ?>
                        <div class="package-price">$<?php echo number_format($regular_price); ?></div>
                    <?php endif; ?>
                </div>
                
                <?php if ($popular) : ?>
                    <div class="popular-badge">Most Popular Package</div>
                <?php endif; ?>
                
                <?php if ($sessions && $duration) : ?>
                    <div class="package-meta">
                        <div class="sessions">
                            <span class="value"><?php echo esc_html($sessions); ?></span>
                            <span class="label">Sessions</span>
                        </div>
                        
                        <div class="duration">
                            <span class="value"><?php echo esc_html($duration); ?></span>
                            <span class="label">Weeks</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <div class="package-content">
        <div class="container">
            <div class="package-main-content">
                <div class="package-description">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="package-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="package-description-content">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if ($additional_info) : ?>
                        <div class="package-additional-info">
                            <h3>Additional Information</h3>
                            <?php echo wp_kses_post($additional_info); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="package-sidebar">
                    <div class="package-card">
                        <h2>Package Summary</h2>
                        
                        <?php if ($features && count($features) > 0) : ?>
                            <div class="package-features-section">
                                <h3>What's Included</h3>
                                <ul class="package-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <li class="<?php echo $feature['feature_included'] ? 'included' : 'not-included'; ?>">
                                            <?php echo esc_html($feature['feature_text']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($services_list)) : ?>
                            <div class="package-services-section">
                                <h3>Services</h3>
                                <div class="service-tags">
                                    <?php foreach ($services_list as $service) : ?>
                                        <span class="service-tag"><?php echo esc_html($service); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="package-cta">
                            <a href="<?php echo esc_url($button_url); ?>" class="cta-button">
                                <?php echo esc_html($button_text); ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="package-contact-card">
                        <h3>Have Questions?</h3>
                        <p>Contact us to learn more about this package and how it can help you and your dog.</p>
                        <a href="tel:8165551234" class="phone-button">
                            <span class="phone-icon">📞</span> (816) 555-1234
                        </a>
                        <a href="/contact/" class="contact-link">Send us a message</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="related-packages">
        <div class="container">
            <h2>Other Service Packages</h2>
            
            <?php
            // Get related packages by same package type
            $related_args = array(
                'post_type' => 'gdkc_package',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand',
            );
            
            if (!empty($package_types)) {
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'package_type',
                        'field' => 'term_id',
                        'terms' => $package_types[0]->term_id,
                    ),
                );
            }
            
            $related_query = new WP_Query($related_args);
            
            if ($related_query->have_posts()) :
            ?>
                <div class="related-packages-grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                        $rel_regular_price = get_field('package_regular_price');
                        $rel_sale_price = get_field('package_sale_price');
                        $rel_sessions = get_field('package_sessions');
                    ?>
                        <article class="related-package">
                            <h3 class="related-package-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="related-package-price">
                                <?php if ($rel_sale_price) : ?>
                                    <span class="old-price">$<?php echo number_format($rel_regular_price); ?></span>
                                    <span class="new-price">$<?php echo number_format($rel_sale_price); ?></span>
                                <?php elseif ($rel_regular_price) : ?>
                                    <span class="price">$<?php echo number_format($rel_regular_price); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($rel_sessions) : ?>
                                <div class="related-package-sessions">
                                    <?php echo esc_html($rel_sessions); ?> sessions
                                </div>
                            <?php endif; ?>
                            
                            <div class="related-package-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="related-package-link">View Package</a>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</article>

<style>
    /* Single Service Package Styles */
    .single-service-package {
        margin-bottom: 60px;
    }
    
    /* Header */
    .package-header {
        background-color: #f8f8ff;
        padding: 60px 0 40px;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .package-header-content {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .package-type {
        display: inline-block;
        background-color: #e0e0ff;
        color: #2c2977;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .package-title {
        font-size: 2.8rem;
        color: #2c2977;
        margin-bottom: 20px;
    }
    
    .package-pricing {
        margin-bottom: 15px;
    }
    
    .package-price {
        font-size: 3rem;
        font-weight: 700;
        color: #333;
    }
    
    .package-regular-price {
        font-size: 1.8rem;
        color: #999;
        text-decoration: line-through;
        display: inline-block;
        margin-right: 10px;
    }
    
    .package-sale-price {
        font-size: 3rem;
        font-weight: 700;
        color: #333;
        display: inline-block;
    }
    
    .popular-badge {
        display: inline-block;
        background-color: #a08cff;
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .package-meta {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 20px;
    }
    
    .package-meta .value {
        display: block;
        font-size: 2rem;
        font-weight: 700;
        color: #2c2977;
    }
    
    .package-meta .label {
        display: block;
        font-size: 1rem;
        color: #666;
    }
    
    /* Main Content */
    .package-main-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }
    
    .package-featured-image {
        margin-bottom: 30px;
    }
    
    .package-featured-image img {
        border-radius: 8px;
        width: 100%;
        height: auto;
    }
    
    .package-description-content {
        margin-bottom: 30px;
        color: #444;
        line-height: 1.7;
    }
    
    .package-additional-info {
        background-color: #f9f9ff;
        padding: 25px;
        border-radius: 8px;
        margin-top: 30px;
    }
    
    .package-additional-info h3 {
        font-size: 1.4rem;
        color: #2c2977;
        margin-bottom: 15px;
    }
    
    /* Sidebar */
    .package-sidebar {
        position: sticky;
        top: 30px;
    }
    
    .package-card, 
    .package-contact-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 25px;
    }
    
    .package-card h2 {
        font-size: 1.6rem;
        color: #2c2977;
        margin-bottom: 25px;
        text-align: center;
    }
    
    .package-features-section, 
    .package-services-section {
        margin-bottom: 25px;
    }
    
    .package-features-section h3, 
    .package-services-section h3 {
        font-size: 1.2rem;
        color: #2c2977;
        margin-bottom: 15px;
    }
    
    .package-features {
        list-style: none;
        padding: 0;
        margin: 0;
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
    
    .service-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .service-tag {
        background-color: #f0f0ff;
        color: #2c2977;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
    }
    
    .package-cta {
        text-align: center;
        margin-top: 25px;
    }
    
    .cta-button {
        display: block;
        background-color: #07edbe;
        color: #2c2977;
        text-align: center;
        padding: 14px 20px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .cta-button:hover {
        background-color: #06d6ac;
    }
    
    .package-contact-card {
        text-align: center;
    }
    
    .package-contact-card h3 {
        font-size: 1.3rem;
        color: #2c2977;
        margin-bottom: 10px;
    }
    
    .package-contact-card p {
        color: #666;
        margin-bottom: 20px;
    }
    
    .phone-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0ff;
        color: #2c2977;
        padding: 12px 15px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }
    
    .phone-button:hover {
        background-color: #e0e0ff;
    }
    
    .phone-icon {
        margin-right: 8px;
    }
    
    .contact-link {
        color: #2c2977;
        text-decoration: underline;
        font-weight: 500;
    }
    
    /* Related Packages */
    .related-packages {
        background-color: #f8f8ff;
        padding: 60px 0;
        margin-top: 60px;
    }
    
    .related-packages h2 {
        font-size: 1.8rem;
        color: #2c2977;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .related-packages-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }
    
    .related-package {
        background-color: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .related-package:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .related-package-title {
        font-size: 1.3rem;
        margin-bottom: 10px;
    }
    
    .related-package-title a {
        color: #2c2977;
        text-decoration: none;
    }
    
    .related-package-price {
        margin-bottom: 8px;
    }
    
    .related-package-price .price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }
    
    .related-package-price .old-price {
        font-size: 1rem;
        color: #999;
        text-decoration: line-through;
        margin-right: 8px;
    }
    
    .related-package-price .new-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
    }
    
    .related-package-sessions {
        color: #666;
        margin-bottom: 12px;
        font-size: 0.9rem;
    }
    
    .related-package-excerpt {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
        font-size: 0.95rem;
    }
    
    .related-package-link {
        display: inline-block;
        color: #2c2977;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 2px solid #07edbe;
        transition: border-color 0.3s ease;
    }
    
    .related-package-link:hover {
        border-color: #2c2977;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .package-main-content {
            grid-template-columns: 1fr;
        }
        
        .package-sidebar {
            position: static;
        }
        
        .related-packages-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .package-header {
            padding: 40px 0 30px;
        }
        
        .package-title {
            font-size: 2.2rem;
        }
        
        .package-price,
        .package-sale-price {
            font-size: 2.5rem;
        }
        
        .related-packages-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php get_footer(); ?>