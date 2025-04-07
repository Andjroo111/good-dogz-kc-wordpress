    </main><!-- #primary -->

    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <!-- Footer Logo -->
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="footer-logo">
                            <?php 
                            $custom_logo_id = get_theme_mod( 'custom_logo' );
                            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                            if ( $logo ) {
                                echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . ' Logo" class="footer-site-logo">';
                            }
                            ?>
                        </div>
                    <?php else : ?>
                        <div class="logo-placeholder"><?php bloginfo( 'name' ); ?></div>
                    <?php endif; ?>
                    
                    <!-- Footer Description -->
                    <p>Transforming dogs and enhancing the human-canine relationship through science-based training methods since 2020.</p>
                    
                    <!-- Business Hours -->
                    <div class="hours-info">
                        <h4>Training Hours</h4>
                        <p><i class="fas fa-clock"></i> Monday - Friday: 9am - 7pm</p>
                        <p><i class="fas fa-clock"></i> Saturday: 9am - 5pm</p>
                        <p><i class="fas fa-clock"></i> Sunday: By appointment only</p>
                    </div>
                </div>
                
                <div class="footer-links">
                    <!-- Footer Navigation -->
                    <div class="footer-nav">
                        <h4>Site Navigation</h4>
                        <?php
                        if ( has_nav_menu( 'footer' ) ) {
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'footer',
                                    'menu_id'        => 'footer-menu',
                                    'depth'          => 1,
                                    'fallback_cb'    => false,
                                )
                            );
                        } else {
                            // Fallback
                            echo '<ul>
                                <li><a href="' . home_url() . '">Home</a></li>
                                <li><a href="#">Programs</a></li>
                                <li><a href="#">Testimonials</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms of Service</a></li>
                            </ul>';
                        }
                        ?>
                    </div>
                    
                    <!-- Resources Links -->
                    <div class="footer-resources">
                        <h4>Training Resources</h4>
                        <ul>
                            <li><a href="#">Free Training Tips</a></li>
                            <li><a href="#">Training Videos</a></li>
                            <li><a href="#">Recommended Products</a></li>
                            <li><a href="#">Local Dog Resources</a></li>
                            <li><a href="#">KC Dog-Friendly Places</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <!-- Copyright -->
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                
                <!-- Social Links -->
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </footer>

<?php wp_footer(); ?>

</body>
</html>