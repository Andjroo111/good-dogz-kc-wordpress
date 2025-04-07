<?php
/**
 * Template Name: Modular Page
 * Description: A flexible page template that can include any combination of homepage components
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main">
    
    <?php if (is_page() && !post_password_required()) : ?>
        
        <?php
        // Check if this page has a content section at the top
        $show_content = get_post_meta(get_the_ID(), '_gdkc_show_page_content', true);
        
        if ($show_content !== 'hide') :
        ?>
        <section class="page-content">
            <div class="container">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="page-content-inner">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        <?php
        // Load any selected components for this page
        gdkc_load_page_components();
        ?>
        
    <?php else : ?>
        
        <section class="page-content">
            <div class="container">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="page-content-inner">
                    <?php
                    if (post_password_required()) {
                        echo get_the_password_form();
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
        </section>
        
    <?php endif; ?>
    
</main>

<?php
get_footer();
?>