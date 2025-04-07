<?php
/**
 * ACF Field Groups for Good Dogz KC
 *
 * Registers custom field groups for the theme's custom post types.
 * Requires Advanced Custom Fields plugin.
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if ACF is active
 */
if( !function_exists('acf_add_local_field_group') ) {
    return;
}

/**
 * Register ACF field groups
 */
function gdkc_register_acf_fields() {
    
    /**
     * Training Programs Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_training_programs',
        'title' => 'Training Program Information',
        'fields' => array(
            array(
                'key' => 'field_program_overview',
                'label' => 'Program Overview',
                'name' => 'program_overview',
                'type' => 'textarea',
                'instructions' => 'Provide a brief overview of the training program',
                'required' => 1,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
            ),
            array(
                'key' => 'field_program_benefits',
                'label' => 'Benefits',
                'name' => 'program_benefits',
                'type' => 'repeater',
                'instructions' => 'Add benefits of this training program',
                'required' => 0,
                'min' => 2,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Benefit',
                'sub_fields' => array(
                    array(
                        'key' => 'field_benefit_title',
                        'label' => 'Benefit Title',
                        'name' => 'benefit_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_benefit_description',
                        'label' => 'Benefit Description',
                        'name' => 'benefit_description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 0,
                    ),
                ),
            ),
            array(
                'key' => 'field_program_who_for',
                'label' => 'Who Is This For',
                'name' => 'program_who_for',
                'type' => 'wysiwyg',
                'instructions' => 'Describe who this program is best suited for',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_program_steps',
                'label' => 'Process Steps',
                'name' => 'program_steps',
                'type' => 'repeater',
                'instructions' => 'Add the steps of this training program',
                'required' => 0,
                'min' => 1,
                'max' => 8,
                'layout' => 'row',
                'button_label' => 'Add Step',
                'sub_fields' => array(
                    array(
                        'key' => 'field_step_number',
                        'label' => 'Step Number',
                        'name' => 'step_number',
                        'type' => 'number',
                        'required' => 1,
                        'min' => 1,
                        'max' => 10,
                    ),
                    array(
                        'key' => 'field_step_title',
                        'label' => 'Step Title',
                        'name' => 'step_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_step_description',
                        'label' => 'Step Description',
                        'name' => 'step_description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 0,
                    ),
                ),
            ),
            array(
                'key' => 'field_program_pricing',
                'label' => 'Pricing Information',
                'name' => 'program_pricing',
                'type' => 'group',
                'instructions' => 'Set pricing for this program',
                'required' => 0,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_pricing_4_session',
                        'label' => '4-Session Price',
                        'name' => 'pricing_4_session',
                        'type' => 'number',
                        'instructions' => 'Price for 4-session package',
                        'required' => 0,
                        'min' => 0,
                        'prepend' => '$',
                    ),
                    array(
                        'key' => 'field_pricing_6_session',
                        'label' => '6-Session Price',
                        'name' => 'pricing_6_session',
                        'type' => 'number',
                        'instructions' => 'Price for 6-session package',
                        'required' => 0,
                        'min' => 0,
                        'prepend' => '$',
                    ),
                    array(
                        'key' => 'field_pricing_8_session',
                        'label' => '8-Session Price',
                        'name' => 'pricing_8_session',
                        'type' => 'number',
                        'instructions' => 'Price for 8-session package',
                        'required' => 0,
                        'min' => 0,
                        'prepend' => '$',
                    ),
                    array(
                        'key' => 'field_pricing_custom',
                        'label' => 'Custom Package Info',
                        'name' => 'pricing_custom',
                        'type' => 'text',
                        'instructions' => 'Information about custom pricing if available',
                        'required' => 0,
                    ),
                ),
            ),
            array(
                'key' => 'field_program_featured',
                'label' => 'Featured Program',
                'name' => 'program_featured',
                'type' => 'true_false',
                'instructions' => 'Mark this program as featured',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_program_details',
                'label' => 'Program Details',
                'name' => 'program_details',
                'type' => 'group',
                'instructions' => 'Additional details about this program',
                'required' => 0,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_program_duration',
                        'label' => 'Duration',
                        'name' => 'program_duration',
                        'type' => 'text',
                        'instructions' => 'Total duration of the program (e.g., "4-6 weeks")',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'field_program_frequency',
                        'label' => 'Session Frequency',
                        'name' => 'program_frequency',
                        'type' => 'text',
                        'instructions' => 'How often sessions occur (e.g., "Weekly, then bi-weekly")',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'field_program_location',
                        'label' => 'Location',
                        'name' => 'program_location',
                        'type' => 'text',
                        'instructions' => 'Where training takes place',
                        'required' => 0,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gdkc_training',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Custom fields for Training Programs',
    ));
    
    /**
     * Service Package Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_service_packages',
        'title' => 'Package Information',
        'fields' => array(
            array(
                'key' => 'field_package_regular_price',
                'label' => 'Regular Price',
                'name' => 'package_regular_price',
                'type' => 'number',
                'instructions' => 'Regular price of this package',
                'required' => 1,
                'min' => 0,
                'prepend' => '$',
            ),
            array(
                'key' => 'field_package_sale_price',
                'label' => 'Sale Price',
                'name' => 'package_sale_price',
                'type' => 'number',
                'instructions' => 'Sale price (if applicable)',
                'required' => 0,
                'min' => 0,
                'prepend' => '$',
            ),
            array(
                'key' => 'field_package_sessions',
                'label' => 'Number of Sessions',
                'name' => 'package_sessions',
                'type' => 'number',
                'instructions' => 'How many training sessions are included',
                'required' => 1,
                'min' => 1,
                'max' => 20,
                'default_value' => 4,
            ),
            array(
                'key' => 'field_package_duration',
                'label' => 'Duration in Weeks',
                'name' => 'package_duration',
                'type' => 'number',
                'instructions' => 'Total duration of the package in weeks',
                'required' => 1,
                'min' => 1,
                'max' => 52,
                'default_value' => 4,
            ),
            array(
                'key' => 'field_package_features',
                'label' => 'Features Included',
                'name' => 'package_features',
                'type' => 'repeater',
                'instructions' => 'Add features included in this package',
                'required' => 0,
                'min' => 0,
                'max' => 12,
                'layout' => 'table',
                'button_label' => 'Add Feature',
                'sub_fields' => array(
                    array(
                        'key' => 'field_feature_text',
                        'label' => 'Feature',
                        'name' => 'feature_text',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_feature_included',
                        'label' => 'Included',
                        'name' => 'feature_included',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                    ),
                ),
            ),
            array(
                'key' => 'field_package_popular',
                'label' => 'Popular Package',
                'name' => 'package_popular',
                'type' => 'true_false',
                'instructions' => 'Mark this package as most popular',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_package_additional_info',
                'label' => 'Additional Information',
                'name' => 'package_additional_info',
                'type' => 'wysiwyg',
                'instructions' => 'Any additional information about this package',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_package_button_text',
                'label' => 'Button Text',
                'name' => 'package_button_text',
                'type' => 'text',
                'instructions' => 'Text for the package button',
                'required' => 0,
                'default_value' => 'Book Now',
            ),
            array(
                'key' => 'field_package_button_url',
                'label' => 'Button URL',
                'name' => 'package_button_url',
                'type' => 'url',
                'instructions' => 'URL for the package button',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gdkc_package',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Custom fields for Service Packages',
    ));
    
    /**
     * Success Stories Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_success_stories',
        'title' => 'Success Story Details',
        'fields' => array(
            array(
                'key' => 'field_client_name',
                'label' => 'Client Name',
                'name' => 'client_name',
                'type' => 'text',
                'instructions' => 'Name of the client',
                'required' => 1,
            ),
            array(
                'key' => 'field_dog_name',
                'label' => 'Dog Name',
                'name' => 'dog_name',
                'type' => 'text',
                'instructions' => 'Name of the dog',
                'required' => 1,
            ),
            array(
                'key' => 'field_before_situation',
                'label' => 'Before Situation',
                'name' => 'before_situation',
                'type' => 'textarea',
                'instructions' => 'Describe the situation before training',
                'required' => 1,
                'rows' => 4,
            ),
            array(
                'key' => 'field_after_results',
                'label' => 'After Results',
                'name' => 'after_results',
                'type' => 'textarea',
                'instructions' => 'Describe the results after training',
                'required' => 1,
                'rows' => 4,
            ),
            array(
                'key' => 'field_testimonial_quote',
                'label' => 'Testimonial Quote',
                'name' => 'testimonial_quote',
                'type' => 'textarea',
                'instructions' => 'A quote from the client',
                'required' => 0,
                'rows' => 4,
            ),
            array(
                'key' => 'field_star_rating',
                'label' => 'Star Rating',
                'name' => 'star_rating',
                'type' => 'number',
                'instructions' => 'Rating out of 5 stars',
                'required' => 0,
                'min' => 1,
                'max' => 5,
                'default_value' => 5,
            ),
            array(
                'key' => 'field_before_after_images',
                'label' => 'Before/After Images',
                'name' => 'before_after_images',
                'type' => 'gallery',
                'instructions' => 'Upload before and after images',
                'required' => 0,
                'min' => 0,
                'max' => 10,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            array(
                'key' => 'field_video_testimonial',
                'label' => 'Video Testimonial',
                'name' => 'video_testimonial',
                'type' => 'url',
                'instructions' => 'URL to a video testimonial',
                'required' => 0,
            ),
            array(
                'key' => 'field_featured_success',
                'label' => 'Feature this Success Story',
                'name' => 'featured_success',
                'type' => 'true_false',
                'instructions' => 'Feature this success story on the homepage',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gdkc_success',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Custom fields for Success Stories',
    ));
    
    /**
     * Resources Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_resources',
        'title' => 'Resource Details',
        'fields' => array(
            array(
                'key' => 'field_resource_summary',
                'label' => 'Resource Summary',
                'name' => 'resource_summary',
                'type' => 'textarea',
                'instructions' => 'A brief summary of this resource',
                'required' => 1,
                'rows' => 3,
            ),
            array(
                'key' => 'field_resource_difficulty',
                'label' => 'Difficulty Level',
                'name' => 'resource_difficulty',
                'type' => 'select',
                'instructions' => 'Select the difficulty level',
                'required' => 0,
                'choices' => array(
                    'beginner' => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced' => 'Advanced',
                ),
                'default_value' => 'beginner',
            ),
            array(
                'key' => 'field_resource_files',
                'label' => 'Downloadable Files',
                'name' => 'resource_files',
                'type' => 'repeater',
                'instructions' => 'Add downloadable files for this resource',
                'required' => 0,
                'min' => 0,
                'max' => 5,
                'layout' => 'table',
                'button_label' => 'Add File',
                'sub_fields' => array(
                    array(
                        'key' => 'field_file_title',
                        'label' => 'File Title',
                        'name' => 'file_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_file',
                        'label' => 'File',
                        'name' => 'file',
                        'type' => 'file',
                        'required' => 1,
                        'return_format' => 'array',
                        'library' => 'all',
                    ),
                    array(
                        'key' => 'field_file_description',
                        'label' => 'Description',
                        'name' => 'file_description',
                        'type' => 'text',
                        'required' => 0,
                    ),
                ),
            ),
            array(
                'key' => 'field_resource_video',
                'label' => 'Video URL',
                'name' => 'resource_video',
                'type' => 'url',
                'instructions' => 'URL to a video for this resource',
                'required' => 0,
            ),
            array(
                'key' => 'field_resource_related',
                'label' => 'Related Resources',
                'name' => 'resource_related',
                'type' => 'relationship',
                'instructions' => 'Select related resources',
                'required' => 0,
                'post_type' => array(
                    0 => 'gdkc_resource',
                ),
                'min' => 0,
                'max' => 3,
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_resource_featured',
                'label' => 'Feature this Resource',
                'name' => 'resource_featured',
                'type' => 'true_false',
                'instructions' => 'Feature this resource on the resources page',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gdkc_resource',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Custom fields for Training Resources',
    ));
    
    /**
     * Service Areas Field Group
     */
    acf_add_local_field_group(array(
        'key' => 'group_service_areas',
        'title' => 'Service Area Details',
        'fields' => array(
            array(
                'key' => 'field_service_zipcodes',
                'label' => 'Zip Codes Covered',
                'name' => 'service_zipcodes',
                'type' => 'textarea',
                'instructions' => 'List of zip codes covered in this service area (comma separated)',
                'required' => 0,
                'rows' => 3,
            ),
            array(
                'key' => 'field_travel_fee',
                'label' => 'Travel Fee Amount',
                'name' => 'travel_fee',
                'type' => 'number',
                'instructions' => 'Travel fee amount (if applicable)',
                'required' => 0,
                'min' => 0,
                'prepend' => '$',
            ),
            array(
                'key' => 'field_travel_time',
                'label' => 'Travel Time',
                'name' => 'travel_time',
                'type' => 'text',
                'instructions' => 'Approximate travel time (e.g., "30-45 minutes")',
                'required' => 0,
            ),
            array(
                'key' => 'field_map_embed',
                'label' => 'Google Maps Embed',
                'name' => 'map_embed',
                'type' => 'textarea',
                'instructions' => 'Paste Google Maps embed code',
                'required' => 0,
                'rows' => 4,
            ),
            array(
                'key' => 'field_area_coordinates',
                'label' => 'Area Coordinates',
                'name' => 'area_coordinates',
                'type' => 'group',
                'instructions' => 'Coordinates for this service area',
                'required' => 0,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'field_latitude',
                        'label' => 'Latitude',
                        'name' => 'latitude',
                        'type' => 'text',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'field_longitude',
                        'label' => 'Longitude',
                        'name' => 'longitude',
                        'type' => 'text',
                        'required' => 0,
                    ),
                ),
            ),
            array(
                'key' => 'field_area_notes',
                'label' => 'Service Area Notes',
                'name' => 'area_notes',
                'type' => 'wysiwyg',
                'instructions' => 'Additional notes about this service area',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gdkc_service_area',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Custom fields for Service Areas',
    ));
}
add_action('acf/init', 'gdkc_register_acf_fields');

/**
 * Admin notice if ACF plugin is not active
 */
function gdkc_acf_admin_notice() {
    if ( ! class_exists('ACF') ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php _e( 'The Good Dogz KC theme requires the Advanced Custom Fields plugin to be installed and activated for full functionality.', 'gooddogzkc-twentytwentyfour-child' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'gdkc_acf_admin_notice' );