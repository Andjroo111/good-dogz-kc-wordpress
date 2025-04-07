<?php
/**
 * Template part for displaying the behavior assessment quiz
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="behavior-quiz-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Behavior Assessment Quiz</h2>
            <p class="section-description">Understand your dog's behavior patterns and get personalized training recommendations.</p>
        </div>
        
        <div class="quiz-container" id="behavior-quiz">
            <div class="quiz-intro active" data-step="intro">
                <div class="quiz-intro-content">
                    <h3>Is Your Dog Showing These Behaviors?</h3>
                    <ul class="behavior-checklist">
                        <li>Pulling on leash during walks</li>
                        <li>Barking at other dogs or people</li>
                        <li>Jumping on guests or family members</li>
                        <li>Not coming when called</li>
                        <li>Destructive chewing or digging</li>
                        <li>Anxiety when left alone</li>
                    </ul>
                    <p>Take our quick 2-minute assessment to find out which training program is right for your dog!</p>
                    <button class="quiz-btn quiz-start-btn" data-next="1">Start Assessment</button>
                </div>
            </div>
            
            <div class="quiz-step" data-step="1">
                <div class="quiz-question">
                    <h3>How old is your dog?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option">
                            <input type="radio" name="dog_age" value="puppy">
                            <span class="option-text">Puppy (under 1 year)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="dog_age" value="young">
                            <span class="option-text">Young adult (1-3 years)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="dog_age" value="adult">
                            <span class="option-text">Adult (4-8 years)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="dog_age" value="senior">
                            <span class="option-text">Senior (9+ years)</span>
                        </label>
                    </div>
                    <div class="quiz-navigation">
                        <button class="quiz-btn quiz-back-btn" data-prev="intro">Back</button>
                        <button class="quiz-btn quiz-next-btn" data-next="2">Next</button>
                    </div>
                </div>
            </div>
            
            <div class="quiz-step" data-step="2">
                <div class="quiz-question">
                    <h3>What is your biggest training concern?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option">
                            <input type="radio" name="training_concern" value="basic">
                            <span class="option-text">Basic obedience (sit, stay, come)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="training_concern" value="leash">
                            <span class="option-text">Leash pulling/reactivity</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="training_concern" value="anxiety">
                            <span class="option-text">Anxiety or fearfulness</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="training_concern" value="aggression">
                            <span class="option-text">Aggression toward people/dogs</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="training_concern" value="house">
                            <span class="option-text">House training/destructive behaviors</span>
                        </label>
                    </div>
                    <div class="quiz-navigation">
                        <button class="quiz-btn quiz-back-btn" data-prev="1">Back</button>
                        <button class="quiz-btn quiz-next-btn" data-next="3">Next</button>
                    </div>
                </div>
            </div>
            
            <div class="quiz-step" data-step="3">
                <div class="quiz-question">
                    <h3>How much daily exercise does your dog get?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option">
                            <input type="radio" name="exercise_level" value="minimal">
                            <span class="option-text">Minimal (brief potty breaks only)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="exercise_level" value="light">
                            <span class="option-text">Light (15-30 min daily walk)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="exercise_level" value="moderate">
                            <span class="option-text">Moderate (30-60 min daily)</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="exercise_level" value="active">
                            <span class="option-text">Active (60+ min daily)</span>
                        </label>
                    </div>
                    <div class="quiz-navigation">
                        <button class="quiz-btn quiz-back-btn" data-prev="2">Back</button>
                        <button class="quiz-btn quiz-next-btn" data-next="4">Next</button>
                    </div>
                </div>
            </div>
            
            <div class="quiz-step" data-step="4">
                <div class="quiz-question">
                    <h3>Have you tried professional training before?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option">
                            <input type="radio" name="previous_training" value="none">
                            <span class="option-text">No previous training</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="previous_training" value="self">
                            <span class="option-text">Self-taught/online videos</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="previous_training" value="group">
                            <span class="option-text">Group classes</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="previous_training" value="private">
                            <span class="option-text">Private training</span>
                        </label>
                        <label class="quiz-option">
                            <input type="radio" name="previous_training" value="board">
                            <span class="option-text">Board and train</span>
                        </label>
                    </div>
                    <div class="quiz-navigation">
                        <button class="quiz-btn quiz-back-btn" data-prev="3">Back</button>
                        <button class="quiz-btn quiz-next-btn" data-next="results">See Results</button>
                    </div>
                </div>
            </div>
            
            <div class="quiz-results" data-step="results">
                <div class="results-loading">
                    <div class="loading-spinner"></div>
                    <p>Analyzing your responses...</p>
                </div>
                
                <div class="results-content">
                    <h3>Your Personalized Training Recommendation</h3>
                    <div class="recommendation-card">
                        <div class="recommendation-header">
                            <div class="program-match">
                                <span class="match-percent">94%</span>
                                <span class="match-text">Match</span>
                            </div>
                            <h4 class="program-name">Comprehensive Obedience Program</h4>
                        </div>
                        <div class="program-details">
                            <p class="program-description">Based on your answers, we recommend our signature training program that addresses both basic obedience and behavioral concerns.</p>
                            <ul class="program-features">
                                <li>6-week structured training curriculum</li>
                                <li>Personalized attention in small group setting</li>
                                <li>Focus on leash manners and recall</li>
                                <li>Includes take-home exercises and ongoing support</li>
                            </ul>
                        </div>
                        <div class="cta-container">
                            <a href="#contact" class="cta-button">Schedule a Free Consultation</a>
                            <p class="cta-subtext">or call us at (816) 555-DOGS</p>
                        </div>
                    </div>
                    
                    <div class="secondary-recommendations">
                        <h4>You May Also Consider:</h4>
                        <div class="alt-programs">
                            <div class="alt-program">
                                <h5>Private Training Sessions</h5>
                                <p>One-on-one training focused specifically on your dog's needs</p>
                                <a href="#programs" class="alt-program-link">Learn More</a>
                            </div>
                            <div class="alt-program">
                                <h5>Puppy Foundations</h5>
                                <p>Early socialization and basic skills for puppies under 6 months</p>
                                <a href="#programs" class="alt-program-link">Learn More</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="quiz-navigation">
                        <button class="quiz-btn quiz-reset-btn" data-prev="intro">Start Over</button>
                        <a href="#contact" class="quiz-btn quiz-contact-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Quiz navigation
    $('.quiz-btn').on('click', function() {
        var currentStep = $(this).closest('[data-step]').attr('data-step');
        var nextStep = $(this).data('next');
        var prevStep = $(this).data('prev');
        
        // Handle forward navigation
        if (nextStep) {
            // Validate required fields before proceeding
            var canProceed = true;
            if (currentStep !== 'intro') {
                var radioGroup = $('[data-step="' + currentStep + '"] input[type="radio"]').attr('name');
                if (!$('input[name="' + radioGroup + '"]:checked').val()) {
                    canProceed = false;
                    // Show validation error
                    $('[data-step="' + currentStep + '"]').addClass('has-error');
                    setTimeout(function() {
                        $('[data-step="' + currentStep + '"]').removeClass('has-error');
                    }, 1500);
                }
            }
            
            if (canProceed) {
                $('[data-step]').removeClass('active');
                $('[data-step="' + nextStep + '"]').addClass('active');
                
                // If going to results, simulate loading
                if (nextStep === 'results') {
                    $('.results-content').hide();
                    $('.results-loading').show();
                    
                    setTimeout(function() {
                        $('.results-loading').hide();
                        $('.results-content').fadeIn();
                    }, 2000);
                }
                
                // Scroll to top of quiz container
                $('html, body').animate({
                    scrollTop: $('#behavior-quiz').offset().top - 100
                }, 300);
            }
        }
        
        // Handle backward navigation
        if (prevStep) {
            $('[data-step]').removeClass('active');
            $('[data-step="' + prevStep + '"]').addClass('active');
            
            // Scroll to top of quiz container
            $('html, body').animate({
                scrollTop: $('#behavior-quiz').offset().top - 100
            }, 300);
        }
    });
});
</script>