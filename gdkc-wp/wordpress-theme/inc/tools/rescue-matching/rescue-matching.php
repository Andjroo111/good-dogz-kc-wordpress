<?php
/**
 * Rescue Matching Tool
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
 * Rescue Matching Class
 */
class GDKC_Rescue_Matching {
    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_shortcode( 'rescue_matching_form', array( $this, 'matching_form_shortcode' ) );
        add_shortcode( 'rescue_matching_results', array( $this, 'matching_results_shortcode' ) );
        add_action( 'wp_ajax_gdkc_rescue_matching', array( $this, 'process_matching' ) );
        add_action( 'wp_ajax_nopriv_gdkc_rescue_matching', array( $this, 'process_matching' ) );
    }

    /**
     * Register post types
     */
    public function register_post_types() {
        // Rescue Dogs Post Type
        $labels = array(
            'name'               => _x( 'Rescue Dogs', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Rescue Dog', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Rescue Dogs', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Rescue Dog', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'rescue dog', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Rescue Dog', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Rescue Dog', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Rescue Dog', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Rescue Dog', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Rescue Dogs', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Rescue Dogs', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Rescue Dogs:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No rescue dogs found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No rescue dogs found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Rescue dogs available for adoption', 'gooddogzkc-twentytwentyfour-child' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'rescue-dog' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
            'menu_icon'          => 'dashicons-heart',
        );

        register_post_type( 'rescue_dog', $args );

        // Matching Results Post Type
        $labels = array(
            'name'               => _x( 'Matching Results', 'post type general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'      => _x( 'Matching Result', 'post type singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'          => _x( 'Matching Results', 'admin menu', 'gooddogzkc-twentytwentyfour-child' ),
            'name_admin_bar'     => _x( 'Matching Result', 'add new on admin bar', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new'            => _x( 'Add New', 'matching result', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'       => __( 'Add New Matching Result', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item'           => __( 'New Matching Result', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'          => __( 'Edit Matching Result', 'gooddogzkc-twentytwentyfour-child' ),
            'view_item'          => __( 'View Matching Result', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'          => __( 'All Matching Results', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'       => __( 'Search Matching Results', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon'  => __( 'Parent Matching Results:', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'          => __( 'No matching results found.', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found_in_trash' => __( 'No matching results found in Trash.', 'gooddogzkc-twentytwentyfour-child' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Rescue dog matching results', 'gooddogzkc-twentytwentyfour-child' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => 'edit.php?post_type=rescue_dog',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'matching-result' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'author', 'custom-fields' ),
        );

        register_post_type( 'matching_result', $args );
    }

    /**
     * Register taxonomies
     */
    public function register_taxonomies() {
        // Dog Breeds
        $labels = array(
            'name'              => _x( 'Breeds', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Breed', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Breeds', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Breed:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Breed', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Breed Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Breeds', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'dog-breed' ),
        );

        register_taxonomy( 'dog_breed', array( 'rescue_dog' ), $args );

        // Dog Sizes
        $labels = array(
            'name'              => _x( 'Sizes', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Size', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Sizes', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Sizes', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Size', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Size:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Size', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Size', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Size', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Size Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Sizes', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'dog-size' ),
        );

        register_taxonomy( 'dog_size', array( 'rescue_dog' ), $args );

        // Dog Ages
        $labels = array(
            'name'              => _x( 'Ages', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'     => _x( 'Age', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'      => __( 'Search Ages', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'         => __( 'All Ages', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'       => __( 'Parent Age', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item_colon' => __( 'Parent Age:', 'gooddogzkc-twentytwentyfour-child' ),
            'edit_item'         => __( 'Edit Age', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'       => __( 'Update Age', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'      => __( 'Add New Age', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'     => __( 'New Age Name', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'         => __( 'Ages', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'dog-age' ),
        );

        register_taxonomy( 'dog_age', array( 'rescue_dog' ), $args );

        // Dog Temperaments
        $labels = array(
            'name'                       => _x( 'Temperaments', 'taxonomy general name', 'gooddogzkc-twentytwentyfour-child' ),
            'singular_name'              => _x( 'Temperament', 'taxonomy singular name', 'gooddogzkc-twentytwentyfour-child' ),
            'search_items'               => __( 'Search Temperaments', 'gooddogzkc-twentytwentyfour-child' ),
            'popular_items'              => __( 'Popular Temperaments', 'gooddogzkc-twentytwentyfour-child' ),
            'all_items'                  => __( 'All Temperaments', 'gooddogzkc-twentytwentyfour-child' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Temperament', 'gooddogzkc-twentytwentyfour-child' ),
            'update_item'                => __( 'Update Temperament', 'gooddogzkc-twentytwentyfour-child' ),
            'add_new_item'               => __( 'Add New Temperament', 'gooddogzkc-twentytwentyfour-child' ),
            'new_item_name'              => __( 'New Temperament Name', 'gooddogzkc-twentytwentyfour-child' ),
            'separate_items_with_commas' => __( 'Separate temperaments with commas', 'gooddogzkc-twentytwentyfour-child' ),
            'add_or_remove_items'        => __( 'Add or remove temperaments', 'gooddogzkc-twentytwentyfour-child' ),
            'choose_from_most_used'      => __( 'Choose from the most used temperaments', 'gooddogzkc-twentytwentyfour-child' ),
            'not_found'                  => __( 'No temperaments found.', 'gooddogzkc-twentytwentyfour-child' ),
            'menu_name'                  => __( 'Temperaments', 'gooddogzkc-twentytwentyfour-child' ),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'dog-temperament' ),
        );

        register_taxonomy( 'dog_temperament', 'rescue_dog', $args );
    }

    /**
     * Enqueue scripts
     */
    public function enqueue_scripts() {
        if ( has_shortcode( get_post()->post_content, 'rescue_matching_form' ) || has_shortcode( get_post()->post_content, 'rescue_matching_results' ) ) {
            wp_enqueue_style( 'gdkc-rescue-matching', GOODDOGZKC_THEME_URI . 'inc/tools/rescue-matching/css/rescue-matching.css', array(), GOODDOGZKC_THEME_VERSION );
            wp_enqueue_script( 'gdkc-rescue-matching', GOODDOGZKC_THEME_URI . 'inc/tools/rescue-matching/js/rescue-matching.js', array( 'jquery' ), GOODDOGZKC_THEME_VERSION, true );
            
            wp_localize_script( 'gdkc-rescue-matching', 'gdkcRescueMatching', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'gdkc-rescue-matching-nonce' ),
            ) );
        }
    }

    /**
     * Matching form shortcode
     */
    public function matching_form_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'title' => __( 'Find Your Perfect Rescue Dog', 'gooddogzkc-twentytwentyfour-child' ),
        ), $atts, 'rescue_matching_form' );

        // Get all dog breeds
        $breeds = get_terms( array(
            'taxonomy'   => 'dog_breed',
            'hide_empty' => false,
        ) );

        // Get all dog sizes
        $sizes = get_terms( array(
            'taxonomy'   => 'dog_size',
            'hide_empty' => false,
        ) );

        // Get all dog ages
        $ages = get_terms( array(
            'taxonomy'   => 'dog_age',
            'hide_empty' => false,
        ) );

        // Get all dog temperaments
        $temperaments = get_terms( array(
            'taxonomy'   => 'dog_temperament',
            'hide_empty' => false,
        ) );

        ob_start();
        ?>
        <div class="gdkc-rescue-matching-form">
            <h2><?php echo esc_html( $atts['title'] ); ?></h2>
            <form id="gdkc-rescue-matching" method="post">
                <div class="form-section">
                    <h3><?php _e( 'Your Preferences', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label for="name"><?php _e( 'Your Name', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-field">
                        <label for="email"><?php _e( 'Email Address', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-field">
                        <label for="phone"><?php _e( 'Phone Number', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                </div>
                
                <div class="form-section">
                    <h3><?php _e( 'Dog Preferences', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label for="preferred_breeds"><?php _e( 'Preferred Breeds', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="preferred_breeds" name="preferred_breeds[]" multiple>
                            <?php foreach ( $breeds as $breed ) : ?>
                                <option value="<?php echo esc_attr( $breed->term_id ); ?>"><?php echo esc_html( $breed->name ); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="description"><?php _e( 'Hold Ctrl/Cmd to select multiple', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                    </div>
                    
                    <div class="form-field">
                        <label for="preferred_sizes"><?php _e( 'Preferred Sizes', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <?php foreach ( $sizes as $size ) : ?>
                                <label>
                                    <input type="checkbox" name="preferred_sizes[]" value="<?php echo esc_attr( $size->term_id ); ?>">
                                    <?php echo esc_html( $size->name ); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="preferred_ages"><?php _e( 'Preferred Ages', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <?php foreach ( $ages as $age ) : ?>
                                <label>
                                    <input type="checkbox" name="preferred_ages[]" value="<?php echo esc_attr( $age->term_id ); ?>">
                                    <?php echo esc_html( $age->name ); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="preferred_temperaments"><?php _e( 'Preferred Temperaments', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <?php foreach ( $temperaments as $temperament ) : ?>
                                <label>
                                    <input type="checkbox" name="preferred_temperaments[]" value="<?php echo esc_attr( $temperament->term_id ); ?>">
                                    <?php echo esc_html( $temperament->name ); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3><?php _e( 'Lifestyle & Environment', 'gooddogzkc-twentytwentyfour-child' ); ?></h3>
                    
                    <div class="form-field">
                        <label for="home_type"><?php _e( 'Home Type', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="home_type" name="home_type">
                            <option value=""><?php _e( 'Select Home Type', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="apartment"><?php _e( 'Apartment', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="house_no_yard"><?php _e( 'House without Yard', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="house_small_yard"><?php _e( 'House with Small Yard', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="house_large_yard"><?php _e( 'House with Large Yard', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="rural"><?php _e( 'Rural Property', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="activity_level"><?php _e( 'Your Activity Level', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="activity_level" name="activity_level">
                            <option value=""><?php _e( 'Select Activity Level', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="sedentary"><?php _e( 'Sedentary', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="light"><?php _e( 'Light (short walks)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="moderate"><?php _e( 'Moderate (regular walks/play)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="active"><?php _e( 'Active (long walks, hiking)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="very_active"><?php _e( 'Very Active (running, sports)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="hours_alone"><?php _e( 'Hours Dog Will Be Alone', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="hours_alone" name="hours_alone">
                            <option value=""><?php _e( 'Select Hours', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="0-2"><?php _e( '0-2 hours', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="3-5"><?php _e( '3-5 hours', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="6-8"><?php _e( '6-8 hours', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="8+"><?php _e( '8+ hours', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="other_pets"><?php _e( 'Other Pets in Home', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="other_pets[]" value="dogs">
                                <?php _e( 'Dogs', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="other_pets[]" value="cats">
                                <?php _e( 'Cats', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="other_pets[]" value="small_animals">
                                <?php _e( 'Small Animals', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="other_pets[]" value="none">
                                <?php _e( 'None', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="children"><?php _e( 'Children in Home', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="children[]" value="under_5">
                                <?php _e( 'Under 5 years', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="children[]" value="5_12">
                                <?php _e( '5-12 years', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="children[]" value="13_18">
                                <?php _e( '13-18 years', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                            <label>
                                <input type="checkbox" name="children[]" value="none">
                                <?php _e( 'No children', 'gooddogzkc-twentytwentyfour-child' ); ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <label for="experience"><?php _e( 'Dog Ownership Experience', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <select id="experience" name="experience">
                            <option value=""><?php _e( 'Select Experience Level', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="first_time"><?php _e( 'First-time owner', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="some"><?php _e( 'Some experience', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="experienced"><?php _e( 'Experienced owner', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                            <option value="professional"><?php _e( 'Professional (trainer, vet, etc.)', 'gooddogzkc-twentytwentyfour-child' ); ?></option>
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="additional_notes"><?php _e( 'Additional Notes', 'gooddogzkc-twentytwentyfour-child' ); ?></label>
                        <textarea id="additional_notes" name="additional_notes" rows="4"></textarea>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="button button-primary"><?php _e( 'Find My Match', 'gooddogzkc-twentytwentyfour-child' ); ?></button>
                </div>
                
                <?php wp_nonce_field( 'gdkc_rescue_matching_form', 'gdkc_rescue_matching_nonce' ); ?>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Matching results shortcode
     */
    public function matching_results_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'title' => __( 'Your Rescue Dog Matches', 'gooddogzkc-twentytwentyfour-child' ),
            'id'    => 0,
        ), $atts, 'rescue_matching_results' );

        if ( ! $atts['id'] ) {
            return '<p>' . __( 'No matching result ID provided.', 'gooddogzkc-twentytwentyfour-child' ) . '</p>';
        }

        $result = get_post( $atts['id'] );

        if ( ! $result || 'matching_result' !== $result->post_type ) {
            return '<p>' . __( 'Matching result not found.', 'gooddogzkc-twentytwentyfour-child' ) . '</p>';
        }

        $matches = get_post_meta( $result->ID, 'matches', true );
        
        if ( empty( $matches ) ) {
            return '<p>' . __( 'No matches found.', 'gooddogzkc-twentytwentyfour-child' ) . '</p>';
        }

        ob_start();
        ?>
        <div class="gdkc-rescue-matching-results">
            <h2><?php echo esc_html( $atts['title'] ); ?></h2>
            
            <div class="matching-results">
                <?php foreach ( $matches as $match ) : 
                    $dog = get_post( $match['dog_id'] );
                    if ( ! $dog ) continue;
                    
                    $thumbnail = get_the_post_thumbnail_url( $dog->ID, 'medium' );
                    $breeds = wp_get_post_terms( $dog->ID, 'dog_breed', array( 'fields' => 'names' ) );
                    $sizes = wp_get_post_terms( $dog->ID, 'dog_size', array( 'fields' => 'names' ) );
                    $ages = wp_get_post_terms( $dog->ID, 'dog_age', array( 'fields' => 'names' ) );
                    $temperaments = wp_get_post_terms( $dog->ID, 'dog_temperament', array( 'fields' => 'names' ) );
                ?>
                    <div class="match-card">
                        <div class="match-score">
                            <span class="score"><?php echo esc_html( $match['score'] ); ?>%</span>
                            <span class="label"><?php _e( 'Match', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                        </div>
                        
                        <div class="match-content">
                            <?php if ( $thumbnail ) : ?>
                                <div class="match-image">
                                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $dog->post_title ); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="match-details">
                                <h3 class="match-name">
                                    <a href="<?php echo esc_url( get_permalink( $dog->ID ) ); ?>"><?php echo esc_html( $dog->post_title ); ?></a>
                                </h3>
                                
                                <?php if ( ! empty( $breeds ) ) : ?>
                                    <div class="match-breeds">
                                        <span class="label"><?php _e( 'Breed:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                                        <span class="value"><?php echo esc_html( implode( ', ', $breeds ) ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $sizes ) ) : ?>
                                    <div class="match-sizes">
                                        <span class="label"><?php _e( 'Size:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                                        <span class="value"><?php echo esc_html( implode( ', ', $sizes ) ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $ages ) ) : ?>
                                    <div class="match-ages">
                                        <span class="label"><?php _e( 'Age:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                                        <span class="value"><?php echo esc_html( implode( ', ', $ages ) ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $temperaments ) ) : ?>
                                    <div class="match-temperaments">
                                        <span class="label"><?php _e( 'Temperament:', 'gooddogzkc-twentytwentyfour-child' ); ?></span>
                                        <span class="value"><?php echo esc_html( implode( ', ', $temperaments ) ); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="match-excerpt">
                                    <?php echo wp_kses_post( get_the_excerpt( $dog ) ); ?>
                                </div>
                                
                                <div class="match-actions">
                                    <a href="<?php echo esc_url( get_permalink( $dog->ID ) ); ?>" class="button"><?php _e( 'View Details', 'gooddogzkc-twentytwentyfour-child' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Process matching
     */
    public function process_matching() {
        // Verify nonce
        if ( ! isset( $_POST['gdkc_rescue_matching_nonce'] ) || ! wp_verify_nonce( $_POST['gdkc_rescue_matching_nonce'], 'gdkc_rescue_matching_form' ) ) {
            wp_send_json_error( array( 'message' => __( 'Security check failed.', 'gooddogzkc-twentytwentyfour-child' ) ) );
        }

        // Get form data
        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
        $phone = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
        
        // Get preferences
        $preferred_breeds = isset( $_POST['preferred_breeds'] ) ? array_map( 'intval', (array) $_POST['preferred_breeds'] ) : array();
        $preferred_sizes = isset( $_POST['preferred_sizes'] ) ? array_map( 'intval', (array) $_POST['preferred_sizes'] ) : array();
        $preferred_ages = isset( $_POST['preferred_ages'] ) ? array_map( 'intval', (array) $_POST['preferred_ages'] ) : array();
        $preferred_temperaments = isset( $_POST['preferred_temperaments'] ) ? array_map( 'intval', (array) $_POST['preferred_temperaments'] ) : array();
        
        // Get lifestyle data
        $home_type = isset( $_POST['home_type'] ) ? sanitize_text_field( $_POST['home_type'] ) : '';
        $activity_level = isset( $_POST['activity_level'] ) ? sanitize_text_field( $_POST['activity_level'] ) : '';
        $hours_alone = isset( $_POST['hours_alone'] ) ? sanitize_text_field( $_POST['hours_alone'] ) : '';
        $other_pets = isset( $_POST['other_pets'] ) ? array_map( 'sanitize_text_field', (array) $_POST['other_pets'] ) : array();
        $children = isset( $_POST['children'] ) ? array_map( 'sanitize_text_field', (array) $_POST['children'] ) : array();
        $experience = isset( $_POST['experience'] ) ? sanitize_text_field( $_POST['experience'] ) : '';
        $additional_notes = isset( $_POST['additional_notes'] ) ? sanitize_textarea_field( $_POST['additional_notes'] ) : '';
        
        // Create a new matching result post
        $result_id = wp_insert_post( array(
            'post_title'   => sprintf( __( 'Matching Result for %s', 'gooddogzkc-twentytwentyfour-child' ), $name ),
            'post_type'    => 'matching_result',
            'post_status'  => 'publish',
            'post_content' => '',
        ) );
        
        if ( is_wp_error( $result_id ) ) {
            wp_send_json_error( array( 'message' => $result_id->get_error_message() ) );
        }
        
        // Save user data
        update_post_meta( $result_id, 'name', $name );
        update_post_meta( $result_id, 'email', $email );
        update_post_meta( $result_id, 'phone', $phone );
        
        // Save preferences
        update_post_meta( $result_id, 'preferred_breeds', $preferred_breeds );
        update_post_meta( $result_id, 'preferred_sizes', $preferred_sizes );
        update_post_meta( $result_id, 'preferred_ages', $preferred_ages );
        update_post_meta( $result_id, 'preferred_temperaments', $preferred_temperaments );
        
        // Save lifestyle data
        update_post_meta( $result_id, 'home_type', $home_type );
        update_post_meta( $result_id, 'activity_level', $activity_level );
        update_post_meta( $result_id, 'hours_alone', $hours_alone );
        update_post_meta( $result_id, 'other_pets', $other_pets );
        update_post_meta( $result_id, 'children', $children );
        update_post_meta( $result_id, 'experience', $experience );
        update_post_meta( $result_id, 'additional_notes', $additional_notes );
        
        // Find matching dogs
        $matches = $this->find_matches( $result_id );
        
        // Save matches
        update_post_meta( $result_id, 'matches', $matches );
        
        // Return success
        wp_send_json_success( array(
            'message'    => __( 'Matching complete!', 'gooddogzkc-twentytwentyfour-child' ),
            'result_id'  => $result_id,
            'result_url' => add_query_arg( 'id', $result_id, get_permalink( get_page_by_path( 'rescue-matching-results' ) ) ),
        ) );
    }

    /**
     * Find matches
     *
     * @param int $result_id The matching result post ID
     * @return array Array of matching dogs with scores
     */
    private function find_matches( $result_id ) {
        // Get preferences
        $preferred_breeds = get_post_meta( $result_id, 'preferred_breeds', true );
        $preferred_sizes = get_post_meta( $result_id, 'preferred_sizes', true );
        $preferred_ages = get_post_meta( $result_id, 'preferred_ages', true );
        $preferred_temperaments = get_post_meta( $result_id, 'preferred_temperaments', true );
        
        // Get lifestyle data
        $home_type = get_post_meta( $result_id, 'home_type', true );
        $activity_level = get_post_meta( $result_id, 'activity_level', true );
        $hours_alone = get_post_meta( $result_id, 'hours_alone', true );
        $other_pets = get_post_meta( $result_id, 'other_pets', true );
        $children = get_post_meta( $result_id, 'children', true );
        $experience = get_post_meta( $result_id, 'experience', true );
        
        // Get all available dogs
        $args = array(
            'post_type'      => 'rescue_dog',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        
        $dogs = get_posts( $args );
        
        $matches = array();
        
        foreach ( $dogs as $dog ) {
            $score = 0;
            $total_factors = 0;
            
            // Check breed match
            if ( ! empty( $preferred_breeds ) ) {
                $dog_breeds = wp_get_post_terms( $dog->ID, 'dog_breed', array( 'fields' => 'ids' ) );
                $breed_match = count( array_intersect( $preferred_breeds, $dog_breeds ) ) > 0;
                $score += $breed_match ? 1 : 0;
                $total_factors++;
            }
            
            // Check size match
            if ( ! empty( $preferred_sizes ) ) {
                $dog_sizes = wp_get_post_terms( $dog->ID, 'dog_size', array( 'fields' => 'ids' ) );
                $size_match = count( array_intersect( $preferred_sizes, $dog_sizes ) ) > 0;
                $score += $size_match ? 1 : 0;
                $total_factors++;
            }
            
            // Check age match
            if ( ! empty( $preferred_ages ) ) {
                $dog_ages = wp_get_post_terms( $dog->ID, 'dog_age', array( 'fields' => 'ids' ) );
                $age_match = count( array_intersect( $preferred_ages, $dog_ages ) ) > 0;
                $score += $age_match ? 1 : 0;
                $total_factors++;
            }
            
            // Check temperament match
            if ( ! empty( $preferred_temperaments ) ) {
                $dog_temperaments = wp_get_post_terms( $dog->ID, 'dog_temperament', array( 'fields' => 'ids' ) );
                $temperament_match = count( array_intersect( $preferred_temperaments, $dog_temperaments ) ) > 0;
                $score += $temperament_match ? 1 : 0;
                $total_factors++;
            }
            
            // Check home type compatibility
            if ( ! empty( $home_type ) ) {
                $dog_home_type = get_post_meta( $dog->ID, 'home_type', true );
                $home_type_match = empty( $dog_home_type ) || $dog_home_type === $home_type;
                $score += $home_type_match ? 1 : 0;
                $total_factors++;
            }
            
            // Check activity level compatibility
            if ( ! empty( $activity_level ) ) {
                $dog_activity_level = get_post_meta( $dog->ID, 'activity_level', true );
                $activity_level_match = empty( $dog_activity_level ) || $dog_activity_level === $activity_level;
                $score += $activity_level_match ? 1 : 0;
                $total_factors++;
            }
            
            // Calculate final percentage score
            $percentage_score = $total_factors > 0 ? round( ( $score / $total_factors ) * 100 ) : 0;
            
            // Add to matches if score is above threshold
            if ( $percentage_score >= 50 ) {
                $matches[] = array(
                    'dog_id' => $dog->ID,
                    'score'  => $percentage_score,
                );
            }
        }
        
        // Sort matches by score (highest first)
        usort( $matches, function( $a, $b ) {
            return $b['score'] - $a['score'];
        } );
        
        // Limit to top 10 matches
        $matches = array_slice( $matches, 0, 10 );
        
        return $matches;
    }
}

// Initialize the class
new GDKC_Rescue_Matching();
