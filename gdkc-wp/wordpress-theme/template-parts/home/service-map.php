<?php
/**
 * Template part for displaying a service area map
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Get settings from theme mods
$section_title = get_theme_mod('service_map_title', 'Our Service Area');
$section_subtitle = get_theme_mod('service_map_subtitle', 'Check if we serve your neighborhood in Kansas City');
$intro_text = get_theme_mod('service_map_intro', 'We provide dog training services throughout the Kansas City metro area. Enter your address or neighborhood below to check if we serve your location.');
$radius_title = get_theme_mod('service_radius_title', 'Service Radius Information');
$radius_text = get_theme_mod('service_radius_text', 'We offer different pricing depending on your location. Core service areas have standard pricing, while extended areas may include a travel fee.');

// Define areas manually (could be replaced with custom post type in the future)
$service_areas = [
    'Downtown Kansas City',
    'Overland Park',
    'Leawood',
    'Prairie Village',
    'Mission',
    'Shawnee',
    'Lenexa',
    'Olathe',
    'Lee\'s Summit',
    'Independence',
    'Liberty',
    'Blue Springs',
    'Raytown',
    'Gladstone',
    'North Kansas City',
    'Grandview'
];

// Define map center and API key
$map_center_lat = get_theme_mod('map_center_lat', '39.0997');
$map_center_lng = get_theme_mod('map_center_lng', '-94.5786');
$core_radius = get_theme_mod('core_service_radius', '15'); // miles
$extended_radius = get_theme_mod('extended_service_radius', '30'); // miles
$google_maps_api_key = get_theme_mod('google_maps_api_key', ''); // Add your API key

$section_id = isset($args['section_id']) ? $args['section_id'] : 'service-area';
?>

<!-- Service Area Map Section -->
<section class="service-map-section" id="<?php echo esc_attr($section_id); ?>">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <?php if ($section_subtitle) : ?>
            <p class="section-subtitle text-center"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>
        
        <div class="service-map-container">
            <div class="service-map-content">
                <p class="service-map-intro"><?php echo esc_html($intro_text); ?></p>
                
                <div class="service-map-search">
                    <form class="service-map-search-form" id="location-search-form">
                        <input type="text" id="location-input" class="service-map-search-input" placeholder="Enter your address or neighborhood" aria-label="Enter your address or neighborhood">
                        <button type="submit" class="gdkc-button primary">Check Availability</button>
                    </form>
                </div>
                
                <div class="service-radius-info">
                    <h3 class="service-radius-title"><?php echo esc_html($radius_title); ?></h3>
                    <p class="service-radius-text"><?php echo esc_html($radius_text); ?></p>
                    
                    <div class="radius-legend">
                        <div class="radius-legend-item">
                            <span class="radius-color radius-color-primary"></span>
                            <span>Core Service Area (<?php echo esc_html($core_radius); ?> miles)</span>
                        </div>
                        <div class="radius-legend-item">
                            <span class="radius-color radius-color-secondary"></span>
                            <span>Extended Area (<?php echo esc_html($extended_radius); ?> miles)</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-map-areas">
                    <h3 class="service-map-areas-title">Areas We Serve</h3>
                    <ul class="service-area-list">
                        <?php foreach ($service_areas as $area) : ?>
                        <li class="service-area-item">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo esc_html($area); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div id="service-result" class="service-result" style="display: none;"></div>
            </div>
            
            <div class="service-map-wrapper">
                <div id="service-map" class="service-map"></div>
                <div id="map-tooltip" class="map-tooltip"></div>
            </div>
        </div>
    </div>
    
    <?php if ($google_maps_api_key) : ?>
    <script>
        // Map initialization script
        function initMap() {
            const mapCenter = { 
                lat: <?php echo floatval($map_center_lat); ?>, 
                lng: <?php echo floatval($map_center_lng); ?> 
            };
            
            const coreRadius = <?php echo floatval($core_radius); ?> * 1609.34; // Convert miles to meters
            const extendedRadius = <?php echo floatval($extended_radius); ?> * 1609.34; // Convert miles to meters
            
            // Create map
            const map = new google.maps.Map(document.getElementById('service-map'), {
                center: mapCenter,
                zoom: 10,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });
            
            // Add center marker
            const centerMarker = new google.maps.Marker({
                position: mapCenter,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillColor: '#2c2977',
                    fillOpacity: 1,
                    strokeWeight: 0,
                    scale: 8
                },
                title: 'Good Dogz KC'
            });
            
            // Add service radius circles
            const coreCircle = new google.maps.Circle({
                strokeColor: '#2c2977',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#2c2977',
                fillOpacity: 0.2,
                map: map,
                center: mapCenter,
                radius: coreRadius
            });
            
            const extendedCircle = new google.maps.Circle({
                strokeColor: '#07edbe',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#07edbe',
                fillOpacity: 0.1,
                map: map,
                center: mapCenter,
                radius: extendedRadius
            });
            
            // Initialize geocoder
            const geocoder = new google.maps.Geocoder();
            
            // Handle form submission
            document.getElementById('location-search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const address = document.getElementById('location-input').value;
                
                if (!address) return;
                
                geocoder.geocode({ address: address + ', Kansas City' }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        const userLocation = results[0].geometry.location;
                        
                        // Add marker for searched location
                        const searchMarker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            animation: google.maps.Animation.DROP
                        });
                        
                        // Center map on the result
                        map.setCenter(userLocation);
                        map.setZoom(12);
                        
                        // Calculate distance
                        const distance = google.maps.geometry.spherical.computeDistanceBetween(
                            userLocation, 
                            new google.maps.LatLng(mapCenter.lat, mapCenter.lng)
                        );
                        
                        // Determine service availability
                        const resultElement = document.getElementById('service-result');
                        resultElement.style.display = 'block';
                        
                        if (distance <= coreRadius) {
                            resultElement.innerHTML = '<div class="alert alert-success">✅ Good news! This location is in our core service area.</div>';
                        } else if (distance <= extendedRadius) {
                            resultElement.innerHTML = '<div class="alert alert-warning">✅ This location is in our extended service area. A small travel fee may apply.</div>';
                        } else {
                            resultElement.innerHTML = '<div class="alert alert-error">❌ This location is outside our service area. Please contact us for special arrangements.</div>';
                        }
                    } else {
                        alert('We couldn\'t find that location. Please try again with a more specific address.');
                    }
                });
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($google_maps_api_key); ?>&libraries=geometry&callback=initMap"></script>
    <?php else : ?>
    <!-- Fallback if no API key is provided -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create a static map
            const mapElement = document.getElementById('service-map');
            mapElement.innerHTML = '<div style="display: flex; height: 100%; align-items: center; justify-content: center; flex-direction: column; text-align: center;"><i class="fas fa-map-marked-alt" style="font-size: 3rem; color: var(--gdkc-primary); margin-bottom: 1rem;"></i><p>Interactive map not available.<br>Please contact us to check service availability.</p></div>';
            
            // Handle form submission
            document.getElementById('location-search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const address = document.getElementById('location-input').value;
                
                if (!address) return;
                
                const resultElement = document.getElementById('service-result');
                resultElement.style.display = 'block';
                resultElement.innerHTML = '<div class="alert alert-info">Please contact us to verify if this location is within our service area.</div>';
            });
        });
    </script>
    <?php endif; ?>
</section>