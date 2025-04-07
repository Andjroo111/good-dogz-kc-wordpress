<?php
/**
 * Dog Assessment Dashboard
 *
 * Adds a custom admin dashboard for Dog Assessment results.
 *
 * @package Good_Dogz_KC
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Assessment Dashboard Page
 */
function gdkc_register_assessment_dashboard() {
    add_submenu_page(
        'edit.php?post_type=gdkc_assessment',
        'Assessment Dashboard',
        'Dashboard',
        'manage_options',
        'gdkc-assessment-dashboard',
        'gdkc_assessment_dashboard_page'
    );
}
add_action('admin_menu', 'gdkc_register_assessment_dashboard');

/**
 * Render the Assessment Dashboard Page
 */
function gdkc_assessment_dashboard_page() {
    // Get recent assessments
    $recent_assessments = get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => 10,
        'post_status' => 'private',
        'orderby' => 'date',
        'order' => 'DESC',
    ]);

    // Get assessment stats
    $total_assessments = wp_count_posts('gdkc_assessment')->private;
    $last_month_assessments = count(get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
        'date_query' => [
            [
                'after' => '1 month ago',
            ]
        ]
    ]));

    // Get most common issues
    $common_issues = gdkc_get_most_common_issues();

    // Get most recommended packages
    $recommended_packages = gdkc_get_most_recommended_packages();
    ?>
    <div class="wrap">
        <h1>Dog Assessment Dashboard</h1>
        
        <div class="assessment-dashboard">
            <div class="dashboard-section stats-overview">
                <h2>Statistics Overview</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Assessments</h3>
                        <div class="stat-value"><?php echo esc_html($total_assessments); ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Last 30 Days</h3>
                        <div class="stat-value"><?php echo esc_html($last_month_assessments); ?></div>
                    </div>
                    <div class="stat-card">
                        <h3>Conversion Rate</h3>
                        <div class="stat-value">
                            <?php 
                            $rate = gdkc_get_assessment_conversion_rate();
                            echo esc_html($rate) . '%'; 
                            ?>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h3>Client Follow-ups</h3>
                        <div class="stat-value"><?php echo esc_html(gdkc_get_pending_followups()); ?></div>
                        <a href="<?php echo admin_url('edit.php?post_type=gdkc_assessment&needs_followup=1'); ?>" class="view-all">View all</a>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-row">
                <div class="dashboard-section recent-assessments">
                    <h2>Recent Assessments</h2>
                    <?php if (!empty($recent_assessments)) : ?>
                        <table class="wp-list-table widefat fixed striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Dog</th>
                                    <th>Program Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_assessments as $assessment) : 
                                    $owner_name = get_post_meta($assessment->ID, 'owner_name', true);
                                    $dog_name = get_post_meta($assessment->ID, 'dog_name', true);
                                    $email = get_post_meta($assessment->ID, 'email', true);
                                    $phone = get_post_meta($assessment->ID, 'phone', true);
                                    $analysis = get_post_meta($assessment->ID, 'analysis_results', true);
                                    $program_type = isset($analysis['program_type']) ? $analysis['program_type'] : 'N/A';
                                ?>
                                    <tr>
                                        <td><?php echo get_the_date('M j, Y', $assessment->ID); ?></td>
                                        <td>
                                            <?php echo esc_html($owner_name); ?>
                                            <?php if ($email) echo '<br><small>' . esc_html($email) . '</small>'; ?>
                                        </td>
                                        <td><?php echo esc_html($dog_name); ?></td>
                                        <td><?php echo esc_html($program_type); ?></td>
                                        <td>
                                            <a href="<?php echo get_edit_post_link($assessment->ID); ?>" class="button button-small">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="view-all-link">
                            <a href="<?php echo admin_url('edit.php?post_type=gdkc_assessment'); ?>" class="button">View All Assessments</a>
                        </p>
                    <?php else : ?>
                        <p>No assessments found.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-section top-issues">
                    <h2>Top Issues Identified</h2>
                    <?php if (!empty($common_issues)) : ?>
                        <div class="issue-list">
                            <?php foreach ($common_issues as $issue => $count) : ?>
                                <div class="issue-item">
                                    <div class="issue-name"><?php echo esc_html($issue); ?></div>
                                    <div class="issue-bar">
                                        <div class="issue-bar-fill" style="width: <?php echo min(100, ($count / max(array_values($common_issues)) * 100)); ?>%;">
                                            <span><?php echo esc_html($count); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>No issues data available.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="dashboard-row">
                <div class="dashboard-section recommended-packages">
                    <h2>Top Recommended Packages</h2>
                    <?php if (!empty($recommended_packages)) : ?>
                        <div class="recommended-list">
                            <?php foreach ($recommended_packages as $package_id => $count) : 
                                $package = get_post($package_id);
                                if ($package) :
                            ?>
                                <div class="recommended-item">
                                    <div class="package-info">
                                        <h3><?php echo esc_html($package->post_title); ?></h3>
                                        <div class="package-meta">
                                            <?php 
                                            $price = get_post_meta($package_id, 'price', true);
                                            $duration = get_post_meta($package_id, 'duration', true);
                                            if ($price) echo '<span class="price">' . esc_html($price) . '</span>';
                                            if ($duration) echo '<span class="duration">' . esc_html($duration) . '</span>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="recommendation-count">
                                        <span class="count"><?php echo esc_html($count); ?></span>
                                        <span class="label">recommendations</span>
                                    </div>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>No package recommendation data available.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-section analytics">
                    <h2>Assessment Analytics</h2>
                    <div class="analytics-charts">
                        <div class="chart-container">
                            <h3>Assessments Over Time</h3>
                            <div id="assessments-chart"></div>
                        </div>
                        <div class="chart-container">
                            <h3>Primary Issues Distribution</h3>
                            <div id="issues-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-section import-export">
                <h2>Import / Export</h2>
                <div class="import-export-controls">
                    <div class="export-section">
                        <h3>Export Assessment Data</h3>
                        <p>Download assessment data for analysis or backup.</p>
                        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                            <input type="hidden" name="action" value="gdkc_export_assessments">
                            <?php wp_nonce_field('gdkc_export_assessments_nonce', 'gdkc_export_nonce'); ?>
                            <button type="submit" class="button button-primary">Export CSV</button>
                        </form>
                    </div>
                    
                    <div class="report-section">
                        <h3>Generate Reports</h3>
                        <p>Create reports for specific time periods.</p>
                        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                            <input type="hidden" name="action" value="gdkc_generate_assessment_report">
                            <?php wp_nonce_field('gdkc_generate_report_nonce', 'gdkc_report_nonce'); ?>
                            <select name="report_period" required>
                                <option value="7days">Last 7 Days</option>
                                <option value="30days">Last 30 Days</option>
                                <option value="90days">Last 90 Days</option>
                                <option value="year">This Year</option>
                                <option value="all">All Time</option>
                            </select>
                            <button type="submit" class="button button-primary">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .assessment-dashboard {
            margin-top: 20px;
        }
        
        .dashboard-section {
            background-color: #fff;
            border: 1px solid #e2e4e7;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .dashboard-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .dashboard-row .dashboard-section {
            flex: 1;
            margin-bottom: 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .stat-card {
            background-color: #f9f9f9;
            border-radius: 4px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c2977;
        }
        
        .issue-list {
            margin-top: 15px;
        }
        
        .issue-item {
            margin-bottom: 10px;
        }
        
        .issue-name {
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .issue-bar {
            background-color: #f0f0f0;
            border-radius: 4px;
            height: 20px;
            overflow: hidden;
        }
        
        .issue-bar-fill {
            background-color: #07edbe;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 8px;
            color: #2c2977;
            font-weight: 600;
            font-size: 12px;
            transition: width 0.5s ease;
        }
        
        .recommended-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .recommended-item:last-child {
            border-bottom: none;
        }
        
        .package-info h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        
        .package-meta {
            color: #666;
            font-size: 13px;
        }
        
        .package-meta span {
            margin-right: 10px;
        }
        
        .recommendation-count {
            background-color: #f9f9ff;
            padding: 8px 15px;
            border-radius: 30px;
            text-align: center;
        }
        
        .recommendation-count .count {
            font-weight: bold;
            color: #2c2977;
            font-size: 18px;
            display: block;
        }
        
        .recommendation-count .label {
            font-size: 12px;
            color: #666;
        }
        
        .view-all-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .import-export-controls {
            display: flex;
            gap: 30px;
        }
        
        .export-section, .report-section {
            flex: 1;
        }
        
        .import-export-controls h3 {
            margin-top: 0;
        }
        
        .chart-container {
            height: 250px;
            margin-bottom: 20px;
        }
        
        #assessments-chart, #issues-chart {
            width: 100%;
            height: 100%;
        }
        
        @media screen and (max-width: 782px) {
            .dashboard-row {
                flex-direction: column;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .import-export-controls {
                flex-direction: column;
            }
        }
    </style>
    
    <!-- Chart.js for analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Assessments over time chart
        var assessmentsCtx = document.getElementById('assessments-chart').getContext('2d');
        var assessmentsData = <?php echo json_encode(gdkc_get_assessment_timeline_data()); ?>;
        
        new Chart(assessmentsCtx, {
            type: 'line',
            data: {
                labels: assessmentsData.labels,
                datasets: [{
                    label: 'Assessments',
                    data: assessmentsData.values,
                    backgroundColor: 'rgba(44, 41, 119, 0.1)',
                    borderColor: '#2c2977',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Issues distribution chart
        var issuesCtx = document.getElementById('issues-chart').getContext('2d');
        var issuesData = <?php echo json_encode(gdkc_get_issues_chart_data()); ?>;
        
        new Chart(issuesCtx, {
            type: 'doughnut',
            data: {
                labels: issuesData.labels,
                datasets: [{
                    data: issuesData.values,
                    backgroundColor: [
                        '#2c2977',
                        '#07edbe',
                        '#5f75ed',
                        '#ff6b6b',
                        '#ffd166',
                        '#06d6ac',
                        '#383587'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
    </script>
    <?php
}

/**
 * Get most common issues identified in assessments
 */
function gdkc_get_most_common_issues() {
    $issues_count = [];
    
    // Get all assessments
    $assessments = get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
    ]);
    
    foreach ($assessments as $assessment) {
        $analysis = get_post_meta($assessment->ID, 'analysis_results', true);
        
        if (isset($analysis['primary_issues']) && is_array($analysis['primary_issues'])) {
            foreach ($analysis['primary_issues'] as $issue) {
                if (!isset($issues_count[$issue])) {
                    $issues_count[$issue] = 0;
                }
                $issues_count[$issue]++;
            }
        }
        
        if (isset($analysis['secondary_issues']) && is_array($analysis['secondary_issues'])) {
            foreach ($analysis['secondary_issues'] as $issue) {
                if (!isset($issues_count[$issue])) {
                    $issues_count[$issue] = 0;
                }
                $issues_count[$issue]++;
            }
        }
    }
    
    // Sort by count (descending)
    arsort($issues_count);
    
    // Get top 5 issues
    return array_slice($issues_count, 0, 5);
}

/**
 * Get most recommended packages
 */
function gdkc_get_most_recommended_packages() {
    $package_count = [];
    
    // Get all assessments
    $assessments = get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
    ]);
    
    foreach ($assessments as $assessment) {
        $recommended_packages = get_post_meta($assessment->ID, 'recommended_packages', true);
        
        if (is_array($recommended_packages)) {
            foreach ($recommended_packages as $package_id => $score) {
                if (!isset($package_count[$package_id])) {
                    $package_count[$package_id] = 0;
                }
                $package_count[$package_id]++;
            }
        }
    }
    
    // Sort by count (descending)
    arsort($package_count);
    
    // Get top 5 packages
    return array_slice($package_count, 0, 5);
}

/**
 * Get assessment conversion rate
 * 
 * Calculates the percentage of assessments that led to bookings
 */
function gdkc_get_assessment_conversion_rate() {
    // This is a placeholder - in a real implementation, you would track
    // which assessments led to bookings and calculate the percentage
    return 34; // Example: 34%
}

/**
 * Get number of assessments that need follow-up
 */
function gdkc_get_pending_followups() {
    // This is a placeholder - in a real implementation, you would query
    // assessments that have been flagged as needing follow-up
    return 5; // Example: 5 pending follow-ups
}

/**
 * Get assessment timeline data for chart
 */
function gdkc_get_assessment_timeline_data() {
    $dates = [];
    $counts = [];
    
    // Get the past 12 weeks
    for ($i = 11; $i >= 0; $i--) {
        $week_start = date('Y-m-d', strtotime("-$i weeks"));
        $week_end = date('Y-m-d', strtotime("-".($i-1)." weeks -1 day"));
        
        $count = count(get_posts([
            'post_type' => 'gdkc_assessment',
            'posts_per_page' => -1,
            'post_status' => 'private',
            'date_query' => [
                [
                    'after' => $week_start,
                    'before' => $week_end,
                    'inclusive' => true,
                ]
            ]
        ]));
        
        $dates[] = date('M j', strtotime($week_start));
        $counts[] = $count;
    }
    
    return [
        'labels' => $dates,
        'values' => $counts,
    ];
}

/**
 * Get issues distribution data for chart
 */
function gdkc_get_issues_chart_data() {
    $issues_count = [];
    
    // Get all assessments
    $assessments = get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
    ]);
    
    foreach ($assessments as $assessment) {
        $analysis = get_post_meta($assessment->ID, 'analysis_results', true);
        
        if (isset($analysis['primary_issues']) && is_array($analysis['primary_issues'])) {
            foreach ($analysis['primary_issues'] as $issue) {
                if (!isset($issues_count[$issue])) {
                    $issues_count[$issue] = 0;
                }
                $issues_count[$issue]++;
            }
        }
    }
    
    // Sort by count (descending)
    arsort($issues_count);
    
    // Get top 7 issues
    $top_issues = array_slice($issues_count, 0, 7);
    
    return [
        'labels' => array_keys($top_issues),
        'values' => array_values($top_issues),
    ];
}

/**
 * Handle assessment export
 */
function gdkc_handle_assessment_export() {
    if (!isset($_POST['gdkc_export_nonce']) || !wp_verify_nonce($_POST['gdkc_export_nonce'], 'gdkc_export_assessments_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    // Get all assessments
    $assessments = get_posts([
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
    
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="dog-assessments-' . date('Y-m-d') . '.csv"');
    
    // Create output stream
    $output = fopen('php://output', 'w');
    
    // CSV header row
    fputcsv($output, [
        'Date',
        'Owner Name',
        'Email',
        'Phone',
        'Dog Name',
        'Dog Breed',
        'Dog Age',
        'Primary Issues',
        'Secondary Issues',
        'Program Type',
        'Recommended Focus',
        'Notes',
    ]);
    
    // CSV data rows
    foreach ($assessments as $assessment) {
        $owner_name = get_post_meta($assessment->ID, 'owner_name', true);
        $dog_name = get_post_meta($assessment->ID, 'dog_name', true);
        $dog_breed = get_post_meta($assessment->ID, 'dog_breed', true);
        $dog_age = get_post_meta($assessment->ID, 'dog_age', true);
        $email = get_post_meta($assessment->ID, 'email', true);
        $phone = get_post_meta($assessment->ID, 'phone', true);
        
        $analysis = get_post_meta($assessment->ID, 'analysis_results', true);
        
        $primary_issues = isset($analysis['primary_issues']) ? implode(', ', $analysis['primary_issues']) : '';
        $secondary_issues = isset($analysis['secondary_issues']) ? implode(', ', $analysis['secondary_issues']) : '';
        $program_type = isset($analysis['program_type']) ? $analysis['program_type'] : '';
        $recommended_focus = isset($analysis['recommended_focus']) ? implode(', ', $analysis['recommended_focus']) : '';
        $notes = isset($analysis['notes']) ? $analysis['notes'] : '';
        
        fputcsv($output, [
            get_the_date('Y-m-d', $assessment->ID),
            $owner_name,
            $email,
            $phone,
            $dog_name,
            $dog_breed,
            $dog_age,
            $primary_issues,
            $secondary_issues,
            $program_type,
            $recommended_focus,
            $notes,
        ]);
    }
    
    fclose($output);
    exit;
}
add_action('admin_post_gdkc_export_assessments', 'gdkc_handle_assessment_export');

/**
 * Generate assessment report
 */
function gdkc_generate_assessment_report() {
    if (!isset($_POST['gdkc_report_nonce']) || !wp_verify_nonce($_POST['gdkc_report_nonce'], 'gdkc_generate_report_nonce')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    $period = isset($_POST['report_period']) ? sanitize_text_field($_POST['report_period']) : '30days';
    
    // Set up date query based on period
    $date_query = [];
    switch ($period) {
        case '7days':
            $date_query = [['after' => '1 week ago']];
            $period_label = 'Last 7 Days';
            break;
        case '30days':
            $date_query = [['after' => '1 month ago']];
            $period_label = 'Last 30 Days';
            break;
        case '90days':
            $date_query = [['after' => '3 months ago']];
            $period_label = 'Last 90 Days';
            break;
        case 'year':
            $date_query = [
                [
                    'year' => date('Y'),
                ]
            ];
            $period_label = 'This Year';
            break;
        case 'all':
            $date_query = [];
            $period_label = 'All Time';
            break;
    }
    
    // Get assessments for the selected period
    $args = [
        'post_type' => 'gdkc_assessment',
        'posts_per_page' => -1,
        'post_status' => 'private',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    if (!empty($date_query)) {
        $args['date_query'] = $date_query;
    }
    
    $assessments = get_posts($args);
    
    // Generate report data
    $total_assessments = count($assessments);
    $issues_data = [];
    $program_types = [];
    
    foreach ($assessments as $assessment) {
        $analysis = get_post_meta($assessment->ID, 'analysis_results', true);
        
        // Collect primary issues
        if (isset($analysis['primary_issues']) && is_array($analysis['primary_issues'])) {
            foreach ($analysis['primary_issues'] as $issue) {
                if (!isset($issues_data[$issue])) {
                    $issues_data[$issue] = 0;
                }
                $issues_data[$issue]++;
            }
        }
        
        // Collect program types
        if (isset($analysis['program_type'])) {
            $program_type = $analysis['program_type'];
            if (!isset($program_types[$program_type])) {
                $program_types[$program_type] = 0;
            }
            $program_types[$program_type]++;
        }
    }
    
    // Sort data by count
    arsort($issues_data);
    arsort($program_types);
    
    // Set headers for PDF report
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="assessment-report-' . date('Y-m-d') . '.pdf"');
    
    // Generate PDF (requires a PDF library like TCPDF or FPDF)
    // For this example, we'll just redirect back to the dashboard
    // In a real implementation, you would generate a PDF report here
    
    // Redirect back to dashboard with success message
    wp_redirect(admin_url('edit.php?post_type=gdkc_assessment&page=gdkc-assessment-dashboard&report_generated=1'));
    exit;
}
add_action('admin_post_gdkc_generate_assessment_report', 'gdkc_generate_assessment_report');

/**
 * Add custom meta boxes to the assessment post type
 */
function gdkc_add_assessment_meta_boxes() {
    add_meta_box(
        'gdkc_assessment_details',
        'Assessment Details',
        'gdkc_assessment_details_meta_box',
        'gdkc_assessment',
        'normal',
        'high'
    );
    
    add_meta_box(
        'gdkc_assessment_results',
        'Assessment Results',
        'gdkc_assessment_results_meta_box',
        'gdkc_assessment',
        'normal',
        'high'
    );
    
    add_meta_box(
        'gdkc_assessment_followup',
        'Follow-up Status',
        'gdkc_assessment_followup_meta_box',
        'gdkc_assessment',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'gdkc_add_assessment_meta_boxes');

/**
 * Render the assessment details meta box
 */
function gdkc_assessment_details_meta_box($post) {
    // Get assessment data
    $owner_name = get_post_meta($post->ID, 'owner_name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $dog_name = get_post_meta($post->ID, 'dog_name', true);
    $dog_breed = get_post_meta($post->ID, 'dog_breed', true);
    $dog_age = get_post_meta($post->ID, 'dog_age', true);
    $dog_gender = get_post_meta($post->ID, 'dog_gender', true);
    $dog_size = get_post_meta($post->ID, 'dog_size', true);
    $behavior_issues = get_post_meta($post->ID, 'behavior_issues', true);
    $training_history = get_post_meta($post->ID, 'training_history', true);
    $socialization = get_post_meta($post->ID, 'socialization', true);
    $training_goals = get_post_meta($post->ID, 'training_goals', true);
    $additional_notes = get_post_meta($post->ID, 'additional_notes', true);
    
    ?>
    <style>
        .assessment-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .detail-section {
            margin-bottom: 20px;
        }
        
        .detail-section h3 {
            margin-top: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .detail-field {
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
        }
        
        .detail-value {
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 4px;
        }
        
        .behavior-issues-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .behavior-issue-tag {
            background-color: #f0f0ff;
            color: #2c2977;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
        }
        
        .training-goals-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .training-goal-tag {
            background-color: #f0fff8;
            color: #07edbe;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
        }
    </style>
    
    <div class="assessment-details">
        <div class="detail-section owner-details">
            <h3>Owner Information</h3>
            
            <div class="detail-field">
                <span class="detail-label">Name:</span>
                <div class="detail-value"><?php echo esc_html($owner_name); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Email:</span>
                <div class="detail-value"><?php echo esc_html($email); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Phone:</span>
                <div class="detail-value"><?php echo esc_html($phone); ?></div>
            </div>
        </div>
        
        <div class="detail-section dog-details">
            <h3>Dog Information</h3>
            
            <div class="detail-field">
                <span class="detail-label">Name:</span>
                <div class="detail-value"><?php echo esc_html($dog_name); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Breed:</span>
                <div class="detail-value"><?php echo esc_html($dog_breed); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Age:</span>
                <div class="detail-value"><?php echo esc_html($dog_age); ?> years</div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Gender:</span>
                <div class="detail-value"><?php echo esc_html($dog_gender); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Size:</span>
                <div class="detail-value"><?php echo esc_html($dog_size); ?></div>
            </div>
        </div>
        
        <div class="detail-section behavior-details">
            <h3>Behavior & Training</h3>
            
            <div class="detail-field">
                <span class="detail-label">Behavior Issues:</span>
                <div class="detail-value behavior-issues-list">
                    <?php 
                    if (is_array($behavior_issues)) :
                        foreach ($behavior_issues as $issue) :
                    ?>
                        <span class="behavior-issue-tag"><?php echo esc_html($issue); ?></span>
                    <?php 
                        endforeach;
                    else :
                        echo esc_html($behavior_issues);
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Training History:</span>
                <div class="detail-value"><?php echo esc_html($training_history); ?></div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Socialization:</span>
                <div class="detail-value"><?php echo esc_html($socialization); ?></div>
            </div>
        </div>
        
        <div class="detail-section goals-notes">
            <h3>Goals & Notes</h3>
            
            <div class="detail-field">
                <span class="detail-label">Training Goals:</span>
                <div class="detail-value training-goals-list">
                    <?php 
                    if (is_array($training_goals)) :
                        foreach ($training_goals as $goal) :
                    ?>
                        <span class="training-goal-tag"><?php echo esc_html($goal); ?></span>
                    <?php 
                        endforeach;
                    else :
                        echo esc_html($training_goals);
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="detail-field">
                <span class="detail-label">Additional Notes:</span>
                <div class="detail-value"><?php echo esc_html($additional_notes); ?></div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render the assessment results meta box
 */
function gdkc_assessment_results_meta_box($post) {
    // Get assessment analysis results
    $analysis_results = get_post_meta($post->ID, 'analysis_results', true);
    $recommended_packages = get_post_meta($post->ID, 'recommended_packages', true);
    
    if (!$analysis_results) {
        echo '<p>No analysis results available.</p>';
        return;
    }
    
    ?>
    <style>
        .assessment-results {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .result-section {
            margin-bottom: 20px;
        }
        
        .result-section h3 {
            margin-top: 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .result-field {
            margin-bottom: 10px;
        }
        
        .result-label {
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
        }
        
        .result-value {
            background-color: #f9f9f9;
            padding: 8px;
            border-radius: 4px;
        }
        
        .issues-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .issue-tag {
            background-color: #f0f0ff;
            color: #2c2977;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
        }
        
        .primary-issue-tag {
            background-color: #ff6b6b;
            color: white;
        }
        
        .focus-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .focus-tag {
            background-color: #f0fff8;
            color: #07edbe;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 13px;
        }
        
        .program-type {
            font-weight: 600;
            font-size: 16px;
            color: #2c2977;
            margin-bottom: 10px;
        }
        
        .recommended-packages-list {
            margin-top: 15px;
        }
        
        .package-card {
            background-color: #f9f9ff;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #2c2977;
        }
        
        .package-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 15px;
        }
        
        .package-meta {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .package-meta span {
            margin-right: 10px;
        }
        
        .package-score {
            font-size: 13px;
            color: #2c2977;
        }
    </style>
    
    <div class="assessment-results">
        <div class="result-section analysis-summary">
            <h3>Analysis Summary</h3>
            
            <?php if (isset($analysis_results['program_type'])) : ?>
                <div class="program-type">
                    Recommended Program Type: <?php echo esc_html($analysis_results['program_type']); ?>
                </div>
            <?php endif; ?>
            
            <div class="result-field">
                <span class="result-label">Primary Issues:</span>
                <div class="result-value issues-list">
                    <?php 
                    if (isset($analysis_results['primary_issues']) && is_array($analysis_results['primary_issues'])) :
                        foreach ($analysis_results['primary_issues'] as $issue) :
                    ?>
                        <span class="issue-tag primary-issue-tag"><?php echo esc_html($issue); ?></span>
                    <?php 
                        endforeach;
                    else :
                        echo '<p>None identified</p>';
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="result-field">
                <span class="result-label">Secondary Issues:</span>
                <div class="result-value issues-list">
                    <?php 
                    if (isset($analysis_results['secondary_issues']) && is_array($analysis_results['secondary_issues'])) :
                        foreach ($analysis_results['secondary_issues'] as $issue) :
                    ?>
                        <span class="issue-tag"><?php echo esc_html($issue); ?></span>
                    <?php 
                        endforeach;
                    else :
                        echo '<p>None identified</p>';
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="result-field">
                <span class="result-label">Recommended Focus Areas:</span>
                <div class="result-value focus-list">
                    <?php 
                    if (isset($analysis_results['recommended_focus']) && is_array($analysis_results['recommended_focus'])) :
                        foreach ($analysis_results['recommended_focus'] as $focus) :
                    ?>
                        <span class="focus-tag"><?php echo esc_html($focus); ?></span>
                    <?php 
                        endforeach;
                    else :
                        echo '<p>None identified</p>';
                    endif;
                    ?>
                </div>
            </div>
            
            <?php if (isset($analysis_results['notes']) && !empty($analysis_results['notes'])) : ?>
                <div class="result-field">
                    <span class="result-label">Notes:</span>
                    <div class="result-value">
                        <?php echo esc_html($analysis_results['notes']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="result-section recommended-packages">
            <h3>Recommended Packages</h3>
            
            <?php if (is_array($recommended_packages) && !empty($recommended_packages)) : ?>
                <div class="recommended-packages-list">
                    <?php 
                    foreach ($recommended_packages as $package_id => $score) :
                        $package = get_post($package_id);
                        if ($package) :
                            $price = get_post_meta($package_id, 'price', true);
                            $duration = get_post_meta($package_id, 'duration', true);
                    ?>
                        <div class="package-card">
                            <div class="package-title"><?php echo esc_html($package->post_title); ?></div>
                            <div class="package-meta">
                                <?php if ($price) : ?>
                                    <span class="package-price"><?php echo esc_html($price); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($duration) : ?>
                                    <span class="package-duration"><?php echo esc_html($duration); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="package-score">Match score: <?php echo esc_html($score); ?></div>
                            <a href="<?php echo get_edit_post_link($package_id); ?>" class="button button-small">View Package</a>
                        </div>
                    <?php 
                        endif;
                    endforeach;
                    ?>
                </div>
            <?php else : ?>
                <p>No packages recommended.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render the follow-up meta box
 */
function gdkc_assessment_followup_meta_box($post) {
    // Get follow-up status
    $followup_status = get_post_meta($post->ID, 'followup_status', true) ?: 'pending';
    $followup_date = get_post_meta($post->ID, 'followup_date', true);
    $followup_notes = get_post_meta($post->ID, 'followup_notes', true);
    
    wp_nonce_field('gdkc_assessment_followup_nonce', 'gdkc_followup_nonce');
    
    ?>
    <p>
        <label for="followup_status">Status:</label>
        <select name="followup_status" id="followup_status" style="width: 100%;">
            <option value="pending" <?php selected($followup_status, 'pending'); ?>>Pending</option>
            <option value="contacted" <?php selected($followup_status, 'contacted'); ?>>Contacted</option>
            <option value="booked" <?php selected($followup_status, 'booked'); ?>>Booked</option>
            <option value="no_response" <?php selected($followup_status, 'no_response'); ?>>No Response</option>
            <option value="not_interested" <?php selected($followup_status, 'not_interested'); ?>>Not Interested</option>
        </select>
    </p>
    
    <p>
        <label for="followup_date">Follow-up Date:</label>
        <input type="date" name="followup_date" id="followup_date" value="<?php echo esc_attr($followup_date); ?>" style="width: 100%;">
    </p>
    
    <p>
        <label for="followup_notes">Notes:</label>
        <textarea name="followup_notes" id="followup_notes" rows="4" style="width: 100%;"><?php echo esc_textarea($followup_notes); ?></textarea>
    </p>
    <?php
}

/**
 * Save the assessment follow-up data
 */
function gdkc_save_assessment_followup($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['gdkc_followup_nonce']) || !wp_verify_nonce($_POST['gdkc_followup_nonce'], 'gdkc_assessment_followup_nonce')) {
        return;
    }
    
    // Check if we're doing an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save follow-up data
    if (isset($_POST['followup_status'])) {
        update_post_meta($post_id, 'followup_status', sanitize_text_field($_POST['followup_status']));
    }
    
    if (isset($_POST['followup_date'])) {
        update_post_meta($post_id, 'followup_date', sanitize_text_field($_POST['followup_date']));
    }
    
    if (isset($_POST['followup_notes'])) {
        update_post_meta($post_id, 'followup_notes', sanitize_textarea_field($_POST['followup_notes']));
    }
}
add_action('save_post_gdkc_assessment', 'gdkc_save_assessment_followup');

/**
 * Add custom columns to the assessments list table
 */
function gdkc_add_assessment_columns($columns) {
    $new_columns = array();
    
    // Insert columns after title
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        if ($key === 'title') {
            $new_columns['owner_name'] = 'Owner';
            $new_columns['dog_info'] = 'Dog Info';
            $new_columns['program_type'] = 'Program Type';
            $new_columns['followup_status'] = 'Follow-up Status';
        }
    }
    
    return $new_columns;
}
add_filter('manage_gdkc_assessment_posts_columns', 'gdkc_add_assessment_columns');

/**
 * Display custom column content
 */
function gdkc_assessment_custom_column($column, $post_id) {
    switch ($column) {
        case 'owner_name':
            $owner_name = get_post_meta($post_id, 'owner_name', true);
            $email = get_post_meta($post_id, 'email', true);
            
            echo esc_html($owner_name);
            if ($email) {
                echo '<br><small>' . esc_html($email) . '</small>';
            }
            break;
            
        case 'dog_info':
            $dog_name = get_post_meta($post_id, 'dog_name', true);
            $dog_breed = get_post_meta($post_id, 'dog_breed', true);
            
            echo esc_html($dog_name);
            if ($dog_breed) {
                echo ' (' . esc_html($dog_breed) . ')';
            }
            break;
            
        case 'program_type':
            $analysis = get_post_meta($post_id, 'analysis_results', true);
            $program_type = isset($analysis['program_type']) ? $analysis['program_type'] : 'N/A';
            
            echo esc_html($program_type);
            break;
            
        case 'followup_status':
            $followup_status = get_post_meta($post_id, 'followup_status', true) ?: 'pending';
            $status_labels = [
                'pending' => 'Pending',
                'contacted' => 'Contacted',
                'booked' => 'Booked',
                'no_response' => 'No Response',
                'not_interested' => 'Not Interested',
            ];
            
            $status_colors = [
                'pending' => '#f0ad4e',
                'contacted' => '#5bc0de',
                'booked' => '#5cb85c',
                'no_response' => '#d9534f',
                'not_interested' => '#777',
            ];
            
            $status_label = isset($status_labels[$followup_status]) ? $status_labels[$followup_status] : 'Unknown';
            $status_color = isset($status_colors[$followup_status]) ? $status_colors[$followup_status] : '#777';
            
            echo '<span style="display: inline-block; padding: 3px 8px; border-radius: 15px; background-color: ' . esc_attr($status_color) . '; color: white; font-size: 12px;">' . esc_html($status_label) . '</span>';
            break;
    }
}
add_action('manage_gdkc_assessment_posts_custom_column', 'gdkc_assessment_custom_column', 10, 2);

/**
 * Make custom columns sortable
 */
function gdkc_assessment_sortable_columns($columns) {
    $columns['owner_name'] = 'owner_name';
    $columns['followup_status'] = 'followup_status';
    return $columns;
}
add_filter('manage_edit-gdkc_assessment_sortable_columns', 'gdkc_assessment_sortable_columns');

/**
 * Add custom filters to the assessments list table
 */
function gdkc_assessment_filters() {
    global $typenow;
    
    if ($typenow === 'gdkc_assessment') {
        // Follow-up status filter
        $followup_status = isset($_GET['followup_status']) ? sanitize_text_field($_GET['followup_status']) : '';
        
        ?>
        <select name="followup_status">
            <option value="">All Follow-up Statuses</option>
            <option value="pending" <?php selected($followup_status, 'pending'); ?>>Pending</option>
            <option value="contacted" <?php selected($followup_status, 'contacted'); ?>>Contacted</option>
            <option value="booked" <?php selected($followup_status, 'booked'); ?>>Booked</option>
            <option value="no_response" <?php selected($followup_status, 'no_response'); ?>>No Response</option>
            <option value="not_interested" <?php selected($followup_status, 'not_interested'); ?>>Not Interested</option>
        </select>
        <?php
        
        // Program type filter
        $program_type = isset($_GET['program_type']) ? sanitize_text_field($_GET['program_type']) : '';
        $program_types = ['Basic Obedience', 'Behavioral Training', 'Anxiety Management', 'Behavioral Rehabilitation', 'Socialization Focus', 'General Obedience'];
        
        ?>
        <select name="program_type">
            <option value="">All Program Types</option>
            <?php foreach ($program_types as $type) : ?>
                <option value="<?php echo esc_attr($type); ?>" <?php selected($program_type, $type); ?>>
                    <?php echo esc_html($type); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
        
        // Needs follow-up filter
        $needs_followup = isset($_GET['needs_followup']) ? intval($_GET['needs_followup']) : 0;
        
        ?>
        <label for="needs_followup">
            <input type="checkbox" id="needs_followup" name="needs_followup" value="1" <?php checked($needs_followup, 1); ?>>
            Needs Follow-up
        </label>
        <?php
    }
}
add_action('restrict_manage_posts', 'gdkc_assessment_filters');

/**
 * Modify query to apply custom filters
 */
function gdkc_assessment_filter_query($query) {
    global $pagenow, $typenow;
    
    if ($pagenow === 'edit.php' && $typenow === 'gdkc_assessment') {
        // Follow-up status filter
        if (isset($_GET['followup_status']) && !empty($_GET['followup_status'])) {
            $query->query_vars['meta_key'] = 'followup_status';
            $query->query_vars['meta_value'] = sanitize_text_field($_GET['followup_status']);
        }
        
        // Program type filter
        if (isset($_GET['program_type']) && !empty($_GET['program_type'])) {
            $query->query_vars['meta_query'][] = [
                'key' => 'analysis_results',
                'value' => '"program_type";s:' . strlen($_GET['program_type']) . ':"' . sanitize_text_field($_GET['program_type']) . '"',
                'compare' => 'LIKE',
            ];
        }
        
        // Needs follow-up filter
        if (isset($_GET['needs_followup']) && $_GET['needs_followup'] === '1') {
            $query->query_vars['meta_query'][] = [
                'relation' => 'OR',
                [
                    'key' => 'followup_status',
                    'value' => 'pending',
                    'compare' => '=',
                ],
                [
                    'key' => 'followup_status',
                    'compare' => 'NOT EXISTS',
                ],
            ];
        }
    }
}
add_action('pre_get_posts', 'gdkc_assessment_filter_query');