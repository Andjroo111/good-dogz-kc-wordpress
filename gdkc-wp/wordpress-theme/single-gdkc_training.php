<?php
/**
 * The template for displaying single Training Program post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();

// Custom field data
$program_overview = get_field('program_overview');
$program_benefits = get_field('program_benefits');
$program_who_for = get_field('program_who_for');
$program_steps = get_field('program_steps');
$program_pricing = get_field('program_pricing');
$program_details = get_field('program_details');

// Program type
$program_types = get_the_terms(get_the_ID(), 'program_type');
$program_type_name = '';
if (!empty($program_types) && !is_wp_error($program_types)) {
    $program_type_name = $program_types[0]->name;
}

// Calculate number of positive ratings for display
$rating_count = wp_rand(5, 30); // For demo, replace with actual review count in production
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-training-program'); ?>>

    <header class="program-header">
        <div class="container">
            <div class="program-header-content">
                <?php if ($program_type_name) : ?>
                    <div class="program-type">
                        <?php echo esc_html($program_type_name); ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="program-title"><?php the_title(); ?></h1>
                
                <?php if ($program_overview) : ?>
                    <div class="program-overview">
                        <?php echo esc_html($program_overview); ?>
                    </div>
                <?php endif; ?>
                
                <div class="program-rating">
                    <div class="rating-stars">
                        <span class="rating-value">5.0</span>
                        <span class="star-icon filled">★</span>
                        <span class="star-icon filled">★</span>
                        <span class="star-icon filled">★</span>
                        <span class="star-icon filled">★</span>
                        <span class="star-icon filled">★</span>
                    </div>
                    <div class="rating-count"><?php echo esc_html($rating_count); ?> positive reviews</div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="program-content">
        <div class="container">
            <div class="program-main-content">
                <div class="program-details">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="program-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="program-description">
                        <?php the_content(); ?>
                    </div>
                    
                    <?php if ($program_benefits) : ?>
                        <div class="program-benefits-section">
                            <h2>Program Benefits</h2>
                            <div class="benefits-grid">
                                <?php foreach ($program_benefits as $benefit) : ?>
                                    <div class="benefit-item">
                                        <h3><?php echo esc_html($benefit['benefit_title']); ?></h3>
                                        <?php if (!empty($benefit['benefit_description'])) : ?>
                                            <p><?php echo esc_html($benefit['benefit_description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($program_steps) : ?>
                        <div class="program-steps-section">
                            <h2>How It Works</h2>
                            <div class="steps-timeline">
                                <?php foreach ($program_steps as $step) : ?>
                                    <div class="step-item">
                                        <div class="step-number"><?php echo esc_html($step['step_number']); ?></div>
                                        <div class="step-content">
                                            <h3><?php echo esc_html($step['step_title']); ?></h3>
                                            <?php if (!empty($step['step_description'])) : ?>
                                                <p><?php echo esc_html($step['step_description']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($program_who_for) : ?>
                        <div class="program-who-for-section">
                            <h2>Who Is This For?</h2>
                            <div class="who-for-content">
                                <?php echo wp_kses_post($program_who_for); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="program-sidebar">
                    <div class="program-pricing-card">
                        <h2>Program Pricing</h2>
                        
                        <?php if (!empty($program_pricing)) : ?>
                            <div class="pricing-options">
                                <?php if (!empty($program_pricing['pricing_4_session'])) : ?>
                                    <div class="pricing-option">
                                        <div class="option-name">4-Session Package</div>
                                        <div class="option-price">$<?php echo number_format($program_pricing['pricing_4_session']); ?></div>
                                        <div class="option-description">One month program with weekly sessions</div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($program_pricing['pricing_6_session'])) : ?>
                                    <div class="pricing-option recommended">
                                        <div class="recommended-badge">Most Popular</div>
                                        <div class="option-name">6-Session Package</div>
                                        <div class="option-price">$<?php echo number_format($program_pricing['pricing_6_session']); ?></div>
                                        <div class="option-description">Two month program with sessions in month 1, bi-weekly in month 2</div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($program_pricing['pricing_8_session'])) : ?>
                                    <div class="pricing-option">
                                        <div class="option-name">8-Session Package</div>
                                        <div class="option-price">$<?php echo number_format($program_pricing['pricing_8_session']); ?></div>
                                        <div class="option-description">Three month program with weekly sessions in month 1, bi-weekly after</div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($program_pricing['pricing_custom'])) : ?>
                                    <div class="pricing-custom-note">
                                        <?php echo esc_html($program_pricing['pricing_custom']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <p class="pricing-contact">Contact us for pricing information</p>
                        <?php endif; ?>
                        
                        <div class="pricing-cta">
                            <a href="/contact/" class="cta-button">Book Your Session</a>
                            <a href="tel:8165551234" class="phone-button">Call (816) 555-1234</a>
                        </div>
                    </div>
                    
                    <?php if (!empty($program_details)) : ?>
                        <div class="program-details-card">
                            <h3>Program Details</h3>
                            <ul class="details-list">
                                <?php if (!empty($program_details['program_duration'])) : ?>
                                    <li>
                                        <span class="detail-label">Duration:</span>
                                        <span class="detail-value"><?php echo esc_html($program_details['program_duration']); ?></span>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if (!empty($program_details['program_frequency'])) : ?>
                                    <li>
                                        <span class="detail-label">Session Frequency:</span>
                                        <span class="detail-value"><?php echo esc_html($program_details['program_frequency']); ?></span>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if (!empty($program_details['program_location'])) : ?>
                                    <li>
                                        <span class="detail-label">Location:</span>
                                        <span class="detail-value"><?php echo esc_html($program_details['program_location']); ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="program-related">
        <div class="container">
            <h2>Related Training Programs</h2>
            
            <?php
            // Get related programs by same program type
            $related_args = array(
                'post_type' => 'gdkc_training',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand',
            );
            
            if (!empty($program_types)) {
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'program_type',
                        'field' => 'term_id',
                        'terms' => $program_types[0]->term_id,
                    ),
                );
            }
            
            $related_query = new WP_Query($related_args);
            
            if ($related_query->have_posts()) :
            ?>
                <div class="related-programs-grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); 
                        $rel_program_overview = get_field('program_overview');
                    ?>
                        <article class="related-program-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="related-program-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="related-program-content">
                                <h3 class="related-program-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php if ($rel_program_overview) : ?>
                                    <div class="related-program-overview">
                                        <?php echo wp_trim_words($rel_program_overview, 12, '...'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="related-program-button">Learn More</a>
                            </div>
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
    /* Single Training Program Styles */
    .single-training-program {
        margin-bottom: 60px;
    }
    
    /* Header */
    .program-header {
        background-color: #f8f8ff;
        padding: 60px 0 40px;
        margin-bottom: 40px;
    }
    
    .program-header-content {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }
    
    .program-type {
        display: inline-block;
        background-color: #e0e0ff;
        color: #2c2977;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .program-title {
        font-size: 2.8rem;
        color: #2c2977;
        margin-bottom: 20px;
    }
    
    .program-overview {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 25px;
        line-height: 1.5;
    }
    
    .program-rating {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }
    
    .rating-stars {
        display: flex;
        align-items: center;
    }
    
    .rating-value {
        font-weight: bold;
        margin-right: 8px;
    }
    
    .star-icon {
        color: #ccc;
        font-size: 20px;
    }
    
    .star-icon.filled {
        color: #ffb900;
    }
    
    .rating-count {
        color: #666;
        font-size: 0.9rem;
    }
    
    /* Main Content */
    .program-main-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }
    
    .program-featured-image {
        margin-bottom: 30px;
    }
    
    .program-featured-image img {
        border-radius: 8px;
        width: 100%;
        height: auto;
    }
    
    .program-description {
        margin-bottom: 40px;
        line-height: 1.6;
    }
    
    .program-benefits-section,
    .program-steps-section,
    .program-who-for-section {
        margin-bottom: 40px;
    }
    
    .program-benefits-section h2,
    .program-steps-section h2,
    .program-who-for-section h2 {
        font-size: 1.8rem;
        color: #2c2977;
        margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }
    
    /* Benefits Grid */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .benefit-item {
        background-color: #f9f9ff;
        padding: 20px;
        border-radius: 8px;
        border-top: 3px solid #a08cff;
    }
    
    .benefit-item h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #2c2977;
    }
    
    .benefit-item p {
        color: #666;
        line-height: 1.5;
    }
    
    /* Steps Timeline */
    .steps-timeline {
        position: relative;
    }
    
    .steps-timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 20px;
        width: 2px;
        background-color: #e0e0ff;
    }
    
    .step-item {
        position: relative;
        padding-left: 60px;
        margin-bottom: 30px;
        padding-bottom: 20px;
    }
    
    .step-number {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        background-color: #2c2977;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 1;
    }
    
    .step-content h3 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #2c2977;
    }
    
    .step-content p {
        color: #666;
        line-height: 1.5;
    }
    
    /* Who For Section */
    .who-for-content {
        background-color: #f9f9ff;
        padding: 25px;
        border-radius: 8px;
        border-left: 4px solid #07edbe;
    }
    
    .who-for-content ul {
        margin-left: 20px;
    }
    
    /* Sidebar */
    .program-sidebar {
        position: sticky;
        top: 30px;
    }
    
    .program-pricing-card,
    .program-details-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 25px;
    }
    
    .program-pricing-card h2 {
        font-size: 1.5rem;
        color: #2c2977;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .pricing-options {
        margin-bottom: 25px;
    }
    
    .pricing-option {
        position: relative;
        border: 1px solid #e0e0ff;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .pricing-option:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .pricing-option.recommended {
        border: 2px solid #a08cff;
    }
    
    .recommended-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background-color: #a08cff;
        color: white;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 15px;
    }
    
    .option-name {
        font-weight: 600;
        color: #2c2977;
        margin-bottom: 8px;
    }
    
    .option-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }
    
    .option-description {
        font-size: 0.9rem;
        color: #666;
    }
    
    .pricing-custom-note {
        font-size: 0.9rem;
        padding: 10px;
        background-color: #f9f9ff;
        border-radius: 6px;
        text-align: center;
        font-style: italic;
    }
    
    .pricing-contact {
        text-align: center;
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 20px;
    }
    
    .pricing-cta {
        display: flex;
        flex-direction: column;
        gap: 12px;
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
    
    .phone-button {
        display: block;
        border: 1px solid #ddd;
        color: #666;
        text-align: center;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .phone-button:hover {
        background-color: #f5f5f5;
    }
    
    /* Program Details Card */
    .program-details-card h3 {
        font-size: 1.3rem;
        color: #2c2977;
        margin-bottom: 15px;
    }
    
    .details-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .details-list li {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .details-list li:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-weight: 600;
        color: #555;
    }
    
    .detail-value {
        color: #333;
    }
    
    /* Related Programs */
    .program-related {
        background-color: #f8f8ff;
        padding: 60px 0;
        margin-top: 60px;
    }
    
    .program-related h2 {
        font-size: 1.8rem;
        color: #2c2977;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .related-programs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }
    
    .related-program-card {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .related-program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .related-program-image {
        height: 180px;
        overflow: hidden;
    }
    
    .related-program-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .related-program-card:hover .related-program-image img {
        transform: scale(1.05);
    }
    
    .related-program-content {
        padding: 20px;
    }
    
    .related-program-title {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #2c2977;
    }
    
    .related-program-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .related-program-overview {
        color: #666;
        margin-bottom: 15px;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .related-program-button {
        display: inline-block;
        background-color: #f0f0ff;
        color: #2c2977;
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .related-program-button:hover {
        background-color: #e0e0ff;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 991px) {
        .program-main-content {
            grid-template-columns: 1fr;
        }
        
        .program-sidebar {
            position: static;
        }
        
        .related-programs-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .program-header {
            padding: 40px 0 30px;
        }
        
        .program-title {
            font-size: 2.2rem;
        }
        
        .benefits-grid {
            grid-template-columns: 1fr;
        }
        
        .related-programs-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php get_footer(); ?>