<?php
/**
 * SEO Helper Functions
 *
 * Adds custom SEO metadata for the Good Dogz KC theme
 *
 * @package Good_Dogz_KC
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add SEO metadata for custom post types
 */
function gdkc_add_seo_metadata() {
    // Add meta tags to service package pages
    if (is_singular('gdkc_package')) {
        global $post;
        
        // Get package details
        $price = get_field('price', $post->ID);
        $duration = get_field('duration', $post->ID);
        $features = get_field('features', $post->ID);
        
        // Build description from excerpt or content
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
        
        // Add price and duration to description if available
        if ($price) {
            $description .= ' Price: ' . $price . '.';
        }
        
        if ($duration) {
            $description .= ' Duration: ' . $duration . '.';
        }
        
        // Output meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . ' | ' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:type" content="product" />' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '" />' . "\n";
        }
    }
    
    // Add meta tags to success story pages
    if (is_singular('gdkc_success')) {
        global $post;
        
        // Get custom fields
        $dog_name = get_field('dog_name', $post->ID);
        $dog_breed = get_field('dog_breed', $post->ID);
        $training_program = get_field('training_program', $post->ID);
        
        // Build description from excerpt or testimonial
        $testimonial_excerpt = get_field('testimonial_excerpt', $post->ID);
        $testimonial = get_field('testimonial', $post->ID);
        
        if ($testimonial_excerpt) {
            $description = $testimonial_excerpt;
        } elseif ($testimonial) {
            $description = wp_trim_words($testimonial, 30);
        } else {
            $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
        }
        
        // Add dog info to title and description
        $title = get_the_title();
        if ($dog_name && $dog_breed) {
            $title .= ' - ' . $dog_name . ' the ' . $dog_breed;
            $description = 'Success story for ' . $dog_name . ' the ' . $dog_breed . '. ' . $description;
        }
        
        // Output meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . ' | ' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '" />' . "\n";
        }
    }
    
    // Add meta tags to resource pages
    if (is_singular('gdkc_resource')) {
        global $post;
        
        // Get custom fields
        $resource_type = get_field('resource_type', $post->ID);
        $estimated_time = get_field('estimated_time', $post->ID);
        
        // Get categories
        $categories = get_the_terms($post->ID, 'gdkc_resource_category');
        $category_names = '';
        
        if ($categories && !is_wp_error($categories)) {
            $category_arr = array();
            foreach ($categories as $category) {
                $category_arr[] = $category->name;
            }
            $category_names = implode(', ', $category_arr);
        }
        
        // Build description from excerpt or content
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
        
        // Add resource type and categories to description
        if ($resource_type) {
            $description = ucfirst($resource_type) . ' resource: ' . $description;
        }
        
        if ($category_names) {
            $description .= ' Categories: ' . $category_names;
        }
        
        if ($estimated_time) {
            $description .= ' Reading time: ' . $estimated_time;
        }
        
        // Output meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . ' | ' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '" />' . "\n";
        }
    }
    
    // Add meta tags to service area pages
    if (is_singular('gdkc_area') || is_singular('gdkc_service_area')) {
        global $post;
        
        // Get custom fields
        $city = get_field('city', $post->ID);
        $state = get_field('state', $post->ID);
        $zip_code = get_field('zip_code', $post->ID);
        
        // Build location string
        $location = '';
        if ($city && $state) {
            $location = $city . ', ' . $state;
            if ($zip_code) {
                $location .= ' ' . $zip_code;
            }
        }
        
        // Build description from excerpt or content
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30);
        
        // Add location to description
        if ($location) {
            $description = 'Dog training services available in ' . $location . '. ' . $description;
        }
        
        // Build title with location
        $title = get_the_title();
        if ($location) {
            $title .= ' - Dog Training in ' . $location;
        }
        
        // Output meta tags
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:type" content="business.business" />' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '" />' . "\n";
        }
        
        // Add geo metadata if coordinates are available
        $map_coordinates = get_field('map_coordinates', $post->ID);
        if ($map_coordinates && isset($map_coordinates['lat']) && isset($map_coordinates['lng'])) {
            echo '<meta property="place:location:latitude" content="' . esc_attr($map_coordinates['lat']) . '" />' . "\n";
            echo '<meta property="place:location:longitude" content="' . esc_attr($map_coordinates['lng']) . '" />' . "\n";
            echo '<meta property="business:contact_data:locality" content="' . esc_attr($city) . '" />' . "\n";
            echo '<meta property="business:contact_data:region" content="' . esc_attr($state) . '" />' . "\n";
            if ($zip_code) {
                echo '<meta property="business:contact_data:postal_code" content="' . esc_attr($zip_code) . '" />' . "\n";
            }
        }
    }
    
    // Add meta tags to dog assessment page
    if (is_page('dog-behavior-assessment') || is_page('dog-assessment')) {
        $title = get_the_title();
        $description = has_excerpt() ? get_the_excerpt() : 'Complete our comprehensive dog behavior assessment to receive personalized training recommendations for your dog\'s unique needs.';
        
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:title" content="' . esc_attr($title) . ' | ' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
        
        if (has_post_thumbnail()) {
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            echo '<meta property="og:image" content="' . esc_url($thumbnail_url) . '" />' . "\n";
        }
    }
}
add_action('wp_head', 'gdkc_add_seo_metadata', 1);

/**
 * Add Schema.org structured data for custom post types
 */
function gdkc_add_schema_markup() {
    if (is_singular('gdkc_package')) {
        global $post;
        
        // Get package details
        $price = get_field('price', $post->ID);
        $duration = get_field('duration', $post->ID);
        $features = get_field('features', $post->ID);
        
        // Build schema
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
            'url' => get_permalink(),
            'brand' => array(
                '@type' => 'Brand',
                'name' => get_bloginfo('name')
            )
        );
        
        // Add price if available
        if ($price) {
            // Extract just the number from price string
            $price_value = preg_replace('/[^0-9.]/', '', $price);
            if (!empty($price_value)) {
                $schema['offers'] = array(
                    '@type' => 'Offer',
                    'price' => $price_value,
                    'priceCurrency' => 'USD', // Assuming USD, adjust if needed
                    'availability' => 'https://schema.org/InStock',
                    'url' => get_permalink()
                );
            }
        }
        
        // Add features if available
        if ($features && is_array($features)) {
            $schema['additionalProperty'] = array();
            foreach ($features as $feature) {
                if (isset($feature['feature_name'])) {
                    $schema['additionalProperty'][] = array(
                        '@type' => 'PropertyValue',
                        'name' => $feature['feature_name'],
                        'value' => isset($feature['feature_description']) ? $feature['feature_description'] : ''
                    );
                }
            }
        }
        
        // Add image if available
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Output schema
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
    
    // Add schema for success stories
    if (is_singular('gdkc_success')) {
        global $post;
        
        // Get custom fields
        $owner_name = get_field('owner_name', $post->ID);
        $dog_name = get_field('dog_name', $post->ID);
        $dog_breed = get_field('dog_breed', $post->ID);
        $testimonial = get_field('testimonial', $post->ID);
        
        // Build schema
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'itemReviewed' => array(
                '@type' => 'Service',
                'name' => 'Dog Training',
                'provider' => array(
                    '@type' => 'LocalBusiness',
                    'name' => get_bloginfo('name'),
                    'url' => home_url()
                )
            ),
            'reviewRating' => array(
                '@type' => 'Rating',
                'ratingValue' => '5',
                'bestRating' => '5'
            ),
            'url' => get_permalink()
        );
        
        // Add author if available
        if ($owner_name) {
            $schema['author'] = array(
                '@type' => 'Person',
                'name' => $owner_name
            );
        }
        
        // Add review body if available
        if ($testimonial) {
            $schema['reviewBody'] = wp_strip_all_tags($testimonial);
        } else {
            $schema['reviewBody'] = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 60);
        }
        
        // Add dog info if available
        if ($dog_name && $dog_breed) {
            $schema['about'] = array(
                '@type' => 'Thing',
                'name' => $dog_name . ' (' . $dog_breed . ')'
            );
        }
        
        // Add image if available
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Output schema
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
    
    // Add schema for service areas
    if (is_singular('gdkc_area') || is_singular('gdkc_service_area')) {
        global $post;
        
        // Get custom fields
        $city = get_field('city', $post->ID);
        $state = get_field('state', $post->ID);
        $zip_code = get_field('zip_code', $post->ID);
        $map_coordinates = get_field('map_coordinates', $post->ID);
        
        // Build location string
        $location = '';
        if ($city && $state) {
            $location = $city . ', ' . $state;
            if ($zip_code) {
                $location .= ' ' . $zip_code;
            }
        }
        
        // Build schema
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => get_bloginfo('name') . ' - ' . get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
            'url' => get_permalink()
        );
        
        // Add location info if available
        if ($location) {
            $schema['address'] = array(
                '@type' => 'PostalAddress',
                'addressLocality' => $city,
                'addressRegion' => $state
            );
            
            if ($zip_code) {
                $schema['address']['postalCode'] = $zip_code;
            }
        }
        
        // Add geo coordinates if available
        if ($map_coordinates && isset($map_coordinates['lat']) && isset($map_coordinates['lng'])) {
            $schema['geo'] = array(
                '@type' => 'GeoCoordinates',
                'latitude' => $map_coordinates['lat'],
                'longitude' => $map_coordinates['lng']
            );
        }
        
        // Add image if available
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Output schema
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
    }
}
add_action('wp_head', 'gdkc_add_schema_markup', 2);

/**
 * Add SEO-friendly title tags
 */
function gdkc_custom_title_tag($title_parts) {
    if (is_singular('gdkc_package')) {
        global $post;
        
        // Get package details
        $price = get_field('price', $post->ID);
        $duration = get_field('duration', $post->ID);
        
        $title = get_the_title();
        
        // Add price and duration to title
        if ($price && $duration) {
            $title = $title . ' - ' . $price . ' - ' . $duration;
        } elseif ($price) {
            $title = $title . ' - ' . $price;
        } elseif ($duration) {
            $title = $title . ' - ' . $duration;
        }
        
        $title_parts['title'] = $title;
    }
    
    if (is_singular('gdkc_success')) {
        global $post;
        
        // Get custom fields
        $dog_name = get_field('dog_name', $post->ID);
        $dog_breed = get_field('dog_breed', $post->ID);
        
        $title = get_the_title();
        
        // Add dog info to title
        if ($dog_name && $dog_breed) {
            $title = $title . ' - ' . $dog_name . ' the ' . $dog_breed;
        }
        
        $title_parts['title'] = $title;
    }
    
    if (is_singular('gdkc_area') || is_singular('gdkc_service_area')) {
        global $post;
        
        // Get custom fields
        $city = get_field('city', $post->ID);
        $state = get_field('state', $post->ID);
        
        $title = get_the_title();
        
        // Add location to title
        if ($city && $state) {
            $title = $title . ' - Dog Training in ' . $city . ', ' . $state;
        }
        
        $title_parts['title'] = $title;
    }
    
    return $title_parts;
}
add_filter('document_title_parts', 'gdkc_custom_title_tag');

/**
 * Add Google Analytics tracking code
 */
function gdkc_add_google_analytics() {
    $tracking_id = 'G-XXXXXXXXXX'; // Replace with actual tracking ID
    
    if (!empty($tracking_id)) {
        ?>
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($tracking_id); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr($tracking_id); ?>', { 'anonymize_ip': true });
        </script>
        <!-- End Google Analytics -->
        <?php
    }
}
add_action('wp_head', 'gdkc_add_google_analytics', 10);

/**
 * Add canonical URL tag to avoid duplicate content issues
 */
function gdkc_add_canonical_url() {
    if (is_singular()) {
        echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '" />' . "\n";
    } elseif (is_home() || is_front_page()) {
        echo '<link rel="canonical" href="' . esc_url(home_url('/')) . '" />' . "\n";
    } elseif (is_archive()) {
        // Get the current URL
        global $wp;
        $current_url = home_url($wp->request);
        
        // Remove pagination from URL for canonical
        $canonical_url = preg_replace('/\/page\/[0-9]+\/?/', '/', $current_url);
        
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '" />' . "\n";
    }
}
add_action('wp_head', 'gdkc_add_canonical_url', 1);