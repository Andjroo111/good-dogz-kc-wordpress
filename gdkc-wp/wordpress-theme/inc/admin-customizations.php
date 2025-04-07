<?php
/**
 * Admin Customizations for Good Dogz KC
 *
 * Customizes the WordPress admin interface for the theme.
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
 * Add custom dashboard widgets
 */
function gdkc_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'gdkc_dashboard_widget',
        'Good Dogz KC Quick Links',
        'gdkc_dashboard_widget_callback'
    );
}
add_action( 'wp_dashboard_setup', 'gdkc_add_dashboard_widgets' );

/**
 * Callback function for the dashboard widget
 */
function gdkc_dashboard_widget_callback() {
    ?>
    <div class="gdkc-dashboard-widget">
        <h3>Training Programs</h3>
        <ul>
            <li><a href="<?php echo admin_url( 'post-new.php?post_type=gdkc_training' ); ?>">Add New Training Program</a></li>
            <li><a href="<?php echo admin_url( 'edit.php?post_type=gdkc_training' ); ?>">View All Programs</a></li>
        </ul>
        
        <h3>Service Packages</h3>
        <ul>
            <li><a href="<?php echo admin_url( 'post-new.php?post_type=gdkc_package' ); ?>">Add New Service Package</a></li>
            <li><a href="<?php echo admin_url( 'edit.php?post_type=gdkc_package' ); ?>">View All Packages</a></li>
        </ul>
        
        <h3>Success Stories</h3>
        <ul>
            <li><a href="<?php echo admin_url( 'post-new.php?post_type=gdkc_success' ); ?>">Add New Success Story</a></li>
            <li><a href="<?php echo admin_url( 'edit.php?post_type=gdkc_success' ); ?>">View All Success Stories</a></li>
        </ul>
        
        <h3>Quick Actions</h3>
        <ul>
            <li><a href="<?php echo admin_url( 'edit.php?post_type=gdkc_training&page=gdkc_training_manual' ); ?>">Training Programs Manual</a></li>
            <li><a href="<?php echo admin_url( 'admin.php?page=gdkc_service_areas_map' ); ?>">Service Areas Map</a></li>
        </ul>
    </div>
    <style>
        .gdkc-dashboard-widget h3 {
            margin-top: 20px;
            margin-bottom: 10px;
            color: #2c2977;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .gdkc-dashboard-widget h3:first-child {
            margin-top: 0;
        }
        .gdkc-dashboard-widget ul {
            margin-left: 15px;
        }
    </style>
    <?php
}

/**
 * Add custom column headers to Training Programs post type admin list
 */
function gdkc_training_programs_column_headers( $columns ) {
    $new_columns = array();
    
    // Get the thumbnail and title columns
    if ( isset( $columns['cb'] ) ) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    $new_columns['thumbnail'] = __( 'Image', 'gooddogzkc-twentytwentyfour-child' );
    
    if ( isset( $columns['title'] ) ) {
        $new_columns['title'] = $columns['title'];
    }
    
    // Add custom columns
    $new_columns['program_type'] = __( 'Program Type', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['featured'] = __( 'Featured', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['pricing'] = __( 'Pricing', 'gooddogzkc-twentytwentyfour-child' );
    
    // Add the date column
    if ( isset( $columns['date'] ) ) {
        $new_columns['date'] = $columns['date'];
    }
    
    return $new_columns;
}
add_filter( 'manage_gdkc_training_posts_columns', 'gdkc_training_programs_column_headers' );

/**
 * Add content to custom columns for Training Programs post type
 */
function gdkc_training_programs_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            if ( has_post_thumbnail( $post_id ) ) {
                echo '<img src="' . get_the_post_thumbnail_url( $post_id, 'thumbnail' ) . '" width="60" height="60" style="border-radius: 4px;">';
            }
            break;
            
        case 'program_type':
            $terms = get_the_terms( $post_id, 'program_type' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $program_types = array();
                foreach ( $terms as $term ) {
                    $program_types[] = '<a href="' . get_edit_term_link( $term->term_id, 'program_type' ) . '">' . $term->name . '</a>';
                }
                echo implode( ', ', $program_types );
            }
            break;
            
        case 'featured':
            $featured = get_field( 'program_featured', $post_id );
            if ( $featured ) {
                echo '<span class="dashicons dashicons-star-filled" style="color: #ffb900;"></span>';
            } else {
                echo '<span class="dashicons dashicons-star-empty"></span>';
            }
            break;
            
        case 'pricing':
            $pricing = get_field( 'program_pricing', $post_id );
            if ( ! empty( $pricing ) && ! empty( $pricing['pricing_4_session'] ) ) {
                echo 'From $' . number_format( $pricing['pricing_4_session'] ) . '+';
            } else {
                echo '—';
            }
            break;
    }
}
add_action( 'manage_gdkc_training_posts_custom_column', 'gdkc_training_programs_column_content', 10, 2 );

/**
 * Add custom column headers to Service Packages post type admin list
 */
function gdkc_service_packages_column_headers( $columns ) {
    $new_columns = array();
    
    // Get the thumbnail and title columns
    if ( isset( $columns['cb'] ) ) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    if ( isset( $columns['title'] ) ) {
        $new_columns['title'] = $columns['title'];
    }
    
    // Add custom columns
    $new_columns['package_type'] = __( 'Package Type', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['sessions'] = __( 'Sessions', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['price'] = __( 'Price', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['popular'] = __( 'Popular', 'gooddogzkc-twentytwentyfour-child' );
    
    // Add the date column
    if ( isset( $columns['date'] ) ) {
        $new_columns['date'] = $columns['date'];
    }
    
    return $new_columns;
}
add_filter( 'manage_gdkc_package_posts_columns', 'gdkc_service_packages_column_headers' );

/**
 * Add content to custom columns for Service Packages post type
 */
function gdkc_service_packages_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'package_type':
            $terms = get_the_terms( $post_id, 'package_type' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $package_types = array();
                foreach ( $terms as $term ) {
                    $package_types[] = '<a href="' . get_edit_term_link( $term->term_id, 'package_type' ) . '">' . $term->name . '</a>';
                }
                echo implode( ', ', $package_types );
            }
            break;
            
        case 'sessions':
            $sessions = get_field( 'package_sessions', $post_id );
            if ( $sessions ) {
                echo $sessions . ' sessions';
            } else {
                echo '—';
            }
            break;
            
        case 'price':
            $regular_price = get_field( 'package_regular_price', $post_id );
            $sale_price = get_field( 'package_sale_price', $post_id );
            
            if ( $regular_price ) {
                if ( $sale_price ) {
                    echo '<span style="text-decoration: line-through; color: #999;">$' . number_format( $regular_price ) . '</span> ';
                    echo '<span style="color: #d54e21; font-weight: bold;">$' . number_format( $sale_price ) . '</span>';
                } else {
                    echo '$' . number_format( $regular_price );
                }
            } else {
                echo '—';
            }
            break;
            
        case 'popular':
            $popular = get_field( 'package_popular', $post_id );
            if ( $popular ) {
                echo '<span class="dashicons dashicons-yes" style="color: #46b450;"></span>';
            } else {
                echo '<span class="dashicons dashicons-no"></span>';
            }
            break;
    }
}
add_action( 'manage_gdkc_package_posts_custom_column', 'gdkc_service_packages_column_content', 10, 2 );

/**
 * Add custom column headers to Success Stories post type admin list
 */
function gdkc_success_stories_column_headers( $columns ) {
    $new_columns = array();
    
    // Get the checkbox and title columns
    if ( isset( $columns['cb'] ) ) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    $new_columns['thumbnail'] = __( 'Image', 'gooddogzkc-twentytwentyfour-child' );
    
    if ( isset( $columns['title'] ) ) {
        $new_columns['title'] = $columns['title'];
    }
    
    // Add custom columns
    $new_columns['client'] = __( 'Client', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['dog'] = __( 'Dog', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['issue'] = __( 'Issue Addressed', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['rating'] = __( 'Rating', 'gooddogzkc-twentytwentyfour-child' );
    $new_columns['featured'] = __( 'Featured', 'gooddogzkc-twentytwentyfour-child' );
    
    // Add the date column
    if ( isset( $columns['date'] ) ) {
        $new_columns['date'] = $columns['date'];
    }
    
    return $new_columns;
}
add_filter( 'manage_gdkc_success_posts_columns', 'gdkc_success_stories_column_headers' );

/**
 * Add content to custom columns for Success Stories post type
 */
function gdkc_success_stories_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            if ( has_post_thumbnail( $post_id ) ) {
                echo '<img src="' . get_the_post_thumbnail_url( $post_id, 'thumbnail' ) . '" width="60" height="60" style="object-fit: cover; border-radius: 4px;">';
            }
            break;
            
        case 'client':
            $client_name = get_field( 'client_name', $post_id );
            if ( $client_name ) {
                echo $client_name;
            } else {
                echo '—';
            }
            break;
            
        case 'dog':
            $dog_name = get_field( 'dog_name', $post_id );
            $breed_terms = get_the_terms( $post_id, 'dog_breed' );
            
            if ( $dog_name ) {
                echo $dog_name;
                
                if ( ! empty( $breed_terms ) && ! is_wp_error( $breed_terms ) ) {
                    echo ' <span style="color: #999;">(' . $breed_terms[0]->name . ')</span>';
                }
            } else {
                echo '—';
            }
            break;
            
        case 'issue':
            $terms = get_the_terms( $post_id, 'issue_addressed' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $issues = array();
                foreach ( $terms as $term ) {
                    $issues[] = '<a href="' . get_edit_term_link( $term->term_id, 'issue_addressed' ) . '">' . $term->name . '</a>';
                }
                echo implode( ', ', $issues );
            }
            break;
            
        case 'rating':
            $rating = get_field( 'star_rating', $post_id );
            if ( $rating ) {
                for ( $i = 0; $i < 5; $i++ ) {
                    if ( $i < $rating ) {
                        echo '<span class="dashicons dashicons-star-filled" style="color: #ffb900; font-size: 16px;"></span>';
                    } else {
                        echo '<span class="dashicons dashicons-star-empty" style="color: #ccc; font-size: 16px;"></span>';
                    }
                }
            } else {
                echo '—';
            }
            break;
            
        case 'featured':
            $featured = get_field( 'featured_success', $post_id );
            if ( $featured ) {
                echo '<span class="dashicons dashicons-yes" style="color: #46b450;"></span>';
            } else {
                echo '<span class="dashicons dashicons-no"></span>';
            }
            break;
    }
}
add_action( 'manage_gdkc_success_posts_custom_column', 'gdkc_success_stories_column_content', 10, 2 );

/**
 * Make custom columns sortable
 */
function gdkc_sortable_columns( $columns ) {
    $columns['program_type'] = 'program_type';
    $columns['featured'] = 'program_featured';
    $columns['rating'] = 'star_rating';
    $columns['sessions'] = 'package_sessions';
    $columns['price'] = 'package_regular_price';
    $columns['popular'] = 'package_popular';
    
    return $columns;
}
add_filter( 'manage_edit-gdkc_training_sortable_columns', 'gdkc_sortable_columns' );
add_filter( 'manage_edit-gdkc_package_sortable_columns', 'gdkc_sortable_columns' );
add_filter( 'manage_edit-gdkc_success_sortable_columns', 'gdkc_sortable_columns' );

/**
 * Add help tabs to CPT edit screens
 */
function gdkc_add_help_tabs() {
    $screen = get_current_screen();
    
    // Only add help tabs for our custom post types
    if ( ! in_array( $screen->id, array( 'gdkc_training', 'gdkc_package', 'gdkc_success', 'gdkc_resource', 'gdkc_service_area' ) ) ) {
        return;
    }
    
    // Remove existing help tabs
    $screen->remove_help_tabs();
    
    // Add new help tabs
    switch ( $screen->id ) {
        case 'gdkc_training':
            $screen->add_help_tab( array(
                'id'      => 'gdkc_training_overview',
                'title'   => __( 'Training Programs Overview', 'gooddogzkc-twentytwentyfour-child' ),
                'content' => '<h2>Training Programs</h2>' .
                            '<p>Training Programs represent the various dog training services offered by Good Dogz KC.</p>' .
                            '<p>Each program can be assigned to a Program Type (e.g., In-Home Training, Puppy Training) and have associated pricing details.</p>' .
                            '<p>Use the Featured option to highlight important programs on the website.</p>'
            ) );
            
            $screen->add_help_tab( array(
                'id'      => 'gdkc_training_fields',
                'title'   => __( 'Custom Fields', 'gooddogzkc-twentytwentyfour-child' ),
                'content' => '<h2>Custom Fields</h2>' .
                            '<ul>' .
                            '<li><strong>Program Overview:</strong> A brief description of the training program</li>' .
                            '<li><strong>Benefits:</strong> Key advantages and benefits of the program</li>' .
                            '<li><strong>Who Is This For:</strong> Description of ideal clients for this program</li>' .
                            '<li><strong>Process Steps:</strong> Step-by-step breakdown of the training process</li>' .
                            '<li><strong>Pricing Information:</strong> Pricing tiers for different session packages</li>' .
                            '<li><strong>Featured Program:</strong> Toggle to feature this program prominently</li>' .
                            '<li><strong>Program Details:</strong> Additional information about duration, frequency, etc.</li>' .
                            '</ul>'
            ) );
            break;
            
        case 'gdkc_package':
            $screen->add_help_tab( array(
                'id'      => 'gdkc_package_overview',
                'title'   => __( 'Service Packages Overview', 'gooddogzkc-twentytwentyfour-child' ),
                'content' => '<h2>Service Packages</h2>' .
                            '<p>Service Packages represent the packaged training services with specific pricing and duration.</p>' .
                            '<p>Each package has a specific number of sessions and duration, with an associated price.</p>' .
                            '<p>Use the Popular option to highlight the recommended package for clients.</p>'
            ) );
            break;
            
        case 'gdkc_success':
            $screen->add_help_tab( array(
                'id'      => 'gdkc_success_overview',
                'title'   => __( 'Success Stories Overview', 'gooddogzkc-twentytwentyfour-child' ),
                'content' => '<h2>Success Stories</h2>' .
                            '<p>Success Stories showcase client testimonials and transformations.</p>' .
                            '<p>Include before and after details, client quotes, and images to demonstrate results.</p>' .
                            '<p>Tag stories with the specific issues addressed and programs used.</p>'
            ) );
            break;
    }
    
    // Add common sidebar content
    $screen->set_help_sidebar(
        '<p><strong>' . __( 'For more information:', 'gooddogzkc-twentytwentyfour-child' ) . '</strong></p>' .
        '<p><a href="https://gooddogzkc.com/editor-guide" target="_blank">' . __( 'Editor Guide', 'gooddogzkc-twentytwentyfour-child' ) . '</a></p>' .
        '<p><a href="mailto:support@gooddogzkc.com">' . __( 'Contact Support', 'gooddogzkc-twentytwentyfour-child' ) . '</a></p>'
    );
}
add_action( 'current_screen', 'gdkc_add_help_tabs' );

/**
 * Add custom CSS to admin
 */
function gdkc_admin_css() {
    ?>
    <style>
        /* Add brand colors to admin */
        :root {
            --gdkc-dark-blue: #2c2977;
            --gdkc-light-purple: #a08cff;
            --gdkc-teal: #07edbe;
            --gdkc-medium-blue: #477ed6;
        }
        
        /* Customize post type admin screens */
        .post-type-gdkc_training #titlewrap:before,
        .post-type-gdkc_package #titlewrap:before,
        .post-type-gdkc_success #titlewrap:before,
        .post-type-gdkc_resource #titlewrap:before,
        .post-type-gdkc_service_area #titlewrap:before {
            content: '';
            display: block;
            height: 3px;
            background: var(--gdkc-dark-blue);
            margin-bottom: 10px;
        }
        
        /* Customize post type icons */
        #adminmenu #menu-posts-gdkc_training .wp-menu-image:before {
            color: var(--gdkc-light-purple);
        }
        
        #adminmenu #menu-posts-gdkc_package .wp-menu-image:before {
            color: var(--gdkc-teal);
        }
        
        #adminmenu #menu-posts-gdkc_success .wp-menu-image:before {
            color: var(--gdkc-medium-blue);
        }
        
        /* Customize ACF field groups */
        .acf-field-program-overview .acf-label label,
        .acf-field-package-regular-price .acf-label label,
        .acf-field-client-name .acf-label label,
        .acf-field-resource-summary .acf-label label,
        .acf-field-service-zipcodes .acf-label label {
            font-weight: bold;
            color: var(--gdkc-dark-blue);
        }
        
        /* Taxonomy term highlighting */
        .column-program_type a,
        .column-package_type a,
        .column-issue a {
            background-color: #f0f0f9;
            padding: 2px 6px;
            border-radius: 3px;
            text-decoration: none;
        }
        
        .column-program_type a:hover,
        .column-package_type a:hover,
        .column-issue a:hover {
            background-color: #e0e0f0;
        }
    </style>
    <?php
}
add_action( 'admin_head', 'gdkc_admin_css' );

/**
 * Add admin menu for training manual
 */
function gdkc_add_menu_pages() {
    add_submenu_page(
        'edit.php?post_type=gdkc_training',
        'Training Programs Manual',
        'Training Manual',
        'edit_posts',
        'gdkc_training_manual',
        'gdkc_training_manual_page'
    );
    
    // Add Service Areas Map page
    add_menu_page(
        'Service Areas Map',
        'Service Areas Map',
        'edit_posts',
        'gdkc_service_areas_map',
        'gdkc_service_areas_map_page',
        'dashicons-location-alt',
        30
    );
}
add_action( 'admin_menu', 'gdkc_add_menu_pages' );

/**
 * Training manual page content
 */
function gdkc_training_manual_page() {
    ?>
    <div class="wrap">
        <h1>Training Programs Manual</h1>
        
        <div class="card">
            <h2>Creating Effective Training Programs</h2>
            <p>This guide will help you create and manage training programs that convert visitors into clients.</p>
            
            <h3>Best Practices</h3>
            <ol>
                <li>Use clear, benefit-focused titles</li>
                <li>Include before/after transformations when possible</li>
                <li>Break down the process into clear steps</li>
                <li>Always specify who the program is best suited for</li>
                <li>Include specific pricing information</li>
            </ol>
            
            <h3>Program Types</h3>
            <p>Good Dogz KC offers the following program types:</p>
            <ul>
                <li><strong>In-Home Training:</strong> Personalized training in the client's home environment</li>
                <li><strong>Puppy Training:</strong> Early development and socialization for puppies 8-20 weeks</li>
                <li><strong>Behavior Solutions:</strong> Specialized behavior modification for challenging behaviors</li>
                <li><strong>Board & Train:</strong> Intensive training in the trainer's family home environment</li>
                <li><strong>Group Classes:</strong> Structured environment for practicing skills with other dogs</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Service areas map page content
 */
function gdkc_service_areas_map_page() {
    ?>
    <div class="wrap">
        <h1>Service Areas Map</h1>
        
        <div class="card">
            <h2>Service Coverage Areas</h2>
            <p>This map shows all the areas where Good Dogz KC offers services.</p>
            
            <div id="gdkc-service-map" style="width: 100%; height: 500px; background-color: #f0f0f0; margin-top: 20px;">
                <p style="text-align: center; padding-top: 200px;">Google Maps API required to display the service areas map.</p>
                <p style="text-align: center;"><a href="<?php echo admin_url( 'edit.php?post_type=gdkc_service_area' ); ?>" class="button button-primary">Manage Service Areas</a></p>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Add custom admin footer text
 */
function gdkc_admin_footer_text( $text ) {
    $current_screen = get_current_screen();
    
    // Check if we're on one of our custom post type screens
    if ( strpos( $current_screen->id, 'gdkc_' ) !== false ) {
        $text = 'Thank you for creating content with <a href="https://gooddogzkc.com" target="_blank">Good Dogz KC</a>.';
    }
    
    return $text;
}
add_filter( 'admin_footer_text', 'gdkc_admin_footer_text' );

/**
 * Filter admin title for custom post types
 */
function gdkc_admin_title( $admin_title, $title ) {
    $current_screen = get_current_screen();
    
    // Custom titles for our post types
    if ( $current_screen->post_type === 'gdkc_training' ) {
        return 'Training Program: ' . $title . ' - Good Dogz KC';
    } elseif ( $current_screen->post_type === 'gdkc_package' ) {
        return 'Service Package: ' . $title . ' - Good Dogz KC';
    } elseif ( $current_screen->post_type === 'gdkc_success' ) {
        return 'Success Story: ' . $title . ' - Good Dogz KC';
    } elseif ( $current_screen->post_type === 'gdkc_resource' ) {
        return 'Training Resource: ' . $title . ' - Good Dogz KC';
    } elseif ( $current_screen->post_type === 'gdkc_service_area' ) {
        return 'Service Area: ' . $title . ' - Good Dogz KC';
    }
    
    return $admin_title;
}
add_filter( 'admin_title', 'gdkc_admin_title', 10, 2 );