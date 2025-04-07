<?php
/**
 * Template Name: Homepage with Lava Animation
 * Description: A custom homepage template with lava animation background and service cards
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
        // Default homepage components with lava animation hero
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
    
    // If page content should be shown
    $show_content = get_post_meta(get_the_ID(), '_gdkc_show_page_content', true);
    if ($show_content !== 'hide') {
        // Display the page content
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</main>

<?php
get_footer();
?>
