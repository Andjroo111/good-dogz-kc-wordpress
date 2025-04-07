<?php
/**
 * Template part for displaying the training programs section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Training Programs Section -->
<section class="programs-section" id="training-solutions">
    <div class="container">
        <h2 class="section-title"><?php echo get_theme_mod('programs_title', 'Our Training Programs'); ?></h2>
        <p class="section-subtitle text-center"><?php echo get_theme_mod('programs_subtitle', 'Customized solutions for every dog and family'); ?></p>
        
        <div class="programs-grid">
            <?php
            // Query for program posts
            $programs_query = new WP_Query([
                'post_type' => 'program',
                'posts_per_page' => 3
            ]);
            
            if ($programs_query->have_posts()) :
                while ($programs_query->have_posts()) : $programs_query->the_post();
                    $price = get_post_meta(get_the_ID(), '_program_price', true);
                    $subtitle = get_post_meta(get_the_ID(), '_program_subtitle', true);
                    $features = get_post_meta(get_the_ID(), '_program_features', true);
                    $is_featured = get_post_meta(get_the_ID(), '_program_featured', true);
                    $header_class = get_post_meta(get_the_ID(), '_program_header_class', true);
            ?>
            <div class="program-card <?php echo $is_featured ? 'highlighted' : ''; ?>">
                <div class="program-card__header <?php echo esc_attr($header_class); ?>">
                    <h3 class="program-card__title <?php echo $header_class ? 'text-white' : ''; ?>"><?php the_title(); ?></h3>
                    <p class="program-card__subtitle <?php echo $header_class ? 'text-white' : ''; ?>"><?php echo esc_html($subtitle); ?></p>
                    <div class="program-card__price <?php echo $header_class ? 'text-white' : ''; ?>">From $<?php echo esc_html($price); ?></div>
                </div>
                <div class="program-card__body">
                    <ul class="program-features">
                        <?php
                        if ($features) :
                            $features_array = explode("\n", $features);
                            foreach ($features_array as $feature) :
                                if (trim($feature)) :
                        ?>
                        <li class="program-feature">
                            <i class="fas fa-check"></i>
                            <span><?php echo esc_html(trim($feature)); ?></span>
                        </li>
                        <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="program-card__footer">
                    <a href="<?php the_permalink(); ?>" class="gdkc-button primary <?php echo $is_featured ? 'pulse-animation' : ''; ?>">Learn More</a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback programs if no custom post type entries
                $fallback_programs = [
                    [
                        'title' => 'In-Home Training',
                        'subtitle' => 'Personalized training in your environment',
                        'price' => '150',
                        'features' => [
                            'Customized to your dog\'s specific needs',
                            'Training in your home environment',
                            'Practical solutions for real-life scenarios',
                            'Flexible scheduling options',
                            'Family involvement and education'
                        ],
                        'is_featured' => false,
                        'header_class' => ''
                    ],
                    [
                        'title' => 'Board & Train',
                        'subtitle' => 'Intensive training with proven results',
                        'price' => '1,200',
                        'features' => [
                            '2-3 week training program',
                            'Daily structured training sessions',
                            'Real-world socialization opportunities',
                            'Regular progress updates and videos',
                            'Transfer sessions and follow-up support'
                        ],
                        'is_featured' => true,
                        'header_class' => 'program-card__header--blue'
                    ],
                    [
                        'title' => 'Virtual Training',
                        'subtitle' => 'Expert guidance from anywhere',
                        'price' => '85',
                        'features' => [
                            'Convenient online sessions',
                            'One-on-one guidance from trainers',
                            'Custom training plans and homework',
                            'Video review and feedback',
                            'Email support between sessions'
                        ],
                        'is_featured' => false,
                        'header_class' => ''
                    ]
                ];
                
                foreach ($fallback_programs as $program) :
            ?>
            <div class="program-card <?php echo $program['is_featured'] ? 'highlighted' : ''; ?>">
                <div class="program-card__header <?php echo esc_attr($program['header_class']); ?>">
                    <h3 class="program-card__title <?php echo $program['header_class'] ? 'text-white' : ''; ?>"><?php echo esc_html($program['title']); ?></h3>
                    <p class="program-card__subtitle <?php echo $program['header_class'] ? 'text-white' : ''; ?>"><?php echo esc_html($program['subtitle']); ?></p>
                    <div class="program-card__price <?php echo $program['header_class'] ? 'text-white' : ''; ?>">From $<?php echo esc_html($program['price']); ?></div>
                </div>
                <div class="program-card__body">
                    <ul class="program-features">
                        <?php foreach ($program['features'] as $feature) : ?>
                        <li class="program-feature">
                            <i class="fas fa-check"></i>
                            <span><?php echo esc_html($feature); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="program-card__footer">
                    <a href="#contact" class="gdkc-button primary <?php echo $program['is_featured'] ? 'pulse-animation' : ''; ?>">Learn More</a>
                </div>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        
        <div class="programs-note text-center">
            <p class="note-text"><?php echo get_theme_mod('programs_note', 'All programs include our 30-day satisfaction guarantee. Not sure which program is right for you?'); ?></p>
            <a href="<?php echo get_theme_mod('programs_cta_url', '#contact'); ?>" class="gdkc-button secondary gdkc-mt-md"><?php echo get_theme_mod('programs_cta_text', 'Book a Free Consultation'); ?></a>
        </div>
    </div>
</section>