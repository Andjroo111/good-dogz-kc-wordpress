<?php
/**
 * Custom Gutenberg Blocks
 *
 * @package Good_Dogz_KC
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom block category
 */
function gdkc_block_category($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'gooddogzkc',
                'title' => __('Good Dogz KC', 'gooddogzkc'),
                'icon'  => 'pets',
            ],
        ]
    );
}
add_filter('block_categories_all', 'gdkc_block_category', 10, 2);

/**
 * Enqueue block editor assets
 */
function gdkc_enqueue_block_editor_assets() {
    // Block editor script
    wp_enqueue_script(
        'gdkc-blocks',
        get_stylesheet_directory_uri() . '/assets/js/blocks.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-i18n'],
        filemtime(get_stylesheet_directory() . '/assets/js/blocks.js'),
        true
    );

    // Block editor styles
    wp_enqueue_style(
        'gdkc-blocks-editor',
        get_stylesheet_directory_uri() . '/assets/css/blocks-editor.css',
        ['wp-edit-blocks'],
        filemtime(get_stylesheet_directory() . '/assets/css/blocks-editor.css')
    );

    // Pass data to script
    wp_localize_script(
        'gdkc-blocks',
        'gdkcBlocks',
        [
            'pluginDirPath' => plugin_dir_path(__DIR__),
            'pluginDirUrl'  => plugin_dir_url(__DIR__),
            'siteUrl' => get_site_url(),
        ]
    );
}
add_action('enqueue_block_editor_assets', 'gdkc_enqueue_block_editor_assets');

/**
 * Enqueue block assets for frontend
 */
function gdkc_enqueue_block_assets() {
    wp_enqueue_style(
        'gdkc-blocks',
        get_stylesheet_directory_uri() . '/assets/css/blocks.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/blocks.css')
    );
}
add_action('enqueue_block_assets', 'gdkc_enqueue_block_assets');

/**
 * Register blocks server-side
 */
function gdkc_register_blocks() {
    // Service Areas Block
    register_block_type('gooddogzkc/service-areas', [
        'editor_script' => 'gdkc-blocks',
        'editor_style'  => 'gdkc-blocks-editor',
        'style'         => 'gdkc-blocks',
        'render_callback' => 'gdkc_render_service_areas_block',
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'Our Service Areas',
            ],
            'showMap' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'numAreas' => [
                'type' => 'number',
                'default' => 6,
            ],
            'regionFilter' => [
                'type' => 'string',
                'default' => '',
            ],
            'alignment' => [
                'type' => 'string',
                'default' => 'center',
            ],
            'className' => [
                'type' => 'string',
                'default' => '',
            ],
        ],
    ]);

    // Testimonials Block
    register_block_type('gooddogzkc/testimonials', [
        'editor_script' => 'gdkc-blocks',
        'editor_style'  => 'gdkc-blocks-editor',
        'style'         => 'gdkc-blocks',
        'render_callback' => 'gdkc_render_testimonials_block',
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'What Our Clients Say',
            ],
            'layout' => [
                'type' => 'string',
                'default' => 'slider',
            ],
            'numPosts' => [
                'type' => 'number',
                'default' => 3,
            ],
            'showImage' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'showRating' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'breedFilter' => [
                'type' => 'string',
                'default' => '',
            ],
            'issueFilter' => [
                'type' => 'string',
                'default' => '',
            ],
            'alignment' => [
                'type' => 'string',
                'default' => 'center',
            ],
            'className' => [
                'type' => 'string',
                'default' => '',
            ],
        ],
    ]);

    // Service Packages Block
    register_block_type('gooddogzkc/service-packages', [
        'editor_script' => 'gdkc-blocks',
        'editor_style'  => 'gdkc-blocks-editor',
        'style'         => 'gdkc-blocks',
        'render_callback' => 'gdkc_render_service_packages_block',
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'Our Training Packages',
            ],
            'layout' => [
                'type' => 'string',
                'default' => 'grid',
            ],
            'numPackages' => [
                'type' => 'number',
                'default' => 3,
            ],
            'packageType' => [
                'type' => 'string',
                'default' => '',
            ],
            'showPrice' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'showButton' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'buttonText' => [
                'type' => 'string',
                'default' => 'Learn More',
            ],
            'alignment' => [
                'type' => 'string',
                'default' => 'center',
            ],
            'className' => [
                'type' => 'string',
                'default' => '',
            ],
        ],
    ]);
    
    // Training Tips Block
    register_block_type('gooddogzkc/training-tips', [
        'editor_script' => 'gdkc-blocks',
        'editor_style'  => 'gdkc-blocks-editor',
        'style'         => 'gdkc-blocks',
        'render_callback' => 'gdkc_render_training_tips_block',
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'Training Tips',
            ],
            'numPosts' => [
                'type' => 'number',
                'default' => 3,
            ],
            'category' => [
                'type' => 'string',
                'default' => '',
            ],
            'showExcerpt' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'showImage' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'buttonText' => [
                'type' => 'string',
                'default' => 'Read More',
            ],
            'className' => [
                'type' => 'string',
                'default' => '',
            ],
        ],
    ]);

    // Assessment Form Block
    register_block_type('gooddogzkc/assessment-form', [
        'editor_script' => 'gdkc-blocks',
        'editor_style'  => 'gdkc-blocks-editor',
        'style'         => 'gdkc-blocks',
        'render_callback' => 'gdkc_render_assessment_form_block',
        'attributes' => [
            'title' => [
                'type' => 'string',
                'default' => 'Dog Behavior Assessment',
            ],
            'description' => [
                'type' => 'string',
                'default' => 'Complete our assessment form to receive personalized training recommendations.',
            ],
            'buttonText' => [
                'type' => 'string',
                'default' => 'Start Assessment',
            ],
            'successMessage' => [
                'type' => 'string',
                'default' => 'Thank you! Your assessment has been submitted successfully.',
            ],
            'className' => [
                'type' => 'string',
                'default' => '',
            ],
        ],
    ]);
}
add_action('init', 'gdkc_register_blocks');

/**
 * Render Service Areas Block
 */
function gdkc_render_service_areas_block($attributes) {
    $title = $attributes['title'];
    $show_map = $attributes['showMap'];
    $num_areas = $attributes['numAreas'];
    $region_filter = $attributes['regionFilter'];
    $alignment = $attributes['alignment'];
    $class_name = $attributes['className'];
    
    $block_class = 'gdkc-service-areas-block';
    if (!empty($class_name)) {
        $block_class .= ' ' . $class_name;
    }
    $block_class .= ' align-' . $alignment;
    
    // Query arguments
    $args = [
        'post_type' => 'gdkc_area',
        'posts_per_page' => $num_areas,
        'orderby' => 'menu_order title',
        'order' => 'ASC',
    ];
    
    // Add region filter if specified
    if (!empty($region_filter)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'gdkc_area_category',
                'field' => 'slug',
                'terms' => $region_filter,
            ]
        ];
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($block_class); ?>">
        <?php if (!empty($title)) : ?>
            <h2 class="gdkc-block-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($show_map && $query->have_posts()) : ?>
            <div class="gdkc-areas-map">
                <div id="service-areas-map" class="service-map"></div>
            </div>
        <?php endif; ?>
        
        <?php if ($query->have_posts()) : ?>
            <div class="gdkc-areas-grid">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $zip_code = get_field('zip_code');
                    $city = get_field('city');
                    $state = get_field('state');
                    $map_coordinates = get_field('map_coordinates');
                ?>
                    <div class="service-area-card" 
                        <?php if ($map_coordinates) : ?>
                        data-lat="<?php echo esc_attr($map_coordinates['lat']); ?>"
                        data-lng="<?php echo esc_attr($map_coordinates['lng']); ?>"
                        <?php endif; ?>>
                        <div class="area-header">
                            <h3 class="area-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="area-meta">
                                <?php if ($city && $state) : ?>
                                    <span class="area-location"><?php echo esc_html($city . ', ' . $state); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($zip_code) : ?>
                                    <span class="area-zip"><?php echo esc_html($zip_code); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="area-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="block-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_area')); ?>" class="view-all-link">View All Service Areas</a>
            </div>
            
            <?php if ($show_map) : ?>
                <script>
                function initServiceAreasMapBlock() {
                    // Check if there are service areas
                    const serviceAreaCards = document.querySelectorAll('.gdkc-service-areas-block .service-area-card[data-lat][data-lng]');
                    
                    if (serviceAreaCards.length === 0) {
                        return;
                    }
                    
                    // Create map
                    const mapElement = document.getElementById('service-areas-map');
                    const map = new google.maps.Map(mapElement, {
                        zoom: 10,
                        center: {lat: 39.0997, lng: -94.5786}, // Default to Kansas City
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    
                    // Create info window
                    const infoWindow = new google.maps.InfoWindow();
                    
                    // Add markers for each service area
                    const bounds = new google.maps.LatLngBounds();
                    const markers = [];
                    
                    serviceAreaCards.forEach(card => {
                        const lat = parseFloat(card.dataset.lat);
                        const lng = parseFloat(card.dataset.lng);
                        const title = card.querySelector('.area-title').textContent.trim();
                        const url = card.querySelector('.area-title a').getAttribute('href');
                        
                        if (isNaN(lat) || isNaN(lng)) {
                            return;
                        }
                        
                        const position = {lat, lng};
                        bounds.extend(position);
                        
                        const marker = new google.maps.Marker({
                            position,
                            map,
                            title,
                            animation: google.maps.Animation.DROP
                        });
                        
                        markers.push(marker);
                        
                        // Add click listener
                        marker.addListener('click', () => {
                            const content = `
                                <div class="map-info-window">
                                    <h3>${title}</h3>
                                    <a href="${url}" class="view-details">View Details</a>
                                </div>
                            `;
                            
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        });
                    });
                    
                    // Fit map to bounds
                    if (!bounds.isEmpty()) {
                        map.fitBounds(bounds);
                    }
                }
                
                // Load Google Maps API if not already loaded
                if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                    const script = document.createElement('script');
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initServiceAreasMapBlock';
                    script.async = true;
                    script.defer = true;
                    document.head.appendChild(script);
                } else {
                    initServiceAreasMapBlock();
                }
                </script>
            <?php endif; ?>
            
        <?php else : ?>
            <p class="no-results">No service areas found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Testimonials Block
 */
function gdkc_render_testimonials_block($attributes) {
    $title = $attributes['title'];
    $layout = $attributes['layout'];
    $num_posts = $attributes['numPosts'];
    $show_image = $attributes['showImage'];
    $show_rating = $attributes['showRating'];
    $breed_filter = $attributes['breedFilter'];
    $issue_filter = $attributes['issueFilter'];
    $alignment = $attributes['alignment'];
    $class_name = $attributes['className'];
    
    $block_class = 'gdkc-testimonials-block';
    if (!empty($class_name)) {
        $block_class .= ' ' . $class_name;
    }
    $block_class .= ' layout-' . $layout;
    $block_class .= ' align-' . $alignment;
    
    // Query arguments
    $args = [
        'post_type' => 'gdkc_success',
        'posts_per_page' => $num_posts,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Add breed filter if specified
    if (!empty($breed_filter)) {
        $args['tax_query'][] = [
            'taxonomy' => 'dog_breed',
            'field' => 'slug',
            'terms' => $breed_filter,
        ];
    }
    
    // Add issue filter if specified
    if (!empty($issue_filter)) {
        $args['tax_query'][] = [
            'taxonomy' => 'issue_addressed',
            'field' => 'slug',
            'terms' => $issue_filter,
        ];
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($block_class); ?>">
        <?php if (!empty($title)) : ?>
            <h2 class="gdkc-block-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($query->have_posts()) : ?>
            <div class="testimonials-container <?php echo $layout === 'slider' ? 'testimonials-slider' : 'testimonials-grid'; ?>">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $owner_name = get_field('owner_name');
                    $dog_name = get_field('dog_name');
                    $dog_breed = get_field('dog_breed');
                    $testimonial = get_field('testimonial');
                    $testimonial_excerpt = get_field('testimonial_excerpt');
                    $rating = get_field('rating');
                    
                    // Use excerpt if available, otherwise use the first part of the testimonial
                    $short_testimonial = $testimonial_excerpt;
                    if (empty($short_testimonial) && !empty($testimonial)) {
                        $short_testimonial = wp_trim_words($testimonial, 30);
                    }
                ?>
                    <div class="testimonial-item">
                        <?php if ($show_image && has_post_thumbnail()) : ?>
                            <div class="testimonial-image">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="testimonial-content">
                            <?php if ($show_rating && !empty($rating)) : ?>
                                <div class="testimonial-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <span class="star <?php echo $i <= $rating ? 'filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            
                            <blockquote class="testimonial-text">
                                <?php echo wpautop(esc_html($short_testimonial)); ?>
                            </blockquote>
                            
                            <div class="testimonial-author">
                                <cite>
                                    <?php 
                                    if (!empty($owner_name)) {
                                        echo esc_html($owner_name);
                                        
                                        if (!empty($dog_name) && !empty($dog_breed)) {
                                            echo ' with ' . esc_html($dog_name) . ' (' . esc_html($dog_breed) . ')';
                                        } elseif (!empty($dog_name)) {
                                            echo ' with ' . esc_html($dog_name);
                                        }
                                    } else {
                                        the_title();
                                    }
                                    ?>
                                </cite>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more-link">Read Full Story</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <?php if ($layout === 'slider') : ?>
                <div class="slider-navigation">
                    <button class="slider-prev">Previous</button>
                    <button class="slider-next">Next</button>
                </div>
            <?php endif; ?>
            
            <div class="block-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_success')); ?>" class="view-all-link">View All Success Stories</a>
            </div>
            
            <?php if ($layout === 'slider') : ?>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    initTestimonialsSlider();
                });
                
                function initTestimonialsSlider() {
                    const slider = document.querySelector('.testimonials-slider');
                    const slides = slider.querySelectorAll('.testimonial-item');
                    const prevButton = document.querySelector('.slider-prev');
                    const nextButton = document.querySelector('.slider-next');
                    let currentSlide = 0;
                    
                    // Hide all slides except the first one
                    slides.forEach((slide, index) => {
                        if (index !== 0) {
                            slide.style.display = 'none';
                        }
                    });
                    
                    // Previous button click handler
                    prevButton.addEventListener('click', () => {
                        slides[currentSlide].style.display = 'none';
                        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                        slides[currentSlide].style.display = 'flex';
                    });
                    
                    // Next button click handler
                    nextButton.addEventListener('click', () => {
                        slides[currentSlide].style.display = 'none';
                        currentSlide = (currentSlide + 1) % slides.length;
                        slides[currentSlide].style.display = 'flex';
                    });
                }
                </script>
            <?php endif; ?>
            
        <?php else : ?>
            <p class="no-results">No testimonials found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Service Packages Block
 */
function gdkc_render_service_packages_block($attributes) {
    $title = $attributes['title'];
    $layout = $attributes['layout'];
    $num_packages = $attributes['numPackages'];
    $package_type = $attributes['packageType'];
    $show_price = $attributes['showPrice'];
    $show_button = $attributes['showButton'];
    $button_text = $attributes['buttonText'];
    $alignment = $attributes['alignment'];
    $class_name = $attributes['className'];
    
    $block_class = 'gdkc-service-packages-block';
    if (!empty($class_name)) {
        $block_class .= ' ' . $class_name;
    }
    $block_class .= ' layout-' . $layout;
    $block_class .= ' align-' . $alignment;
    
    // Query arguments
    $args = [
        'post_type' => 'gdkc_package',
        'posts_per_page' => $num_packages,
        'orderby' => 'menu_order title',
        'order' => 'ASC',
    ];
    
    // Add package type filter if specified
    if (!empty($package_type)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'package_type',
                'field' => 'slug',
                'terms' => $package_type,
            ]
        ];
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($block_class); ?>">
        <?php if (!empty($title)) : ?>
            <h2 class="gdkc-block-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($query->have_posts()) : ?>
            <div class="packages-container packages-<?php echo $layout; ?>">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $price = get_field('price');
                    $duration = get_field('duration');
                    $features = get_field('features');
                ?>
                    <div class="package-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="package-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="package-content">
                            <h3 class="package-title"><?php the_title(); ?></h3>
                            
                            <?php if ($show_price && !empty($price)) : ?>
                                <div class="package-price">
                                    <?php echo esc_html($price); ?>
                                    <?php if (!empty($duration)) : ?>
                                        <span class="package-duration"><?php echo esc_html($duration); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="package-description">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <?php if (!empty($features)) : ?>
                                <ul class="package-features">
                                    <?php foreach ($features as $feature) : ?>
                                        <li>
                                            <span class="feature-name"><?php echo esc_html($feature['feature_name']); ?></span>
                                            <?php if (!empty($feature['feature_description'])) : ?>
                                                <span class="feature-description"><?php echo esc_html($feature['feature_description']); ?></span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            
                            <?php if ($show_button) : ?>
                                <a href="<?php the_permalink(); ?>" class="package-button"><?php echo esc_html($button_text); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="block-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_package')); ?>" class="view-all-link">View All Packages</a>
            </div>
            
        <?php else : ?>
            <p class="no-results">No service packages found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Training Tips Block
 */
function gdkc_render_training_tips_block($attributes) {
    $title = $attributes['title'];
    $num_posts = $attributes['numPosts'];
    $category = $attributes['category'];
    $show_excerpt = $attributes['showExcerpt'];
    $show_image = $attributes['showImage'];
    $button_text = $attributes['buttonText'];
    $class_name = $attributes['className'];
    
    $block_class = 'gdkc-training-tips-block';
    if (!empty($class_name)) {
        $block_class .= ' ' . $class_name;
    }
    
    // Query arguments
    $args = [
        'post_type' => 'gdkc_resource',
        'posts_per_page' => $num_posts,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Add category filter if specified
    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'resource_topic',
                'field' => 'slug',
                'terms' => $category,
            ]
        ];
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($block_class); ?>">
        <?php if (!empty($title)) : ?>
            <h2 class="gdkc-block-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        
        <?php if ($query->have_posts()) : ?>
            <div class="tips-grid">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $estimated_time = get_field('estimated_time');
                    $resource_type = get_field('resource_type');
                ?>
                    <div class="tip-card">
                        <?php if ($show_image && has_post_thumbnail()) : ?>
                            <div class="tip-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="tip-content">
                            <h3 class="tip-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="tip-meta">
                                <?php if (!empty($resource_type)) : ?>
                                    <span class="tip-type"><?php echo esc_html($resource_type); ?></span>
                                <?php endif; ?>
                                
                                <?php if (!empty($estimated_time)) : ?>
                                    <span class="tip-time"><?php echo esc_html($estimated_time); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($show_excerpt) : ?>
                                <div class="tip-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <a href="<?php the_permalink(); ?>" class="tip-button"><?php echo esc_html($button_text); ?></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <div class="block-footer">
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_resource')); ?>" class="view-all-link">View All Training Resources</a>
            </div>
            
        <?php else : ?>
            <p class="no-results">No training tips found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Render Assessment Form Block
 */
function gdkc_render_assessment_form_block($attributes) {
    $title = $attributes['title'];
    $description = $attributes['description'];
    $button_text = $attributes['buttonText'];
    $success_message = $attributes['successMessage'];
    $class_name = $attributes['className'];
    
    $block_class = 'gdkc-assessment-form-block';
    if (!empty($class_name)) {
        $block_class .= ' ' . $class_name;
    }
    
    // Generate a unique ID for the form
    $form_id = 'gdkc-assessment-form-' . uniqid();
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($block_class); ?>">
        <div class="assessment-form-container">
            <?php if (!empty($title)) : ?>
                <h2 class="form-title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if (!empty($description)) : ?>
                <div class="form-description">
                    <?php echo wpautop(esc_html($description)); ?>
                </div>
            <?php endif; ?>
            
            <div class="assessment-cta">
                <a href="<?php echo esc_url(home_url('/dog-behavior-assessment/')); ?>" class="assessment-button"><?php echo esc_html($button_text); ?></a>
                <p class="cta-note">Takes about 5-10 minutes to complete</p>
            </div>
            
            <div class="assessment-benefits">
                <h3>What You'll Get:</h3>
                <ul>
                    <li>Personalized training program recommendations</li>
                    <li>Insights into your dog's behavior patterns</li>
                    <li>Professional advice on addressing specific issues</li>
                    <li>Clear next steps for improving your dog's behavior</li>
                </ul>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}