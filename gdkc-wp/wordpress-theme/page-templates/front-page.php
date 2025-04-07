<?php
/**
 * Template Name: Front Page
 * Description: Custom front page template for Good Dogz KC
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main">
    <?php
    // Check if there are any components set for this page
    $components = get_post_meta(get_the_ID(), '_gdkc_page_components', true);
    
    // If no components are specifically set for the homepage, use default components
    if (empty($components) || !is_array($components)) {
        // Default homepage components
        $default_components = [
            'hero',
            'social-proof',
            'transformation',
            'lead-magnet',
            'problem-solution',
            'testimonials',
            'programs',
            'faq',
            'contact'
        ];
        
        // Load default components
        foreach ($default_components as $component) {
            gdkc_load_home_component($component);
        }
    } else {
        // Load the page's configured components
        gdkc_load_page_components();
    }
    ?>
</main>

<?php
get_footer();
?>
