<?php
/**
 * Good Dogz KC - Twenty Twenty-Four Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
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
 * Define Constants
 */
define( 'GOODDOGZKC_THEME_VERSION', '1.0.0' );
define( 'GOODDOGZKC_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );
define( 'GOODDOGZKC_THEME_URI', trailingslashit( get_stylesheet_directory_uri() ) );

/**
 * Enqueue styles and scripts
 */
function gooddogzkc_enqueue_styles() {
    // Enqueue parent theme stylesheet automatically via @import in style.css
    
    // Register custom fonts
    wp_enqueue_style(
        'gooddogzkc-fonts',
        GOODDOGZKC_THEME_URI . 'assets/css/fonts.css',
        array(),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Register Adobe Typekit for Proxima Soft
    wp_enqueue_style(
        'gooddogzkc-typekit',
        'https://use.typekit.net/roc7klc.css',
        array(),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Register brand colors
    wp_enqueue_style(
        'gooddogzkc-colors',
        GOODDOGZKC_THEME_URI . 'assets/css/colors.css',
        array(),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue child theme stylesheet for customizations
    wp_enqueue_style(
        'gooddogzkc-style',
        get_stylesheet_uri(),
        array( 'gooddogzkc-fonts', 'gooddogzkc-colors' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue component styles - Buttons
    wp_enqueue_style(
        'gooddogzkc-buttons',
        GOODDOGZKC_THEME_URI . 'assets/css/components/buttons.css',
        array( 'gooddogzkc-style' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue component styles - Cards
    wp_enqueue_style(
        'gooddogzkc-cards',
        GOODDOGZKC_THEME_URI . 'assets/css/components/cards.css',
        array( 'gooddogzkc-style' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue component styles - Navigation
    wp_enqueue_style(
        'gooddogzkc-navigation',
        GOODDOGZKC_THEME_URI . 'assets/css/components/navigation.css',
        array( 'gooddogzkc-style' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue component styles - Forms
    wp_enqueue_style(
        'gooddogzkc-forms',
        GOODDOGZKC_THEME_URI . 'assets/css/components/forms.css',
        array( 'gooddogzkc-style' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue section-specific styles
    wp_enqueue_style(
        'gooddogzkc-sections',
        GOODDOGZKC_THEME_URI . 'assets/css/sections.css',
        array( 'gooddogzkc-style' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue base styles
    wp_enqueue_style(
        'gooddogzkc-base-styles',
        GOODDOGZKC_THEME_URI . 'assets/css/styles.css',
        array( 'gooddogzkc-style', 'gooddogzkc-buttons', 'gooddogzkc-cards', 'gooddogzkc-navigation', 'gooddogzkc-forms', 'gooddogzkc-sections' ),
        GOODDOGZKC_THEME_VERSION
    );
    
    // Enqueue custom scripts
    wp_enqueue_script(
        'gooddogzkc-main',
        GOODDOGZKC_THEME_URI . 'assets/js/main.js',
        array( 'jquery' ),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    // Enqueue section-specific scripts
    wp_enqueue_script(
        'gooddogzkc-sections',
        GOODDOGZKC_THEME_URI . 'assets/js/sections.js',
        array( 'jquery', 'gooddogzkc-main' ),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    // Enqueue menu solution script
    wp_enqueue_script(
        'gooddogzkc-menu-solution',
        GOODDOGZKC_THEME_URI . 'assets/js/menu-solution.js',
        array( 'jquery' ),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    // Enqueue lava lamp animation script
    wp_enqueue_script(
        'gooddogzkc-lava-lamp', 
        GOODDOGZKC_THEME_URI . 'assets/js/lava-lamp.js', 
        array(), 
        filemtime(GOODDOGZKC_THEME_DIR . 'assets/js/lava-lamp.js'), 
        true
    );
    
    // Enqueue component scripts
    wp_enqueue_script(
        'gooddogzkc-modals',
        GOODDOGZKC_THEME_URI . 'assets/js/components/modals.js',
        array('jquery'),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    wp_enqueue_script(
        'gooddogzkc-tabs',
        GOODDOGZKC_THEME_URI . 'assets/js/components/tabs.js',
        array('jquery'),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    wp_enqueue_script(
        'gooddogzkc-dropdowns',
        GOODDOGZKC_THEME_URI . 'assets/js/components/dropdowns.js',
        array('jquery'),
        GOODDOGZKC_THEME_VERSION,
        true
    );
    
    wp_enqueue_script(
        'gooddogzkc-lightbox',
        GOODDOGZKC_THEME_URI . 'assets/js/components/lightbox.js',
        array('jquery'),
        GOODDOGZKC_THEME_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'gooddogzkc_enqueue_styles' );

/**
 * Register navigation menus
 */
function gooddogzkc_register_menus() {
    register_nav_menus(
        array(
            'primary'   => __( 'Primary Menu', 'gooddogzkc-twentytwentyfour-child' ),
            'footer'    => __( 'Footer Menu', 'gooddogzkc-twentytwentyfour-child' ),
            'social'    => __( 'Social Links Menu', 'gooddogzkc-twentytwentyfour-child' ),
            'resources' => __( 'Resources Menu', 'gooddogzkc-twentytwentyfour-child' ),
        )
    );
}
add_action( 'init', 'gooddogzkc_register_menus' );

/**
 * Register widget areas
 */
function gooddogzkc_widgets_init() {
    register_sidebar(
        array(
            'name'          => __( 'Footer Widget Area', 'gooddogzkc-twentytwentyfour-child' ),
            'id'            => 'sidebar-footer',
            'description'   => __( 'Add widgets here to appear in your footer.', 'gooddogzkc-twentytwentyfour-child' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'gooddogzkc_widgets_init' );

/**
 * Include additional functionality
 */
// Custom post types
require_once GOODDOGZKC_THEME_DIR . 'inc/custom-post-types.php';

// ACF custom fields
require_once GOODDOGZKC_THEME_DIR . 'inc/acf-fields.php';

// Admin customizations
require_once GOODDOGZKC_THEME_DIR . 'inc/admin-customizations.php';

// Custom template tags
// require_once GOODDOGZKC_THEME_DIR . 'inc/template-tags.php';

// Customizer additions
// require_once GOODDOGZKC_THEME_DIR . 'inc/customizer.php';

// Template functions
require_once GOODDOGZKC_THEME_DIR . 'includes/template-functions.php';

/**
 * Include tools functionality
 */
// Dog Assessment Tool
require_once GOODDOGZKC_THEME_DIR . 'inc/tools/dog-assessment/dog-assessment.php';
require_once GOODDOGZKC_THEME_DIR . 'inc/tools/dog-assessment/process-assessment.php';
require_once GOODDOGZKC_THEME_DIR . 'inc/tools/dog-assessment/test-flow.php';

// Add shortcode for the dog assessment form
function gdkc_dog_assessment_form_shortcode() {
    ob_start();
    include_once GOODDOGZKC_THEME_DIR . 'inc/tools/dog-assessment/dog-assessment.php';
    return ob_get_clean();
}
add_shortcode('dog_assessment_form', 'gdkc_dog_assessment_form_shortcode');

// Enqueue Assessment CSS and JS when needed
function gdkc_enqueue_assessment_assets() {
    if (is_page('dog-behavior-assessment') || is_page('assessment-results')) {
        wp_enqueue_style('gdkc-dog-assessment', GOODDOGZKC_THEME_URI . 'inc/tools/dog-assessment/css/dog-assessment.css', array(), '1.0.0');
        wp_enqueue_script('gdkc-dog-assessment-js', GOODDOGZKC_THEME_URI . 'inc/tools/dog-assessment/js/dog-assessment.js', array('jquery'), '1.0.0', true);
        
        // Add AJAX URL for form submission
        wp_localize_script('gdkc-dog-assessment-js', 'gdkcDogAssessment', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }
    
    // Enqueue Success Stories CSS
    if (is_post_type_archive('gdkc_success') || is_singular('gdkc_success')) {
        wp_enqueue_style('gdkc-success-stories', GOODDOGZKC_THEME_URI . 'assets/css/gdkc-success-stories.css', array(), '1.0.0');
    }
    
    // Enqueue Resources CSS
    if (is_post_type_archive('gdkc_resource') || is_singular('gdkc_resource')) {
        wp_enqueue_style('gdkc-resources', GOODDOGZKC_THEME_URI . 'assets/css/gdkc-resources.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'gdkc_enqueue_assessment_assets', 15);

// Rescue Matching Tool
require_once GOODDOGZKC_THEME_DIR . 'inc/tools/rescue-matching/rescue-matching.php';

// Task Management Tool
require_once GOODDOGZKC_THEME_DIR . 'inc/tools/task-management/task-management.php';
