<?php
/**
 * Dog Assessment Tool - Processing Script
 * 
 * Processes assessment submissions, analyzes results, and provides recommendations
 *
 * @package Good_Dogz_KC
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Process the dog assessment form submission via AJAX
 */
function gdkc_process_dog_assessment() {
    // Verify nonce for security
    if (!isset($_POST['assessment_nonce']) || !wp_verify_nonce($_POST['assessment_nonce'], 'gdkc_dog_assessment')) {
        wp_send_json_error(['message' => 'Security check failed. Please try again.']);
        exit;
    }

    // Sanitize and collect all form data
    $assessment_data = [];
    foreach ($_POST as $key => $value) {
        if ($key !== 'action' && $key !== 'assessment_nonce') {
            if (is_array($value)) {
                // For checkboxes with multiple values
                $assessment_data[$key] = array_map('sanitize_text_field', $value);
            } else {
                $assessment_data[$key] = sanitize_text_field($value);
            }
        }
    }

    // Save the assessment data
    $assessment_id = gdkc_save_assessment_data($assessment_data);

    if (!$assessment_id) {
        wp_send_json_error(['message' => 'There was an error saving your assessment. Please try again.']);
        exit;
    }

    // Analyze the assessment data
    $analysis_results = gdkc_analyze_assessment($assessment_data);

    // Save analysis results
    update_post_meta($assessment_id, 'analysis_results', $analysis_results);

    // Find recommended packages based on analysis
    $recommended_packages = gdkc_get_package_recommendations($analysis_results);
    update_post_meta($assessment_id, 'recommended_packages', $recommended_packages);

    // Send email notification to admin
    gdkc_send_assessment_admin_notification($assessment_id, $assessment_data);

    // Send confirmation email to client if email provided
    if (!empty($assessment_data['email'])) {
        gdkc_send_assessment_confirmation($assessment_data['email'], $assessment_id);
    }

    // Create results URL
    $results_page_id = get_option('gdkc_assessment_results_page');
    if ($results_page_id) {
        $results_url = add_query_arg('assessment', $assessment_id, get_permalink($results_page_id));
    } else {
        // Fallback to thank you message if no results page is configured
        $results_url = '';
    }

    // Send success response
    wp_send_json_success([
        'message' => 'Assessment successfully processed.',
        'assessment_id' => $assessment_id,
        'redirect' => $results_url
    ]);
    exit;
}
add_action('wp_ajax_process_dog_assessment', 'gdkc_process_dog_assessment');
add_action('wp_ajax_nopriv_process_dog_assessment', 'gdkc_process_dog_assessment');

/**
 * Save assessment data to a custom post type
 *
 * @param array $data The assessment data from the form
 * @return int|bool The post ID on success, false on failure
 */
function gdkc_save_assessment_data($data) {
    // Create title from owner/dog name if available
    $title = '';
    if (!empty($data['owner_name']) && !empty($data['dog_name'])) {
        $title = sanitize_text_field($data['owner_name']) . ' - ' . sanitize_text_field($data['dog_name']);
    } elseif (!empty($data['dog_name'])) {
        $title = 'Assessment for ' . sanitize_text_field($data['dog_name']);
    } elseif (!empty($data['owner_name'])) {
        $title = 'Assessment from ' . sanitize_text_field($data['owner_name']);
    } else {
        $title = 'Dog Behavior Assessment - ' . date('Y-m-d H:i');
    }

    // Create a custom post to store the assessment
    $post_args = [
        'post_title'    => $title,
        'post_status'   => 'private',
        'post_type'     => 'gdkc_assessment',
        'post_content'  => '',
        'post_author'   => 1, // Default to admin
    ];

    $post_id = wp_insert_post($post_args);

    if (!$post_id || is_wp_error($post_id)) {
        return false;
    }

    // Save all form data as post meta
    foreach ($data as $key => $value) {
        update_post_meta($post_id, $key, $value);
    }

    // Save the submission date
    update_post_meta($post_id, 'submission_date', current_time('mysql'));

    return $post_id;
}

/**
 * Analyze assessment data to determine recommendations
 *
 * @param array $data The assessment data
 * @return array Analysis results
 */
function gdkc_analyze_assessment($data) {
    $analysis = [
        'behavior_score' => 0,
        'aggression_level' => 0,
        'training_level' => 0,
        'anxiety_level' => 0,
        'socialization_needs' => 0,
        'primary_issues' => [],
        'secondary_issues' => [],
        'recommended_focus' => [],
        'program_type' => '',
        'notes' => ''
    ];

    // Analyze basic information
    // Age factor (younger dogs often need more basic training)
    if (!empty($data['dog_age'])) {
        $age = intval($data['dog_age']);
        if ($age < 1) {
            $analysis['training_level'] -= 2; // Puppy needs more basic training
            $analysis['notes'] .= "Puppy under 1 year - focus on foundation skills. ";
        } elseif ($age > 8) {
            $analysis['notes'] .= "Senior dog - may need adaptations for physical limitations. ";
        }
    }

    // Analyze behavior issues
    if (!empty($data['behavior_issues'])) {
        $issues = is_array($data['behavior_issues']) ? $data['behavior_issues'] : [$data['behavior_issues']];
        
        foreach ($issues as $issue) {
            switch ($issue) {
                case 'aggression_dogs':
                    $analysis['aggression_level'] += 3;
                    $analysis['primary_issues'][] = 'Dog Aggression';
                    break;
                case 'aggression_people':
                    $analysis['aggression_level'] += 4;
                    $analysis['primary_issues'][] = 'Human Aggression';
                    break;
                case 'fear_anxiety':
                    $analysis['anxiety_level'] += 3;
                    $analysis['primary_issues'][] = 'Fear/Anxiety';
                    break;
                case 'leash_pulling':
                    $analysis['behavior_score'] += 1;
                    $analysis['secondary_issues'][] = 'Leash Pulling';
                    break;
                case 'jumping':
                    $analysis['behavior_score'] += 1;
                    $analysis['secondary_issues'][] = 'Jumping';
                    break;
                case 'barking':
                    $analysis['behavior_score'] += 2;
                    $analysis['secondary_issues'][] = 'Excessive Barking';
                    break;
                case 'destructive':
                    $analysis['behavior_score'] += 2;
                    $analysis['secondary_issues'][] = 'Destructive Behavior';
                    break;
                case 'separation_anxiety':
                    $analysis['anxiety_level'] += 3;
                    $analysis['primary_issues'][] = 'Separation Anxiety';
                    break;
                case 'resource_guarding':
                    $analysis['aggression_level'] += 2;
                    $analysis['primary_issues'][] = 'Resource Guarding';
                    break;
            }
        }
    }

    // Analyze training history
    if (!empty($data['training_history'])) {
        switch ($data['training_history']) {
            case 'none':
                $analysis['training_level'] -= 2;
                $analysis['notes'] .= "No prior training - will need to start with basics. ";
                break;
            case 'basic':
                $analysis['training_level'] += 0;
                break;
            case 'intermediate':
                $analysis['training_level'] += 1;
                break;
            case 'advanced':
                $analysis['training_level'] += 2;
                $analysis['notes'] .= "Advanced training background - can focus on specific issues. ";
                break;
        }
    }

    // Analyze socialization needs
    if (!empty($data['socialization'])) {
        switch ($data['socialization']) {
            case 'poor':
                $analysis['socialization_needs'] += 3;
                $analysis['recommended_focus'][] = 'Socialization';
                $analysis['notes'] .= "Poor socialization is a priority. ";
                break;
            case 'limited':
                $analysis['socialization_needs'] += 2;
                $analysis['recommended_focus'][] = 'Socialization';
                break;
            case 'good':
                $analysis['socialization_needs'] += 0;
                break;
            case 'excellent':
                $analysis['socialization_needs'] -= 1;
                break;
        }
    }

    // Calculate overall behavior score
    $analysis['behavior_score'] += $analysis['aggression_level'] + $analysis['anxiety_level'];

    // Determine program type based on analysis
    if ($analysis['aggression_level'] >= 3) {
        $analysis['program_type'] = 'Behavioral Rehabilitation';
        $analysis['recommended_focus'][] = 'Aggression Management';
    } elseif ($analysis['anxiety_level'] >= 3) {
        $analysis['program_type'] = 'Anxiety Management';
        $analysis['recommended_focus'][] = 'Confidence Building';
    } elseif ($analysis['behavior_score'] >= 4) {
        $analysis['program_type'] = 'Behavioral Training';
    } elseif ($analysis['training_level'] <= -1) {
        $analysis['program_type'] = 'Basic Obedience';
        $analysis['recommended_focus'][] = 'Foundation Skills';
    } elseif ($analysis['socialization_needs'] >= 2) {
        $analysis['program_type'] = 'Socialization Focus';
    } else {
        $analysis['program_type'] = 'General Obedience';
    }

    // Add training goals to recommended focus
    if (!empty($data['training_goals'])) {
        $goals = is_array($data['training_goals']) ? $data['training_goals'] : [$data['training_goals']];
        foreach ($goals as $goal) {
            switch ($goal) {
                case 'basic_obedience':
                    $analysis['recommended_focus'][] = 'Basic Obedience';
                    break;
                case 'leash_manners':
                    $analysis['recommended_focus'][] = 'Leash Manners';
                    break;
                case 'socialization':
                    $analysis['recommended_focus'][] = 'Socialization';
                    break;
                case 'anxiety_reduction':
                    $analysis['recommended_focus'][] = 'Anxiety Reduction';
                    break;
                case 'aggression_management':
                    $analysis['recommended_focus'][] = 'Aggression Management';
                    break;
                case 'advanced_training':
                    $analysis['recommended_focus'][] = 'Advanced Training';
                    break;
            }
        }
    }

    // Remove duplicate recommended focus areas
    $analysis['recommended_focus'] = array_unique($analysis['recommended_focus']);
    
    return $analysis;
}

/**
 * Get package recommendations based on assessment analysis
 *
 * @param array $analysis The analysis results
 * @return array Recommended package IDs
 */
function gdkc_get_package_recommendations($analysis) {
    $args = [
        'post_type' => 'gdkc_package',
        'posts_per_page' => -1,
        'meta_query' => [],
    ];

    // Add program type to meta query if available
    if (!empty($analysis['program_type'])) {
        $args['meta_query'][] = [
            'key' => 'program_type',
            'value' => $analysis['program_type'],
            'compare' => 'LIKE',
        ];
    }

    // Query packages
    $packages_query = new WP_Query($args);
    $recommended_packages = [];

    if ($packages_query->have_posts()) {
        while ($packages_query->have_posts()) {
            $packages_query->the_post();
            $package_id = get_the_ID();
            $package_score = 0;
            
            // Get package attributes for matching
            $package_focuses = get_post_meta($package_id, 'focus_areas', true);
            $package_issues = get_post_meta($package_id, 'addresses_issues', true);
            
            // Match against primary issues
            if (!empty($analysis['primary_issues']) && !empty($package_issues)) {
                foreach ($analysis['primary_issues'] as $issue) {
                    if (in_array($issue, $package_issues) || strpos($package_issues, $issue) !== false) {
                        $package_score += 3; // High score for matching primary issues
                    }
                }
            }
            
            // Match against secondary issues
            if (!empty($analysis['secondary_issues']) && !empty($package_issues)) {
                foreach ($analysis['secondary_issues'] as $issue) {
                    if (in_array($issue, $package_issues) || strpos($package_issues, $issue) !== false) {
                        $package_score += 1; // Lower score for matching secondary issues
                    }
                }
            }
            
            // Match against recommended focus areas
            if (!empty($analysis['recommended_focus']) && !empty($package_focuses)) {
                foreach ($analysis['recommended_focus'] as $focus) {
                    if (in_array($focus, $package_focuses) || strpos($package_focuses, $focus) !== false) {
                        $package_score += 2; // Medium score for matching focus areas
                    }
                }
            }
            
            // Add to recommended packages if score is above threshold
            if ($package_score >= 2) {
                $recommended_packages[$package_id] = $package_score;
            }
        }
        wp_reset_postdata();
    }
    
    // Sort packages by score (highest first)
    arsort($recommended_packages);
    
    // Limit to top 3 recommendations
    return array_slice($recommended_packages, 0, 3, true);
}

/**
 * Send email notification to admin about new assessment
 *
 * @param int $assessment_id The assessment post ID
 * @param array $data The assessment form data
 */
function gdkc_send_assessment_admin_notification($assessment_id, $data) {
    $admin_email = get_option('admin_email');
    $subject = 'New Dog Behavior Assessment Submission';
    
    $message = "A new dog behavior assessment has been submitted.\n\n";
    $message .= "Assessment ID: {$assessment_id}\n";
    
    if (!empty($data['owner_name'])) {
        $message .= "Owner Name: {$data['owner_name']}\n";
    }
    
    if (!empty($data['email'])) {
        $message .= "Email: {$data['email']}\n";
    }
    
    if (!empty($data['phone'])) {
        $message .= "Phone: {$data['phone']}\n";
    }
    
    if (!empty($data['dog_name'])) {
        $message .= "Dog Name: {$data['dog_name']}\n";
    }
    
    $message .= "\nView full assessment details in the admin dashboard: " . admin_url("post.php?post={$assessment_id}&action=edit");
    
    wp_mail($admin_email, $subject, $message);
}

/**
 * Send confirmation email to client
 *
 * @param string $email The client's email address
 * @param int $assessment_id The assessment post ID
 */
function gdkc_send_assessment_confirmation($email, $assessment_id) {
    $subject = 'Your Dog Behavior Assessment Results';
    
    $message = "Thank you for completing our dog behavior assessment!\n\n";
    $message .= "We've received your submission and are reviewing your dog's unique needs.\n\n";
    
    // If we have a results page set up, include the link
    $results_page_id = get_option('gdkc_assessment_results_page');
    if ($results_page_id) {
        $results_url = add_query_arg('assessment', $assessment_id, get_permalink($results_page_id));
        $message .= "View your personalized results and training recommendations here:\n";
        $message .= $results_url . "\n\n";
    } else {
        $message .= "One of our trainers will be in touch with you shortly to discuss your results and tailored training recommendations.\n\n";
    }
    
    $message .= "If you have any questions in the meantime, please don't hesitate to contact us.\n\n";
    $message .= "Good Dogz KC Training Team";
    
    wp_mail($email, $subject, $message);
}

/**
 * Display assessment results on the frontend
 *
 * @param int $assessment_id The assessment post ID
 * @return string HTML output of assessment results
 */
function gdkc_display_assessment_results($assessment_id) {
    // Verify the assessment exists and belongs to a valid post type
    $assessment = get_post($assessment_id);
    if (!$assessment || $assessment->post_type !== 'gdkc_assessment') {
        return '<p>Assessment not found. Please check your link and try again.</p>';
    }
    
    // Get assessment data
    $dog_name = get_post_meta($assessment_id, 'dog_name', true);
    $dog_breed = get_post_meta($assessment_id, 'dog_breed', true);
    $dog_age = get_post_meta($assessment_id, 'dog_age', true);
    $owner_name = get_post_meta($assessment_id, 'owner_name', true);
    
    // Get analysis results
    $analysis = get_post_meta($assessment_id, 'analysis_results', true);
    $recommended_packages = get_post_meta($assessment_id, 'recommended_packages', true);
    
    ob_start();
    ?>
    <div class="gdkc-dog-assessment-results">
        <div class="assessment-result">
            <h3>Your Dog's Assessment Results</h3>
            
            <div class="result-section">
                <h4>About Your Dog</h4>
                <?php if ($dog_name) : ?>
                    <div class="result-field">
                        <div class="label">Name:</div>
                        <div class="value"><?php echo esc_html($dog_name); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if ($dog_breed) : ?>
                    <div class="result-field">
                        <div class="label">Breed:</div>
                        <div class="value"><?php echo esc_html($dog_breed); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if ($dog_age) : ?>
                    <div class="result-field">
                        <div class="label">Age:</div>
                        <div class="value"><?php echo esc_html($dog_age); ?> years</div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="result-section">
                <h4>Assessment Summary</h4>
                
                <?php if (!empty($analysis['primary_issues'])) : ?>
                    <div class="result-field">
                        <div class="label">Primary Concerns:</div>
                        <div class="value"><?php echo esc_html(implode(', ', $analysis['primary_issues'])); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($analysis['secondary_issues'])) : ?>
                    <div class="result-field">
                        <div class="label">Secondary Issues:</div>
                        <div class="value"><?php echo esc_html(implode(', ', $analysis['secondary_issues'])); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($analysis['recommended_focus'])) : ?>
                    <div class="result-field">
                        <div class="label">Training Focus:</div>
                        <div class="value"><?php echo esc_html(implode(', ', $analysis['recommended_focus'])); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($analysis['program_type'])) : ?>
                    <div class="result-field">
                        <div class="label">Recommended Program:</div>
                        <div class="value"><?php echo esc_html($analysis['program_type']); ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($analysis['notes'])) : ?>
                    <div class="result-field">
                        <div class="label">Notes:</div>
                        <div class="value notes"><?php echo esc_html($analysis['notes']); ?></div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="recommendation-section">
                <h4>Training Recommendations</h4>
                <p>Based on your assessment, we recommend the following training programs for <?php echo esc_html($dog_name ?: 'your dog'); ?>:</p>
                
                <?php 
                if (!empty($recommended_packages)) :
                    foreach ($recommended_packages as $package_id => $score) :
                        $package = get_post($package_id);
                        if ($package) :
                            $price = get_post_meta($package_id, 'price', true);
                            $duration = get_post_meta($package_id, 'duration', true);
                ?>
                            <div class="recommended-program">
                                <h5><?php echo esc_html($package->post_title); ?></h5>
                                <div class="program-meta">
                                    <?php if ($price) : ?>
                                        <div class="program-price"><?php echo esc_html($price); ?></div>
                                    <?php endif; ?>
                                    
                                    <?php if ($duration) : ?>
                                        <div class="program-duration"><?php echo esc_html($duration); ?></div>
                                    <?php endif; ?>
                                </div>
                                <p><?php echo wp_trim_words(get_the_excerpt($package_id), 30); ?></p>
                                <a href="<?php echo esc_url(get_permalink($package_id)); ?>" class="view-program">View Program Details</a>
                            </div>
                <?php 
                        endif;
                    endforeach;
                else :
                ?>
                    <p>We'd like to discuss your dog's needs in more detail to provide the most tailored training recommendation. Please contact us to schedule a consultation.</p>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-button">Contact Us to Get Started</a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode to display assessment results
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function gdkc_assessment_results_shortcode($atts) {
    $atts = shortcode_atts([
        'id' => 0,
    ], $atts, 'dog_assessment_results');
    
    // If no ID is provided in shortcode, check for it in URL parameter
    if (empty($atts['id'])) {
        $assessment_id = isset($_GET['assessment']) ? intval($_GET['assessment']) : 0;
    } else {
        $assessment_id = intval($atts['id']);
    }
    
    if ($assessment_id) {
        return gdkc_display_assessment_results($assessment_id);
    } else {
        return '<p>No assessment found. Please complete the dog behavior assessment to see your results.</p>';
    }
}
add_shortcode('dog_assessment_results', 'gdkc_assessment_results_shortcode');