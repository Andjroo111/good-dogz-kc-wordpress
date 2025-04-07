<?php
/**
 * Schema.org Structured Data Integration
 *
 * Adds schema.org structured data to the website for better SEO
 *
 * @package Good_Dogz_KC
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class for handling Schema.org structured data
 */
class GDKC_Schema_Markup {
    /**
     * Initialize the class
     */
    public function __construct() {
        // Add schema for entire site
        add_action('wp_head', [$this, 'add_global_schema']);
        
        // Add conditional schemas based on page type
        add_action('wp_head', [$this, 'add_conditional_schema']);
    }
    
    /**
     * Add global schema markup for the entire site
     */
    public function add_global_schema() {
        // Get company info from options
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        $company_logo = get_field('company_logo', 'option');
        $company_address = get_field('company_address', 'option');
        $company_phone = get_field('company_phone', 'option');
        $company_email = get_field('company_email', 'option');
        $social_profiles = get_field('social_profiles', 'option');
        
        // Base Organization schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $company_name,
            'url' => home_url('/'),
        ];
        
        // Add logo if available
        if ($company_logo) {
            $schema['logo'] = $company_logo['url'];
            $schema['image'] = $company_logo['url'];
        }
        
        // Add address if available
        if ($company_address) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $company_address['street'] ?? '',
                'addressLocality' => $company_address['city'] ?? '',
                'addressRegion' => $company_address['state'] ?? '',
                'postalCode' => $company_address['zip'] ?? '',
                'addressCountry' => $company_address['country'] ?? 'US',
            ];
        }
        
        // Add contact info
        if ($company_phone) {
            $schema['telephone'] = $company_phone;
        }
        
        if ($company_email) {
            $schema['email'] = $company_email;
        }
        
        // Add social profiles
        if ($social_profiles && is_array($social_profiles)) {
            $schema['sameAs'] = [];
            
            foreach ($social_profiles as $profile) {
                if (!empty($profile['url'])) {
                    $schema['sameAs'][] = $profile['url'];
                }
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add conditional schema markup based on page type
     */
    public function add_conditional_schema() {
        if (is_front_page()) {
            $this->add_homepage_schema();
        } elseif (is_singular('gdkc_package')) {
            $this->add_package_schema();
        } elseif (is_singular('gdkc_success')) {
            $this->add_success_story_schema();
        } elseif (is_singular('gdkc_resource')) {
            $this->add_resource_schema();
        } elseif (is_singular('gdkc_area') || is_singular('gdkc_service_area')) {
            $this->add_service_area_schema();
        } elseif (is_page('contact')) {
            $this->add_contact_page_schema();
        } elseif (is_page('about') || is_page('about-us')) {
            $this->add_about_page_schema();
        } elseif (is_archive() || is_home() || is_category() || is_tag()) {
            $this->add_listing_page_schema();
        }
    }
    
    /**
     * Add schema markup for the homepage
     */
    private function add_homepage_schema() {
        // Get company info from options
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        $company_description = get_field('company_description', 'option') ?: get_bloginfo('description');
        $company_logo = get_field('company_logo', 'option');
        $locations = get_field('service_locations', 'option');
        
        // LocalBusiness schema for dog training service
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $company_name,
            'description' => $company_description,
            'url' => home_url('/'),
            'priceRange' => '$$ - $$$',
            '@id' => home_url('/') . '#localbusiness',
        ];
        
        // Additional business types
        $schema['additionalType'] = [
            'https://schema.org/ProfessionalService',
            'https://schema.org/AnimalShelter'
        ];
        
        // Add logo if available
        if ($company_logo) {
            $schema['logo'] = $company_logo['url'];
            $schema['image'] = $company_logo['url'];
        }
        
        // Add location info
        if ($locations && is_array($locations)) {
            $schema['location'] = [];
            $schema['areaServed'] = [];
            
            foreach ($locations as $location) {
                // Add address
                $schema['location'][] = [
                    '@type' => 'Place',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $location['address']['street'] ?? '',
                        'addressLocality' => $location['address']['city'] ?? '',
                        'addressRegion' => $location['address']['state'] ?? '',
                        'postalCode' => $location['address']['zip'] ?? '',
                        'addressCountry' => 'US',
                    ]
                ];
                
                // Add area served
                $schema['areaServed'][] = [
                    '@type' => 'GeoCircle',
                    'geoMidpoint' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => $location['coordinates']['lat'] ?? '',
                        'longitude' => $location['coordinates']['lng'] ?? '',
                    ],
                    'geoRadius' => $location['radius'] ? ($location['radius'] * 1609.34) : 24140, // Convert miles to meters, default 15 miles
                ];
            }
        }
        
        // Get services from service packages
        $service_packages = get_posts([
            'post_type' => 'gdkc_package',
            'posts_per_page' => 5,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);
        
        if ($service_packages) {
            $schema['makesOffer'] = [];
            
            foreach ($service_packages as $package) {
                $price = get_field('price', $package->ID);
                $price_value = preg_replace('/[^0-9.]/', '', $price);
                
                $offer = [
                    '@type' => 'Offer',
                    'name' => $package->post_title,
                    'description' => wp_trim_words(get_the_excerpt($package), 30),
                    'url' => get_permalink($package->ID),
                ];
                
                if (!empty($price_value)) {
                    $offer['price'] = $price_value;
                    $offer['priceCurrency'] = 'USD';
                }
                
                $schema['makesOffer'][] = $offer;
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
        
        // Add webpage schema
        $webpage_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => home_url('/') . '#webpage',
            'url' => home_url('/'),
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'isPartOf' => [
                '@id' => home_url('/') . '#website'
            ],
            'inLanguage' => 'en-US',
            'potentialAction' => [
                [
                    '@type' => 'ReadAction',
                    'target' => [home_url('/')],
                ]
            ]
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($webpage_schema) . '</script>';
    }
    
    /**
     * Add schema markup for service package pages
     */
    private function add_package_schema() {
        global $post;
        
        // Get package details
        $price = get_field('price', $post->ID);
        $duration = get_field('duration', $post->ID);
        $features = get_field('features', $post->ID);
        
        // Extract price value
        $price_value = '';
        if ($price) {
            $price_value = preg_replace('/[^0-9.]/', '', $price);
        }
        
        // Service schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
            'url' => get_permalink(),
            'provider' => [
                '@type' => 'LocalBusiness',
                '@id' => home_url('/') . '#localbusiness',
                'name' => get_bloginfo('name'),
                'url' => home_url('/')
            ],
            'serviceType' => 'Dog Training'
        ];
        
        // Add image if available
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Add offer with price if available
        if (!empty($price_value)) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $price_value,
                'priceCurrency' => 'USD',
                'availability' => 'https://schema.org/InStock',
                'url' => get_permalink()
            ];
            
            if ($duration) {
                $schema['offers']['description'] = 'Duration: ' . $duration;
            }
        }
        
        // Add features/benefits
        if ($features && is_array($features)) {
            $schema['serviceOutput'] = [];
            
            foreach ($features as $feature) {
                if (isset($feature['feature_name'])) {
                    $schema['serviceOutput'][] = [
                        '@type' => 'Thing',
                        'name' => $feature['feature_name'],
                        'description' => isset($feature['feature_description']) ? $feature['feature_description'] : ''
                    ];
                }
            }
        }
        
        // Add package taxonomy terms as service categories
        $package_types = get_the_terms($post->ID, 'package_type');
        if ($package_types && !is_wp_error($package_types)) {
            $schema['category'] = [];
            
            foreach ($package_types as $type) {
                $schema['category'][] = $type->name;
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for success story pages
     */
    private function add_success_story_schema() {
        global $post;
        
        // Get success story details
        $owner_name = get_field('owner_name', $post->ID);
        $dog_name = get_field('dog_name', $post->ID);
        $dog_breed = get_field('dog_breed', $post->ID);
        $testimonial = get_field('testimonial', $post->ID);
        $rating = get_field('rating', $post->ID) ?: 5;
        
        // Review schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Review',
            'itemReviewed' => [
                '@type' => 'Service',
                'name' => 'Dog Training',
                'provider' => [
                    '@type' => 'LocalBusiness',
                    '@id' => home_url('/') . '#localbusiness',
                    'name' => get_bloginfo('name'),
                    'url' => home_url('/')
                ]
            ],
            'reviewRating' => [
                '@type' => 'Rating',
                'ratingValue' => $rating,
                'bestRating' => '5'
            ],
            'url' => get_permalink()
        ];
        
        // Add review body
        if ($testimonial) {
            $schema['reviewBody'] = wp_strip_all_tags($testimonial);
        } else {
            $schema['reviewBody'] = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 60);
        }
        
        // Add author
        if ($owner_name) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $owner_name
            ];
        } else {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => get_the_title()
            ];
        }
        
        // Add publication date
        $schema['datePublished'] = get_the_date('c');
        
        // Add image
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Add dog information
        if ($dog_name && $dog_breed) {
            $schema['about'] = [
                '@type' => 'Thing',
                'name' => $dog_name,
                'description' => $dog_breed . ' dog'
            ];
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for resource pages
     */
    private function add_resource_schema() {
        global $post;
        
        // Get resource details
        $resource_type = get_field('resource_type', $post->ID);
        $estimated_time = get_field('estimated_time', $post->ID);
        
        // Determine schema type based on resource type
        $schema_type = 'Article';
        if ($resource_type == 'Video') {
            $schema_type = 'VideoObject';
        } elseif ($resource_type == 'Guide') {
            $schema_type = 'HowTo';
        }
        
        // Base schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $schema_type,
            'headline' => get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
            'url' => get_permalink(),
            'author' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url('/')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url('/')
            ],
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c')
        ];
        
        // Add image
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Add estimated reading time
        if ($estimated_time && $schema_type === 'Article') {
            $schema['timeRequired'] = 'PT' . preg_replace('/[^0-9]/', '', $estimated_time) . 'M';
        }
        
        // For HowTo type, add additional fields
        if ($schema_type === 'HowTo') {
            // Get steps from ACF repeater if available
            $steps = get_field('guide_steps', $post->ID);
            
            if ($steps && is_array($steps)) {
                $schema['step'] = [];
                
                foreach ($steps as $index => $step) {
                    $schema['step'][] = [
                        '@type' => 'HowToStep',
                        'name' => $step['step_title'],
                        'text' => $step['step_content'],
                        'position' => $index + 1
                    ];
                }
            }
        }
        
        // For VideoObject type, add additional fields
        if ($schema_type === 'VideoObject') {
            $video_url = get_field('video_url', $post->ID);
            $video_thumbnail = get_field('video_thumbnail', $post->ID);
            $video_duration = get_field('video_duration', $post->ID);
            
            if ($video_url) {
                $schema['contentUrl'] = $video_url;
                $schema['embedUrl'] = $video_url;
            }
            
            if ($video_thumbnail) {
                $schema['thumbnailUrl'] = $video_thumbnail['url'];
            } elseif (has_post_thumbnail()) {
                $schema['thumbnailUrl'] = get_the_post_thumbnail_url($post->ID, 'full');
            }
            
            if ($video_duration) {
                // Convert MM:SS format to ISO 8601 duration
                $parts = explode(':', $video_duration);
                if (count($parts) === 2) {
                    $minutes = (int)$parts[0];
                    $seconds = (int)$parts[1];
                    $schema['duration'] = 'PT' . $minutes . 'M' . $seconds . 'S';
                }
            }
        }
        
        // Add resource taxonomy terms as keywords
        $resource_topics = get_the_terms($post->ID, 'resource_topic');
        if ($resource_topics && !is_wp_error($resource_topics)) {
            $schema['keywords'] = [];
            
            foreach ($resource_topics as $topic) {
                $schema['keywords'][] = $topic->name;
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for service area pages
     */
    private function add_service_area_schema() {
        global $post;
        
        // Get service area details
        $city = get_field('city', $post->ID);
        $state = get_field('state', $post->ID);
        $zip_code = get_field('zip_code', $post->ID);
        $map_coordinates = get_field('map_coordinates', $post->ID);
        $service_radius = get_field('service_radius', $post->ID);
        
        // LocalBusiness schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => get_bloginfo('name') . ' - ' . get_the_title(),
            'description' => has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 30),
            'url' => get_permalink(),
            'priceRange' => '$$ - $$$',
            'additionalType' => [
                'https://schema.org/ProfessionalService',
                'https://schema.org/AnimalShelter'
            ]
        ];
        
        // Add address
        if ($city && $state) {
            $schema['address'] = [
                '@type' => 'PostalAddress',
                'addressLocality' => $city,
                'addressRegion' => $state
            ];
            
            if ($zip_code) {
                $schema['address']['postalCode'] = $zip_code;
            }
        }
        
        // Add service area
        if ($map_coordinates && isset($map_coordinates['lat']) && isset($map_coordinates['lng'])) {
            $schema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $map_coordinates['lat'],
                'longitude' => $map_coordinates['lng']
            ];
            
            if ($service_radius) {
                $schema['areaServed'] = [
                    '@type' => 'GeoCircle',
                    'geoMidpoint' => [
                        '@type' => 'GeoCoordinates',
                        'latitude' => $map_coordinates['lat'],
                        'longitude' => $map_coordinates['lng']
                    ],
                    'geoRadius' => $service_radius * 1609.34 // Convert miles to meters
                ];
            }
        }
        
        // Add image
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'full');
        }
        
        // Get services from ACF repeater
        $primary_services = get_field('primary_services', $post->ID);
        
        if ($primary_services && is_array($primary_services)) {
            $schema['makesOffer'] = [];
            
            foreach ($primary_services as $service) {
                if (isset($service['service_name'])) {
                    $offer = [
                        '@type' => 'Offer',
                        'name' => $service['service_name']
                    ];
                    
                    if (isset($service['service_description'])) {
                        $offer['description'] = $service['service_description'];
                    }
                    
                    if (isset($service['service_price'])) {
                        $price_value = preg_replace('/[^0-9.]/', '', $service['service_price']);
                        if (!empty($price_value)) {
                            $offer['price'] = $price_value;
                            $offer['priceCurrency'] = 'USD';
                        }
                    }
                    
                    $schema['makesOffer'][] = $offer;
                }
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for the contact page
     */
    private function add_contact_page_schema() {
        // Get company info from options
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        $company_address = get_field('company_address', 'option');
        $company_phone = get_field('company_phone', 'option');
        $company_email = get_field('company_email', 'option');
        $opening_hours = get_field('opening_hours', 'option');
        
        // ContactPage schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => 'Contact ' . $company_name,
            'description' => 'Contact information for ' . $company_name,
            'url' => get_permalink(),
            'mainEntity' => [
                '@type' => 'LocalBusiness',
                '@id' => home_url('/') . '#localbusiness',
                'name' => $company_name,
                'url' => home_url('/')
            ]
        ];
        
        // Add contact points
        $schema['mainEntity']['contactPoint'] = [
            '@type' => 'ContactPoint',
            'contactType' => 'customer service'
        ];
        
        if ($company_phone) {
            $schema['mainEntity']['contactPoint']['telephone'] = $company_phone;
        }
        
        if ($company_email) {
            $schema['mainEntity']['contactPoint']['email'] = $company_email;
        }
        
        // Add address
        if ($company_address) {
            $schema['mainEntity']['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $company_address['street'] ?? '',
                'addressLocality' => $company_address['city'] ?? '',
                'addressRegion' => $company_address['state'] ?? '',
                'postalCode' => $company_address['zip'] ?? '',
                'addressCountry' => $company_address['country'] ?? 'US'
            ];
        }
        
        // Add opening hours
        if ($opening_hours && is_array($opening_hours)) {
            $schema['mainEntity']['openingHoursSpecification'] = [];
            
            foreach ($opening_hours as $hours) {
                if (isset($hours['days']) && isset($hours['time'])) {
                    $schema['mainEntity']['openingHoursSpecification'][] = [
                        '@type' => 'OpeningHoursSpecification',
                        'dayOfWeek' => $hours['days'],
                        'opens' => $hours['time']['open'] ?? '',
                        'closes' => $hours['time']['close'] ?? ''
                    ];
                }
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for the about page
     */
    private function add_about_page_schema() {
        // Get company info from options
        $company_name = get_field('company_name', 'option') ?: get_bloginfo('name');
        $company_description = get_field('company_description', 'option') ?: get_bloginfo('description');
        $company_founding_date = get_field('founding_date', 'option');
        $company_founders = get_field('founders', 'option');
        
        // AboutPage schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'About ' . $company_name,
            'description' => $company_description,
            'url' => get_permalink(),
            'mainEntity' => [
                '@type' => 'Organization',
                '@id' => home_url('/') . '#organization',
                'name' => $company_name,
                'url' => home_url('/')
            ]
        ];
        
        // Add founding date
        if ($company_founding_date) {
            $schema['mainEntity']['foundingDate'] = $company_founding_date;
        }
        
        // Add founders
        if ($company_founders && is_array($company_founders)) {
            $schema['mainEntity']['founder'] = [];
            
            foreach ($company_founders as $founder) {
                if (isset($founder['name'])) {
                    $person = [
                        '@type' => 'Person',
                        'name' => $founder['name']
                    ];
                    
                    if (isset($founder['title'])) {
                        $person['jobTitle'] = $founder['title'];
                    }
                    
                    if (isset($founder['bio'])) {
                        $person['description'] = $founder['bio'];
                    }
                    
                    if (isset($founder['image'])) {
                        $person['image'] = $founder['image']['url'];
                    }
                    
                    $schema['mainEntity']['founder'][] = $person;
                }
            }
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
    
    /**
     * Add schema markup for archive/listing pages
     */
    private function add_listing_page_schema() {
        // Get page title
        $title = '';
        
        if (is_home()) {
            $title = 'Blog';
        } elseif (is_archive()) {
            $title = get_the_archive_title();
        } elseif (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        }
        
        // CollectionPage schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $title,
            'description' => get_the_archive_description() ?: 'Listing of ' . $title,
            'url' => get_the_permalink(),
            'isPartOf' => [
                '@id' => home_url('/') . '#website'
            ]
        ];
        
        // Add items if we have posts
        if (have_posts()) {
            $schema['mainEntity'] = [
                '@type' => 'ItemList',
                'itemListElement' => []
            ];
            
            $post_index = 0;
            
            while (have_posts()) {
                the_post();
                global $post;
                
                $post_index++;
                
                $schema['mainEntity']['itemListElement'][] = [
                    '@type' => 'ListItem',
                    'position' => $post_index,
                    'url' => get_permalink(),
                    'name' => get_the_title()
                ];
            }
            
            // Reset post data
            rewind_posts();
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    }
}

// Initialize the class
new GDKC_Schema_Markup();