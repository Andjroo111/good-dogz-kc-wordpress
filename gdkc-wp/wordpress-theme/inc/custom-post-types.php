<?php
/**
 * Custom Post Types and Taxonomies for Good Dogz KC
 *
 * Registers custom post types and taxonomies for the theme.
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
 * Register Custom Post Types and Taxonomies
 */
function gdkc_register_post_types() {
    
    // Register Training Programs Custom Post Type
    register_post_type( 'gdkc_training', array(
        'labels' => array(
            'name'               => _x( 'Training Programs', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Training Program', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Training Programs', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Training Program', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'training program', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Training Program', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Training Program', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Training Program', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Training Program', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Training Programs', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Training Programs', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Training Programs:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No training programs found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No training programs found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        ),
        'description'         => __( 'Dog training programs and services', 'gooddogzkc-twentytwentyfour-child' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'training-programs' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-pets',
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );

    // Register Service Packages Custom Post Type
    register_post_type( 'gdkc_package', array(
        'labels' => array(
            'name'               => _x( 'Service Packages', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Service Package', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Service Packages', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Service Package', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'service package', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Service Package', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Service Package', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Service Package', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Service Package', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Service Packages', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Service Packages', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Service Packages:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No service packages found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No service packages found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        ),
        'description'         => __( 'Service packages with pricing information', 'gooddogzkc-twentytwentyfour-child' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'service-packages' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-tag',
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );

    // Register Success Stories Custom Post Type
    register_post_type( 'gdkc_success', array(
        'labels' => array(
            'name'               => _x( 'Success Stories', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Success Story', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Success Stories', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Success Story', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'success story', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Success Story', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Success Story', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Success Story', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Success Story', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Success Stories', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Success Stories', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Success Stories:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No success stories found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No success stories found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        ),
        'description'         => __( 'Client testimonials and success stories', 'gooddogzkc-twentytwentyfour-child' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'success-stories' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-awards',
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );

    // Register Training Resources Custom Post Type
    register_post_type( 'gdkc_resource', array(
        'labels' => array(
            'name'               => _x( 'Training Resources', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Training Resource', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Resources', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'resource', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Resource', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Resource', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Resource', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Resource', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Resources', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Resources', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Resources:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No resources found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No resources found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        ),
        'description'         => __( 'Educational resources and training guides', 'gooddogzkc-twentytwentyfour-child' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'resources' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 23,
        'menu_icon'           => 'dashicons-book-alt',
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );

    // Register Service Areas Custom Post Type
    register_post_type( 'gdkc_service_area', array(
        'labels' => array(
            'name'               => _x( 'Service Areas', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Service Area', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Service Areas', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Service Area', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'service area', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Service Area', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Service Area', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Service Area', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Service Area', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Service Areas', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Service Areas', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Service Areas:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No service areas found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No service areas found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        ),
        'description'         => __( 'Geographic service areas', 'gooddogzkc-twentytwentyfour-child' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'service-areas' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 24,
        'menu_icon'           => 'dashicons-location-alt',
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );
    
    // Register Program Type Taxonomy (hierarchical, like categories)
    register_taxonomy( 'program_type', 'gdkc_training', array(
        'labels' => array(
            'name'              => _x( 'Program Types', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Program Type', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Program Types', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Program Types', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Program Type', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Program Type:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Program Type', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Program Type', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Program Type', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Program Type Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Program Types', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'program-types' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Training Focus Taxonomy (non-hierarchical, like tags)
    register_taxonomy( 'training_focus', 'gdkc_training', array(
        'labels' => array(
            'name'                       => _x( 'Training Focus', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Training Focus', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Training Focus Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate training focus with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove training focus', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used training focus', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Training Focus', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'training-focus' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Behavior Issues Taxonomy (hierarchical)
    register_taxonomy( 'behavior_issue', 'gdkc_training', array(
        'labels' => array(
            'name'              => _x( 'Behavior Issues', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Behavior Issue', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Behavior Issues', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Behavior Issues', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Behavior Issue', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Behavior Issue:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Behavior Issue', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Behavior Issue', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Behavior Issue', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Behavior Issue Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Behavior Issues', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'behavior-issues' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Program Duration Taxonomy (non-hierarchical)
    register_taxonomy( 'program_duration', 'gdkc_training', array(
        'labels' => array(
            'name'                       => _x( 'Program Duration', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Program Duration', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Program Durations', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Program Durations', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Program Durations', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Program Duration', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Program Duration', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Program Duration', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Program Duration Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate program durations with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove program durations', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used program durations', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Program Durations', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'program-durations' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Package Type Taxonomy (hierarchical)
    register_taxonomy( 'package_type', 'gdkc_package', array(
        'labels' => array(
            'name'              => _x( 'Package Types', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Package Type', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Package Types', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Package Types', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Package Type', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Package Type:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Package Type', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Package Type', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Package Type', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Package Type Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Package Types', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'package-types' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Included Services Taxonomy (non-hierarchical)
    register_taxonomy( 'included_service', 'gdkc_package', array(
        'labels' => array(
            'name'                       => _x( 'Included Services', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Included Service', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Included Services', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Included Services', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Included Services', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Included Service', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Included Service', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Included Service', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Included Service Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate included services with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove included services', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used included services', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Included Services', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'included-services' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Issues Addressed Taxonomy (non-hierarchical) for Success Stories
    register_taxonomy( 'issue_addressed', 'gdkc_success', array(
        'labels' => array(
            'name'                       => _x( 'Issues Addressed', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Issue Addressed', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Issues Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Issues Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Issues Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Issue Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Issue Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Issue Addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Issue Addressed Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate issues addressed with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove issues addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used issues addressed', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Issues Addressed', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'issues-addressed' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Program Used Taxonomy (hierarchical) for Success Stories
    register_taxonomy( 'program_used', 'gdkc_success', array(
        'labels' => array(
            'name'              => _x( 'Programs Used', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Program Used', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Programs Used', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Programs Used', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Program Used', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Program Used:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Program Used', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Program Used', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Program Used', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Program Used Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Programs Used', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'programs-used' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Dog Breed Taxonomy (non-hierarchical) for Success Stories
    register_taxonomy( 'dog_breed', 'gdkc_success', array(
        'labels' => array(
            'name'                       => _x( 'Dog Breeds', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Dog Breed', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Dog Breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Dog Breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Dog Breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Dog Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Dog Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Dog Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Dog Breed Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate dog breeds with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove dog breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used dog breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Dog Breeds', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'dog-breeds' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Resource Type Taxonomy (hierarchical) for Training Resources
    register_taxonomy( 'resource_type', 'gdkc_resource', array(
        'labels' => array(
            'name'              => _x( 'Resource Types', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Resource Type', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Resource Types', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Resource Types', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Resource Type', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Resource Type:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Resource Type', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Resource Type', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Resource Type', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Resource Type Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Resource Types', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'resource-types' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Resource Topic Taxonomy (hierarchical) for Training Resources
    register_taxonomy( 'resource_topic', 'gdkc_resource', array(
        'labels' => array(
            'name'              => _x( 'Topics', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Topics', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Topics', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Topic', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Topic:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Topic', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Topic', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Topic', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Topic Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Topics', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'topics' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Region Taxonomy (hierarchical) for Service Areas
    register_taxonomy( 'region', 'gdkc_service_area', array(
        'labels' => array(
            'name'              => _x( 'Regions', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Region', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Regions', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Regions', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Region', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Region:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Region', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Region', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Region', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Region Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Regions', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'regions' ),
        'show_in_rest'      => true,
    ) );
    
    // Register Fee Structure Taxonomy (non-hierarchical) for Service Areas
    register_taxonomy( 'fee_structure', 'gdkc_service_area', array(
        'labels' => array(
            'name'                       => _x( 'Fee Structures', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Fee Structure', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Fee Structures', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Fee Structures', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Fee Structures', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Fee Structure', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Fee Structure', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Fee Structure', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Fee Structure Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate fee structures with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove fee structures', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used fee structures', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Fee Structures', 'gooddogzkc-twentytwentyfour-child' ),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'fee-structures' ),
        'show_in_rest'      => true,
    ) );
}
add_action( 'init', 'gdkc_register_post_types' );

/**
 * Populate initial taxonomy terms
 */
function gdkc_populate_initial_terms() {
    // Only run this function if custom terms haven't been created yet
    if (get_option('gdkc_terms_created')) {
        return;
    }
    
    // Program Types
    $program_types = array(
        'In-Home Training' => array(
            'description' => 'Personalized training conducted in the client\'s home environment',
            'slug' => 'in-home-training'
        ),
        'Puppy Training' => array(
            'description' => 'Early development and socialization for puppies 8-20 weeks',
            'slug' => 'puppy-training'
        ),
        'Behavior Solutions' => array(
            'description' => 'Specialized behavior modification for challenging behaviors',
            'slug' => 'behavior-solutions'
        ),
        'Board & Train' => array(
            'description' => 'Intensive training in the trainer\'s family home environment',
            'slug' => 'board-and-train'
        ),
        'Group Classes' => array(
            'description' => 'Structured environment for practicing skills with other dogs',
            'slug' => 'group-classes'
        )
    );
    
    foreach ($program_types as $term => $args) {
        wp_insert_term($term, 'program_type', $args);
    }
    
    // Training Focus
    $training_focus_terms = array(
        'Obedience', 'Socialization', 'Behavior Modification', 'Leash Training', 
        'Crate Training', 'House Training', 'Recall', 'Impulse Control', 
        'Confidence Building', 'Manners', 'Environmental Desensitization'
    );
    
    foreach ($training_focus_terms as $term) {
        wp_insert_term($term, 'training_focus');
    }
    
    // Behavior Issues with hierarchical structure
    $behavior_issues = array(
        'Anxiety' => array(
            'description' => 'Fear-based or stress-related anxiety issues',
            'children' => array('Separation Anxiety', 'Noise Phobias', 'General Nervousness')
        ),
        'Aggression' => array(
            'description' => 'Various forms of aggressive behavior',
            'children' => array('Resource Guarding', 'Territorial', 'Fear-based Aggression')
        ),
        'Reactivity' => array(
            'description' => 'Over-reaction to specific triggers',
            'children' => array('Leash Reactivity', 'Barrier Frustration', 'Over-arousal')
        ),
        'Fear' => array(
            'description' => 'Fear-based behavior issues',
            'children' => array('Specific Triggers', 'Generalized Fearfulness')
        )
    );
    
    foreach ($behavior_issues as $parent => $details) {
        $parent_term = wp_insert_term($parent, 'behavior_issue', array('description' => $details['description']));
        
        // If the parent term was successfully created, add children
        if (!is_wp_error($parent_term)) {
            foreach ($details['children'] as $child) {
                wp_insert_term($child, 'behavior_issue', array('parent' => $parent_term['term_id']));
            }
        }
    }
    
    // Program Durations
    $durations = array('1-Month', '2-Month', '3-Month', 'Ongoing');
    foreach ($durations as $duration) {
        wp_insert_term($duration, 'program_duration');
    }
    
    // Package Types
    $package_types = array(
        '4-Session Package' => array(
            'description' => 'One month program with 4 weekly sessions',
            'slug' => '4-session-package'
        ),
        '6-Session Package' => array(
            'description' => 'Two month program with weekly sessions in month 1, bi-weekly in month 2',
            'slug' => '6-session-package'
        ),
        '8-Session Package' => array(
            'description' => 'Three month program with weekly sessions in month 1, bi-weekly after',
            'slug' => '8-session-package'
        ),
        'Custom Package' => array(
            'description' => 'Customized training package based on specific needs',
            'slug' => 'custom-package'
        )
    );
    
    foreach ($package_types as $term => $args) {
        wp_insert_term($term, 'package_type', $args);
    }
    
    // Included Services
    $included_services = array(
        'Phone Support', 'Email Support', 'Text Support', 'Video Review', 
        'Progress Tracking', 'Homework Assignments', 'Training Materials',
        'Follow-up Sessions', 'Training Equipment', 'Home Environment Assessment'
    );
    
    foreach ($included_services as $service) {
        wp_insert_term($service, 'included_service');
    }
    
    // Resource Types
    $resource_types = array(
        'Article' => array(
            'description' => 'Written educational content',
            'slug' => 'article'
        ),
        'Video' => array(
            'description' => 'Video tutorials and demonstrations',
            'slug' => 'video'
        ),
        'Guide' => array(
            'description' => 'Comprehensive how-to guides',
            'slug' => 'guide'
        ),
        'Infographic' => array(
            'description' => 'Visual representation of information',
            'slug' => 'infographic'
        )
    );
    
    foreach ($resource_types as $term => $args) {
        wp_insert_term($term, 'resource_type', $args);
    }
    
    // Resource Topics
    $resource_topics = array(
        'Puppy Care' => array(
            'description' => 'Caring for and raising puppies',
            'children' => array('Socialization', 'Puppy Development', 'House Training')
        ),
        'Training Tips' => array(
            'description' => 'General dog training advice',
            'children' => array('Basic Commands', 'Advanced Training', 'Clicker Training')
        ),
        'Behavior Issues' => array(
            'description' => 'Addressing common behavior problems',
            'children' => array('Aggression', 'Anxiety', 'Reactivity', 'Excessive Barking')
        ),
        'Nutrition' => array(
            'description' => 'Food and nutrition information',
            'children' => array('Diet Basics', 'Special Diets', 'Treats')
        )
    );
    
    foreach ($resource_topics as $parent => $details) {
        $parent_term = wp_insert_term($parent, 'resource_topic', array('description' => $details['description']));
        
        // If the parent term was successfully created, add children
        if (!is_wp_error($parent_term)) {
            foreach ($details['children'] as $child) {
                wp_insert_term($child, 'resource_topic', array('parent' => $parent_term['term_id']));
            }
        }
    }
    
    // Regions for Service Areas
    $regions = array(
        'Northland' => array(
            'description' => 'North Kansas City area',
            'children' => array('North Kansas City', 'Gladstone', 'Liberty')
        ),
        'Downtown' => array(
            'description' => 'Downtown Kansas City area',
            'children' => array('Downtown KC', 'Midtown', 'River Market')
        ),
        'Johnson County' => array(
            'description' => 'Johnson County area',
            'children' => array('Mission Hills', 'Prairie Village', 'Overland Park')
        ),
        'South KC' => array(
            'description' => 'South Kansas City area',
            'children' => array('Waldo', 'Brookside', 'South Plaza')
        ),
        'Extended Areas' => array(
            'description' => 'Extended service areas with travel fees',
            'children' => array('Lees Summit', 'Blue Springs', 'Grain Valley')
        )
    );
    
    foreach ($regions as $parent => $details) {
        $parent_term = wp_insert_term($parent, 'region', array('description' => $details['description']));
        
        // If the parent term was successfully created, add children
        if (!is_wp_error($parent_term)) {
            foreach ($details['children'] as $child) {
                wp_insert_term($child, 'region', array('parent' => $parent_term['term_id']));
            }
        }
    }
    
    // Fee Structures
    wp_insert_term('No Fee', 'fee_structure', array('description' => 'Areas serviced with no additional travel fee'));
    wp_insert_term('Travel Fee', 'fee_structure', array('description' => 'Areas that require an additional travel fee'));
    
    // Store that the terms have been created
    update_option('gdkc_terms_created', true);
}
// Hook into after_setup_theme to make sure this runs after theme setup
add_action('after_setup_theme', 'gdkc_populate_initial_terms');

/**
 * Flush rewrite rules on theme activation to ensure CPT permalinks work
 */
function gdkc_rewrite_flush() {
    gdkc_register_post_types();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'gdkc_rewrite_flush');

/**
 * Add custom template for taxonomy archives
 * 
 * This ensures that taxonomy archives for program_type use the same template as the post type archive
 */
function gdkc_custom_taxonomy_template($template) {
    if (is_tax('program_type')) {
        $new_template = locate_template(array('archive-gdkc_training.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    
    return $template;
}
add_filter('taxonomy_template', 'gdkc_custom_taxonomy_template');