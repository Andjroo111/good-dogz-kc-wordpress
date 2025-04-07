<?php
/**
 * Template for displaying single Service Area
 *
 * @package Good_Dogz_KC
 */

get_header();

// Get custom fields
$zip_code = get_field('zip_code');
$city = get_field('city');
$state = get_field('state');
$primary_services = get_field('primary_services');
$availability = get_field('availability');
$map_coordinates = get_field('map_coordinates');
$service_details = get_field('service_details');
$local_testimonials = get_field('local_testimonials');
$local_resources = get_field('local_resources');
$local_partners = get_field('local_partners');
$service_radius = get_field('service_radius');
$area_image_gallery = get_field('area_image_gallery');

// Get taxonomy terms
$area_categories = get_the_terms(get_the_ID(), 'gdkc_area_category');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('gdkc-service-area'); ?>>
    <div class="gdkc-page-header">
        <div class="container">
            <div class="area-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> &raquo;
                <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_area')); ?>">Service Areas</a> &raquo;
                <span><?php the_title(); ?></span>
            </div>
            
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <div class="area-meta">
                <?php if ($city && $state) : ?>
                    <span class="area-location"><?php echo esc_html($city . ', ' . $state); ?></span>
                <?php endif; ?>
                
                <?php if ($zip_code) : ?>
                    <span class="area-zip">ZIP: <?php echo esc_html($zip_code); ?></span>
                <?php endif; ?>
                
                <?php if (!empty($area_categories) && !is_wp_error($area_categories)) : ?>
                    <div class="area-categories">
                        <?php foreach ($area_categories as $category) : ?>
                            <span class="area-category"><?php echo esc_html($category->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="gdkc-area-content">
            <div class="content-main">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="area-description">
                    <?php the_content(); ?>
                </div>
                
                <?php if ($map_coordinates) : ?>
                    <div class="area-map-section">
                        <h2>Service Area Map</h2>
                        <div id="area-map" class="area-map" 
                             data-lat="<?php echo esc_attr($map_coordinates['lat']); ?>" 
                             data-lng="<?php echo esc_attr($map_coordinates['lng']); ?>"
                             data-radius="<?php echo esc_attr($service_radius ?: 10); ?>">
                        </div>
                        <?php if ($service_radius) : ?>
                            <p class="radius-note">We provide services within approximately <?php echo esc_html($service_radius); ?> miles of <?php the_title(); ?>.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($service_details) : ?>
                    <div class="area-service-details">
                        <h2>Services Available in <?php the_title(); ?></h2>
                        <div class="service-details-content">
                            <?php echo wp_kses_post($service_details); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($primary_services) : ?>
                    <div class="area-services-section">
                        <h2>Available Services</h2>
                        <div class="services-grid">
                            <?php foreach ($primary_services as $service) : ?>
                                <div class="service-card">
                                    <h3><?php echo esc_html($service['service_name']); ?></h3>
                                    
                                    <?php if (!empty($service['service_description'])) : ?>
                                        <div class="service-description">
                                            <?php echo wp_kses_post($service['service_description']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($service['service_price'])) : ?>
                                        <div class="service-price">
                                            <?php echo esc_html($service['service_price']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($service['service_link']) && !empty($service['service_link_text'])) : ?>
                                        <a href="<?php echo esc_url($service['service_link']); ?>" class="service-link">
                                            <?php echo esc_html($service['service_link_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($area_image_gallery) : ?>
                    <div class="area-gallery">
                        <h2>Photos from <?php the_title(); ?></h2>
                        <div class="gallery-grid">
                            <?php foreach ($area_image_gallery as $image) : ?>
                                <div class="gallery-item">
                                    <a href="<?php echo esc_url($image['url']); ?>" class="lightbox">
                                        <img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($local_testimonials) : ?>
                    <div class="local-testimonials">
                        <h2>What <?php the_title(); ?> Clients Say</h2>
                        <div class="testimonials-slider">
                            <?php foreach ($local_testimonials as $testimonial) : ?>
                                <div class="testimonial-slide">
                                    <div class="testimonial-content">
                                        <?php echo wp_kses_post($testimonial['testimonial_content']); ?>
                                    </div>
                                    
                                    <?php if (!empty($testimonial['client_name'])) : ?>
                                        <div class="testimonial-author">
                                            <cite>- <?php echo esc_html($testimonial['client_name']); ?></cite>
                                            
                                            <?php if (!empty($testimonial['client_location'])) : ?>
                                                <span class="author-location"><?php echo esc_html($testimonial['client_location']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($local_partners) : ?>
                    <div class="local-partners">
                        <h2>Our Partners in <?php the_title(); ?></h2>
                        <div class="partners-grid">
                            <?php foreach ($local_partners as $partner) : ?>
                                <div class="partner-card">
                                    <?php if (!empty($partner['partner_logo'])) : ?>
                                        <div class="partner-logo">
                                            <img src="<?php echo esc_url($partner['partner_logo']['sizes']['medium']); ?>" alt="<?php echo esc_attr($partner['partner_name']); ?> logo">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h3 class="partner-name"><?php echo esc_html($partner['partner_name']); ?></h3>
                                    
                                    <?php if (!empty($partner['partner_description'])) : ?>
                                        <div class="partner-description">
                                            <?php echo wp_kses_post($partner['partner_description']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($partner['partner_website'])) : ?>
                                        <a href="<?php echo esc_url($partner['partner_website']); ?>" target="_blank" class="partner-link">Visit Website</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($local_resources) : ?>
                    <div class="local-resources">
                        <h2>Local Resources for <?php the_title(); ?> Dog Owners</h2>
                        <div class="resources-list">
                            <ul>
                                <?php foreach ($local_resources as $resource) : ?>
                                    <li>
                                        <h3><?php echo esc_html($resource['resource_name']); ?></h3>
                                        
                                        <?php if (!empty($resource['resource_description'])) : ?>
                                            <div class="resource-description">
                                                <?php echo wp_kses_post($resource['resource_description']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($resource['resource_link'])) : ?>
                                            <a href="<?php echo esc_url($resource['resource_link']); ?>" target="_blank" class="resource-link">Learn More</a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="area-navigation">
                    <div class="nav-previous"><?php previous_post_link('%link', '&laquo; Previous Area: %title'); ?></div>
                    <div class="nav-next"><?php next_post_link('%link', 'Next Area: %title &raquo;'); ?></div>
                </div>
            </div>
            
            <div class="content-sidebar">
                <?php if ($availability) : ?>
                    <div class="availability-box">
                        <h3>Service Availability</h3>
                        <div class="availability-content">
                            <?php echo wp_kses_post($availability); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="cta-box">
                    <h3>Schedule Training in <?php the_title(); ?></h3>
                    <p>Ready to transform your dog's behavior? Contact us to schedule a training session in your area.</p>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="cta-button">Contact Us</a>
                </div>
                
                <div class="assessment-box">
                    <h3>Assess Your Dog's Needs</h3>
                    <p>Not sure which training program is right for your dog? Take our quick assessment to get personalized recommendations.</p>
                    <a href="<?php echo esc_url(home_url('/dog-behavior-assessment/')); ?>" class="assessment-button">Take the Assessment</a>
                </div>
                
                <div class="related-areas">
                    <h3>Nearby Service Areas</h3>
                    <ul class="nearby-areas-list">
                        <?php
                        // Get nearby service areas
                        $nearby_args = [
                            'post_type' => 'gdkc_area',
                            'posts_per_page' => 5,
                            'post__not_in' => [get_the_ID()],
                            'orderby' => 'rand',
                        ];
                        
                        // Add taxonomy query if we have area categories
                        if (!empty($area_categories) && !is_wp_error($area_categories)) {
                            $cat_ids = wp_list_pluck($area_categories, 'term_id');
                            
                            $nearby_args['tax_query'] = [
                                [
                                    'taxonomy' => 'gdkc_area_category',
                                    'field' => 'term_id',
                                    'terms' => $cat_ids,
                                ]
                            ];
                        }
                        
                        $nearby_query = new WP_Query($nearby_args);
                        
                        if ($nearby_query->have_posts()) :
                            while ($nearby_query->have_posts()) :
                                $nearby_query->the_post();
                                $nearby_city = get_field('city');
                                $nearby_state = get_field('state');
                        ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <?php if ($nearby_city && $nearby_state) : ?>
                                    <span class="area-location"><?php echo esc_html($nearby_city . ', ' . $nearby_state); ?></span>
                                <?php endif; ?>
                            </li>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <li>No nearby service areas found.</li>
                        <?php endif; ?>
                    </ul>
                    
                    <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_area')); ?>" class="view-all-link">View All Service Areas</a>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Load Google Maps API and initialize the map -->
<script>
function initSingleAreaMap() {
    const mapElement = document.getElementById('area-map');
    
    if (!mapElement) {
        return;
    }
    
    const lat = parseFloat(mapElement.dataset.lat);
    const lng = parseFloat(mapElement.dataset.lng);
    const radius = parseInt(mapElement.dataset.radius, 10) || 10;
    
    if (isNaN(lat) || isNaN(lng)) {
        return;
    }
    
    const center = {lat, lng};
    
    // Create map
    const map = new google.maps.Map(mapElement, {
        zoom: 11,
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    // Add marker for the area
    const marker = new google.maps.Marker({
        position: center,
        map,
        title: '<?php echo esc_js(get_the_title()); ?>',
        animation: google.maps.Animation.DROP
    });
    
    // Add circle to show service radius
    const radiusCircle = new google.maps.Circle({
        strokeColor: '#2c2977',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#07edbe',
        fillOpacity: 0.35,
        map,
        center: center,
        radius: radius * 1609.34  // Convert miles to meters
    });
    
    // Fit map to circle bounds
    map.fitBounds(radiusCircle.getBounds());
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initSingleAreaMap"></script>

<?php get_footer(); ?>