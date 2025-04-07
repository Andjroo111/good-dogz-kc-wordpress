<?php
/**
 * The header for the Good Dogz KC theme
 *
 * @package GoodDogzKC
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Skip to content link -->
    <a href="#primary" class="skip-to-content">Skip to main content</a>
    
    <!-- Header -->
    <header class="site-header" role="banner">
        <div class="container header-container">
            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                else :
                ?>
                    <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
                <?php endif; ?>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button id="hamburger" class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-list',
                        'container_class' => 'container nav-container',
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </nav>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
                <?php 
                if ( has_custom_logo() ) {
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    if ( $logo ) {
                        echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . ' Logo" class="site-logo mobile-logo">';
                    }
                } else {
                    echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>';
                }
                ?>
            </a>
            
            <button id="closeButton" class="mobile-menu-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-menu-nav',
                    'menu_class'     => 'mobile-menu-list',
                    'container'      => '',
                    'fallback_cb'    => false,
                )
            );
            ?>
        </nav>
        
        <!-- Contact Button -->
        <div class="mobile-quick-actions">
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="quick-action-button schedule">
                Book Training
            </a>
        </div>
    </div>

    <main id="primary" class="site-main">