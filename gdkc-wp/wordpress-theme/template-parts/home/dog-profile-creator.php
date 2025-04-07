<?php
/**
 * Template part for displaying the dog profile creator
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="dog-profile-section">
    <div class="container dog-profile-container">
        <div class="profile-header">
            <h2 class="section-title">Create Your Dog's Training Profile</h2>
            <p class="section-subtitle">Tell us about your furry friend and get personalized training recommendations</p>
        </div>

        <div class="profile-creator">
            <!-- Profile Creation Steps -->
            <div class="profile-steps">
                <div class="profile-step active" data-step="1">1</div>
                <div class="profile-step" data-step="2">2</div>
                <div class="profile-step" data-step="3">3</div>
                <div class="profile-step" data-step="4">4</div>
            </div>

            <!-- Step 1: Basic Information -->
            <div class="profile-step-content active" data-step="1">
                <h3>Basic Information</h3>
                <div class="profile-form-group">
                    <label for="dogName">Dog's Name</label>
                    <input type="text" id="dogName" class="profile-input" placeholder="Enter your dog's name">
                </div>
                <div class="profile-form-group">
                    <label>Upload a Photo (Optional)</label>
                    <div class="dog-image-preview" id="dogImagePreview"></div>
                    <div class="upload-button">
                        <button type="button" class="gdkc-button-s" id="uploadPhotoBtn">Upload Photo</button>
                    </div>
                </div>
                <div class="profile-actions">
                    <button type="button" class="gdkc-button primary next-step" data-next="2">Continue</button>
                </div>
            </div>

            <!-- Step 2: Breed & Age -->
            <div class="profile-step-content" data-step="2">
                <h3>Breed & Age Information</h3>
                <div class="profile-form-group">
                    <label for="dogBreed">Breed</label>
                    <select id="dogBreed" class="profile-select">
                        <option value="">Select breed</option>
                        <option value="labrador">Labrador Retriever</option>
                        <option value="german-shepherd">German Shepherd</option>
                        <option value="golden-retriever">Golden Retriever</option>
                        <option value="bulldog">Bulldog</option>
                        <option value="beagle">Beagle</option>
                        <option value="poodle">Poodle</option>
                        <option value="mixed">Mixed Breed / Other</option>
                    </select>
                </div>
                <div class="profile-form-group">
                    <label for="dogAge">Age</label>
                    <select id="dogAge" class="profile-select">
                        <option value="">Select age</option>
                        <option value="puppy">Puppy (0-6 months)</option>
                        <option value="junior">Junior (6-12 months)</option>
                        <option value="young">Young Adult (1-3 years)</option>
                        <option value="adult">Adult (3-7 years)</option>
                        <option value="senior">Senior (8+ years)</option>
                    </select>
                </div>
                <div class="profile-form-group">
                    <label>Size</label>
                    <div class="profile-radio-group">
                        <label class="profile-radio-item">
                            <input type="radio" name="dogSize" value="small">
                            Small (under 20 lbs)
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="dogSize" value="medium">
                            Medium (21-50 lbs)
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="dogSize" value="large">
                            Large (51-90 lbs)
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="dogSize" value="xlarge">
                            X-Large (90+ lbs)
                        </label>
                    </div>
                </div>
                <div class="profile-actions">
                    <button type="button" class="gdkc-button outline prev-step" data-prev="1">Back</button>
                    <button type="button" class="gdkc-button primary next-step" data-next="3">Continue</button>
                </div>
            </div>

            <!-- Step 3: Behavior Assessment -->
            <div class="profile-step-content" data-step="3">
                <h3>Behavior Assessment</h3>
                <div class="profile-form-group">
                    <label>What are your main training concerns? (Select all that apply)</label>
                    <div class="profile-checkbox-group">
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="barking">
                            Excessive barking
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="pulling">
                            Leash pulling
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="jumping">
                            Jumping on people
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="house">
                            House training issues
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="chewing">
                            Destructive chewing
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="aggression">
                            Aggression toward people/dogs
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="recall">
                            Not coming when called
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingConcerns" value="anxiety">
                            Separation anxiety
                        </label>
                    </div>
                </div>
                <div class="profile-form-group">
                    <label>How would you describe your dog's energy level?</label>
                    <div class="profile-radio-group">
                        <label class="profile-radio-item">
                            <input type="radio" name="energyLevel" value="low">
                            Low - Couch potato
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="energyLevel" value="medium">
                            Medium - Balanced energy
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="energyLevel" value="high">
                            High - Very active
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="energyLevel" value="extreme">
                            Extremely High - Never stops
                        </label>
                    </div>
                </div>
                <div class="profile-actions">
                    <button type="button" class="gdkc-button outline prev-step" data-prev="2">Back</button>
                    <button type="button" class="gdkc-button primary next-step" data-next="4">Continue</button>
                </div>
            </div>

            <!-- Step 4: Training Experience -->
            <div class="profile-step-content" data-step="4">
                <h3>Training Experience</h3>
                <div class="profile-form-group">
                    <label>Previous Training Experience</label>
                    <div class="profile-radio-group">
                        <label class="profile-radio-item">
                            <input type="radio" name="trainingExperience" value="none">
                            No previous training
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="trainingExperience" value="basic">
                            Basic commands only
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="trainingExperience" value="intermediate">
                            Some formal training
                        </label>
                        <label class="profile-radio-item">
                            <input type="radio" name="trainingExperience" value="advanced">
                            Advanced training
                        </label>
                    </div>
                </div>
                <div class="profile-form-group">
                    <label>Your Training Goals</label>
                    <div class="profile-checkbox-group">
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="obedience">
                            Basic obedience
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="behavior">
                            Behavior modification
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="socialization">
                            Better socialization
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="tricks">
                            Fun tricks and skills
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="therapy">
                            Therapy dog work
                        </label>
                        <label class="profile-checkbox-item">
                            <input type="checkbox" name="trainingGoals" value="agility">
                            Agility/sports
                        </label>
                    </div>
                </div>
                <div class="profile-actions">
                    <button type="button" class="gdkc-button outline prev-step" data-prev="3">Back</button>
                    <button type="button" class="gdkc-button primary" id="createProfileBtn">Create Profile</button>
                </div>
            </div>

            <!-- Profile Result -->
            <div class="profile-result" id="profileResult">
                <div class="dog-profile-card">
                    <div class="dog-profile-header">
                        <div class="dog-profile-image" id="resultDogImage"></div>
                        <div>
                            <h3 class="dog-profile-name" id="resultDogName">Buddy</h3>
                            <p class="dog-profile-breed" id="resultDogBreed">Labrador Retriever, 2 years old</p>
                        </div>
                    </div>
                    <div class="dog-profile-details">
                        <div class="dog-profile-detail">
                            <p class="detail-label">Size</p>
                            <p class="detail-value" id="resultDogSize">Medium (35 lbs)</p>
                        </div>
                        <div class="dog-profile-detail">
                            <p class="detail-label">Energy Level</p>
                            <p class="detail-value" id="resultEnergyLevel">High</p>
                        </div>
                        <div class="dog-profile-detail">
                            <p class="detail-label">Training Experience</p>
                            <p class="detail-value" id="resultTrainingExp">Some formal training</p>
                        </div>
                        <div class="dog-profile-detail">
                            <p class="detail-label">Key Concerns</p>
                            <p class="detail-value" id="resultKeyConcerns">Leash pulling, Jumping</p>
                        </div>
                    </div>
                    <div class="training-recommendations">
                        <h4 class="recommendation-title">Personalized Training Recommendations</h4>
                        <ul class="recommendation-list">
                            <li class="recommendation-item">
                                <div class="recommendation-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="recommendation-text">
                                    <strong>Leash Manners Program:</strong> Our focused program will teach your dog to walk calmly on a loose leash even with distractions.
                                </div>
                            </li>
                            <li class="recommendation-item">
                                <div class="recommendation-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="recommendation-text">
                                    <strong>Impulse Control Training:</strong> Perfect for high-energy dogs who need to learn patience and self-control around exciting situations.
                                </div>
                            </li>
                            <li class="recommendation-item">
                                <div class="recommendation-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="recommendation-text">
                                    <strong>Advanced Commands:</strong> Build on your dog's existing training with more advanced commands and practical real-world skills.
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="profile-save-button">
                        <button type="button" class="gdkc-button primary">Schedule a Consultation</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Navigation between steps
    $('.next-step').on('click', function() {
        const nextStep = $(this).data('next');
        const currentStep = $(this).closest('.profile-step-content').data('step');
        
        // Hide current step
        $(`.profile-step-content[data-step="${currentStep}"]`).removeClass('active');
        $(`.profile-step[data-step="${currentStep}"]`).removeClass('active').addClass('completed');
        
        // Show next step
        $(`.profile-step-content[data-step="${nextStep}"]`).addClass('active');
        $(`.profile-step[data-step="${nextStep}"]`).addClass('active');
    });
    
    $('.prev-step').on('click', function() {
        const prevStep = $(this).data('prev');
        const currentStep = $(this).closest('.profile-step-content').data('step');
        
        // Hide current step
        $(`.profile-step-content[data-step="${currentStep}"]`).removeClass('active');
        $(`.profile-step[data-step="${currentStep}"]`).removeClass('active');
        
        // Show previous step
        $(`.profile-step-content[data-step="${prevStep}"]`).addClass('active');
        $(`.profile-step[data-step="${prevStep}"]`).addClass('active');
        $(`.profile-step[data-step="${prevStep}"]`).removeClass('completed');
    });
    
    // Create profile button
    $('#createProfileBtn').on('click', function() {
        // In a real implementation, this would collect and validate all form data
        
        // For demo purposes, we'll just populate with sample data and show the result
        $('#resultDogName').text($('#dogName').val() || 'Buddy');
        $('#resultDogBreed').text(($('#dogBreed option:selected').text() || 'Labrador Retriever') + ', ' + ($('#dogAge option:selected').text() || '2 years old'));
        
        // Get selected size
        const size = $('input[name="dogSize"]:checked').val();
        let sizeText = 'Medium (35 lbs)';
        if (size === 'small') sizeText = 'Small (15 lbs)';
        if (size === 'large') sizeText = 'Large (70 lbs)';
        if (size === 'xlarge') sizeText = 'X-Large (95+ lbs)';
        $('#resultDogSize').text(sizeText);
        
        // Get energy level
        const energy = $('input[name="energyLevel"]:checked').val();
        let energyText = 'Medium';
        if (energy === 'low') energyText = 'Low';
        if (energy === 'high') energyText = 'High';
        if (energy === 'extreme') energyText = 'Extremely High';
        $('#resultEnergyLevel').text(energyText);
        
        // Get training experience
        const training = $('input[name="trainingExperience"]:checked').val();
        let trainingText = 'Some formal training';
        if (training === 'none') trainingText = 'No previous training';
        if (training === 'basic') trainingText = 'Basic commands only';
        if (training === 'advanced') trainingText = 'Advanced training';
        $('#resultTrainingExp').text(trainingText);
        
        // Get concerns (first 2 only for display purposes)
        const concerns = [];
        $('input[name="trainingConcerns"]:checked').each(function() {
            concerns.push($(this).val());
        });
        let concernsText = 'None specified';
        if (concerns.length > 0) {
            const concernLabels = {
                'barking': 'Excessive barking',
                'pulling': 'Leash pulling',
                'jumping': 'Jumping on people',
                'house': 'House training',
                'chewing': 'Destructive chewing',
                'aggression': 'Aggression',
                'recall': 'Recall issues',
                'anxiety': 'Separation anxiety'
            };
            const concernsDisplay = concerns.slice(0, 2).map(c => concernLabels[c] || c);
            concernsText = concernsDisplay.join(', ');
        }
        $('#resultKeyConcerns').text(concernsText);
        
        // Hide form steps and show result
        $('.profile-steps').hide();
        $('.profile-step-content').removeClass('active');
        $('#profileResult').show();
    });
    
    // Upload photo button (simulated)
    $('#uploadPhotoBtn').on('click', function() {
        // In a real implementation, this would open a file input dialog
        // For demo purposes, we'll just add a placeholder image
        $('#dogImagePreview').addClass('has-image').css('background-image', 'url("https://placedog.net/200/200")');
        $('#resultDogImage').css('background-image', 'url("https://placedog.net/200/200")');
    });
});
</script>