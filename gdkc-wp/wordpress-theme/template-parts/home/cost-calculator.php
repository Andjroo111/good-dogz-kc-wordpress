<?php
/**
 * Template part for displaying the cost calculator
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="cost-calculator-section">
    <div class="container cost-calculator-container">
        <div class="calculator-header">
            <h2 class="section-title">Training Cost Calculator</h2>
            <p class="calculator-subtitle">Customize your dog's training program and get an instant quote</p>
        </div>

        <div class="calculator-grid">
            <!-- Options Side -->
            <div class="calculator-options">
                <div class="option-group">
                    <label class="option-label">Program Type</label>
                    <select class="option-select" id="programType">
                        <option value="private">Private Training Sessions</option>
                        <option value="board">Board & Train</option>
                        <option value="group">Group Classes</option>
                        <option value="virtual">Virtual Training</option>
                    </select>
                </div>
                
                <div class="option-group">
                    <label class="option-label">Dog's Age</label>
                    <div class="option-radio-group">
                        <input type="radio" name="dogAge" id="agePuppy" class="option-radio" value="puppy">
                        <label for="agePuppy">Puppy</label>
                        
                        <input type="radio" name="dogAge" id="ageYoung" class="option-radio" value="young" checked>
                        <label for="ageYoung">Young Adult</label>
                        
                        <input type="radio" name="dogAge" id="ageAdult" class="option-radio" value="adult">
                        <label for="ageAdult">Adult</label>
                        
                        <input type="radio" name="dogAge" id="ageSenior" class="option-radio" value="senior">
                        <label for="ageSenior">Senior</label>
                    </div>
                </div>
                
                <div class="option-group">
                    <label class="option-label">Package Size</label>
                    <select class="option-select" id="packageSize">
                        <option value="single">Single Session</option>
                        <option value="small" selected>4-Session Package</option>
                        <option value="medium">8-Session Package</option>
                        <option value="large">12-Session Package</option>
                    </select>
                </div>
                
                <div class="option-group">
                    <label class="option-label">Training Focus</label>
                    <select class="option-select" id="trainingFocus">
                        <option value="basic">Basic Obedience</option>
                        <option value="advanced">Advanced Obedience</option>
                        <option value="behavior">Behavior Modification</option>
                        <option value="puppy">Puppy Foundations</option>
                        <option value="tricks">Tricks & Enrichment</option>
                    </select>
                </div>
                
                <div class="option-group">
                    <label class="option-label">Add-ons</label>
                    <div class="option-checkbox-group">
                        <div class="option-checkbox-item">
                            <input type="checkbox" id="addTravel" class="option-checkbox">
                            <label for="addTravel">In-home training (+$25 per session)</label>
                        </div>
                        <div class="option-checkbox-item">
                            <input type="checkbox" id="addSupport" class="option-checkbox">
                            <label for="addSupport">Extended email/text support (+$50)</label>
                        </div>
                        <div class="option-checkbox-item">
                            <input type="checkbox" id="addHandoff" class="option-checkbox">
                            <label for="addHandoff">Family handoff session (+$75)</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Results Side -->
            <div class="calculator-results">
                <div class="cost-breakdown">
                    <h3 class="breakdown-title">Your Custom Quote</h3>
                    
                    <div class="breakdown-item">
                        <span>Private Training (4 sessions)</span>
                        <span>$600</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Package Discount</span>
                        <span>-$100</span>
                    </div>
                    <div class="breakdown-item">
                        <span>In-home Training Fee</span>
                        <span>$100</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Extended Support</span>
                        <span>$50</span>
                    </div>
                    
                    <div class="total-cost">
                        <div class="total-label">Total Investment</div>
                        <div class="total-value" id="totalCost">$650</div>
                        <div class="total-note">One-time payment or payment plans available</div>
                    </div>
                </div>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fas fa-check feature-included"></i> Personalized training plan
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-included"></i> Take-home materials
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-included"></i> Email support between sessions
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check feature-included"></i> 30-day satisfaction guarantee
                    </div>
                </div>
                
                <div class="calculator-cta">
                    <button class="add-to-quote">
                        <i class="fas fa-calendar-alt"></i> Schedule a Consultation
                    </button>
                </div>
                
                <!-- Savings badge for packages -->
                <div class="savings-badge">
                    <span class="savings-badge-value">15%</span>
                    <span class="savings-badge-text">Savings</span>
                </div>
                
                <!-- Loading overlay for calculations -->
                <div class="calculator-loading" id="calculatorLoading">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        </div>
        
        <div class="price-disclaimer">
            * Prices shown are estimates. Final pricing may vary based on specific needs and assessment. Schedule a free consultation for an exact quote.
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Define pricing constants
    const BASE_PRICES = {
        'private': {
            'single': 150,
            'small': 550,  // 4 sessions
            'medium': 1000, // 8 sessions
            'large': 1400   // 12 sessions
        },
        'board': {
            'single': 0,    // N/A
            'small': 1200,  // 1 week
            'medium': 2100, // 2 weeks
            'large': 2900   // 3 weeks
        },
        'group': {
            'single': 0,    // N/A
            'small': 250,   // 6 weeks
            'medium': 400,  // 8 weeks with benefits
            'large': 550    // 12 weeks with benefits
        },
        'virtual': {
            'single': 85,
            'small': 300,   // 4 sessions
            'medium': 550,  // 8 sessions
            'large': 750    // 12 sessions
        }
    };
    
    // Define training focus modifiers
    const FOCUS_MODIFIERS = {
        'basic': 0,
        'advanced': 50,
        'behavior': 75,
        'puppy': 0,
        'tricks': 25
    };
    
    // Define age modifiers
    const AGE_MODIFIERS = {
        'puppy': 0,
        'young': 0,
        'adult': 25,
        'senior': 50
    };
    
    // Add-on prices
    const ADDONS = {
        'travel': 25,       // per session
        'support': 50,      // flat fee
        'handoff': 75       // flat fee
    };
    
    // Calculate and update the total cost
    function updateCalculation() {
        // Show loading spinner
        $('#calculatorLoading').addClass('active');
        
        // Simulate calculation delay for better UX
        setTimeout(function() {
            try {
                // Get selected options
                const programType = $('#programType').val();
                const packageSize = $('#packageSize').val();
                const trainingFocus = $('#trainingFocus').val();
                const dogAge = $('input[name="dogAge"]:checked').val();
                
                // Calculate base price
                let basePrice = BASE_PRICES[programType][packageSize];
                
                // Add focus modifier
                let focusModifier = FOCUS_MODIFIERS[trainingFocus] || 0;
                
                // Add age modifier
                let ageModifier = AGE_MODIFIERS[dogAge] || 0;
                
                // Calculate number of sessions for travel add-on
                let sessionCount = 1;
                if (packageSize === 'small') sessionCount = 4;
                if (packageSize === 'medium') sessionCount = 8;
                if (packageSize === 'large') sessionCount = 12;
                if (programType === 'group') {
                    if (packageSize === 'small') sessionCount = 6;
                    if (packageSize === 'medium') sessionCount = 8;
                    if (packageSize === 'large') sessionCount = 12;
                }
                if (programType === 'board') sessionCount = 1; // Just one handoff session
                
                // Calculate add-ons
                let addOns = 0;
                if ($('#addTravel').is(':checked')) {
                    addOns += ADDONS.travel * sessionCount;
                }
                if ($('#addSupport').is(':checked')) {
                    addOns += ADDONS.support;
                }
                if ($('#addHandoff').is(':checked')) {
                    addOns += ADDONS.handoff;
                }
                
                // Calculate total
                const total = basePrice + focusModifier + ageModifier + addOns;
                
                // Update the breakdown items
                $('.breakdown-item').remove(); // Clear existing items
                
                // Base price item
                let programName = '';
                if (programType === 'private') programName = 'Private Training';
                if (programType === 'board') programName = 'Board & Train';
                if (programType === 'group') programName = 'Group Classes';
                if (programType === 'virtual') programName = 'Virtual Training';
                
                let packageName = '';
                if (packageSize === 'single') packageName = '(Single Session)';
                if (packageSize === 'small') {
                    if (programType === 'board') packageName = '(1 Week)';
                    else if (programType === 'group') packageName = '(6 Weeks)';
                    else packageName = '(4 Sessions)';
                }
                if (packageSize === 'medium') {
                    if (programType === 'board') packageName = '(2 Weeks)';
                    else if (programType === 'group') packageName = '(8 Weeks)';
                    else packageName = '(8 Sessions)';
                }
                if (packageSize === 'large') {
                    if (programType === 'board') packageName = '(3 Weeks)';
                    else if (programType === 'group') packageName = '(12 Weeks)';
                    else packageName = '(12 Sessions)';
                }
                
                $('.breakdown-title').after(`
                    <div class="breakdown-item">
                        <span>${programName} ${packageName}</span>
                        <span>$${basePrice}</span>
                    </div>
                `);
                
                // Focus modifier
                if (focusModifier > 0) {
                    $('.breakdown-title').next().after(`
                        <div class="breakdown-item">
                            <span>${trainingFocus.charAt(0).toUpperCase() + trainingFocus.slice(1)} Training Focus</span>
                            <span>+$${focusModifier}</span>
                        </div>
                    `);
                }
                
                // Age modifier
                if (ageModifier > 0) {
                    const ageName = dogAge.charAt(0).toUpperCase() + dogAge.slice(1);
                    $('.breakdown-item').last().after(`
                        <div class="breakdown-item">
                            <span>${ageName} Dog Adjustment</span>
                            <span>+$${ageModifier}</span>
                        </div>
                    `);
                }
                
                // Add-ons
                if ($('#addTravel').is(':checked')) {
                    $('.breakdown-item').last().after(`
                        <div class="breakdown-item">
                            <span>In-home Training (${sessionCount} sessions)</span>
                            <span>+$${ADDONS.travel * sessionCount}</span>
                        </div>
                    `);
                }
                
                if ($('#addSupport').is(':checked')) {
                    $('.breakdown-item').last().after(`
                        <div class="breakdown-item">
                            <span>Extended Support Package</span>
                            <span>+$${ADDONS.support}</span>
                        </div>
                    `);
                }
                
                if ($('#addHandoff').is(':checked')) {
                    $('.breakdown-item').last().after(`
                        <div class="breakdown-item">
                            <span>Family Handoff Session</span>
                            <span>+$${ADDONS.handoff}</span>
                        </div>
                    `);
                }
                
                // Update savings badge
                let savingsPercent = 0;
                if (packageSize === 'medium') savingsPercent = 15;
                if (packageSize === 'large') savingsPercent = 20;
                
                if (savingsPercent > 0) {
                    $('.savings-badge').show();
                    $('.savings-badge-value').text(`${savingsPercent}%`);
                } else {
                    $('.savings-badge').hide();
                }
                
                // Update total
                $('#totalCost').text(`$${total}`);
                
                // Update recommended tag
                $('.recommended-tag').remove();
                if (packageSize === 'medium') {
                    $('#packageSize').next('.recommended-tag').remove();
                    $('#packageSize').after('<span class="recommended-tag">Most Popular</span>');
                }
                
                // Handle feature list visibility
                $('.feature-item').each(function(index) {
                    if (index > 1) {
                        $(this).toggle(packageSize !== 'single');
                    }
                });
                
                // Hide loading spinner
                $('#calculatorLoading').removeClass('active');
                
            } catch (error) {
                console.error('Error calculating price:', error);
                $('#calculatorLoading').removeClass('active');
            }
        }, 500); // Delay for UX
    }
    
    // Bind change events to all inputs
    $('#programType, #packageSize, #trainingFocus, input[name="dogAge"], #addTravel, #addSupport, #addHandoff').on('change', updateCalculation);
    
    // Initialize calculation
    updateCalculation();
    
    // Handle program type changes to update available package sizes
    $('#programType').on('change', function() {
        const programType = $(this).val();
        const $packageSize = $('#packageSize');
        
        // Clear options
        $packageSize.empty();
        
        // Add options based on program type
        if (programType === 'private' || programType === 'virtual') {
            $packageSize.append('<option value="single">Single Session</option>');
            $packageSize.append('<option value="small">4-Session Package</option>');
            $packageSize.append('<option value="medium">8-Session Package</option>');
            $packageSize.append('<option value="large">12-Session Package</option>');
        } else if (programType === 'board') {
            $packageSize.append('<option value="small">1-Week Program</option>');
            $packageSize.append('<option value="medium">2-Week Program</option>');
            $packageSize.append('<option value="large">3-Week Program</option>');
        } else if (programType === 'group') {
            $packageSize.append('<option value="small">6-Week Course</option>');
            $packageSize.append('<option value="medium">8-Week Premium</option>');
            $packageSize.append('<option value="large">12-Week Complete</option>');
        }
        
        // Select the first option and trigger change
        $packageSize.val('small').trigger('change');
    });
});
</script>