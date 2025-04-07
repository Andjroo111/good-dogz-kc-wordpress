<?php
/**
 * Test Flow for Dog Assessment Tool
 * 
 * This file serves as a test harness to ensure the dog assessment tool 
 * works properly throughout the complete flow from form submission 
 * to results generation.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Test the complete assessment flow
 */
function gdkc_test_assessment_flow() {
    // Only run tests when the test parameter is present
    if (isset($_GET['test_assessment']) && current_user_can('manage_options')) {
        echo '<div style="background:#fff; padding:20px; margin:20px; border:1px solid #ddd; border-radius:5px;">';
        echo '<h2>Dog Assessment Tool Test Harness</h2>';
        
        // Step 1: Verify form renders properly
        echo '<h3>Step 1: Testing Form Rendering</h3>';
        if (shortcode_exists('dog_assessment_form')) {
            echo '<p style="color:green;">✓ Assessment form shortcode exists</p>';
        } else {
            echo '<p style="color:red;">✗ Assessment form shortcode is missing</p>';
        }
        
        // Check if the form template file exists
        if (file_exists(get_stylesheet_directory() . '/inc/tools/dog-assessment/dog-assessment.php')) {
            echo '<p style="color:green;">✓ Assessment form template file exists</p>';
        } else {
            echo '<p style="color:red;">✗ Assessment form template file is missing</p>';
        }
        
        // Step 2: Verify CSS and JS files are properly enqueued
        echo '<h3>Step 2: Testing Asset Enqueuing</h3>';
        $styles = wp_styles();
        $scripts = wp_scripts();
        
        if (isset($styles->registered['gdkc-dog-assessment'])) {
            echo '<p style="color:green;">✓ Assessment CSS is properly registered</p>';
        } else {
            echo '<p style="color:red;">✗ Assessment CSS is not registered</p>';
        }
        
        if (isset($scripts->registered['gdkc-dog-assessment-js'])) {
            echo '<p style="color:green;">✓ Assessment JavaScript is properly registered</p>';
        } else {
            echo '<p style="color:red;">✗ Assessment JavaScript is not registered</p>';
        }
        
        // Step 3: Test processing functionality
        echo '<h3>Step 3: Testing Processing Functionality</h3>';
        
        // Check if the processing file exists
        if (file_exists(get_stylesheet_directory() . '/inc/tools/dog-assessment/process-assessment.php')) {
            echo '<p style="color:green;">✓ Assessment processing file exists</p>';
        } else {
            echo '<p style="color:red;">✗ Assessment processing file is missing</p>';
        }
        
        // Check if AJAX actions are registered
        if (has_action('wp_ajax_process_dog_assessment') && has_action('wp_ajax_nopriv_process_dog_assessment')) {
            echo '<p style="color:green;">✓ AJAX handlers are properly registered</p>';
        } else {
            echo '<p style="color:red;">✗ AJAX handlers are not properly registered</p>';
        }
        
        // Step 4: Test mock submission
        echo '<h3>Step 4: Testing Mock Submission</h3>';
        
        // Create mock assessment data
        $mock_data = [
            'owner_name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '555-123-4567',
            'dog_name' => 'Buddy',
            'dog_breed' => 'Mixed',
            'dog_age' => '3',
            'dog_gender' => 'male',
            'dog_size' => 'medium',
            'behavior_issues' => ['leash_pulling', 'jumping'],
            'training_history' => 'basic',
            'socialization' => 'good',
            'training_goals' => ['basic_obedience', 'leash_manners']
        ];
        
        // Test the save function
        if (function_exists('gdkc_save_assessment_data')) {
            $test_post_id = gdkc_save_assessment_data($mock_data);
            if ($test_post_id) {
                echo '<p style="color:green;">✓ Assessment data can be saved (Post ID: ' . $test_post_id . ')</p>';
                
                // Test the analysis function
                if (function_exists('gdkc_analyze_assessment')) {
                    $test_analysis = gdkc_analyze_assessment($mock_data);
                    if (!empty($test_analysis) && isset($test_analysis['program_type'])) {
                        echo '<p style="color:green;">✓ Assessment analysis works correctly</p>';
                        echo '<p>Program Type: ' . esc_html($test_analysis['program_type']) . '</p>';
                        
                        // Test the recommendation function
                        if (function_exists('gdkc_get_package_recommendations')) {
                            $test_recommendations = gdkc_get_package_recommendations($test_analysis);
                            if (is_array($test_recommendations)) {
                                echo '<p style="color:green;">✓ Package recommendations function works</p>';
                                echo '<p>Number of recommended packages: ' . count($test_recommendations) . '</p>';
                            } else {
                                echo '<p style="color:red;">✗ Package recommendations function failed</p>';
                            }
                        } else {
                            echo '<p style="color:red;">✗ Package recommendations function not found</p>';
                        }
                        
                        // Test the results display
                        if (function_exists('gdkc_display_assessment_results')) {
                            $test_display = gdkc_display_assessment_results($test_post_id);
                            if (!empty($test_display)) {
                                echo '<p style="color:green;">✓ Results display function works</p>';
                            } else {
                                echo '<p style="color:red;">✗ Results display function failed</p>';
                            }
                        } else {
                            echo '<p style="color:red;">✗ Results display function not found</p>';
                        }
                    } else {
                        echo '<p style="color:red;">✗ Assessment analysis failed</p>';
                    }
                } else {
                    echo '<p style="color:red;">✗ Assessment analysis function not found</p>';
                }
                
                // Clean up the test post
                wp_delete_post($test_post_id, true);
                echo '<p>Test post deleted.</p>';
            } else {
                echo '<p style="color:red;">✗ Could not save assessment data</p>';
            }
        } else {
            echo '<p style="color:red;">✗ Save assessment function not found</p>';
        }
        
        // Step 5: Test shortcode rendering
        echo '<h3>Step 5: Testing Shortcode Rendering</h3>';
        if (function_exists('gdkc_assessment_results_shortcode')) {
            $test_shortcode = gdkc_assessment_results_shortcode(['id' => 0]);
            if (!empty($test_shortcode)) {
                echo '<p style="color:green;">✓ Results shortcode returns content</p>';
            } else {
                echo '<p style="color:red;">✗ Results shortcode failed</p>';
            }
        } else {
            echo '<p style="color:red;">✗ Results shortcode function not found</p>';
        }
        
        echo '<h3>Test Summary</h3>';
        echo '<p>The test has completed. Check the results above to ensure all components are working properly.</p>';
        echo '</div>';
    }
}
add_action('wp_footer', 'gdkc_test_assessment_flow');

/**
 * Test responsive layouts
 */
function gdkc_test_responsive_layouts() {
    // Only run tests when the test parameter is present
    if (isset($_GET['test_responsive']) && current_user_can('manage_options')) {
        ?>
        <div style="background:#fff; padding:20px; margin:20px; border:1px solid #ddd; border-radius:5px;">
            <h2>Responsive Layout Test Tool</h2>
            <p>This tool helps you verify that the templates and styles are working correctly at different screen sizes.</p>
            
            <div style="margin: 20px 0;">
                <button onclick="resizePreview('mobile')" style="padding: 8px 15px; margin-right: 10px; cursor: pointer;">Mobile View</button>
                <button onclick="resizePreview('tablet')" style="padding: 8px 15px; margin-right: 10px; cursor: pointer;">Tablet View</button>
                <button onclick="resizePreview('desktop')" style="padding: 8px 15px; margin-right: 10px; cursor: pointer;">Desktop View</button>
                <button onclick="resizePreview('full')" style="padding: 8px 15px; cursor: pointer;">Full Size</button>
            </div>
            
            <div id="preview-container" style="border: 2px solid #aaa; transition: all 0.3s ease; width: 100%; height: 500px; overflow: hidden;">
                <iframe id="responsive-preview" src="<?php echo esc_url(get_permalink()); ?>" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
            
            <div style="margin-top: 20px;">
                <h3>Check these pages for responsive testing:</h3>
                <ul>
                    <?php
                    // Get all service package posts
                    $packages = get_posts([
                        'post_type' => 'gdkc_package',
                        'numberposts' => 1,
                    ]);
                    
                    // Get all success story posts
                    $success_stories = get_posts([
                        'post_type' => 'gdkc_success',
                        'numberposts' => 1,
                    ]);
                    
                    // Get all resource posts
                    $resources = get_posts([
                        'post_type' => 'gdkc_resource',
                        'numberposts' => 1,
                    ]);
                    
                    // Get the dog assessment page
                    $assessment_page = get_page_by_path('dog-behavior-assessment');
                    ?>
                    
                    <?php if (!empty($packages)) : ?>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_permalink($packages[0]->ID)); ?>" target="_blank">
                                Service Package: <?php echo esc_html($packages[0]->post_title); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_post_type_archive_link('gdkc_package')); ?>" target="_blank">
                                Service Packages Archive
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (!empty($success_stories)) : ?>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_permalink($success_stories[0]->ID)); ?>" target="_blank">
                                Success Story: <?php echo esc_html($success_stories[0]->post_title); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_post_type_archive_link('gdkc_success')); ?>" target="_blank">
                                Success Stories Archive
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (!empty($resources)) : ?>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_permalink($resources[0]->ID)); ?>" target="_blank">
                                Resource: <?php echo esc_html($resources[0]->post_title); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_post_type_archive_link('gdkc_resource')); ?>" target="_blank">
                                Resources Archive
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if ($assessment_page) : ?>
                        <li>
                            <a href="<?php echo add_query_arg('test_responsive', '1', get_permalink($assessment_page->ID)); ?>" target="_blank">
                                Dog Behavior Assessment
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <script>
        function resizePreview(size) {
            const container = document.getElementById('preview-container');
            
            switch(size) {
                case 'mobile':
                    container.style.width = '375px';
                    break;
                case 'tablet':
                    container.style.width = '768px';
                    break;
                case 'desktop':
                    container.style.width = '1024px';
                    break;
                case 'full':
                    container.style.width = '100%';
                    break;
            }
        }
        </script>
        <?php
    }
}
add_action('wp_footer', 'gdkc_test_responsive_layouts');

/**
 * Test theme integration
 */
function gdkc_test_theme_integration() {
    // Only run tests when the test parameter is present
    if (isset($_GET['test_integration']) && current_user_can('manage_options')) {
        echo '<div style="background:#fff; padding:20px; margin:20px; border:1px solid #ddd; border-radius:5px;">';
        echo '<h2>Theme Integration Test</h2>';
        
        // Test 1: Verify custom post types are registered and working
        echo '<h3>Custom Post Types</h3>';
        
        if (post_type_exists('gdkc_package')) {
            echo '<p style="color:green;">✓ Service Packages post type is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Service Packages post type is missing</p>';
        }
        
        if (post_type_exists('gdkc_success')) {
            echo '<p style="color:green;">✓ Success Stories post type is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Success Stories post type is missing</p>';
        }
        
        if (post_type_exists('gdkc_resource')) {
            echo '<p style="color:green;">✓ Resources post type is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Resources post type is missing</p>';
        }
        
        if (post_type_exists('gdkc_assessment')) {
            echo '<p style="color:green;">✓ Assessments post type is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Assessments post type is missing</p>';
        }
        
        // Test 2: Verify taxonomies are registered
        echo '<h3>Taxonomies</h3>';
        
        if (taxonomy_exists('gdkc_package_type')) {
            echo '<p style="color:green;">✓ Package Type taxonomy is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Package Type taxonomy is missing</p>';
        }
        
        if (taxonomy_exists('gdkc_dog_size')) {
            echo '<p style="color:green;">✓ Dog Size taxonomy is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Dog Size taxonomy is missing</p>';
        }
        
        if (taxonomy_exists('gdkc_service_type')) {
            echo '<p style="color:green;">✓ Service Type taxonomy is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Service Type taxonomy is missing</p>';
        }
        
        if (taxonomy_exists('gdkc_resource_category')) {
            echo '<p style="color:green;">✓ Resource Category taxonomy is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Resource Category taxonomy is missing</p>';
        }
        
        if (taxonomy_exists('gdkc_resource_level')) {
            echo '<p style="color:green;">✓ Resource Level taxonomy is registered</p>';
        } else {
            echo '<p style="color:red;">✗ Resource Level taxonomy is missing</p>';
        }
        
        // Test 3: Verify template files are in place
        echo '<h3>Template Files</h3>';
        
        $template_files = [
            'archive-gdkc_package.php' => 'Service Packages Archive template',
            'single-gdkc_package.php' => 'Single Service Package template',
            'archive-gdkc_success.php' => 'Success Stories Archive template',
            'single-gdkc_success.php' => 'Single Success Story template',
            'archive-gdkc_resource.php' => 'Resources Archive template',
            'single-gdkc_resource.php' => 'Single Resource template',
        ];
        
        foreach ($template_files as $file => $description) {
            if (file_exists(get_stylesheet_directory() . '/' . $file)) {
                echo '<p style="color:green;">✓ ' . $description . ' exists</p>';
            } else {
                echo '<p style="color:red;">✗ ' . $description . ' is missing</p>';
            }
        }
        
        // Test 4: Verify CSS files are in place
        echo '<h3>CSS Files</h3>';
        
        $css_files = [
            'assets/css/gdkc-packages.css' => 'Service Packages CSS',
            'assets/css/gdkc-success-stories.css' => 'Success Stories CSS',
            'assets/css/gdkc-resources.css' => 'Resources CSS',
            'inc/tools/dog-assessment/css/dog-assessment.css' => 'Dog Assessment CSS',
        ];
        
        foreach ($css_files as $file => $description) {
            if (file_exists(get_stylesheet_directory() . '/' . $file)) {
                echo '<p style="color:green;">✓ ' . $description . ' exists</p>';
            } else {
                echo '<p style="color:red;">✗ ' . $description . ' is missing</p>';
            }
        }
        
        // Test 5: Verify JS files are in place
        echo '<h3>JavaScript Files</h3>';
        
        $js_files = [
            'inc/tools/dog-assessment/js/dog-assessment.js' => 'Dog Assessment JavaScript',
        ];
        
        foreach ($js_files as $file => $description) {
            if (file_exists(get_stylesheet_directory() . '/' . $file)) {
                echo '<p style="color:green;">✓ ' . $description . ' exists</p>';
            } else {
                echo '<p style="color:red;">✗ ' . $description . ' is missing</p>';
            }
        }
        
        echo '</div>';
    }
}
add_action('wp_footer', 'gdkc_test_theme_integration');