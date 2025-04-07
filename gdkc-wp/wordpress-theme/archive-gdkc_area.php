<?php
/**
 * Template for displaying Service Areas archive
 *
 * @package Good_Dogz_KC
 */

get_header();

$title = get_field('service_areas_title', 'option') ?: 'Service Areas';
$description = get_field('service_areas_description', 'option') ?: 'We provide professional dog training services to the following areas.';

// Get all the area categories for filtering
$categories = get_terms([
    'taxonomy' => 'gdkc_area_category',
    'hide_empty' => true,
]);

// Get the current filter values from URL
$current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Build the tax query if filters are active
$tax_query = [];

if (!empty($current_category)) {
    $tax_query[] = [
        'taxonomy' => 'gdkc_area_category',
        'field' => 'slug',
        'terms' => $current_category,
    ];
}

// Query for service areas
$args = [
    'post_type' => 'gdkc_area',
    'posts_per_page' => 24,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'orderby' => 'menu_order title',
    'order' => 'ASC',
];

if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}

$query = new WP_Query($args);
?>

<div class="gdkc-areas-archive">
    <div class="gdkc-page-header">
        <div class="container">
            <h1 class="page-title"><?php echo esc_html($title); ?></h1>
            <div class="page-description"><?php echo wp_kses_post($description); ?></div>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($categories)) : ?>
            <div class="gdkc-filter-bar">
                <div class="filter-title">Filter Areas:</div>
                <form class="gdkc-filters" method="get">
                    <div class="filter-group">
                        <label for="category-filter">Region:</label>
                        <select id="category-filter" name="category">
                            <option value="">All Regions</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo esc_attr($category->slug); ?>" <?php selected($current_category, $category->slug); ?>>
                                    <?php echo esc_html($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="filter-submit">Apply Filter</button>
                    <?php if (!empty($current_category)) : ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('gdkc_area')); ?>" class="clear-filters">Clear Filter</a>
                    <?php endif; ?>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($query->have_posts()) : ?>
            <div class="gdkc-areas-map">
                <h2>Our Service Area Map</h2>
                <div id="service-areas-map" class="service-map"></div>
            </div>
            
            <div class="gdkc-areas-grid">
                <?php while ($query->have_posts()) : $query->the_post(); 
                    // Get custom fields
                    $zip_code = get_field('zip_code');
                    $city = get_field('city');
                    $state = get_field('state');
                    $primary_services = get_field('primary_services');
                    $availability = get_field('availability');
                    $map_coordinates = get_field('map_coordinates');
                ?>
                    <div class="service-area-card" 
                        <?php if ($map_coordinates) : ?>
                        data-lat="<?php echo esc_attr($map_coordinates['lat']); ?>"
                        data-lng="<?php echo esc_attr($map_coordinates['lng']); ?>"
                        <?php endif; ?>>
                        <div class="area-header">
                            <h2 class="area-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="area-meta">
                                <?php if ($city && $state) : ?>
                                    <span class="area-location"><?php echo esc_html($city . ', ' . $state); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($zip_code) : ?>
                                    <span class="area-zip"><?php echo esc_html($zip_code); ?></span>
                                <?php endif; ?>
                                
                                <?php 
                                // Show categories
                                $cat_terms = get_the_terms(get_the_ID(), 'gdkc_area_category');
                                if ($cat_terms && !is_wp_error($cat_terms)) : 
                                    foreach ($cat_terms as $term) :
                                ?>
                                    <span class="area-category"><?php echo esc_html($term->name); ?></span>
                                <?php 
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                        </div>
                        
                        <div class="area-content">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="area-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="area-details">
                                <div class="area-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <?php if ($primary_services) : ?>
                                    <div class="area-services">
                                        <h3>Available Services:</h3>
                                        <ul class="services-list">
                                            <?php foreach ($primary_services as $service) : ?>
                                                <li><?php echo esc_html($service['service_name']); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($availability) : ?>
                                    <div class="area-availability">
                                        <h3>Availability:</h3>
                                        <p><?php echo esc_html($availability); ?></p>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more-link">View Details</a>
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
                <p>No service areas found matching your criteria. Try adjusting your filters or contact us for more information.</p>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        
        <div class="areas-contact-callout">
            <div class="callout-content">
                <h3>Don't See Your Area Listed?</h3>
                <p>We may still be able to serve your location. Contact us to discuss your specific needs and service area availability.</p>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-button">Contact Us</a>
            </div>
        </div>
    </div>
</div>

<!-- Load Google Maps API and initialize the map -->
<script>
function initServiceAreasMap() {
    // Check if there are service areas
    const serviceAreaCards = document.querySelectorAll('.service-area-card[data-lat][data-lng]');
    
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
        
        // Adjust zoom if too close
        google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
            if (map.getZoom() > 15) {
                map.setZoom(15);
            }
        });
    }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initServiceAreasMap"></script>

<?php get_footer(); ?>