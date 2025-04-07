<?php
/**
 * Template part for displaying a sticky CTA bar at the bottom of the page
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

// Get settings from theme mods
$show_sticky_cta = get_theme_mod('show_sticky_cta', true);
$cta_title = get_theme_mod('sticky_cta_title', 'Transform Your Dog\'s Behavior');
$cta_subtitle = get_theme_mod('sticky_cta_subtitle', 'Book your free consultation today');
$cta_button_text = get_theme_mod('sticky_cta_button_text', 'Book Consultation');
$cta_button_url = get_theme_mod('sticky_cta_button_url', '#contact');
$cta_phone = get_theme_mod('sticky_cta_phone', '(816) 555-1234');
$scroll_trigger = get_theme_mod('sticky_cta_scroll_trigger', 300);

// Show cookie notice
$show_cookie_notice = get_theme_mod('show_cookie_notice', true);
$cookie_text = get_theme_mod('cookie_notice_text', 'We use cookies to improve your experience on our website. By continuing to browse, you agree to our use of cookies.');
$cookie_accept_text = get_theme_mod('cookie_accept_text', 'Accept');
$cookie_decline_text = get_theme_mod('cookie_decline_text', 'Decline');

// Check if we should show the sticky CTA
if (!$show_sticky_cta) {
    return;
}
?>

<!-- Sticky CTA Bar -->
<div class="sticky-cta-bar" id="sticky-cta-bar">
    <div class="container sticky-cta-container">
        <div class="sticky-cta-text">
            <div class="sticky-cta-title"><?php echo esc_html($cta_title); ?></div>
            <div class="sticky-cta-subtitle"><?php echo esc_html($cta_subtitle); ?></div>
        </div>
        
        <div class="sticky-cta-actions">
            <?php if ($cta_phone) : ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $cta_phone)); ?>" class="sticky-phone-link">
                    <i class="fas fa-phone-alt"></i>
                    <span><?php echo esc_html($cta_phone); ?></span>
                </a>
            <?php endif; ?>
            
            <a href="<?php echo esc_url($cta_button_url); ?>" class="gdkc-button primary">
                <?php echo esc_html($cta_button_text); ?>
            </a>
        </div>
    </div>
    
    <button class="sticky-cta-close" id="close-sticky-cta" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>
</div>

<?php if ($show_cookie_notice) : ?>
<!-- Cookie Notice -->
<div class="cookie-notice" id="cookie-notice">
    <div class="container">
        <div class="cookie-notice-content">
            <div class="cookie-notice-text"><?php echo esc_html($cookie_text); ?></div>
            
            <div class="cookie-notice-actions">
                <button class="cookie-notice-button cookie-accept" id="accept-cookies"><?php echo esc_html($cookie_accept_text); ?></button>
                <button class="cookie-notice-button cookie-decline" id="decline-cookies"><?php echo esc_html($cookie_decline_text); ?></button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const stickyCta = document.getElementById('sticky-cta-bar');
        const closeStickyCta = document.getElementById('close-sticky-cta');
        const cookieNotice = document.getElementById('cookie-notice');
        const acceptCookies = document.getElementById('accept-cookies');
        const declineCookies = document.getElementById('decline-cookies');
        
        // Show the sticky CTA after scrolling
        function handleScroll() {
            if (window.scrollY > <?php echo intval($scroll_trigger); ?>) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
            
            // Check if we're near the bottom of the page
            const scrollHeight = document.documentElement.scrollHeight;
            const scrollPosition = window.scrollY + window.innerHeight;
            const footerHeight = document.querySelector('footer') ? document.querySelector('footer').offsetHeight : 0;
            
            if (scrollPosition > scrollHeight - footerHeight) {
                stickyCta.classList.add('bottom-reached');
            } else {
                stickyCta.classList.remove('bottom-reached');
            }
        }
        
        // Close the sticky CTA
        if (closeStickyCta) {
            closeStickyCta.addEventListener('click', function() {
                stickyCta.classList.remove('visible');
                localStorage.setItem('gdkc_hide_cta', 'true');
            });
        }
        
        // Check if user has previously closed the CTA
        const hideCtaStored = localStorage.getItem('gdkc_hide_cta');
        if (hideCtaStored !== 'true') {
            window.addEventListener('scroll', handleScroll);
            handleScroll(); // Initial check
        }
        
        // Cookie notice functionality
        if (cookieNotice) {
            // Check if user has already answered
            const cookieChoice = localStorage.getItem('gdkc_cookie_choice');
            
            if (!cookieChoice) {
                // Show cookie notice after a delay
                setTimeout(function() {
                    cookieNotice.classList.add('visible');
                }, 1000);
            }
            
            // Handle accept
            if (acceptCookies) {
                acceptCookies.addEventListener('click', function() {
                    localStorage.setItem('gdkc_cookie_choice', 'accepted');
                    cookieNotice.classList.remove('visible');
                });
            }
            
            // Handle decline
            if (declineCookies) {
                declineCookies.addEventListener('click', function() {
                    localStorage.setItem('gdkc_cookie_choice', 'declined');
                    cookieNotice.classList.remove('visible');
                });
            }
        }
    });
})();
</script>