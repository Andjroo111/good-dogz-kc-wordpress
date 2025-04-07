<?php
/**
 * Template part for displaying the problem-solution section on the homepage
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<!-- Problem-Solution Section -->
<section class="problem-solution-section" id="problem-solution">
    <div class="container">
        <h2 class="section-title"><?php echo get_theme_mod('problem_solution_title', 'Real Solutions for Real Problems'); ?></h2>
        
        <div class="issues-container">
            <?php
            // Issue buttons
            $issues = [
                'anxiety' => get_theme_mod('issue_1_name', 'Anxiety'),
                'aggression' => get_theme_mod('issue_2_name', 'Aggression'),
                'leash' => get_theme_mod('issue_3_name', 'Leash Pulling'),
                'obedience' => get_theme_mod('issue_4_name', 'Basic Obedience'),
                'reactivity' => get_theme_mod('issue_5_name', 'Reactivity')
            ];
            
            $first = true;
            foreach ($issues as $key => $name) :
            ?>
            <button class="issue-button <?php echo $first ? 'active' : ''; ?>" data-issue="<?php echo esc_attr($key); ?>"><?php echo esc_html($name); ?></button>
            <?php
                $first = false;
            endforeach;
            ?>
        </div>
        
        <div class="solution-showcase">
            <?php
            // Issue content
            foreach ($issues as $key => $name) :
                $is_active = ($key === 'anxiety') ? 'active' : '';
            ?>
            <div class="issue-content <?php echo $is_active; ?>" id="<?php echo esc_attr($key); ?>-content">
                <div class="transformation-card">
                    <div class="transformation-content">
                        <div class="transformation-grid">
                            <div class="transformation-item">
                                <div class="badge badge-blue"><?php echo get_theme_mod($key . '_problem_label', 'Problem'); ?></div>
                                <h3><?php echo get_theme_mod($key . '_problem_title', $name); ?></h3>
                                <p><?php echo get_theme_mod($key . '_problem_text', 'Description of the problem'); ?></p>
                            </div>
                            <div class="transformation-item">
                                <div class="badge badge-teal"><?php echo get_theme_mod($key . '_solution_label', 'Solution'); ?></div>
                                <h3><?php echo get_theme_mod($key . '_solution_title', 'Our Approach'); ?></h3>
                                <p><?php echo get_theme_mod($key . '_solution_text', 'Description of our solution'); ?></p>
                            </div>
                            <div class="transformation-item">
                                <div class="badge badge-purple"><?php echo get_theme_mod($key . '_results_label', 'Results'); ?></div>
                                <h3><?php echo get_theme_mod($key . '_results_title', 'Expected Outcome'); ?></h3>
                                <p><?php echo get_theme_mod($key . '_results_text', 'Description of expected results'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>