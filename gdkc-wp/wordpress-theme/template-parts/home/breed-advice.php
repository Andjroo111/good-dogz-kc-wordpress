<?php
/**
 * Template part for displaying the breed-specific advice generator
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="breed-advice-section">
    <div class="container breed-advice-container">
        <div class="advice-header">
            <h2 class="section-title">Breed-Specific Training Advice</h2>
            <p class="advice-subtitle">Get customized training tips tailored to your dog's breed characteristics</p>
        </div>

        <div class="breed-selector">
            <div class="breed-search">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="breed-search-input" id="breedSearch" placeholder="Search for your dog's breed...">
                <div class="breed-dropdown" id="breedDropdown">
                    <!-- Breed options will be dynamically loaded -->
                </div>
            </div>
            
            <div class="popular-breeds">
                <div class="popular-breeds-title">Popular Breeds:</div>
                <div class="popular-breeds-list">
                    <div class="popular-breed-tag" data-breed="labrador-retriever">Labrador Retriever</div>
                    <div class="popular-breed-tag" data-breed="german-shepherd">German Shepherd</div>
                    <div class="popular-breed-tag" data-breed="golden-retriever">Golden Retriever</div>
                    <div class="popular-breed-tag" data-breed="french-bulldog">French Bulldog</div>
                    <div class="popular-breed-tag" data-breed="poodle">Poodle</div>
                    <div class="popular-breed-tag" data-breed="beagle">Beagle</div>
                </div>
            </div>
        </div>

        <!-- Breed Profile (initially hidden, shown after selection) -->
        <div class="breed-profile" id="breedProfile" style="display: none;">
            <div class="breed-image">
                <img id="breedImage" src="" alt="Breed Image">
            </div>
            
            <div class="breed-info">
                <h3 class="breed-name" id="breedName">Labrador Retriever</h3>
                <p class="breed-description" id="breedDescription">The Labrador Retriever is known for its friendly, outgoing, and high-energy temperament. Labs are intelligent, eager to please, and responsive to training.</p>
                
                <div class="breed-attributes">
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 80%"></div>
                            <i class="fas fa-brain attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Intelligence</div>
                    </div>
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 90%"></div>
                            <i class="fas fa-bolt attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Energy</div>
                    </div>
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 85%"></div>
                            <i class="fas fa-graduation-cap attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Trainability</div>
                    </div>
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 95%"></div>
                            <i class="fas fa-users attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Sociability</div>
                    </div>
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 60%"></div>
                            <i class="fas fa-volume-up attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Barking</div>
                    </div>
                    <div class="breed-attribute">
                        <div class="attribute-value">
                            <div class="attribute-fill" style="height: 70%"></div>
                            <i class="fas fa-shoe-prints attribute-icon"></i>
                        </div>
                        <div class="attribute-label">Exercise Needs</div>
                    </div>
                </div>
                
                <div class="advice-tabs">
                    <div class="advice-tab active" data-tab="training">Training Tips</div>
                    <div class="advice-tab" data-tab="behavior">Common Behaviors</div>
                    <div class="advice-tab" data-tab="socialization">Socialization</div>
                    <div class="advice-tab" data-tab="exercise">Exercise Needs</div>
                </div>
                
                <!-- Training Tips Tab -->
                <div class="advice-content active" data-tab="training">
                    <div class="advice-grid">
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-check-circle"></i>
                                Recommended Training Approach
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Use positive reinforcement with food rewards</li>
                                <li class="advice-item">Keep training sessions short (5-10 minutes) but frequent</li>
                                <li class="advice-item">Incorporate play as a reward for this playful breed</li>
                                <li class="advice-item">Be consistent with commands and expectations</li>
                            </ul>
                        </div>
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-exclamation-triangle"></i>
                                Training Challenges
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">High energy can lead to distraction - train after exercise</li>
                                <li class="advice-item">Prone to jumping up on people when excited</li>
                                <li class="advice-item">May pull on leash due to enthusiasm</li>
                                <li class="advice-item">Can be overly food-motivated</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Common Behaviors Tab -->
                <div class="advice-content" data-tab="behavior">
                    <div class="advice-grid">
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-paw"></i>
                                Natural Tendencies
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Strong retrieving instinct - loves fetch games</li>
                                <li class="advice-item">Enjoys water and swimming</li>
                                <li class="advice-item">Mouthy behavior - may carry items around</li>
                                <li class="advice-item">People-oriented - thrives on human interaction</li>
                            </ul>
                        </div>
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-tools"></i>
                                Behavior Solutions
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Provide appropriate chew toys to satisfy mouthing instinct</li>
                                <li class="advice-item">Teach "drop it" and "leave it" commands early</li>
                                <li class="advice-item">Channel retrieving instinct into structured games</li>
                                <li class="advice-item">Provide mental stimulation with puzzle toys</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Socialization Tab -->
                <div class="advice-content" data-tab="socialization">
                    <div class="advice-grid">
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-users"></i>
                                Socialization Needs
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Generally friendly with people and other dogs</li>
                                <li class="advice-item">Early socialization still essential despite friendly nature</li>
                                <li class="advice-item">May need to learn appropriate greeting behavior</li>
                                <li class="advice-item">Benefits from regular dog park visits</li>
                            </ul>
                        </div>
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-child"></i>
                                Family Compatibility
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Excellent with children when properly trained</li>
                                <li class="advice-item">Teach children appropriate interaction</li>
                                <li class="advice-item">Supervision recommended with young children due to size/energy</li>
                                <li class="advice-item">Generally good with other pets</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Exercise Needs Tab -->
                <div class="advice-content" data-tab="exercise">
                    <div class="advice-grid">
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-running"></i>
                                Exercise Requirements
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Needs 1-2 hours of exercise daily</li>
                                <li class="advice-item">Enjoys swimming, retrieving, and hiking</li>
                                <li class="advice-item">Mental exercise as important as physical</li>
                                <li class="advice-item">Exercise needs higher in youth, moderate in maturity</li>
                            </ul>
                        </div>
                        <div class="advice-card">
                            <h4 class="advice-card-title">
                                <i class="fas fa-gamepad"></i>
                                Recommended Activities
                            </h4>
                            <ul class="advice-list">
                                <li class="advice-item">Fetch games - ideal for retrieving instinct</li>
                                <li class="advice-item">Swimming - natural water affinity</li>
                                <li class="advice-item">Scent work - engages nose and brain</li>
                                <li class="advice-item">Canine sports - agility, dock diving, obedience</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="training-timeline" id="trainingTimeline" style="display: none;">
            <h3 class="timeline-title">Breed-Specific Training Timeline</h3>
            <div class="timeline-container">
                <div class="timeline-line"></div>
                
                <div class="timeline-item">
                    <div class="timeline-marker">1</div>
                    <div class="timeline-content">
                        <div class="timeline-age">2-4 Months</div>
                        <div class="timeline-text">Start with basic obedience, socialization, and gentle leash introduction. Focus on positive associations and handling exercises.</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-marker">2</div>
                    <div class="timeline-content">
                        <div class="timeline-age">4-6 Months</div>
                        <div class="timeline-text">Begin formal training sessions, focusing on recall and leash manners. Start addressing jumping behavior and retrieving exercises.</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-marker">3</div>
                    <div class="timeline-content">
                        <div class="timeline-age">6-12 Months</div>
                        <div class="timeline-text">Introduce more advanced commands, continue socialization with variety of experiences. Work on impulse control and loose-leash walking.</div>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-marker">4</div>
                    <div class="timeline-content">
                        <div class="timeline-age">1-2 Years</div>
                        <div class="timeline-text">Maintain consistency through adolescence, increase distraction training, and consider advanced training or sports that channel natural retrieving abilities.</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="related-breeds" id="relatedBreeds" style="display: none;">
            <h3 class="related-title">Similar Breeds You Might Like</h3>
            <div class="related-grid">
                <div class="related-breed" data-breed="golden-retriever">
                    <div class="related-image">
                        <img src="https://images.dog.ceo/breeds/retriever-golden/n02099601_1074.jpg" alt="Golden Retriever">
                    </div>
                    <div class="related-name">Golden Retriever</div>
                </div>
                <div class="related-breed" data-breed="chesapeake">
                    <div class="related-image">
                        <img src="https://images.dog.ceo/breeds/retriever-chesapeake/n02099849_2873.jpg" alt="Chesapeake Bay Retriever">
                    </div>
                    <div class="related-name">Chesapeake Bay Retriever</div>
                </div>
                <div class="related-breed" data-breed="pointer">
                    <div class="related-image">
                        <img src="https://images.dog.ceo/breeds/pointer-germanlonghair/hans1.jpg" alt="German Shorthaired Pointer">
                    </div>
                    <div class="related-name">German Shorthaired Pointer</div>
                </div>
                <div class="related-breed" data-breed="flatcoated">
                    <div class="related-image">
                        <img src="https://images.dog.ceo/breeds/retriever-flatcoated/n02099267_1248.jpg" alt="Flat-Coated Retriever">
                    </div>
                    <div class="related-name">Flat-Coated Retriever</div>
                </div>
            </div>
        </div>
        
        <div class="advice-placeholder" id="advicePlaceholder">
            <i class="fas fa-search"></i>
            <h3>Looking for breed-specific advice?</h3>
            <p>Search for your dog's breed above to get customized training tips and recommendations.</p>
        </div>
        
        <div class="advice-cta" id="adviceCta" style="display: none;">
            <a href="#contact" class="gdkc-button primary">Get Personalized Training Plan</a>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Define list of dog breeds
    const dogBreeds = [
        { id: 'labrador-retriever', name: 'Labrador Retriever' },
        { id: 'german-shepherd', name: 'German Shepherd' },
        { id: 'golden-retriever', name: 'Golden Retriever' },
        { id: 'bulldog', name: 'Bulldog' },
        { id: 'french-bulldog', name: 'French Bulldog' },
        { id: 'poodle', name: 'Poodle' },
        { id: 'beagle', name: 'Beagle' },
        { id: 'rottweiler', name: 'Rottweiler' },
        { id: 'boxer', name: 'Boxer' },
        { id: 'dachshund', name: 'Dachshund' },
        { id: 'shih-tzu', name: 'Shih Tzu' },
        { id: 'siberian-husky', name: 'Siberian Husky' },
        { id: 'great-dane', name: 'Great Dane' },
        { id: 'chihuahua', name: 'Chihuahua' },
        { id: 'pomeranian', name: 'Pomeranian' },
        { id: 'border-collie', name: 'Border Collie' },
        { id: 'yorkshire-terrier', name: 'Yorkshire Terrier' },
        { id: 'australian-shepherd', name: 'Australian Shepherd' },
        { id: 'cavalier-king-charles-spaniel', name: 'Cavalier King Charles Spaniel' },
        { id: 'doberman-pinscher', name: 'Doberman Pinscher' }
    ];
    
    // Define breed data for demo purposes
    const breedData = {
        'labrador-retriever': {
            name: 'Labrador Retriever',
            image: 'https://images.dog.ceo/breeds/retriever-labrador/n02099712_5195.jpg',
            description: 'The Labrador Retriever is known for its friendly, outgoing, and high-energy temperament. Labs are intelligent, eager to please, and responsive to training.',
            attributes: {
                intelligence: 80,
                energy: 90,
                trainability: 85,
                sociability: 95,
                barking: 60,
                exercise: 70
            }
        },
        'german-shepherd': {
            name: 'German Shepherd',
            image: 'https://images.dog.ceo/breeds/germanshepherd/n02106662_26696.jpg',
            description: 'German Shepherds are intelligent, confident, and courageous working dogs. They are loyal and protective of their families, with a strong work ethic and drive.',
            attributes: {
                intelligence: 95,
                energy: 85,
                trainability: 90,
                sociability: 70,
                barking: 75,
                exercise: 80
            }
        },
        'golden-retriever': {
            name: 'Golden Retriever',
            image: 'https://images.dog.ceo/breeds/retriever-golden/n02099601_6214.jpg',
            description: 'Golden Retrievers are intelligent, friendly, and devoted. They are known for their patient demeanor and are excellent family dogs with a natural love for retrieving.',
            attributes: {
                intelligence: 85,
                energy: 85,
                trainability: 90,
                sociability: 90,
                barking: 55,
                exercise: 75
            }
        },
        'beagle': {
            name: 'Beagle',
            image: 'https://images.dog.ceo/breeds/beagle/n02088364_12166.jpg',
            description: 'Beagles are friendly, curious, and merry hounds. They are scent-driven with strong hunting instincts and can be independent thinkers with a touch of stubbornness.',
            attributes: {
                intelligence: 70,
                energy: 80,
                trainability: 65,
                sociability: 85,
                barking: 90,
                exercise: 75
            }
        },
        'french-bulldog': {
            name: 'French Bulldog',
            image: 'https://images.dog.ceo/breeds/bulldog-french/n02108915_4746.jpg',
            description: 'French Bulldogs are playful, alert, and adaptable companions. They are known for their bat-like ears, even temper, and affectionate nature, with moderate exercise needs.',
            attributes: {
                intelligence: 65,
                energy: 50,
                trainability: 65,
                sociability: 85,
                barking: 40,
                exercise: 40
            }
        },
        'poodle': {
            name: 'Poodle',
            image: 'https://images.dog.ceo/breeds/poodle-standard/n02113799_2292.jpg',
            description: 'Poodles are exceptionally smart, active, and elegant dogs. They are highly trainable with a proud bearing and come in three sizes: standard, miniature, and toy.',
            attributes: {
                intelligence: 95,
                energy: 70,
                trainability: 95,
                sociability: 80,
                barking: 60,
                exercise: 65
            }
        }
    };
    
    // Breed search functionality
    $('#breedSearch').on('focus', function() {
        // Show dropdown and populate with all breeds
        populateBreedDropdown(dogBreeds);
        $('#breedDropdown').addClass('active');
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.breed-search').length) {
            $('#breedDropdown').removeClass('active');
        }
    });
    
    // Filter breeds as user types
    $('#breedSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        if (searchTerm.length === 0) {
            populateBreedDropdown(dogBreeds);
            return;
        }
        
        const filteredBreeds = dogBreeds.filter(breed => 
            breed.name.toLowerCase().includes(searchTerm)
        );
        
        populateBreedDropdown(filteredBreeds);
    });
    
    // Populate breed dropdown
    function populateBreedDropdown(breeds) {
        const dropdown = $('#breedDropdown');
        dropdown.empty();
        
        if (breeds.length === 0) {
            dropdown.append('<div class="no-results">No breeds found</div>');
            return;
        }
        
        breeds.forEach(breed => {
            dropdown.append(`
                <div class="breed-option" data-breed="${breed.id}">
                    ${breed.name}
                </div>
            `);
        });
        
        // Add click event to breed options
        $('.breed-option').on('click', function() {
            const breedId = $(this).data('breed');
            const breedName = $(this).text();
            
            // Update search input
            $('#breedSearch').val(breedName);
            
            // Hide dropdown
            $('#breedDropdown').removeClass('active');
            
            // Display breed profile
            displayBreedProfile(breedId);
        });
    }
    
    // Popular breed tags click handler
    $('.popular-breed-tag').on('click', function() {
        const breedId = $(this).data('breed');
        const breedName = $(this).text();
        
        // Update search input
        $('#breedSearch').val(breedName);
        
        // Display breed profile
        displayBreedProfile(breedId);
    });
    
    // Related breed click handler
    $(document).on('click', '.related-breed', function() {
        const breedId = $(this).data('breed');
        const breedName = $(this).find('.related-name').text();
        
        // Update search input
        $('#breedSearch').val(breedName);
        
        // Scroll back to top of section
        $('.breed-advice-section').get(0).scrollIntoView({ behavior: 'smooth' });
        
        // Display breed profile
        displayBreedProfile(breedId);
    });
    
    // Display breed profile
    function displayBreedProfile(breedId) {
        // Check if we have data for this breed
        if (!breedData[breedId]) {
            // In a real implementation, this would fetch data from the server
            // For demo, show a placeholder message
            $('#breedProfile').hide();
            $('#trainingTimeline').hide();
            $('#relatedBreeds').hide();
            $('#advicePlaceholder').show();
            $('#adviceCta').hide();
            
            alert('Full breed data not available in the demo. Try "Labrador Retriever", "German Shepherd", "Golden Retriever", "Beagle", "French Bulldog", or "Poodle".');
            return;
        }
        
        // Get breed data
        const breed = breedData[breedId];
        
        // Update profile information
        $('#breedName').text(breed.name);
        $('#breedImage').attr('src', breed.image);
        $('#breedDescription').text(breed.description);
        
        // Update attributes
        $('.attribute-fill').each(function(index) {
            const attributes = ['intelligence', 'energy', 'trainability', 'sociability', 'barking', 'exercise'];
            const attributeName = attributes[index];
            const attributeValue = breed.attributes[attributeName];
            
            $(this).css('height', `${attributeValue}%`);
        });
        
        // Show breed profile and related sections
        $('#advicePlaceholder').hide();
        $('#breedProfile').show();
        $('#trainingTimeline').show();
        $('#relatedBreeds').show();
        $('#adviceCta').show();
        
        // Reset active tab
        $('.advice-tab').removeClass('active');
        $('.advice-tab[data-tab="training"]').addClass('active');
        $('.advice-content').removeClass('active');
        $('.advice-content[data-tab="training"]').addClass('active');
    }
    
    // Tab switching functionality
    $('.advice-tab').on('click', function() {
        const tab = $(this).data('tab');
        
        // Update active tab
        $('.advice-tab').removeClass('active');
        $(this).addClass('active');
        
        // Show corresponding content
        $('.advice-content').removeClass('active');
        $(`.advice-content[data-tab="${tab}"]`).addClass('active');
    });
});
</script>