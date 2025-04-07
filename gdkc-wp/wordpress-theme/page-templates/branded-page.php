<?php
/**
 * Template Name: Branded Page
 * Description: A branded page template with lava animation header, service card, and footer.
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" role="main">
    <!-- Hero Section with Lava Animation -->
    <section class="hero-section gdkc-lava-container">
        <div class="container hero-content">
            <div class="hero-grid">
                <div class="hero-text">
                    <h1 class="hero-title">Transform Your Dog's Behavior</h1>
                    <p class="hero-subtitle">Your local family transforming dogs together in Kansas City</p>
                    
                    <div class="hero-cta">
                        <a href="#contact" class="gdkc-button primary">Schedule Free Consultation</a>
                        <a href="#training-solutions" class="gdkc-button outline">View Programs</a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="video-placeholder hover-lift">
                        <i class="fas fa-play-circle pulse-animation"></i>
                        <span>Training Transformation Video</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Card Section -->
    <section class="section bg-white">
        <div class="container">
            <h2 class="section-title text-center">Our Training Programs</h2>
            <p class="section-subtitle text-center">Customized solutions for every dog and family</p>
            
            <div class="grid grid-cols-1 grid-cols-3-lg gap-lg">
                <!-- Service Card -->
                <div class="gdkc-program-card gdkc-program-card--popular">
                    <div class="gdkc-program-card__header gdkc-program-card--teal">
                        <h3 class="gdkc-program-card__title">Board & Train</h3>
                        <p class="gdkc-program-card__subtitle">Intensive training with proven results</p>
                        <div class="gdkc-program-card__price">From $1,200</div>
                    </div>
                    <div class="gdkc-program-card__body">
                        <ul class="gdkc-feature-list">
                            <li class="gdkc-feature-list__item">2-3 week training program</li>
                            <li class="gdkc-feature-list__item">Daily structured training sessions</li>
                            <li class="gdkc-feature-list__item">Real-world socialization opportunities</li>
                            <li class="gdkc-feature-list__item">Regular progress updates and videos</li>
                            <li class="gdkc-feature-list__item">Transfer sessions and follow-up support</li>
                        </ul>
                    </div>
                    <div class="gdkc-program-card__footer">
                        <a href="#contact" class="gdkc-button primary pulse-animation">Learn More</a>
                    </div>
                </div>

                <!-- Service Card -->
                <div class="gdkc-program-card">
                    <div class="gdkc-program-card__header">
                        <h3 class="gdkc-program-card__title">In-Home Training</h3>
                        <p class="gdkc-program-card__subtitle">Personalized training in your environment</p>
                        <div class="gdkc-program-card__price">From $150</div>
                    </div>
                    <div class="gdkc-program-card__body">
                        <ul class="gdkc-feature-list">
                            <li class="gdkc-feature-list__item">Customized to your dog's specific needs</li>
                            <li class="gdkc-feature-list__item">Training in your home environment</li>
                            <li class="gdkc-feature-list__item">Practical solutions for real-life scenarios</li>
                            <li class="gdkc-feature-list__item">Flexible scheduling options</li>
                            <li class="gdkc-feature-list__item">Family involvement and education</li>
                        </ul>
                    </div>
                    <div class="gdkc-program-card__footer">
                        <a href="#contact" class="gdkc-button primary">Learn More</a>
                    </div>
                </div>

                <!-- Service Card -->
                <div class="gdkc-program-card">
                    <div class="gdkc-program-card__header">
                        <h3 class="gdkc-program-card__title">Virtual Training</h3>
                        <p class="gdkc-program-card__subtitle">Expert guidance from anywhere</p>
                        <div class="gdkc-program-card__price">From $85</div>
                    </div>
                    <div class="gdkc-program-card__body">
                        <ul class="gdkc-feature-list">
                            <li class="gdkc-feature-list__item">Convenient online sessions</li>
                            <li class="gdkc-feature-list__item">One-on-one guidance from trainers</li>
                            <li class="gdkc-feature-list__item">Custom training plans and homework</li>
                            <li class="gdkc-feature-list__item">Video review and feedback</li>
                            <li class="gdkc-feature-list__item">Email support between sessions</li>
                        </ul>
                    </div>
                    <div class="gdkc-program-card__footer">
                        <a href="#contact" class="gdkc-button primary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center gdkc-mt-xl">
                <p class="gdkc-text">All programs include our 30-day satisfaction guarantee. Not sure which program is right for you?</p>
                <a href="#contact" class="gdkc-button secondary gdkc-mt-md">Book a Free Consultation</a>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="section bg-soft-lilac">
        <div class="container">
            <h2 class="section-title text-center">What Our Clients Say</h2>
            
            <div class="grid grid-cols-1 grid-cols-3-md gap-lg">
                <div class="gdkc-testimonial">
                    <div class="gdkc-testimonial__content">
                        "We were at our wit's end with our rescue dog's leash reactivity. After just 4 weeks of training with Good Dogz KC, we can now walk past other dogs without drama. Their methods are effective and compassionate."
                    </div>
                    <div class="gdkc-testimonial__author">
                        <div class="gdkc-avatar gdkc-avatar--sm">
                            <div class="gdkc-avatar__initials">MT</div>
                        </div>
                        <div>
                            <div class="gdkc-testimonial__name">Michael T.</div>
                            <div class="gdkc-testimonial__title">Owner of Bella</div>
                            <div class="gdkc-testimonial__rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center gdkc-mt-xl">
                <a href="#contact" class="gdkc-button primary">Book Your Free Consultation</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section bg-white">
        <div class="container">
            <div class="grid grid-cols-1 grid-cols-2-lg gap-xl">
                <div>
                    <h2 class="section-title text-left">Transform Your Dog</h2>
                    <p class="gdkc-text">Our proven methods have helped over 500 Kansas City families. If you don't see improvement in your dog's behavior, your next session is free.</p>
                    
                    <div class="gdkc-card gdkc-card--accent gdkc-mt-lg">
                        <div class="gdkc-card__body">
                            <h3 class="gdkc-h3">"We can finally enjoy walks as a family again. Life-changing!"</h3>
                            <p class="gdkc-text-s">— Bailey's Family</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="gdkc-card">
                        <div class="gdkc-card__header">
                            <h3 class="gdkc-h3 text-center">Get Your Free Consultation</h3>
                            <p class="gdkc-text-s text-center">No obligation • 30-minute call • Custom training plan</p>
                        </div>
                        <div class="gdkc-card__body">
                            <?php echo do_shortcode('[contact-form-7 id="contact-form" title="Contact Form"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
