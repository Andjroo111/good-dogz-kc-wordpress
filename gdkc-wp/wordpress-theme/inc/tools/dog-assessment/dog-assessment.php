<?php
/**
 * Dog Assessment Tool
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
 * Dog Assessment Class
 */
class GDKC_Dog_Assessment {
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_shortcode( 'dog_assessment_form', array( $this, 'assessment_form_shortcode' ) );
        add_shortcode( 'dog_assessment_results', array( $this, 'assessment_results_shortcode' ) );
    }

    /**
     * Register post types
     */
    public function register_post_types() {
        $labels = array(
            'name'               => _x( 'Dog Assessments', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Dog Assessment', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Dog Assessments', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Dog Assessment', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'assessment', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Assessment', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Assessment', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Assessment', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Assessment', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Assessments', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Assessments', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Assessments:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No assessments found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No assessments found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Dog assessment records', 'gooddogzkc-twentytwentyfour-child' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'dog-assessment' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
            'menu_icon'          => 'dashicons-pets',
        );

        register_post_type( 'dog_assessment', $args );
    }

    /**
     * Register taxonomies
     */
    public function register_taxonomies() {
        // Assessment Categories
        $labels = array(
            'name'              => _x( 'Assessment Categories', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Assessment Category', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Assessment Categories', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Assessment Categories', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Assessment Category', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Assessment Category:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Assessment Category', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Assessment Category', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Assessment Category', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Assessment Category Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Assessment Categories', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'assessment-category' ),
        );

        register_taxonomy( 'assessment_category', array( 'dog_assessment' ), $args );

        // Assessment Tags
        $labels = array(
            'name'                       => _x( 'Assessment Tags', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Assessment Tag', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Assessment Tags', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Assessment Tags', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Assessment Tags', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Assessment Tag', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Assessment Tag', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Assessment Tag', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Assessment Tag Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate assessment tags with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove assessment tags', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used assessment tags', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'                  => __( 'No assessment tags found.', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Assessment Tags', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'assessment-tag' ),
        );

        register_taxonomy( 'assessment_tag', 'dog_assessment', $args );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        if ( is_singular( 'dog_assessment' ) || has_shortcode( get_post()->post_content, 'dog_assessment_form' ) || has_shortcode( get_post()->post_content, 'dog_assessment_results' ) ) {
            wp_enqueue_style( 'gdkc-dog-assessment', GOODDOGZKC_THEME_URI . 'inc/tools/dog-assessment/css/dog-assessment.css', array(), GOODDOGZKC_THEME_VERSION );
            wp_enqueue_script( 'gdkc-dog-assessment', GOODDOGZKC_THEME_URI . 'inc/tools/dog-assessment/js/dog-assessment.js', array( 'jquery' ), GOODDOGZKC_THEME_VERSION, true );
            
            wp_localize_script( 'gdkc-dog-assessment', 'gdkcDogAssessment', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'gdkc-dog-assessment-nonce' ),
            ) );
        }
    }

    /**
     * Assessment form shortcode
     */
    public function assessment_form_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'title' => __( 'Dog Behavior Assessment', 'gooddogzkc-twentytwentyfour-child' ),
        ), $atts, 'dog_assessment_form' );

        ob_start();
        ?>
        <div class="gdkc-dog-assessment-form">
            <h2><?php echo esc_html( $atts['title'] ); ?></h2>
            <p class="assessment-intro">
                <?php _e('This assessment will help us understand your dog\'s personality, behavior patterns, and training needs. Complete all sections for a personalized training recommendation.', 'gooddogzkc-twentytwentyfour-child'); ?>
            </p>
            
            <form id="gdkc-dog-assessment" method="post">
                <div class="form-progress">
                    <div class="progress-bar">
                        <div class="progress-indicator" style="width: 0%"></div>
                    </div>
                    <div class="step-indicators">
                        <span class="step active" data-step="1">1</span>
                        <span class="step" data-step="2">2</span>
                        <span class="step" data-step="3">3</span>
                        <span class="step" data-step="4">4</span>
                        <span class="step" data-step="5">5</span>
                    </div>
                </div>
                
                <!-- Step 1: Basic Information -->
                <div class="form-section active" data-section="1">
                    <h3><?php _e( 'Basic Information', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label for="dog_name"><?php _e( 'Dog Name', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="text" id="dog_name" name="dog_name" required>
                    </div>
                    
                    <div class="form-field">
                        <label for="dog_breed"><?php _e( 'Breed', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="text" id="dog_breed" name="dog_breed" required>
                    </div>
                    
                    <div class="form-field-group">
                        <div class="form-field half">
                            <label for="dog_age"><?php _e( 'Age', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <input type="number" id="dog_age" name="dog_age" min="0" step="0.1" required>
                        </div>
                        
                        <div class="form-field half">
                            <label for="dog_gender"><?php _e( 'Gender', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <select id="dog_gender" name="dog_gender" required>
                                <option value=""><?php _e( 'Select Gender', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                                <option value="male"><?php _e( 'Male', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                                <option value="female"><?php _e( 'Female', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="dog_spayed_neutered"><?php _e( 'Is your dog spayed/neutered?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="radio-group">
                            <label><input type="radio" name="dog_spayed_neutered" value="yes" required> <?php _e( 'Yes', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="radio" name="dog_spayed_neutered" value="no"> <?php _e( 'No', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="dog_weight"><?php _e( 'Weight (lbs)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="number" id="dog_weight" name="dog_weight" min="1" required>
                    </div>
                    
                    <div class="form-field">
                        <label><?php _e( 'How long have you had your dog?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select name="time_with_dog" required>
                            <option value=""><?php _e( 'Select Time', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="less_than_month"><?php _e( 'Less than a month', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="1_6_months"><?php _e( '1-6 months', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="6_12_months"><?php _e( '6-12 months', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="1_3_years"><?php _e( '1-3 years', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="3_plus_years"><?php _e( '3+ years', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="next-step"><?php _e( 'Next', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                    </div>
                </div>
                
                <!-- Step 2: Behavior & Temperament -->
                <div class="form-section" data-section="2">
                    <h3><?php _e( 'Behavior & Temperament', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label for="energy_level"><?php _e( 'Energy Level', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="energy_level" name="energy_level" required>
                            <option value=""><?php _e( 'Select Energy Level', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="low"><?php _e( 'Low - Prefers lounging and short walks', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="medium"><?php _e( 'Medium - Enjoys regular activity but also settles down', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="high"><?php _e( 'High - Needs lots of exercise and mental stimulation', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="very_high"><?php _e( 'Very High - Constantly on the go, difficult to tire out', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="sociability_dogs"><?php _e( 'How does your dog react to other dogs?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="sociability_dogs" name="sociability_dogs" required>
                            <option value=""><?php _e( 'Select Answer', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="friendly"><?php _e( 'Friendly - Enjoys most other dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="selective"><?php _e( 'Selective - Gets along with some dogs, not others', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="fearful"><?php _e( 'Fearful - Shows fear but not aggression', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="reactive"><?php _e( 'Reactive - Barks/lunges on leash but may be OK off-leash', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="aggressive"><?php _e( 'Aggressive - Has shown aggression toward other dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="unknown"><?php _e( 'Unknown - Limited exposure to other dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="sociability_people"><?php _e( 'How does your dog react to unfamiliar people?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="sociability_people" name="sociability_people" required>
                            <option value=""><?php _e( 'Select Answer', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="very_friendly"><?php _e( 'Very Friendly - Loves everyone immediately', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="friendly"><?php _e( 'Friendly - Warms up quickly after brief introduction', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="cautious"><?php _e( 'Cautious - Takes time to warm up but eventually friendly', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="fearful"><?php _e( 'Fearful - Shows fear around new people', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="protective"><?php _e( 'Protective - May bark but settles when owner is calm', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="aggressive"><?php _e( 'Aggressive - Has shown aggression toward people', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label><?php _e( 'Which environments are challenging for your dog? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="challenging_environments[]" value="busy_streets"> <?php _e( 'Busy streets/traffic', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="dog_parks"> <?php _e( 'Dog parks', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="visitors"> <?php _e( 'Visitors in the home', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="vet"> <?php _e( 'Veterinary visits', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="car_rides"> <?php _e( 'Car rides', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="loud_noises"> <?php _e( 'Loud noises (thunder, fireworks)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="being_alone"> <?php _e( 'Being alone/separation', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="challenging_environments[]" value="none"> <?php _e( 'None of the above', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="prev-step"><?php _e( 'Previous', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                        <button type="button" class="next-step"><?php _e( 'Next', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                    </div>
                </div>
                
                <!-- Step 3: Training History -->
                <div class="form-section" data-section="3">
                    <h3><?php _e( 'Training History', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label><?php _e( 'Has your dog had previous training?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="radio-group">
                            <label><input type="radio" name="previous_training" value="yes" required> <?php _e( 'Yes', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="radio" name="previous_training" value="no"> <?php _e( 'No', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field conditional-field" data-condition="previous_training" data-value="yes">
                        <label><?php _e( 'What type of training? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="training_type[]" value="puppy_class"> <?php _e( 'Puppy class', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="basic_obedience"> <?php _e( 'Basic obedience class', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="advanced_obedience"> <?php _e( 'Advanced obedience', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="private_lessons"> <?php _e( 'Private lessons', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="board_and_train"> <?php _e( 'Board and train', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="behavior_modification"> <?php _e( 'Behavior modification', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_type[]" value="self_taught"> <?php _e( 'Self-taught (books, videos, etc.)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="training_methods"><?php _e( 'Which training methods have you used? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="training_methods[]" value="treats_rewards"> <?php _e( 'Treats/rewards', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="clicker"> <?php _e( 'Clicker training', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="verbal_praise"> <?php _e( 'Verbal praise', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="toys_play"> <?php _e( 'Toys/play rewards', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="correction_based"> <?php _e( 'Correction-based methods', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="e_collar"> <?php _e( 'E-collar/remote collar', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_methods[]" value="none"> <?php _e( 'None/haven\'t trained yet', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label><?php _e( 'Which commands does your dog know reliably? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="known_commands[]" value="sit"> <?php _e( 'Sit', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="down"> <?php _e( 'Down', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="stay"> <?php _e( 'Stay', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="come"> <?php _e( 'Come/recall', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="leave_it"> <?php _e( 'Leave it', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="heel"> <?php _e( 'Heel/loose leash walking', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="known_commands[]" value="none"> <?php _e( 'None', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="trainability"><?php _e( 'How would you describe your dog\'s trainability?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="trainability" name="trainability" required>
                            <option value=""><?php _e( 'Select Answer', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="very_eager"><?php _e( 'Very eager to learn, picks up commands quickly', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="food_motivated"><?php _e( 'Learns well when food is involved', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="play_motivated"><?php _e( 'Learns well when play is involved', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="inconsistent"><?php _e( 'Inconsistent - sometimes focused, sometimes not', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="distracted"><?php _e( 'Easily distracted, hard to keep focused', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="stubborn"><?php _e( 'Stubborn, knows commands but chooses when to listen', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="challenging"><?php _e( 'Challenging, difficulty learning new commands', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="prev-step"><?php _e( 'Previous', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                        <button type="button" class="next-step"><?php _e( 'Next', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                    </div>
                </div>
                
                <!-- Step 4: Behavior Concerns -->
                <div class="form-section" data-section="4">
                    <h3><?php _e( 'Behavior Concerns', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label><?php _e( 'What behaviors are you most concerned about? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="behavior_concerns[]" value="pulling_leash"> <?php _e( 'Pulling on leash', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="jumping"> <?php _e( 'Jumping on people', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="barking"> <?php _e( 'Excessive barking', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="house_training"> <?php _e( 'House training issues', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="destructive"> <?php _e( 'Destructive behavior', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="separation_anxiety"> <?php _e( 'Separation anxiety', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="reactivity_dogs"> <?php _e( 'Reactivity toward dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="reactivity_people"> <?php _e( 'Reactivity toward people', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="aggression"> <?php _e( 'Aggression (growling, snapping, biting)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="fear_anxiety"> <?php _e( 'Fear/anxiety issues', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="resource_guarding"> <?php _e( 'Resource guarding (food, toys, etc.)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="not_coming"> <?php _e( 'Not coming when called', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="counter_surfing"> <?php _e( 'Counter surfing/stealing food', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="behavior_concerns[]" value="none"> <?php _e( 'None - just want general training', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field conditional-field" data-condition="behavior_concerns" data-value="aggression">
                        <label><?php _e( 'If you selected aggression, please specify the circumstances (Select all that apply):', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="aggression_circumstances[]" value="toward_family"> <?php _e( 'Toward family members', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="toward_strangers"> <?php _e( 'Toward strangers', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="toward_dogs"> <?php _e( 'Toward other dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="toward_animals"> <?php _e( 'Toward other animals', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="when_guarding"> <?php _e( 'When guarding resources', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="when_scared"> <?php _e( 'When scared/startled', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="aggression_circumstances[]" value="when_handled"> <?php _e( 'When handled (grooming, vet, etc.)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="behavior_severity"><?php _e( 'How would you rate the severity of your main behavior concern?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="behavior_severity" name="behavior_severity" required>
                            <option value=""><?php _e( 'Select Severity', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="mild"><?php _e( 'Mild - Annoying but not disrupting daily life', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="moderate"><?php _e( 'Moderate - Causing some problems in daily life', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="severe"><?php _e( 'Severe - Significantly impacting daily life', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="very_severe"><?php _e( 'Very Severe - Safety concern/crisis situation', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="none"><?php _e( 'No major concerns, just want training', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="behavior_duration"><?php _e( 'How long has this behavior been an issue?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="behavior_duration" name="behavior_duration" required>
                            <option value=""><?php _e( 'Select Duration', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="recent"><?php _e( 'Recently started (less than a month)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="few_months"><?php _e( 'A few months', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="6_months"><?php _e( 'About 6 months', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="year_plus"><?php _e( 'A year or more', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="always"><?php _e( 'Always had this issue', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="none"><?php _e( 'Not applicable', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="prev-step"><?php _e( 'Previous', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                        <button type="button" class="next-step"><?php _e( 'Next', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                    </div>
                </div>
                
                <!-- Step 5: Goals & Contact Information -->
                <div class="form-section" data-section="5">
                    <h3><?php _e( 'Goals & Contact Information', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label><?php _e( 'What are your training goals? (Select all that apply)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="training_goals[]" value="basic_manners"> <?php _e( 'Basic manners/obedience', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="puppy_foundation"> <?php _e( 'Puppy foundation skills', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="advanced_obedience"> <?php _e( 'Advanced obedience', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="fix_behavior_problem"> <?php _e( 'Fix specific behavior problem(s)', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="improve_confidence"> <?php _e( 'Improve confidence/reduce fear', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="socialization"> <?php _e( 'Socialization with people/dogs', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="public_manners"> <?php _e( 'Better manners in public', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="living_with_children"> <?php _e( 'Improved behavior around children', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <label><input type="checkbox" name="training_goals[]" value="enrichment"> <?php _e( 'Mental stimulation/enrichment', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="training_preference"><?php _e( 'What type of training program are you interested in?', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="training_preference" name="training_preference" required>
                            <option value=""><?php _e( 'Select Preference', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="group"><?php _e( 'Group classes', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="private"><?php _e( 'Private lessons', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="board_train"><?php _e( 'Board and train program', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="day_training"><?php _e( 'Day training (trainer works with dog while you\'re at work)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="virtual"><?php _e( 'Virtual/online coaching', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="undecided"><?php _e( 'Not sure - need guidance', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="notes"><?php _e( 'Additional information or questions:', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <textarea id="notes" name="notes" rows="4"></textarea>
                    </div>
                    
                    <div class="form-field-group">
                        <div class="form-field half">
                            <label for="owner_name"><?php _e( 'Your Name', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <input type="text" id="owner_name" name="owner_name" required>
                        </div>
                        
                        <div class="form-field half">
                            <label for="owner_email"><?php _e( 'Email Address', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <input type="email" id="owner_email" name="owner_email" required>
                        </div>
                    </div>
                    
                    <div class="form-field-group">
                        <div class="form-field half">
                            <label for="owner_phone"><?php _e( 'Phone Number', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <input type="tel" id="owner_phone" name="owner_phone" required>
                        </div>
                        
                        <div class="form-field half">
                            <label for="owner_zip"><?php _e( 'Zip Code', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                            <input type="text" id="owner_zip" name="owner_zip" required>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="privacy_consent" required> <?php _e( 'I consent to my information being stored and used to contact me about my assessment results', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        </div>
                    </div>
                    
                    <div class="form-navigation">
                        <button type="button" class="prev-step"><?php _e( 'Previous', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                        <button type="submit" class="button button-primary"><?php _e( 'Submit Assessment', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                    </div>
                </div>
                
                <?php wp_nonce_field( 'gdkc_dog_assessment_form', 'gdkc_dog_assessment_nonce' ); ?>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Assessment results shortcode
     */
    public function assessment_results_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'title' => __( 'Dog Assessment Results', 'gooddogzkc-twentytwentyfour-child' ),
            'id'    => 0,
        ), $atts, 'dog_assessment_results' );

        if ( ! $atts['id'] ) {
            return '<p>' . __( 'No assessment ID provided.', 'gooddogzkc-twentytwentyfour-child' ) . '</p>';
        }

        $assessment = get_post( $atts['id'] );

        if ( ! $assessment || 'dog_assessment' !== $assessment->post_type ) {
            return '<p>' . __( 'Assessment not found.', 'gooddogzkc-twentytwentyfour-child' ) . '</p>';
        }

        $dog_name = get_post_meta( $assessment->ID, 'dog_name', true );
        $dog_breed = get_post_meta( $assessment->ID, 'dog_breed', true );
        $dog_age = get_post_meta( $assessment->ID, 'dog_age', true );
        $dog_gender = get_post_meta( $assessment->ID, 'dog_gender', true );
        $energy_level = get_post_meta( $assessment->ID, 'energy_level', true );
        $sociability = get_post_meta( $assessment->ID, 'sociability', true );
        $trainability = get_post_meta( $assessment->ID, 'trainability', true );
        $notes = get_post_meta( $assessment->ID, 'notes', true );

        ob_start();
        ?>
        <div class="gdkc-dog-assessment-results">
            <h2><?php echo esc_html( $atts['title'] ); ?></h2>
            
            <div class="assessment-result">
                <h3><?php echo esc_html( $dog_name ); ?></h3>
                
                <div class="result-section">
                    <h4><?php _e( 'Basic Information', 'gooddogzkc-twentytwentyfour-child' ); ?></h4>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Breed:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( $dog_breed ); ?></span>
                    </div>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Age:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( $dog_age ); ?></span>
                    </div>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Gender:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( ucfirst( $dog_gender ) ); ?></span>
                    </div>
                </div>
                
                <div class="result-section">
                    <h4><?php _e( 'Behavior Assessment', 'gooddogzkc-twentytwentyfour-child' ); ?></h4>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Energy Level:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( ucfirst( $energy_level ) ); ?></span>
                    </div>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Sociability:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( ucfirst( $sociability ) ); ?></span>
                    </div>
                    
                    <div class="result-field">
                        <span class="label"><?php _e( 'Trainability:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <span class="value"><?php echo esc_html( ucfirst( $trainability ) ); ?></span>
                    </div>
                    
                    <?php if ( $notes ) : ?>
                    <div class="result-field">
                        <span class="label"><?php _e( 'Additional Notes:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        <div class="value notes"><?php echo wpautop( esc_html( $notes ) ); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Initialize the class
new GDKC_Dog_Assessment();
